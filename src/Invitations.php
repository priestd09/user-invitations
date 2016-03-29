<?php

namespace Gocanto\UserInvitations;

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
     * The table associated with the invitation model.
     *
     * @var string
     */
    private static $table = 'invitation_users';

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

        self::$user = request()->user();
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
     * Validate users input data.
     *
     * @param Illuminate\Http\Request $request
     * @param string  &$m
     * @param array $rules
     * @return boolean
     */
    private static function isValid(Request $request, &$m, $rules = [])
    {
        //Creating validation. If there rules were passed in,
        //we use it, otherwise, we keep the default ones.
        $v = \Validator::make($request->all(), count($rules) > 0 ? $rules : [
            'email' => 'required|email|unique:'.self::$table.',guest_email'
        ]);

        //We save the message if there was a validation problem.
        if ($v->fails()) {
            $m = implode(' ', $v->errors()->all());

            return false;
        }

        return true;
    }

    /**
     * Retrieve an invitation from the database.
     *
     * @param  array $data
     * @return \Gocanto\UserInvitations\Models\Invitation $invitation
     */
    public static function getInvitation(array $data)
    {
        return Invitation::select(['id', 'user_id', 'guest_email'])->where([
            'guest_email' => $data['guest_email'],
            'confirmation_token' => $data['confirmation_token'],
            'active' => '0'
        ])->first();
    }

    /**
     * Check for available invitations.
     *
     * @return boolean
     */
    public static function canInvite()
    {
        return self::$user->invitations > 0;
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
        //Checking if the user has invitations remaining.
        if (self::retrieveQuantity() > 0) {

            //Input validations.
            if (self::isValid($request, $m)) {

                //Inserting invitation.
                self::insert($request->get('email'));

                return response()->json([
                    'output' => 'ok'
                ], 200);
            } else {

                //Input validations went wrong.
                return response()->json([
                    'message' => $m,
                    'output' => 'invalid'
                ], 403);
            }
        } else {

            //The user does not have invitations remaining.
            return response()->json([
                'title' => trans('userinvitations.overdraw.title'),
                'message' => trans('userinvitations.overdraw.message'),
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
        //Generating email token to be used in the user
        //signup form.
        $confirmation_token = str_random(50);

        //Creating a new invitation.
        $inv = Invitation::create([
            'user_id' => self::$user->id,
            'guest_email' => $email,
            'active' => '0',
            'confirmation_token' => $confirmation_token
        ]);

        //Decrementing user invitation counter.
        $inv->user()->decrement('invitations');

        //Sending invitation email.
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
        \Mail::queue('vendor.gocanto.invitations.emailBody', $data, function ($m) use ($data) {
            $m->from(config('userinvitations.email.username'), trans('userinvitations.app_name'));
            $m->to($data['guest_email']);
            $m->subject(trans('userinvitations.subject'));
        });
    }
}
