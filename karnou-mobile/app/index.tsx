import { useRef, useState, useCallback, useEffect } from 'react';
import { ActivityIndicator, Animated, BackHandler, StyleSheet, Text, View } from 'react-native';
import { useFocusEffect } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { WebView, WebViewNavigation } from 'react-native-webview';
import { SITE_URL } from '../src/config';

export default function KarnouWebApp() {
  const webRef = useRef<WebView>(null);
  const [loading, setLoading] = useState(true);
  const [firstDone, setFirstDone] = useState(false); // true une fois la 1re page chargée
  const [canGoBack, setCanGoBack] = useState(false);

  // Animation de pulsation du texte "Karnou" sur l'écran de lancement
  const pulse = useRef(new Animated.Value(0.4)).current;
  useEffect(() => {
    const anim = Animated.loop(
      Animated.sequence([
        Animated.timing(pulse, { toValue: 1, duration: 750, useNativeDriver: true }),
        Animated.timing(pulse, { toValue: 0.4, duration: 750, useNativeDriver: true }),
      ])
    );
    anim.start();
    return () => anim.stop();
  }, [pulse]);

  // Paniers 🛒 qui flottent autour de "Karnou"
  const carts = useRef(
    [0, 1, 2, 3, 4].map(() => new Animated.Value(0))
  ).current;
  useEffect(() => {
    const anims = carts.map((v, i) =>
      Animated.loop(
        Animated.sequence([
          Animated.delay(i * 300),
          Animated.timing(v, { toValue: 1, duration: 1600, useNativeDriver: true }),
          Animated.timing(v, { toValue: 0, duration: 1600, useNativeDriver: true }),
        ])
      )
    );
    anims.forEach((a) => a.start());
    return () => anims.forEach((a) => a.stop());
  }, [carts]);

  // Positions (autour du texte) + sens du mouvement de chaque panier
  const cartConfig = [
    { top: '22%', left: '12%', dy: -18 },
    { top: '30%', right: '14%', dy: 16 },
    { bottom: '26%', left: '18%', dy: 14 },
    { bottom: '20%', right: '16%', dy: -16 },
    { top: '16%', left: '46%', dy: -14 },
  ];

  // Bouton retour Android → revient dans l'historique du site
  useFocusEffect(
    useCallback(() => {
      const onBack = () => {
        if (canGoBack && webRef.current) {
          webRef.current.goBack();
          return true; // on gère le retour nous-mêmes
        }
        return false; // sinon comportement par défaut (quitter l'app)
      };
      const sub = BackHandler.addEventListener('hardwareBackPress', onBack);
      return () => sub.remove();
    }, [canGoBack])
  );

  const onNav = (navState: WebViewNavigation) => {
    setCanGoBack(navState.canGoBack);
  };

  return (
    <SafeAreaView style={styles.container} edges={['top', 'left', 'right']}>
      <WebView
        ref={webRef}
        source={{ uri: SITE_URL }}
        onNavigationStateChange={onNav}
        onLoadStart={() => setLoading(true)}
        onLoadEnd={() => {
          setLoading(false);
          setFirstDone(true);
        }}
        // Réglages utiles marketplace (paiement, upload photo, cookies/session)
        javaScriptEnabled
        domStorageEnabled
        thirdPartyCookiesEnabled
        sharedCookiesEnabled
        allowsInlineMediaPlayback
        allowsBackForwardNavigationGestures
        originWhitelist={['*']}
        startInLoadingState
        pullToRefreshEnabled
        setSupportMultipleWindows={false}
        renderLoading={() => <View />}
        style={styles.webview}
      />

      {/* Écran de lancement (1er chargement) : fond orange + "Karnou" animé, sans cercle */}
      {loading && !firstDone && (
        <View style={styles.splash} pointerEvents="none">
          {cartConfig.map((c, i) => (
            <Animated.Text
              key={i}
              style={[
                styles.cart,
                {
                  top: c.top as any,
                  left: c.left as any,
                  right: c.right as any,
                  bottom: c.bottom as any,
                  opacity: carts[i].interpolate({ inputRange: [0, 0.5, 1], outputRange: [0.35, 1, 0.35] }),
                  transform: [
                    { translateY: carts[i].interpolate({ inputRange: [0, 1], outputRange: [0, c.dy] }) },
                  ],
                },
              ]}
            >
              🛒
            </Animated.Text>
          ))}
          <Animated.Text style={[styles.brand, { opacity: pulse }]}>Karnou</Animated.Text>
        </View>
      )}

      {/* Chargements de page suivants : juste le cercle */}
      {loading && firstDone && (
        <View style={styles.loader} pointerEvents="none">
          <ActivityIndicator size="large" color="#9ca3af" />
        </View>
      )}
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: '#004aad' },
  webview: { flex: 1, backgroundColor: '#fff' },
  loader: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#fff',
  },
  splash: {
    position: 'absolute',
    top: 0,
    left: 0,
    right: 0,
    bottom: 0,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f68b1e',
  },
  brand: {
    fontSize: 40,
    fontWeight: '800',
    color: '#ffffff',
    letterSpacing: 1,
  },
  cart: {
    position: 'absolute',
    fontSize: 30,
  },
  topBar: {
    position: 'absolute',
    top: 8,
    right: 12,
  },
});
