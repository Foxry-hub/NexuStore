@if ($paginator->hasPages())
<nav class="custom-pagination">
    {{-- Previous Arrow --}}
    @if ($paginator->onFirstPage())
        <span class="arrow disabled">←</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="arrow">←</a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        {{-- Dots --}}
        @if (is_string($element))
            <span class="dots">{{ $element }}</span>
        @endif

        {{-- Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="page active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="page">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Arrow --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="arrow">→</a>
    @else
        <span class="arrow disabled">→</span>
    @endif
</nav>
@endif
