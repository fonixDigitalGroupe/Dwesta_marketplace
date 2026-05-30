@php
    $activeTab = request('tab', 'utilisateur');
@endphp

{{-- Pull the tab bar flush to the top of agence-content (cancels the 1.5rem padding) --}}
<div id="tabs-wrapper"
    style="margin: -1.5rem -1.5rem 0 -1.5rem;
           background: #fff;
           border-bottom: 1px solid #e7e7e7;
           box-shadow: inset 0 -1px 0 #e7e7e7;
           position: relative;
           display: flex;
           align-items: center;
           overflow: hidden;
           height: 50px;">

    <div id="tabs-container"
        style="display: flex; align-items: stretch; overflow-x: auto; scroll-behavior: smooth;
               -ms-overflow-style: none; scrollbar-width: none; flex: 1; padding: 0; height: 100%;">

        {{-- Tab: Utilisateur --}}
        <a href="{{ route('profile.edit') }}?tab=utilisateur"
            style="display: flex; align-items: center; gap: 8px;
                   padding: 0 32px;
                   font-size: 0.85rem;
                   font-weight: {{ $activeTab == 'utilisateur' ? '700' : '500' }};
                   color: {{ $activeTab == 'utilisateur' ? '#111' : '#555' }};
                   text-decoration: none; white-space: nowrap; position: relative; height: 100%;"
            onmouseover="this.style.color='#111'; this.style.background='rgba(0,0,0,0.02)'"
            onmouseout="this.style.color='{{ $activeTab == 'utilisateur' ? '#111' : '#555' }}'; this.style.background='transparent'">
            <i class="fas fa-user-circle"
               style="font-size: 0.85rem;
                      opacity: {{ $activeTab == 'utilisateur' ? '1' : '0.6' }};
                      color: {{ $activeTab == 'utilisateur' ? '#e77600' : 'inherit' }};"></i>
            Utilisateur
        </a>

        {{-- Tab: Configuration --}}
        <a href="{{ route('profile.edit') }}?tab=configuration"
            style="display: flex; align-items: center; gap: 8px;
                   padding: 0 32px;
                   font-size: 0.85rem;
                   font-weight: {{ $activeTab == 'configuration' ? '700' : '500' }};
                   color: {{ $activeTab == 'configuration' ? '#111' : '#555' }};
                   text-decoration: none; white-space: nowrap; position: relative; height: 100%;"
            onmouseover="this.style.color='#111'; this.style.background='rgba(0,0,0,0.02)'"
            onmouseout="this.style.color='{{ $activeTab == 'configuration' ? '#111' : '#555' }}'; this.style.background='transparent'">
            <i class="fas fa-cog"
               style="font-size: 0.85rem;
                      opacity: {{ $activeTab == 'configuration' ? '1' : '0.6' }};
                      color: {{ $activeTab == 'configuration' ? '#e77600' : 'inherit' }};"></i>
            Configuration
        </a>

    </div>
</div>

<style>
    #tabs-container::-webkit-scrollbar { display: none; }
</style>
