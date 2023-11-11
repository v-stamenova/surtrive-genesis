<?php

use App\Models\Minor;
use App\Models\University;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, rules, mount};
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

name('minor.create');
middleware(['auth', 'verified']);

state(['university_id' => '',
    'city' => '',
    'specifics' => '',
    'accommodation' => '',
    'semester_start' => '',
    'semester_end' => '',
    'lower_living_expense' => '',
    'higher_living_expense' => '',
    'prerequisites' => '',
    'items' => '']);


rules(['university_id' => 'required',
    'city' => 'required',
    'specifics' => '',
    'accommodation' => '',
    'semester_start' => 'date',
    'semester_end' => 'date',
    'lower_living_expense' => 'numeric',
    'higher_living_expense' => 'numeric|gt:lower_living_expense',
    'prerequisites' => '']);

mount(function () {
    $this->items = University::all()->map(function ($university) {
        return [
            'value' => $university->id,
            'text' => $university->name,
        ];
    });

});

$createMinor = function () {
    // Validate based on the rules above
    $validated = $this->validate();
    Minor::create($validated);

    return $this->redirect(route('dashboard'), navigate: true);
}
?>


<x-layouts.app>

    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Add new potential minor') }}
        </h2>
        <h3 class="text-lg leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Save all data necessary found and needed for making a choice about your minor') }}
        </h3>
    </x-slot>

    @volt('minor.create')
    <div class="py-7">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <section
                class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                <div class="px-5">
                    <form wire:submit="createMinor" class="space-y-6">
                        <div class="grid grid-cols-2 gap-10">
                            <div class="space-y-3">
                                <header class="pb-2">
                                    <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">{{ __('Minor Information') }}</h2>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("Good job on finding a minor that suits you") }}</p>
                                </header>
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100">{{ __('University and course') }}</h3>
                                <div>
                                    <x-ui.select :items="$items" label="University name" mandatory="true"
                                                 wire:model="university_id"/>
                                    <livewire:create-university wire:loading.attr="disabled" wire:target="createUniversity" />
                                </div>
                                <x-ui.input label="City" type="text" id="city" name="city" mandatory="true"
                                            wire:model="city"/>
                                <x-ui.textarea label="Specifics"
                                               additional_info="What courses you want to take? Is it a predefined minor? Add everything that pops to mind study related"
                                               type="text" id="specifics" name="specifics" wire:model="specifics"/>
                                <!-- TODO: Proper date picker -->
                                <x-ui.input label="Starting date (approx)" type="date" id="semester_start"
                                            name="semester_start" wire:model="semester_start"/>
                                <x-ui.input label="Ending date (approx)" type="date" id="semester_end"
                                            name="semester_end" wire:model="semester_end"/>
                                <x-ui.textarea label="Prerequisites" type="text" id="prerequisites"
                                               name="prerequisites"
                                               wire:model="prerequisites"/>
                            </div>
                            <div class="space-y-2 relative">
                                <div
                                    class="flex items-center justify-center fill-current opacity-10 dark:opacity-5 text-slate-400">
                                    <img class="w-[70%]" src="../img/confused-penguin.png">
                                </div>
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 pb-1">{{ __('Living situtaion') }}</h3>
                                <x-ui.textarea label="Accommodation"
                                               additional_info="What is the situation with the accommodation for the uni?"
                                               type="text" id="accommodation" name="accommodation"
                                               wire:model="accommodation"/>
                                <x-ui.input label="Lower living expense border" type="number"
                                            id="lower_living_expense"
                                            name="lower_living_expense" wire:model="lower_living_expense"/>
                                <x-ui.input label="Higher living expense border" type="number"
                                            id="higher_living_expense" name="higher_living_expense"
                                            wire:model="higher_living_expense"/>
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
