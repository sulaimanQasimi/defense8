<style>
    /* Core styles */
    .patient-container {
        min-height: 100vh;
        background: linear-gradient(to right, #f9e4f0, #e8e4fc, #e0ebff);
        padding: 3rem 0;
        direction: rtl;
        font-family: 'persian-font', Arial, sans-serif;
    }

    /* Alert styles */
    .error-alert {
        max-width: 48rem;
        margin: 0 auto;
        background-color: #fef2f2;
        border-left: 4px solid #ef4444;
        color: #b91c1c;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    .alert-content {
        display: flex;
        align-items: center;
    }

    .alert-icon {
        flex-shrink: 0;
    }

    .alert-icon svg {
        height: 1.5rem;
        width: 1.5rem;
        color: #ef4444;
    }

    .alert-message {
        margin-left: 0.75rem;
    }

    .alert-text {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .alert-text strong {
        font-weight: 700;
    }

    /* Card styles */
    .patient-card {
        max-width: 64rem;
        margin: 0 auto;
        background-color: white;
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        transition: all 0.3s;
        border: 1px solid #e9d5ff;
    }

    .patient-card:hover {
        box-shadow: 0 35px 60px -15px rgba(0, 0, 0, 0.3);
    }

    /* Header styles */
    .card-header {
        background: linear-gradient(to right, #ec4899, #a855f7, #6366f1);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .header-circle-1 {
        position: absolute;
        top: -3rem;
        right: -3rem;
        width: 10rem;
        height: 10rem;
        background-color: white;
        opacity: 0.1;
        border-radius: 50%;
    }

    .header-circle-2 {
        position: absolute;
        bottom: -3rem;
        left: -3rem;
        width: 10rem;
        height: 10rem;
        background-color: white;
        opacity: 0.1;
        border-radius: 50%;
    }

    .header-content {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header-icon {
        height: 2.5rem;
        width: 2.5rem;
        margin-right: 1rem;
        color: #f9a8d4;
    }

    .header-title {
        font-size: 1.875rem;
        font-weight: 700;
        text-align: center;
    }

    /* Content styles */
    .card-content {
        padding: 2rem;
        background: linear-gradient(to bottom, white, #f5f3ff);
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    @media (min-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    /* Info panels */
    .info-panel {
        padding: 1.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid;
        transform: translateY(0);
        transition: all 0.3s;
    }

    .info-panel:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.15);
    }

    .personal-info {
        background: linear-gradient(to bottom right, #eff6ff, #e0e7ff);
        border-color: #bfdbfe;
    }

    .medical-info {
        background: linear-gradient(to bottom right, #fdf2f8, #f5f3ff);
        border-color: #fbcfe8;
    }

    .panel-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .panel-icon {
        height: 1.5rem;
        width: 1.5rem;
        margin-right: 0.5rem;
    }

    .personal-icon {
        color: #3b82f6;
    }

    .medical-icon {
        color: #ec4899;
    }

    .panel-title {
        font-size: 1.25rem;
        font-weight: 600;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid;
    }

    .personal-title {
        color: #1e40af;
        border-color: #93c5fd;
    }

    .medical-title {
        color: #be185d;
        border-color: #f9a8d4;
    }

    /* Info rows */
    .info-row {
        display: flex;
        align-items: center;
        background-color: white;
        padding: 0.75rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .row-icon {
        height: 1.25rem;
        width: 1.25rem;
        margin-right: 0.75rem;
    }

    .personal-row-icon {
        color: #3b82f6;
    }

    .medical-row-icon {
        color: #ec4899;
    }

    .row-label {
        font-weight: 700;
        min-width: 6rem;
        margin-right: 0.75rem;
    }

    .personal-label {
        color: #1e40af;
    }

    .medical-label {
        color: #be185d;
    }

    .row-value {
        color: #374151;
        font-weight: 500;
    }

    /* Status badges */
    .status-badge {
        padding: 0.375rem 1rem;
        font-size: 0.875rem;
        font-weight: 700;
        border-radius: 9999px;
    }

    .status-expired {
        background-color: #fee2e2;
        color: #991b1b;
        border: 2px solid #fecaca;
    }

    .status-active {
        background-color: #dcfce7;
        color: #166534;
        border: 2px solid #bbf7d0;
    }

    .status-inactive {
        background-color: #fee2e2;
        color: #991b1b;
        border: 2px solid #fecaca;
    }

    /* Action buttons */
    .action-container {
        margin-top: 2rem;
        text-align: center;
    }

    .action-row {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        font-weight: 700;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 9999px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
        overflow: hidden;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .btn:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.5);
    }

    .btn-enter {
        background: linear-gradient(to right, #ec4899, #8b5cf6, #6366f1);
    }

    .btn-exit {
        background: linear-gradient(to right, #f97316, #f59e0b, #eab308);
    }

    .btn-shine {
        position: absolute;
        right: 0;
        width: 3rem;
        height: 100%;
        background-color: white;
        opacity: 0.1;
        transform: skewX(-12deg);
        transition: transform 0.7s;
    }

    .btn:hover .btn-shine {
        transform: translateX(12rem) skewX(-12deg);
    }

    .btn-icon {
        height: 1.5rem;
        width: 1.5rem;
        margin-right: 0.5rem;
    }

    /* Notification boxes */
    .notification {
        padding: 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .notification-icon {
        height: 1.5rem;
        width: 1.5rem;
        margin-right: 0.5rem;
    }

    .notification-warning {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }

    .notification-error {
        background-color: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #b91c1c;
    }

    .notification-warning .notification-icon {
        color: #f59e0b;
    }

    .notification-error .notification-icon {
        color: #ef4444;
    }
</style>

<div class="patient-container">
    @if($patient->status === 'inactive' || ($patient->ended_at && $patient->ended_at < now()))
        <div class="error-alert">
            <div class="alert-content">
                <div class="alert-icon">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="alert-message">
                    <p class="alert-text">
                        <strong>خطا!</strong>
                        <span class="mr-2">
                            @if($patient->ended_at && $patient->ended_at < now())
                                این توکن منقضی شده است
                            @else
                                این توکن باطل شده شما اجازه ورود ندارید
                            @endif
                        </span>
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="patient-card">
            <div class="card-header">
                <div class="header-circle-1"></div>
                <div class="header-circle-2"></div>
                <div class="header-content">
                    <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h1 class="header-title">اطلاعات بیمار</h1>
                </div>
            </div>

            <div class="card-content">
                <div class="content-grid">
                    <!-- Personal Information Panel -->
                    <div class="info-panel personal-info">
                        <div class="panel-header">
                            <svg class="panel-icon personal-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <h2 class="panel-title personal-title">اطلاعات شخصی</h2>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon personal-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="row-label personal-label">نام:</div>
                            <div class="row-value">{{ $patient->name }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon personal-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                            <div class="row-label personal-label">نام خانوادگی:</div>
                            <div class="row-value">{{ $patient->lastname }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon personal-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <div class="row-label personal-label">شماره تماس:</div>
                            <div class="row-value">{{ $patient->phone }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon personal-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="row-label personal-label">کد ملی:</div>
                            <div class="row-value">{{ $patient->national_code }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon personal-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="row-label personal-label">تاریخ تولد:</div>
                            <div class="row-value">{{ $patient->dob }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon personal-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="row-label personal-label">وضعیت:</div>
                            <div class="row-value">
                                <span class="status-badge @if($patient->ended_at && $patient->ended_at < now()) status-expired @elseif($patient->status === 'active') status-active @else status-inactive @endif">
                                    @if($patient->ended_at && $patient->ended_at < now())
                                        منقضی شده
                                    @elseif($patient->status === 'active')
                                        فعال
                                    @else
                                        غیرفعال
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Information Panel -->
                    <div class="info-panel medical-info">
                        <div class="panel-header">
                            <svg class="panel-icon medical-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            <h2 class="panel-title medical-title">اطلاعات پزشکی</h2>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon medical-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <div class="row-label medical-label">بخش:</div>
                            <div class="row-value">{{ $patient->department->name ?? 'بدون بخش' }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon medical-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="row-label medical-label">دکتر:</div>
                            <div class="row-value">{{ $patient->doctor->name ?? 'نامشخص' }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon medical-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            <div class="row-label medical-label">شماره توکن:</div>
                            <div class="row-value">{{ $patient->token }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon medical-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="row-label medical-label">تاریخ شروع:</div>
                            <div class="row-value">{{ $patient->started_at }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon medical-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="row-label medical-label">تاریخ پایان:</div>
                            <div class="row-value">{{ $patient->ended_at ?? 'نامحدود' }}</div>
                        </div>

                        <div class="info-row">
                            <svg class="row-icon medical-row-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <div class="row-label medical-label">آخرین بازدید:</div>
                            <div class="row-value">{{ $patient->lastVisit ? $patient->lastVisit->created_at : 'بدون بازدید' }}</div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    @endif
</div>
