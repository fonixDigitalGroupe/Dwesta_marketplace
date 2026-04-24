@php
    $currentCategory = isset($category) ? $category : null;
    $parentCategory = $currentCategory ? $currentCategory->parent : null;
    $searchTerm = request('q');
@endphp

<aside class="catalog-sidebar">
    <div class="sidebar-section">
        <div class="sidebar-header">CATÉGORIES</div>
        <ul class="sidebar-menu">
            @if($parentCategory)
                <li class="menu-item back-link">
                    <a href="{{ route('categories.show', $parentCategory->slug) }}">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                        Retour à {{ $parentCategory->nom }}
                    </a>
                </li>
            @elseif($currentCategory && !$currentCategory->estRacine())
                <li class="menu-item back-link">
                    <a href="{{ route('home') }}">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                        Retour à l'accueil
                    </a>
                </li>
            @endif

            @if($currentCategory)
                <li class="menu-item category-main">
                    <a href="{{ route('categories.show', $currentCategory->slug) }}">
                        <span>{{ $currentCategory->nom }}</span>
                        <span class="count">{{ $annonces->total() }}</span>
                    </a>
                </li>
                @foreach($currentCategory->enfantsActifs as $child)
                    <li class="menu-item sub-item">
                        <a href="{{ route('categories.show', $child->slug) }}">
                            {{ $child->nom }}
                            @if(isset($child->annonces_count)) <span class="count">{{ $child->annonces_count }}</span> @endif
                        </a>
                    </li>
                @endforeach
            @else
                @foreach($categories as $cat)
                    <li class="menu-item">
                        <a href="{{ route('search.index', ['category' => $cat->slug, 'q' => $searchTerm]) }}" class="@if(request('category') == $cat->slug) active @endif">
                            {{ $cat->nom }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>

    @if(isset($annonces) && !($currentCategory && $currentCategory->parent_id === null))
    <div class="sidebar-section">
        <div class="sidebar-header">FILTRES</div>
        
        <form action="{{ request()->url() }}" method="GET" id="sidebar-filter-form">
            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
            @if(request('category') && !isset($category)) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

@php
    // Find root category to determine family
    $rootCat = $currentCategory;
    while ($rootCat && $rootCat->parent_id) {
        $rootCat = $rootCat->parent;
    }
    $showEtatFilter = !($rootCat && in_array($rootCat->famille, ['Immobilier', 'Services']));
@endphp

@if($showEtatFilter)
            <div class="filter-group-alt">
                <div class="filter-label-alt">ETAT</div>
                <div class="checkbox-group">
                    <label class="rakuten-checkbox">
                        <input type="checkbox" name="etat[]" value="Neuf" @if(is_array(request('etat')) && in_array('Neuf', request('etat'))) checked @endif onchange="this.form.submit()">
                        <span class="box"></span> 
                        <span class="label-text">Neuf</span>
                    </label>
                    <label class="rakuten-checkbox">
                        <input type="checkbox" name="etat[]" value="Occasion" @if(is_array(request('etat')) && in_array('Occasion', request('etat'))) checked @endif onchange="this.form.submit()">
                        <span class="box"></span> 
                        <span class="label-text">Occasion</span>
                    </label>
                    <label class="rakuten-checkbox">
                        <input type="checkbox" name="etat[]" value="Reconditionné" @if(is_array(request('etat')) && in_array('Reconditionné', request('etat'))) checked @endif onchange="this.form.submit()">
                        <span class="box"></span> 
                        <span class="label-text">Reconditionné</span>
                    </label>

                </div>
                <div class="divider-thin"></div>
            </div>
@endif

            <div class="filter-group-alt">
                <div class="filter-label-alt">PRIX</div>
                <div class="rakuten-price-inputs">
                    <div class="price-box">
                        <input type="number" name="min_prix" placeholder="Min" value="{{ request('min_prix') }}">
                    </div>
                    <span class="hyphen">-</span>
                    <div class="price-box">
                        <input type="number" name="max_prix" placeholder="Max" value="{{ request('max_prix') }}">
                    </div>
                    <button type="submit" class="p-ok-btn">Ok</button>
                </div>
                <div class="divider-thin"></div>
            </div>

            @if(isset($category) && $category->filters)
                @foreach($category->filters as $filter)
                    @if($filter->is_filterable)
                        <div class="filter-group-alt">
                            <div class="filter-label-alt">{{ strtoupper($filter->nom) }}</div>
                            @if($filter->type === 'select' && $filter->options)
                                <div class="checkbox-group">
                                    @foreach($filter->options as $option)
                                        <label class="rakuten-checkbox">
                                            <input type="checkbox" name="attrs[{{ $filter->id }}]" value="{{ $option }}" @if(request()->input('attrs.'.$filter->id) == $option) checked @endif onchange="this.form.submit()">
                                            <span class="box"></span> 
                                            <span class="label-text">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="rakuten-price-inputs">
                                     <input type="text" name="attrs[{{ $filter->id }}]" placeholder="{{ $filter->unit ? 'Ex: '.$filter->unit : '...' }}" value="{{ request()->input('attrs.'.$filter->id) }}" class="sidebar-input-alt" style="flex: 1;">
                                     <button type="submit" class="p-ok-btn">Ok</button>
                                </div>
                            @endif
                            <div class="divider-thin"></div>
                        </div>
                    @endif
                @endforeach
            @endif



            @php
                $isVehicule = (isset($category) && str_contains(strtolower($category->nom), 'auto')) || request('category') == 'vehicules';
            @endphp

            @if($isVehicule)
                <div class="filter-group-alt">
                    <div class="filter-label-alt">KILOMÉTRAGE MAX</div>
                    <input type="number" name="km_max" class="sidebar-input-alt" placeholder="Ex: 100000" value="{{ request('km_max') }}" onchange="this.form.submit()">
                    <div class="divider-thin"></div>
                </div>
            @endif


        </form>
    </div>
    @endif
</aside>

<style>
    .catalog-sidebar {
        width: 100%;
        color: #333;
        position: sticky;
        top: 0;
        background: #fff;
        border-right: 1px solid #ebebeb;
    }

    .sidebar-section {
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 0.5rem;
    }

    .sidebar-header {
        background-color: #f7f7f7;
        padding: 0.6rem 1rem;
        font-size: 0.75rem;
        font-weight: 800;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #ebebeb;
        margin-bottom: 0.5rem;
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .menu-item a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        color: #333;
        font-size: 0.82rem;
        padding: 0.4rem 1rem;
        transition: all 0.2s;
        line-height: 1.4;
    }

    .menu-item a:hover {
        background-color: #f9f9f9;
        color: #bf0000;
    }

    .menu-item.category-main a {
        font-size: 0.9rem;
        color: #000;
        font-weight: 700;
        padding-top: 0.45rem;
        padding-bottom: 0.45rem;
    }

    .menu-item.sub-item a {
        padding-left: 2rem;
        color: #555;
        font-size: 0.8rem;
    }

    .menu-item.back-link a {
        color: #666;
        font-size: 0.75rem;
        gap: 0.5rem;
        justify-content: flex-start;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .divider {
        height: 1px;
        background-color: #e5e5e5;
        margin: 0.5rem 0;
    }

    .divider-thin {
        height: 1px;
        background-color: #f0f0f0;
        margin: 0.75rem 0;
    }

    .filter-label-alt {
        font-size: 0.7rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 0;
    }

    .filter-group-alt {
        padding: 0 1rem;
        margin-bottom: 0.75rem;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 0.75rem;
    }

    .filter-group-alt:last-of-type {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0.5rem;
    }

    /* Rakuten Style Checkbox */
    .rakuten-checkbox {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.85rem;
        cursor: pointer;
        color: #333;
        margin-bottom: 0.5rem;
        position: relative;
        line-height: normal;
    }

    .rakuten-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .rakuten-checkbox .box {
        height: 16px;
        width: 16px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 2px;
        flex-shrink: 0;
    }

    .rakuten-checkbox:hover .box {
        border-color: #999;
    }

    .rakuten-checkbox input:checked ~ .box {
        background-color: #fff;
        border-color: #333;
    }

    .rakuten-checkbox input:checked ~ .box:after {
        content: "";
        position: absolute;
        left: 5px;
        top: 2px;
        width: 4px;
        height: 8px;
        border: solid #333;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .rakuten-checkbox .count {
        margin-left: auto;
        color: #999;
        font-size: 0.7rem;
    }

    .rakuten-checkbox .label-text {
        flex: 1;
    }

    /* Price Inputs Alt */
    .rakuten-price-inputs {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .price-box {
        position: relative;
        flex: 1;
    }

    .price-box input {
        width: 100%;
        padding: 0.4rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 0.75rem;
        outline: none;
        -moz-appearance: textfield;
    }

    .price-box input::-webkit-outer-spin-button,
    .price-box input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .rakuten-price-inputs .hyphen {
        color: #ccc;
    }

    .p-ok-btn {
        background: #ff6600;
        color: #fff;
        border: none;
        padding: 0.4rem 0.6rem;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.75rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .p-ok-btn:hover {
        background: #e65c00;
    }

    .sidebar-input-alt {
        width: 100%;
        padding: 0.4rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 0.75rem;
        outline: none;
    }

    .count {
        color: #999;
        font-size: 0.75rem;
        font-weight: 400;
    }
</style>
