<?php

namespace App\Livewire\SportsSchools;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SportsSchool;
use App\Models\Category;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $name = '';
    public $description = '';
    public $address = '';
    public $city = '';
    public $province = '';
    public $postal_code = '';
    public $phone = '';
    public $email = '';
    public $contact_person = '';
    public $is_active = true;
    public $logo;

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
        'logo' => 'nullable|image|max:2048',
    ];

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
            $logoPath = $this->logo->store('schools/logos', 'public');
            $data['logo'] = $logoPath;
        }

        $school = SportsSchool::create($data);

        // Crear categorías genéricas para la nueva escuela
        $this->createDefaultCategories($school);

        session()->flash('message', 'Escuela deportiva creada correctamente.');
        
        return redirect()->route('sports-schools.index');
    }

    /**
     * Crear categorías por defecto para la escuela
     */
    protected function createDefaultCategories(SportsSchool $school)
    {
        $defaultCategories = config('constants.categories', []);

        foreach ($defaultCategories as $categoryData) {
            Category::create([
                'sports_school_id' => $school->id,
                'category' => $categoryData['category'],
                'description' => $categoryData['description'],
                'from_age' => $categoryData['from_age'],
                'to_age' => $categoryData['to_age'],
                'modality' => $categoryData['modality'] ?? null,
                'created_user' => auth()->id(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.sports-schools.create');
    }
}
