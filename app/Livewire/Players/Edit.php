<?php

namespace App\Livewire\Players;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Player;

class Edit extends Component
{
    use WithFileUploads;

    public Player $playerModel;
    
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
    public $currentPhoto;
    public $selectedSeasons = [];
    public $selectedSections = [];
    public $hasChanges = false;
    
    // Valores originales para detectar cambios
    private $originalName;
    private $originalSurname;
    private $originalDni;
    private $originalDbirth;
    private $originalDbanio;
    private $originalNametutor;
    private $originalSurnametutor;
    private $originalDnitutor;
    private $originalAddress;
    private $originalTown;
    private $originalProvince;
    private $originalZip;
    private $originalPhone1;
    private $originalPhone2;
    private $originalEmail;
    private $originalDorsal;
    private $originalPosition;
    private $originalSizes;
    private $originalCodMatricula;
    private $originalActive;
    private $originalSoccer;
    private $originalPassport;
    private $originalPaddle;
    private $originalGoalie;
    private $originalFile;
    private $originalObservations;
    private $originalSelectedSeasons = [];
    private $originalSelectedSections = [];

    public function updated($propertyName)
    {
        // Detectar cambios en cualquier propiedad
        $this->checkForChanges();
    }

    private function checkForChanges()
    {
        $this->hasChanges = 
            $this->name !== $this->originalName ||
            $this->surname !== $this->originalSurname ||
            $this->dni !== $this->originalDni ||
            $this->dbirth !== $this->originalDbirth ||
            $this->dbanio !== $this->originalDbanio ||
            $this->nametutor !== $this->originalNametutor ||
            $this->surnametutor !== $this->originalSurnametutor ||
            $this->dnitutor !== $this->originalDnitutor ||
            $this->address !== $this->originalAddress ||
            $this->town !== $this->originalTown ||
            $this->province !== $this->originalProvince ||
            $this->zip !== $this->originalZip ||
            $this->phone1 !== $this->originalPhone1 ||
            $this->phone2 !== $this->originalPhone2 ||
            $this->email !== $this->originalEmail ||
            $this->dorsal !== $this->originalDorsal ||
            $this->position !== $this->originalPosition ||
            $this->sizes !== $this->originalSizes ||
            $this->cod_matricula !== $this->originalCodMatricula ||
            $this->active !== $this->originalActive ||
            $this->soccer !== $this->originalSoccer ||
            $this->passport !== $this->originalPassport ||
            $this->paddle !== $this->originalPaddle ||
            $this->goalie !== $this->originalGoalie ||
            $this->file !== $this->originalFile ||
            $this->observations !== $this->originalObservations ||
            count(array_diff($this->selectedSeasons, $this->originalSelectedSeasons)) > 0 ||
            count(array_diff($this->originalSelectedSeasons, $this->selectedSeasons)) > 0 ||
            count(array_diff($this->selectedSections, $this->originalSelectedSections)) > 0 ||
            count(array_diff($this->originalSelectedSections, $this->selectedSections)) > 0;
    }

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

    public function mount(Player $player)
    {
        // Verificar que el jugador pertenece a la escuela del usuario
        if ($player->sports_school_id !== auth()->user()->sports_school_id) {
            abort(403, 'No tienes permisos para editar este jugador.');
        }

        $this->playerModel = $player;
        $this->name = $player->name;
        $this->surname = $player->surname;
        $this->dni = $player->dni;
        $this->dbirth = $player->dbirth ? $player->dbirth->format('Y-m-d') : '';
        $this->dbanio = $player->dbanio;
        $this->nametutor = $player->nametutor;
        $this->surnametutor = $player->surnametutor;
        $this->dnitutor = $player->dnitutor;
        $this->address = $player->address;
        $this->town = $player->town;
        $this->province = $player->province;
        $this->zip = $player->zip;
        $this->phone1 = $player->phone1;
        $this->phone2 = $player->phone2;
        $this->email = $player->email;
        $this->dorsal = $player->dorsal;
        $this->position = $player->position;
        $this->sizes = $player->sizes;
        $this->cod_matricula = $player->cod_matricula;
        $this->active = $player->active;
        $this->soccer = $player->soccer;
        $this->passport = $player->passport;
        $this->paddle = $player->paddle;
        $this->goalie = $player->goalie;
        $this->file = $player->file;
        $this->observations = $player->observations;
        $this->currentPhoto = $player->player_photo;
        $this->selectedSeasons = $player->seasons->pluck('id')->toArray();
        $this->selectedSections = $player->sections->pluck('id')->toArray();
        
        // Guardar valores originales para detectar cambios
        $this->originalName = $this->name;
        $this->originalSurname = $this->surname;
        $this->originalDni = $this->dni ?? '';
        $this->originalDbirth = $this->dbirth ?? '';
        $this->originalDbanio = $this->dbanio ?? '';
        $this->originalNametutor = $this->nametutor ?? '';
        $this->originalSurnametutor = $this->surnametutor ?? '';
        $this->originalDnitutor = $this->dnitutor ?? '';
        $this->originalAddress = $this->address ?? '';
        $this->originalTown = $this->town ?? '';
        $this->originalProvince = $this->province ?? '';
        $this->originalZip = $this->zip ?? '';
        $this->originalPhone1 = $this->phone1 ?? '';
        $this->originalPhone2 = $this->phone2 ?? '';
        $this->originalEmail = $this->email ?? '';
        $this->originalDorsal = $this->dorsal ?? '';
        $this->originalPosition = $this->position ?? '';
        $this->originalSizes = $this->sizes ?? '';
        $this->originalCodMatricula = $this->cod_matricula ?? '';
        $this->originalActive = $this->active;
        $this->originalSoccer = $this->soccer;
        $this->originalPassport = $this->passport;
        $this->originalPaddle = $this->paddle;
        $this->originalGoalie = $this->goalie;
        $this->originalFile = $this->file;
        $this->originalObservations = $this->observations ?? '';
        $this->originalSelectedSeasons = $this->selectedSeasons;
        $this->originalSelectedSections = $this->selectedSections;
    }

    public function deletePhoto()
    {
        if ($this->currentPhoto && \Storage::disk('public')->exists($this->currentPhoto)) {
            \Storage::disk('public')->delete($this->currentPhoto);
        }
        
        $this->playerModel->update(['player_photo' => null]);
        $this->currentPhoto = null;
        
        session()->flash('message', 'Foto eliminada correctamente.');
    }

    public function save()
    {
        $this->validate();

        $data = [
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
            'updated_user' => auth()->id(),
        ];

        // Handle new photo upload
        if ($this->player_photo) {
            // Delete old photo
            if ($this->currentPhoto && \Storage::disk('public')->exists($this->currentPhoto)) {
                \Storage::disk('public')->delete($this->currentPhoto);
            }
            
            $photoPath = $this->player_photo->store('players/photos', 'public');
            $data['player_photo'] = $photoPath;
        }

        $this->playerModel->update($data);

        // Sync seasons
        $this->playerModel->seasons()->sync(
            collect($this->selectedSeasons)->mapWithKeys(function ($seasonId) {
                return [$seasonId => [
                    'updated_user' => auth()->id(),
                    'updated_at' => now(),
                ]];
            })->toArray()
        );

        // Sync sections
        $this->playerModel->sections()->sync(
            collect($this->selectedSections)->mapWithKeys(function ($sectionId) {
                return [$sectionId => [
                    'updated_user' => auth()->id(),
                    'updated_at' => now(),
                ]];
            })->toArray()
        );

        // Resetear indicador de cambios
        $this->hasChanges = false;

        session()->flash('message', 'Jugador actualizado correctamente.');
        
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

        return view('livewire.players.edit', [
            'seasons' => $seasons,
            'sections' => $sections
        ]);
    }
}
