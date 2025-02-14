# MainCardPolicy Class Documentation

## Namespace
```php
namespace Sq\Employee\Policies;
```

## Imports
```php
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;
use Sq\Employee\Models\MainCard;
use Sq\Query\Policy\UserDepartment;
```

## Class Definition
```php
class MainCardPolicy
{
    // ...existing code...
}
```

## Methods

### viewAny
```php
public function viewAny(User $user): bool
{
    return $user->hasPermissionTo(PermissionTranslation::viewAny("Main Card"));
}
```
Determines whether the user can view any models.

### view
```php
public function view(User $user, MainCard $mainCard): bool
{
    return $user->hasPermissionTo(PermissionTranslation::view("Main Card")) 
        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment());
}
```
Determines whether the user can view the model.

### create
```php
public function create(User $user): bool
{
    return $user->hasPermissionTo(PermissionTranslation::create("Main Card"));
}
```
Determines whether the user can create models.

### update
```php
public function update(User $user, MainCard $mainCard): bool
{
    return $user->hasPermissionTo(PermissionTranslation::update("Main Card")) 
        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment());
}
```
Determines whether the user can update the model.

### delete
```php
public function delete(User $user, MainCard $mainCard): bool
{
    return $user->hasPermissionTo(PermissionTranslation::delete("Main Card")) 
        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment()) 
        && (!$mainCard->printed);
}
```
Determines whether the user can delete the model.

### restore
```php
public function restore(User $user, MainCard $mainCard): bool
{
    return $user->hasPermissionTo(PermissionTranslation::restore("Main Card")) 
        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment()) 
        && (!$mainCard->printed);
}
```
Determines whether the user can restore the model.

### forceDelete
```php
public function forceDelete(User $user, MainCard $mainCard): bool
{
    return $user->hasPermissionTo(PermissionTranslation::destroy("Main Card")) 
        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment()) 
        && (!$mainCard->printed);
}
```
Determines whether the user can permanently delete the model.
