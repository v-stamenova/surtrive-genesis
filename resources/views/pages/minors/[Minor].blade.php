<?php

use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, rules, mount};

name('minors.show');
middleware(['auth', 'verified']);

state(['minor'])->locked();

state(['city' => '',
    'specifics' => '',
    'accommodation' => '',
    'semester_start' => '',
    'semester_end' => '',
    'lower_living_expense' => '',
    'higher_living_expense' => '',
    'prerequisites' => '',
    'delete_confirm_password' => '']);

mount(function () {
    $this->city = $this->minor->city;
    $this->specifics = $this->minor->specifics;
    $this->semester_start = $this->minor->semester_start;
    $this->semester_end = $this->minor->semester_end;
    $this->prerequisites = $this->minor->prerequisites;
    $this->lower_living_expense = $this->minor->lower_living_expense;
    $this->higher_living_expense = $this->minor->higher_living_expense;
    $this->accommodation = $this->minor->accommodation;
});

$updateMinor = function () {
    $validated = $this->validate([
        'city' => 'required',
        'specifics' => '',
        'semester_start' => 'date',
        'semester_end' => 'date',
        'prerequisites' => ''
    ]);

    if ($this->city == $this->minor->city && $this->specifics == $this->minor->specifics
        && $this->semester_start == $this->minor->semester_start && $this->semester_end == $this->minor->semester_end
        && $this->prerequisites == $this->minor->prerequisites) {

        $this->dispatch('toast', message: 'Nothing to update.', data: ['position' => 'top-right', 'type' => 'info']);
        return;
    }

    $this->minor->update($validated);

    $this->dispatch('toast', message: 'Successfully updated notes for this minor.', data: ['position' => 'top-right', 'type' => 'success']);
};

$updateLiving = function () {
    $validated = $this->validate([
        'lower_living_expense' => 'numeric',
        'higher_living_expense' => 'numeric|gt:lower_living_expense',
        'accommodation' => '',
    ]);

    if ($this->lower_living_expense == $this->minor->lower_living_expense &&
        $this->higher_living_expense == $this->minor->higher_living_expense &&
        $this->accommodation == $this->minor->accommodation) {

        $this->dispatch('toast', message: 'Nothing to update.', data: ['position' => 'top-right', 'type' => 'info']);
        return;
    }

    $this->minor->update($validated);

    $this->dispatch('toast', message: 'Successfully updated notes for the living situation.', data: ['position' => 'top-right', 'type' => 'success']);
};

/**
 * Delete the user's account.
 */
$destroy = function (Request $request) {

    if (!Hash::check($this->delete_confirm_password, Auth::user()->password)) {
        $this->dispatch('toast', message: 'The Password you entered is incorrect', data: ['position' => 'top-right', 'type' => 'danger']);
        $this->reset(['delete_confirm_password']);
        return;
    }

    $this->minor->delete();

    return $this->redirect(route('dashboard'), navigate: true);
}
?>
<x-layouts.app>

    <x-slot name="header">
        <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Minor at ') . $minor->university->name }}
        </h2>
        <h3 class="text-lg leading-tight text-gray-800 dark:text-gray-200">
            {{ __('All notes you have left for this minor') }}
        </h3>
    </x-slot>

    @volt('minor.show')
    <div class="py-7">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            {{-- Update Minor Section --}}
            <section
                class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Minor Information') }}</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("You can update all data for the minor at {$minor->university->name} over here.") }}</p>
                    </header>
                    <form wire:submit="updateMinor" class="mt-6 space-y-6">
                        <x-ui.input label="City" type="text" id="city" name="city" mandatory="true" wire:model="city"/>
                        <x-ui.textarea label="Specifics"
                                       additional_info="What courses you want to take? Is it a predefined minor? Add everything that pops to mind study related"
                                       type="text" id="specifics" name="specifics" wire:model="specifics"/>
                        <x-ui.input label="Starting date (approx)" type="date" id="semester_start"
                                    name="semester_start" wire:model="semester_start"/>
                        <x-ui.input label="Ending date (approx)" type="date" id="semester_end"
                                    name="semester_end" wire:model="semester_end"/>
                        <x-ui.textarea label="Prerequisites" type="text" id="prerequisites"
                                       name="prerequisites"
                                       wire:model="prerequisites"/>
                        <div class="flex items-start">
                            <div>
                                <x-ui.button type="primary" submit="true">{{ __('Update minor') }}</x-ui.button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            {{-- End Update Minor Information --}}

            {{-- Update Living Section --}}
            <section
                class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Living Situation') }}</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __("You can update all data for the living situation at {$minor->city} over here.") }}</p>
                    </header>
                    <form wire:submit="updateLiving" class="mt-6 space-y-6">
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
                        <div class="flex items-start">
                            <div>
                                <x-ui.button type="primary"
                                             submit="true">{{ __('Update living situation') }}</x-ui.button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            {{-- End Update Living Information --}}

            {{-- Delete Minor Form --}}
            <section
                class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Delete Minor') }}</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('After deleting this minor, all data and resources are permanently removed. Enter your password to confirm deletion.') }}</p>
                    </header>

                    <div class="flex items-start justify-start w-auto text-left pt-5">
                        <div>
                            <x-ui.button type="danger" x-data
                                         @click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                                {{ __('Delete Account') }}
                            </x-ui.button>
                        </div>
                    </div>

                    <x-ui.modal name="confirm-user-deletion" maxWidth="lg" :show="$errors->userDeletion->isNotEmpty()"
                                focusable>
                        <form wire:submit="destroy" class="p-6">

                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Are you sure you want to delete this minor?') }}</h2>
                            <p class="mt-1 mb-6 text-sm text-gray-600 dark:text-gray-400">{{ __('After the minor, all data and resources are permanently removed. Enter your password to confirm deletion.') }}</p>

                            <x-ui.input label="Password" type="password" id="delete_confirm_password"
                                        name="delete_confirm_password" wire:model="delete_confirm_password"/>

                            <div class="flex justify-end mt-6">
                                <div>
                                    <x-ui.button type="secondary" x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-ui.button>
                                </div>

                                <div class="ml-3">
                                    <x-ui.button type="danger" submit="true">
                                        {{ __('Delete Minor') }}
                                    </x-ui.button>
                                </div>
                            </div>
                        </form>
                    </x-ui.modal>
                </div>
            </section>
            {{-- End Delete Minor Form --}}

        </div>
    </div>
    @endvolt

</x-layouts.app>

