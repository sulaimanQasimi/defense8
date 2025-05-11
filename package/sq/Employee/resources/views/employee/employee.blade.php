@php
    $date1 = \Carbon\Carbon::make(\Alkoumi\LaravelHijriDate\Hijri::Date('Y-m-d'));

    // Create a \Carbon\Carbon instance from the card's expiration date
    $date2 = ($employee->current_id_card?->card_expired_date) ? \Carbon\Carbon::make($employee->current_id_card?->card_expired_date) : null;
    $state = false;
    if ($date2) {
        $state = $date1->gt($date2);
    }

@endphp

<style>
    .employee-container {
        margin-top: 1rem;
        direction: rtl;
    }

    .employee-card {
        margin-top: 1.25rem;
        border: 4px solid white;
        border-radius: 0.5rem;
        padding: 1.25rem;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    }

    .grid-layout {
        display: grid;
        gap: 0.5rem;
    }

    @media (min-width: 768px) {
        .grid-layout {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 767px) {
        .grid-layout {
            grid-template-columns: 1fr;
        }
    }

    .rightside {
        background-color: #f3f4f6;
        padding: 1rem;
        border-radius: 0.5rem;
        border: 1px solid white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .table-container {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #d1d5db;
    }

    .table-container th, .table-container td {
        border: 1px solid #4b5563;
    }

    .table-header {
        padding: 0.75rem 1rem;
        text-align: center;
        font-size: 2.25rem;
    }

    .table-cell-heading {
        padding: 0.25rem 1rem;
        font-size: 1.25rem;
    }

    .table-cell-data {
        padding: 0.25rem 1.5rem;
    }

    .table-cell-text {
        font-weight: 500;
        line-height: 1;
        color: #374151;
        margin-right: 0.5rem;
        font-size: 1.25rem;
    }

    .expired-text {
        color: #b91c1c;
    }

    .conditions-container {
        text-align: right;
        background: linear-gradient(to right, #fef3c7, #fbbf24);
        padding: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .conditions-title {
        color: #ef4444;
        font-weight: bold;
    }

    .condition-item {
        color: #2563eb;
        font-size: 1.25rem;
    }

    .leftside {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .profile-image {
        height: 400px;
        border-radius: 0.5rem;
        display: block;
    }

    .invalid-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .invalid-title {
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
        text-align: center;
    }

    .invalid-subtitle {
        color: white;
        font-size: 1.25rem;
        font-weight: bold;
        text-align: center;
    }

    .no-cursor {
        cursor: not-allowed;
        grid-column: span 3;
    }

    .alert-box {
        display: flex;
        align-items: center;
        padding: 1rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: #991b1b;
        border-radius: 0.5rem;
        background-color: #fee2e2;
    }

    .alert-title {
        font-size: 1.25rem;
        border-left: 2px solid #7f1d1d;
        padding-left: 0.5rem;
        margin-left: 0.75rem;
        font-weight: bold;
    }

    .alert-content {
        font-size: 1.25rem;
        font-weight: 500;
    }

    .info-footer {
        border-radius: 0.375rem;
        text-align: center;
        font-size: 1.125rem;
        margin-top: 1rem;
        background-color: #f9fafb;
        width: 100%;
        grid-column: span 3;
    }
</style>

<div class="employee-container">
    <div class="employee-card grid-layout">
        <div class="rightside">
            <table class="table-container">
                <thead>
                    <tr>
                        <th scope="col" class="table-header" colspan="5">
                            د کارمند مشخصات
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            ثبت ګنه:
                        </th>
                        <td class="table-cell-data">
                            <p class="table-cell-text">
                                {{ $employee->registare_no }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            نوم او تخلص:
                        </th>
                        <td class="table-cell-data">
                            <p class="table-cell-text">
                                {{ $employee->name }}
                                {{ $employee->last_name }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            د پلارنوم:
                        </th>
                        <td class="table-cell-heading">
                            <p class="table-cell-text">
                                {{ $employee->father_name }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            دنده:
                        </th>
                        <td class="table-cell-heading">
                            <p class="table-cell-text">
                                {{ $employee->job_structure }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            @lang('Category')
                        </th>
                        <td class="table-cell-heading">
                            <p class="table-cell-text">
                                {{ $employee->category }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            پیل نیته:
                        </th>
                        <td class="table-cell-heading">
                            <p class="table-cell-text">
                                {{ ($employee->current_id_card?->card_perform) ? \Carbon\Carbon::make($employee->current_id_card?->card_perform)->format("Y/m/d") : 'ندارد' }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            ختمیدو نیته:
                        </th>
                        <td class="table-cell-heading">
                            <p class="table-cell-text {{ $state ? 'expired-text' : '' }}">
                                {{ ($employee->current_id_card?->card_expired_date) ? \Carbon\Carbon::make($employee->current_id_card?->card_expired_date)->format("Y/m/d") : 'ندارد' }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            اروند اداره:
                        </th>
                        <td class="table-cell-heading">
                            <p class="table-cell-text">
                                {{ $employee->orginization?->fa_name }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            اروند دروازه:
                        </th>
                        <td class="table-cell-heading">
                            <p class="table-cell-text">
                                {{ $employee->gate?->fa_name }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            حاضری امروز:
                        </th>
                        <td class="table-cell-heading">
                            <p class="table-cell-text">
                                {{ trans(
    match ($attendance?->state) {
        'U' => 'Upsent',
        'P' => 'Present',
        default => 'حاضری نداده است',
    },
) }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            {{ (is_null($employee->orginization->start) || $employee->orginization->start == "") ? (new \App\Settings\AttendanceTimer())->start : $employee->orginization->start}}
                        </th>
                        <th scope="col" class="table-cell-heading">
                            {{ (is_null($employee->orginization->end) || $employee->orginization->end == "") ? (new \App\Settings\AttendanceTimer())->end : $employee->orginization->end}}
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            {{ $attendance?->enter ? verta($attendance->enter)->format('Y/m/d h:i') : '' }}
                        </th>
                        <th scope="col" class="table-cell-heading">
                            {{ $attendance?->exit ? verta($attendance?->exit)->format('Y/m/d h:i') : '' }}
                        </th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="conditions-container">
            <div class="conditions-title">شرایط:</div>
            @foreach ($employee->employeeOptions as $option)
                <div class="condition-item">{{ $option->name }}</div>
            @endforeach
        </div>

        <div class="leftside">
            <img class="profile-image" src="{{ asset("storage/{$employee->photo}") }}" />

            @if($state)
                <div class="invalid-card-overlay">
                    <h1 class="invalid-title">این کارت باطل است</h1>
                    <h1 class="invalid-title">این شخص اجازه داخل شدن را ندارد</h1>
                    <h4 class="invalid-subtitle">لطفاً این کارت را از شخص مذکور بگيريد و به شماره 0202660424 تماس بگیرید.</h4>
                </div>
            @endif
        </div>

        <div class="no-cursor">
            <div class="alert-box" role="alert">
                <span class="alert-title">پاملرنه</span>
                <div>
                    <span class="alert-content">{!! $employee->remark !!}</span>
                </div>
            </div>
        </div>

        <div class="info-footer">
            <h2>جهت معلومات بیشتر به این شماره به تماس شوید 2660788</h2>
        </div>
    </div>

    @include('sqemployee::employee.gun_card')
    @include('sqemployee::employee.employee_vehical')
</div>
