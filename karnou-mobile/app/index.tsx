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
  topBar: {
    position: 'absolute',
    top: 8,
    right: 12,
  },
});
