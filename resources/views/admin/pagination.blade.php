@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: flex-end; gap: 5px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span
                style="padding: 6px 12px; border: 1px solid #e5e5e5; color: #ccc; border-radius: 4px; font-size: 0.85rem; cursor: not-allowed; background: #fafafa;">
                &lsaquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                style="padding: 6px 12px; border: 1px solid #e5e5e5; color: #333; border-radius: 4px; font-size: 0.85rem; text-decoration: none; background: #fff; transition: all 0.2s;">
                &lsaquo;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span
                    style="padding: 6px 12px; border: 1px solid transparent; color: #777; font-size: 0.85rem;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            style="padding: 6px 12px; border: 1px solid #000; background-color: #000; color: #fff; border-radius: 4px; font-size: 0.85rem; font-weight: 600;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                            style="padding: 6px 12px; border: 1px solid #e5e5e5; color: #333; border-radius: 4px; font-size: 0.85rem; text-decoration: none; background: #fff; transition: all 0.2s;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                style="padding: 6px 12px; border: 1px solid #e5e5e5; color: #333; border-radius: 4px; font-size: 0.85rem; text-decoration: none; background: #fff; transition: all 0.2s;">
                &rsaquo;
            </a>
        @else
            <span
                style="padding: 6px 12px; border: 1px solid #e5e5e5; color: #ccc; border-radius: 4px; font-size: 0.85rem; cursor: not-allowed; background: #fafafa;">
                &rsaquo;
            </span>
        @endif
    </nav>
@endif