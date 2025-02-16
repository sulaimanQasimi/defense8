
# PrintSettings Trait

The `PrintSettings` trait provides reusable methods for handling the printing of various types of cards. This trait can be used in controllers to streamline the process of printing employee cards, gun cards, and employee vehicle cards.

## Methods

### `card_optimization`

This abstract method must be implemented in the controller using the trait. It handles the optimization of card data before printing.

**Parameters:**
- `$cardInfo`: The card information.
- `$printCardFrame`: The ID of the print card frame.
- `$employeeVehicalCard` (optional): The employee vehicle card information.
- `$gun` (optional): The gun card information.
- `$printTypeEnum` (optional): The type of the card being printed.
- `$mainCard` (optional): The main card information.

**Returns:**
- `\Illuminate\View\View`: The view to be rendered.

### `employee`

Handles the printing process for an employee's main card.

**Parameters:**
- `\Illuminate\Http\Request $request`: The HTTP request.
- `\Sq\Employee\Models\MainCard $mainCard`: The main card model.
- `int $printCardFrame`: The ID of the print card frame.

**Returns:**
- `\Illuminate\View\View`: The view to be rendered.

### `gun`

Handles the printing process for a gun card.

**Parameters:**
- `\Illuminate\Http\Request $request`: The HTTP request.
- `\Sq\Employee\Models\GunCard $gunCard`: The gun card model.
- `int $printCardFrame`: The ID of the print card frame.

**Returns:**
- `\Illuminate\View\View`: The view to be rendered.

### `employee_car`

Handles the printing process for an employee vehicle card.

**Parameters:**
- `\Illuminate\Http\Request $request`: The HTTP request.
- `\Sq\Employee\Models\EmployeeVehicalCard $employeeVehicalCard`: The employee vehicle card model.
- `int $printCardFrame`: The ID of the print card frame.

**Returns:**
- `\Illuminate\View\View`: The view to be rendered.

### `logActivity`

Logs the activity of printing a card.

**Parameters:**
- `$entity`: The entity being printed (MainCard, GunCard, or EmployeeVehicalCard).
- `$mainCard` (optional): The main card being printed.
- `$gun` (optional): The gun card being printed.
- `$employeeVehicalCard` (optional): The employee vehicle card being printed.

**Returns:**
- `void`

### `validateCardInfo`

Validates the card information before printing.

**Parameters:**
- `$cardInfo`: The card information.
- `$card`: The card frame.
- `$printTypeEnum`: The type of the card being printed.

**Returns:**
- `void`

### `getIssueDate`

Gets the issue date for the card being printed.

**Parameters:**
- `$printTypeEnum`: The type of the card being printed.
- `$mainCard` (optional): The main card being printed.
- `$employeeVehicalCard` (optional): The employee vehicle card being printed.
- `$gun` (optional): The gun card being printed.

**Returns:**
- `mixed`: The issue date.

### `getExpireDate`

Gets the expiration date for the card being printed.

**Parameters:**
- `$printTypeEnum`: The type of the card being printed.
- `$mainCard` (optional): The main card being printed.
- `$employeeVehicalCard` (optional): The employee vehicle card being printed.
- `$gun` (optional): The gun card being printed.

**Returns:**
- `mixed`: The expiration date.

## Usage

To use the `PrintSettings` trait in a controller, simply include the trait and implement the `card_optimization` method. Here is an example:

```php
namespace Sq\Card\Http\Controllers;

use App\Http\Controllers\Controller;
use Sq\Card\Http\Controllers\Contracts\PrintSettings;
use Illuminate\View\View;

class PrintCardController extends Controller
{
    use PrintSettings;

    private function card_optimization($cardInfo, $printCardFrame, $employeeVehicalCard = null, $gun = null, $printTypeEnum = null, $mainCard = null): View
    {
        // Implementation of card optimization logic
    }
}
```

By using the `PrintSettings` trait, you can easily manage the printing process for different types of cards with minimal code duplication.
