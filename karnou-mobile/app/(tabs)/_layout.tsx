import { Tabs } from 'expo-router';
import { Text } from 'react-native';

function icon(label: string) {
  return ({ color }: { color: string }) => (
    <Text style={{ color, fontSize: 20 }}>{label}</Text>
  );
}

export default function TabsLayout() {
  return (
    <Tabs
      screenOptions={{
        tabBarActiveTintColor: '#004aad',
        headerStyle: { backgroundColor: '#004aad' },
        headerTintColor: '#fff',
      }}
    >
      <Tabs.Screen name="index" options={{ title: 'Accueil', tabBarIcon: icon('🏠') }} />
      <Tabs.Screen name="compte" options={{ title: 'Compte', tabBarIcon: icon('👤') }} />
    </Tabs>
  );
}
