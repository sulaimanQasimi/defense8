<div>
    {{-- The Master doesn't talk, he acts. --}}
    @once
        @push('css')
            <script type="text/javascript" src="{{ asset('qrcode/jquery.min.js') }}"></script>
            <script type="text/javascript" src="{{ asset('qrcode/qrcode.js') }}"></script>
            <script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>
            <style>
                @media print {
                    body {
                        print-color-adjust: exact;
                        -webkit-print-color-adjust: exact;
                    }

                    #printable {
                        position: absolute;
                        top: 0;
                        left: 0;
                    }

                }

                body {
                    background-color: white
                }

                /* level settings 👇 */

                .slider {
                    /* slider */
                    --slider-width: 100%;
                    --slider-height: 6px;
                    --slider-bg: rgb(82, 82, 82);
                    --slider-border-radius: 999px;
                    /* level */
                    --level-color: #fff;
                    --level-transition-duration: .1s;
                    /* icon */
                    --icon-margin: 15px;
                    --icon-color: var(--slider-bg);
                    --icon-size: 25px;
                }

                .slider {
                    cursor: pointer;
                    display: -webkit-inline-box;
                    display: -ms-inline-flexbox;
                    display: inline-flex;
                    -webkit-box-orient: horizontal;
                    -webkit-box-direction: reverse;
                    -ms-flex-direction: row-reverse;
                    flex-direction: row-reverse;
                    -webkit-box-align: center;
                    -ms-flex-align: center;
                    align-items: center;
                }

                .slider .volume {
                    display: inline-block;
                    vertical-align: top;
                    margin-right: var(--icon-margin);
                    color: var(--icon-color);
                    width: var(--icon-size);
                    height: auto;
                }

                .slider .level {
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    width: var(--slider-width);
                    height: var(--slider-height);
                    background: var(--slider-bg);
                    overflow: hidden;
                    border-radius: var(--slider-border-radius);
                    -webkit-transition: height var(--level-transition-duration);
                    -o-transition: height var(--level-transition-duration);
                    transition: height var(--level-transition-duration);
                    cursor: inherit;
                }

                .slider .level::-webkit-slider-thumb {
                    -webkit-appearance: none;
                    width: 0;
                    height: 0;
                    -webkit-box-shadow: -200px 0 0 200px var(--level-color);
                    box-shadow: -200px 0 0 200px var(--level-color);
                }

                .slider:hover .level {
                    height: calc(var(--slider-height) * 2);
                }

                .svg-frame {
                    position: relative;
                    width: 300px;
                    height: 300px;
                    transform-style: preserve-3d;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .svg-frame svg {
                    position: absolute;
                    transition: .5s;
                    z-index: calc(1 - (0.2 * var(--j)));
                    transform-origin: center;
                    width: 344px;
                    height: 344px;
                    fill: none;
                }

                .svg-frame:hover svg {
                    transform: rotate(-80deg) skew(30deg) translateX(calc(45px * var(--i))) translateY(calc(-35px * var(--i)));
                }

                .svg-frame svg #center {
                    transition: .5s;
                    transform-origin: center;
                }

                .svg-frame:hover svg #center {
                    transform: rotate(-30deg) translateX(45px) translateY(-3px);
                }

                #out2 {
                    animation: rotate16 7s ease-in-out infinite alternate;
                    transform-origin: center;
                }

                #out3 {
                    animation: rotate16 3s ease-in-out infinite alternate;
                    transform-origin: center;
                    stroke: #ff0;
                }

                #inner3,
                #inner1 {
                    animation: rotate16 4s ease-in-out infinite alternate;
                    transform-origin: center;
                }

                #center1 {
                    fill: #ff0;
                    animation: rotate16 2s ease-in-out infinite alternate;
                    transform-origin: center;
                }

                @keyframes rotate16 {
                    to {
                        transform: rotate(360deg);
                    }
                }
            </style>
        @endpush
    @endonce
    @teleport('body')
        @include('sqcard::livewire.guest.components.loadingBanner')
    @endteleport
    <div class="block pb-5">
        <a href="/"
            class="px-7 rounded-lg hover:scale-95 py-2 text-white bg-gradient-to-t from-blue-600 to-blue-500"
            style="">@lang('Home')</a>

    </div>
    <div class="flex justify-center align-middle bg-white px-6 py-2 rounded-2xl shadow-2xl">
        <div>
            <div class="pb-12 font-medium text-2xl text-blue-700">@lang('Guest Import') </div>
            <a href="{{ asset('template.xlsx') }}" target="_blank" class="pb-6 block"><span
                    class="fas fa-download fa-2xl text-blue-400 hover:text-blue-300"></span></a>


            <form wire:submit="save">

                <div class="flex items-center justify-center w-full">
                    <label for="background-logo-file-upload"
                        class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>

                            <p class="text-xs text-gray-500 dark:text-gray-400">@lang('Guest Import')</p>
                        </div>
                        <input id="background-logo-file-upload" type="file" class="hidden" wire:model.live="file" />
                    </label>
                </div>


                @error('file')
                    <span class="error">{{ $message }}</span>
                @enderror

                <button type="submit"
                    class="mt-5 bg-blue-400 px-3 py-2 text-white font-medium rounded-lg ring-1 ring-blue-400">@lang('Save')</button>
            </form>
        </div>
    </div>
</div>
