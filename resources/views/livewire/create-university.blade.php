<div x-data="{ modalOpen: false }" id="create_uni"
     @keydown.escape.window="modalOpen = false"
     class="relative z-50 w-auto h-auto">
    <p @click="modalOpen=true"
       class="text-xs dark:text-gray-400 underline transition-colors cursor-pointer pt-1 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
        The university is missing? Click here</p>
    <template x-teleport="body">
        <div x-show="modalOpen" class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen"
             x-cloak>
            <div x-show="modalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="modalOpen=false" class="absolute inset-0 w-full h-full bg-black bg-opacity-40"></div>
            <div x-show="modalOpen"
                 x-trap.inert.noscroll="modalOpen"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full py-6 bg-white px-7 sm:max-w-lg sm:rounded-lg dark:bg-gray-900">
                <div class="flex items-center justify-between pb-2">
                    <h3 class="text-lg font-semibold dark:text-gray-100">Add new university</h3>
                    <button @click="modalOpen=false"
                            class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 text-gray-600 rounded-full hover:text-gray-800 hover:bg-gray-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="relative w-auto">
                    <form wire:submit.prevent="createUniversity">
                        <div class="py-4">
                            <x-ui.input label="University name" type="text" id="name" name="name"
                                        mandatory="true"
                                        wire:model="name"/>
                            <div class="pt-2">
                                <x-ui.select :items="$items" label="Country" mandatory="true"
                                             wire:model="country"/>
                            </div>
                        </div>
                        <x-ui.button type="primary" @click="modalOpen=false" submit="true">Save</x-ui.button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>
