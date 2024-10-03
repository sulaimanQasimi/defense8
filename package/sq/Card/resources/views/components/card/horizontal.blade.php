@props(['card', 'cardInfo', 'field'])
@php
    $heightStyle = 'height: 2.16in; width: 3.41in;';
    $wholeSize = 'height: 4.32in;width: 3.41in;';
@endphp
<x-sqcard::card.baseCard :card="$card" :cardInfo="$cardInfo" :id="'guest-' . $cardInfo->id" :field="$field" :heightStyle="$heightStyle"
    :wholeSize="$wholeSize" />
</div>
