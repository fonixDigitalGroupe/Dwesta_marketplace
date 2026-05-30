import React from 'react';
import { StyleSheet, View } from 'react-native';
import { WebView } from 'react-native-webview';

export default function LeafletMap({ userLocation }) {
  const webviewRef = React.useRef(null);

  // Injection de la position quand elle change
  React.useEffect(() => {
    if (userLocation && webviewRef.current) {
      const js = `updateLocation(${userLocation.latitude}, ${userLocation.longitude});`;
      webviewRef.current.injectJavaScript(js);
    }
  }, [userLocation]);

  const htmlContent = `
    <!DOCTYPE html>
    <html>
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <style>
          body { margin: 0; padding: 0; background: #212121; }
          #map { height: 100vh; width: 100vw; }
          .leaflet-tile-pane {
            filter: brightness(0.6) invert(1) contrast(3) hue-rotate(200deg) brightness(0.3) saturate(0.3);
          }
          .user-marker {
            background: #004aad;
            border: 3px solid white;
            border-radius: 50%;
            width: 20px !important;
            height: 20px !important;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
          }
        </style>
      </head>
      <body>
        <div id="map"></div>
        <script>
          var map = L.map('map', {
            zoomControl: false,
            attributionControl: false
          }).setView([5.3484, -4.0305], 15);

          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
          }).addTo(map);

          var userMarker = null;

          window.updateLocation = function(lat, lng) {
            if (!userMarker) {
              var icon = L.divIcon({ className: 'user-marker' });
              userMarker = L.marker([lat, lng], { icon: icon }).addTo(map);
            } else {
              userMarker.setLatLng([lat, lng]);
            }
            map.panTo([lat, lng]);
          };
        </script>
      </body>
    </html>
  `;

  return (
    <View style={styles.container}>
      <WebView
        ref={webviewRef}
        originWhitelist={['*']}
        source={{ html: htmlContent }}
        style={styles.webview}
        scrollEnabled={false}
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    ...StyleSheet.absoluteFillObject,
    backgroundColor: '#212121',
  },
  webview: {
    flex: 1,
    backgroundColor: 'transparent',
  },
});
