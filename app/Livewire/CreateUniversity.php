<?php

namespace App\Livewire;

use App\Models\University;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CreateUniversity extends Component
{
    public $name;

    public $country;

    public $items;

    protected $rules = [
        'name' => 'required|unique:universities',
        'country' => 'required',
    ];

    public function mount()
    {
        $this->items = collect(json_decode(Http::get("https://restcountries.com/v3.1/all?fields=name")))->map(function ($item) {
            return [
                'value' => $item->name->common,
                'text' => $item->name->common,
            ];
        })->sortBy('text');

        $this->country = $this->items[0]['value'];
    }

    public function render()
    {
        return view('livewire.create-university');
    }

    public function createUniversity()
    {
        $validated = $this->validate();

        University::create($validated);

        $this->redirect(route('minors.create'), navigate: true);
    }

}
