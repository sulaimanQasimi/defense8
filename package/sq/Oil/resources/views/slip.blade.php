<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('Oil Disterbution Page')</title>
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesom/all.min.css') }}">
    <link type="text/css" href="{{ asset('date/css/persian-datepicker.css') }}" rel="stylesheet" />
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <script type="text/javascript" src="{{ asset('qrcode/qrcode.js') }}"></script>

</head>

<body dir="rtl" class="px-6">
    <div class="">
        <div class="text-center my-5"></div>
        <table class="text-sm text-left rtl:text-right ">
            <thead class="">
                <tr>
                    <th scope="col" class="text-center px-2 py-4" colspan="2">
                        رسید تیل
                    </th>
                </tr>
                <tr>
                    <th scope="col" class="text-center border border-gray-500 px-2 " colspan="2">
                        د کارمند مشخصات
                    </th>
                </tr>
                <tr>
                    <th class="border border-gray-500 px-2">
                        ثبت ګنه:
                    </th>
                    <td class="border border-gray-500 px-2">
                        {{ $employee->registare_no }}
                    </td>

                </tr>
                <tr>
                    <th class="border border-gray-500 px-2">
                        نوم او تخلص:
                    </th>
                    <td class="border border-gray-500 px-2">

                        {{ $employee->full_name }}
                    </td>
                </tr>

                <tr>
                    <th class="border border-gray-500 px-2">
                        د پلارنوم:
                    </th>
                    <td class="border border-gray-500 px-2">
                        {{ $employee->father_name }}
                    </td>
                </tr>
                <tr>
                    <th class="border border-gray-500 px-2">
                        دنده:
                    </th>
                    <td class="border border-gray-500 px-2">
                        {{ $employee->job_structure }}
                    </td>
                </tr>
                <tr>
                    <th scope="col" class="border border-gray-500 px-2">
                        اروند اداره:
                    </th>
                    <td class="border border-gray-500 px-2">
                        {{ $employee->orginization?->fa_name }}
                    </td>
                </tr>
                <tr>
                    <th class="border border-gray-500 px-2">
                        @lang('Oil Type')
                    </th>
                    <td class="border border-gray-500 px-2">
                        @lang($employee->oil_type && $employee->oil_type == \Vehical\OilType::Diesel ? 'Diesel' : 'Petrole')
                    </td>
                </tr>
                <tr>
                    <th class="border border-gray-500 px-2">
                        @lang('Monthly Rate')
                    </th>
                    <td class="border border-gray-500 px-2">
                        @lang('Liter', ['value' => $employee->monthly_rate])
                    </td>
                </tr>
                <tr>
                    <th class="border border-gray-500 px-2">
                        @lang('Consumtion Amount')
                    </th>
                    <td class="border border-gray-500 px-2">
                        @lang('Liter', ['value' => $employee->current_month_oil_consumtion])
                    </td>
                </tr>
                <tr>
                    <th class="border border-gray-500 px-2">
                        @lang('Remain')
                    </th>
                    <td class="border border-gray-500 px-2">
                        @lang('Liter', ['value' => $employee->current_month_oil_remain])
                    </td>
                </tr>

                <tr>
                    <th class="border border-gray-500 px-2">
                        @lang('Recieved Oil')
                    </th>
                    <td class="border border-gray-500 px-2">
                        @lang('Liter', ['value' => $oil->oil_amount])
                    </td>
                </tr>
                <tr>
                    <th class="border border-gray-500 px-2">
                        @lang('Date')
                    </th>
                    <td class="border border-gray-500 px-2">
                        {{ verta($oil->filled_date)->format('Y/m/d') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center" dir="ltr">{{ verta($oil->created_at) }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="flex justify-center">
                            <div id="qrcode" class=""></div>
                        </div>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 50,
            height: 50
        });
        qrcode.makeCode("{{ request()->url() }}");
    </script>

</body>

</html>
