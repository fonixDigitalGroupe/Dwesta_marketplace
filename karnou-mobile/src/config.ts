import Constants from 'expo-constants';

/**
 * URL du site Karnou (version responsive) affichée dans l'app.
 * Modifiable via app.json -> expo.extra.siteUrl.
 */
export const SITE_URL: string =
  (Constants.expoConfig?.extra?.siteUrl as string) || 'https://karnou.com';
