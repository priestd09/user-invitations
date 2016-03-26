<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id'); //the user who is sending the invitation
            $table->string('guest_email', 100); //the receiver
            $table->char('active'); //flag to know if the user invited is active in the app
            $table->string('confirmation_token', 100); //email confirmation token
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invitation_users');
    }
}
