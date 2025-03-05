<div class="px-32 py-4 " dir="rtl">

    @if ($guest->currentGate?->entered_at && $guest->currentGate?->exit_at)
        <span class="text-4xl font-medium text-center my-2  block text-red-700">@lang('Barcode is expired')</span>
    @endif

    @if (!$guest->registered_at->isToday())
        <span class="text-4xl font-medium text-center my-2  block text-red-700">@lang('Barcode is expired')</span>
    @endif

    @if ($guest->EnterGate && auth()->user()->gate->level == 1)
        <span
            class="text-4xl font-medium text-center my-2  block text-red-700">@lang('Barcode is expired for enter from any main gates')</span>
    @endif


    <table class="bg-white bg-opacity-90 w-full rtl:text-right border border-gray-300">

        <tr class="bg-blue-300">
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-4xl text-center text-gray-800 font-semibold " colspan="4">
                د ملي دفاع وزارت د ورځنیو ميلمنو نوملړ</td>
        </tr>
        <tr class="border-b border-gray-300">
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-4xl text-center font-semibold border border-gray-300"
                colspan="2">د ميلمه
                پېژند پاڼه</td>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-4xl text-center font-semibold border border-gray-300"
                colspan="2">د کوربه
                پېژند پاڼه
            </td>
        </tr>
        <tr class="border-b border-gray-300">
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">نوم او تخلص:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border border-gray-300">
                {{ $guest->name }} {{ $guest->last_name }}
            </td>
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">بلونکې اداره:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">{{ $guest->host->department?->fa_name }}
            </td>
        </tr>


        <tr class="border-b border-gray-300">

            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">اضافي معلومات:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                {{ $guest->career }}
            </td>
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">بلونکی شخص:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">
                {{ $guest->host->head_name }}
            </td>
        </tr>


        <tr class="border-b border-gray-300">
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">د راتلونېټه:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                {{ $guest->jalali_come_date }}
            </td>
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">دنده:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">{{ $guest->host->job }}</td>
        </tr>


        <tr class="border-b border-gray-300">
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">د راتلو وخت:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                {{ $guest->jalali_come_time }}
            </td>

            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">ادرس:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">{{ $guest->host->address }}
            </td>
        </tr>
        <tr class="border-b border-gray-300">
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">د راتلو دروازه:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                {{ $guest->gate?->name }}
            </td>
            <td></td>
            <td></td>
        </tr>

        <tr class="border-b border-gray-300">
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl">د ملاقات/مجلس ځای:</th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl border-l border-r border-gray-300">
                {{ $guest->address }}
            </td>
            <th></th>
            <td></td>
        </tr>

        <tr class="border-b border-gray-300">
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-4xl pr-6  border-l border-r border-gray-300" colspan="2">
                <span>پاملرنه:</span>
                <div class="mr-14">
                    @foreach ($guest->Guestoptions as $option)
                        <div class="mx-3">
                            <p class="text-green-600 font-semibold text-xl">{{ $option->name }}
                            </p>
                        </div>
                    @endforeach
                </div>

            </th>
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl"></th>
            <td scope="col" class="lg:px-6 sm:px-1 py-2 text-3xl"></td>
        </tr>
        <tr>
            <th scope="col" class="lg:px-6 sm:px-1 py-2 text-4xl pr-6  border-l border-r border-gray-300" colspan="4">
                <span>@lang('Remark') : </span>
                <div class="mr-28">
                    <div class="mx-3 text-green-600 font-semibold text-xl ">
                        {!! $guest->remark !!}
                    </div>
                </div>
            </th>
        </tr>
    </table>


    @if (!in_array($guest->host->department_id, \Sq\Query\Policy\UserDepartment::getUserDepartment()))
        <div class="text-9xl text-center text-red-500 ">مهمان مربوط این جز تام نیست</div>
    @else
        @if ($guest->registered_at->isToday())
            <div class="flex justify-around mt-10">

                {{-- IF Current Gate is Main Gate And Enter Gate is empty --}}
                @if (auth()->user()->gate->level === 1 && !$guest->EnterGate)
                    @if (!$guest->currentGate?->entered_at)
                        <a href="{{ route('sqguest.guest.check', ['guest' => $guest->id, 'state' => 'enter']) }}"
                            class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-green-600 to-green-500"
                            style="">@lang('Enter')</a>
                    @endif
                @endif

                @if (auth()->user()->gate->level === 1 && $guest->EnterGate)
                    <span
                        class="text-4xl font-medium">@lang('Guest Entered To Ministry', ['name' => $guest->EnterGate->gate->pa_name])</span>
                @endif

                {{-- If The Guest is not Exited from Any Gate And Not Gate --}}


                @if (auth()->user()->gate->level == 1 && $guest->EnterGate && !$guest->ExitGate)

                    @if (!$guest->currentGate?->entered_at)
                        <a href="{{ route('sqguest.guest.check', ['guest' => $guest->id, 'state' => 'enter']) }}"
                            class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-green-600 to-green-500"
                            style="">@lang('Enter')</a>
                    @endif

                    {{-- IF Guest Entered --}}
                    @if ($guest->currentGate?->entered_at)
                        <span class="text-4xl font-medium">@lang('Guest Entered')</span>
                    @endif
                    {{-- If Guest not Exited --}}
                    @if ($guest->currentGate?->entered_at && !$guest->currentGate?->exit_at)
                        <a href="{{ route('sqguest.guest.check', ['guest' => $guest->id, 'state' => 'exit']) }}"
                            class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-red-600 to-red-500"
                            style="">@lang('Exited')</a>
                    @endif

                    @if ($guest->currentGate?->exit_at)
                        <span class="text-4xl  font-medium">@lang('Guest Exited')</span>
                    @endif

                @endif

                {{-- If The Guest is not Exited from Any Gate And Not Gate --}}
                @if (auth()->user()->gate->level === 1 && $guest->ExitGate)
                    <span class="text-4xl font-medium">
                        @lang('Guest Exit To Ministry', ['name' => $guest->ExitGate?->gate->pa_name])
                    </span>
                @endif
            </div>
        @endif
    @endif
</div>
