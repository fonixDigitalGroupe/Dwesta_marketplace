import { create } from 'zustand';
import { api, saveToken, clearToken, getToken } from '../api/client';

export type User = {
  id: number;
  prenom: string;
  nom: string;
  email: string;
  telephone?: string | null;
  avatar?: string | null;
  est_vendeur: boolean;
  profil_complet: boolean;
  champs_manquants: string[];
};

type AuthState = {
  user: User | null;
  loading: boolean;
  bootstrap: () => Promise<void>;
  login: (login: string, password: string) => Promise<void>;
  register: (data: Record<string, string>) => Promise<void>;
  logout: () => Promise<void>;
};

export const useAuth = create<AuthState>((set) => ({
  user: null,
  loading: true,

  // Au démarrage : si un token existe, on récupère le profil
  bootstrap: async () => {
    try {
      const token = await getToken();
      if (!token) return set({ user: null, loading: false });
      const { data } = await api.get('/me');
      set({ user: data.user, loading: false });
    } catch {
      await clearToken();
      set({ user: null, loading: false });
    }
  },

  login: async (login, password) => {
    const { data } = await api.post('/login', { login, password });
    await saveToken(data.token);
    set({ user: data.user });
  },

  register: async (payload) => {
    const { data } = await api.post('/register', payload);
    await saveToken(data.token);
    set({ user: data.user });
  },

  logout: async () => {
    try { await api.post('/logout'); } catch {}
    await clearToken();
    set({ user: null });
  },
}));
