@props(['card', 'field', 'cardInfo'])
@php
    $heightStyle = ' width: 2.16in; height: 3.41in;';
    $wholeSize = 'width: 2.16in;height: 6.82in;';
@endphp


<x-sqcard::card.baseCard :card="$card"
                        :cardInfo="$cardInfo"
                        :id="'guest-' . $cardInfo->id"
                        :field="$field"
                        :heightStyle="$heightStyle"
                        :wholeSize="$wholeSize" />
</div>
