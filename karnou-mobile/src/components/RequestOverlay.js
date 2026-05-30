import React, { useEffect, useState, useRef } from 'react';
import { StyleSheet, View, Text, TouchableOpacity, Animated, Dimensions } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { X, MapPin } from 'lucide-react-native';

const { width, height } = Dimensions.get('window');

export default function RequestOverlay({ visible, onAccept, onDecline }) {
    const [timeLeft, setTimeLeft] = useState(15);
    const slideAnim = useRef(new Animated.Value(height)).current;

    useEffect(() => {
        if (visible) {
            Animated.spring(slideAnim, {
                toValue: 0,
                tension: 50,
                friction: 10,
                useNativeDriver: true,
            }).start();

            const timer = setInterval(() => {
                setTimeLeft((prev) => (prev > 0 ? prev - 1 : 0));
            }, 1000);

            return () => clearInterval(timer);
        } else {
            Animated.timing(slideAnim, {
                toValue: height,
                duration: 300,
                useNativeDriver: true,
            }).start();
            setTimeLeft(15);
        }
    }, [visible]);

    // Déclenchement automatique de l'expiration
    useEffect(() => {
        if (visible && timeLeft === 0) {
            onDecline();
        }
    }, [timeLeft, visible]);

    if (!visible) {
        const currentVal = JSON.stringify(slideAnim);
        if (currentVal === height.toString()) return null;
    }

    return (
        <Animated.View style={[styles.container, { transform: [{ translateY: slideAnim }] }]}>
            {/* Top Controls */}
            <TouchableOpacity style={styles.closeButton} onPress={onDecline}>
                <X size={24} color="rgba(255,255,255,0.6)" />
            </TouchableOpacity>

            <View style={styles.content}>
                {/* Header Section */}
                <View style={styles.header}>
                    <Text style={styles.title}>Nouvelle Commande</Text>
                    <View style={styles.pointsBadge}>
                        <Text style={styles.pointsText}>+2 POINTS D'ACTIVITÉ</Text>
                    </View>
                </View>

                {/* Fare Section */}
                <View style={styles.fareContainer}>
                    <Text style={styles.fareText}>1 500 <Text style={styles.currency}>CFA</Text></Text>
                </View>

                {/* Routes Section */}
                <View style={styles.routeContainer}>
                    <View style={styles.routeLine} />
                    <View style={styles.stop}>
                        <View style={[styles.dot, { backgroundColor: '#000' }]} />
                        <Text style={styles.addressLabel}>RAMASSAGE</Text>
                        <Text style={styles.address}>Point de Collecte Akwaba</Text>
                    </View>
                    <View style={[styles.stop, { marginTop: 32 }]}>
                        <View style={[styles.dot, { backgroundColor: '#FFF' }]} />
                        <Text style={styles.addressLabel}>DESTINATION</Text>
                        <Text style={styles.address}>Riviera III - Rue des Jardins</Text>
                    </View>
                </View>

                {/* Accept Button / Timer Area */}
                <View style={styles.actionArea}>
                    <TouchableOpacity
                        style={styles.acceptButton}
                        onPress={onAccept}
                        activeOpacity={0.8}
                    >
                        <View style={styles.timerCircle}>
                            <Text style={styles.timerText}>{timeLeft}</Text>
                        </View>
                        <Text style={styles.acceptText}>ACCEPTER</Text>
                    </TouchableOpacity>
                </View>
            </View>
        </Animated.View>
    );
}

const styles = StyleSheet.create({
    container: {
        ...StyleSheet.absoluteFillObject,
        backgroundColor: Colors.primary,
        zIndex: 100,
        paddingTop: 60,
        paddingHorizontal: 24,
    },
    closeButton: {
        width: 48,
        height: 48,
        backgroundColor: 'rgba(0,0,0,0.1)',
        borderRadius: Radius.pill,
        justifyContent: 'center',
        alignItems: 'center',
    },
    content: {
        flex: 1,
        marginTop: 20,
    },
    header: {
        alignItems: 'center',
        marginBottom: 20,
    },
    title: {
        color: Colors.white,
        fontSize: 28,
        fontWeight: '900',
        letterSpacing: -1,
    },
    pointsBadge: {
        marginTop: 8,
        backgroundColor: 'rgba(0,0,0,0.1)',
        paddingHorizontal: 12,
        paddingVertical: 4,
        borderRadius: 8,
    },
    pointsText: {
        color: Colors.white,
        fontSize: 10,
        fontWeight: '900',
        letterSpacing: 1,
    },
    fareContainer: {
        alignItems: 'center',
        marginVertical: 40,
    },
    fareText: {
        color: Colors.white,
        fontSize: 64,
        fontWeight: '900',
        tracking: -2,
    },
    currency: {
        fontSize: 24,
        opacity: 0.6,
    },
    routeContainer: {
        paddingLeft: 40,
        marginVertical: 20,
        position: 'relative',
    },
    routeLine: {
        position: 'absolute',
        left: 11,
        top: 10,
        bottom: 10,
        width: 2,
        backgroundColor: 'rgba(255,255,255,0.1)',
    },
    stop: {
        position: 'relative',
    },
    dot: {
        position: 'absolute',
        left: -38,
        top: 4,
        width: 18,
        height: 18,
        borderRadius: 4,
        borderWidth: 3,
        borderColor: Colors.primary,
    },
    addressLabel: {
        color: 'rgba(255,255,255,0.4)',
        fontSize: 10,
        fontWeight: '900',
        letterSpacing: 1,
        marginBottom: 2,
    },
    address: {
        color: Colors.white,
        fontSize: 20,
        fontWeight: '900',
    },
    actionArea: {
        position: 'absolute',
        bottom: 40,
        left: 0,
        right: 0,
        alignItems: 'center',
    },
    acceptButton: {
        width: '100%',
        height: 90,
        backgroundColor: Colors.white,
        borderRadius: Radius.card,
        flexDirection: 'row',
        alignItems: 'center',
        justifyContent: 'center',
        paddingHorizontal: 30,
    },
    timerCircle: {
        width: 50,
        height: 50,
        borderRadius: 25,
        borderWidth: 4,
        borderColor: '#F0F0F0',
        justifyContent: 'center',
        alignItems: 'center',
        marginRight: 20,
    },
    timerText: {
        color: Colors.text,
        fontSize: 18,
        fontWeight: '900',
    },
    acceptText: {
        color: Colors.text,
        fontSize: 24,
        fontWeight: '900',
        letterSpacing: 1,
    },
});
