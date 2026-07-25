import { useQuery } from '@tanstack/react-query';
import { useLocalSearchParams } from 'expo-router';
import { ActivityIndicator, ScrollView, Text, View } from 'react-native';
import { Image } from 'expo-image';
import { api } from '../../src/api/client';

export default function AnnonceDetail() {
  const { id } = useLocalSearchParams<{ id: string }>();

  const { data: annonce, isLoading } = useQuery({
    queryKey: ['annonce', id],
    queryFn: async () => {
      const { data } = await api.get(`/annonces/${id}`);
      return data.data;
    },
  });

  if (isLoading || !annonce) {
    return <ActivityIndicator size="large" color="#004aad" style={{ marginTop: 40 }} />;
  }

  return (
    <ScrollView style={{ flex: 1, backgroundColor: '#fff' }}>
      <Image
        source={{ uri: annonce.photo ?? undefined }}
        style={{ width: '100%', height: 300, backgroundColor: '#eee' }}
        contentFit="contain"
      />
      <View style={{ padding: 16, gap: 8 }}>
        <Text style={{ fontSize: 20, fontWeight: '800', color: '#111' }}>{annonce.titre}</Text>
        <Text style={{ fontSize: 22, fontWeight: '900', color: '#f68b1e' }}>
          {Number(annonce.prix).toLocaleString('fr-FR')} FCFA
        </Text>
        {annonce.etat ? <Text style={{ color: '#555' }}>État : {annonce.etat}</Text> : null}
        <Text style={{ color: '#333', lineHeight: 22, marginTop: 8 }}>{annonce.description}</Text>

        <View style={{ marginTop: 16, borderTopWidth: 1, borderColor: '#eee', paddingTop: 12 }}>
          <Text style={{ fontWeight: '700', color: '#111' }}>Vendeur</Text>
          <Text style={{ color: '#555' }}>{annonce.vendeur?.nom ?? '—'}</Text>
        </View>
      </View>
    </ScrollView>
  );
}
