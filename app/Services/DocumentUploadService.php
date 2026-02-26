<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentUploadService
{
    /**
     * Formats de fichiers autorisés pour les documents
     */
    private const ALLOWED_MIME_TYPES = [
        'application/pdf',
        'image/jpeg',
        'image/jpg',
        'image/png',
    ];

    /**
     * Taille maximale en Ko (5 Mo)
     */
    private const MAX_FILE_SIZE = 5120; // 5 Mo en Ko

    /**
     * Upload un document de vendeur
     *
     * @param UploadedFile $file
     * @param string $type Type de document (cni, passeport, recepisse, registre_commerce)
     * @param int $vendeurId ID du vendeur
     * @return string Chemin du fichier uploadé
     * @throws \Exception
     */
    public function uploadDocument(UploadedFile $file, string $type, int $vendeurId): string
    {
        return $this->uploadToStore($file, "documents/vendeurs/{$vendeurId}/{$type}");
    }

    /**
     * Upload un document de livreur
     *
     * @param UploadedFile $file
     * @param string $type
     * @param int $livreurId
     * @return string
     * @throws \Exception
     */
    public function uploadLivreurDocument(UploadedFile $file, string $type, int $livreurId): string
    {
        return $this->uploadToStore($file, "documents/livreurs/{$livreurId}/{$type}");
    }

    /**
     * Upload un document de transporteur
     *
     * @param UploadedFile $file
     * @param string $type
     * @param int $transporteurId
     * @return string
     * @throws \Exception
     */
    public function uploadTransporteurDocument(UploadedFile $file, string $type, int $transporteurId): string
    {
        return $this->uploadToStore($file, "documents/transporteurs/{$transporteurId}/{$type}");
    }

    /**
     * Upload générique vers un dossier spécifique
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     * @throws \Exception
     */
    private function uploadToStore(UploadedFile $file, string $folder): string
    {
        // Validation du type MIME
        if (!in_array($file->getMimeType(), self::ALLOWED_MIME_TYPES)) {
            throw new \Exception('Format de fichier non autorisé. Formats acceptés : PDF, JPG, PNG.');
        }

        // Validation de la taille
        $fileSizeInKb = $file->getSize() / 1024;
        if ($fileSizeInKb > self::MAX_FILE_SIZE) {
            throw new \Exception('Fichier trop volumineux. Taille maximale : 5 Mo.');
        }

        // Génération d'un nom de fichier sécurisé
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::random(40) . '_' . time() . '.' . $extension;

        // Upload dans le storage privé
        $storedPath = $file->storeAs($folder, $fileName, 'private');

        if (!$storedPath) {
            throw new \Exception('Erreur lors de l\'upload du fichier.');
        }

        return $storedPath;
    }

    /**
     * Supprime un document
     *
     * @param string $path Chemin du document
     * @return bool
     */
    public function deleteDocument(string $path): bool
    {
        if (Storage::disk('private')->exists($path)) {
            return Storage::disk('private')->delete($path);
        }

        return false;
    }

    /**
     * Récupère l'URL d'un document (pour téléchargement sécurisé)
     *
     * @param string|null $path Chemin du document
     * @return string|null
     */
    public function getDocumentUrl(?string $path): ?string
    {
        if (!$path || !Storage::disk('private')->exists($path)) {
            return null;
        }

        // Pour un disque local, utiliser une route sécurisée
        // L'URL sera générée par le contrôleur DocumentController
        return route('documents.show', ['path' => base64_encode($path)]);
    }

    /**
     * Vérifie si un fichier est valide
     *
     * @param UploadedFile $file
     * @return array ['valid' => bool, 'message' => string]
     */
    public function validateFile(UploadedFile $file): array
    {
        // Vérification du type MIME
        if (!in_array($file->getMimeType(), self::ALLOWED_MIME_TYPES)) {
            return [
                'valid' => false,
                'message' => 'Format de fichier non autorisé. Formats acceptés : PDF, JPG, PNG.'
            ];
        }

        // Vérification de la taille
        $fileSizeInKb = $file->getSize() / 1024;
        if ($fileSizeInKb > self::MAX_FILE_SIZE) {
            return [
                'valid' => false,
                'message' => 'Fichier trop volumineux. Taille maximale : 5 Mo.'
            ];
        }

        return [
            'valid' => true,
            'message' => 'Fichier valide.'
        ];
    }

    /**
     * Formats autorisés pour l'affichage
     *
     * @return array
     */
    public static function getAllowedFormats(): array
    {
        return ['pdf', 'jpg', 'jpeg', 'png'];
    }

    /**
     * Taille maximale pour l'affichage
     *
     * @return string
     */
    public static function getMaxSize(): string
    {
        return '5 Mo';
    }
}

