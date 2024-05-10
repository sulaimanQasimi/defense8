<div class="block">@lang('Name'): <span>{{ $cardInfo->full_name }}</span></div>
<div class="block">@lang('Father Name'): <span>{{ $cardInfo->father_name }}</span></div>
<div class="block">@lang('Job'): <span>{{ $cardInfo->job_structure }}</span></div>
<div class="block">@lang('Department'): <span>{{ $cardInfo->orginization?->fa_name }}</span></div>
<div class="block">@lang('Register No'): <span>{{ $cardInfo->registare_no }}</span></div>
<div class="block">
    @lang('Start Date'):<span>{{ $cardInfo->main_card?->card_perform ? verta($cardInfo->main_card?->card_perform)->format('Y/m/d') : '' }}</span>
</div>
<div class="block">
    @lang('Expire Date'):<span>{{ $cardInfo->main_card?->card_expired_date ? verta($cardInfo->main_card?->card_expired_date)->format('Y/m/d') : '' }}</span>
</div>
