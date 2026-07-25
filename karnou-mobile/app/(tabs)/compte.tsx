import { router } from 'expo-router';
import { Pressable, Text, View } from 'react-native';
import { useAuth } from '../../src/store/auth';

export default function Compte() {
  const { user, logout } = useAuth();

  if (!user) {
    return (
      <View style={{ flex: 1, justifyContent: 'center', padding: 24, gap: 16 }}>
        <Text style={{ fontSize: 16, textAlign: 'center', color: '#444' }}>
          Connectez-vous pour accéder à votre compte.
        </Text>
        <Pressable
          onPress={() => router.push('/(auth)/login')}
          style={{ backgroundColor: '#004aad', padding: 14, borderRadius: 8 }}
        >
          <Text style={{ color: '#fff', textAlign: 'center', fontWeight: '700' }}>
            Se connecter
          </Text>
        </Pressable>
      </View>
    );
  }

  return (
    <View style={{ flex: 1, padding: 24, gap: 8 }}>
      <Text style={{ fontSize: 22, fontWeight: '800' }}>
        {user.prenom} {user.nom}
      </Text>
      <Text style={{ color: '#666' }}>{user.email}</Text>
      {user.telephone ? <Text style={{ color: '#666' }}>{user.telephone}</Text> : null}

      {!user.profil_complet && (
        <View style={{ backgroundColor: '#fff8f0', borderColor: '#f4c28e', borderWidth: 1, borderRadius: 8, padding: 12, marginTop: 12 }}>
          <Text style={{ color: '#8a5a00' }}>
            Profil incomplet — manquant : {user.champs_manquants.join(', ')}.
          </Text>
        </View>
      )}

      <Pressable
        onPress={async () => { await logout(); }}
        style={{ marginTop: 24, backgroundColor: '#dc2626', padding: 14, borderRadius: 8 }}
      >
        <Text style={{ color: '#fff', textAlign: 'center', fontWeight: '700' }}>Se déconnecter</Text>
      </Pressable>
    </View>
  );
}
