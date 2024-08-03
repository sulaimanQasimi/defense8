<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @if (!is_null($employee->gate))


        @if (
            !$employee->current_gate_attendance?->enter &&
                !$employee->current_gate_attendance?->exit &&
                $employee->current_gate_attendance?->state != 'U')
            <button wire:click="save('enter')"
                class="px-6 rounded-xl py-2 bg-gradient-to-b from-green-600 from-60% to-40% to-green-700 border-1 hover:scale-105 duration-200 delay-200 border-green-500 text-white">
                @lang('Present')
            </button>
        @endif
        @if (
            !$employee->current_gate_attendance?->enter &&
                !$employee->current_gate_attendance?->exit &&
                $employee->current_gate_attendance?->state != 'U')
            <button wire:click="save('upsent')"
                class="px-6 rounded-xl py-2 bg-gradient-to-b from-red-600 from-60% to-40% to-red-700 border-1 hover:scale-105 duration-200 delay-200 border-red-500 text-white">
                @lang('Upsent')
            </button>
            @endif
            @if (
                $employee->current_gate_attendance?->enter &&
                    !$employee->current_gate_attendance?->exit &&
                    $employee->current_gate_attendance?->state != 'U')
                <button wire:click="save('exit')"
                    class="px-6 rounded-xl py-2 bg-gradient-to-b from-yellow-600 from-60% to-40% to-yellow-700 border-1 hover:scale-105 duration-200 delay-200 border-yellow-500 text-white">
                    @lang('Exit')
                </button>

            @endif
            @lang(($employee->current_gate_attendance?->state=="U")?"Upsent":"")
            @lang(($employee->current_gate_attendance?->state=="P")?"Present":"")
        @else
            <span>@lang('Gate is Not Specified')</span>
        @endif
</div>
