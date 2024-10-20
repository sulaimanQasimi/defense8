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
            ->with(relations: ['employeeOptions', 'employee_vehical_card', 'gun_card', 'orginization'])

            // Find Current Employee
            ->where(column: 'registare_no', operator: "=", value: $code)

            // Get First Record
            ->first();
    }



    /**
     * Summary of attendance_timer
     * @param \Sq\Employee\Models\Department $department
     * @return mixed
     */
    private static function attendance_timer($department = null): array
    {
        if (!isset($department->start, $department->end) || (empty($department->start) && empty($department->end))) {
            $department = new AttendanceTimer();
        }
        return Pipeline::send(passable: $department)
            ->through(pipes: [
                fn($context, Closure $next): mixed => $next(['start' => $context->start, 'end' => $context->end]),
                fn($context, Closure $next): mixed => $next(['start' => mb_split(pattern: '-', string: $context['start']), 'end' => mb_split('-', $context['end'])]),
                fn($context, Closure $next): mixed => $next(
                    [
                        'start' =>
                            [
                                Carbon::make(var: $context['start'][0]),
                                Carbon::make(var: $context['start'][1])
                            ],
                        'end' => [
                            Carbon::make(var: $context['end'][0])->addHours(value: 12),
                            Carbon::make(var: $context['end'][1])->addHours(value: 12)
                        ]
                    ]
                ),
                fn($context, Closure $next): mixed => $next(
                    [
                        'start' => Carbon::now()->between($context['start']['0'], $context['start']['1']),
                        'end' => Carbon::now()->between($context['end']['0'], $context['end']['1'])
                    ]
                )
            ])
            ->then(destination: fn($context): mixed => $context);
    }


    /**
     * Summary of FunctionName
     * @return \Sq\Employee\Models\Attendance|null
     */
    public function proform_attendance()
    {
        // Create Scaned Record
        if ($this->employee) {

            $date = self::attendance_timer(department: $this->employee->orginization);

            ScanedEmployee::create(attributes: [
                'card_info_id' => $this->employee->id,
                'gate_id' => auth()->user()?->gate?->id,
                'scaned_at' => now(),
            ]);

            // Create a new instance
            $attendance = \Sq\Employee\Models\Attendance::updateOrCreate(
                [
                    'card_info_id' => $this->employee->id,
                    'date' => now()->format('Y-m-d'),
                ],
                [
                    'gate_id' => auth()->user()->gate->id,
                ]
            );
            //  If Gate Related to this employee gate
            if (in_array($this->employee?->gate?->id, UserDepartment::getUserGate())) {

                // Present
                if ($date['start'] && is_null($this->employee->today_attendance?->enter) && $this->employee->today_attendance?->state != 'U') {

                    // Fill the date to NOW
                    $attendance->enter = now();

                    // State changed to P - Present
                    $attendance->state = "P";
                }

                // exit
                if ($date['end'] && $this->employee->today_attendance?->enter && is_null($this->employee->today_attendance?->exit) && $this->employee->today_attendance?->state != "U") {

                    // Update Attendance Datetime to NOW
                    $attendance->exit = now();
                }
                $attendance->save();
                $attendance->fresh();
                return $attendance;
            }
            return null;

        }
    }


}
