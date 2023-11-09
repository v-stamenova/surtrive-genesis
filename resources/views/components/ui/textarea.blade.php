@props([
    'label' => null,
    'id' => null,
    'name' => null,
    'type' => 'text',
    'mandatory' => null,
    'additional_info' => null
])

@php $wireModel = $attributes->get('wire:model'); @endphp

<div>
    @if($label)
        <label for="{{ $id ?? '' }}" class="{{$mandatory ? "after:content-['*'] after:text-red-500" : ''}} block text-sm font-medium leading-5 text-gray-700 dark:text-gray-300">
            {{ $label  }}
        </label>
    @endif
    @if($additional_info)
        <p class="text-xs text-gray-700 dark:text-gray-300">{{$additional_info}}</p>
    @endif

        <div class="w-full mt-1.5" data-model="{{ $wireModel }}">
            <textarea {{ $attributes->whereStartsWith('wire:model') }}  x-data="{
                resize () {
                    $el.style.height = '0px';
                    $el.style.height = $el.scrollHeight + 'px'
                }
            }"
              x-init="resize()"
              @input="resize()" id="{{ $id ?? '' }}" name="{{ $name ?? '' }}" type="{{ $type ?? '' }}"
              class="flex w-full h-auto min-h-[80px] px-3 py-2 text-sm bg-white dark:text-gray-300 dark:bg-white/[4%] border rounded-md border-gray-300 dark:border-white/10 ring-offset-background placeholder:text-gray-500 dark:placeholder:text-gray-400 focus:border-gray-300 dark:focus:border-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200/60 dark:focus:ring-white/20 disabled:cursor-not-allowed disabled:opacity-50 @error($wireModel) border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror"
            ></textarea>
        </div>

    @error($wireModel)
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
