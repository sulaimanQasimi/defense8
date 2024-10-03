<x-sqcard::card.layout>
    @if ($card->dim === 'vertical')
        <x-sqcard::card.vertical :card="$card" :cardInfo="$cardInfo" :id="'guest-' . $cardInfo->id" :field="$field" />
    @else
    <x-sqcard::card.horizontal :card="$card" :cardInfo="$cardInfo" :id="'guest-' . $cardInfo->id" :field="$field" />
    @endif
</x-sqcard::card.layout>
