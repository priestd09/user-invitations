<?php

namespace Gocanto\UserInvitations\Facades;

use Illuminate\Support\Facades\Facade;

class Invite extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'invite';
    }
}
