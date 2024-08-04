<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <section class="bg-gradient-to-b from-sky-100 to-transparent rounded-xl">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">

            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-sky-900 md:text-5xl lg:text-6xl dark:text-white">
                @lang('Attendance Employee Info')</h1>
            <p class="mb-8 text-lg font-normal text-sky-500 lg:text-xl sm:px-16 xl:px-48 dark:text-sky-400">
                @lang('Through this forms find your information')</p>
            <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                <a href="/"
                    class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-sky-900 rounded-lg border border-sky-300 hover:bg-sky-100 focus:ring-4 focus:ring-sky-100 dark:text-white dark:border-sky-700 dark:hover:bg-sky-700 dark:focus:ring-sky-800">
                    <svg class="w-6 h-6 text-sky-800 dark:text-white animate-bounce duration-700" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                    </svg>
                    @lang('Home')
                </a>
            </div>
        </div>
    </section>


    <div class="px-3" dir="rtl">
        <Section id="filters" class="print:hidden">

            <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 gap-x-3 gap-y-6">
                <div>
                    <div class="mb-5" wire:ignore>
                        <label for="department"
                            class="block mb-2 text-sm font-medium text-sky-900 dark:text-white">@lang('Department')</label>
                        <select wire:model="department" id="department"
                            class="department select2 select2-bootstrap-theme " style="width: 100%;padding: 0.625rem"
                            name="states[]">
                            @foreach (\Sq\Employee\Models\Department::all() as $org)
                                <option value="{{ $org->id }}">{{ $org->fa_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{--  --}}

                <div>
                    <div class="mb-5" wire:ignore>
                        <label for="year"
                            class="block mb-2 text-sm font-medium text-sky-900 dark:text-white">@lang('Year')</label>
                        <select wire:model="year" id="year" class="select2 select2-bootstrap-theme "
                            style="width: 100%;padding: 0.625rem" name="states[]">
                            @for ($i = 1395; $i <= 1599; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                {{--  --}}

                <div>
                    <div class="mb-5" wire:ignore>
                        <label for="month"
                            class="block mb-2 text-sm font-medium text-sky-900 dark:text-white">@lang('Month')</label>
                        <select wire:model="month" id="month" class="select2 select2-bootstrap-theme "
                            style="width: 100%;padding: 0.625rem" name="states[]">

                            <option value="1">@lang('Hamal')</option>
                            <option value="2">@lang('Thour')</option>
                            <option value="3">@lang('Jawza')</option>
                            <option value="4">@lang('Sarathan')</option>
                            <option value="5">@lang('Asad')</option>
                            <option value="6">@lang('Sunbulah')</option>
                            <option value="7">@lang('Mizan')</option>
                            <option value="8">@lang('Aqrab')</option>
                            <option value="9">@lang('Qous')</option>
                            <option value="10">@lang('Jadi')</option>
                            <option value="11">@lang('Dalwa')</option>
                            <option value="12">@lang('Hod')</option>

                        </select>
                    </div>
                </div>
            </div>
        </Section>
        @if ( $route != '#')
        <a wire:loading.attr="disabled" href="{{ $route }}"
        target="_blank"
            @class([
                'bg-green-300' => $route != '#',
                'mt-8 block w-full rounded-md border border-transparent bg-blue-300 px-8 py-3 text-base font-medium text-gray-900  sm:w-auto',
            ])>@lang('Download')</a>

@else
<button type="button" wire:click="save" wire:loading.attr="disabled" href="{{ $route }}"
    @class([
        'mt-8 block w-full rounded-md border border-transparent bg-blue-300 px-8 py-3 text-base font-medium text-gray-900  sm:w-auto',
    ])>@lang('Save')</button>

@endif

    </div>

    @script
        <script>
            $(function() {
                $('#month').select2({
                    selectionCssClass: "4",
                    allowClear: true,

                    theme: "classic",

                    dir: "rtl",

                    width: 'resolve' // need to override the changed default
                }).on('change', function(e) {
                    $wire.set('month', $(this).val())
                })


                $('#year').select2({
                    selectionCssClass: "4",
                    allowClear: true,

                    theme: "classic",

                    dir: "rtl",

                    width: 'resolve' // need to override the changed default
                }).on('change', function(e) {
                    $wire.set('year', $(this).val())
                })

                $('#department').select2({
                    selectionCssClass: "4",
                    allowClear: true,

                    theme: "classic",

                    dir: "rtl",

                    width: 'resolve' // need to override the changed default
                }).on('change', function(e) {
                    $wire.set('department', $(this).val())
                })

            });
        </script>
    @endscript
</div>
