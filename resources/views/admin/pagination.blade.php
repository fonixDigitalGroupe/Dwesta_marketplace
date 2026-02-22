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
                onmouseover="this.style.background='#fff7ed'; this.style.borderColor='#ff750f'; this.style.color='#ff750f'" 
                onmouseout="this.style.background='#fff'; this.style.borderColor='#e5e5e5'; this.style.color='#333'">
                &lsaquo;
            </a>
        @endif

        {{-- Current Page Number --}}
        <span
            style="padding: 6px 12px; border: 1px solid #ff750f; background-color: #ff750f; color: #fff; border-radius: 4px; font-size: 0.85rem; font-weight: 600; min-width: 32px; text-align: center;">
            {{ $paginator->currentPage() }}
        </span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                style="padding: 6px 12px; border: 1px solid #e5e5e5; color: #333; border-radius: 4px; font-size: 0.85rem; text-decoration: none; background: #fff; transition: all 0.2s;"
                onmouseover="this.style.background='#fff7ed'; this.style.borderColor='#ff750f'; this.style.color='#ff750f'" 
                onmouseout="this.style.background='#fff'; this.style.borderColor='#e5e5e5'; this.style.color='#333'">
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