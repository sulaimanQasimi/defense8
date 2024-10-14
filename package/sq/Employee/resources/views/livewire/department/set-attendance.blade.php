<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}

    <section class="bg-gradient-to-b from-sky-100 to-transparent rounded-xl">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">

            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-sky-900 md:text-5xl lg:text-6xl dark:text-white">
                @lang('Attendance Employee Info')</h1>
            <p class="mb-8 text-lg font-normal text-sky-500 lg:text-xl sm:px-16 xl:px-48 dark:text-sky-400">
                @lang('In this Page you can set each employee attendance')</p>
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

    <div class="py-3" dir="rtl">
        <div class="relative overflow-x-auto sm:rounded-lg shadow-2xl">
            <table class="w-full table-auto text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                    <tr class="bg-gradient-to-b text-white from-gray-800  to-gray-900">
                        <th scope="col" class="text-white px-6 py-3">#</th>
                        <th scope="col" class="text-white px-6 py-3">@lang('Register No')</th>
                        <th scope="col" class="text-white px-6 py-3">@lang('Name')</th>
                        <th scope="col" class="text-white px-6 py-3">@lang('Last Name')</th>
                        <th scope="col" class="text-white px-6 py-3">@lang('Father Name')</th>
                        <th scope="col" class="text-white px-6 py-3">@lang('Grand Father Name')</th>

                        <th scope="col" class="print:px-2 px-6 py-4">@lang('Date')</th>
                        <th scope="col" class="print:px-2 px-6 py-4">@lang('Enter At')</th>
                        <th scope="col" class="print:px-2 px-6 py-4">@lang('Exit At')</th>
                        <th scope="col" class="print:px-2 px-6 py-4">@lang('State')</th>
                    </tr>

                </thead>
                <tbody style="overflow-y:hidden ">
                    @forelse ($employees as $employee)
                        <tr @class([
                            // 'bg-white'=> $loop->odd,
                            // 'bg-gray-200' => $loop->even,
                            'border-b dark:bg-gray-900 dark:border-gray-700',
                        ])>
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $employee->registare_no }}</td>
                            <td class="px-6 py-4">{{ $employee->name }}</td>
                            <td class="px-6 py-4">{{ $employee->last_name }}</td>
                            <td class="px-6 py-4">{{ $employee->father_name }}</td>
                            <td class="px-6 py-4">{{ $employee->grand_father_name }}</td>
                            <td class="px-6 py-4">{{ (optional($employee->today_attendance)->date)?verta(optional($employee->today_attendance)->date)->format('Y-m-d'):"" }}</td>
                            <td class="px-6 py-4">{{ (optional($employee->today_attendance)->enter)?verta(optional($employee->today_attendance)->enter)->format('h:i a'):"" }}</td>
                            <td class="px-6 py-4">{{ (optional($employee->today_attendance)->exit)?verta(optional($employee->today_attendance)->exit)->format('h:i a'):"" }}</td>
                            <td class="px-6 py-4"><livewire:sq-employee-set-employee-attendance :$employee :id="'attendnace -'.$employee->id"/></td>

                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
            {{$employees->links()}}
        </div>
    </div>
</div>
