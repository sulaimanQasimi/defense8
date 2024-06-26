@props(['label', 'xModel', 'yModel','xMax','yMax'])

<div class="my-2">
    <label for="{{ $xModel }}" class="block mb-2 text-sm font-medium text-gray-900 ">
        @lang($label)
    </label>
    <label class="slider space-x-3">
        <input type="range" class="level" x-model="{{ $xModel }}" max="{{ $xMax }}" />
        <input type="range" class="level" x-model="{{ $yModel }}" max="{{ $yMax }}" />
    </label>
</div>
