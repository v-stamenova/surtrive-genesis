<?php

use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, rules};

name('minor.create');
middleware(['auth', 'verified']);

state(['name' => '',
    'country' => '',
    'city' => '',
    'specifics' => '',
    'accommodation' => '',
    'semester_start' => '',
    'semester_end' => '',
    'lower_living_expense' => '',
    'higher_living_expense' => '',
    'prerequisites' => '']);


rules(['name' => 'required',
    'country' => 'required',
    'city' => 'required',
    'specifics' => '',
    'accommodation' => '',
    'semester_start' => 'date',
    'semester_end' => 'date',
    'lower_living_expense' => 'numeric',
    'higher_living_expense' => 'numeric',
    'prerequisites' => '']);
?>


<x-layouts.app>

    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Add new potential minor') }}
        </h2>
        <div x-data="{
            text: '',
            textArray : ['Found new hell?', 'It is never too late to drop out', ' 👁👄👁' ,'Do I really need this degree?', 'Should have stayed home', '👹', 'Mum, come pick me up I am scared'],
            textIndex: 0,
            charIndex: 0,
            typeSpeed: 110,
            cursorSpeed: 550,
            pauseEnd: 2500,
            pauseStart: 20,
            direction: 'forward',
        }"

        x-init="$nextTick(() => {
            let typingInterval = setInterval(startTyping, $data.typeSpeed);

            function startTyping(){
                let current = $data.textArray[ $data.textIndex ];

                // check to see if we hit the end of the string
                if($data.charIndex > current.length){
                        $data.direction = 'backward';
                        clearInterval(typingInterval);

                        setTimeout(function(){
                            typingInterval = setInterval(startTyping, $data.typeSpeed);
                        }, $data.pauseEnd);
                }

                $data.text = current.substring(0, $data.charIndex);

                if($data.direction == 'forward')
                {
                    $data.charIndex += 1;
                }
                else
                {
                    if($data.charIndex == 0)
                    {
                        $data.direction = 'forward';
                        clearInterval(typingInterval);
                        setTimeout(function(){
                            $data.textIndex += 1;
                            if($data.textIndex >= $data.textArray.length)
                            {
                                $data.textIndex = 0;
                            }
                            typingInterval = setInterval(startTyping, $data.typeSpeed);
                        }, $data.pauseStart);
                    }
                    $data.charIndex -= 1;
                }
            }
        })"
        class="max-w-7xl">
            <div class="relative flex h-6">
                <p class="text-lg leading-tight text-gray-800 dark:text-gray-200" x-text="text"></p>
            </div>
        </div>
    </x-slot>

    @volt('minor.create')
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <section
                class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                <div class="px-5">
                    <header>
                        <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">{{ __('Minor Information') }}</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Congrats on finding a minor that suits you. Add the necessary data so that you don't forget about it.") }}</p>
                    </header>
                    <form class="mt-10 space-y-6">
                        <div class="grid grid-cols-2 gap-10">
                            <div class="space-y-3">
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 pb-1">{{ __('University and course') }}</h3>
                                <x-ui.input label="University Name" type="text" id="name" name="name" mandatory="true"  wire:model="name" />
                                <x-ui.input label="Country" type="text" id="country" name="country" mandatory="true" wire:model="country" />
                                <x-ui.input label="City" type="text" id="city" name="city" mandatory="true" wire:model="city" />
                                <x-ui.textarea label="Specifics" additional_info="What courses you want to take? Is it a predefined minor? Add everything that pops to mind study related" type="text" id="specifics" name="specifics" wire:model="specifics" />
                                <!-- TODO: Proper date picker -->
                                <x-ui.input label="Starting date (approx)" type="date" id="semester_start" name="semester_start" wire:model="semester_start" />
                                <x-ui.input label="Ending date (approx)" type="date" id="semester_end" name="semester_end" wire:model="semester_end" />
                                <x-ui.textarea label="Prerequisites" type="text" id="prerequisites" name="prerequisites" wire:model="prerequisites" />
                            </div>
                            <div class="space-y-3 relative">
                                <div
                                    class="w-3/5 fill-current opacity-10 dark:opacity-5 text-slate-400">
                                    <img src="../img/confused-penguin.png">
                                </div>
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 pb-1">{{ __('Living situtaion') }}</h3>
                                <x-ui.textarea label="Accommodation" additional_info="What is the situation with the accommodation for the uni?" type="text" id="accommodation" name="accommodation" wire:model="accommodation" />
                                <x-ui.input label="Lower living expense border" type="number" id="lower_living_expense" name="lower_living_expense" wire:model="lower_living_expense" />
                                <x-ui.input label="Higher living expense border" type="number" id="higher_living_expense" name="higher_living_expense" wire:model="higher_living_expense" />
                                <x-ui.button type="primary" submit="true">{{ __('Save minor') }}</x-ui.button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    @endvolt
</x-layouts.app>
