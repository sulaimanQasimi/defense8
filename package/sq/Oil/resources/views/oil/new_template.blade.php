<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang("Oil Disterbution Page")</title>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesom/all.min.css') }}">
    <link type="text/css" href="{{ asset('date/css/persian-datepicker.css') }}" rel="stylesheet" />
    @vite(['resources/js/app.js'])

    @stack('css')
    <link type="text/css" href="{{ asset('single.css') }}" rel="stylesheet" />
    <link type="text/css" href="{{ asset('sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
</head>

<body dir="rtl" class="px-6">
    <!--header-->
    <div
        class="header w-full h-16 bg-gradient-to-tr from-blue-600 to-blue-900 shadow-md shadow-gray-400 flex justify-between items-center">
        <form action="">
            <input name="code" autofocus type="text" dir="ltr"
                class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required />
        </form>
        <h1 class="text-2xl text-white">{{ config('app.name') }}</h1>
        <a href="/"
            class="text-white outline-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('Home')</a>

    </div>
    <div class="container grid md:grid-cols-5 sm:grid-cols-1 mt-5 w-full shadow-gray-200 shadow-lg  gap-2 p-2">
        <div
            class="block rounded-lg transition duration-500 ease-out hover:bg-orange-300 bg-white border border-red-700 p-6 text-surface shadow-secondary-1">
            <div class="mb-2 text-xl font-medium leading-tight flex justify-between items-center">
                <i class="fa-solid fa-gas-pump text-4xl text-red-600"></i>@lang('Remain')
            </div>
            <p class="mb-4 text-base text-right">
                @lang('Total Remain Diesel'):@lang('Liter', ['value' => \Vehical\Vehical::remain_diesel_oil()])
            </p>
        </div>
        <div
            class="block rounded-lg transition duration-500 ease-out hover:bg-green-300 bg-white border border-green-700 p-6 text-surface shadow-secondary-1">
            <div class="mb-2 text-xl font-medium leading-tight flex justify-between items-center"><i
                    class="fa-solid fa-gas-pump text-4xl text-green-700"></i>@lang('Remain')</div>
            <p class="mb-4 text-base text-right">
                @lang('Total Remain Petrol'):@lang('Liter', ['value' => \Vehical\Vehical::remain_petrol_oil()])
            </p>
        </div>
        <div
            class="block rounded-lg transition duration-500 ease-out hover:bg-orange-300 bg-white border border-red-700 p-6 text-surface shadow-secondary-1">
            <div class="mb-2 text-xl font-medium leading-tight flex justify-between items-center"><i
                    class="fa-solid fa-gas-pump text-4xl text-red-600"></i>@lang('Expend')</div>
            <p class="mb-4 text-base text-right">
                @lang('Total Expend Diesel'): @lang('Liter', ['value' => \Vehical\Vehical::expend_diesel_oil()])
            </p>
        </div>
        <div
            class="block rounded-lg transition duration-500 ease-out hover:bg-green-300 bg-white border border-green-700 p-6 text-surface shadow-secondary-1">
            <div class="mb-2 text-xl font-medium leading-tight flex justify-between items-center"><i
                    class="fa-solid fa-gas-pump text-4xl text-green-700"></i>@lang('Expend')</div>
            <p class="mb-4 text-base text-right">
                @lang('Total Expend Petrol'): @lang('Liter', ['value' => \Vehical\Vehical::expend_petrol_oil()])
            </p>
        </div>
    </div>
    <!--content of charts-->
    <!--the owner checkbar-->
    @if ($employee)
        <div
            class="container p-2 w-full grid sm:grid-cols-1 md:grid-cols-2 mt-10 bg-white shadow-md shadow-gray-500 gap-2">
            <div>
                <form action="{{ route('sq.oil.oil.store', ['cardInfo' => $employee->id]) }}" method="POST">
                    @csrf
                    @method('put')

                    <div class="flex">
                        <label for="search-dropdown"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">your
                            amount</label>
                    </div>
                    <div class=" flex justify-between">
                        <input type="text" id="search-dropdown" name="amount"
                            class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg rounded-s-gray-100 rounded-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                            placeholder="@lang('Oil Amount')" required />

                        <button type="submit"
                            class=" top-0 end-0 p-2.5 h-full text-sm font-medium text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><svg
                                class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>

                            </svg></button>
                    </div>
                </form>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 ">
                <thead class="">

                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-3 text-center  text-4xl" colspan="5">
                            د کارمند مشخصات
                        </th>

                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-2xl ">
                            ثبت ګنه:
                        </th>
                        <td class="px-6 py-1">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->registare_no }}
                            </p>
                        </td>
                        <td rowspan="6">
                            <div class="flex justify-center align-middle">
                                <img style="height: 150px" class="rounded-lg block"
                                    src="{{ asset("storage/{$employee->photo}") }}" />

                            </div>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-2xl">
                            نوم او تخلص:
                        </th>
                        <td class="px-6 py-1">
                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->full_name }}
                            </p>
                        </td>
                    </tr>

                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-2xl">
                            د پلارنوم:
                        </th>
                        <td class="px-4 py-1  text-2xl">
                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->father_name }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1   text-2xl">
                            دنده:
                        </th>
                        <td class="px-4 py-1   text-2xl">
                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->job_structure }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1  text-2xl">
                            اروند اداره:
                        </th>
                        <td class="px-4 py-1  text-2xl">

                            <p class="font-medium leading-none text-gray-700 mr-2 text-2xl">
                                {{ $employee->orginization?->fa_name }}
                            </p>
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-2xl">
                            @lang('Oil Type')
                        </th>
                        <td class="px-4 py-1  text-2xl">
                            @lang($employee->oil_type && $employee->oil_type == \Vehical\OilType::Diesel ? 'Diesel' : 'Petrole')
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-2xl">
                            @lang('Monthly Rate')
                        </th>
                        <td class="px-4 py-1  text-2xl">
                            @lang('Liter', ['value' => $employee->monthly_rate])
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-2xl">
                            @lang('Consumtion Amount')
                        </th>
                        <td class="px-4 py-1  text-2xl">
                            @lang('Liter', ['value' => $employee->current_month_oil_consumtion])
                        </td>
                    </tr>
                    <tr class="border border-gray-600">
                        <th scope="col" class="px-4 py-1 text-2xl">
                            @lang('Remain')
                        </th>
                        <td class="px-4 py-1  text-2xl">
                            @lang('Liter', ['value' => $employee->current_month_oil_remain])
                        </td>
                    </tr>
                </thead>
            </table>

        </div>

        <div class="mt-7 overflow-x-auto" dir="rtl">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">

                        <tr>
                            <th scope="col" class="px-6  border-1 border-gray-600 py-3 text-center text-[32px]"
                                colspan="11">
                                @lang('Employee Vehical Card')
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                                @lang('Vehical Palete')
                            </th>
                            <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                                @lang('Vehical Colour')
                            </th>
                            <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                                @lang('Vehical Chassis')
                            </th>
                            <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                                @lang('Vehical Model')
                            </th>
                            <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                                @lang('Driver')
                            </th>
                            <th scope="col" class="px-6  border-1 border-gray-600 py-3">
                                @lang('Remark')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employee->employee_vehical_card as $vehical)
                            <tr tabindex="0" class="bg-white border-b">

                                <td class="px-6  border-1 border-gray-600 py-4">
                                    {{ $vehical->vehical_palete }}
                                </td>
                                <td class="px-6  border-1 border-gray-600 py-4">
                                    {{ $vehical->vehical_colour }}
                                </td>
                                <td class="px-6  border-1 border-gray-600 py-4">
                                    {{ $vehical->vehical_chassis }}
                                </td>
                                <td class="px-6  border-1 border-gray-600 py-4">
                                    {{ $vehical->vehical_model }}
                                </td>
                                <td class="px-6  border-1 border-gray-600 py-4">
                                    <a href="{{ route('sqemployee.employee.check.card', ['code' => $vehical->driver->registare_no]) }}"
                                        class="text-blue-600 text-lg"> {{ $vehical->driver->full_name }}</a>
                                </td>
                                <td class="px-6  border-1 border-gray-600 py-4">
                                    {!! $vehical->remark !!}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    @endif
    </div>
    <!--the owner checkbar-->
    <!--oil pump checkbar-->

    <!-- jQuery -->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('date/js/persian-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    @if (session('error'))
        <script>
            Swal.fire({
                title: "@lang('Error Occar')",
                text: "{{ session('error') }}",
                icon: "error",
                showCancelButton: 0,
                showConfirmButton: 0,
            })
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                title: "{{ session('success') }}",
                text: "",
                icon: "success",
                showCancelButton: 0,
                showConfirmButton: 0,
            })
        </script>
    @endif

</body>

</html>
