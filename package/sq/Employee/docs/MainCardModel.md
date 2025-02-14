# MainCard Model Documentation

## Namespace
```php
namespace Sq\Employee\Models;
```

## Imports
```php
use App\Support\HasCardInfo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
```

## Class Definition
```php
class MainCard extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasCardInfo;
    // use HasUuids;
    // ...existing code...
}
```

## Properties

### $fillable
```php
protected $fillable = [
    "card_perform",
    "card_expired_date",
    'printed',
];
```
The attributes that are mass assignable.

### $casts
```php
protected $casts = [
    "card_second_date" => 'date',
    "card_perform" => 'date',
    "card_expired_date" => 'date',
    'printed_at' => 'date',
    'printed' => 'boolean',
];
```
The attributes that should be cast to native types.

## Traits

### HasFactory
```php
use HasFactory;
```
Includes the `HasFactory` trait for factory support.

### SoftDeletes
```php
use SoftDeletes;
```
Includes the `SoftDeletes` trait for soft deleting support.

### HasCardInfo
```php
use HasCardInfo;
```
Includes the `HasCardInfo` trait for card information support.

### HasUuids
```php
// use HasUuids;
```
Optionally includes the `HasUuids` trait for UUID support (commented out).

## Methods

### card_info
```php
public function card_info(): BelongsTo
{
    return $this->belongsTo(CardInfo::class);
}
```
Defines a `BelongsTo` relationship with the `CardInfo` class.
