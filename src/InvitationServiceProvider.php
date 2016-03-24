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
		 * Copy the invitation views to our view vendor app.
		 */
	    $this->publishes([
	        __DIR__.'/Views/' => resource_path('views/vendor/gocanto'),
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
    	 * Bind the invitation facade to our app.
    	 */
    	$this->app->bind('invite', 'Gocanto\UserInvitations\Invitations');
    }
}
