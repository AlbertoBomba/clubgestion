<?php

namespace App\Livewire\ExerciseTypes;

use App\Models\ExerciseType;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255|unique:exercise_types,name',
        'description' => 'nullable|string',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.unique' => 'Ya existe un tipo de ejercicio con este nombre.',
    ];

    public function save()
    {
        $this->validate();

        ExerciseType::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Tipo de ejercicio creado correctamente.');
        return redirect()->route('exercise-types.index');
    }

    public function render()
    {
        return view('livewire.exercise-types.create');
    }
}
