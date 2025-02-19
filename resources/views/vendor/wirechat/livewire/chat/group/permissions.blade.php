<div class="bg-white dark:bg-inherit overfo opaticy-100   min-h-screen w-full">
    <section class="flex gap-4 z-[10]  items-center p-5 sticky top-0 bg-white dark:bg-gray-900  ">
        <button wire:click="$dispatch('closeChatDrawer')" class="focus:outline-none"> <svg class="w-7 h-7"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg> </button>
        <h3>Permissions</h3>
    </section>


    <div class="">
        <section >

            <h5 class="w-full text-start py-4 bg-gray-50 dark:bg-gray-950 px-50 px-4">
                Members can:
            </h5>

            <ul class="space-y-2">
                {{-- Edit Group Settings  --}}
                <li class="w-full flex  p-5">
                    <span class="w-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6 w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>

                    </span>

                    <span class="w-full text-start">
                        <h5 class="font-medium">Edit Group Information</h5>
                        <p>This includes the name, icon and description</p>
                    </span>



                    <span class="w-12">

                        <label class="inline-flex items-center cursor-pointer">
                            <input wire:model.live.debounce="allow_members_to_edit_group_info" type="checkbox"  class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 
                            peer-checked:bg-[var(--wirechat-primary-color)] peer-checked:border-[var(--wirechat-primary-color)] 
                            peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                            peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] 
                            after:start-[2px] after:bg-white after:border-gray-300 after:border 
                            after:rounded-full after:h-5 after:w-5 after:transition-all">
                     </div>
                        </label>

                    </span>

                </li>

                {{-- Send Messages --}}
                <li class="w-full flex items-center p-5">
                    <span class="w-12">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="size-6 w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                          </svg>
                    </span>

                    <span class="w-full text-start">
                        <h5 class="font-medium">Send messages</h5>
                    </span>


                    <span class="w-12">

                        <label class="inline-flex items-center cursor-pointer">
                            <input wire:model.live.debounce="allow_members_to_send_messages" type="checkbox" class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 
                            peer-checked:bg-[var(--wirechat-primary-color)] peer-checked:border-[var(--wirechat-primary-color)] 
                            peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                            peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] 
                            after:start-[2px] after:bg-white after:border-gray-300 after:border 
                            after:rounded-full after:h-5 after:w-5 after:transition-all">
                     </div>
                        </label>

                    </span>

                </li>

                  {{-- Add other members --}}
                  <li class="w-full flex items-center p-5">
                    <span class="w-12">

                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 w-6 h-6 text-gray-500 dark:text-white/90">
                            <path d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                          </svg>
                          
                    </span>

                    <span class="w-full text-start">
                        <h5 class="font-medium">Add other members</h5>
                    </span>



                    <span class="w-12">

                        <label class="inline-flex items-center cursor-pointer">
                            <input wire:model.live.debounce="allow_members_to_add_others" type="checkbox"  class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 
                                   peer-checked:bg-[var(--wirechat-primary-color)] peer-checked:border-[var(--wirechat-primary-color)] 
                                   peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                                   peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] 
                                   after:start-[2px] after:bg-white after:border-gray-300 after:border 
                                   after:rounded-full after:h-5 after:w-5 after:transition-all">
                            </div>
                        
                        
                        </label>

                    </span>

                </li>

            </ul>
        </section>





    </div>

</div>
