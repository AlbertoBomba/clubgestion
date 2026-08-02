<?php

namespace App\Livewire\Members;

use App\Enums\MemberPaymentStatus;
use App\Enums\MemberSeasonStatus;
use App\Models\Member;
use App\Models\MemberPayment;
use App\Models\MemberSeason;
use App\Models\MemberType;
use App\Models\Season;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Member $member;

    // Datos personales
    public string $name = '';
    public string $surname = '';
    public string $dni = '';
    public string $email = '';
    public string $phone = '';
    public string $birth_date = '';
    public string $address = '';
    public bool $active = true;
    public $photo = null;
    public string $currentPhoto = '';

    // Inscripciones (member_seasons)
    public string $activeTab = 'data';
    public bool $showSeasonModal = false;
    public string $ms_season_id = '';
    public string $ms_member_type_id = '';
    public string $ms_join_date = '';
    public string $ms_price = '';
    public string $ms_observations = '';
    public ?int $editingSeasonId = null;

    // Pagos
    public bool $showPaymentModal = false;
    public ?int $paymentForSeasonId = null;
    public string $pay_amount = '';
    public string $pay_due_date = '';
    public string $pay_concept = '';

    // Confirmaciones
    public bool $confirmingSeasonDeletion = false;
    public ?int $seasonToDelete = null;
    public bool $confirmingPaymentDeletion = false;
    public ?int $paymentToDelete = null;

    public function mount(Member $member): void
    {
        $this->member       = $member;
        $this->name         = $member->name;
        $this->surname      = $member->surname;
        $this->dni          = $member->dni ?? '';
        $this->email        = $member->email ?? '';
        $this->phone        = $member->phone ?? '';
        $this->birth_date   = $member->birth_date?->format('Y-m-d') ?? '';
        $this->address      = $member->address ?? '';
        $this->active       = $member->active;
        $this->currentPhoto = $member->photo ?? '';
    }

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

    protected function seasonRules(): array
    {
        return [
            'ms_season_id'      => 'required|exists:seasons,id',
            'ms_member_type_id' => 'required|exists:member_types,id',
            'ms_join_date'      => 'required|date',
            'ms_price'          => 'required|numeric|min:0',
            'ms_observations'   => 'nullable|string|max:1000',
        ];
    }

    protected function paymentRules(): array
    {
        return [
            'pay_amount'   => 'required|numeric|min:0',
            'pay_due_date' => 'required|date',
            'pay_concept'  => 'required|string|max:255',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $photoPath = $this->currentPhoto;
        if ($this->photo) {
            if ($this->currentPhoto) {
                Storage::disk('public')->delete($this->currentPhoto);
            }
            $photoPath = $this->photo->store('members/photos', 'public');
        }

        $this->member->update([
            'name'       => $this->name,
            'surname'    => $this->surname,
            'dni'        => $this->dni ?: null,
            'email'      => $this->email ?: null,
            'phone'      => $this->phone ?: null,
            'birth_date' => $this->birth_date ?: null,
            'address'    => $this->address ?: null,
            'photo'      => $photoPath,
            'active'     => $this->active,
        ]);

        $this->currentPhoto = $photoPath ?? '';
        $this->photo = null;

        session()->flash('message', 'Socio actualizado correctamente.');
    }

    // ── Inscripciones ──────────────────────────────────────────────────────────

    public function openSeasonModal(?int $seasonId = null): void
    {
        $this->resetSeasonForm();
        if ($seasonId) {
            $ms = MemberSeason::find($seasonId);
            if ($ms) {
                $this->editingSeasonId  = $ms->id;
                $this->ms_season_id     = $ms->season_id;
                $this->ms_member_type_id = $ms->member_type_id;
                $this->ms_join_date     = $ms->join_date->format('Y-m-d');
                $this->ms_price         = $ms->price;
                $this->ms_observations  = $ms->observations ?? '';
            }
        } else {
            $this->ms_join_date = now()->toDateString();
        }
        $this->showSeasonModal = true;
    }

    public function saveSeason(): void
    {
        $this->validate($this->seasonRules());

        $data = [
            'season_id'      => $this->ms_season_id,
            'member_type_id' => $this->ms_member_type_id,
            'join_date'      => $this->ms_join_date,
            'price'          => (float) str_replace(',', '.', $this->ms_price),
            'observations'   => $this->ms_observations ?: null,
            'payment_status' => MemberPaymentStatus::Pending->value,
            'status'         => MemberSeasonStatus::Active->value,
        ];

        if ($this->editingSeasonId) {
            MemberSeason::find($this->editingSeasonId)?->update($data);
            session()->flash('message', 'Inscripción actualizada.');
        } else {
            $this->member->memberSeasons()->create($data);
            session()->flash('message', 'Inscripción añadida.');
        }

        $this->showSeasonModal = false;
        $this->resetSeasonForm();
    }

    public function confirmDeleteSeason(int $id): void
    {
        $this->seasonToDelete = $id;
        $this->confirmingSeasonDeletion = true;
    }

    public function deleteSeason(): void
    {
        $ms = MemberSeason::find($this->seasonToDelete);
        if ($ms && $ms->member_id === $this->member->id) {
            $ms->payments()->delete();
            $ms->delete();
            session()->flash('message', 'Inscripción eliminada.');
        }
        $this->confirmingSeasonDeletion = false;
        $this->seasonToDelete = null;
    }

    // ── Pagos ──────────────────────────────────────────────────────────────────

    public function openPaymentModal(int $seasonId): void
    {
        $this->paymentForSeasonId = $seasonId;
        $this->pay_due_date       = now()->toDateString();
        $this->pay_amount         = '';
        $this->pay_concept        = '';
        $this->showPaymentModal   = true;
    }

    public function savePayment(): void
    {
        $this->validate($this->paymentRules());

        MemberPayment::create([
            'member_season_id' => $this->paymentForSeasonId,
            'amount'           => (float) str_replace(',', '.', $this->pay_amount),
            'due_date'         => $this->pay_due_date,
            'payment_date'     => null,
            'status'           => MemberPaymentStatus::Pending->value,
            'concept'          => $this->pay_concept,
        ]);

        session()->flash('message', 'Pago registrado.');
        $this->showPaymentModal = false;
    }

    public function markPaymentPaid(int $paymentId): void
    {
        $payment = MemberPayment::find($paymentId);
        if ($payment && $payment->memberSeason->member_id === $this->member->id) {
            $payment->update([
                'status'       => MemberPaymentStatus::Paid->value,
                'payment_date' => now()->toDateString(),
            ]);

            // Update season payment_status if all paid
            $season = $payment->memberSeason;
            if ($season->payments()->where('status', '!=', MemberPaymentStatus::Paid->value)->count() === 0) {
                $season->update(['payment_status' => MemberPaymentStatus::Paid->value]);
            }
        }
    }

    public function confirmDeletePayment(int $id): void
    {
        $this->paymentToDelete = $id;
        $this->confirmingPaymentDeletion = true;
    }

    public function deletePayment(): void
    {
        $payment = MemberPayment::find($this->paymentToDelete);
        if ($payment && $payment->memberSeason->member_id === $this->member->id) {
            $payment->delete();
            session()->flash('message', 'Pago eliminado.');
        }
        $this->confirmingPaymentDeletion = false;
        $this->paymentToDelete = null;
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    private function resetSeasonForm(): void
    {
        $this->editingSeasonId   = null;
        $this->ms_season_id      = '';
        $this->ms_member_type_id = '';
        $this->ms_join_date      = '';
        $this->ms_price          = '';
        $this->ms_observations   = '';
    }

    public function render(): \Illuminate\View\View
    {
        $memberSeasons = $this->member->memberSeasons()
            ->with(['season', 'memberType', 'payments'])
            ->orderByDesc('join_date')
            ->get();

        $availableSeasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderByDesc('from_year')
            ->get();

        $memberTypes = MemberType::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.members.edit', compact('memberSeasons', 'availableSeasons', 'memberTypes'));
    }
}
