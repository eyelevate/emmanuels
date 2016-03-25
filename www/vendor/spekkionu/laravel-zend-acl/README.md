Laravel Zend Acl
================

[![Latest Stable Version](https://poser.pugx.org/spekkionu/laravel-zend-acl/v/stable.png)](https://packagist.org/packages/spekkionu/laravel-zend-acl)
[![Total Downloads](https://poser.pugx.org/spekkionu/laravel-zend-acl/downloads.png)](https://packagist.org/packages/spekkionu/laravel-zend-acl)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/spekkionu/laravel-zend-acl/badges/quality-score.png?s=40c132d7e25a2856b833195b3e881463c04e07d9)](https://scrutinizer-ci.com/g/spekkionu/laravel-zend-acl/)
[![Code Coverage](https://scrutinizer-ci.com/g/spekkionu/laravel-zend-acl/badges/coverage.png?s=cac2d309c0f9a54c75efc182ab3ba03e16605b1b)](https://scrutinizer-ci.com/g/spekkionu/laravel-zend-acl/)


Adds ACL to Laravel 4 via Zend\Permissions\Acl component.

Most of the ACL solutions for Laravel 4 store the permissions rules in the database or other persistance layer.
This is great if access is dynamic but for applications with set permissions by roles this makes modification more difficult.
Adding new resources, permissions, or roles requires runnning db queries via a migration or other means.
With this package the permissions are stored in code and thus in version control (hopefully).

Rather than reinvent the wheel this package makes use of the Acl package from Zend Framework.
Documentation for the Zend\Permissions\Acl can be found at http://framework.zend.com/manual/2.2/en/modules/zend.permissions.acl.intro.html

## Installation

Add the following line to the `require` section of `composer.json`:

```json
{
    "require": {
        "spekkionu/laravel-zend-acl": "dev-master"
    }
}
```
## Setup

1. Add `'Spekkionu\ZendAcl\ZendAclServiceProvider',` to the service provider list in `app/config/app.php`.
2. Add `'Acl' => 'Spekkionu\ZendAcl\Facades\Acl',` to the list of aliases in `app/config/app.php`.

## Usage

The Zend\Permissions\Acl is available through the Facade Acl or through the acl service in the IOC container.

### Adding a Resource

You can add a new resource using the addResource method.

```php
<?php
// Add using string shortcut
Acl::addResource('page');
// Add using instance of the Resource class
Acl::addResource(new \Zend\Permissions\Acl\Resource\GenericResource('someResource'));
?>
```

### Adding a Role

You can add a new resource using the addRole method.

```php
<?php
// Add using string shortcut
Acl::addRole('admin');
// Add using instance of the Role class
Acl::addRole(new \Zend\Permissions\Acl\Role\GenericRole('member'));
?>
```

### Adding / Removing Permissions

You can add permissions using the allow method.

```php
<?php
// Add page resource
Acl::addResource('page');
// Add admin role
Acl::addRole('admin');
// Add guest role
Acl::addRole('guest');
// Give admin role add, edit, delete, and view permissions for page resource
Acl::allow('admin', 'page', array('add', 'edit', 'delete', 'view'));
// Give guest role only view permissions for page resource
Acl::allow('guest', 'page', 'view');
?>
```
You can remove permissions using the deny method.

```php
<?php
// Add page resource
Acl::addResource('page');
// Add admin role
Acl::addRole('admin');
// Give admin role add, edit, delete, and view permissions for page resource
Acl::allow('admin', 'page', array('add', 'edit', 'delete', 'view'));
// Add staff role that inheirits from admin
Acl::addRole('staff', 'admin');
// Deny access for staff role the delete permission on the page resource
Acl::deny('staff', 'page', 'delete');
?>
```
### Checking for permissions

You can check for access using the isAllowed method

Given the following permissions:

```php
<?php
// Add page resource
Acl::addResource('page');
// Add admin role
Acl::addRole('admin');
// Add guest role
Acl::addRole('guest');
// Give admin role add, edit, delete, and view permissions for page resource
Acl::allow('admin', 'page', array('add', 'edit', 'delete', 'view'));
// Give guest role only view permissions for page resource
Acl::allow('guest', 'page', 'view');
?>
```

```php
<?php
// Check if admin can add page
// Should return true
$allowed = Acl::isAllowed('admin', 'page', 'add');

// Check if admin can delete page
// Should return true
$allowed = Acl::isAllowed('admin', 'page', 'delete');

// Check if guest can edit page
// Should return false
$allowed = Acl::isAllowed('guest', 'page', 'edit');

// Check if guest can view page
// Should return true
$allowed = Acl::isAllowed('guest', 'page', 'view');
?>
```

## Where to put ACL definitions

You can put the ACL definitions anywhere that has access to the IOC container but this is where I prefer to have them.

### Add the following code to the end app/start/global.php

```php
/*
|--------------------------------------------------------------------------
| Require The ACL File
|--------------------------------------------------------------------------
|
| Load the ACL configuration file.
| This contains the roles and permissions needed for the application.
|
*/

require app_path().'/acl.php';
```

### Create app/acl.php with the following content

```php
<?php

/*
|--------------------------------------------------------------------------
| ACL Resources, Roles, and Permissions
|--------------------------------------------------------------------------
|
| Below you may add resources and roles and define the permissions
| roles have on those resources.
|
*/

// Add Resources


// Add Roles


// Give roles permissions on resources

```

Add the resources, roles, and permissions required for your application.

## Checking permissions for a user

In order to check permissions for a logged in user the user needs to have a field that stores the user's role.
If using an Eloquent user model have the user model implement Zend\Permissions\Acl\Role\RoleInterface.
This interface has one method getRoleId() that should return the role for the user.

### Example Model

Say there is a table `users` that has a field `role`
The following model will allow an instance of the User model to be passed to the isAllowed() method.
```php
<?php
use Eloquent;
use Zend\Permissions\Acl\Role\RoleInterface;

class User extends Eloquent implements RoleInterface
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * Returns role of the user
     * @return string
     */
    public function getRoleId()
    {
        return $this->role;
    }
}

```
### Using the user model to check permissions

```php
<?php

// Checking if a user has permissions to view an article
$user = User::find(1);
Acl::isAllowed($user, 'article', 'view');

// Checking if the currently logged in user has permissions to edit a blog post
Acl::isAllowed(Auth::user(), 'post', 'edit');
```
