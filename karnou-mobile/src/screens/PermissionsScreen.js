import React, { useState } from 'react';
import { StyleSheet, View, Text, SafeAreaView, TouchableOpacity, Image, Modal, Dimensions, Platform } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { MapPin, Phone, Bell, Check, ArrowLeft } from 'lucide-react-native';
import * as Location from 'expo-location';

const { width, height } = Dimensions.get('window');

export default function PermissionsScreen({ navigation }) {
    const [activeModal, setActiveModal] = useState('none'); // 'none', 'location', 'phone', 'notifications'
    const [locationType, setLocationType] = useState('exact');

    const handleContinue = () => {
        setActiveModal('location');
    };

    const requestLocation = async () => {
        try {
            await Location.requestForegroundPermissionsAsync();
        } catch (e) {
            console.log('Location permission error:', e);
        }
        nextStep();
    };

    const requestNotifications = async () => {
        // Mock pour Expo Go car expo-notifications crash depuis SDK 53
        console.log('Notifications request simulated for Expo Go');
        nextStep();
    };

    const nextStep = () => {
        if (activeModal === 'location') setActiveModal('phone');
        else if (activeModal === 'phone') setActiveModal('notifications');
        else {
            setActiveModal('none');
            navigation.navigate('UserTypeSelection');
        }
    };

    return (
        <SafeAreaView style={styles.container}>
            <View style={styles.header}>
                <TouchableOpacity onPress={() => navigation.goBack()} style={styles.backButton}>
                    <ArrowLeft size={24} color={Colors.white} />
                </TouchableOpacity>
                <View style={styles.progressContainer}>
                    <View style={[styles.progressBar, { width: '40%', backgroundColor: Colors.primary }]} />
                </View>
            </View>

            <View style={styles.content}>
                <Text style={styles.title}>Autorisations</Text>
                <Text style={styles.subtitle}>
                    Karnou a besoin d'accès essentiels pour assurer votre sécurité et le suivi de vos missions.
                </Text>

                <View style={styles.permissionList}>
                    {/* Position */}
                    <TouchableOpacity
                        style={[styles.permissionItem, activeModal === 'location' && styles.dimmed]}
                        onPress={() => setActiveModal('location')}
                    >
                        <View style={[styles.iconCircle, { backgroundColor: '#262626' }]}>
                            <MapPin size={24} color={Colors.primary} strokeWidth={2.5} />
                        </View>
                        <View style={styles.permissionTextContainer}>
                            <Text style={styles.permissionTitle}>Position GPS</Text>
                            <Text style={styles.permissionDesc}>Navigation et calcul automatique des trajets</Text>
                        </View>
                    </TouchableOpacity>

                    {/* Téléphone */}
                    <TouchableOpacity
                        style={[styles.permissionItem, activeModal === 'phone' && styles.dimmed]}
                        onPress={() => setActiveModal('phone')}
                    >
                        <View style={[styles.iconCircle, { backgroundColor: '#262626' }]}>
                            <Phone size={24} color={Colors.white} strokeWidth={2.5} />
                        </View>
                        <View style={styles.permissionTextContainer}>
                            <Text style={styles.permissionTitle}>Appels</Text>
                            <Text style={styles.permissionDesc}>Contacter les clients en un clic</Text>
                        </View>
                    </TouchableOpacity>

                    {/* Notifications */}
                    <TouchableOpacity
                        style={[styles.permissionItem, activeModal === 'notifications' && styles.dimmed]}
                        onPress={() => setActiveModal('notifications')}
                    >
                        <View style={[styles.iconCircle, { backgroundColor: '#262626' }]}>
                            <Bell size={24} color={Colors.primary} strokeWidth={2.5} />
                        </View>
                        <View style={styles.permissionTextContainer}>
                            <Text style={styles.permissionTitle}>Alertes</Text>
                            <Text style={styles.permissionDesc}>Nouvelles commandes Marketplace dispo</Text>
                        </View>
                    </TouchableOpacity>
                </View>
            </View>

            <View style={styles.footer}>
                <TouchableOpacity style={styles.button} onPress={handleContinue}>
                    <Text style={styles.buttonText}>Continuer</Text>
                </TouchableOpacity>
            </View>

            {/* Step 1: Location Permission Popup */}
            <Modal transparent={true} visible={activeModal === 'location'} animationType="slide">
                <View style={styles.modalOverlay}>
                    <View style={styles.modalContent}>
                        <View style={styles.modalHeader}>
                            <View style={styles.yellowCircle}>
                                <MapPin size={30} color={Colors.secondary} />
                            </View>
                            <Text style={styles.modalTitle}>Autoriser Karnou Marketplace à accéder à la position de cet appareil ?</Text>
                        </View>

                        <View style={styles.locationSelector}>
                            <TouchableOpacity style={styles.locationOption} onPress={() => setLocationType('exact')}>
                                <View style={[styles.mapCircle, locationType === 'exact' && styles.activeMapCircle]}>
                                    <View style={styles.mapGraphicExact}>
                                        <View style={styles.yellowDot} />
                                        <View style={[styles.mapLine, { top: 20, width: '80%' }]} />
                                        <View style={[styles.mapLine, { top: 40, width: '60%' }]} />
                                    </View>
                                </View>
                                <Text style={[styles.locationOptionText, locationType === 'exact' && styles.activeOptionText]}>Exacte</Text>
                            </TouchableOpacity>

                            <TouchableOpacity style={styles.locationOption} onPress={() => setLocationType('approximate')}>
                                <View style={[styles.mapCircle, locationType === 'approximate' && styles.activeMapCircle]}>
                                    <View style={styles.mapGraphicApprox}>
                                        <View style={styles.approxCircle} />
                                        <View style={[styles.mapLine, { top: 15, width: '40%' }]} />
                                        <View style={[styles.mapLine, { top: 45, width: '70%' }]} />
                                    </View>
                                </View>
                                <Text style={[styles.locationOptionText, locationType === 'approximate' && styles.activeOptionText]}>Approximative</Text>
                            </TouchableOpacity>
                        </View>

                        <View style={styles.modalActions}>
                            <TouchableOpacity style={styles.modalActionBtn} onPress={requestLocation}>
                                <Text style={styles.modalActionText}>Lorsque vous utilisez l'appli</Text>
                            </TouchableOpacity>
                            <TouchableOpacity style={styles.modalActionBtn} onPress={requestLocation}>
                                <Text style={styles.modalActionText}>Uniquement cette fois-ci</Text>
                            </TouchableOpacity>
                            <TouchableOpacity style={styles.modalActionBtn} onPress={nextStep}>
                                <Text style={[styles.modalActionText, { color: Colors.textSecondary }]}>Ne pas autoriser</Text>
                            </TouchableOpacity>
                        </View>
                    </View>
                </View>
            </Modal>

            {/* Step 2: Phone Permission Popup */}
            <Modal transparent={true} visible={activeModal === 'phone'} animationType="fade">
                <View style={styles.modalOverlay}>
                    <View style={styles.modalContent}>
                        <View style={[styles.modalHeader, { marginBottom: 10 }]}>
                            <View style={[styles.yellowCircle, { backgroundColor: 'transparent', marginBottom: 5 }]}>
                                <Phone size={36} color={Colors.primary} />
                            </View>
                            <Text style={[styles.modalTitle, { fontSize: 16 }]}>
                                Autoriser <Text style={{ color: Colors.primary }}>Karnou</Text> à passer et gérer des appels ?
                            </Text>
                        </View>

                        <View style={[styles.modalActions, { borderTopWidth: 0 }]}>
                            <TouchableOpacity style={[styles.modalActionBtn, { backgroundColor: Colors.primary }]} onPress={nextStep}>
                                <Text style={[styles.modalActionText, { color: Colors.secondary }]}>Autoriser</Text>
                            </TouchableOpacity>
                            <TouchableOpacity style={styles.modalActionBtn} onPress={nextStep}>
                                <Text style={[styles.modalActionText, { color: Colors.textSecondary }]}>Ne pas autoriser</Text>
                            </TouchableOpacity>
                        </View>
                    </View>
                </View>
            </Modal>

            {/* Step 3: Notifications Simulation */}
            <Modal transparent={true} visible={activeModal === 'notifications'} animationType="fade">
                <View style={styles.modalOverlay}>
                    <View style={styles.modalContent}>
                        <View style={[styles.modalHeader, { marginBottom: 10 }]}>
                            <Bell size={36} color={Colors.primary} style={{ marginBottom: 10 }} />
                            <Text style={[styles.modalTitle, { fontSize: 16 }]}>
                                Autoriser <Text style={{ color: Colors.primary }}>Karnou</Text> à vous envoyer des notifications ?
                            </Text>
                        </View>

                        <View style={[styles.modalActions, { borderTopWidth: 0 }]}>
                            <TouchableOpacity style={[styles.modalActionBtn, { backgroundColor: Colors.primary }]} onPress={nextStep}>
                                <Text style={[styles.modalActionText, { color: Colors.secondary }]}>Autoriser</Text>
                            </TouchableOpacity>
                            <TouchableOpacity style={styles.modalActionBtn} onPress={nextStep}>
                                <Text style={[styles.modalActionText, { color: Colors.textSecondary }]}>Ne pas autoriser</Text>
                            </TouchableOpacity>
                        </View>
                    </View>
                </View>
            </Modal>
        </SafeAreaView >
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: Colors.background,
    },
    header: {
        paddingHorizontal: Spacing.lg,
        paddingTop: Spacing.md,
    },
    backButton: {
        width: 44,
        height: 44,
        justifyContent: 'center',
    },
    progressContainer: {
        height: 4,
        backgroundColor: '#262626',
        borderRadius: 2,
        marginTop: 10,
        overflow: 'hidden',
    },
    progressBar: {
        height: '100%',
    },
    content: {
        flex: 1,
        paddingHorizontal: Spacing.lg,
        paddingTop: 60,
    },
    title: {
        fontSize: 34,
        fontWeight: '900',
        color: Colors.white,
        marginBottom: 16,
        lineHeight: 40,
    },
    subtitle: {
        fontSize: 16,
        color: Colors.textSecondary,
        lineHeight: 24,
        marginBottom: 48,
    },
    permissionList: {
        gap: 16,
    },
    permissionItem: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: Colors.surface,
        padding: 20,
        borderRadius: 20,
    },
    dimmed: {
        opacity: 0.5,
    },
    iconCircle: {
        width: 56,
        height: 56,
        borderRadius: 16,
        justifyContent: 'center',
        alignItems: 'center',
        marginRight: 20,
    },
    permissionTextContainer: {
        flex: 1,
    },
    permissionTitle: {
        fontSize: 18,
        fontWeight: '900',
        color: Colors.white,
        marginBottom: 4,
    },
    permissionDesc: {
        fontSize: 14,
        color: Colors.textSecondary,
        lineHeight: 18,
    },
    footer: {
        padding: Spacing.lg,
        paddingBottom: Platform.OS === 'ios' ? 40 : 30,
    },
    button: {
        backgroundColor: Colors.primary,
        height: 64,
        borderRadius: 16,
        justifyContent: 'center',
        alignItems: 'center',
    },
    buttonText: {
        color: Colors.secondary,
        fontSize: 18,
        fontWeight: '900',
        letterSpacing: 0.5,
    },

    // Modal Styles
    modalOverlay: {
        flex: 1,
        backgroundColor: 'rgba(0,0,0,0.8)',
        justifyContent: 'center',
        alignItems: 'center',
    },
    modalContent: {
        width: width * 0.9,
        backgroundColor: Colors.surface,
        borderRadius: 32,
        padding: 32,
        alignItems: 'center',
    },
    modalHeader: {
        alignItems: 'center',
        marginBottom: 24,
    },
    yellowCircle: {
        width: 80,
        height: 80,
        borderRadius: 40,
        backgroundColor: Colors.primary,
        justifyContent: 'center',
        alignItems: 'center',
        marginBottom: 20,
    },
    modalTitle: {
        fontSize: 18,
        fontWeight: '700',
        color: Colors.white,
        textAlign: 'center',
        lineHeight: 26,
    },
    locationSelector: {
        flexDirection: 'row',
        justifyContent: 'space-around',
        width: '100%',
        marginBottom: 32,
    },
    locationOption: {
        alignItems: 'center',
    },
    mapCircle: {
        width: 100,
        height: 100,
        borderRadius: 50,
        borderWidth: 2,
        borderColor: '#262626',
        backgroundColor: '#1E1E1E',
        justifyContent: 'center',
        alignItems: 'center',
        marginBottom: 12,
        overflow: 'hidden',
    },
    activeMapCircle: {
        borderColor: Colors.primary,
    },
    locationOptionText: {
        fontSize: 14,
        fontWeight: 'bold',
        color: Colors.textSecondary,
    },
    activeOptionText: {
        color: Colors.primary,
    },
    mapGraphicExact: {
        width: '100%',
        height: '100%',
        padding: 10,
    },
    mapGraphicApprox: {
        width: '100%',
        height: '100%',
        padding: 10,
    },
    yellowDot: {
        width: 14,
        height: 14,
        borderRadius: 7,
        backgroundColor: Colors.primary,
        position: 'absolute',
        top: '40%',
        left: '45%',
        zIndex: 10,
    },
    approxCircle: {
        width: 48,
        height: 48,
        borderRadius: 24,
        borderWidth: 2,
        borderColor: Colors.primary,
        borderStyle: 'dashed',
        position: 'absolute',
        top: '25%',
        left: '25%',
        backgroundColor: 'rgba(252, 224, 0, 0.1)',
    },
    mapLine: {
        height: 2,
        backgroundColor: '#334155',
        position: 'absolute',
        left: 10,
    },
    modalActions: {
        width: '100%',
        gap: 12,
    },
    modalActionBtn: {
        paddingVertical: 18,
        borderRadius: 16,
        alignItems: 'center',
    },
    modalActionText: {
        fontSize: 16,
        fontWeight: '800',
        color: Colors.white,
    },
});
