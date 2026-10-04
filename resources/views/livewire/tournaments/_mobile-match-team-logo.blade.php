@if ($team)
    @if ($team->logo)
        <img src="{{ asset('storage/' . $team->logo) }}" alt=""
             class="{{ $logoSize ?? 'w-6 h-6' }} rounded-md object-contain shrink-0 bg-white border border-gray-100">
    @elseif ($team->team?->logo)
        <img src="{{ Storage::url($team->team->logo) }}" alt=""
             class="{{ $logoSize ?? 'w-6 h-6' }} rounded-md object-contain shrink-0 bg-white border border-gray-100">
    @else
        <span aria-hidden="true" class="{{ $logoSize ?? 'w-6 h-6' }} rounded-md bg-gray-100 flex items-center justify-center shrink-0 text-[10px] font-black text-gray-400">
            {{ mb_strtoupper(mb_substr($team->displayName(), 0, 1)) }}
        </span>
    @endif
@endif
