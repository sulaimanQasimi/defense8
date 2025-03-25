<div class="min-h-screen bg-pink-100 bg-gradient-to-r from-pink-100 via-purple-100 to-indigo-100 py-12" dir="rtl">
    @if($patient->status === 'inactive')
        <div class="max-w-3xl mx-auto bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-lg shadow-sm animate-pulse" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">
                        <strong class="font-bold">خطا!</strong>
                        <span class="mr-2">این توکن باطل شده شما اجازه ورود ندارید</span>
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-2xl border border-purple-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 text-white px-8 py-8 relative overflow-hidden">
                <div class="absolute -right-12 -top-12 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-12 -bottom-12 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                <div class="relative flex items-center justify-center">
                    <svg class="h-10 w-10 mr-4 text-pink-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 005 10a1 1 0 10-2 0c0 3.313 2.686 6 6 6 3.313 0 6-2.687 6-6a1 1 0 10-2 0c0 .686-.108 1.35-.309 1.973A5 5 0 0010 11z" clip-rule="evenodd"/>
                    </svg>
                    <h1 class="text-3xl font-bold text-center">@lang('معلومات مریض')</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8 bg-gradient-to-b from-white to-purple-50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Patient Basic Info -->
                    <div class="space-y-5 bg-gradient-to-br from-blue-50 to-indigo-100 p-6 rounded-2xl shadow-md border border-blue-200 transform transition-all duration-300 hover:scale-105">
                        <div class="flex items-center mb-4">
                            <svg class="h-6 w-6 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            <h2 class="text-xl font-semibold text-blue-700 border-b-2 border-blue-300 pb-2">@lang('معلومات شخصی')</h2>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse bg-white p-3 rounded-lg shadow-sm">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold text-blue-700 min-w-24">@lang('Name'):</span>
                            <span class="text-gray-700 font-medium">{{ $patient->name }}</span>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse bg-white p-3 rounded-lg shadow-sm">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                            <span class="font-bold text-blue-700 min-w-24">@lang('Last Name'):</span>
                            <span class="text-gray-700 font-medium">{{ $patient->last_name }}</span>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse bg-white p-3 rounded-lg shadow-sm">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <span class="font-bold text-blue-700 min-w-24">@lang('Phone'):</span>
                            <span class="text-gray-700 font-medium">{{ $patient->phone }}</span>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse bg-white p-3 rounded-lg shadow-sm">
                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1h-2a1 1 0 01-1-1v-2a1 1 0 00-1-1H7a1 1 0 00-1 1v2a1 1 0 01-1 1H3a1 1 0 01-1-1V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold text-blue-700 min-w-24">@lang('بخش'):</span>
                            <span class="text-gray-700 font-medium">{{ $patient->department }}</span>
                        </div>
                    </div>

                    <!-- Medical Info -->
                    <div class="space-y-5 bg-gradient-to-br from-pink-50 to-purple-100 p-6 rounded-2xl shadow-md border border-pink-200 transform transition-all duration-300 hover:scale-105">
                        <div class="flex items-center mb-4">
                            <svg class="h-6 w-6 text-pink-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                            <h2 class="text-xl font-semibold text-pink-700 border-b-2 border-pink-300 pb-2">@lang('معلومات طبی')</h2>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse bg-white p-3 rounded-lg shadow-sm">
                            <svg class="h-5 w-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                            </svg>
                            <span class="font-bold text-pink-700 min-w-24">@lang('Department'):</span>
                            <span class="text-gray-700 font-medium">{{ $patient->host->department?->fa_name }}</span>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse bg-white p-3 rounded-lg shadow-sm">
                            <svg class="h-5 w-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold text-pink-700 min-w-24">@lang('داکتر'):</span>
                            <span class="text-gray-700 font-medium">{{ $patient->doctor_name }}</span>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse bg-white p-3 rounded-lg shadow-sm">
                            <svg class="h-5 w-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold text-pink-700 min-w-24">@lang('Status'):</span>
                            <span class="px-4 py-1.5 text-sm font-bold rounded-full {{ $patient->status === 'active' ? 'bg-green-100 text-green-800 ring-2 ring-green-300' : 'bg-red-100 text-red-800 ring-2 ring-red-300' }}">
                                {{ $patient->status }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse bg-white p-3 rounded-lg shadow-sm">
                            <svg class="h-5 w-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold text-pink-700 min-w-24">@lang('تاریخ مراجعه'):</span>
                            <span class="text-gray-700 font-medium">{{ \Verta::instance($patient->registered_at)->format('Y/m/d H:i') }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <form action="{{ route('sqguest.guest.patients.deactivate', $patient) }}" method="POST" class="inline">
                        @csrf
                        @method('POST')
                        <button type="submit" class="group relative inline-flex items-center bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 text-white font-bold px-10 py-4 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-purple-500 focus:ring-opacity-50 overflow-hidden">
                            <span class="absolute right-0 w-12 h-full bg-white opacity-10 transform -skew-x-12 transition-transform duration-700 group-hover:translate-x-20"></span>
                            <svg class="h-6 w-6 mr-2 text-pink-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            @lang('داخل شد')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
