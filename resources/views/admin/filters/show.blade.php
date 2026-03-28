@extends('layouts.admin')

@section('title', 'Détails - ' . $filter->nom)

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.filters.index') }}">Critères & Attributs</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">{{ $filter->nom }}</span>
@endsection

@section('content')
    <div style="max-width: 900px;">

        <!-- Header avec bouton -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div>
                <h1 style="font-size: 1.375rem; color: #333; font-weight: 600; margin-bottom: 0.25rem;">
                    {{ $filter->nom }}
                </h1>
                <div style="font-size: 0.85rem; color: #666;">
                    <span style="opacity: 0.7;">Filtre associé à la catégorie :</span>
                    <span style="font-weight: 600; color: #333;">{{ $filter->category->nom }}</span>
                </div>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('admin.filters.index') }}"
                    style="background: transparent; padding: 0.625rem 0; font-size: 0.85rem; color: #333; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s; font-weight: 500;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour
                </a>

            </div>
        </div>


        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5;">

            <!-- Table Header -->
            <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.8rem; color: #666;">
                    {{ $filter->options ? count($filter->options) : 0 }} option(s) de filtrage
                </span>

            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    @if($filter->options && count($filter->options) > 0)
                        @foreach($filter->options as $option)
                            <tr style="border-bottom: 1px solid #e5e5e5; transition: all 0.2s;"
                                onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='white'">
                                <td style="padding: 0.875rem 1.25rem;">
                                    <div style="font-size: 0.875rem; color: #333; font-weight: 500;">{{ $option }}</div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="padding: 3rem 1.25rem; text-align: center; color: #999; font-size: 0.875rem;">
                                Aucune option définie
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
@endsection
