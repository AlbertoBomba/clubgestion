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

    protected $rules = [
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

        session()->flash('message', 'Jugador actualizado correctamente.');
        
        return redirect()->route('players.index');
    }

    public function render()
    {
        return view('livewire.players.edit');
    }
}
