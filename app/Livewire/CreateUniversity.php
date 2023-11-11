<?php

namespace App\Livewire;

use App\Models\University;
use Livewire\Component;

class CreateUniversity extends Component
{
    public $name;

    public $country;

    protected $rules = [
        'name' => 'required|unique:universities',
        'country' => 'required',
    ];


    public function render()
    {
        return view('livewire.create-university');
    }

    public function createUniversity()
    {
        $validated = $this->validate();

        University::create($validated);

        $this->redirect(route('minor.create'), navigate: true);
    }

}
