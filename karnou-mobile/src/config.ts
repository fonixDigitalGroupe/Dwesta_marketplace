import Constants from 'expo-constants';

/**
 * URL de base de l'API Laravel.
 * En dev local (émulateur) : remplacez par http://10.0.2.2:8000/api (Android)
 * ou http://127.0.0.1:8000/api (iOS), et lancez `php artisan serve`.
 */
export const API_BASE_URL: string =
  (Constants.expoConfig?.extra?.apiBaseUrl as string) || 'https://karnou.com/api';
