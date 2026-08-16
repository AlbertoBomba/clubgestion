<?php

namespace App\Livewire\MemberTypes;

use App\Enums\MemberPeriodicity;
use App\Models\MemberType;
use App\Models\Season;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';
    public string $description = '';
    public string $price = '';
    public string $periodicity = '';
    public string $card_template = '';
    public bool $active = true;
    public string $season_id = '';
    public bool $bank_account = false;
    public bool $credit_card = false;

    public function mount(): void
    {
        $active = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->orderByDesc('created_at')
            ->first();

        if ($active) {
            $this->season_id = $active->id;
        }

        $this->periodicity = MemberPeriodicity::Annual->value;
    }

    protected function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'periodicity' => 'required|in:' . implode(',', array_column(MemberPeriodicity::cases(), 'value')),
            'season_id'   => 'required|exists:seasons,id',
            'active'      => 'nullable|boolean',
            'bank_account' => 'nullable|boolean',
            'credit_card' => 'nullable|boolean',
        ];
    }

    protected $messages = [
        'name.required'        => 'El nombre es obligatorio.',
        'price.required'       => 'El precio es obligatorio.',
        'periodicity.required' => 'La periodicidad es obligatoria.',
        'season_id.required'   => 'La temporada es obligatoria.',
    ];

    public function updatedPrice(string $value): void
    {
        $this->price = str_replace(',', '.', $value);
    }

    public function save(): mixed
    {
        $this->validate();

        MemberType::create([
            'sports_school_id' => auth()->user()->sports_school_id,
            'season_id'        => $this->season_id,
            'name'             => $this->name,
            'description'      => $this->description ?: null,
            'price'            => (float) $this->price,
            'periodicity'      => $this->periodicity,
            'card_template'    => $this->card_template ?: null,
            'active'           => $this->active,
            'bank_account'     => $this->bank_account,
            'credit_card'      => $this->credit_card,
        ]);

        session()->flash('message', 'Tipo de socio creado correctamente.');

        return redirect()->route('member-types.index');
    }

    public function render(): \Illuminate\View\View
    {
        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderByDesc('from_year')
            ->get();

        $periodicities = MemberPeriodicity::cases();

        return view('livewire.member-types.create', compact('seasons', 'periodicities'));
    }
}
