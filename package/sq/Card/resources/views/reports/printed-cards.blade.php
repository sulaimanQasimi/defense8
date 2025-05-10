<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>گزارش کارت‌های چاپ شده</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-light: #edf2ff;
            --primary-dark: #3a56d4;
            --secondary-color: #ef476f;
            --accent-color: #06d6a0;
            --text-color: #2b2d42;
            --text-light: #8d99ae;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --border-radius: 12px;
            --border-radius-sm: 6px;
            --box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05), 0 6px 6px rgba(0, 0, 0, 0.03);
            --transition: all 0.3s ease;
            --font-family: Tahoma, Arial, sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-family);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.7;
            padding: 20px;
            direction: rtl;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            margin-bottom: 30px;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 24px 30px;
            position: relative;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .card-header h1 {
            font-size: 26px;
            margin: 0;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .header-subtitle {
            font-size: 16px;
            margin-top: 8px;
            opacity: 0.9;
            font-weight: 300;
        }

        .card-body {
            padding: 35px;
        }

        .filter-form {
            background: linear-gradient(to right, var(--primary-light) 0%, rgba(237, 242, 255, 0.7) 100%);
            border-radius: var(--border-radius);
            padding: 24px 30px;
            margin-bottom: 35px;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 24px;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(67, 97, 238, 0.1);
        }

        .form-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        label {
            font-weight: 600;
            color: var(--primary-dark);
            font-size: 15px;
        }

        select {
            padding: 12px 16px;
            border: 1px solid rgba(67, 97, 238, 0.2);
            border-radius: var(--border-radius-sm);
            background-color: white;
            min-width: 130px;
            outline: none;
            transition: var(--transition);
            font-family: var(--font-family);
            font-size: 15px;
            color: var(--text-color);
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%234361ee' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: left 12px center;
            padding-left: 36px;
        }

        .month-select {
            font-weight: 500;
            width: 110px;
            text-align: center;
        }

        select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        button {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 6px rgba(67, 97, 238, 0.2);
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(67, 97, 238, 0.25);
        }

        button:active {
            transform: translateY(0);
        }

        .table-container {
            overflow-x: auto;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(0,0,0,0.05);
            background-color: white;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: right;
        }

        thead {
            background: linear-gradient(to right, var(--primary-light) 0%, rgba(237, 242, 255, 0.7) 100%);
        }

        th {
            padding: 16px 20px;
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid rgba(67, 97, 238, 0.2);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-size: 15px;
            color: var(--text-color);
        }

        tbody tr {
            transition: var(--transition);
        }

        tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .empty-message {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
            font-style: italic;
            font-size: 16px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 14px;
            background: linear-gradient(to right, var(--primary-light) 0%, rgba(237, 242, 255, 0.7) 100%);
            color: var(--primary-dark);
            border-radius: 20px;
            font-size: 15px;
            font-weight: 600;
            min-width: 50px;
            border: 1px solid rgba(67, 97, 238, 0.15);
            box-shadow: 0 2px 4px rgba(67, 97, 238, 0.1);
        }

        .department-name {
            font-weight: 600;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .department-name::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: var(--primary-color);
            border-radius: 50%;
        }

        .total-row {
            background: linear-gradient(to right, var(--primary-light) 0%, rgba(237, 242, 255, 0.7) 100%);
            font-weight: bold;
        }

        .total-row td {
            border-top: 2px solid rgba(67, 97, 238, 0.2);
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 16px;
            color: var(--primary-dark);
        }

        .total-row .badge {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            font-size: 16px;
            padding: 8px 16px;
        }

        /* Filter button icon */
        button::after {
            content: '';
            display: inline-block;
            width: 18px;
            height: 18px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cline x1='21' y1='4' x2='3' y2='4'%3E%3C/line%3E%3Cline x1='17' y1='12' x2='7' y2='12'%3E%3C/line%3E%3Cline x1='13' y1='20' x2='11' y2='20'%3E%3C/line%3E%3Cline x1='12' y1='20' x2='12' y2='20'%3E%3C/line%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 20px;
            }

            .filter-form {
                flex-direction: column;
                align-items: stretch;
                padding: 20px;
            }

            .form-group {
                justify-content: space-between;
            }

            button {
                width: 100%;
            }

            th, td {
                padding: 12px 15px;
            }

            .header-subtitle {
                font-size: 14px;
            }

            .card-header h1 {
                font-size: 22px;
            }
        }

        /* Animation for loading */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-container {
            animation: fadeIn 0.5s ease-out;
        }

        tbody tr {
            animation: fadeIn 0.5s ease-out;
            animation-fill-mode: both;
        }

        tbody tr:nth-child(1) { animation-delay: 0.1s; }
        tbody tr:nth-child(2) { animation-delay: 0.15s; }
        tbody tr:nth-child(3) { animation-delay: 0.2s; }
        tbody tr:nth-child(4) { animation-delay: 0.25s; }
        tbody tr:nth-child(5) { animation-delay: 0.3s; }
        tbody tr:nth-child(6) { animation-delay: 0.35s; }
        tbody tr:nth-child(7) { animation-delay: 0.4s; }
        tbody tr:nth-child(8) { animation-delay: 0.45s; }
        tbody tr:nth-child(9) { animation-delay: 0.5s; }
        tbody tr:nth-child(10) { animation-delay: 0.55s; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>گزارش کارت‌های چاپ شده</h1>
                <div class="header-subtitle">
                    {{ $months[$month] ?? '' }} {{ $year }}
                </div>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('sq.card.reports.printed') }}" class="filter-form">
                    <div class="form-group">
                        <label for="month">ماه:</label>
                        <select name="month" id="month" class="month-select">
                            @foreach($months as $key => $value)
                                <option value="{{ $key }}" {{ $key == $month ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="year">سال:</label>
                        <select name="year" id="year">
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit">اعمال فیلتر</button>
                </form>

                <!-- Report Table -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>نام اداره</th>
                                <th>تعداد کارت‌های چاپ شده</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalCards = 0; @endphp
                            @forelse($report as $department => $count)
                                @php $totalCards += $count; @endphp
                                <tr>
                                    <td><span class="department-name">{{ $department }}</span></td>
                                    <td><span class="badge">{{ $count }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="empty-message">
                                        هیچ داده‌ای برای نمایش وجود ندارد
                                    </td>
                                </tr>
                            @endforelse
                            @if(count($report) > 0)
                                <tr class="total-row">
                                    <td>مجموع</td>
                                    <td><span class="badge">{{ $totalCards }}</span></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
