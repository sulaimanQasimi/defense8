<div class="container mx-auto px-4 py-8" dir="rtl">
    @if($patient->status === 'inactive')
        <div class="max-w-2xl mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">خطا!</strong>
            <span class="block sm:inline">این توکن باطل شده شما اجازه ورود ندارید</span>
        </div>
    @else
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 text-white px-6 py-4">
                <h1 class="text-xl font-bold text-center">@lang('معلومات مریض')</h1>
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
                            <span class="font-bold text-gray-700">@lang('بخش'):</span>
                            <span class="text-gray-600">{{ $patient->department }}</span>
                        </div>
                    </div>

                    <!-- Medical Info -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('Department'):</span>
                            <span class="text-gray-600">{{ $patient->host->department?->fa_name }}</span>
                        </div>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="font-bold text-gray-700">@lang('داکتر'):</span>
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
                <form action="{{ route('sqguest.guest.patients.deactivate', $patient) }}" method="POST" class="inline">
                    @csrf
                    @method('POST')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        @lang('داخل شد')
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
