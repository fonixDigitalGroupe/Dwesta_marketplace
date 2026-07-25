import { router } from 'expo-router';
import { useState } from 'react';
import { ActivityIndicator, Alert, Pressable, Text, TextInput, View } from 'react-native';
import { useAuth } from '../../src/store/auth';

export default function Login() {
  const login = useAuth((s) => s.login);
  const [identifiant, setIdentifiant] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);

  const submit = async () => {
    if (!identifiant || !password) return;
    setLoading(true);
    try {
      await login(identifiant, password);
      router.replace('/(tabs)/compte');
    } catch (e: any) {
      Alert.alert('Connexion échouée', e?.response?.data?.message ?? 'Identifiants invalides.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <View style={{ flex: 1, padding: 24, gap: 14, backgroundColor: '#fff' }}>
      <Text style={{ fontSize: 24, fontWeight: '800', marginBottom: 8 }}>Connexion</Text>

      <TextInput
        placeholder="Email ou téléphone"
        autoCapitalize="none"
        value={identifiant}
        onChangeText={setIdentifiant}
        style={inputStyle}
      />
      <TextInput
        placeholder="Mot de passe"
        secureTextEntry
        value={password}
        onChangeText={setPassword}
        style={inputStyle}
      />

      <Pressable
        onPress={submit}
        disabled={loading}
        style={{ backgroundColor: '#004aad', padding: 15, borderRadius: 8, opacity: loading ? 0.6 : 1 }}
      >
        {loading ? (
          <ActivityIndicator color="#fff" />
        ) : (
          <Text style={{ color: '#fff', textAlign: 'center', fontWeight: '700' }}>Me connecter</Text>
        )}
      </Pressable>
    </View>
  );
}

const inputStyle = {
  borderWidth: 1,
  borderColor: '#e5e7eb',
  borderRadius: 8,
  padding: 14,
  fontSize: 15,
} as const;
