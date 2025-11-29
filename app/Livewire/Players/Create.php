<?php

namespace App\Livewire\Players;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Player;

class Create extends Component
{
    use WithFileUploads;

    // Datos personales
    public $name = '';
    public $surname = '';
    public $dni = '';
    public $dbirth = '';
    public $dbanio = '';
    
    // Tutor
    public $nametutor = '';
    public $surnametutor = '';
    public $dnitutor = '';
    
    // Contacto
    public $address = '';
    public $town = '';
    public $province = '';
    public $zip = '';
    public $phone1 = '';
    public $phone2 = '';
    public $email = '';
    
    // Datos deportivos
    public $selectedSeasons = [];
    public $dorsal = '';
    public $position = '';
    public $sizes = '';
    public $cod_matricula = '';
    
    // Booleanos
    public $active = true;
    public $soccer = false;
    public $passport = false;
    public $paddle = false;
    public $goalie = false;
    public $file = false;
    
    // Otros
    public $observations = '';
    public $player_photo;
    public $selectedSections = [];

    protected $rules = [
        'selectedSeasons' => 'required|array|min:1',
        'selectedSeasons.*' => 'exists:seasons,id',
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'dni' => 'nullable|string|max:20',
        'dbirth' => 'nullable|date',
        'dbanio' => 'nullable|integer|min:1900|max:2100',
        'nametutor' => 'nullable|string|max:255',
        'surnametutor' => 'nullable|string|max:255',
        'dnitutor' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'town' => 'nullable|string|max:100',
        'province' => 'nullable|string|max:100',
        'zip' => 'nullable|string|max:10',
        'phone1' => 'nullable|string|max:20',
        'phone2' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'dorsal' => 'nullable|integer|min:0|max:999',
        'position' => 'nullable|string|max:50',
        'sizes' => 'nullable|string|max:50',
        'cod_matricula' => 'nullable|string|max:50',
        'observations' => 'nullable|string',
        'player_photo' => 'nullable|image|max:2048',
        'selectedSections' => 'nullable|array',
        'selectedSections.*' => 'exists:sections,id',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'sports_school_id' => auth()->user()->sports_school_id,
            'name' => $this->name,
            'surname' => $this->surname,
            'dni' => $this->dni,
            'dbirth' => $this->dbirth,
            'dbanio' => $this->dbanio,
            'nametutor' => $this->nametutor,
            'surnametutor' => $this->surnametutor,
            'dnitutor' => $this->dnitutor,
            'address' => $this->address,
            'town' => $this->town,
            'province' => $this->province,
            'zip' => $this->zip,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'email' => $this->email,
            'dorsal' => $this->dorsal ?: null,
            'position' => $this->position,
            'sizes' => $this->sizes,
            'cod_matricula' => $this->cod_matricula,
            'active' => $this->active,
            'soccer' => $this->soccer,
            'passport' => $this->passport,
            'paddle' => $this->paddle,
            'goalie' => $this->goalie,
            'file' => $this->file,
            'observations' => $this->observations,
            'created_user' => auth()->id(),
        ];

        // Handle photo upload
        if ($this->player_photo) {
            $photoPath = $this->player_photo->store('players/photos', 'public');
            $data['player_photo'] = $photoPath;
        }

        $player = Player::create($data);

        // Sync seasons
        if (!empty($this->selectedSeasons)) {
            $player->seasons()->attach($this->selectedSeasons, [
                'created_user' => auth()->id(),
                'updated_user' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Sync sections
        if (!empty($this->selectedSections)) {
            $player->sections()->attach($this->selectedSections, [
                'created_user' => auth()->id(),
                'updated_user' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        session()->flash('message', 'Jugador creado correctamente.');
        
        return redirect()->route('players.index');
    }

    public function render()
    {
        // Obtener temporadas de la escuela
        $seasons = \App\Models\Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderBy('from_year', 'desc')
            ->get();

        // Obtener las secciones de todas las temporadas seleccionadas
        $sections = collect();
        if (!empty($this->selectedSeasons)) {
            $sections = \App\Models\Section::whereHas('seasons', function($query) {
                $query->whereIn('seasons.id', $this->selectedSeasons)
                      ->where('active', true);
            })->distinct()->orderBy('name')->get();
        }
            
        return view('livewire.players.create', [
            'seasons' => $seasons,
            'sections' => $sections
        ]);
    }
}
