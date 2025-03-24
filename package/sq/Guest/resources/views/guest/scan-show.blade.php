<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('Patient Information')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @font-face {
            font-family: 'persian-font';
            src: url('{{ asset('fonts/IRANSans.ttf') }}') format('truetype');
        }
        body {
            font-family: 'persian-font', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 text-white px-6 py-4">
                <h1 class="text-xl font-bold text-center">@lang('Patient Information')</h1>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient Basic Info -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('Name'):</span>
                            <span class="text-gray-600">{{ $patient->name }}</span>
                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('Last Name'):</span>
                            <span class="text-gray-600">{{ $patient->last_name }}</span>
                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('Phone'):</span>
                            <span class="text-gray-600">{{ $patient->phone }}</span>
                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('Blood Type'):</span>
                            <span class="text-gray-600">{{ $patient->blood_type }}</span>
                        </div>
                    </div>

                    <!-- Medical Info -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('Department'):</span>
                            <span class="text-gray-600">{{ $patient->host->department?->fa_name }}</span>
                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('Doctor'):</span>
                            <span class="text-gray-600">{{ $patient->doctor_name }}</span>
                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('Status'):</span>
                            <span class="text-gray-600">{{ $patient->status }}</span>
                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('Registered At'):</span>
                            <span class="text-gray-600">{{ \Verta::instance($patient->registered_at)->format('Y/m/d H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="mt-8 text-center">
                    <div id="qrcode" class="mx-auto inline-block"></div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-center space-x-4 space-x-reverse">
                    <form action="{{ route('guest.patients.deactivate', $patient) }}" method="POST" class="inline">
                        @csrf
                        @method('POST')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition duration-200">
                            @lang('Deactivate Patient')
                        </button>
                    </form>
                    <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        @lang('Print')
                    </button>
                    <a href="{{ route('guest.patients.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        @lang('Back')
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{ asset('qrcode/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('qrcode/qrcode.js') }}"></script>
    <script type="text/javascript">
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 128,
            height: 128,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
        qrcode.makeCode("{{ $url }}");
    </script>
</body>
</html>
