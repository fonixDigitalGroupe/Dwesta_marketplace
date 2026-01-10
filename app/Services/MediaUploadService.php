<?php

namespace App\Services;

use App\Models\AnnonceMedia;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// Intervention Image v3 - utilisation directe de ImageManager

class MediaUploadService
{
    /**
     * Formats de fichiers autorisés pour les photos
     */
    private const ALLOWED_PHOTO_TYPES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
    ];

    /**
     * Formats de fichiers autorisés pour les vidéos
     */
    private const ALLOWED_VIDEO_TYPES = [
        'video/mp4',
        'video/quicktime',
        'video/x-msvideo',
    ];

    /**
     * Taille maximale pour les photos (5 Mo)
     */
    private const MAX_PHOTO_SIZE = 5120; // 5 Mo en Ko

    /**
     * Taille maximale pour les vidéos (50 Mo)
     */
    private const MAX_VIDEO_SIZE = 51200; // 50 Mo en Ko

    /**
     * Upload une photo pour une annonce
     *
     * @param UploadedFile $file
     * @param int $annonceId ID de l'annonce
     * @param bool $estPrincipale Si c'est la photo principale
     * @param int $ordre Ordre d'affichage
     * @return AnnonceMedia
     * @throws \Exception
     */
    public function uploadPhoto(UploadedFile $file, int $annonceId, bool $estPrincipale = false, int $ordre = 0): AnnonceMedia
    {
        // Validation
        if (!in_array($file->getMimeType(), self::ALLOWED_PHOTO_TYPES)) {
            throw new \Exception('Format de photo non autorisé. Formats acceptés : JPG, PNG, WEBP.');
        }

        $fileSizeInKb = $file->getSize() / 1024;
        if ($fileSizeInKb > self::MAX_PHOTO_SIZE) {
            throw new \Exception('Photo trop volumineuse. Taille maximale : 5 Mo.');
        }

        // Génération d'un nom de fichier sécurisé
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::random(40) . '_' . time() . '.' . $extension;
        
        // Chemin de stockage : annonces/{annonce_id}/photos/
        $directory = "annonces/{$annonceId}/photos";
        $path = "{$directory}/{$fileName}";

        // Upload dans le storage public
        $storedPath = $file->storeAs($directory, $fileName, 'public');

        if (!$storedPath) {
            throw new \Exception('Erreur lors de l\'upload de la photo.');
        }

        // Compression et optimisation de l'image
        $this->optimizeImage($storedPath);

        // Génération du thumbnail
        $this->generateThumbnail($storedPath);

        // Si c'est la photo principale, désactiver les autres
        if ($estPrincipale) {
            AnnonceMedia::where('annonce_id', $annonceId)
                ->where('type', AnnonceMedia::TYPE_PHOTO)
                ->where('est_principale', true)
                ->update(['est_principale' => false]);
        }

        // Création de l'enregistrement en base
        $media = AnnonceMedia::create([
            'annonce_id' => $annonceId,
            'type' => AnnonceMedia::TYPE_PHOTO,
            'chemin' => $storedPath,
            'nom_original' => $file->getClientOriginalName(),
            'taille' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'ordre' => $ordre,
            'est_principale' => $estPrincipale,
        ]);

        return $media;
    }

    /**
     * Upload une vidéo pour une annonce
     *
     * @param UploadedFile $file
     * @param int $annonceId ID de l'annonce
     * @return AnnonceMedia
     * @throws \Exception
     */
    public function uploadVideo(UploadedFile $file, int $annonceId): AnnonceMedia
    {
        // Validation
        if (!in_array($file->getMimeType(), self::ALLOWED_VIDEO_TYPES)) {
            throw new \Exception('Format de vidéo non autorisé. Formats acceptés : MP4, MOV, AVI.');
        }

        $fileSizeInKb = $file->getSize() / 1024;
        if ($fileSizeInKb > self::MAX_VIDEO_SIZE) {
            throw new \Exception('Vidéo trop volumineuse. Taille maximale : 50 Mo.');
        }

        // Vérifier qu'il n'y a pas déjà une vidéo pour cette annonce
        $existingVideo = AnnonceMedia::where('annonce_id', $annonceId)
            ->where('type', AnnonceMedia::TYPE_VIDEO)
            ->first();

        if ($existingVideo) {
            throw new \Exception('Une vidéo existe déjà pour cette annonce. Supprimez-la d\'abord.');
        }

        // Génération d'un nom de fichier sécurisé
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::random(40) . '_' . time() . '.' . $extension;
        
        // Chemin de stockage : annonces/{annonce_id}/videos/
        $directory = "annonces/{$annonceId}/videos";
        $path = "{$directory}/{$fileName}";

        // Upload dans le storage public
        $storedPath = $file->storeAs($directory, $fileName, 'public');

        if (!$storedPath) {
            throw new \Exception('Erreur lors de l\'upload de la vidéo.');
        }

        // Création de l'enregistrement en base
        $media = AnnonceMedia::create([
            'annonce_id' => $annonceId,
            'type' => AnnonceMedia::TYPE_VIDEO,
            'chemin' => $storedPath,
            'nom_original' => $file->getClientOriginalName(),
            'taille' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'ordre' => 0,
            'est_principale' => false,
        ]);

        return $media;
    }

    /**
     * Optimise une image (compression)
     *
     * @param string $path Chemin de l'image
     * @return void
     */
    private function optimizeImage(string $path): void
    {
        try {
            // Vérifier si Intervention Image v3 est disponible
            if (!class_exists(\Intervention\Image\ImageManager::class)) {
                \Log::info('Intervention Image non disponible, optimisation d\'image ignorée');
                return;
            }

            $fullPath = Storage::disk('public')->path($path);
            
            // Utiliser ImageManager pour Intervention Image v3 (avec driver GD)
            $manager = \Intervention\Image\ImageManager::gd();
            $image = $manager->read($fullPath);
            
            // Redimensionner si trop grande (max 1920px de largeur)
            if ($image->width() > 1920) {
                $image->scale(width: 1920);
            }
            
            // Compression qualité 85%
            $image->save($fullPath, quality: 85);
        } catch (\Exception $e) {
            // Si Intervention Image n'est pas disponible, on continue sans optimisation
            \Log::warning('Impossible d\'optimiser l\'image : ' . $e->getMessage());
        }
    }

    /**
     * Génère un thumbnail pour une image
     *
     * @param string $path Chemin de l'image
     * @return void
     */
    private function generateThumbnail(string $path): void
    {
        try {
            // Vérifier si Intervention Image est disponible
            if (!class_exists(\Intervention\Image\ImageManager::class)) {
                \Log::info('Intervention Image non disponible, génération de thumbnail ignorée');
                return;
            }

            $fullPath = Storage::disk('public')->path($path);
            $thumbnailPath = str_replace('/photos/', '/thumbnails/', $fullPath);
            
            // Créer le répertoire si nécessaire
            $thumbnailDir = dirname($thumbnailPath);
            if (!is_dir($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }
            
            // Utiliser ImageManager pour Intervention Image v3 (avec driver GD)
            $manager = \Intervention\Image\ImageManager::gd();
            $image = $manager->read($fullPath);
            
            // Générer le thumbnail (300x300)
            $image->cover(300, 300);
            $image->save($thumbnailPath, quality: 80);
        } catch (\Exception $e) {
            // Si Intervention Image n'est pas disponible, on continue sans thumbnail
            \Log::warning('Impossible de générer le thumbnail : ' . $e->getMessage());
        }
    }

    /**
     * Supprime un média
     *
     * @param AnnonceMedia $media
     * @return bool
     */
    public function deleteMedia(AnnonceMedia $media): bool
    {
        // Supprimer le fichier
        if (Storage::disk('public')->exists($media->chemin)) {
            Storage::disk('public')->delete($media->chemin);
            
            // Supprimer le thumbnail si c'est une photo
            if ($media->estPhoto()) {
                $thumbnailPath = str_replace('/photos/', '/thumbnails/', $media->chemin);
                if (Storage::disk('public')->exists($thumbnailPath)) {
                    Storage::disk('public')->delete($thumbnailPath);
                }
            }
        }

        // Supprimer l'enregistrement en base
        return $media->delete();
    }

    /**
     * Supprime tous les médias d'une annonce
     *
     * @param int $annonceId
     * @return void
     */
    public function deleteAllMedia(int $annonceId): void
    {
        $medias = AnnonceMedia::where('annonce_id', $annonceId)->get();
        
        foreach ($medias as $media) {
            $this->deleteMedia($media);
        }
    }

    /**
     * Réorganise l'ordre des photos
     *
     * @param array $mediaIds Tableau d'IDs dans l'ordre souhaité
     * @return void
     */
    public function reorderPhotos(array $mediaIds): void
    {
        foreach ($mediaIds as $ordre => $mediaId) {
            AnnonceMedia::where('id', $mediaId)->update(['ordre' => $ordre]);
        }
    }

    /**
     * Définit une photo comme principale
     *
     * @param int $mediaId
     * @return void
     */
    public function setMainPhoto(int $mediaId): void
    {
        $media = AnnonceMedia::findOrFail($mediaId);
        
        // Désactiver les autres photos principales
        AnnonceMedia::where('annonce_id', $media->annonce_id)
            ->where('type', AnnonceMedia::TYPE_PHOTO)
            ->where('id', '!=', $mediaId)
            ->update(['est_principale' => false]);
        
        // Activer cette photo
        $media->update(['est_principale' => true]);
    }

    /**
     * Valide un fichier photo
     *
     * @param UploadedFile $file
     * @return array ['valid' => bool, 'message' => string]
     */
    public function validatePhoto(UploadedFile $file): array
    {
        if (!in_array($file->getMimeType(), self::ALLOWED_PHOTO_TYPES)) {
            return [
                'valid' => false,
                'message' => 'Format de photo non autorisé. Formats acceptés : JPG, PNG, WEBP.'
            ];
        }

        $fileSizeInKb = $file->getSize() / 1024;
        if ($fileSizeInKb > self::MAX_PHOTO_SIZE) {
            return [
                'valid' => false,
                'message' => 'Photo trop volumineuse. Taille maximale : 5 Mo.'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Photo valide.'
        ];
    }

    /**
     * Valide un fichier vidéo
     *
     * @param UploadedFile $file
     * @return array ['valid' => bool, 'message' => string]
     */
    public function validateVideo(UploadedFile $file): array
    {
        if (!in_array($file->getMimeType(), self::ALLOWED_VIDEO_TYPES)) {
            return [
                'valid' => false,
                'message' => 'Format de vidéo non autorisé. Formats acceptés : MP4, MOV, AVI.'
            ];
        }

        $fileSizeInKb = $file->getSize() / 1024;
        if ($fileSizeInKb > self::MAX_VIDEO_SIZE) {
            return [
                'valid' => false,
                'message' => 'Vidéo trop volumineuse. Taille maximale : 50 Mo.'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Vidéo valide.'
        ];
    }
}

