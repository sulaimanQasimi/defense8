{{-- Import helper function to use in chatbox --}}
@use('Namu\WireChat\Helpers\Helper')
@use('Namu\WireChat\Facades\WireChat')

@php
    $primaryColor = WireChat::getColor();
@endphp



@assets
    <style>
     
        emoji-picker {
            width: 100% !important;
            height: 100%;
        }

        /* Emoji picker configuration */
        emoji-picker {
            --background: #f9fafb;
            --border-radius: 12px;
            --input-border-color: rgb(229 229 229);
            --input-padding: 0.45rem;
            --outline-color: none;
            --outline-size: 1px;
            --num-columns: 8;
            /* Mobile-first default */
            --emoji-padding: 0.7rem;
            --emoji-size: 1.5rem;
            /* Smaller size for mobile */
            --border-color: none;
            --indicator-color: #9ca3af;
        }


        @media screen and (min-width: 600px) {
            emoji-picker {
                --num-columns: 10;
                /* Increase columns for larger screens */
                --emoji-size: 1.8rem;
                /* Larger size for desktop */
            }
        }

        @media screen and (min-width: 900px) {
            emoji-picker {
                --num-columns: 16;
                /* Increase columns for larger screens */
                --emoji-size: 1.9rem;
                /* Larger size for desktop */
            }
        }
        /* Dark mode using prefers-color-scheme */
        @media (prefers-color-scheme: dark) {
            emoji-picker {
                --background: #1f2937 !important;
                --input-border-color: #374151;
                --outline-color: none;
                --outline-size: 1px;
                --border-color: none;
                --input-font-color: white;
                --indicator-color: #9ca3af;
                --button-hover-background: #9ca3af;
            }
        }


        /* Ensure dark mode takes precedence */
        .dark emoji-picker {
            --background: none !important;
            --input-border-color: #374151;
            --outline-color: none;
            --outline-size: 1px;
            --border-color: none;
            --input-font-color: white;
            --indicator-color: #9ca3af;
            --button-hover-background: #9ca3af
        }
    </style>

@endassets

<div x-data="{
    initializing: true,
    conversationId:@js($conversation->id),
    conversationElement: document.getElementById('conversation'),
    loadEmojiPicker() {
        if (!document.head.querySelector('script[src=\'https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js\']')) {
            let script = document.createElement('script');
            script.type = 'module';
            script.async = true; // Load asynchronously
            script.src = 'https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js';
            document.head.appendChild(script);
        }
    },
    get isWidget() {

        return $wire.widget == true;
    }
}" 

 x-init="setTimeout(() => {

    requestAnimationFrame(() => {
        initializing = false;
        $wire.dispatch('focus-input-field');
        loadEmojiPicker();
        if (isWidget) {
            $wire.dispatch('chat-opened',{conversation:conversationId});
        }
    });
}, 120);"
    class="w-full transition bg-white/95 dark:bg-gray-900 overflow-hidden h-full relative" style="contain:content">

    <div class=" flex flex-col  grow h-full   relative ">
        {{-- ---------- --}}
        {{-- --Header-- --}}
        {{-- ---------- --}}
        @include('wirechat::livewire.chat.includes.header', [ 'conversation' => $conversation, 'receiver' => $receiver])
        {{-- ---------- --}}
        {{-- -Body----- --}}
        {{-- ---------- --}}
        @include('wirechat::livewire.chat.includes.body', [ 'conversation' => $conversation, 'authParticipant' => $authParticipant, 'loadedMessages' => $loadedMessages, 'isPrivate' => $conversation->isPrivate(), 'isGroup' => $conversation->isGroup(), 'receiver' => $receiver])
        {{-- ---------- --}}
        {{-- -Footer--- --}}
        {{-- ---------- --}}
        @include('wirechat::livewire.chat.includes.footer', [ 'conversation' => $conversation, 'authParticipant' => $authParticipant, 'media' => $media, 'files' => $files, 'replyMessage' => $replyMessage])

    </div>

    <livewire:wirechat.chat.drawer />
</div>
