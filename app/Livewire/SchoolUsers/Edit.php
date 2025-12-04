<?php

namespace App\Livewire\SchoolUsers;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\SportsSchool;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    use WithFileUploads;
    
    public User $user;
    
    public $name;
    public $email;
    public $password = '';
    public $password_confirmation = '';
    public $sports_school_id;
    public $role;
    public $is_active;
    public $profile_photo;
    public $current_profile_photo;
    public $document;
    public $documentLabel;
    public $documentType = '';
    public $captureMode = false;
    public $existingDocuments = [];

    protected function rules()
    {
        return [];  // Las reglas se aplican manualmente en save()
    }

    public function mount(User $user)
    {
        if ($user->isMaster()) {
            abort(403, 'No se puede editar el usuario master.');
        }
        
        // Verificar que school_admin solo edite usuarios de su escuela
        $currentUser = auth()->user();
        if ($currentUser->hasRole('school_admin') && $user->sports_school_id !== $currentUser->sports_school_id) {
            abort(403, 'No tienes permiso para editar usuarios de otras escuelas.');
        }
        
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->sports_school_id = $user->sports_school_id;
        $this->role = $user->role;
        $this->is_active = $user->is_active;
        $this->current_profile_photo = $user->profile_photo_path;
        $this->existingDocuments = $user->documents ?? [];
    }

    public function deleteDocument($index)
    {
        if (isset($this->existingDocuments[$index])) {
            $docPath = $this->existingDocuments[$index]['path'];
            
            // Eliminar el archivo físicamente del servidor
            if (Storage::disk('public')->exists($docPath)) {
                Storage::disk('public')->delete($docPath);
            }
            
            // Eliminar del array de documentos existentes
            unset($this->existingDocuments[$index]);
            $this->existingDocuments = array_values($this->existingDocuments);
            
            // Actualizar inmediatamente en la base de datos
            $this->user->update(['documents' => $this->existingDocuments]);
            
            session()->flash('message', 'Documento eliminado exitosamente.');
        }
    }

    public function uploadDocument()
    {
        \Log::info('=== UPLOAD DOCUMENT START ===', [
            'user_id' => $this->user->id,
            'has_document' => !is_null($this->document),
            'document_type' => $this->documentType,
            'document_label' => $this->documentLabel,
        ]);

        // Validar documento
        if (!$this->document) {
            $this->addError('document', 'Debes seleccionar un archivo.');
            return;
        }

        if (empty($this->documentType)) {
            $this->addError('documentType', 'Debes seleccionar un tipo de documento.');
            return;
        }

        if ($this->documentType === 'otros' && empty($this->documentLabel)) {
            $this->addError('documentLabel', 'Debes proporcionar una descripción para el documento.');
            return;
        }

        // Validar el archivo
        $this->validate([
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        \Log::info('Document validation passed');

        // Obtener documentos actuales del usuario
        $savedDocuments = $this->user->documents ?? [];

        // Determinar la etiqueta según el tipo de documento
        $label = match($this->documentType) {
            'dni_frontal' => 'DNI Frontal',
            'dni_trasero' => 'DNI Trasero',
            'otros' => $this->documentLabel ?: 'Documento ' . (count($savedDocuments) + 1),
            default => 'Documento ' . (count($savedDocuments) + 1)
        };

        \Log::info('Document label determined', ['label' => $label]);

        // Guardar el documento
        $path = $this->document->store('user-documents/' . $this->user->id, 'public');

        \Log::info('Document stored', ['path' => $path]);

        $savedDocuments[] = [
            'path' => $path,
            'label' => $label,
            'original_name' => $this->document->getClientOriginalName(),
            'uploaded_at' => now()->toDateTimeString(),
        ];

        // Actualizar solo los documentos del usuario
        $this->user->update(['documents' => $savedDocuments]);

        \Log::info('=== UPLOAD DOCUMENT SUCCESS ===');

        // Resetear campos de documento
        $this->document = null;
        $this->documentType = '';
        $this->documentLabel = '';
        $this->captureMode = false;

        // Actualizar la lista de documentos existentes
        $this->existingDocuments = $savedDocuments;

        session()->flash('message', 'Documento subido exitosamente.');
    }

    public function deleteProfilePhoto()
    {
        if ($this->current_profile_photo) {
            Storage::disk('public')->delete($this->current_profile_photo);
            $this->current_profile_photo = null;
            $this->user->update(['profile_photo_path' => null]);
        }
    }

    public function save()
    {
        // Log al inicio del método
        \Log::info('=== SAVE METHOD START ===', [
            'user_id' => $this->user->id,
            'has_document' => !is_null($this->document),
            'document_type' => $this->documentType,
            'document_label' => $this->documentLabel,
        ]);

        // Forzar escuela del usuario autenticado si es school_admin
        $currentUser = auth()->user();
        if ($currentUser->hasRole('school_admin')) {
            $this->sports_school_id = $currentUser->sports_school_id;
        }
        
        // Validar solo los campos básicos primero
        $basicRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'sports_school_id' => 'required|exists:sports_schools,id',
            'role' => 'required|exists:roles,name',
            'is_active' => 'boolean',
            'profile_photo' => 'nullable|image|max:2048',
        ];
        
        $this->validate($basicRules);
        
        // Si hay documento, validar según el tipo
        if ($this->document) {
            \Log::info('Document validation start', [
                'document_class' => get_class($this->document),
                'document_original_name' => method_exists($this->document, 'getClientOriginalName') ? $this->document->getClientOriginalName() : 'N/A',
            ]);

            if (empty($this->documentType)) {
                \Log::info('Validation failed: documentType empty');
                $this->addError('documentType', 'Debes seleccionar un tipo de documento.');
                return;
            }
            
            if ($this->documentType === 'otros' && empty($this->documentLabel)) {
                \Log::info('Validation failed: documentLabel empty for otros');
                $this->addError('documentLabel', 'Debes proporcionar una descripción para el documento.');
                return;
            }
            
            $this->validate([
                'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ]);
        }

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'sports_school_id' => $this->sports_school_id,
            'role' => $this->role,
            'is_active' => $this->is_active,
        ];

        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        // Actualizar foto de perfil si se subió una nueva
        if ($this->profile_photo) {
            \Log::info('Processing profile photo');
            // Eliminar la foto anterior si existe
            if ($this->current_profile_photo) {
                Storage::disk('public')->delete($this->current_profile_photo);
            }
            $data['profile_photo_path'] = $this->profile_photo->store('profile-photos', 'public');
        }

        // Guardar nuevo documento si hay uno pendiente
        $savedDocuments = $this->existingDocuments;
        if ($this->document) {
            \Log::info('Processing document upload in save method');
            
            // Determinar la etiqueta según el tipo de documento
            $label = match($this->documentType) {
                'dni_frontal' => 'DNI Frontal',
                'dni_trasero' => 'DNI Trasero',
                'otros' => $this->documentLabel ?: 'Documento ' . (count($savedDocuments) + 1),
                default => 'Documento ' . (count($savedDocuments) + 1)
            };
            
            \Log::info('Document label determined', ['label' => $label]);
            
            $path = $this->document->store('user-documents/' . $this->user->id, 'public');
            
            \Log::info('Document stored', ['path' => $path]);
            
            $savedDocuments[] = [
                'path' => $path,
                'label' => $label,
                'original_name' => $this->document->getClientOriginalName(),
                'uploaded_at' => now()->toDateTimeString(),
            ];
        }
        
        // Agregar documentos al array de datos
        $data['documents'] = $savedDocuments;
        
        \Log::info('Updating user', ['data_keys' => array_keys($data)]);
        
        // Actualizar usuario una sola vez con todos los datos
        $this->user->update($data);

        // Sincronizar rol usando Spatie
        $this->user->syncRoles([$this->role]);

        session()->flash('message', 'Usuario actualizado correctamente.');
        
        \Log::info('=== SAVE METHOD END - SUCCESS ===');
        
        // Redirigir a la ruta correcta según el contexto
        $route = (auth()->user()->isMaster() || session()->has('impersonator_id')) 
            ? 'school-users.index' 
            : 'my-school-users.index';
            
        return redirect()->route($route);
    }

    public function render()
    {
        $currentUser = auth()->user();
        
        // Filtrar escuelas según el rol
        $schools = $currentUser->hasRole('school_admin')
            ? SportsSchool::where('id', $currentUser->sports_school_id)->where('is_active', true)->orderBy('name')->get()
            : SportsSchool::where('is_active', true)->orderBy('name')->get();
            
        $roles = Role::where('name', '!=', 'master')->get();
        
        // Obtener equipos si el usuario es entrenador
        $coachTeams = collect();
        if ($this->user->hasRole('coach')) {
            $coachTeams = $this->user->teams()
                ->with(['category', 'season', 'section'])
                ->orderBy('team')
                ->get();
        }
        
        return view('livewire.school-users.edit', [
            'schools' => $schools,
            'roles' => $roles,
            'coachTeams' => $coachTeams,
        ]);
    }
}
