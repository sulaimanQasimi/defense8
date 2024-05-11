<div>
    @once
        @push('css')
            <style>
                .inputbox {
                    position: relative;
                    width: 196px;
                }

                .inputbox input {
                    position: relative;
                    width: 100%;
                    padding: 20px 10px 10px;
                    background: transparent;
                    outline: none;
                    box-shadow: none;
                    border: none;
                    color: #23242a;
                    font-size: 1em;
                    letter-spacing: 0.05em;
                    transition: 0.5s;
                    z-index: 10;
                }

                .inputbox span {
                    position: absolute;
                    left: 0;
                    padding: 20px 10px 10px;
                    font-size: 1em;
                    color: #8f8f8f;
                    letter-spacing: 00.05em;
                    transition: 0.5s;
                    pointer-events: none;
                }

                .inputbox input:valid~span,
                .inputbox input:focus~span {
                    color: #45f3ff;
                    transform: translateX(-10px) translateY(-34px);
                    font-size: 0, 75em;
                }

                .inputbox i {
                    position: absolute;
                    left: 0;
                    bottom: 0;
                    width: 100%;
                    height: 2px;
                    background: #45f3ff;
                    border-radius: 4px;
                    transition: 0.5s;
                    pointer-events: none;
                    z-index: 9;
                }

                .inputbox input:valid~i,
                .inputbox input:focus~i {
                    height: 44px;
                }
            </style>
        @endpush
    @endonce
    <div dir="rtl" class="bg-white px-3 py-4 rounded-xl">

        <div>@lang('Change Application Language')</div>
        <div class="grid lg:grid-cols-5 gap-5 sm:grid-cols-2 md:grid-cols-3">

            @foreach ($words as $key => $word)
                <div class="flex justify-between text-xs">

                    <div class="font-medium"> {{ $key }}:</div>
                    <div class="inputbox">
                        <input wire:model.lazy="lang.{{ $key }}"
                        type="text"
                        {{-- class="bg-transparent px-3 py-2 text-xs hover:ring-1 rounded-lg" --}}
                            wire:loading.attr="disabled" />
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
