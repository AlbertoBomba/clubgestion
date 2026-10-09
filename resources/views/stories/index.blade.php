<x-app-layout>
    <x-slot name="header"><h1 class="font-bold text-2xl">Historias de aficionados</h1></x-slot>
    <div class="max-w-6xl mx-auto py-8 px-4">
        @include('webclubs.stories._notice')
        <p class="text-gray-600 mb-6">Revisa las historias, comentarios y Me gusta de tu club antes de hacerlos públicos.</p>
        <div class="flex flex-wrap gap-3 mb-6">
            @foreach(['stories' => 'Historias', 'comments' => 'Comentarios', 'likes' => 'Me gusta'] as $type => $label)
                <a href="{{ route('stories.index', ['kind' => $type, 'status' => $status]) }}" class="px-4 py-3 rounded-lg border {{ $kind === $type ? 'bg-primary text-white' : 'bg-white' }}">{{ $label }} · {{ $pending[$type] }} pendientes</a>
            @endforeach
        </div>
        <form method="get" action="{{ route('stories.index') }}" class="flex items-end gap-3 mb-6">
            <input type="hidden" name="kind" value="{{ $kind }}">
            <label class="text-sm font-semibold">Estado
                <select name="status" class="block rounded-lg border-gray-300 mt-1">
                    @foreach(['pending' => 'Pendientes', 'approved' => 'Aprobados', 'rejected' => 'Rechazados', 'all' => 'Todos'] as $value => $label)
                        <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <button class="bg-white border rounded-lg px-4 py-2">Filtrar</button>
        </form>
        <div class="space-y-5">
            @forelse($items as $item)
                <article class="bg-white border rounded-xl p-6">
                    <div class="flex flex-wrap justify-between gap-3">
                        <h2 class="font-bold text-xl">
                            <a class="text-primary" href="{{ route('stories.show', $kind === 'stories' ? $item->id : $item->club_story_id) }}">{{ $kind === 'stories' ? $item->title : $item->story->title }}</a>
                        </h2>
                        <span class="text-sm font-semibold">{{ ['pending' => 'Pendiente', 'approved' => 'Aprobado', 'rejected' => 'Rechazado'][$item->status] }}</span>
                    </div>
                    @if($kind !== 'likes')
                        <p class="text-sm text-gray-500 mt-2">{{ $item->author_name }} · {{ $item->author_email }}</p>
                        <p class="whitespace-pre-wrap break-words mt-3">{{ \Illuminate\Support\Str::limit($item->body, 500) }}</p>
                    @else
                        <p class="text-sm text-gray-500 mt-2">Me gusta #{{ $item->id }} · {{ $item->created_at->format('d/m/Y H:i') }} · visitante anónimo</p>
                    @endif
                    @if($kind === 'stories')
                        <p class="text-sm mt-3">{{ $item->category?->name }} · {{ $item->comments_count }} comentarios · {{ $item->likes_count }} Me gusta</p>
                        <a href="{{ route('stories.show', $item) }}" class="inline-block mt-4 font-semibold text-primary">Revisar texto y archivos →</a>
                    @else
                        @include('stories._review', ['kind' => $kind, 'item' => $item])
                    @endif
                </article>
            @empty
                <p class="bg-white border rounded-xl p-8 text-gray-500">No hay elementos con estos filtros.</p>
            @endforelse
        </div>
        <div class="mt-6">{{ $items->links() }}</div>
    </div>
</x-app-layout>
