import React, { useEffect } from 'react';
import { StyleSheet, View, Text, Animated, Dimensions } from 'react-native';
import { Colors } from '../constants/Theme';

const { width } = Dimensions.get('window');

export default function SplashScreen({ navigation }) {
    const fadeAnim = new Animated.Value(0);
    const scaleAnim = new Animated.Value(0.95);

    useEffect(() => {
        Animated.parallel([
            Animated.timing(fadeAnim, {
                toValue: 1,
                duration: 1000,
                useNativeDriver: true,
            }),
            Animated.spring(scaleAnim, {
                toValue: 1,
                friction: 4,
                useNativeDriver: true,
            })
        ]).start();

        const timer = setTimeout(() => {
            navigation.replace('Onboarding'); // On passe d'abord par l'onboarding pour les permissions
        }, 3000);

        return () => clearTimeout(timer);
    }, []);

    return (
        <View style={styles.container}>
            <Animated.View style={[
                styles.logoContainer,
                { opacity: fadeAnim, transform: [{ scale: scaleAnim }] }
            ]}>
                <Text style={styles.logoText}>KARNOU</Text>
                <View style={styles.proBadge}>
                    <Text style={styles.proBadgeText}>PRO</Text>
                </View>
                <Text style={styles.subText}>LOGISTIQUE</Text>
            </Animated.View>

            <View style={styles.footer}>
                <Text style={styles.footerText}>Partenaire Officiel Karnou</Text>
            </View>
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: Colors.background,
        justifyContent: 'center',
        alignItems: 'center',
    },
    logoContainer: {
        alignItems: 'center',
    },
    logoText: {
        fontSize: 56,
        fontWeight: '900',
        color: Colors.primary,
        letterSpacing: -1,
    },
    proBadge: {
        backgroundColor: Colors.primary,
        paddingHorizontal: 12,
        paddingVertical: 2,
        borderRadius: 4,
        marginTop: -10,
        marginBottom: 10,
    },
    proBadgeText: {
        color: Colors.secondary,
        fontSize: 14,
        fontWeight: '900',
    },
    subText: {
        fontSize: 12,
        fontWeight: '700',
        color: Colors.textSecondary,
        letterSpacing: 4,
        marginTop: 10,
    },
    footer: {
        position: 'absolute',
        bottom: 50,
    },
    footerText: {
        color: Colors.textSecondary,
        opacity: 0.6,
        fontSize: 13,
        fontWeight: '600',
    },
});
