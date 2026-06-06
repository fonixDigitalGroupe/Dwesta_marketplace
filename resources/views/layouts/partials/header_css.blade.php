<style>
    /* Header Base */
    .header {
        background-color: #ffffff;
        position: relative;
        z-index: 100;
        /* border-bottom removal is handled in row-1 now */
    }

    .header-row-1 {
        padding: 0.5rem 0;
    }

    .header-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    /* Logo */
    .logo {
        display: block;
        width: 140px;
        height: 40px;
        @if($logoUrl = \App\Models\Setting::logoUrl())
            background-image: url("{{ $logoUrl }}");
        @endif
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        flex-shrink: 0;
    }

    /* Search Bar */
    .search-container {
        flex: 1;
        margin: 0 2rem;
        max-width: 800px;
        display: flex;
        align-items: center;
        position: relative;
    }

    .search-field {
        flex: 1;
        display: flex;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        overflow: hidden;
    }

    .search-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        font-size: 1rem;
        outline: none;
    }

    .search-button {
        background-color: #333;
        color: white;
        border: none;
        padding: 0 1.25rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-button:hover {
        background-color: #000;
    }

    /* Header Actions */
    .header-actions {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-left: auto;
        flex-shrink: 0;
    }

    .header-link {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: #333;
        font-size: 0.9rem;
        font-weight: 500;
        position: relative;
    }

    .header-link:hover {
        color: #bf0000;
    }

    .header-link svg {
        width: 22px;
        height: 22px;
    }

    /* Sell Button */
    .sell-button-container {
        position: relative;
    }

    .sell-button {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: #333;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        background: white;
        border: none;
        padding: 0.5rem;
    }

    .sell-button:hover {
        color: #bf0000;
    }

    .sell-button .chevron {
        width: 12px;
        height: 12px;
        transition: transform 0.2s;
    }

    .sell-button.active .chevron {
        transform: rotate(180deg);
    }

    .sell-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 0.5rem;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        min-width: 280px;
        z-index: 1000;
        display: none;
    }

    .sell-dropdown.show {
        display: block;
    }

    .sell-dropdown-item {
        display: block;
        padding: 1rem;
        text-decoration: none;
        color: #333;
        border-bottom: 1px solid #f0f0f0;
        transition: background-color 0.2s;
        text-align: left;
    }

    .sell-dropdown-item:last-child {
        border-bottom: none;
    }

    .sell-dropdown-item:hover {
        background-color: #f5f5f5;
    }

    .sell-dropdown-item-title {
        font-weight: 500;
        font-size: 0.95rem;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .sell-dropdown-item-subtitle {
        font-size: 0.85rem;
        color: #666;
    }

    /* Category Navigation */
    .header-row-2 {
        border-bottom: 1px solid #e0e0e0;
        background: #fff;
    }

    .cat-nav-item {
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        color: #333;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .cat-nav-item.badge-style {
        background: #f0f0f0;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 500;
    }

    /* Inactive Buttons Style */
    .disabled-action {
        cursor: default !important;
        opacity: 0.6;
        pointer-events: none;
    }

    .disabled-action:hover {
        color: inherit !important;
        background: inherit !important;
    }

    /* Mobile Menu Drawer */
    .mobile-menu-drawer {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-top: 1px solid #e0e0e0;
        z-index: 99;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        color: #333;
        margin-right: 1rem;
    }

    @media (max-width: 1024px) {
        .mobile-menu-btn {
            display: block;
        }

        .search-container {
            display: none;
            /* Simplify for now or adapt */
        }

        .header-container {
            gap: 1rem;
        }
    }
</style>