<?php

namespace App\Livewire\Members;

use App\Models\Member;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $surname = '';
    public string $dni = '';
    public string $email = '';
    public string $phone = '';
    public string $birth_date = '';
    public string $address = '';
    public bool $active = true;
    public $photo = null;

    protected function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'surname'    => 'required|string|max:255',
            'dni'        => 'nullable|string|max:20',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|string|max:30',
            'birth_date' => 'nullable|date',
            'address'    => 'nullable|string|max:500',
            'active'     => 'boolean',
            'photo'      => 'nullable|image|max:2048',
        ];
    }

    protected $messages = [
        'name.required'    => 'El nombre es obligatorio.',
        'surname.required' => 'Los apellidos son obligatorios.',
        'email.email'      => 'El email no es válido.',
        'photo.image'      => 'La foto debe ser una imagen.',
        'photo.max'        => 'La foto no puede superar 2MB.',
    ];

    public function save(): mixed
    {
        $this->validate();

        $schoolId = auth()->user()->sports_school_id;

        // Generate member number
        $lastNumber = Member::where('sports_school_id', $schoolId)
            ->whereNotNull('member_number')
            ->orderByRaw('CAST(REGEXP_REPLACE(member_number, "[^0-9]", "") AS UNSIGNED) DESC')
            ->value('member_number');

        $nextNum = 1;
        if ($lastNumber && preg_match('/(\d+)$/', $lastNumber, $m)) {
            $nextNum = (int) $m[1] + 1;
        }
        $memberNumber = str_pad($nextNum, 4, '0', STR_PAD_LEFT);

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('members/photos', 'public');
        }

        Member::create([
            'sports_school_id' => $schoolId,
            'member_number'    => $memberNumber,
            'name'             => $this->name,
            'surname'          => $this->surname,
            'dni'              => $this->dni ?: null,
            'email'            => $this->email ?: null,
            'phone'            => $this->phone ?: null,
            'birth_date'       => $this->birth_date ?: null,
            'address'          => $this->address ?: null,
            'photo'            => $photoPath,
            'active'           => $this->active,
        ]);

        session()->flash('message', 'Socio creado correctamente.');

        return redirect()->route('members.index');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.members.create');
    }
}
