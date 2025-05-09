<?php
namespace Sq\Employee\Http\Controllers\Contracts;
use App\Settings\AttendanceTimer;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Pipeline;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\ScanedEmployee;
use Sq\Query\Policy\UserDepartment;

class Attendance
{
    /**
     * Summary of employee
     * @var CardInfo
     */
    public $employee;
    public function __construct(private string|null $code)
    {
        $this->employee = CardInfo::query()

            // Preload Relationships
            ->with(relations: ['employeeOptions','current_id_card', 'employee_vehical_card', 'gun_card', 'orginization'])

            // Find Current Employee
            ->where(column: 'registare_no', operator: "=", value: $code)

            // Get First Record
            ->first();
    }

    /**
     * Summary of FunctionName
     * @return \Sq\Employee\Models\Attendance|null
     */
    public function proform_attendance()
    {
        // Create Scaned Record
        if ($this->employee) {

            ScanedEmployee::create(attributes: [
                'card_info_id' => $this->employee->id,
                'gate_id' => auth()->user()?->gate?->id,
                'scaned_at' => now(),
            ]);
            return null;
        }
    }
}
