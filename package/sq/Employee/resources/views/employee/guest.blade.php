<style>
    .guest-container {
        padding: 1.5rem 8rem;
        direction: rtl;
        font-family: 'persian-font', Arial, sans-serif;
    }

    .expired-message {
        font-size: 2rem;
        font-weight: 500;
        text-align: center;
        margin: 0.5rem 0;
        display: block;
        color: #dc2626;
    }

    .guest-table {
        width: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        text-align: right;
        border: 1px solid #d1d5db;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(to right, #93c5fd, #60a5fa);
    }

    .table-header td {
        padding: 0.75rem 1.5rem;
        font-size: 1.75rem;
        text-align: center;
        color: #1e3a8a;
        font-weight: 600;
    }

    .section-header {
        text-align: center;
        font-weight: 600;
        font-size: 1.75rem;
        border: 1px solid #d1d5db;
        background-color: #f3f4f6;
    }

    .guest-table th {
        padding: 0.5rem 1.5rem;
        font-size: 1.5rem;
        text-align: right;
        vertical-align: middle;
        background-color: #f9fafb;
        font-weight: 600;
    }

    .guest-table td {
        padding: 0.5rem 1.5rem;
        font-size: 1.5rem;
        border-left: 1px solid #d1d5db;
        vertical-align: middle;
    }

    .guest-table tr {
        border-bottom: 1px solid #d1d5db;
    }

    .guest-table tr:last-child {
        border-bottom: none;
    }

    .notice-row span {
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .notice-container {
        margin-right: 3.5rem;
    }

    .notice-item {
        margin: 0 0.75rem;
    }

    .notice-text {
        color: #047857;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .not-belong-message {
        font-size: 4.5rem;
        text-align: center;
        color: #dc2626;
        margin: 2rem 0;
    }

    .actions-container {
        display: flex;
        justify-content: space-around;
        margin-top: 2.5rem;
    }

    .btn {
        padding: 0.5rem 1.75rem;
        border-radius: 0.5rem;
        color: white;
        text-decoration: none;
        font-weight: 500;
        font-size: 1.25rem;
        transition: transform 0.2s ease;
    }

    .btn:hover {
        transform: scale(0.95);
    }

    .btn-enter {
        background: linear-gradient(to top, #16a34a, #22c55e);
    }

    .btn-exit {
        background: linear-gradient(to top, #dc2626, #ef4444);
    }

    .status-message {
        font-size: 1.75rem;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .guest-container {
            padding: 1rem 1rem;
        }

        .table-header td, .section-header {
            font-size: 1.5rem;
            padding: 0.5rem 0.25rem;
        }

        .guest-table th, .guest-table td {
            padding: 0.5rem 0.25rem;
            font-size: 1.25rem;
        }
    }
</style>

<div class="guest-container">

    @if ($guest->currentGate?->entered_at && $guest->currentGate?->exit_at)
        <span class="expired-message">@lang('Barcode is expired')</span>
    @endif

    @if (!$guest->registered_at->isToday())
        <span class="expired-message">@lang('Barcode is expired')</span>
    @endif

    @if ($guest->EnterGate && auth()->user()->gate->level == 1)
        <span class="expired-message">@lang('Barcode is expired for enter from any main gates')</span>
    @endif

    <table class="guest-table">
        <tr class="table-header">
            <td colspan="4">د ملي دفاع وزارت د ورځنیو ميلمنو نوملړ</td>
        </tr>
        <tr>
            <td class="section-header" colspan="2">د ميلمه پېژند پاڼه</td>
            <td class="section-header" colspan="2">د کوربه پېژند پاڼه</td>
        </tr>
        <tr>
            <th>نوم او تخلص:</th>
            <td>{{ $guest->name }} {{ $guest->last_name }}</td>
            <th>بلونکې اداره:</th>
            <td>{{ $guest->host->department?->fa_name }}</td>
        </tr>
        <tr>
            <th>اضافي معلومات:</th>
            <td>{{ $guest->career }}</td>
            <th>بلونکی شخص:</th>
            <td>{{ $guest->host->head_name }}</td>
        </tr>
        <tr>
            <th>د راتلونېټه:</th>
            <td>{{ $guest->jalali_come_date }}</td>
            <th>دنده:</th>
            <td>{{ $guest->host->job }}</td>
        </tr>
        <tr>
            <th>د راتلو وخت:</th>
            <td>{{ $guest->jalali_come_time }}</td>
            <th>ادرس:</th>
            <td>{{ $guest->host->address }}</td>
        </tr>
        <tr>
            <th>د راتلو دروازه:</th>
            <td>{{ $guest->gate?->name }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <th>د ملاقات/مجلس ځای:</th>
            <td>{{ $guest->address }}</td>
            <th></th>
            <td></td>
        </tr>
        <tr class="notice-row">
            <th colspan="2">
                <span>پاملرنه:</span>
                <div class="notice-container">
                    @foreach ($guest->Guestoptions as $option)
                        <div class="notice-item">
                            <p class="notice-text">{{ $option->name }}</p>
                        </div>
                    @endforeach
                </div>
            </th>
            <th></th>
            <td></td>
        </tr>
        <tr class="notice-row">
            <th colspan="4">
                <span>@lang('Remark') : </span>
                <div class="notice-container">
                    <div class="notice-item">
                        <div class="notice-text">{!! $guest->remark !!}</div>
                    </div>
                </div>
            </th>
        </tr>
    </table>

    @if (!in_array($guest->host->department_id, \Sq\Query\Policy\UserDepartment::getUserDepartment()))
        <div class="not-belong-message">مهمان مربوط این جز تام نیست</div>
    @else
        @if ($guest->registered_at->isToday())
            <div class="actions-container">
                {{-- IF Current Gate is Main Gate And Enter Gate is empty --}}
                @if (auth()->user()->gate->level === 1 && !$guest->EnterGate)
                    @if (!$guest->currentGate?->entered_at)
                        <a href="{{ route('sqguest.guest.check', ['guest' => $guest->id, 'state' => 'enter']) }}"
                            class="btn btn-enter">@lang('Enter')</a>
                    @endif
                @endif

                @if (auth()->user()->gate->level === 1 && $guest->EnterGate)
                    <span class="status-message">@lang('Guest Entered To Ministry', ['name' => $guest->EnterGate->gate->pa_name])</span>
                @endif

                {{-- If The Guest is not Exited from Any Gate And Not Gate --}}
                @if (auth()->user()->gate->level == 1 && $guest->EnterGate && !$guest->ExitGate)
                    @if (!$guest->currentGate?->entered_at)
                        <a href="{{ route('sqguest.guest.check', ['guest' => $guest->id, 'state' => 'enter']) }}"
                            class="btn btn-enter">@lang('Enter')</a>
                    @endif

                    {{-- IF Guest Entered --}}
                    @if ($guest->currentGate?->entered_at)
                        <span class="status-message">@lang('Guest Entered')</span>
                    @endif

                    {{-- If Guest not Exited --}}
                    @if ($guest->currentGate?->entered_at && !$guest->currentGate?->exit_at)
                        <a href="{{ route('sqguest.guest.check', ['guest' => $guest->id, 'state' => 'exit']) }}"
                            class="btn btn-exit">@lang('Exited')</a>
                    @endif

                    @if ($guest->currentGate?->exit_at)
                        <span class="status-message">@lang('Guest Exited')</span>
                    @endif
                @endif

                {{-- If The Guest is not Exited from Any Gate And Not Gate --}}
                @if (auth()->user()->gate->level === 1 && $guest->ExitGate)
                    <span class="status-message">
                        @lang('Guest Exit To Ministry', ['name' => $guest->ExitGate?->gate->pa_name])
                    </span>
                @endif
            </div>
        @endif
    @endif
</div>
