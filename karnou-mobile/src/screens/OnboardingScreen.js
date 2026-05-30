import React, { useState } from 'react';
import { StyleSheet, View, Text, TouchableOpacity, SafeAreaView, ScrollView, Modal, Dimensions, Platform } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { MapPin, Phone, Bell, ChevronRight } from 'lucide-react-native';

const { width } = Dimensions.get('window');

export default function OnboardingScreen({ navigation }) {
    const [showPermissionModal, setShowPermissionModal] = useState(false);

    const permissions = [
        {
            id: 'pos',
            icon: <MapPin size={24} color={Colors.primary} />,
            title: 'Géolocalisation',
            desc: 'Navigation précise et calcul des trajets optimaux'
        },
        {
            id: 'tel',
            icon: <Phone size={24} color={Colors.primary} />,
            title: 'Téléphone',
            desc: 'Sécurisation de votre compte et contacts clients'
        },
        {
            id: 'notif',
            icon: <Bell size={24} color={Colors.primary} />,
            title: 'Notifications Flash',
            desc: 'Réception instantanée des nouvelles missions'
        },
    ];

    const PermissionModal = () => (
        <Modal
            transparent={true}
            visible={showPermissionModal}
            animationType="slide"
        >
            <View style={styles.modalOverlay}>
                <View style={styles.modalContent}>
                    <View style={styles.modalHeader}>
                        <View style={styles.yellowPinContainer}>
                            <MapPin size={32} color={Colors.secondary} />
                        </View>
                        <Text style={styles.modalTitle}>
                            Autoriser <Text style={{ color: Colors.primary, fontWeight: '900' }}>Karnou Pro</Text> à accéder à votre position ?
                        </Text>
                    </View>

                    <View style={styles.mapPreviewRow}>
                        <View style={styles.mapItem}>
                            <View style={[styles.mapCircle, styles.mapExact]}>
                                <View style={styles.mapDotBig} />
                                <View style={styles.mapDotRing} />
                            </View>
                            <Text style={styles.mapLabel}>Précise</Text>
                        </View>
                        <View style={styles.mapItem}>
                            <View style={[styles.mapCircle, styles.mapApprox]}>
                                <View style={styles.mapGrid} />
                                <View style={styles.mapDotApprox} />
                            </View>
                            <Text style={styles.mapLabel}>Vague</Text>
                        </View>
                    </View>

                    <View style={styles.modalOptions}>
                        <TouchableOpacity
                            style={styles.modalPrimaryOption}
                            onPress={() => {
                                setShowPermissionModal(false);
                                navigation.navigate('PhoneLogin');
                            }}
                        >
                            <Text style={styles.modalPrimaryText}>Pendant l'utilisation</Text>
                        </TouchableOpacity>

                        <TouchableOpacity
                            style={styles.modalSecondaryOption}
                            onPress={() => setShowPermissionModal(false)}
                        >
                            <Text style={styles.modalSecondaryText}>Une seule fois</Text>
                        </TouchableOpacity>

                        <TouchableOpacity
                            style={styles.modalSecondaryOption}
                            onPress={() => setShowPermissionModal(false)}
                        >
                            <Text style={styles.modalSecondaryText}>Refuser</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            </View>
        </Modal>
    );

    return (
        <SafeAreaView style={styles.container}>
            <PermissionModal />
            <ScrollView contentContainerStyle={styles.content} showsVerticalScrollIndicator={false}>
                <Text style={styles.headerTitle}>Accès aux services</Text>
                <Text style={styles.headerSubtitle}>
                    Pour une expérience professionnelle fluide, Karnou Pro nécessite l'accès aux fonctionnalités suivantes.
                </Text>

                <View style={styles.list}>
                    {permissions.map((p) => (
                        <View key={p.id} style={styles.item}>
                            <View style={styles.iconBox}>{p.icon}</View>
                            <View style={styles.textBox}>
                                <Text style={styles.itemTitle}>{p.title}</Text>
                                <Text style={styles.itemDesc}>{p.desc}</Text>
                            </View>
                        </View>
                    ))}
                </View>
            </ScrollView>

            <View style={styles.footer}>
                <TouchableOpacity
                    style={styles.button}
                    onPress={() => setShowPermissionModal(true)}
                    activeOpacity={0.8}
                >
                    <Text style={styles.buttonText}>Continuer</Text>
                    <ChevronRight size={20} color={Colors.secondary} />
                </TouchableOpacity>
            </View>
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: Colors.background,
    },
    content: {
        padding: 30,
        paddingTop: 40,
    },
    headerTitle: {
        fontSize: 34,
        fontWeight: '900',
        color: Colors.white,
        marginBottom: 16,
    },
    headerSubtitle: {
        fontSize: 16,
        color: Colors.textSecondary,
        lineHeight: 24,
        marginBottom: 48,
    },
    list: {
        marginTop: 10,
    },
    item: {
        flexDirection: 'row',
        marginBottom: 40,
        alignItems: 'flex-start',
    },
    iconBox: {
        width: 48,
        height: 48,
        borderRadius: 12,
        backgroundColor: Colors.surface,
        justifyContent: 'center',
        alignItems: 'center',
        marginRight: 20,
    },
    textBox: {
        flex: 1,
    },
    itemTitle: {
        fontSize: 18,
        fontWeight: '800',
        color: Colors.white,
    },
    itemDesc: {
        fontSize: 14,
        color: Colors.textSecondary,
        marginTop: 4,
        lineHeight: 20,
    },
    footer: {
        padding: 24,
        paddingBottom: Platform.OS === 'ios' ? 40 : 30,
    },
    button: {
        backgroundColor: Colors.primary,
        height: 64,
        borderRadius: 16,
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        gap: 8,
    },
    buttonText: {
        color: Colors.secondary,
        fontSize: 18,
        fontWeight: '900',
    },
    modalOverlay: {
        flex: 1,
        backgroundColor: 'rgba(0,0,0,0.85)',
        justifyContent: 'flex-end',
    },
    modalContent: {
        backgroundColor: '#121212',
        width: '100%',
        borderTopLeftRadius: 32,
        borderTopRightRadius: 32,
        padding: 32,
        alignItems: 'center',
    },
    modalHeader: {
        alignItems: 'center',
        marginBottom: 32,
    },
    yellowPinContainer: {
        width: 64,
        height: 64,
        borderRadius: 32,
        backgroundColor: Colors.primary,
        justifyContent: 'center',
        alignItems: 'center',
        marginBottom: 20,
    },
    modalTitle: {
        fontSize: 20,
        textAlign: 'center',
        color: Colors.white,
        fontWeight: '700',
        lineHeight: 28,
        paddingHorizontal: 10,
    },
    mapPreviewRow: {
        flexDirection: 'row',
        justifyContent: 'center',
        gap: 30,
        width: '100%',
        marginBottom: 40,
    },
    mapItem: {
        alignItems: 'center',
    },
    mapCircle: {
        width: 100,
        height: 100,
        borderRadius: 50,
        backgroundColor: '#1E1E1E',
        borderWidth: 2,
        borderColor: '#262626',
        marginBottom: 12,
        justifyContent: 'center',
        alignItems: 'center',
    },
    mapExact: {
        borderColor: Colors.primary,
        backgroundColor: '#1E1E1B',
    },
    mapLabel: {
        fontSize: 14,
        fontWeight: '800',
        color: Colors.textSecondary,
    },
    mapDotBig: {
        width: 20,
        height: 20,
        borderRadius: 10,
        backgroundColor: Colors.primary,
        zIndex: 2,
    },
    mapDotRing: {
        position: 'absolute',
        width: 40,
        height: 40,
        borderRadius: 20,
        backgroundColor: 'rgba(252, 224, 0, 0.15)',
    },
    mapGrid: {
        position: 'absolute',
        width: '200%',
        height: '200%',
        borderWidth: 0.5,
        borderColor: '#262626',
        transform: [{ rotate: '45deg' }],
    },
    mapDotApprox: {
        width: 16,
        height: 16,
        borderRadius: 8,
        backgroundColor: '#334155',
    },
    modalOptions: {
        width: '100%',
        gap: 8,
    },
    modalPrimaryOption: {
        width: '100%',
        height: 60,
        backgroundColor: Colors.primary,
        borderRadius: 16,
        justifyContent: 'center',
        alignItems: 'center',
        marginBottom: 8,
    },
    modalPrimaryText: {
        fontSize: 18,
        fontWeight: '900',
        color: Colors.secondary,
    },
    modalSecondaryOption: {
        width: '100%',
        height: 56,
        justifyContent: 'center',
        alignItems: 'center',
    },
    modalSecondaryText: {
        fontSize: 16,
        fontWeight: '700',
        color: Colors.textSecondary,
    },
});
