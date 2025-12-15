<?php

namespace App\Livewire\ExerciseTypes;

use App\Models\ExerciseType;
use Livewire\Component;

class Edit extends Component
{
    public ExerciseType $type;
    public $name;
    public $description;

    public function mount()
    {
        $this->name = $this->type->name;
        $this->description = $this->type->description;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:exercise_types,name,' . $this->type->id,
            'description' => 'nullable|string',
        ];
    }

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'name.unique' => 'Ya existe un tipo de ejercicio con este nombre.',
    ];

    public function update()
    {
        $this->validate();

        $this->type->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('message', 'Tipo de ejercicio actualizado correctamente.');
        return redirect()->route('exercise-types.index');
    }

    public function render()
    {
        return view('livewire.exercise-types.edit');
    }
}
