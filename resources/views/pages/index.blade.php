<?php

use function Laravel\Folio\{middleware, name};
use function Livewire\Volt\{state, rules};

name('home');

state(['buttonLabel' => Auth::user() ? "Go to Your Dashboard" : "Try it yourself",
    'buttonRoute' => Auth::user() ? 'dashboard' : 'register']);

?>

<x-layouts.marketing>

    @volt('home')
    <div class="relative flex flex-col items-center justify-center w-full h-auto overflow-hidden" x-cloak>

        <div
            class="absolute top-0 left-0 w-2/5 ml-56 -translate-x-1/2 fill-current opacity-10 dark:opacity-5 text-slate-400">
            <img src="img/front-page-penguin-left.png">
        </div>

        <div
            class="absolute -mb-20 bottom-0 right-0 w-7/12 -mr-20 translate-x-1/2 fill-current opacity-10 dark:opacity-5 text-slate-400">
            <img src="img/front-page-penguin-right.png">
        </div>

        <div class="flex items-center w-full max-w-6xl px-8 pt-12 pb-20 mx-auto">
            <div class="container relative max-w-4xl mx-auto mt-20 text-center sm:mt-24 lg:mt-32">
                <div style="background-image:linear-gradient(160deg,#3552e6,#8f35e3 50%,#73f7f8, #29a2ed)"
                     class="inline-block w-auto p-0.5 shadow rounded-full animate-gradient">
                    <p class="w-auto h-full px-3 bg-slate-50 dark:bg-neutral-900 dark:text-white py-1.5 font-medium text-sm tracking-widest uppercase  rounded-full text-slate-800/90 group-hover:text-white/100">
                        Welcome to surtrive</p>
                </div>
                <h1 class="mt-5 text-4xl font-light leading-tight tracking-tight text-center dark:text-white text-slate-800 sm:text-5xl md:text-8xl">
                    Organize your<br> Third Year Plan.</h1>
                <p class="w-full max-w-2xl mx-auto mt-8 text-lg dark:text-white/60 text-slate-500">The "I am second year in HZ" starter pack includes but not limited to: the stress pack <span class="italic">What am I doing for my
                    <span class="text-red-700 dark:text-red-500 animate-pulse">minor</span> and <span class="text-red-700 dark:text-red-500 animate-pulse">internship</span></span>. Do yourself a favour - organize your favorites with Surtrive.
                <div class="flex items-center justify-center w-full max-w-sm px-5 mx-auto mt-8 space-x-5">
                    <x-ui.button wire:navigate type="primary" tag="a" href="{{route($buttonRoute)}}">{{$buttonLabel}}</x-ui.button>
                </div>
            </div>
        </div>

    </div>
    @endvolt

</x-layouts.marketing>
