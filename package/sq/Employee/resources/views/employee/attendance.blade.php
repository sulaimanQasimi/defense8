<div class="flex justify-around mt-10">

    {{--  IF Current Gate is Main Gate And Enter Gate is empty --}}
    @if ($attendance['allowed_gate'])
        @if ($date['start'] && $attendance['present'])
            <a href="{{ route('sqemployee.employee.check.pass', ['cardInfo' => $employee->id, 'state' => 'enter']) }}"
                class="px-7 rounded-lg hover:scale-95 py-1 text-white bg-gradient-to-t from-green-600 to-green-500"
                style="">@lang('Present')
            </a>
        @endif
        @if ($date['end'] && $attendance['exit'])
            <a href="{{ route('sqemployee.employee.check.pass', ['cardInfo' => $employee->id, 'state' => 'exit']) }}"
                class="px-7 rounded-lg hover:scale-95 py-1 text-white bg-gradient-to-t from-red-600 to-red-500"
                style="">@lang('Exited')</a>
        @endif

        @if ($attendance['absent'])
            <a href="{{ route('sqemployee.employee.check.pass', ['cardInfo' => $employee->id, 'state' => 'upsent']) }}"
                class="px-7 rounded-lg hover:scale-95 py-1 text-white bg-gradient-to-t from-red-600 to-red-500"
                style="">@lang('Upsent')</a>
        @endif

    @endif
</div>
