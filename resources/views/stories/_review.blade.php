<form method="post" action="{{ route('stories.review', ['kind' => $kind, 'item' => $item->id]) }}" class="space-y-3 mt-4">
    @csrf
    <label class="block text-sm">
        Nota interna de moderación (opcional)
        <input name="review_note" maxlength="1000" value="{{ $item->review_note }}" class="block w-full mt-1 rounded-lg border-gray-300">
    </label>
    <div class="flex flex-wrap gap-3">
        <button name="status" value="approved" class="bg-green-700 text-white rounded-lg px-4 py-2">Aprobar</button>
        <button name="status" value="rejected" class="bg-red-700 text-white rounded-lg px-4 py-2">{{ $item->status === 'approved' ? 'Retirar / rechazar' : 'Rechazar' }}</button>
    </div>
    @if($item->reviewed_at)
        <p class="text-xs text-gray-500">Última revisión: {{ \Illuminate\Support\Carbon::parse($item->reviewed_at)->format('d/m/Y H:i') }} · Usuario #{{ $item->reviewed_by }}</p>
    @endif
</form>
