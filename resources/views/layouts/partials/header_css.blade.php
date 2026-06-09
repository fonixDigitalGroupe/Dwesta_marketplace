<style>
    /* ==============================
       HEADER CSS - Single Source of Truth
       ============================== */

    /* Autocomplete Search */
    #autocomplete-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 2000;
        display: none;
    }

    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f9f9f9;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        color: #333;
    }

    .autocomplete-item:hover {
        background: #fff8f0;
    }

    .autocomplete-item .type-badge {
        font-size: 0.7rem;
        padding: 2px 6px;
        border-radius: 10px;
        background: #eee;
        color: #666;
    }

    /* Header Base */
    .header {
        background-color: #ffffff;
        position: relative;
        z-index: 100;
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
        border: 1px solid #eeeeee;
        border-radius: 8px;
        overflow: hidden;
        background-color: #eeeeee;
    }

    .search-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        font-size: 1rem;
        outline: none;
        background-color: #eeeeee;
    }

    .search-button {
        background-color: #ff8c00; /* Dark orange */
        color: white;
        border: none;
        padding: 0 1.25rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .search-button:hover {
        background-color: #e67e00;
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

    /* Global SVG constraints */
    .header svg {
        width: 22px;
        height: 22px;
        flex-shrink: 0;
    }

    .header-link svg {
        width: 22px;
        height: 22px;
        flex-shrink: 0;
    }

    .sell-button svg {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
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

    /* Auth Dropdown */
    .auth-dropdown-container {
        position: relative;
        height: 100%;
        display: flex;
        align-items: center;
    }

    .auth-dropdown {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        width: 280px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        padding: 1.25rem;
        display: none;
        z-index: 1000;
        margin-top: 10px;
    }

    .auth-dropdown-container:hover .auth-dropdown {
        display: block;
    }

    .auth-dropdown::after {
        content: '';
        position: absolute;
        top: -20px;
        left: 0;
        width: 100%;
        height: 20px;
        background: transparent;
    }

    .auth-dropdown::before {
        content: '';
        position: absolute;
        top: -8px;
        left: 50%;
        margin-left: -8px;
        width: 16px;
        height: 16px;
        background: #fff;
        border-top: 1px solid #eee;
        border-left: 1px solid #eee;
        transform: rotate(45deg);
        z-index: 1001;
    }

    .auth-btn-login {
        background: #004aad;
        color: #fff;
        font-weight: 700;
        text-align: center;
        padding: 0.6rem;
        border-radius: 6px;
        text-decoration: none;
        font-size: 1rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    .auth-link-create {
        color: #333;
        text-align: center;
        text-decoration: none;
        font-size: 0.9rem;
        display: block;
        font-weight: 500;
    }

    .auth-separator {
        height: 1px;
        background: #f0f0f0;
        margin: 1rem 0;
    }

    .auth-menu-list {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .auth-menu-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #444;
        text-decoration: none;
        font-size: 0.95rem;
        padding: 0.5rem;
        border-radius: 4px;
    }

    .auth-menu-item:hover {
        background-color: #f9f9f9;
        color: #004aad;
    }

    .auth-icon-blue {
        width: 20px !important;
        height: 20px !important;
        color: #004aad;
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
        display: block !important;
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
        color: #555;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 500;
    }

    /* All generic badge-style links in the header nav are grey */
    .badge-style {
        background: #f0f0f0;
        color: #555;
        padding: 5px 15px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.15s, color 0.15s;
    }
    .badge-style:hover {
        background: #e0e0e0;
        color: #222;
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

    /* Site Badge */
    .site-badge {
        display: none;
    }

    /* Visibility Utils */
    .desktop-only {
        display: flex !important;
    }

    .mobile-only {
        display: none !important;
    }

    .mobile-search-row {
        display: none;
        background: #fff;
        border-bottom: 1px solid #eee;
        padding: 0.25rem 0;
    }

    @media (min-width: 1025px) {
        .site-badge {
            display: flex;
            align-items: center;
            background: #f8f8f8;
            border: 1px solid #eee;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #bf0000;
            margin-left: 10px;
        }

        .header-brand-group {
            display: flex;
            align-items: center;
        }
    }

    /* ===== TABLET (max 1024px) ===== */
    @media (max-width: 1024px) {
        .desktop-only {
            display: none !important;
        }

        .mobile-only {
            display: flex !important;
        }

        .mobile-search-row {
            display: block;
        }
        .mobile-menu-btn {
            display: block;
            order: 1;
            flex-shrink: 0;
            margin-right: 0;
        }

        .header-container {
            display: flex !important;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            max-width: none;
        }

        .header-brand-group {
            order: 2;
            flex: 1;
            display: flex !important;
            align-items: center;
            gap: 10px;
            justify-content: flex-start;
        }

        .header-actions {
            order: 3;
            gap: 1.25rem;
            margin-left: 0;
            flex-shrink: 0;
        }

        /* Main search in row-1 is hidden by .desktop-only */
        /* Mobile search in row-2 is visible by .mobile-search-row */

        .header-row-2 {
            width: 100%;
            border-bottom: none;
        }

        .header-row-2 .header-container {
            padding: 0 1rem 0.5rem 1rem;
            display: block !important;
        }

        .cat-nav-item:not(.badge-style) {
            display: none !important;
        }

        .header-badges-container {
            margin-top: 0;
            padding-bottom: 5px;
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            width: 100%;
        }

        .header-badges-container::-webkit-scrollbar {
            display: none;
        }

        .desktop-only {
            display: none !important;
        }

        .header-link span:not(.desktop-only) {
            display: none;
        }

        .sell-button span:last-child {
            display: none;
        }

        .auth-dropdown-container {
            position: static;
        }

        .auth-dropdown {
            width: 96vw;
            left: 2vw;
            transform: none;
            margin-top: 5px;
        }

        .auth-dropdown::before {
            display: none;
        }

        .site-badge {
            display: flex;
            align-items: center;
            background: #f8f8f8;
            border: 1px solid #eee;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #bf0000;
        }
    }

    /* ===== MOBILE (max 768px) ===== */
    @media (max-width: 768px) {
        .header-row-1 {
            padding: 0.3rem 0;
        }

        .header-container {
            padding: 0.4rem 0.75rem;
            gap: 0.35rem;
        }

        .mobile-menu-btn {
            order: 1;
            flex-shrink: 0;
        }

        .header-brand-group {
            order: 2;
            flex: 1;
            justify-content: flex-start;
            gap: 6px;
        }

        .header-actions {
            order: 3;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        /* Main search in row-1 is hidden by .desktop-only */
        /* Mobile search in row-2 is visible by .mobile-search-row */

        .search-field {
            background-color: transparent !important;
            border: none !important;
            gap: 8px !important;
            overflow: visible !important;
        }

        .search-input {
            padding: 0.6rem 0.75rem;
            font-size: 0.9rem;
            border-radius: 8px !important;
            background-color: #eeeeee !important;
        }

        .search-button {
            padding: 0 1rem;
            background-color: #ff8c00 !important;
            color: white !important;
            border-radius: 8px !important;
        }

        .header-row-1 .header-container {
            padding: 0.5rem 0.6rem !important;
            gap: 0.75rem !important;
        }

        .header-row-2 .header-container {
            padding: 0 0.6rem 0.4rem 0.6rem !important;
        }

        /* Hide sell button on small screens */
        .sell-button-container {
            display: none !important;
        }

        .cat-nav-item.badge-style,
        .badge-style {
            padding: 4px 10px;
            font-size: 0.8rem;
        }

        .auth-dropdown {
            display: none !important;
        }

        .chevron {
            display: none !important;
        }

        .site-badge {
            display: none !important;
        }

        .header-link span,
        .sell-button span:not(.sell-icon) {
            display: none !important;
        }

        .header-actions {
            order: 3;
            gap: 1rem;
            flex-shrink: 0;
            display: flex !important;
            align-items: center;
        }

        .header-link svg {
            width: 24px;
            height: 24px;
        }

        .mobile-search-row .header-container {
            padding-left: 0.6rem !important;
            padding-right: 0.6rem !important;
        }

        .search-container.mobile-only {
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>