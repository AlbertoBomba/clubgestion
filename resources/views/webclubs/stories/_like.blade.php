<form method="post" action="{{ route('webclubs.stories.like', ['story' => $story->id] + ($from === 'show' ? $storyContext : [])) }}">
    @csrf
    <input type="hidden" name="from" value="{{ $from }}">
    @if($from === 'index')
        <input type="hidden" name="category" value="{{ request('category') }}">
        <input type="hidden" name="page" value="{{ $stories->currentPage() }}">
    @endif
    <button type="submit" @disabled($story->liked_by_visitor)
        aria-label="{{ $story->liked_by_visitor ? 'Ya te gusta: ' : 'Me gusta: ' }}{{ $story->title }}"
        class="rounded-full px-4 py-2 text-sm font-semibold {{ $story->liked_by_visitor ? 'bg-red-50 text-red-700 cursor-default' : 'bg-primary text-white hover:opacity-90' }}">
        {{ $story->liked_by_visitor ? '♥ Te gusta' : '♡ Me gusta' }}
    </button>
</form>
