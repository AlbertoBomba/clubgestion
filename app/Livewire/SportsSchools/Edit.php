<?php

namespace App\Livewire\SportsSchools;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SportsSchool;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public SportsSchool $school;
    
    public $name;
    public $description;
    public $address;
    public $city;
    public $province;
    public $postal_code;
    public $phone;
    public $email;
    public $contact_person;
    public $is_active;
    public $logo;
    public $currentLogo;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'province' => 'nullable|string|max:100',
        'postal_code' => 'nullable|string|max:10',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'contact_person' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'logo' => 'nullable|image|max:2048', // Max 2MB
    ];

    public function mount(SportsSchool $school)
    {
        $this->school = $school;
        $this->name = $school->name;
        $this->description = $school->description;
        $this->address = $school->address;
        $this->city = $school->city;
        $this->province = $school->province;
        $this->postal_code = $school->postal_code;
        $this->phone = $school->phone;
        $this->email = $school->email;
        $this->contact_person = $school->contact_person;
        $this->is_active = $school->is_active;
        $this->currentLogo = $school->logo;
    }

    public function deleteLogo()
    {
        if ($this->currentLogo) {
            Storage::disk('public')->delete($this->currentLogo);
            $this->school->update(['logo' => null]);
            $this->currentLogo = null;
            session()->flash('message', 'Logo eliminado correctamente.');
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postal_code' => $this->postal_code,
            'phone' => $this->phone,
            'email' => $this->email,
            'contact_person' => $this->contact_person,
            'is_active' => $this->is_active,
        ];

        // Handle logo upload
        if ($this->logo) {
            // Delete old logo if exists
            if ($this->currentLogo) {
                Storage::disk('public')->delete($this->currentLogo);
            }
            
            // Store new logo
            $logoPath = $this->logo->store('schools/logos', 'public');
            $data['logo'] = $logoPath;
            $this->currentLogo = $logoPath;
        }

        $this->school->update($data);

        session()->flash('message', 'Escuela deportiva actualizada correctamente.');
        
        return redirect()->route('sports-schools.index');
    }

    public function render()
    {
        return view('livewire.sports-schools.edit');
    }
}
