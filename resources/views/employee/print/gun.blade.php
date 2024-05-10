<div class="block">@lang('Name'): <span>{{ $cardInfo->full_name }}</span></div>
<div class="block">@lang('Father Name'): <span>{{ $cardInfo->father_name }}</span></div>

<div class="block">@lang('Gun Type'): <span>{{ $cardInfo->gun_card?->gun_type }}</span></div>
<div class="block">@lang('Gun Range'): <span>{{ $cardInfo->gun_card?->range }}</span></div>
<div class="block">@lang('Gun No'): <span>{{ $cardInfo->gun_card?->gun_no }}</span></div>
<div class="block">
    @lang('Preform Date'):<span>{{ $cardInfo->gun_card?->filled_form_date ? verta($cardInfo->gun_card?->filled_form_date)->format('Y/m/d') : '' }}</span>
</div>
<div class="block">@lang('Expire Date'):<span></span></div>
