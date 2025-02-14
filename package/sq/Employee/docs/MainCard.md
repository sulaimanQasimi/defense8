# MainCard Class Documentation

## Namespace
```php
namespace Sq\Employee\Nova;
```

## Imports
```php
use Afj95\LaravelNovaHijriDatepickerField\HijriDatePicker;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Nova\Actions\EmployeePrintCardAction;
use App\Nova\Resource;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Sq\Query\Policy\UserDepartment;
use Carbon\Carbon;
```

## Class Definition
```php
class MainCard extends Resource
{
    // ...existing code...
}
```

## Properties

### $model
```php
public static $model = \Sq\Employee\Models\MainCard::class;
```
The model associated with the resource.

### $title
```php
public static $title = 'card_info.registare_no';
```
The title of the resource.

### $search
```php
public static $search = [];
```
The columns that should be searched.

## Methods

### label
```php
public static function label()
{
    return __('Main Card');
}
```
Returns the label for the resource.

### singularLabel
```php
public static function singularLabel()
{
    return __('Main Card');
}
```
Returns the singular label for the resource.

### indexQuery
```php
public static function indexQuery(NovaRequest $request, $query)
{
    return $query->whereHas('card_info', function ($query) {
        return $query->whereIn('department_id', UserDepartment::getUserDepartment());
    });
}
```
Modifies the index query to filter results based on the user's department.

### fields
```php
public function fields(NovaRequest $request)
{
    return [
        // ...existing code...
    ];
}
```
Defines the fields for the resource.

#### BelongsTo: Employee
```php
BelongsTo::make(__('Employee'), 'card_info', CardInfo::class)
    ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
        $query->whereIn('department_id', UserDepartment::getUserDepartment());
    }),
```
Defines a `BelongsTo` relationship with the `CardInfo` class, filtered by the user's department.

#### HijriDatePicker: Distribute Date
```php
HijriDatePicker::make(__("Disterbute Date"), "card_perform")
    ->hideWhenUpdating(fn() => $this->printed)
    ->format('iYYYY/iMM/iDD')
    ->placeholder('YYYY/MM/DD')
    ->selected_date('1444/12/12')
    ->placement('bottom'),
```
Defines a Hijri date picker for the distribute date, hidden when updating if the card is printed.

#### HijriDatePicker: Expire Date
```php
HijriDatePicker::make(__("Expire Date"), "card_expired_date")
    ->hideWhenUpdating(fn() => $this->printed)
    ->format('iYYYY/iMM/iDD')
    ->placeholder('YYYY/MM/DD')
    ->selected_date('1444/12/12')
    ->placement('bottom'),
```
Defines a Hijri date picker for the expire date, hidden when updating if the card is printed.

#### Boolean: Is Expired
```php
Boolean::make(__('Is Expired'), function () {
    $date1 = Carbon::make(Hijri::Date('Y-m-d'));
    $date2 = Carbon::make($this->card_expired_date);
    return $date1->lte($date2);
})->exceptOnForms(),
```
Defines a boolean field to check if the card is expired, based on the current Hijri date and the card's expiration date.

#### Trix: Remark
```php
Trix::make(trans('Remark'), 'remark'),
```
Defines a Trix editor for remarks.

#### Boolean: Print
```php
Boolean::make(__("Print"), 'printed')->hideWhenCreating(),
```
Defines a boolean field for the print status, hidden when creating.

#### Boolean: Muthanna
```php
Boolean::make(__("Muthanna"), 'muthanna'),
```
Defines a boolean field for the Muthanna status.

#### PersianDate: Print Date
```php
PersianDate::make(__("Print Date"), 'printed_at')->exceptOnForms(),
```
Defines a Persian date field for the print date, excluded from forms.

### cards
```php
public function cards(NovaRequest $request)
{
    return [];
}
```
Defines the cards for the resource.

### filters
```php
public function filters(NovaRequest $request)
{
    return [];
}
```
Defines the filters for the resource.

### lenses
```php
public function lenses(NovaRequest $request)
{
    return [
        new \Sq\Employee\Nova\Lenses\MainCardExpireToday(),
    ];
}
```
Defines the lenses for the resource.

### actions
```php
public function actions(NovaRequest $request)
{
    return [
        // ...existing code...
    ];
}
```
Defines the actions for the resource.

#### EmployeePrintCardAction
```php
(new \Sq\Card\Nova\Actions\EmployeePrintCardAction)->onlyOnDetail()
    ->canRun(fn($request, $mainCard) => auth()->user()->hasPermissionTo("print-card")
        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment())),
```
Defines the `EmployeePrintCardAction` action, restricted to users with the "print-card" permission and within the user's department.

#### EmployeePrintPaperCardAction
```php
(new \Sq\Card\Nova\Actions\EmployeePrintPaperCardAction)->onlyOnDetail()
    ->canRun(fn($request, $mainCard) => auth()->user()->hasPermissionTo("print-card")
        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment())),
```
Defines the `EmployeePrintPaperCardAction` action, restricted to users with the "print-card" permission and within the user's department.
