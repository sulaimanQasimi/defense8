@extends('sqoil::oil.layout')
@section('content')
    <div class="bg-gray-600 px-2 py-2 rounded-2xl">
        <div class="flex justify-between">
            <form action="">
                <input name="code" autofocus type="text" dir="ltr"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    required>
            </form>
            <div class="text-center text-[30px] text-white">@lang('Oil Disterbution')</div>
            <a href="/"
                class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-blue-600 to-blue-500"
                style="">@lang('Home')</a>
        </div>
    </div>


    <div class="grid grid-cols-5 px-5 py-3 gap-x-12">
        <div class="grid grid-cols-2 bg-white px-2 py-2 rounded-2xl border-blue-200 border drop-shadow-xl">
            <div>
                <div class="font-medium text-orange-500 ml-4">@lang('Diesel')</div>
                <div class="font-medium text-orange-500 ml-4">@lang('Remain'): @lang('Liter', ['value' => \Vehical\Vehical::remain_diesel_oil()])</div>
                <div class="font-medium text-orange-500 ml-4">@lang('Expend'): @lang('Liter', ['value' => \Vehical\Vehical::expend_diesel_oil()])</div>
            </div>
            <div class="mt-3 mr-12">
                <i class="fas fa-gas-pump fa-3x text-orange-600"></i>
            </div>
        </div>

        <div class="grid grid-cols-2 bg-white px-2 py-2 rounded-2xl border-blue-200 border drop-shadow-xl">
            <div>
                <div class="font-medium text-blue-500 ml-4">@lang('Petrole')</div>
                <div class="font-medium text-blue-500 ml-4">@lang('Remain'): @lang('Liter', ['value' => \Vehical\Vehical::remain_petrol_oil()])</div>
                <div class="font-medium text-blue-500 ml-4">@lang('Expend'): @lang('Liter', ['value' => \Vehical\Vehical::expend_petrol_oil()])</div>
            </div>
            <div class="mt-3 mr-12">
                <i class="fas fa-charging-station fa-3x text-blue-600"></i>
            </div>
        </div>
    </div>
    @if ($employee)
        <div class="grid grid-cols-2 bg-white border rounded-2xl px-5 py-6">
            <div>
                @if (session('out_of_oil'))
                    <div class="alert alert-success">
                        {{ session('out_of_oil') }}
                    </div>
                @endif
                <form action="{{ route('sq.oil.oil.store', ['cardInfo' => $employee->id]) }}" method="POST">
                    @csrf
                    @method('put')
                    <label for="">@lang('Amount')</label>
                    <input type="text" name="amount" id="">
                    <button type="submit">@lang('Save')</button>
                </form>
            </div>
            <div>
                @if ($employee)
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
                                <th  scope="col" class="px-4 py-1 text-2xl">
                                    @lang('Oil Type')
                                </th>
                                <td class="px-4 py-1  text-2xl">
                                    @lang($employee->oil_type && $employee->oil_type == \Vehical\OilType::Diesel ? 'Diesel' : 'Petrole')
                                </td>
                            </tr>
                            <tr class="border border-gray-600">
                                <th  scope="col" class="px-4 py-1 text-2xl">
                                    @lang('Monthly Rate')
                                </th>
                                <td class="px-4 py-1  text-2xl">
                                    @lang('Liter', ['value' => $employee->monthly_rate])
                                </td>
                            </tr>
                            <tr class="border border-gray-600">
                                <th  scope="col" class="px-4 py-1 text-2xl">
                                    @lang('Consumtion Amount')
                                </th>
                                <td class="px-4 py-1  text-2xl">
                                    @lang('Liter', ['value' => $employee->current_month_oil_consumtion])
                                </td>
                            </tr>
                            <tr class="border border-gray-600">
                                <th  scope="col" class="px-4 py-1 text-2xl">
                                    @lang('Remain')
                                </th>
                                <td class="px-4 py-1  text-2xl">
                                    @lang('Liter', ['value' => $employee->current_month_oil_remain])
                                </td>
                            </tr>
                        </thead>
                    </table>
                @endif            </div>
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
                                    <a href="{{ route('employee.check.card', ['code' => $vehical->driver->registare_no]) }}"
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
    @push('js')
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
    @endpush

@endsection
