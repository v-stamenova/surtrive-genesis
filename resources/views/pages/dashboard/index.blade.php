<?php

use App\Models\Minor;
use App\Models\University;
use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, mount};
use Illuminate\Support\Facades\Auth;

name('dashboard');
middleware(['auth', 'verified']);

state([
    'lastMinors' => '',
    'lastUniversities' => ''
]);

mount(function () {
    $this->lastMinors = Auth::user()->minors()->orderBy('created_at', 'desc')
        ->take(Auth::user()->minors->count() < 3 ? Auth::user()->minors->count() : 3)->get();

    $this->lastUniversities = University::chosenFromUsersByProgramme(Auth::user()->programme)
        ->take(University::chosenFromUsersByProgramme(Auth::user()->programme)->count() < 3
            ? University::chosenFromUsersByProgramme(Auth::user()->programme)->count() : 3);
});
?>

<x-layouts.app>

    @volt('dashboard')
    <div class="h-full py-12">
        <div class="h-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 relative w-full h-full gap-4">
                <section
                    class="p-4 h-full bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg dark:bg-gray-900/50 dark:border dark:border-gray-200/10">
                    <div class="py-20">
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
                        <div class="pb-10">
                            <div class="flex justify-between">
                                <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100 pb-2">{{ __('Last minors added by you') }}</h2>
                                <a wire:navigate href="{{ route('minors.create') }}" class="text-sky-700 dark:text-sky-500 hover:text-sky-900 dark:hover:text-sky-700 underline">{{ __('Add a Minor') }}</a>
                            </div>

                            <div x-data="{
                                activeAccordion: '',
                                setActiveAccordion(id) {
                                    this.activeAccordion = (this.activeAccordion == id) ? '' : id
                                }
                            }"
                                 class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white dark:bg-white/5 border border-gray-200 dark:border-gray-700 dark:text-gray-100 divide-y divide-gray-200 rounded-md">
                                @forelse($lastMinors as $minor)
                                    <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
                                        <button @click="setActiveAccordion(id)"
                                                class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
                                            <span>Minor at {{$minor->university->name}}</span>
                                            <svg class="w-4 h-4 duration-200 ease-out"
                                                 :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div x-show="activeAccordion==id" x-collapse x-cloak>
                                            <div class="p-4 pt-0 opacity-70 cursor-default">
                                                The minor at {{$minor->university->name}} takes place
                                                in {{$minor->city}}, {{$minor->university->name}}. Check your notes
                                                <a wire:navigate class="underline font-bold"
                                                   href="{{route('minors.show', ['minor' => $minor])}}">over here</a>.
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-2 py-3">You haven't added any minors yet,
                                        <a href="{{route('minors.create')}}" wire:navigate class="underline hover:text-sky-800 dark:hover:text-sky-400">time to change that?</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-medium text-gray-900 dark:text-gray-100">{{ __('Last universities added') }}</h2>
                            <h3 class="text-md italic text-gray-900 dark:text-gray-100 pb-2">{{ __('Maybe the other students from your programme are onto something? You may want to check them out') }}</h3>
                            <div x-data="{
                                activeAccordion: '',
                                setActiveAccordion(id) {
                                    this.activeAccordion = (this.activeAccordion == id) ? '' : id
                                }
                            }"
                                 class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white dark:bg-white/5 border border-gray-200 dark:border-gray-700 dark:text-gray-100 divide-y divide-gray-200 rounded-md">
                                @forelse($lastUniversities as $university)
                                    <div x-data="{ id: $id('accordion') }" class="cursor-pointer group">
                                        <button @click="setActiveAccordion(id)"
                                                class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
                                            <span>{{$university->name}}</span>
                                            <svg class="w-4 h-4 duration-200 ease-out"
                                                 :class="{ 'rotate-180': activeAccordion==id }" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div x-show="activeAccordion==id" x-collapse x-cloak>
                                            <div class="p-4 pt-0 opacity-70 cursor-default">
                                                This university is in {{$university->country}}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-2 py-3">No one from your programme has added info for minor</div>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
    @endvolt
</x-layouts.app>
