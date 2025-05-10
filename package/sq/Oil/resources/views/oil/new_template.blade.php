<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه توزیع تیل</title>
    <style>
        /* CSS Reset and Base Styles */
        :root {
            --primary-color: #3b82f6;
            --primary-light: #93c5fd;
            --primary-dark: #1e40af;
            --secondary-color: #f97316;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --text-color: #1e293b;
            --text-light: #64748b;
            --bg-color: #0f172a;
            --bg-gradient: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --border-radius-sm: 0.375rem;
            --border-radius: 0.5rem;
            --border-radius-lg: 0.75rem;
            --border-radius-xl: 1rem;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tahoma', Arial, sans-serif;
        }

        body {
            background: var(--bg-gradient);
            color: var(--text-color);
            line-height: 1.6;
            direction: rtl;
            padding: 1.25rem;
            min-height: 100vh;
            animation: pageLoad 0.5s ease-out forwards;
        }

        /* Typography */
        h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-dark);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Header Section */
        .header {
            height: 4.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
            margin: 0.75rem 0.5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        /* Inputs */
        .input {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: var(--text-color);
            border: 2px solid var(--border-color);
            border-radius: var(--border-radius);
            background-color: #f8fafc;
            transition: var(--transition);
        }

        .input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .input::placeholder {
            color: var(--text-light);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            background: linear-gradient(to right, var(--primary-color), var(--primary-dark));
            border: none;
            border-radius: var(--border-radius-lg);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.35);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(59, 130, 246, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-icon {
            margin-left: 0.5rem;
        }

        /* Cards */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1rem;
            padding: 0.5rem;
            margin-bottom: 2.5rem;
        }

        @media (min-width: 640px) {
            .card-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .card-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .card {
            position: relative;
            background-color: var(--card-bg);
            border-radius: var(--border-radius-lg);
            padding: 1.75rem;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            overflow: hidden;
            z-index: 1;
        }

        .card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            z-index: -1;
            transition: var(--transition);
        }

        .card-diesel {
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .card-diesel::after {
            background: linear-gradient(to right, var(--danger-color), #f43f5e);
        }

        .card-diesel:hover {
            transform: translateY(-5px);
        }

        .card-diesel:hover::after {
            height: 8px;
        }

        .card-petrol {
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .card-petrol::after {
            background: linear-gradient(to right, #10b981, #059669);
        }

        .card-petrol:hover {
            transform: translateY(-5px);
        }

        .card-petrol:hover::after {
            height: 8px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1.35rem;
            font-weight: 600;
        }

        .card-value {
            text-align: right;
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-color);
            margin-top: 0.25rem;
        }

        .card-label {
            display: block;
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 0.25rem;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-top: 1rem;
            width: 100%;
        }

        @media (min-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr 2fr;
            }
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-input-group {
            display: flex;
            position: relative;
            margin-bottom: 1.5rem;
        }

        .submit-btn {
            height: 100%;
            padding: 0 1.25rem;
            font-size: 1.5rem;
            font-weight: 600;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 3.5rem;
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
            z-index: -1;
            transition: var(--transition);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.5);
        }

        .submit-btn:hover::before {
            background: linear-gradient(45deg, var(--primary-dark), var(--primary-color));
        }

        .submit-btn:active {
            transform: translateY(1px);
            box-shadow: 0 2px 6px rgba(59, 130, 246, 0.4);
        }

        .submit-btn::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(255, 255, 255, 0.2), transparent);
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .submit-btn:hover::after {
            opacity: 1;
        }

        /* Submit button pulse animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        /* Tables */
        .table-container {
            background-color: var(--card-bg);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            border: 1px solid var(--border-color);
        }

        .table-container:hover {
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
            font-size: 0.95rem;
        }

        .table th,
        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            background-color: #f8fafc;
        }

        .table-header {
            border-bottom: 2px solid var(--primary-color);
            font-weight: 600;
            font-size: 1rem;
            color: var(--primary-dark);
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .employee-table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        .employee-table th,
        .employee-table td {
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
        }

        .employee-table th {
            text-align: center;
            background-color: #f8fafc;
            color: var(--primary-dark);
        }

        .employee-info-header {
            font-size: 1.75rem;
            text-align: center;
            padding: 1rem;
            background: linear-gradient(to right, #f1f5f9, #e2e8f0);
            color: var(--primary-dark);
            border-bottom: 2px solid var(--primary-color);
        }

        .employee-attribute {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .employee-value {
            font-size: 1.1rem;
            font-weight: 500;
        }

        .photo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0.5rem;
        }

        .employee-photo {
            height: 150px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: 3px solid white;
            transition: var(--transition);
        }

        .employee-photo:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        /* Icon Styles */
        .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .icon-diesel {
            color: white;
            background: linear-gradient(135deg, var(--danger-color), #f43f5e);
            box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3);
        }

        .icon-petrol {
            color: white;
            background: linear-gradient(135deg, var(--success-color), #059669);
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.3);
        }

        /* Additions for Pump Station */
        .pump-station-info {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--primary-dark);
            margin-top: 0.5rem;
        }

        .pump-station-info::before {
            content: '⛽';
            margin-left: 0.5rem;
            font-size: 1.25rem;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.5rem;
            margin: 1rem 0;
            border-radius: var(--border-radius);
            display: none;
            position: fixed;
            top: 1.5rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 100;
            animation: slideDown 0.3s ease-out forwards;
            box-shadow: var(--shadow);
            max-width: 90%;
            width: 500px;
            text-align: center;
        }

        @keyframes slideDown {
            from {
                transform: translate(-50%, -20px);
                opacity: 0;
            }
            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }

        .alert-error {
            background-color: #fee2e2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #15803d;
            border-left: 4px solid #22c55e;
        }

        /* Section Title */
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50%;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), transparent);
            border-radius: 3px;
        }

        /* Enhancements for table data */
        .oil-amount {
            font-weight: 600;
            color: var(--primary-dark);
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: #f1f5f9;
            border-radius: var(--border-radius-sm);
        }

        .oil-remain {
            font-weight: 600;
            color: var(--success-color);
        }

        .oil-consumed {
            font-weight: 600;
            color: var(--danger-color);
        }

        .data-highlight {
            font-weight: 600;
            position: relative;
            z-index: 1;
            display: inline-block;
        }

        .data-highlight::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 25%;
            background-color: rgba(147, 197, 253, 0.3);
            z-index: -1;
            border-radius: 2px;
        }

        /* Fancy animation for table rows */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table tbody tr {
            animation: fadeIn 0.3s ease-out forwards;
            opacity: 0;
        }

        .table tbody tr:nth-child(1) { animation-delay: 0.1s; }
        .table tbody tr:nth-child(2) { animation-delay: 0.2s; }
        .table tbody tr:nth-child(3) { animation-delay: 0.3s; }
        .table tbody tr:nth-child(4) { animation-delay: 0.4s; }
        .table tbody tr:nth-child(5) { animation-delay: 0.5s; }

        /* Page transition */
        @keyframes pageLoad {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Empty state styling */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--text-light);
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state-text {
            font-size: 1.1rem;
        }

        /* Pump Station Statistics Styles */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
            margin: 1rem 0 2rem;
        }

        .stat-card {
            padding: 1rem;
            display: flex;
            align-items: center;
            transition: var(--transition);
            border-radius: var(--border-radius-lg);
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            background: linear-gradient(135deg, #64748b, #475569);
            padding: 0.75rem;
            border-radius: 50%;
            color: white;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
        }

        .stat-info {
            flex: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 0.25rem;
        }

        .stat-value {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        .status-active {
            color: var(--success-color);
            font-weight: 600;
        }

        .status-inactive {
            color: var(--danger-color);
            font-weight: 600;
        }

        /* 404 Page Styles */
        .error-container {
            text-align: center;
            padding: 3rem 1rem;
            margin-top: 2rem;
            color: white;
            animation: fadeIn 0.5s ease-out forwards;
        }

        .error-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .error-title {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: white;
        }

        .error-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .error-action {
            margin-top: 2rem;
        }

        .error-action .btn {
            padding: 0.75rem 2rem;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <form action="">
            <input name="code" autofocus type="text" dir="ltr" class="input" placeholder="کد کارمند را وارد کنید" required />
        </form>
        <h1>{{ config('app.name') }}</h1>
        <a href="/" class="btn">
            صفحه اصلی
        </a>
    </div>

    <!-- Pump Station Statistics Section -->
    @if (isset($pumpStats) && $pumpStats)
        <h2 class="section-title">آمار پمپ استیشن</h2>

        <!-- Pump Info Card -->
        <div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(to right, rgba(255,255,255,0.9), rgba(255,255,255,0.97));">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <div class="icon" style="background: linear-gradient(135deg, #8b5cf6, #6366f1); color: white; width: 4rem; height: 4rem; font-size: 2rem;">🏢</div>
                </div>
                <div style="flex: 1; padding: 0 1.5rem;">
                    <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem; color: var(--primary-dark);">{{ $pumpStats['name'] }}</h3>
                    <p style="font-size: 1.1rem; color: var(--text-light); margin: 0;">
                        <span>موقعیت:</span>
                        <span style="font-weight: 500;">{{ $pumpStats['location'] ?: '---' }}</span>
                    </p>
                    <p style="font-size: 1.1rem; color: var(--text-light); margin: 0;">
                        <span>ظرفیت:</span>
                        <span style="font-weight: 500;">{{ $pumpStats['capacity'] ?: 0 }} لیتر</span>
                    </p>
                </div>
                <div>
                    <div style="padding: 0.5rem 1rem; border-radius: var(--border-radius);
                        {{ $pumpStats['is_active'] ? 'background-color: #dcfce7; color: #15803d;' : 'background-color: #fee2e2; color: #b91c1c;' }}
                        font-weight: 600; text-align: center;">
                        {{ $pumpStats['is_active'] ? 'فعال' : 'غیرفعال' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Oil Balance Section -->
        <div style="margin-bottom: 2rem;">
            <h3 style="color: white; font-size: 1.35rem; margin-bottom: 1rem; opacity: 0.9;">موجودی تیل فعلی</h3>
            <div class="card-grid">
                <div class="card">
                    <div class="icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white;">📊</div>
                    <span class="card-label">مجموع باقیمانده</span>
                    <p class="card-value">
                        <span class="data-highlight">{{ $pumpStats['remaining_total'] }} لیتر</span>
                    </p>
                    <span class="card-label">پر شده / توزیع شده</span>
                    <p class="card-value" style="font-size: 0.9rem;">
                        <span style="color: var(--success-color);">{{ $pumpStats['total_income'] }} لیتر</span> /
                        <span style="color: var(--danger-color);">{{ $pumpStats['total_distributed'] }} لیتر</span>
                    </p>
                </div>
                <div class="card card-diesel">
                    <div class="icon icon-diesel">⛽</div>
                    <span class="card-label">دیزل باقیمانده</span>
                    <p class="card-value">
                        <span class="data-highlight">{{ $pumpStats['remaining_diesel'] }} لیتر</span>
                    </p>
                    <span class="card-label">پر شده / توزیع شده</span>
                    <p class="card-value" style="font-size: 0.9rem;">
                        <span style="color: var(--success-color);">{{ $pumpStats['total_diesel_income'] }} لیتر</span> /
                        <span style="color: var(--danger-color);">{{ $pumpStats['total_diesel_distributed'] }} لیتر</span>
                    </p>
                </div>
                <div class="card card-petrol">
                    <div class="icon icon-petrol">⛽</div>
                    <span class="card-label">پطرول باقیمانده</span>
                    <p class="card-value">
                        <span class="data-highlight">{{ $pumpStats['remaining_petrol'] }} لیتر</span>
                    </p>
                    <span class="card-label">پر شده / توزیع شده</span>
                    <p class="card-value" style="font-size: 0.9rem;">
                        <span style="color: var(--success-color);">{{ $pumpStats['total_petrol_income'] }} لیتر</span> /
                        <span style="color: var(--danger-color);">{{ $pumpStats['total_petrol_distributed'] }} لیتر</span>
                    </p>
                </div>
                <div class="card">
                    <div class="icon" style="background: linear-gradient(135deg, #0891b2, #0e7490); color: white;">📅</div>
                    <span class="card-label">این ماه</span>
                    <p class="card-value">
                        <span class="data-highlight">{{ $pumpStats['current_month_distributed'] }} لیتر</span> استفاده شده
                    </p>
                    <span class="card-label">ورودی این ماه</span>
                    <p class="card-value">
                        <span style="color: var(--success-color);">{{ $pumpStats['current_month_income'] }} لیتر</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <h3 style="color: white; font-size: 1.35rem; margin-bottom: 1rem; opacity: 0.9;">فعالیت توزیع</h3>
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <span style="font-size: 1.25rem;">👥</span>
                </div>
                <div class="stat-info">
                    <span class="stat-label">کاربران سرویس گرفته</span>
                    <p class="stat-value">
                        <span class="data-highlight">{{ $pumpStats['users_served'] }}</span>
                    </p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <span style="font-size: 1.25rem;">🔄</span>
                </div>
                <div class="stat-info">
                    <span class="stat-label">تعداد توزیع</span>
                    <p class="stat-value">
                        <span class="data-highlight">{{ $pumpStats['distribution_count'] }}</span>
                    </p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <span style="font-size: 1.25rem;">📊</span>
                </div>
                <div class="stat-info">
                    <span class="stat-label">دیزل این ماه</span>
                    <p class="stat-value">
                        <span class="data-highlight">{{ $pumpStats['current_month_diesel_distributed'] }} لیتر</span>
                    </p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <span style="font-size: 1.25rem;">📊</span>
                </div>
                <div class="stat-info">
                    <span class="stat-label">پطرول این ماه</span>
                    <p class="stat-value">
                        <span class="data-highlight">{{ $pumpStats['current_month_petrol_distributed'] }} لیتر</span>
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Employee Information Section -->
    @if ($employee)
        <h2 class="section-title">معلومات کارمند</h2>
        <div class="content-grid">
            <div>
                <form action="{{ route('sq.oil.oil.store', ['cardInfo' => $employee->id]) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="form-input-group">
                        <input type="text" id="amount" name="amount" class="input" placeholder="مقدار تیل را به لیتر وارد کنید" required />
                        <button type="submit" class="submit-btn" style="animation: pulse 2s infinite;">
                            <span style="display: inline-block; transform: scale(1.2);">+</span>
                        </button>
                    </div>
                </form>

                <div class="table-container">
                    <table class="table">
                        <tr>
                            <th class="table-header">تاریخ</th>
                            <th class="table-header">مقدار</th>
                        </tr>
                        @forelse ($employee->current_month_oil_disterbutions as $oil)
                            <tr>
                                <td>{{ $oil->filled_date ? verta($oil->filled_date)->format('Y/m/d') : '' }}</td>
                                <td><span class="oil-amount">{{ $oil->oil_amount }} لیتر</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="empty-state">
                                    <div class="empty-state-icon">📊</div>
                                    <p class="empty-state-text">هیچ سابقه توزیع تیل برای این ماه یافت نشد</p>
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>

            <div>
                <div class="table-container">
                    <table class="employee-table">
                        <tr>
                            <th colspan="5" class="employee-info-header">
                                د کارمند مشخصات
                            </th>
                        </tr>
                        <tr>
                            <th class="employee-attribute">ثبت ګنه:</th>
                            <td>
                                <p class="employee-value">{{ $employee->registare_no }}</p>
                            </td>
                            <td rowspan="6" class="photo-container">
                                <img class="employee-photo" src="{{ asset("storage/{$employee->photo}") }}" alt="{{ $employee->full_name }}" />
                            </td>
                        </tr>
                        <tr>
                            <th class="employee-attribute">نوم او تخلص:</th>
                            <td>
                                <p class="employee-value">{{ $employee->full_name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="employee-attribute">د پلارنوم:</th>
                            <td>
                                <p class="employee-value">{{ $employee->father_name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="employee-attribute">دنده:</th>
                            <td>
                                <p class="employee-value">{{ $employee->job_structure }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="employee-attribute">اروند اداره:</th>
                            <td>
                                <p class="employee-value">{{ $employee->orginization?->fa_name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="employee-attribute">پمپ استیشن:</th>
                            <td>
                                <p class="pump-station-info">{{ $employee->pumpStation?->name ?? '---' }}</p>
                            </td>
                        </tr>
                        <tr>
                            <th class="employee-attribute">نوع تیل</th>
                            <td>
                                @if($employee->oil_type && $employee->oil_type == \Vehical\OilType::Diesel)
                                    <span style="color: #ef4444; font-weight: 600;">دیزل</span>
                                @elseif($employee->oil_type && $employee->oil_type == \Vehical\OilType::Petrole)
                                    <span style="color: #10b981; font-weight: 600;">پطرول</span>
                                @else
                                    ---
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="employee-attribute">مقدار ماهانه</th>
                            <td>
                                <span class="data-highlight">{{ $employee->monthly_rate }} لیتر</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="employee-attribute">مقدار مصرف</th>
                            <td>
                                <span class="oil-consumed">{{ $employee->current_month_oil_consumtion }} لیتر</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="employee-attribute">باقیمانده</th>
                            <td>
                                <span class="oil-remain">{{ $employee->current_month_oil_remain }} لیتر</span>
                            </td>
                        </tr>
                    </table>

                    <table class="employee-table" style="margin-top: 1rem;">
                        <tr>
                            <th colspan="6" class="employee-info-header">
                                کارت وسیله نقلیه کارمند
                            </th>
                        </tr>
                        <tr>
                            <th>پلیت وسیله</th>
                            <th>رنگ وسیله</th>
                            <th>شاسی وسیله</th>
                            <th>مدل وسیله</th>
                            <th>راننده</th>
                            <th>ملاحظات</th>
                        </tr>
                        @forelse ($employee->employee_vehical_card as $vehical)
                            <tr>
                                <td><span class="data-highlight">{{ $vehical?->vehical_palete }}</span></td>
                                <td>{{ $vehical?->vehical_colour }}</td>
                                <td>{{ $vehical?->vehical_chassis }}</td>
                                <td>{{ $vehical?->vehical_model }}</td>
                                <td>
                                    <a href="{{ route('sqemployee.employee.check.card', ['code' => $vehical?->driver?->registare_no]) }}"
                                       style="color: var(--primary-color); text-decoration: none; font-weight: 600;">
                                        {{ $vehical?->driver?->full_name }}
                                    </a>
                                </td>
                                <td>{!! $vehical?->remark !!}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <div class="empty-state-icon">🚗</div>
                                    <p class="empty-state-text">هیچ سابقه وسیله نقلیه یافت نشد</p>
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state" style="margin-top: 3rem; color: white;">
            <div class="empty-state-icon">👤</div>
            <p class="empty-state-text">کد کارمند را برای مشاهده جزئیات وارد کنید</p>
        </div>
    @endif

    <!-- 404 Display for no pump station -->
    @if (isset($noAccessReason) && $noAccessReason === 'no_pump_station')
    <div class="error-container">
        <div class="error-icon">⛽</div>
        <h1 class="error-title">پمپ استیشن تعیین نشده است</h1>
        <p class="error-message">این کارمند دارای پمپ استیشن تعیین شده نیست. لطفا با مدیر سیستم برای تعیین پمپ استیشن تماس بگیرید.</p>
        <div class="error-action">
            <a href="/" class="btn">بازگشت به صفحه اصلی</a>
        </div>
    </div>
    @endif

    <!-- Alert Messages -->
    <div id="error-alert" class="alert alert-error"></div>
    <div id="success-alert" class="alert alert-success"></div>

    <script>
        // Pure JavaScript for alert messages
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('error'))
                const errorAlert = document.getElementById('error-alert');
                errorAlert.textContent = "{{ session('error') }}";
                errorAlert.style.display = 'block';
                setTimeout(() => {
                    errorAlert.style.opacity = '0';
                    setTimeout(() => {
                        errorAlert.style.display = 'none';
                    }, 300);
                }, 5000);
            @endif

            @if(session('success'))
                const successAlert = document.getElementById('success-alert');
                successAlert.textContent = "{{ session('success') }}";
                successAlert.style.display = 'block';
                setTimeout(() => {
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.style.display = 'none';
                    }, 300);
                }, 5000);
            @endif
        });
    </script>
</body>

</html>
