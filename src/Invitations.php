<?php

namespace Gocanto\UserInvitations;

use Auth;
use Mail;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gocanto\UserInvitations\Models\Invitation;

class Invitations extends Controller
{
    /**
     * Information of the user in session
     *
     * @var Auth
     */
    private static $user;

    /**
     * Create a new Invitations instance.
     *
     * @param void
     * @return void
     */
    private static function init()
    {
        if (self::$user) {
            return;
        }

        self::$user = Auth::user();
    }

    /**
     * Create a new Invitations instance.
     *
     * @param void
     * @return void
     */
    public function __construct()
    {
        if (! self::$user) {
            self::init();
        }
    }

    /**
     * Check for available invitations.
     *
     * @return boolean
     */
    public static function canInvite()
    {
        return Auth::user()->invitations > 0;
    }

    /**
     * Retrieve available invitations.
     *
     * @return integer
     */
    public static function retrieveQuantity()
    {
        return self::$user->invitations;
    }

    /**
     * Store new invitation.
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public static function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($v->fails()) {
            return response()->json([
                'output' => 'invalid'
            ], 403);
        }

        if (self::retrieveQuantity() > 0) {
            $exist = Invitation::select('id')->where('guest_email', 'like', $request->get('email'))->first();

            if (count($exist) == 0) {
                self::insert($request->get('email'));

                return response()->json([
                    'output' => 'ok'
                ], 200);
            } else {
                return response()->json([
                        'output' => 'duplicated'
                    ], 406);
            }
        } else {
            return response()->json([
                'output' => 'overdraw'
            ], 401);
        }
    }

    /**
     * Process a new invitation.
     *
     * @param  string $email
     * @param  int $id
     * @return void
     */
    private static function insert($email)
    {
        $confirmation_token = str_random(50);

        $inv = Invitation::create([
            'user_id' => self::$user->id,
            'guest_email' => $email,
            'active' => '0',
            'confirmation_token' => $confirmation_token
        ]);

        $inv->user()->decrement('invitations');

        self::sendEmail([
            'user' => [
                'name' => ucfirst($inv->user->name . ' ' .$inv->user->last_name)
            ],
            'guest_email' => $email,
            'confirmation_token' => $confirmation_token
        ]);
    }

    /**
     * Send invitation email.
     *
     * @param  array  $data
     * @return void
     */
    public static function sendEmail(array $data = [])
    {
        Mail::queue('vendor.gocanto.invitations.emailBody', $data, function ($m) use ($data) {
            $m->from(config('userinvitations.email.username'), trans('userinvitations.app_name'));
            $m->to($data['guest_email']);
            $m->subject(trans('userinvitations.subject'));
        });
    }
}
