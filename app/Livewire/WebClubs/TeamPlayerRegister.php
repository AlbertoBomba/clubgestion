<?php

namespace App\Livewire\WebClubs;

use App\Models\Tournament;
use App\Models\TournamentPlayer;
use App\Models\TournamentTeam;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class TeamPlayerRegister extends Component
{
    use WithFileUploads;

    public Tournament     $tournament;
    public TournamentTeam $team;

    /** Whether the form was accessed from the team admin dashboard */
    public bool $fromDashboard = false;

    /** Current wizard step (1-5) */
    public int $step = 1;
    public int $totalSteps = 5;

    // ── Step 1: Personal data ──────────────────────────────
    public string $name      = '';
    public string $surname   = '';
    public string $birthdate = '';   // yyyy-mm-dd
    public string $phone     = '';
    public string $email     = '';

    // ── Step 2: Document ──────────────────────────────────
    public string $docType   = 'dni';
    public string $docNumber = '';
    public        $docFront  = null;  // UploadedFile
    public        $docBack   = null;  // UploadedFile

    // ── Step 3: Sports + extra docs ───────────────────────
    public string $position   = '';
    public string $dorsal     = '';
    public bool   $federado   = false;
    public string $fedTeam    = '';   // team name if federado
    public        $photo      = null; // UploadedFile – profile photo
    public        $extraDoc   = null; // UploadedFile – extra document

    // ── Step 4: Signature ───────────────────────────────────────
    /** PNG signature as data URL (base64) provided by the canvas */
    public ?string $signature = null;

    // ── Step 5: Done ────────────────────────────────────────────────
    public bool   $done       = false;
    public string $doneMessage = '';

    // ── Validation rules per step ─────────────────────────
    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            1 => [
                'name'      => 'required|string|max:100',
                'surname'   => 'required|string|max:100',
                'birthdate' => 'nullable|date',
                'phone'     => 'nullable|string|max:20',
                'email'     => 'nullable|email|max:150',
            ],
            2 => [
                'docType'   => 'required|in:dni,nie,passport',
                'docNumber' => 'required|string|min:1|max:30',
                'docFront'  => 'required|file|max:10240',
                'docBack'   => 'required_unless:docType,passport|file|max:10240',
            ],
            3 => [
                'position'  => 'nullable|string|max:50',
                'dorsal'    => 'nullable|integer|min:1|max:99',
                'photo'     => 'required|file|max:10240',
                'extraDoc'  => 'nullable|file|max:15360',
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
            'name.required'      => 'El nombre es obligatorio.',
            'surname.required'   => 'Los apellidos son obligatorios.',
            'docType.required'   => 'Selecciona el tipo de documento.',
            'docNumber.required' => 'El número de documento es obligatorio.',
            'docFront.required'  => 'La foto del anverso del documento es obligatoria.',
            'docFront.mimes'     => 'El documento debe ser JPG, PNG o PDF.',
            'docBack.required_unless' => 'La foto del reverso del documento es obligatoria.',
            'docBack.mimes'      => 'El documento debe ser JPG, PNG o PDF.',
            'photo.required'     => 'La foto del jugador es obligatoria.',
            'photo.image'        => 'La foto debe ser una imagen.',
            'extraDoc.mimes'     => 'El documento debe ser JPG, PNG o PDF.',
            'signature.required' => 'La firma es obligatoria.',
            'signature.starts_with' => 'La firma no es válida.',
        ];
    }

    // ── Mount ─────────────────────────────────────────────
    public function mount(Tournament $tournament, string $token): void
    {
        $school = currentSchool();

        if (!$school) {
            abort(404);
        }

        if (
            $tournament->sports_school_id !== $school->id ||
            $tournament->visibility !== 'public' ||
            $tournament->status === 'cancelled'
        ) {
            abort(404);
        }

        $team = TournamentTeam::where('tournament_id', $tournament->id)
            ->where('registration_token', $token)
            ->first();

        if (!$team) {
            abort(404);
        }

        $this->tournament     = $tournament;
        $this->team           = $team;
        $this->fromDashboard  = (bool) session('tt_auth_' . $tournament->id);
    }

    // ── Navigation ────────────────────────────────────────
    public function nextStep(): void
    {
        $this->validate($this->rulesForStep($this->step), $this->messages());
        // After step 2: check the player isn't already registered in this tournament
        if ($this->step === 2) {
            $this->checkDuplicatePlayer();
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

    // ── Duplicate check ──────────────────────────────
    protected function checkDuplicatePlayer(): void
    {
        $docNumber = strtoupper(preg_replace('/\s+/', '', $this->docNumber));

        $alreadyRegistered = TournamentPlayer::whereHas('tournamentTeam', function ($q) {
                $q->where('tournament_id', $this->tournament->id);
            })
            ->whereNotNull('dni')
            ->where('dni', $docNumber)
            ->exists();

        if ($alreadyRegistered) {
            $this->addError('docNumber', 'Este documento ya está inscrito en este torneo.');
            throw ValidationException::withMessages(['docNumber' => 'Este documento ya está inscrito en este torneo.']);
        }
    }

    // ── Submit ────────────────────────────────────────────
    public function submit(): void
    {
        $this->validate($this->rulesForStep(3), $this->messages());        $this->validate($this->rulesForStep(4), $this->messages());        $this->checkDuplicatePlayer();
        $data = [
            'tournament_team_id' => $this->team->id,
            'name'               => trim($this->name),
            'surname'            => trim($this->surname),
            'birthdate'          => $this->birthdate ?: null,
            'phone'              => trim($this->phone) ?: null,
            'email'              => trim($this->email) ?: null,
            'doc_type'           => $this->docType,
            'dni'                => strtoupper(preg_replace('/\s+/', '', $this->docNumber)),
            'position'           => $this->position ?: null,
            'dorsal'             => $this->dorsal ? (int) $this->dorsal : null,
            'federado'           => $this->federado,
            'notes'              => $this->federado && $this->fedTeam
                                        ? 'Federado en: ' . trim($this->fedTeam)
                                        : null,
            'status'             => 'pending',
        ];

        // Profile photo
        if ($this->photo) {
            $data['photo'] = $this->photo->store('tournament-players', 'public');
        }

        // Document front
        if ($this->docFront) {
            $data['doc_front'] = $this->docFront->store('tournament-players/docs', 'public');
        }

        // Document back
        if ($this->docBack) {
            $data['doc_back'] = $this->docBack->store('tournament-players/docs', 'public');
        }

        // Extra document stored in extra_documents JSON array
        if ($this->extraDoc) {
            $path = $this->extraDoc->store('tournament-players/extra', 'public');
            $data['extra_documents'] = [['path' => $path, 'label' => $this->extraDoc->getClientOriginalName()]];
        }

        // Signature: decode the data URL and save as PNG file
        if ($this->signature && str_starts_with($this->signature, 'data:image/png;base64,')) {
            $base64 = substr($this->signature, strlen('data:image/png;base64,'));
            $binary = base64_decode($base64, true);
            if ($binary !== false) {
                $filename = 'tournament-players/signatures/' . \Illuminate\Support\Str::uuid() . '.png';
                Storage::disk('public')->put($filename, $binary);
                $data['signature'] = $filename;
            }
        }

        TournamentPlayer::create($data);

        $this->doneMessage = $this->fromDashboard
            ? 'Jugador inscrito correctamente. Puedes volver al panel del equipo.'
            : 'Tu inscripción se ha registrado correctamente. El equipo revisará tus datos y recibirás confirmación en breve.';

        $this->done = true;
        $this->step = $this->totalSteps;
    }

    // ── Render ────────────────────────────────────────────
    public function render()
    {
        return view('livewire.webclubs.team-player-register', [
            'docTypes'  => TournamentPlayer::docTypes(),
            'positions' => TournamentPlayer::positions(),
        ])->layout('livewire.webclubs.layouts.app');
    }
}
