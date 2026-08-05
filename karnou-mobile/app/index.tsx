import { useRef, useState, useCallback, useEffect } from 'react';
import { Animated, BackHandler, StyleSheet, Text, View } from 'react-native';
import { useFocusEffect } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { WebView, WebViewNavigation } from 'react-native-webview';
import { Ionicons } from '@expo/vector-icons';
import { SITE_URL } from '../src/config';

export default function KarnouWebApp() {
  const webRef = useRef<WebView>(null);
  const [loading, setLoading] = useState(true);
  const [firstDone, setFirstDone] = useState(false); // true une fois la 1re page chargée
  const [minSplash, setMinSplash] = useState(false);  // true après 5s minimum d'écran de lancement
  const [canGoBack, setCanGoBack] = useState(false);

  // L'écran de lancement reste affiché au moins 5 secondes
  useEffect(() => {
    const t = setTimeout(() => setMinSplash(true), 5000);
    return () => clearTimeout(t);
  }, []);

  const splashVisible = !(firstDone && minSplash); // splash tant que : pas chargé OU < 5s

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

  // Positions rapprochées du texte + sens du mouvement de chaque panier
  const cartConfig = [
    { top: '38%', left: '28%', dy: -14 },
    { top: '40%', right: '28%', dy: 12 },
    { bottom: '40%', left: '34%', dy: 12 },
    { bottom: '38%', right: '32%', dy: -12 },
    { top: '34%', left: '48%', dy: -12 },
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

  // Le loader n'apparaît que pour les actions "lourdes" :
  // recherche, boutique pro, checkout/paiement (Stripe). Sinon navigation instantanée.
  const isHeavyUrl = (url: string) => {
    if (!url) return false;
    return /\/(recherche|search|page-pro|checkout|abonnements\/checkout|paiement)/i.test(url)
      || /stripe\.com|checkout\.stripe|paydunya|wave|orange/i.test(url);
  };

  return (
    <SafeAreaView style={styles.container} edges={['top', 'left', 'right']}>
      <WebView
        ref={webRef}
        source={{ uri: SITE_URL }}
        onNavigationStateChange={onNav}
        onLoadStart={(e) => {
          // Affiche le loader uniquement pour les pages lourdes (le splash gère le 1er chargement)
          if (firstDone && isHeavyUrl(e.nativeEvent.url)) {
            setLoading(true);
          }
        }}
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
        javaScriptCanOpenWindowsAutomatically
        setSupportMultipleWindows={true}
        onOpenWindow={(e) => {
          // Ex. paiement Stripe qui tente d'ouvrir une nouvelle fenêtre :
          // on redirige la WebView principale vers cette URL (reste dans l'app).
          const url = e.nativeEvent.targetUrl;
          if (url && webRef.current) {
            webRef.current.injectJavaScript(`window.location.href = ${JSON.stringify(url)}; true;`);
          }
        }}
        renderLoading={() => <View />}
        style={styles.webview}
      />

      {/* Écran de lancement : fond orange + "Karnou" animé (≥ 5s, jusqu'au chargement) */}
      {splashVisible && (
        <View style={styles.splash} pointerEvents="none">
          {cartConfig.map((c, i) => (
            <Animated.View
              key={i}
              style={[
                styles.cart,
                {
                  top: c.top as any,
                  left: c.left as any,
                  right: c.right as any,
                  bottom: c.bottom as any,
                  opacity: carts[i].interpolate({ inputRange: [0, 0.5, 1], outputRange: [0.4, 1, 0.4] }),
                  transform: [
                    { translateY: carts[i].interpolate({ inputRange: [0, 1], outputRange: [0, c.dy] }) },
                  ],
                },
              ]}
            >
              <Ionicons name="cart" size={26} color="#ffffff" />
            </Animated.View>
          ))}
          <Animated.Text style={[styles.brand, { opacity: pulse }]}>Karnou</Animated.Text>
        </View>
      )}

      {/* Chargements de page suivants : un panier animé (gris) */}
      {loading && !splashVisible && (
        <View style={styles.loader} pointerEvents="none">
          <Animated.View
            style={{
              opacity: pulse,
              transform: [{ scale: pulse.interpolate({ inputRange: [0.4, 1], outputRange: [0.85, 1.1] }) }],
            }}
          >
            <Ionicons name="cart" size={40} color="#d1975a" />
          </Animated.View>
          <Text style={styles.loaderBrand}>Karnou</Text>
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
  loaderBrand: {
    marginTop: 10,
    fontSize: 18,
    fontWeight: '700',
    color: '#9ca3af',
    letterSpacing: 0.5,
  },
  topBar: {
    position: 'absolute',
    top: 8,
    right: 12,
  },
});
