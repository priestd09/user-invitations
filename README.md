# User Invitations

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gocanto/user-invitations.svg?style=flat-square)](https://img.shields.io/packagist/v/gocanto/user-invitations.svg)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/gocanto/user-invitations.svg?style=flat-square)](https://img.shields.io/packagist/dt/gocanto/user-invitations.svg?style=flat-square)

User invitations is a ***laravel*** package, a dummy one actually, thought to control the users invitations in ***laravel* applications. 

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

At this point you must to have your configuration file, as migration, language and views into your main app folder. 


