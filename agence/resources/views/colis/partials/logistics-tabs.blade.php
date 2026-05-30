@php
    $logisticsTabs = [
        ['id' => 'stock', 'label' => 'En Stock', 'icon' => 'fa-warehouse'],
        ['id' => 'incoming', 'label' => 'À Recevoir', 'icon' => 'fa-truck-loading'],
        ['id' => 'history', 'label' => 'Historique', 'icon' => 'fa-history'],
    ];
@endphp

<div id="tabs-wrapper"
    style="background: #fff; border: 1px solid #e7e7e7; border-bottom: none; box-shadow: inset 0 -1px 0 #e7e7e7; margin-bottom: 0; position: relative; display: flex; align-items: center; overflow: hidden; height: 50px;">
    
    <div id="tabs-container"
        style="display: flex; align-items: stretch; overflow-x: auto; scroll-behavior: smooth; flex: 1; padding: 0; height: 100%;">
        @foreach($logisticsTabs as $tab)
            <a href="{{ route('operations.stock', ['tab' => $tab['id']]) }}" 
               class="settings-tab-link"
               style="display: flex; align-items: center; gap: 8px; padding: 0 25px; font-size: 0.85rem; font-weight: {{ $activeTab == $tab['id'] ? '700' : '500' }}; color: {{ $activeTab == $tab['id'] ? '#111' : '#555' }}; text-decoration: none; transition: all 0.2s; white-space: nowrap; position: relative; border-bottom: {{ $activeTab == $tab['id'] ? '3px solid #e77600' : 'none' }}; margin-bottom: 0px;"
               onmouseover="this.style.background='rgba(0,0,0,0.02)'"
               onmouseout="this.style.background='transparent'">
                <i class="fas {{ $tab['icon'] }}"
                    style="font-size: 0.85rem; opacity: {{ $activeTab == $tab['id'] ? '1' : '0.6' }}; color: {{ $activeTab == $tab['id'] ? '#e77600' : 'inherit' }};"></i>
                {{ $tab['label'] }} ({{ $counts[$tab['id']] ?? 0 }})
            </a>
        @endforeach
    </div>
</div>

<style>
    #tabs-container::-webkit-scrollbar { display: none; }
</style>
