<?php

use App\Models\University;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, rules, mount};

middleware(['auth', 'verified']);
name('minors.index');

state(['user' => auth()->user()])->locked();

?>
<x-layouts.app>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Your minors') }}
                </h2>
                <h3 class="text-lg leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Save all data necessary found and needed for making a choice about your minor') }}
                </h3>
            </div>
            <div>
                {{-- Your button goes here --}}
                <a wire:navigate href="{{route('minors.create')}}" class="dark:bg-sky-500 dark:hover:bg-sky-700 bg-sky-700 hover:bg-sky-900 text-white text-lg px-4 py-2 rounded-full">Add new minor</a>
            </div>
        </div>
    </x-slot>


    @volt('minors.index')
    <div class="py-7">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <section
                class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                <div class="px-5">
                    @foreach(University::distinct()->pluck('country') as $country)
                        @if($user->minors()->whereHas('university', function($query) use ($country) {
                             $query->where('country', $country);
                        })->exists())
                            <div class="pt-5">
                                <h4 class="text-lg leading-tight font-bold text-gray-800 dark:text-gray-200">
                                    {{ $country }}
                                </h4>
                                @foreach($user->minors as $minor)
                                    @if($minor->university->country == $country)
                                        <div class="pt-2">
                                            <div
                                                class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white dark:bg-white/5 border border-gray-200 dark:border-gray-700 dark:text-gray-100 divide-y divide-gray-200 rounded-md">
                                                <a wire:navigate href="{{route('minors.show', ['minor' => $minor])}}"
                                                   class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
                                                    Minor at {{$minor->university->name}}
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        </div>
    </div>
    @endvolt

</x-layouts.app>
