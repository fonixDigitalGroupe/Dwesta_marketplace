import { useQuery } from '@tanstack/react-query';
import { Link } from 'expo-router';
import { useState } from 'react';
import {
  ActivityIndicator,
  FlatList,
  Pressable,
  Text,
  TextInput,
  View,
} from 'react-native';
import { Image } from 'expo-image';
import { api } from '../../src/api/client';

type Annonce = {
  id: number;
  titre: string;
  prix: number;
  photo: string | null;
  famille: string | null;
  note_moyenne: number;
};

export default function Home() {
  const [search, setSearch] = useState('');

  const { data, isLoading, refetch, isRefetching } = useQuery({
    queryKey: ['annonces', search],
    queryFn: async () => {
      const { data } = await api.get('/annonces', { params: { search } });
      return data.data as Annonce[];
    },
  });

  return (
    <View style={{ flex: 1, backgroundColor: '#f5f6f8' }}>
      <View style={{ padding: 12 }}>
        <TextInput
          placeholder="Rechercher un produit…"
          value={search}
          onChangeText={setSearch}
          onSubmitEditing={() => refetch()}
          returnKeyType="search"
          style={{
            backgroundColor: '#fff',
            borderRadius: 8,
            paddingHorizontal: 14,
            paddingVertical: 10,
            borderWidth: 1,
            borderColor: '#e5e7eb',
          }}
        />
      </View>

      {isLoading ? (
        <ActivityIndicator size="large" color="#004aad" style={{ marginTop: 40 }} />
      ) : (
        <FlatList
          data={data ?? []}
          keyExtractor={(a) => String(a.id)}
          numColumns={2}
          refreshing={isRefetching}
          onRefresh={refetch}
          contentContainerStyle={{ padding: 8 }}
          columnWrapperStyle={{ gap: 8 }}
          ItemSeparatorComponent={() => <View style={{ height: 8 }} />}
          ListEmptyComponent={
            <Text style={{ textAlign: 'center', color: '#888', marginTop: 40 }}>
              Aucune annonce trouvée.
            </Text>
          }
          renderItem={({ item }) => (
            <Link href={`/annonce/${item.id}`} asChild>
              <Pressable
                style={{
                  flex: 1,
                  backgroundColor: '#fff',
                  borderRadius: 10,
                  overflow: 'hidden',
                  borderWidth: 1,
                  borderColor: '#eee',
                }}
              >
                <Image
                  source={{ uri: item.photo ?? undefined }}
                  style={{ width: '100%', height: 130, backgroundColor: '#eee' }}
                  contentFit="cover"
                />
                <View style={{ padding: 8 }}>
                  <Text numberOfLines={2} style={{ fontSize: 13, color: '#111' }}>
                    {item.titre}
                  </Text>
                  <Text style={{ fontWeight: '800', color: '#f68b1e', marginTop: 4 }}>
                    {item.prix.toLocaleString('fr-FR')} FCFA
                  </Text>
                </View>
              </Pressable>
            </Link>
          )}
        />
      )}
    </View>
  );
}
