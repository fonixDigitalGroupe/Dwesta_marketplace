@if ($paginator->hasPages())
    <nav class="karnou-pagination" role="navigation" aria-label="Pagination">
        {{-- Précédent --}}
        @if ($paginator->onFirstPage())
            <span class="kp-link kp-disabled" aria-disabled="true">
                <i class="fas fa-chevron-left"></i>
            </span>
        @else
            <a class="kp-link kp-arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Précédent">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        {{-- Numéros de page --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="kp-link kp-dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="kp-link kp-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="kp-link" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Suivant --}}
        @if ($paginator->hasMorePages())
            <a class="kp-link kp-arrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Suivant">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span class="kp-link kp-disabled" aria-disabled="true">
                <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif
