<?php

namespace App\Livewire\MemberTypes;

use App\Enums\MemberPeriodicity;
use App\Models\MemberType;
use App\Models\Season;
use Livewire\Component;

class Edit extends Component
{
    public MemberType $memberType;

    public string $name = '';
    public string $description = '';
    public string $price = '';
    public string $periodicity = '';
    public string $card_template = '';
    public bool $active = true;
    public string $season_id = '';

    public function mount(MemberType $memberType): void
    {
        $this->memberType  = $memberType;
        $this->name        = $memberType->name;
        $this->description = $memberType->description ?? '';
        $this->price       = $memberType->price;
        $this->periodicity = $memberType->periodicity instanceof MemberPeriodicity
            ? $memberType->periodicity->value
            : $memberType->periodicity;
        $this->card_template = $memberType->card_template ?? '';
        $this->active      = $memberType->active;
        $this->season_id   = $memberType->season_id;
    }

    protected function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'periodicity' => 'required|in:' . implode(',', array_column(MemberPeriodicity::cases(), 'value')),
            'season_id'   => 'required|exists:seasons,id',
            'active'      => 'boolean',
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

        $this->memberType->update([
            'season_id'     => $this->season_id,
            'name'          => $this->name,
            'description'   => $this->description ?: null,
            'price'         => (float) $this->price,
            'periodicity'   => $this->periodicity,
            'card_template' => $this->card_template ?: null,
            'active'        => $this->active,
        ]);

        session()->flash('message', 'Tipo de socio actualizado correctamente.');

        return redirect()->route('member-types.index');
    }

    public function render(): \Illuminate\View\View
    {
        $seasons = Season::where('sports_school_id', auth()->user()->sports_school_id)
            ->orderByDesc('from_year')
            ->get();

        $periodicities = MemberPeriodicity::cases();

        return view('livewire.member-types.edit', compact('seasons', 'periodicities'));
    }
}
