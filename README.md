# User Invitations

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gocanto/user-invitations.svg?style=flat-square)](https://img.shields.io/packagist/v/gocanto/user-invitations.svg)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/gocanto/user-invitations.svg?style=flat-square)](https://img.shields.io/packagist/dt/gocanto/user-invitations.svg?style=flat-square)

User invitations is a ***laravel*** package, a dummy one actually, thought to control the users invitations in ***laravel*** applications. 

Its target is keeping track and under observation users sign up in your app, thinking on those apps that will not have the budget to come out with a big server at first.


## Installation

Begin by installing the package through Composer. Run the following command in your terminal:

```bash
composer require gocanto/user-invitations
```

Once composer is done, add the package service provider in the providers array in `config/app.php`:

```php
Gocanto\UserInvitations\InvitationServiceProvider::class
```

Also, you have the option to add the facade access in the aliases array, as so:

```php
'Invite'  => Gocanto\UserInvitations\Facades\Invite::class
```

Then publish the config file:

```bash
php artisan vendor:publish --provider="Gocanto\UserInvitations\InvitationServiceProvider"
```

At this point you must have your configuration file, as migration, language and views distributed in the app folder. These will be their locations: 

```
* Language > resources/lang/en (translations related to invitations)

* Views > resources/views/vendor/gocanto (email layout and body)

* Config > config/userinvitations.php (here you will find the requirements to feed this package)

* Migrations > database/migrations/create_invitation_users_table.php (invitations tracked out)
```

## Configurations

From the files published throughout the vendor, you will have the access to set all the input information required to have this package running without issues. Also, you will find these files well documented.

```
You have to add a field call "invitations" in your user table, in order to control the invitation remaining.
```

## How it works

You are able to invoke the ***facade accessor*** to retrieve the package controller either to know if the user has remaining invitations, or show invitations counter wherever you want to display the form related to this duty. Examples:

***Flow Controller***

```html
@if (Invite::canInvite())

  /// my html block

@endif
```

***Invitations Counter***

```html
<small class="pull-right">Current: {{ Invite::retrieveQuantity() }}</small>
```

Also, we can indicate the route which will handle the de insertions of new invitations. This is nothing major because ***laravel*** is the one on charge, example: 

```php
Route::post('store', ['as' => 'inv.store', 'uses' => '\Gocanto\UserInvitations\Invitations@store']);
```

After we sent the data to the invitation controller, we will receive the response related to this process. How does that look like?, well check the following example:

```php
* 401 error if the user does not have invitations remaining.

* 403 error if the was a validation issue.

* 200 if everything went smoothly.
```

of course, you are free to use these output as you will. However, I implement an ajax call to handle my scenario.


