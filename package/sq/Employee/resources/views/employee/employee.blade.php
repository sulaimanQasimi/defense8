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
        margin-top: 1.5rem;
        direction: rtl;
        font-family: 'persian-font', Arial, sans-serif;
    }

    .employee-card {
        margin-top: 1.5rem;
        border: 4px solid white;
        border-radius: 1rem;
        padding: 1.5rem;
        background: linear-gradient(145deg, #f0f4ff, #ffffff);
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2),
                    0 8px 10px -6px rgba(59, 130, 246, 0.1);
        transition: transform 0.3s ease;
    }

    .grid-layout {
        display: grid;
        gap: 1rem;
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
        background: linear-gradient(to bottom right, #f9fafb, #f3f4f6);
        padding: 1.25rem;
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease-in-out;
    }

    .rightside:hover {
        transform: translateY(-3px);
    }

    .table-container {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #d1d5db;
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .table-container th, .table-container td {
        border: 1px solid #e5e7eb;
    }

    .table-header {
        padding: 1rem;
        text-align: center;
        font-size: 2.25rem;
        background: linear-gradient(to right, #4f46e5, #6366f1);
        color: white;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .table-cell-heading {
        padding: 0.5rem 1rem;
        font-size: 1.25rem;
        background-color: #eef2ff;
        color: #4338ca;
    }

    .table-cell-data {
        padding: 0.5rem 1.5rem;
        background-color: white;
    }

    .table-cell-text {
        font-weight: 500;
        line-height: 1.3;
        color: #1f2937;
        margin-right: 0.5rem;
        font-size: 1.25rem;
    }

    .expired-text {
        color: #dc2626;
        font-weight: bold;
    }

    .conditions-container {
        text-align: right;
        background: linear-gradient(135deg, #fef3c7, #fbbf24);
        padding: 1.25rem;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.15);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease-in-out;
    }

    .conditions-container:hover {
        transform: translateY(-3px);
    }

    .conditions-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top right, rgba(255,255,255,0.3), transparent 70%);
        pointer-events: none;
    }

    .conditions-title {
        color: #b91c1c;
        font-weight: bold;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
        border-bottom: 2px solid rgba(220, 38, 38, 0.3);
        padding-bottom: 0.5rem;
    }

    .condition-item {
        color: #1e40af;
        font-size: 1.25rem;
        padding: 0.35rem 0;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
    }

    .condition-item:last-child {
        border-bottom: none;
    }

    .leftside {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease-in-out;
    }

    .leftside:hover {
        transform: translateY(-3px);
    }

    .profile-image {
        height: 400px;
        width: 100%;
        object-fit: cover;
        border-radius: 0.75rem;
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
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(220, 38, 38, 0.7));
        backdrop-filter: blur(2px);
    }

    .invalid-title {
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
        text-align: center;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }

    .invalid-subtitle {
        color: white;
        font-size: 1.25rem;
        font-weight: bold;
        text-align: center;
        max-width: 80%;
        line-height: 1.5;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }

    .no-cursor {
        cursor: not-allowed;
        grid-column: span 3;
    }

    .alert-box {
        display: flex;
        align-items: center;
        padding: 1.25rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: #991b1b;
        border-radius: 0.75rem;
        background-color: #fee2e2;
        box-shadow: 0 4px 6px rgba(252, 165, 165, 0.2);
        border-left: 4px solid #ef4444;
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
        line-height: 1.5;
    }

    .info-footer {
        border-radius: 0.5rem;
        text-align: center;
        font-size: 1.125rem;
        margin-top: 1.5rem;
        background: linear-gradient(to right, #f1f5f9, #e2e8f0);
        width: 100%;
        grid-column: span 3;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
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
                        <td class="table-cell-data">
                            <p class="table-cell-text">
                                {{ $employee->father_name }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            دنده:
                        </th>
                        <td class="table-cell-data">
                            <p class="table-cell-text">
                                {{ $employee->job_structure }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            @lang('Category')
                        </th>
                        <td class="table-cell-data">
                            <p class="table-cell-text">
                                {{ $employee->category }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            پیل نیته:
                        </th>
                        <td class="table-cell-data">
                            <p class="table-cell-text">
                                {{ ($employee->current_id_card?->card_perform) ? \Carbon\Carbon::make($employee->current_id_card?->card_perform)->format("Y/m/d") : 'ندارد' }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            ختمیدو نیته:
                        </th>
                        <td class="table-cell-data">
                            <p class="table-cell-text {{ $state ? 'expired-text' : '' }}">
                                {{ ($employee->current_id_card?->card_expired_date) ? \Carbon\Carbon::make($employee->current_id_card?->card_expired_date)->format("Y/m/d") : 'ندارد' }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            اروند اداره:
                        </th>
                        <td class="table-cell-data">
                            <p class="table-cell-text">
                                {{ $employee->orginization?->fa_name }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            اروند دروازه:
                        </th>
                        <td class="table-cell-data">
                            <p class="table-cell-text">
                                {{ $employee->gate?->fa_name }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="table-cell-heading">
                            حاضری امروز:
                        </th>
                        <td class="table-cell-data">
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
