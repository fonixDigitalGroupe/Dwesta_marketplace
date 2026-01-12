@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <span style="color: var(--mady-red); font-weight: 700;">Vue d'ensemble</span>
@endsection

@section('content')
<div style="display: flex; flex-direction: column; gap: 2.5rem;">
    
    <!-- Hero Section -->
    <header style="display: flex; align-items: flex-end; justify-content: space-between;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 800; color: var(--slate-900); letter-spacing: -0.03em; margin-bottom: 0.5rem;">Bienvenue, {{ auth()->user()->prenom }}</h1>

@endsection
