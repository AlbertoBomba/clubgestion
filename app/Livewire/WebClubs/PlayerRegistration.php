<?php

namespace App\Livewire\WebClubs;

use App\Models\Season;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Category;
use App\Models\Player;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use App\Models\Size;
use App\Services\SchoolMailer;
use App\Models\SportsSchool;
use App\Mail\PlayerRegistrationConfirmation;
use App\Models\SeasonPlayer;
use App\Models\Section;

class PlayerRegistration extends Component
{
    use WithFileUploads;

    public $school;
    public $openInscriptionSeasons;

    /** Whether the form was accessed from the team admin dashboard */
    public bool $fromDashboard = false;

    /** Current wizard step (1-5) */
    public int $step = 1;
    public int $totalSteps = 5;

    // ── Step 1: Personal data ──────────────────────────────
    public string $player_name      = '';
    public string $player_surname   = '';
    public string $player_birthdate = '';   // yyyy-mm-dd
    public string $docType   = 'dni';
    public string $docNumber = '';
    public        $docFront  = null;  // UploadedFile
    public        $docBack   = null;  // UploadedFile
    public bool   $federado   = false;
    public bool   $isAdult    = false; // true if player is 18 or older

    /** Category matched from birthdate (filled by updatedPlayerBirthdate) */
    public ?string $suggestedCategory = null;

    // ── Step 2: Tutor data & address & contact ──────────────────────────────────
    public string $name_tutor      = '';
    public string $dnitutor      = '';
    public string $address         = '';
    public string $town         = '';
    public string $zip         = '';
    public string $province         = '';
    public string $phone1         = '';
    public string $phone2         = '';
    public string $email     = '';
  


    // ── Step 3: Sports + extra docs ───────────────────────
    public string $position   = '';
    public string $dorsal     = '';
    public string $fedTeam    = '';   // team name if federado
    public        $photo      = null; // UploadedFile – profile photo
    public $sections; // Collection of sections for the current season
    public $selectedSections = []; // Array of selected section IDs
    public array $sectionPrices = []; // [section_id => price from season_section pivot]
    public string $sizes    = '';
    public $availableSizes = []; // Collection of sizes available for the school

    // ── Step 4: Signature ───────────────────────────────────────
    /** PNG signature as data URL (base64) provided by the canvas */
    public ?string $signature = null;

    // ── Step 5: Done ────────────────────────────────────────────────
    public bool   $done       = false;
    public string $doneMessage = '';

    // ── Validation rules per step ─────────────────────────
    protected function rulesForStep(int $step): array
    {

        if($this->federado){
            $rule_docType = 'required|in:dni,nie,passport';
            $rule_docNumber = 'required|string|min:1|max:30';
            $rule_docFront = 'required|file|max:10240';
            $rule_docBack = $this->docType === 'passport' ? 'nullable|file|max:10240' : 'required|file|max:10240';
            $rule_photo = 'required|file|max:10240';
        }else{
            $rule_docType = 'nullable|in:dni,nie,passport';
            $rule_docNumber = 'nullable|string|min:1|max:30';
            $rule_docFront = 'nullable|file|max:10240';
            $rule_docBack = 'nullable|file|max:10240';
            $rule_photo = 'nullable|file|max:10240';
        }

        if($this->isAdult){
            $rule_name_tutor = 'nullable|string|max:100';
            $rule_phone_jugador = 'required|string|max:20'; //phone 1
            $rule_phone_tutor = 'nullable|string|max:20'; //phone 2
            $rule_dnitutor = 'nullable|string|max:30';
        }else{
            $rule_name_tutor = 'required|string|max:100';
            $rule_phone_jugador = 'nullable|string|max:20'; //phone 1
            $rule_phone_tutor = 'required|string|max:20'; //phone 2
            $rule_dnitutor = 'required|string|max:30';

        }

        return match ($step) {
            1 => [
                'player_name'      => 'required|string|max:100',
                'player_surname'   => 'required|string|max:100',
                'player_birthdate' => 'required|date',
                'phone1' => $rule_phone_jugador,
                'docType'   => $rule_docType,
                'docNumber' => $rule_docNumber,
                'docFront'  => $rule_docFront,
                'docBack'   => $rule_docBack,
            ],
            2 => [
                'name_tutor' => $rule_name_tutor,
                'dnitutor' => $rule_dnitutor,
                'address'    => 'required|string|max:200',
                'zip'        => 'required|string|max:10',
                'town'       => 'required|string|max:100',
                'province'   => 'required|string|max:100',
                
                'phone2' => $rule_phone_tutor,
                'email'  => 'required|email|max:150',
            ],
            3 => [
                'position'  => 'nullable|string|max:50',
                'dorsal'    => 'nullable|integer|min:1|max:99',
                'photo'     => $rule_photo,
                'selectedSections' => 'required|array|min:1',
                'sizes'      => 'required|string|max:10',

                
                // 'extraDoc'  => 'nullable|file|max:15360',
            ],
            4 => [
                'signature' => ['required', 'string', 'starts_with:data:image/png;base64,', 'max:500000'],
            ],
            default => [],
        };
    }

    protected function messages(): array
    {
        return [
            'player_name.required' => 'El nombre del jugador es obligatorio.',
            'player_surname.required' => 'El apellido del jugador es obligatorio.',
            'player_birthdate.required' => 'La fecha de nacimiento del jugador es obligatoria.',
            'player_birthdate.date' => 'La fecha de nacimiento debe tener un formato válido (AAAA-MM-DD).',
            'phone1.required' => 'El teléfono de contacto es obligatorio.',
            'email.required' => 'El email de contacto es obligatorio.',
            'docNumber.required' => 'El número de documento de identidad es obligatorio.',
            'docFront.required' => 'El documento de identidad es obligatorio.',
            'docBack.required'  => 'El documento de identidad (reverso) es obligatorio.',
            'photo.required'    => 'La foto del jugador es obligatoria.',

            'name_tutor.required' => 'El nombre del tutor es obligatorio.',
            'dnitutor.required' => 'El DNI del tutor es obligatorio.',
            'address.required' => 'La dirección es obligatoria.',
            'zip.required' => 'El código postal es obligatorio.',
            'town.required' => 'La localidad es obligatoria.',
            'province.required' => 'La provincia es obligatoria.',
            'phone1.required' => 'El teléfono del jugador es obligatorio.',
            'phone2.required' => 'El teléfono del tutor es obligatorio.',

            'selectedSections.required' => 'Debes seleccionar al menos una sección.',
            'selectedSections.array' => 'El valor de las secciones seleccionadas debe ser un array.',
            'selectedSections.min' => 'Debes seleccionar al menos una sección.',
            'sizes.required' => 'Debes seleccionar una talla.',

            'signature.required'=> 'La firma es obligatoria.',
           
           
        ];
    }

    // ── Navigation ────────────────────────────────────────
    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step), $this->messages());
        // After step 2: check the player isn't already registered in this tournament
        if ($this->step === 2) {
            // $this->checkDuplicatePlayer();
        }
        if ($this->step < $this->totalSteps) {
            $this->step++;
        }
    }
    
    public function prevStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    /** Restore step after a tab kill (used by the JS sessionStorage recovery). */
    public function setStep(int $step): void
    {
        if ($step >= 1 && $step <= $this->totalSteps && !$this->done) {
            $this->step = $step;
        }
    }

    

    public function mount()
    {

        $this->school = currentSchool();
        //comprueba que la url tiene una escuela asociada, si no la tiene aborta con error 404
        $this->step = 1;
        $this->totalSteps = 5;
        if (!$this->school) {
            abort(404, 'Escuela no encontrada');
        }

        $now = now()->toDateString();

        $seasons = Season::where('sports_school_id', $this->school->id)->get();

        $this->openInscriptionSeasons = $seasons->filter(function($season) use ($now) {
            return $season->inscription_start_at && $season->inscription_end_at &&
                   $season->inscription_start_at <= $now &&
                   $season->inscription_end_at >= $now;
        });

        if ($this->openInscriptionSeasons->isEmpty()) {
            abort(404, 'No hay temporadas abiertas para inscripción en esta escuela.');
        }

        $season   = $this->openInscriptionSeasons?->first();
        $this->sections = $season?->sections ?? collect();

        

        foreach ($this->sections as $section) {
            $this->sectionPrices[$section->id] = $section->pivot->price;
        }

         // Obtener tallas asociadas a la escuela
        $this->availableSizes = Size::whereHas('brand.sportsSchools', function($query) {
            $query->where('sports_schools.id', $this->school->id);
        })->with('brand')->orderBy('brand_id')->orderBy('order')->orderBy('size')->get();

        // dd($this->availableSizes);
    }

     public function updatedPlayerBirthdate(): void
    {
        $this->suggestedCategory = null;

        if (!$this->player_birthdate) {
            return;
        }

        try {
            $birthYear = (int) \Carbon\Carbon::parse($this->player_birthdate)->format('Y');
        } catch (\Exception $e) {
            return;
        }

        $season = $this->openInscriptionSeasons?->first();
        if (!$season || !$season->from_year) {
            return;
        }


        $ageAtSeasonStart = (int) $season->from_year - $birthYear;

        if($ageAtSeasonStart >= 18){
            $this->isAdult = true;
        } else {
            $this->isAdult = false;
        }

        $category = Category::where('sports_school_id', $this->school->id)
            ->where('from_age', '<=', $ageAtSeasonStart)
            ->where('to_age', '>=', $ageAtSeasonStart)
            ->first();
        
        $this->suggestedCategory = $category?->category;



        if ($this->suggestedCategory==='Juvenil' || $this->suggestedCategory==='Senior') {
            $this->federado = true;
        } else {
            $this->federado = false;
        }
    }
    
    // ── Submit ────────────────────────────────────────────
    public function submit(): void
    {
        $this->validate($this->rulesForStep(1), $this->messages());
        $this->validate($this->rulesForStep(2), $this->messages());
        $this->validate($this->rulesForStep(3), $this->messages());        
        $this->validate($this->rulesForStep(4), $this->messages());

        // Handle new photo upload
        if ($this->photo) {
            $photoPath = $this->photo->store('players/photos', 'public');
            $data['player_photo'] = $photoPath;
        }

        $data = [
            'sports_school_id' => $this->school->id,
            'name' => $this->player_name,
            'surname' => $this->player_surname,
            'dni' => $this->docNumber,
            'dbirth' => $this->player_birthdate,
            'dbanio' => \Carbon\Carbon::parse($this->player_birthdate)->format('Y'),
            'nametutor' => $this->name_tutor,
            'surnametutor' => '',
            'dnitutor' => '',//poner dni del tutor si es necesario
            'address' => $this->address,
            'town' => $this->town,
            'province' => $this->province,
            'zip' => $this->zip,
            'phone1' => $this->phone1, //teléfono jugador
            'phone2' => $this->phone2, //teléfono tutor
            'email' => $this->email,
            'sizes' => $this->sizes,
            'active' => true,
            // 'file' => $this->file,
            // 'observations' => $this->observations,
            'updated_user' =>  1,
        ];

        // Handle photo upload
        if ($this->photo) {
            $photoPath = $this->photo->store('players/photos', 'public');
            $data['player_photo'] = $photoPath;
        }

        $player = Player::create($data);

        if ($this->openInscriptionSeasons) {
            $player->seasons()->attach($this->openInscriptionSeasons->first()->id, [
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }

        // 1 Generar el código directo con las IDs conocidas (8 dígitos) para la matricula
        $cod_matricula = sprintf("%03d%05d", $this->openInscriptionSeasons->first()->id, $player->id);
        $player->update(['cod_matricula' => $cod_matricula]);
        
        // Sincronizar secciones
        if (!empty($this->selectedSections)) {
            $player->sections()->attach($this->selectedSections, [
                'created_user' => 1,
                'updated_user' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        

        // Obtener documentos actuales del jugador
        $savedDocuments = $player->documents ?? [];
   
        // Document front
        if ($this->docFront) {

            $label = 'DNI Frontal';

            // Guardar el documento
            $path_docFront = $this->docFront->store('player-documents/' . $player->id, 'public');
            $savedDocuments[] = [
                'path' => $path_docFront,
                'label' => $label,
                'original_name' => $this->docFront->getClientOriginalName(),
                'uploaded_at' => now()->toDateTimeString(),
            ];

            // $path = $this->document->store('player-documents/' . $this->playerModel->id, 'public');
            // $data['doc_front'] = $this->docFront->store('tournament-players/docs', 'public');
        }

        // // Document back
        if ($this->docBack) {
            $label = 'DNI Reverso';
            
            $path_docBack = $this->docBack->store('player-documents/' . $player->id, 'public');
            $savedDocuments[] = [
                'path' => $path_docBack,
                'label' => $label,
                'original_name' => $this->docBack->getClientOriginalName(),
                'uploaded_at' => now()->toDateTimeString(),
            ];
        }

        // Actualizar solo los documentos del jugador
        $player->update(['documents' => $savedDocuments]);

       

        // Signature: decode the data URL and save as PNG file
        if ($this->signature && str_starts_with($this->signature, 'data:image/png;base64,')) {
            $base64 = substr($this->signature, strlen('data:image/png;base64,'));
            $binary = base64_decode($base64, true);
            if ($binary !== false) {
                $filename = 'players/signatures/' . \Illuminate\Support\Str::uuid() . '.png';
                Storage::disk('public')->put($filename, $binary);
                $data['signature'] = $filename;
            }
        }

        $player->update(['signature' => $data['signature'] ?? null]);

        $this->doneMessage = $this->fromDashboard
            ? 'Jugador inscrito correctamente.'
            : 'Tu inscripción se ha registrado correctamente. Recibirá un correo con la confirmación de la inscripción.';

        $this->done = true;
        if(!$this->fromDashboard){
            $this->sendConfirmationEmail($player);
        }
        $this->step = $this->totalSteps;
    }

    protected function sendConfirmationEmail(Player $player): void
    {
        if (empty($player->email)) {
            return;
        }

        $school = $this->school ?? new SportsSchool();
        $season = $this->openInscriptionSeasons?->first();

        $sectionsData = [];
        $totalPrice = 0.0;
        if (!empty($this->selectedSections)) {
            $sectionModels = Section::whereIn('id', $this->selectedSections)->get();
            foreach ($sectionModels as $section) {
                $price = (float) ($this->sectionPrices[$section->id] ?? 0);
                $sectionsData[] = [
                    'name'  => $section->name,
                    'price' => $price,
                ];
                $totalPrice += $price;
            }
        }

        $mailable = new PlayerRegistrationConfirmation(
            player: $player,
            school: $school,
            season: $season,
            sections: $sectionsData,
            totalPrice: $totalPrice,
        );

        try {
            SchoolMailer::forSchool($school)
                ->to($player->email, $player->name)
                ->send($mailable);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Error enviando email de confirmación de inscripción', [
                'player_id' => $player->id,
                'error'     => $e->getMessage(),
            ]);
        }
    }

   

    public function render()
    {
        return view('livewire.webclubs.player-registration', [
            'docTypes'   => Player::docTypes(),
            'positions'  => Player::positions(),
            'schoolName' => currentSchool()?->name ?? config('app.name'),
        ])->layout('livewire.webclubs.layouts.app');
        // return view('livewire.webclubs.player-registration')
        //     ->layout('livewire.webclubs.layouts.app', [
        //         'title' => tenantName() . ' - Inscripción'
        //     ]);
    }
}
