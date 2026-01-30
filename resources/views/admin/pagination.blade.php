@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: flex-end; align-items: center; gap: 5px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span
                style="padding: 6px 12px; border: 1px solid #e5e5e5; color: #ccc; border-radius: 4px; font-size: 0.85rem; cursor: not-allowed; background: #fafafa;">
                &lsaquo;
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                style="padding: 6px 12px; border: 1px solid #e5e5e5; color: #333; border-radius: 4px; font-size: 0.85rem; text-decoration: none; background: #fff; transition: all 0.2s;"
                onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                &lsaquo;
            </a>
        @endif

        {{-- Current Page Number --}}
        <span
            style="padding: 6px 12px; border: 1px solid #000; background-color: #000; color: #fff; border-radius: 4px; font-size: 0.85rem; font-weight: 600; min-width: 32px; text-align: center;">
            {{ $paginator->currentPage() }}
        </span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                style="padding: 6px 12px; border: 1px solid #e5e5e5; color: #333; border-radius: 4px; font-size: 0.85rem; text-decoration: none; background: #fff; transition: all 0.2s;"
                onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
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