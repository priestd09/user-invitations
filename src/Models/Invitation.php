<?php

namespace Gocanto\UserInvitations\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invitation_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'user_id',
        'guest_email',
        'confirmation_token'
    ];

    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
