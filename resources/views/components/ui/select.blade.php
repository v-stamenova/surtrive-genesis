@props([
    'label' => null,
    'id' => null,
    'name' => null,
    'mandatory' => null,
    'items' => []
])

@php $wireModel = $attributes->get('wire:model'); @endphp

<div>
    @if($label)
        <label for="{{ $id ?? '' }}"
               class="{{$mandatory ? "after:content-['*'] after:text-red-500" : ''}} block text-sm font-medium leading-5 text-gray-700 dark:text-gray-300">
            {{ $label  }}
        </label>
    @endif

    <select id="{{ $id ?? '' }}" name="{{ $name ?? '' }}"
            data-model="{{ $wireModel }}"
            {{ $attributes->whereStartsWith('wire:model') }} class="text-sm w-full mt-1.5 rounded-md shadow-sm dark:text-gray-300
             border-gray-300 dark:bg-white/[4%] dark:border-white/10 dark:focus:border-gray-700 dark:focus:ring-white/20 dark:placeholder-gray-400">
        @forelse($items as $item)
            <option value="{{$item['value']}}">{{$item['text']}}</option>
        @empty
            <option>No available university</option>
        @endforelse
    </select>

    @error($wireModel)
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
