<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - {{ __('وارد کردن کارمند') }}</title>

    <style>
        @font-face {
            font-family: "persian-font";
            src: url("/mod_font.ttf") format("truetype");
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'persian-font', Arial, sans-serif;
            background: linear-gradient(to bottom, #ebf3ff, #dae8ff);
            padding: 20px;
            direction: rtl;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            background: linear-gradient(to right, #6c64ff, #0095ff);
            color: white;
            padding: 15px;
            border-radius: 8px;
        }

        .instructions {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-right: 4px solid #0095ff;
        }

        .photo-instructions {
            background-color: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-right: 4px solid #4caf50;
        }

        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select, input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        button {
            background: linear-gradient(to top, #22c55e, #16a34a);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: transform 0.2s;
        }

        button:hover {
            transform: scale(0.98);
        }

        .btn-download {
            background: linear-gradient(to top, #5046e5, #6366f1);
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            transition: transform 0.2s;
        }

        .btn-download:hover {
            transform: scale(0.98);
        }

        .steps {
            padding-right: 20px;
        }

        .steps li {
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ __('وارد کردن اطلاعات کارمند') }}</h1>

        <div class="instructions">
            <p>{{ __('برای وارد کردن یک کارمند، لطفاً مراحل زیر را دنبال کنید:') }}</p>
            <ol class="steps">
                <li>{{ __('قالب را با استفاده از دکمه زیر دانلود کنید') }}</li>
                <li>{{ __('اطلاعات کارمند را در ستون مقدار پر کنید') }}</li>
                <li>{{ __('فایل تکمیل شده را آپلود کنید و دیپارتمان را انتخاب کنید') }}</li>
                <li>{{ __('برای اضافه کردن کارمند به سیستم روی دکمه وارد کردن کلیک کنید') }}</li>
            </ol>
        </div>

        <div class="alert alert-warning" style="background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404; margin-bottom: 20px; padding: 15px; border-radius: 5px;">
            <strong>{{ __('توجه:') }}</strong> {{ __('در قالب جدید، فیلدهای مجزای استان، شهرستان و روستا حذف شده‌اند. لطفاً از فیلدهای آدرس کامل (متنی) استفاده کنید و آدرس را به صورت متنی وارد نمایید.') }}
        </div>

        <div class="photo-instructions" style="margin-bottom: 20px; border: 2px solid #4472C4; padding: 15px; background-color: #EAF1FB; border-radius: 5px;">
            <p style="font-weight: bold; color: #4472C4; font-size: 16px; margin-bottom: 10px;">{{ __('نحوه افزودن عکس در فایل اکسل:') }}</p>
            <ol class="steps" style="padding-right: 20px; line-height: 1.7">
                <li>{{ __('در فایل اکسل، سلول آبی رنگ با عنوان "اینجا عکس را درج کنید" را پیدا کنید') }}</li>
                <li>{{ __('روی این سلول کلیک کنید') }}</li>
                <li>{{ __('از منوی بالا، گزینه Insert یا درج را انتخاب کنید') }}</li>
                <li>{{ __('روی گزینه Pictures یا تصویر کلیک کنید') }}</li>
                <li>{{ __('گزینه This Device یا از این دستگاه را انتخاب کنید') }}</li>
                <li>{{ __('عکس مورد نظر را از کامپیوتر خود انتخاب کنید و روی Insert کلیک کنید') }}</li>
                <li>{{ __('اکنون عکس در سلول قرار گرفته و هنگام آپلود فایل اکسل، به طور خودکار استخراج می‌شود') }}</li>
            </ol>
            <p style="font-weight: bold; color: #FF6347; margin-top: 10px;">{{ __('مهم: عکس حتماً باید در سلول آبی رنگ قرار گیرد تا سیستم بتواند آن را شناسایی کند!') }}</p>
        </div>

        <a href="{{ route('sqemployee.employee.import.template') }}" class="btn-download">
            {{ __('دانلود قالب') }}
        </a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('errors'))
            <div class="alert alert-danger">
                <ul>
                    @foreach(session('errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="importForm" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="department">{{ __('دیپارتمان') }}</label>
                <select id="department" name="department" required>
                    <option value="">{{ __('انتخاب دیپارتمان') }}</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="gateGroup" style="display: none;">
                <label for="gate_id">{{ __('گیت') }}</label>
                <select id="gate_id" name="gate_id">
                    <option value="">{{ __('انتخاب گیت (اختیاری)') }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="import_file">{{ __('فایل اکسل حاوی اطلاعات کارمند') }}</label>
                <input type="file" id="import_file" name="import_file" accept=".xlsx,.xls" required>
                <p style="font-size: 0.8rem; color: #666;">{{ __('فقط فرمت‌های xlsx و xls پشتیبانی می‌شوند.') }}</p>
            </div>

            <div class="form-group">
                <label for="photo_file">{{ __('عکس کارمند (اختیاری)') }}</label>
                <input type="file" id="photo_file" name="photo_file" accept="image/*">
                <p style="font-size: 0.8rem; color: #666;">{{ __('می‌توانید عکس را مستقیماً در فایل اکسل درج کنید یا از این طریق آپلود کنید.') }}</p>
            </div>

            <button type="submit">{{ __('وارد کردن کارمند') }}</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('importForm');
            const departmentSelect = document.getElementById('department');
            const gateSelect = document.getElementById('gate_id');
            const gateGroup = document.getElementById('gateGroup');

            // Update form action when department changes
            departmentSelect.addEventListener('change', function() {
                const departmentId = this.value;
                if (departmentId) {
                    form.action = "{{ route('sqemployee.employee.import.store', ['department' => ':id']) }}".replace(':id', departmentId);
                    
                    // Load gates for selected department
                    fetch("{{ url('sq/modules/employee/employee/import/department') }}/" + departmentId + "/gates")
                        .then(response => response.json())
                        .then(data => {
                            // Clear previous options
                            gateSelect.innerHTML = '<option value="">{{ __("انتخاب گیت (اختیاری)") }}</option>';
                            
                            // Add gates from response
                            if (data.gates && data.gates.length > 0) {
                                data.gates.forEach(gate => {
                                    const option = document.createElement('option');
                                    option.value = gate.id;
                                    option.textContent = gate.name;
                                    gateSelect.appendChild(option);
                                });
                                
                                // Show the gate selection
                                gateGroup.style.display = 'block';
                            } else {
                                gateGroup.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error loading gates:', error);
                            gateGroup.style.display = 'none';
                        });
                } else {
                    gateGroup.style.display = 'none';
                }
            });

            // Handle form submission
            form.addEventListener('submit', function(e) {
                const departmentId = departmentSelect.value;

                if (!departmentId) {
                    e.preventDefault();
                    alert('{{ __("لطفاً یک دیپارتمان را انتخاب کنید") }}');
                    return false;
                }
            });
        });
    </script>
</body>

</html>
