<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - شناسایی اثر انگشت</title>

    <!-- Custom CSS without external dependencies -->
    <style>
        /* Persian Font - Vazir (embed via base64 or reference locally) */
        @font-face {
            font-family: Vazir;
            src: url('{{ asset('fonts/Vazir.eot') }}');
            src: url('{{ asset('fonts/Vazir.eot?#iefix') }}') format('embedded-opentype'),
                 url('{{ asset('fonts/Vazir.woff2') }}') format('woff2'),
                 url('{{ asset('fonts/Vazir.woff') }}') format('woff'),
                 url('{{ asset('fonts/Vazir.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* Reset and base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Vazir', tahoma, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            text-align: right;
            direction: rtl;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
        }

        .col-md-12 {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0 15px;
        }

        .mt-5 {
            margin-top: 3rem;
        }

        .mt-4 {
            margin-top: 2.5rem;
        }

        .mt-3 {
            margin-top: 1.5rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        .mb-2 {
            margin-bottom: 1rem;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mr-1 {
            margin-right: 0.25rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }

        .w-100 {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-primary {
            color: #007bff;
        }

        .text-success {
            color: #28a745;
        }

        .text-warning {
            color: #ffc107;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-muted {
            color: #6c757d;
        }

        .p-2 {
            padding: 0.5rem;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: all 0.15s ease-in-out;
            text-decoration: none;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border: 1px solid #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border: 1px solid #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            border-top-left-radius: 0.5rem !important;
            border-top-right-radius: 0.5rem !important;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
        }

        .bg-primary {
            background-color: #007bff !important;
        }

        .text-white {
            color: #fff !important;
        }

        .alert {
            position: relative;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }

        .form-check {
            position: relative;
            display: block;
            padding-left: 1.25rem;
        }

        .form-check-input {
            position: absolute;
            margin-top: 0.3rem;
            margin-left: -1.25rem;
        }

        .form-check-label {
            margin-bottom: 0;
        }

        .progress {
            display: flex;
            height: 1rem;
            overflow: hidden;
            font-size: 0.75rem;
            background-color: #e9ecef;
            border-radius: 0.25rem;
        }

        .progress-bar {
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            background-color: #007bff;
            transition: width 0.6s ease;
        }

        .progress-bar-striped {
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
            background-size: 1rem 1rem;
        }

        .progress-bar-animated {
            animation: progress-bar-stripes 1s linear infinite;
        }

        @keyframes progress-bar-stripes {
            from { background-position: 1rem 0; }
            to { background-position: 0 0; }
        }

        .bg-info {
            background-color: #17a2b8 !important;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .d-flex {
            display: flex !important;
        }

        .justify-content-between {
            justify-content: space-between !important;
        }

        .h-100 {
            height: 100% !important;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table-borderless td,
        .table-borderless th {
            border: 0;
        }

        .employee-card {
            display: none;
            transition: all 0.3s ease;
        }

        .employee-photo {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            margin: 0 auto;
            display: block;
        }

        .employee-photo:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .fingerprint-area {
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .pulse {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 15px rgba(0, 123, 255, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
            }
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Employee details */
        .employee-details {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        /* Icon styles */
        .icon {
            display: inline-block;
            position: relative;
            height: 1em;
            width: 1em;
            vertical-align: middle;
        }

        .icon-fingerprint::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M17.81 4.47c-.08 0-.16-.02-.23-.06C15.66 3.42 14 3 12.01 3c-1.98 0-3.86.47-5.57 1.41-.24.13-.54.04-.68-.2-.13-.24-.04-.55.2-.68C7.82 2.52 9.86 2 12.01 2c2.13 0 3.99.47 6.03 1.52.25.13.34.43.21.67-.09.18-.26.28-.44.28zM3.5 9.72c-.1 0-.2-.03-.29-.09-.23-.16-.28-.47-.12-.7.99-1.4 2.25-2.5 3.75-3.27C9.98 4.04 14 4.03 17.15 5.65c1.5.77 2.76 1.86 3.75 3.25.16.22.11.54-.12.7-.23.16-.54.11-.7-.12-.9-1.26-2.04-2.25-3.39-2.94-2.87-1.47-6.54-1.47-9.4.01-1.36.7-2.5 1.7-3.4 2.96-.08.14-.23.21-.39.21zm6.25 12.07c-.13 0-.26-.05-.35-.15-.87-.87-1.34-1.43-2.01-2.64-.69-1.23-1.05-2.73-1.05-4.34 0-2.97 2.54-5.39 5.66-5.39s5.66 2.42 5.66 5.39c0 .28-.22.5-.5.5s-.5-.22-.5-.5c0-2.42-2.09-4.39-4.66-4.39-2.57 0-4.66 1.97-4.66 4.39 0 1.44.32 2.77.93 3.85.64 1.15 1.08 1.64 1.85 2.42.19.2.19.51 0 .71-.11.1-.24.15-.37.15zm7.17-1.85c-1.19 0-2.24-.3-3.1-.89-1.49-1.01-2.38-2.65-2.38-4.39 0-.28.22-.5.5-.5s.5.22.5.5c0 1.41.72 2.74 1.94 3.56.71.48 1.54.71 2.54.71.24 0 .64-.03 1.04-.1.27-.05.53.13.58.41.05.27-.13.53-.41.58-.57.11-1.07.12-1.21.12zM14.91 22c-.04 0-.09-.01-.13-.02-1.59-.44-2.63-1.03-3.72-2.1-1.4-1.39-2.17-3.24-2.17-5.22 0-1.62 1.38-2.94 3.08-2.94 1.7 0 3.08 1.32 3.08 2.94 0 1.07.93 1.94 2.08 1.94s2.08-.87 2.08-1.94c0-3.77-3.25-6.83-7.25-6.83-2.84 0-5.44 1.58-6.61 4.03-.39.81-.59 1.76-.59 2.8 0 .78.07 2.01.67 3.61.1.26-.03.55-.29.64-.26.1-.55-.04-.64-.29-.49-1.31-.73-2.61-.73-3.96 0-1.2.23-2.29.68-3.24 1.33-2.79 4.28-4.6 7.51-4.6 4.55 0 8.25 3.51 8.25 7.83 0 1.62-1.38 2.94-3.08 2.94s-3.08-1.32-3.08-2.94c0-1.07-.93-1.94-2.08-1.94s-2.08.87-2.08 1.94c0 1.71.66 3.31 1.87 4.51.95.94 1.86 1.46 3.27 1.85.27.07.42.35.35.61-.05.23-.26.38-.47.38z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: contain;
        }

        .icon-search::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236c757d'%3E%3Cpath d='M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: contain;
        }

        .icon-warning::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23ffc107'%3E%3Cpath d='M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: contain;
        }

        .icon-error::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23dc3545'%3E%3Cpath d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: contain;
        }

        .icon-arrow-left::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: contain;
        }

        /* Make responsive */
        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .employee-photo {
                max-width: 150px;
                max-height: 150px;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <span class="icon icon-fingerprint mr-2"></span>اسکن اثر انگشت
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <p>لطفاً انگشت خود را روی اسکنر قرار دهید</p>
                        </div>
                        <div class="fingerprint-area text-center">
                            <div id="fingerprint-status" class="mb-3">
                                <div class="pulse" style="width: 150px; height: 150px; border-radius: 50%; border: 3px solid #007bff; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('images/fingerprint.png') }}" alt="اثر انگشت" style="width: 80px; height: 80px;">
                                </div>
                                <p class="mt-3 text-muted">در انتظار اسکن...</p>
                            </div>

                            <div id="status-message" class="alert alert-warning" style="display: none;">
                                در حال پردازش...
                            </div>

                            <div id="result-message" class="alert alert-success" style="display: none;">
                                اثر انگشت شناسایی شد!
                            </div>

                            <div id="error-message" class="alert alert-danger" style="display: none;">
                                خطا در شناسایی اثر انگشت.
                                        </div>

                            <div id="scan-btn-area">
                                <button id="scan-button" class="btn btn-primary mt-3">
                                    <span id="scan-icon" class="icon icon-fingerprint mr-1"></span>
                                    اسکن اثر انگشت
                                        </button>

                                <button id="reset-button" class="btn btn-secondary mt-3 mr-2" style="display: none;">
                                    شروع مجدد
                                </button>
                                        </div>

                            <div id="device-check" class="text-muted mt-4" style="font-size: 0.9rem;">
                                <div id="device-status">در حال بررسی دستگاه اسکنر...</div>
                                        </div>

                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="debug-mode" value="1">
                                <label class="form-check-label" for="debug-mode">
                                    حالت اشکال‌زدایی
                                </label>
                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                <div id="employee-card" class="card employee-card h-100">
                    <div class="card-header bg-success text-white">
                        اطلاعات کارمند
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img id="employee-photo" src="{{ asset('images/avatar-placeholder.png') }}" alt="تصویر کارمند" class="employee-photo mb-3">
                            <h4 id="employee-name" class="mb-0"></h4>
                            <p id="employee-position" class="text-muted"></p>
                                        </div>

                        <div class="employee-details p-3">
                                                <table class="table table-borderless">
                                                    <tr>
                                    <th style="width: 120px;">کد کارمندی:</th>
                                    <td id="employee-id"></td>
                                                    </tr>
                                                    <tr>
                                    <th>ایمیل:</th>
                                    <td id="employee-email"></td>
                                                    </tr>
                                                    <tr>
                                    <th>تلفن:</th>
                                    <td id="employee-phone"></td>
                                                    </tr>
                                                    <tr>
                                    <th>بخش:</th>
                                    <td id="employee-department"></td>
                                                    </tr>
                                                </table>
                                            </div>

                        <div class="text-center mt-4">
                            <a href="#" id="employee-details-link" class="btn btn-primary">مشاهده جزئیات کامل</a>
                            <button id="attendance-button" class="btn btn-success mr-2">ثبت حضور</button>
                                        </div>
                                            </div>
                                        </div>

                <div id="no-match-card" class="card employee-card h-100" style="display: none;">
                    <div class="card-header bg-warning text-dark">
                        <span class="icon icon-warning mr-2"></span>
                        عدم تطابق اثر انگشت
                                            </div>
                    <div class="card-body text-center">
                        <img src="{{ asset('images/no-match.png') }}" alt="عدم تطابق" style="width: 150px; margin: 2rem 0;">
                        <h4>کارمندی با این اثر انگشت یافت نشد</h4>
                        <p class="text-muted mt-3">
                            اثر انگشت ارائه شده با هیچ کارمندی در سیستم مطابقت ندارد. لطفا دوباره تلاش کنید یا با مدیر سیستم تماس بگیرید.
                        </p>

                        <div class="mt-4">
                            <button id="try-again-button" class="btn btn-primary">
                                تلاش مجدد
                            </button>
                                </div>
                            </div>
                        </div>

                <div id="debug-card" class="card mt-3" style="display: none;">
                    <div class="card-header bg-info text-white">
                        اطلاعات اشکال‌زدایی
                                </div>
                    <div class="card-body">
                        <div id="debug-output" style="font-family: monospace; font-size: 12px; white-space: pre-wrap;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pure JavaScript implementation without external dependencies -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const scanButton = document.getElementById('scan-button');
            const resetButton = document.getElementById('reset-button');
            const tryAgainButton = document.getElementById('try-again-button');
            const attendanceButton = document.getElementById('attendance-button');
            const debugMode = document.getElementById('debug-mode');
            const debugCard = document.getElementById('debug-card');
            const debugOutput = document.getElementById('debug-output');
            const employeeCard = document.getElementById('employee-card');
            const noMatchCard = document.getElementById('no-match-card');
            const statusMessage = document.getElementById('status-message');
            const resultMessage = document.getElementById('result-message');
            const errorMessage = document.getElementById('error-message');
            const deviceStatus = document.getElementById('device-status');

            // Employee information fields
            const employeePhoto = document.getElementById('employee-photo');
            const employeeName = document.getElementById('employee-name');
            const employeePosition = document.getElementById('employee-position');
            const employeeId = document.getElementById('employee-id');
            const employeeEmail = document.getElementById('employee-email');
            const employeePhone = document.getElementById('employee-phone');
            const employeeDepartment = document.getElementById('employee-department');
            const employeeDetailsLink = document.getElementById('employee-details-link');

            // Check device status (simulated)
            setTimeout(() => {
                deviceStatus.textContent = 'دستگاه اسکنر متصل است و آماده استفاده می‌باشد.';
                deviceStatus.style.color = '#28a745';
            }, 1500);

            // Debug mode toggle
            debugMode.addEventListener('change', function() {
                debugCard.style.display = this.checked ? 'block' : 'none';
                if (this.checked) {
                    log('حالت اشکال‌زدایی فعال شد');
                }
            });

            // Log function for debug output
            function log(message, data = null) {
                if (debugMode.checked) {
                    const timestamp = new Date().toLocaleTimeString();
                    let logMessage = `[${timestamp}] ${message}`;

                    if (data) {
                        if (typeof data === 'object') {
                            logMessage += "\n" + JSON.stringify(data, null, 2);
            } else {
                            logMessage += "\n" + data;
                        }
                    }

                    debugOutput.innerHTML = logMessage + "\n\n" + debugOutput.innerHTML;
                }
            }

            // Reset UI to initial state
            function resetUI() {
                statusMessage.style.display = 'none';
                resultMessage.style.display = 'none';
                errorMessage.style.display = 'none';
                employeeCard.style.display = 'none';
                noMatchCard.style.display = 'none';
                scanButton.style.display = 'inline-block';
                resetButton.style.display = 'none';

                // Reset employee info
                employeePhoto.src = "{{ asset('images/avatar-placeholder.png') }}";
                employeeName.textContent = '';
                employeePosition.textContent = '';
                employeeId.textContent = '';
                employeeEmail.textContent = '';
                employeePhone.textContent = '';
                employeeDepartment.textContent = '';
                employeeDetailsLink.href = '#';

                log('رابط کاربری بازنشانی شد');
            }

            // Show scanning in progress
            function showScanningProgress() {
                scanButton.style.display = 'none';
                statusMessage.style.display = 'block';
                statusMessage.textContent = 'در حال پردازش اثر انگشت...';

                // Add progress bar to status message
                const progressBar = document.createElement('div');
                progressBar.className = 'progress mt-2';
                progressBar.innerHTML = '<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"></div>';
                statusMessage.appendChild(progressBar);

                // Animate progress bar
                const bar = progressBar.querySelector('.progress-bar');
                let width = 0;
                const interval = setInterval(() => {
                    if (width >= 100) {
                        clearInterval(interval);
                    } else {
                        width += 5;
                        bar.style.width = width + '%';
                    }
                }, 150);

                log('شروع اسکن اثر انگشت');

                return {
                    interval: interval,
                    progressBar: progressBar
                };
            }

            // Process fingerprint scan
            function processFingerprint(progressData) {
                // Simulate API call to match fingerprint
                fetch('{{ route("employee.finger-match.api") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        // In a real implementation, you would send the actual fingerprint data
                        // Here we're just simulating with a mock request
                        ISOTemplateBase64: 'MOCK_TEMPLATE_DATA_FOR_TESTING',
                        debug: debugMode.checked,
                        security_level: 2
                    })
                    })
                    .then(response => {
                    clearInterval(progressData.interval);
                    progressData.progressBar.querySelector('.progress-bar').style.width = '100%';

                    if (!response.ok) {
                        throw new Error('خطا در ارتباط با سرور');
                    }
                        return response.json();
                    })
                    .then(data => {
                    log('پاسخ دریافتی از سرور:', data);

                    statusMessage.style.display = 'none';
                    resetButton.style.display = 'inline-block';

                    if (data.success && data.match) {
                        // Show success message and employee card
                        resultMessage.style.display = 'block';
                        employeeCard.style.display = 'flex';

                        // Populate employee information
                                const employee = data.employee;
                        employeeName.textContent = employee.name + ' ' + employee.last_name;
                        employeePosition.textContent = employee.position;
                        employeeId.textContent = employee.id;
                        employeeEmail.textContent = employee.email || 'بدون ایمیل';
                        employeePhone.textContent = employee.phone || 'بدون شماره تلفن';
                        employeeDepartment.textContent = employee.department || 'بدون بخش';

                        if (employee.photo) {
                            employeePhoto.src = employee.photo;
                        }

                        employeeDetailsLink.href = '/employee/card-info/' + employee.id;

                        // Add animation
                        employeeCard.classList.add('fade-in');
                        setTimeout(() => employeeCard.classList.remove('fade-in'), 1000);

                        log('کارمند شناسایی شد:', employee);
                    } else {
                        // Show no match card
                        noMatchCard.style.display = 'flex';
                        noMatchCard.classList.add('fade-in');
                        setTimeout(() => noMatchCard.classList.remove('fade-in'), 1000);

                        log('تطابقی یافت نشد');
                    }
                    })
                    .catch(error => {
                    clearInterval(progressData.interval);
                    statusMessage.style.display = 'none';
                    errorMessage.style.display = 'block';
                    errorMessage.textContent = 'خطا: ' + error.message;
                    resetButton.style.display = 'inline-block';

                    log('خطا در پردازش:', error.message);
                });
            }

            // Handle scan button click
            scanButton.addEventListener('click', function() {
                const progressData = showScanningProgress();

                // Simulate fingerprint scanning delay
                setTimeout(() => {
                    processFingerprint(progressData);
                }, 2000);
            });

            // Handle reset button click
            resetButton.addEventListener('click', resetUI);

            // Handle try again button click
            tryAgainButton.addEventListener('click', resetUI);

            // Handle attendance button click
            attendanceButton.addEventListener('click', function() {
                alert('حضور ثبت شد!');
                log('حضور کارمند ثبت شد');
            });

            // Initialize
            resetUI();
            log('صفحه بارگذاری شد و آماده استفاده است');
        });
    </script>
</body>
</html>
