<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\AnnonceMedia;
use App\Services\MediaUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnnonceMediaController extends Controller
{
    protected MediaUploadService $mediaService;

    public function __construct(MediaUploadService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Upload une photo
     */
    public function uploadPhoto(Request $request, Annonce $annonce)
    {
        // Vérifier que l'utilisateur est propriétaire de l'annonce
        if ($annonce->vendeur->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }

        $request->validate([
            'photo' => ['required', 'image', 'max:5120'], // 5 Mo max
            'est_principale' => ['nullable', 'boolean'],
            'ordre' => ['nullable', 'integer', 'min:0'],
        ]);

        try {
            $media = $this->mediaService->uploadPhoto(
                $request->file('photo'),
                $annonce->id,
                $request->boolean('est_principale', false),
                $request->input('ordre', 0)
            );

            // Mettre à jour le compteur de photos
            $annonce->update(['nb_photos' => $annonce->photos()->count()]);

            return response()->json([
                'success' => true,
                'message' => 'Photo uploadée avec succès.',
                'media' => $media,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Upload une vidéo
     */
    public function uploadVideo(Request $request, Annonce $annonce)
    {
        // Vérifier que l'utilisateur est propriétaire de l'annonce
        if ($annonce->vendeur->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }

        $request->validate([
            'video' => ['required', 'mimes:mp4,mov,avi', 'max:51200'], // 50 Mo max
        ]);

        try {
            $media = $this->mediaService->uploadVideo(
                $request->file('video'),
                $annonce->id
            );

            // Marquer que la vidéo a été achetée
            $annonce->update(['video_achetee' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Vidéo uploadée avec succès.',
                'media' => $media,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Supprime un média
     */
    public function destroy(AnnonceMedia $media)
    {
        $annonce = $media->annonce;
        
        // Vérifier que l'utilisateur est propriétaire de l'annonce
        if ($annonce->vendeur->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce média.');
        }

        try {
            $this->mediaService->deleteMedia($media);

            // Mettre à jour le compteur de photos si c'était une photo
            if ($media->estPhoto()) {
                $annonce->update(['nb_photos' => $annonce->photos()->count()]);
            }

            // Si c'était la vidéo, mettre à jour le flag
            if ($media->estVideo()) {
                $annonce->update(['video_achetee' => false]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Média supprimé avec succès.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Réorganise l'ordre des photos
     */
    public function reorder(Request $request, Annonce $annonce)
    {
        // Vérifier que l'utilisateur est propriétaire de l'annonce
        if ($annonce->vendeur->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }

        $request->validate([
            'media_ids' => ['required', 'array'],
            'media_ids.*' => ['integer', 'exists:annonce_medias,id'],
        ]);

        try {
            $this->mediaService->reorderPhotos($request->input('media_ids'));

            return response()->json([
                'success' => true,
                'message' => 'Ordre des photos mis à jour.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Définit une photo comme principale
     */
    public function setMainPhoto(AnnonceMedia $media)
    {
        $annonce = $media->annonce;
        
        // Vérifier que l'utilisateur est propriétaire de l'annonce
        if ($annonce->vendeur->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette annonce.');
        }

        // Vérifier que c'est une photo
        if (!$media->estPhoto()) {
            return response()->json([
                'success' => false,
                'message' => 'Seules les photos peuvent être définies comme principales.',
            ], 400);
        }

        try {
            $this->mediaService->setMainPhoto($media->id);

            return response()->json([
                'success' => true,
                'message' => 'Photo principale mise à jour.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}

