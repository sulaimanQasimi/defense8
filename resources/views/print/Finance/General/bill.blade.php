<html dir="rtl">

<head>
    <title>Class Attendance</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/print.css') }}">

</head>

<body>
    <div class="page">
        <div class="university-name">پوهنتون کابل</div>
        <div class="university-name" style="top: 65px;  font-size: 25px;">@lang('Accounting and Administration')</div>
        <div class="university-name" style="top: 100px; font-size: 20px;">@lang($title)</div>
        <img class="university-logo" src="{{asset('logo/university.png')}}" />
        <img class="university-ministry" src="{{asset('logo/ministry.jpg')}}" />
        <div class="" style="height: 30px;"></div>
        <table class="table" style="margin-top: 90px">
            <thead>
                <tr>

                    <th class="white-border"> @lang("Name")</th>
                    <th class="white-border">@lang("Father Name")</th>
                    <th class="white-border">@lang("Document Number")</th>
                    <th class="white-border">@lang("Reference")</th>
                    <th class="white-border">@lang("Year")</th>
                    <th class="white-border">@lang("Cost")</th>
                    <th class="white-border">@lang("Content")</th>
                    <th class="white-border">@lang("Slip No")</th>
                    <th class="white-border">@lang("Slip Date")</th>
                    <th class="white-border">@lang("Invoice No")</th>
                    <th class="white-border">@lang("Invoice Date")</th>
                    <th class="white-border">@lang("Remark")</th>

                </tr>
            </thead>
            <tbody>

                <td class="gray-border property-data">{{$account->name}}</td>
                <td class="gray-border property-data">{{$account->fname}}</td>
                <td class="gray-border property-data">{{$account->doc_no}}</td>
                <td class="gray-border property-data">{{$account->reference}}</td>
                <td class="gray-border property-data">{{$account->year}}</td>
                <td class="gray-border property-data">{{$account->cost}}</td>
                <td class="gray-border property-data">{!!$account->content!!}</td>
                <td class="gray-border property-data">{{$account->slip_no}}</td>

                <td class="gray-border property-data">{{$account->slip_date}}</td>
                <td class="gray-border property-data">{{$account->invoice_no}}</td>
                <td class="gray-border property-data">{{$account->invoice_date}}</td>
                <td class="gray-border property-data">{!! $account->remark !!}</td>
            </tbody>
        </table>

    </div>



</body>

</html>