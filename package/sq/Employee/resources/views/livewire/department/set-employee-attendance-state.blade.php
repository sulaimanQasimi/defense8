<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

    <div>

        {{-- Loading Component --}}
        @teleport('body')
            @include('sqcard::livewire.guest.components.loadingBanner')
        @endteleport
        {{-- File Upload Component --}}
    </div>

    @if ($attendance['present'])
        <button wire:loading.class="opacity-50" wire:loading.attr="disabled" wire:click="save('enter')"
            class="px-6 rounded-xl py-2 bg-gradient-to-b from-green-600 from-60% to-40% to-green-700 border-1 hover:scale-105 duration-200 delay-200 border-green-500 text-white">
            @lang('Present')
        </button>
    @endif

    @if ($attendance['absent'])
        <button wire:click="save('upsent')" wire:loading.class="opacity-50" wire:loading.attr="disabled"
            class="px-6 rounded-xl py-2 bg-gradient-to-b from-red-600 from-60% to-40% to-red-700 border-1 hover:scale-105 duration-200 delay-200 border-red-500 text-white">
            @lang('Upsent')
        </button>
    @endif
    @if ($attendance['exit'])
        <button wire:click="save('exit')" wire:loading.class="opacity-50" wire:loading.attr="disabled"
            class="px-6 rounded-xl py-2 bg-gradient-to-b from-yellow-600 from-60% to-40% to-yellow-700 border-1 hover:scale-105 duration-200 delay-200 border-yellow-500 text-white">
            @lang('Exit')
        </button>
    @endif
    @lang($employee->today_attendance?->state == 'U' ? 'Upsent' : '')
    @lang($employee->today_attendance?->state == 'P' ? 'Present' : '')

</div>
