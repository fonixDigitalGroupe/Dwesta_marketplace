import React from 'react';
import { StyleSheet, View, Text, TouchableOpacity, Dimensions, Alert, Platform } from 'react-native';
import * as Location from 'expo-location';
import { SafeAreaView } from 'react-native-safe-area-context';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { Search, ChevronRight, User as UserIcon, Settings } from 'lucide-react-native';
import RequestOverlay from '../components/RequestOverlay';
import LeafletMap from '../components/LeafletMap';

const { width, height } = Dimensions.get('window');

export default function HomeScreen({ navigation }) {
    const [isOnline, setIsOnline] = React.useState(false);
    const [showRequest, setShowRequest] = React.useState(false);
    const [activeTrip, setActiveTrip] = React.useState(null); // 'pickup', 'on_site', 'otp', 'destination'
    const locationSubscription = React.useRef(null);
    const [userLocation, setUserLocation] = React.useState(null);

    // Suivi de la position GPS (toujours actif pour le dashboard)
    React.useEffect(() => {
        const startTracking = async () => {
            try {
                const { status } = await Location.requestForegroundPermissionsAsync();
                if (status !== 'granted') return;

                locationSubscription.current = await Location.watchPositionAsync(
                    {
                        accuracy: Location.Accuracy.High,
                        distanceInterval: 5,
                    },
                    (location) => {
                        const { latitude, longitude } = location.coords;
                        setUserLocation({ latitude, longitude });
                    }
                );
            } catch (err) {
                console.error('Location Tracking Error:', err);
            }
        };

        startTracking();

        return () => {
            if (locationSubscription.current) {
                locationSubscription.current.remove();
                locationSubscription.current = null;
            }
        };
    }, []);

    // Simulation de mission
    React.useEffect(() => {
        let timer;
        if (isOnline && !activeTrip && !showRequest) {
            timer = setTimeout(() => {
                setShowRequest(true);
            }, 8000);
        }
        return () => clearTimeout(timer);
    }, [isOnline, activeTrip, showRequest]);

    const handleAccept = () => {
        setShowRequest(false);
        setActiveTrip('pickup');
    };

    const handleDecline = () => {
        setShowRequest(false);
    };

    const renderActiveTripControls = () => {
        if (!activeTrip) return null;

        return (
            <View style={styles.tripCard}>
                <View style={styles.tripHeader}>
                    <View style={styles.tripIndicator} />
                    <Text style={styles.tripStatus}>
                        {activeTrip === 'pickup' && 'ALLER AU POINT DE COLLECTE'}
                        {activeTrip === 'on_site' && 'ARRIVÉ SUR PLACE'}
                        {activeTrip === 'otp' && 'VALIDATION OTP'}
                        {activeTrip === 'destination' && 'LIVRAISON EN COURS'}
                    </Text>
                </View>

                <View style={styles.tripDetails}>
                    <Text style={styles.tripAddress}>
                        {activeTrip === 'pickup' ? 'Point Market Akwaba' : 'Riviera 3, Rue des Jardins'}
                    </Text>
                    <Text style={styles.tripClient}>Client: Moussa K.</Text>
                </View>

                <TouchableOpacity
                    style={styles.tripActionButton}
                    onPress={() => {
                        if (activeTrip === 'pickup') setActiveTrip('on_site');
                        else if (activeTrip === 'on_site') setActiveTrip('otp');
                        else if (activeTrip === 'otp') setActiveTrip('destination');
                        else if (activeTrip === 'destination') {
                            Alert.alert('Succès', 'Livraison terminée !');
                            setActiveTrip(null);
                        }
                    }}
                >
                    <Text style={styles.tripActionText}>
                        {activeTrip === 'pickup' && 'ARRIVÉ AU POINT'}
                        {activeTrip === 'on_site' && 'DÉMARRER LA MISSION'}
                        {activeTrip === 'otp' && 'VALIDER OTP'}
                        {activeTrip === 'destination' && 'TERMINER LA MISSION'}
                    </Text>
                </TouchableOpacity>
            </View>
        );
    };

    return (
        <View style={styles.container}>
            {/* Map plein écran */}
            <View style={styles.mapContainer}>
                <LeafletMap userLocation={userLocation} />
                <View style={styles.mapDarkOverlay} />
            </View>

            {/* Header flottant */}
            {!showRequest && (
                <SafeAreaView edges={['top']} style={styles.headerFloating}>
                    <View style={styles.headerRow}>
                        <TouchableOpacity style={styles.circleBtn} onPress={() => navigation.navigate('Profile')}>
                            <UserIcon size={24} color={Colors.white} />
                        </TouchableOpacity>

                        <TouchableOpacity style={styles.earningsPill} onPress={() => navigation.navigate('Earnings')}>
                            <Text style={styles.earningsValue}>0 FCFA</Text>
                            <ChevronRight size={16} color="rgba(255,255,255,0.4)" />
                        </TouchableOpacity>

                        <TouchableOpacity style={styles.circleBtn}>
                            <Search size={22} color={Colors.white} />
                        </TouchableOpacity>
                    </View>
                </SafeAreaView>
            )}

            {/* Zone Basse (Bouton En Ligne / Mission) */}
            <View style={styles.bottomArea}>
                {activeTrip ? (
                    renderActiveTripControls()
                ) : (
                    <TouchableOpacity
                        style={[
                            styles.goButton,
                            isOnline ? styles.goButtonOnline : styles.goButtonOffline
                        ]}
                        onPress={() => setIsOnline(!isOnline)}
                        activeOpacity={0.9}
                    >
                        <Text style={[
                            styles.goButtonText,
                            { color: isOnline ? Colors.white : Colors.secondary }
                        ]}>
                            {isOnline ? 'HORS LIGNE' : 'EN LIGNE'}
                        </Text>
                    </TouchableOpacity>
                )}
            </View>

            {/* Overlay de nouvelle mission */}
            <RequestOverlay
                visible={showRequest}
                onAccept={handleAccept}
                onDecline={handleDecline}
            />
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: Colors.background,
    },
    mapContainer: {
        flex: 1,
        ...StyleSheet.absoluteFillObject,
    },
    mapDarkOverlay: {
        ...StyleSheet.absoluteFillObject,
        backgroundColor: 'rgba(0,0,0,0.15)',
    },
    headerFloating: {
        position: 'absolute',
        top: 0,
        left: 0,
        right: 0,
        zIndex: 10,
    },
    headerRow: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        paddingHorizontal: 20,
        paddingTop: Platform.OS === 'ios' ? 0 : 20,
    },
    circleBtn: {
        width: 48,
        height: 48,
        borderRadius: 24,
        backgroundColor: 'rgba(0,0,0,0.8)',
        justifyContent: 'center',
        alignItems: 'center',
        borderWidth: 1,
        borderColor: '#1E1E1E',
    },
    earningsPill: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: 'black',
        paddingVertical: 10,
        paddingHorizontal: 24,
        borderRadius: 30,
        height: 48,
        borderWidth: 1,
        borderColor: '#1E1E1E',
    },
    earningsValue: {
        color: Colors.white,
        fontSize: 18,
        fontWeight: '900',
        marginRight: 4,
    },
    bottomArea: {
        position: 'absolute',
        bottom: 40,
        left: 0,
        right: 0,
        paddingHorizontal: 20,
        zIndex: 20,
    },
    goButton: {
        width: '100%',
        height: 80,
        borderRadius: 24,
        justifyContent: 'center',
        alignItems: 'center',
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 10 },
        shadowOpacity: 0.3,
        shadowRadius: 20,
        elevation: 10,
    },
    goButtonOffline: {
        backgroundColor: Colors.orange,
    },
    goButtonOnline: {
        backgroundColor: '#FF3B30', // Rouge pour "Arrêter" ou simple toggle
    },
    goButtonText: {
        fontSize: 24,
        fontWeight: '900',
        letterSpacing: 1,
    },
    tripCard: {
        backgroundColor: '#0F0F0F',
        width: '100%',
        padding: 24,
        borderRadius: 30,
        borderWidth: 1,
        borderColor: '#1E1E1E',
    },
    tripHeader: {
        flexDirection: 'row',
        alignItems: 'center',
        marginBottom: 12,
    },
    tripIndicator: {
        width: 10,
        height: 10,
        borderRadius: 5,
        backgroundColor: Colors.orange,
        marginRight: 10,
    },
    tripStatus: {
        fontSize: 12,
        fontWeight: '900',
        color: Colors.orange,
        letterSpacing: 1,
    },
    tripDetails: {
        marginBottom: 24,
    },
    tripAddress: {
        fontSize: 26,
        fontWeight: '900',
        color: Colors.white,
        marginBottom: 4,
    },
    tripClient: {
        fontSize: 14,
        color: Colors.textSecondary,
    },
    tripActionButton: {
        backgroundColor: Colors.orange,
        height: 64,
        borderRadius: 20,
        justifyContent: 'center',
        alignItems: 'center',
    },
    tripActionText: {
        color: Colors.white,
        fontSize: 18,
        fontWeight: '900',
        letterSpacing: 0.5,
    },
});
