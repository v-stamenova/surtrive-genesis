<?php

use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, rules, mount};

name('minors.show');
middleware(['auth', 'verified']);

state(['minor']);
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
            <section
                class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">

            </section>
        </div>
    </div>

</x-layouts.app>

