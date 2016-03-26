<?php

namespace Gocanto\UserInvitations;

use Illuminate\Support\ServiceProvider;

class InvitationServiceProvider extends ServiceProvider
{
	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
		/**
		 * Copy the invitation files to the app.
		 */
	    $this->publishes([
	    	__DIR__.'/Lang/en/' => resource_path('lang/en'),
	        __DIR__.'/Views/' => resource_path('views/vendor/gocanto'),
	        __DIR__.'/Config/userinvitations.php' => config_path('userinvitations.php'),
	        __DIR__.'/Migrations/create_invitation_users_table.php' => database_path('migrations/create_invitation_users_table.php')
	    ]);
	}

    /**
     * Register the invitations services.
     *
     * @return void
     */
    public function register()
    {
    	/**
    	 * Binding the invitation facade to the app.
    	 */
    	$this->app->bind('invite', 'Gocanto\UserInvitations\Invitations');
    }
}
