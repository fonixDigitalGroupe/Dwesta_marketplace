@extends('layouts.app')

@section('title', 'Votre marketplace en ligne')

@push('styles')
    <style>
        /* Styles spécifiques à la home page */
        .hero-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            gap: 2rem;
            align-items: center;
            border: 1px solid #e0e0e0;
        }

        .hero-text {
            flex: 1;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .hero-image {
            flex: 1;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .category-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            color: #333;
            border: 1px solid #e0e0e0;
            transition: all 0.2s;
        }

        .category-card:hover {
            border-color: #bf0000;
            color: #bf0000;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .main-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <!-- Hero Section -->
        <div
            style="background: white; padding: 3rem; border-radius: 12px; margin-bottom: 3rem; border: 1px solid #e0e0e0; min-height: 300px;">
        </div>


        <!-- Les sections d'articles ont été vidées par l'utilisateur mais les titres sont conservés -->

        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2
                    style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Nos offres imbattables</h2>
            </div>
            <div
                style="border: 2px dashed #f0f0f0; border-radius: 12px; height: 320px; display: flex; align-items: center; justify-content: center; background: #fafafa;">
            </div>
        </div>

        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2
                    style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Top des produits les plus consultés</h2>
            </div>
            <div
                style="border: 2px dashed #f0f0f0; border-radius: 12px; height: 320px; display: flex; align-items: center; justify-content: center; background: #fafafa;">
            </div>
        </div>

        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2
                    style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Nos top produits du moment</h2>
            </div>
            <div
                style="border: 2px dashed #f0f0f0; border-radius: 12px; height: 320px; display: flex; align-items: center; justify-content: center; background: #fafafa;">
            </div>
        </div>

        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2
                    style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Dernières opportunités</h2>
            </div>
            <div
                style="border: 2px dashed #f0f0f0; border-radius: 12px; height: 320px; display: flex; align-items: center; justify-content: center; background: #fafafa;">
            </div>
        </div>
    </div>
@endsection