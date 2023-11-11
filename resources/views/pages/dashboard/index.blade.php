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

            <div class="grid grid-cols-3 relative w-full h-full">
                <div class="border border-gray-500 rounded py-20">
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
                <div>
                    <a href="{{route('minor.create')}}" wire:navigate>Link to minor</a>
                    Under construction :)
                </div>
            </div>

        </div>
    </div>
    @endvolt
</x-layouts.app>
