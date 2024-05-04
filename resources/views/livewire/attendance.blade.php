<div dir="rtl">
    {{-- Be like water. --}}

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
    <div class="px-3">
        <Section id="filters" class="print:hidden">

            <div class="grid lg:grid-cols-3 md:grid-cols-3 sm:grid-cols-1 gap-x-3 gap-y-6">
                <div>
                    <div class="mb-5">
                        <label for="employee-id"
                            class="block mb-2 text-sm font-medium text-sky-900 dark:text-white">@lang('ID Card')</label>
                        <input type="text" id="employee-id" wire:model.live="employee"
                            class="shadow-sm bg-sky-50 border
                    border-sky-300
                    text-gray-900 text-sm
                    rounded-lg
                    focus:ring-blue-500
                    focus:border-blue-500 block w-full p-2.5 dark:bg-sky-700 dark:border-sky-600 dark:placeholder-sky-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="Gx-xxxxx" dir="ltr" required />
                    </div>
                </div>


                <div>
                    <div class="mb-5" wire:ignore>
                        <label for="department"
                            class="block mb-2 text-sm font-medium text-sky-900 dark:text-white">@lang('Department')</label>
                        <select wire:model="department" class="department select2 select2-bootstrap-theme "
                            style="width: 100%;padding: 0.625rem" name="states[]">
                            @foreach (\App\Models\Department::all() as $org)
                                <option value="{{ $org->id }}">{{ $org->fa_name }}</option>
                            @endforeach
                            =
                        </select>
                    </div>
                </div>


                <div>
                    <div class="mb-5" wire:ignore>
                        <label for="date"
                            class="block mb-2 text-sm font-medium text-sky-900 dark:text-white">@lang('Date')</label>
                        <input type="text" id="datepicker0" {{-- wire:model.live="date" --}}
                            class="shadow-sm bg-sky-50 border border-sky-300 text-sky-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-sky-700 dark:border-sky-600 dark:placeholder-sky-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required />
                    </div>
                </div>


            </div>
        </Section>


        @if (!is_null($date)&&$date!="")
            <div class="relative overflow-x-auto  rounded-xl shadow-xl shadow-sky-600">
                <table class="w-full text-sm text-left rtl:text-right text-sky-500 dark:text-sky-400">
                    <thead class="text-xs uppercase bg-gradient-to-l  from-sky-400 to-sky-600 text-sky-100">

                        <tr>
                            <th></th>
                            <th scope="col" class="px-6 py-4 ">
                                @lang('ID Card')
                            </th>
                            <th scope="col" class="print:px-2 px-6 py-4">@lang('Name')</th>
                            <th scope="col" class="print:px-2 px-6 py-4">@lang('Last Name')</th>
                            <th scope="col" class="print:px-2 px-6 py-4">@lang('Department')</th>
                            <th scope="col" class="print:px-2 px-6 py-4">@lang('Date')</th>
                            <th scope="col" class="print:px-2 px-6 py-4">@lang('Enter At')</th>
                            <th scope="col" class="print:px-2 px-6 py-4">@lang('Exit At')</th>
                            <th scope="col" class="print:px-2 px-6 py-4">@lang('State')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($card_infos as $card_info)
                            @php
                                $attendance = $card_info->attendance()->whereDate('date', \Illuminate\Support\Carbon::make( $date))->first();
                            @endphp
                            <tr class=" border-b bg-sky-800 border-sky-700">
                                <td>

                                    {{-- <img class="rounded-full w-40 h-40 px-2 py-2"
                                    src="https://flowbite.com/docs/images/examples/image-4@2x.jpg"
                                    alt="image description"> --}}

                                </td>
                                <td scope="col" class="print:px-2 px-6 py-4 ">
                                    {{ $card_info->registare_no }}
                                </td>
                                <td class="print:px-2 px-6 py-4">
                                    {{ $card_info->name }}

                                </td>
                                <td class="print:px-2 px-6 py-4">
                                    {{ $card_info->last_name ?? '' }}

                                </td>
                                <td class="print:px-2 px-6 py-4">
                                    {{ $card_info->orginization?->fa_name }}

                                </td>
                                <td class="print:px-2 px-6 py-4" dir="ltr">
                                    {{ optional($attendance)->date ? verta(optional($attendance)->date)->format('Y-m-d') : '' }}

                                </td>
                                <td class="print:px-2 px-6 py-4" dir="ltr">
                                    {{ optional($attendance)->enter ? verta(optional($attendance)->enter)->format('h:i a') : '' }}

                                </td>
                                <td class="print:px-2 px-6 py-4" dir="ltr">
                                    {{ optional($attendance)->exit ? verta(optional($attendance)->exit)->format('h:i a') : '' }}

                                </td>

                                <td class="print:px-2 px-6 py-4">
                                    @if ($attendance)
                                        <button
                                            class="px-6 rounded-xl py-2 bg-gradient-to-b from-green-600 to-green-700 border-1 hover:scale-105 duration-200 delay-200 border-green-500 text-white">
                                            @lang($attendance?->state == 'P' ? 'Present' : 'Upsent')
                                        </button>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td></td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                {{ $card_infos->links() }}
            </div>

        @endif


    </div>
    @script
        <script>
            $(function() {
                $('#datepicker0').datepicker({
                    onSelect: function(dateText, inst) {
                        let s = new JalaliDate(inst['selectedYear'], inst['selectedMonth'], inst[
                            'selectedDay']);
                        let r = new Date(s.getGregorianDate());
                        console.log(r)
                        $wire.set('date', r.toLocaleDateString())
                        // $wire.set('date', r.getYear()+"/"+r.getMonth()."/".r.getDay())
                    }
                })
                //Initialize Select2 Elements
                $('.department').select2({
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
