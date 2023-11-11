<?php

use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, mount};

name('dashboard');
middleware(['auth', 'verified']);

?>

<x-layouts.app>

    @volt('dashboard')
    <div class="h-full py-12">
        <div class="h-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 relative w-full h-full gap-4">
                <section
                    class="p-4 h-full bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                    <div class=" py-20">
                        <div class="pl-5">
                            <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                {{ __('Hi, ') . Auth::user()->name }}
                            </h2>
                            <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                {{ __('See where you left it off last time') }}
                            </h2>
                        </div>
                        <img src="img/waving-penguin.png">
                    </div>
                </section>
                <div class="sm:col-span-2">
                    <section
                        class="p-4 h-full bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                        <div>
                            <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100 pb-2">{{ __('Last minors added by youg') }}</h2>
                            <div x-data="{
                                activeAccordion: '',
                                setActiveAccordion(id) {
                                    this.activeAccordion = (this.activeAccordion == id) ? '' : id
                                }
                            }" class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white border border-gray-200 divide-y divide-gray-200 rounded-md">
                                <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
                                    <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
                                        <span>What is Pines?</span>
                                        <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    </button>
                                    <div x-show="activeAccordion==id" x-collapse x-cloak>
                                        <div class="p-4 pt-0 opacity-70">
                                            Pines is a UI library built for AlpineJS and TailwindCSS.
                                        </div>
                                    </div>
                                </div>
                                <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
                                    <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
                                        <span>How do I install Pines?</span>
                                        <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    </button>
                                    <div x-show="activeAccordion==id" x-collapse x-cloak>
                                        <div class="p-4 pt-0 opacity-70">
                                            Add AlpineJS and TailwindCSS to your page and then copy and paste any of these elements into your project.
                                        </div>
                                    </div>
                                </div>
                                <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
                                    <button @click="setActiveAccordion(id)" class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
                                        <span>Can I use Pines with other libraries or frameworks?</span>
                                        <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    </button>
                                    <div x-show="activeAccordion==id" x-collapse x-cloak>
                                        <div class="p-4 pt-0 opacity-70">
                                            Absolutely! Pines works with any other library or framework. Pines works especially well with the TALL stack.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
    @endvolt
</x-layouts.app>
