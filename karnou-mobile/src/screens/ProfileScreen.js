import React, { useEffect, useState, useCallback } from 'react';
import {
    StyleSheet, View, Text, TouchableOpacity, SafeAreaView,
    ScrollView, Platform, Alert, ActivityIndicator
} from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { Colors } from '../constants/Theme';
import {
    X, Settings, ChevronRight, Shield, Car, Bell,
    LogOut, Truck, Package, CheckCircle, Clock, AlertCircle
} from 'lucide-react-native';

const API_BASE = 'http://10.109.247.85:8001/api';

export default function ProfileScreen({ navigation }) {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    const fetchProfile = useCallback(async () => {
        try {
            const token = await AsyncStorage.getItem('userToken');
            if (!token) {
                navigation.replace('PhoneLogin');
                return;
            }
            const res = await fetch(`${API_BASE}/user`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();
            if (res.ok) {
                setUser(data);
            } else {
                // Token invalide
                await AsyncStorage.removeItem('userToken');
                navigation.replace('PhoneLogin');
            }
        } catch (e) {
            console.error('Fetch profile error:', e);
        } finally {
            setLoading(false);
        }
    }, [navigation]);

    useEffect(() => {
        fetchProfile();
    }, [fetchProfile]);

    const handleLogout = async () => {
        Alert.alert(
            'Déconnexion',
            'Voulez-vous vraiment vous déconnecter ?',
            [
                { text: 'Annuler', style: 'cancel' },
                {
                    text: 'Déconnecter', style: 'destructive',
                    onPress: async () => {
                        await AsyncStorage.removeItem('userToken');
                        navigation.replace('PhoneLogin');
                    }
                }
            ]
        );
    };

    if (loading) {
        return (
            <SafeAreaView style={styles.container}>
                <ActivityIndicator size="large" color={Colors.primary} style={{ flex: 1 }} />
            </SafeAreaView>
        );
    }

    // Determine user type and profile data
    const profile = user?.livreur || user?.transporteur;
    const isLivreur = !!user?.livreur;
    const fullName = [user?.prenom, user?.nom].filter(Boolean).join(' ') || 'Mon Profil';
    const avatarLetter = (user?.prenom || user?.nom || 'K')[0].toUpperCase();
    const roleLabel = isLivreur ? 'LIVREUR' : user?.transporteur ? 'TRANSPORTEUR' : 'PRO';

    // Vehicle info
    const vehicleType = profile?.type_vehicule || '—';
    const vehicleIconComp = isLivreur ? <Package size={20} color={Colors.primary} /> : <Truck size={20} color={Colors.primary} />;

    // KYC Status
    const kycStatus = profile?.statut_verification;
    const kycLabel = kycStatus === 'verifie' ? 'Vérifié ✓'
        : kycStatus === 'en_attente' ? 'En attente de vérification'
            : kycStatus === 'rejete' ? 'Rejeté - Action requise'
                : 'Non soumis';
    const kycColor = kycStatus === 'verifie' ? '#22C55E'
        : kycStatus === 'rejete' ? '#EF4444'
            : Colors.textSecondary;
    const kycIcon = kycStatus === 'verifie'
        ? <CheckCircle size={20} color="#22C55E" />
        : kycStatus === 'en_attente'
            ? <Clock size={20} color={Colors.orange} />
            : <Shield size={20} color={Colors.primary} />;

    // Member since
    const memberSince = user?.created_at
        ? new Date(user.created_at).toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' })
        : '—';

    const phone = user?.telephone || '—';

    return (
        <SafeAreaView style={styles.container}>
            {/* Header */}
            <View style={styles.header}>
                <TouchableOpacity onPress={() => navigation.goBack()} style={styles.circleBtn}>
                    <X size={24} color={Colors.white} />
                </TouchableOpacity>
                <TouchableOpacity style={styles.circleBtn}>
                    <Settings size={22} color={Colors.white} />
                </TouchableOpacity>
            </View>

            <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
                {/* Profile Header */}
                <View style={styles.profileHeader}>
                    <View style={styles.avatarLarge}>
                        <Text style={styles.avatarTextLarge}>{avatarLetter}</Text>
                        <View style={styles.proBadge}>
                            <Text style={styles.proBadgeText}>{roleLabel}</Text>
                        </View>
                    </View>
                    <Text style={styles.userName}>{fullName}</Text>
                    <Text style={styles.userId}>{phone}</Text>
                    <Text style={styles.memberSince}>Membre depuis {memberSince}</Text>
                </View>

                {/* Mon Compte Section */}
                <View style={styles.menuGroup}>
                    <Text style={styles.groupHeader}>MON COMPTE</Text>

                    {/* Documents & KYC */}
                    <TouchableOpacity style={styles.menuItem} activeOpacity={0.7}>
                        <View style={styles.menuIconBox}>{kycIcon}</View>
                        <View style={styles.menuTextContainer}>
                            <Text style={styles.menuLabel}>Documents & KYC</Text>
                            <Text style={[styles.menuSub, { color: kycColor }]}>{kycLabel}</Text>
                        </View>
                        <ChevronRight size={18} color="#334155" />
                    </TouchableOpacity>

                    {/* Mon Véhicule — only if profile exists */}
                    {profile && (
                        <TouchableOpacity style={styles.menuItem} activeOpacity={0.7}>
                            <View style={styles.menuIconBox}>{vehicleIconComp}</View>
                            <View style={styles.menuTextContainer}>
                                <Text style={styles.menuLabel}>Mon Véhicule</Text>
                                <Text style={styles.menuSub}>{vehicleType}</Text>
                            </View>
                            <ChevronRight size={18} color="#334155" />
                        </TouchableOpacity>
                    )}

                    {/* Notifications */}
                    <TouchableOpacity style={styles.menuItem} activeOpacity={0.7}>
                        <View style={styles.menuIconBox}>
                            <Bell size={20} color={Colors.primary} />
                        </View>
                        <View style={styles.menuTextContainer}>
                            <Text style={styles.menuLabel}>Notifications</Text>
                        </View>
                        <ChevronRight size={18} color="#334155" />
                    </TouchableOpacity>
                </View>

                {/* Zone d'Activité (si livreur ou transporteur) */}
                {profile && (
                    <View style={styles.menuGroup}>
                        <Text style={styles.groupHeader}>
                            {isLivreur ? 'MON ACTIVITÉ LIVREUR' : 'MON ACTIVITÉ TRANSPORTEUR'}
                        </Text>
                        <View style={styles.infoCard}>
                            <View style={styles.infoRow}>
                                <Text style={styles.infoLabel}>Type de véhicule</Text>
                                <Text style={styles.infoValue}>{vehicleType}</Text>
                            </View>
                            {isLivreur && user.livreur?.type_document && (
                                <View style={styles.infoRow}>
                                    <Text style={styles.infoLabel}>Document</Text>
                                    <Text style={styles.infoValue}>{user.livreur.type_document}</Text>
                                </View>
                            )}
                            <View style={[styles.infoRow, { borderBottomWidth: 0 }]}>
                                <Text style={styles.infoLabel}>Statut</Text>
                                <View style={[styles.statusPill, {
                                    backgroundColor: kycStatus === 'verifie' ? 'rgba(34,197,94,0.1)'
                                        : kycStatus === 'rejete' ? 'rgba(239,68,68,0.1)'
                                            : 'rgba(252,224,0,0.1)'
                                }]}>
                                    <Text style={[styles.statusText, { color: kycColor }]}>
                                        {kycStatus === 'verifie' ? 'Actif'
                                            : kycStatus === 'en_attente' ? 'En attente'
                                                : kycStatus === 'rejete' ? 'Rejeté'
                                                    : 'Non soumis'}
                                    </Text>
                                </View>
                            </View>
                        </View>
                    </View>
                )}

                {/* Logout */}
                <TouchableOpacity style={styles.logoutBtn} onPress={handleLogout}>
                    <LogOut size={20} color="#FF3B30" />
                    <Text style={styles.logoutText}>Se déconnecter</Text>
                </TouchableOpacity>

                <View style={{ height: 40 }} />
            </ScrollView>
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: Colors.background,
    },
    header: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        paddingHorizontal: 20,
        paddingTop: Platform.OS === 'ios' ? 0 : 20,
        height: 60,
        alignItems: 'center',
    },
    circleBtn: {
        width: 44,
        height: 44,
        borderRadius: 22,
        backgroundColor: Colors.surface,
        justifyContent: 'center',
        alignItems: 'center',
    },
    scrollContent: {
        paddingTop: 20,
    },
    profileHeader: {
        alignItems: 'center',
        marginBottom: 40,
        paddingHorizontal: 20,
    },
    avatarLarge: {
        width: 120,
        height: 120,
        borderRadius: 60,
        backgroundColor: '#1E1E1E',
        justifyContent: 'center',
        alignItems: 'center',
        marginBottom: 20,
        borderWidth: 1,
        borderColor: '#262626',
    },
    avatarTextLarge: {
        fontSize: 48,
        fontWeight: '900',
        color: Colors.primary,
    },
    proBadge: {
        position: 'absolute',
        bottom: -5,
        backgroundColor: Colors.orange,
        paddingHorizontal: 12,
        paddingVertical: 4,
        borderRadius: 10,
    },
    proBadgeText: {
        color: Colors.white,
        fontSize: 10,
        fontWeight: '900',
    },
    userName: {
        fontSize: 30,
        fontWeight: '900',
        color: Colors.white,
        textAlign: 'center',
    },
    userId: {
        fontSize: 15,
        color: Colors.orange,
        marginTop: 6,
        fontWeight: '600',
    },
    memberSince: {
        fontSize: 13,
        color: Colors.textSecondary,
        marginTop: 4,
    },
    menuGroup: {
        paddingHorizontal: 20,
        marginBottom: 30,
    },
    groupHeader: {
        fontSize: 12,
        fontWeight: '900',
        color: Colors.textSecondary,
        letterSpacing: 1.5,
        marginBottom: 16,
        marginLeft: 4,
    },
    menuItem: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: Colors.surface,
        paddingHorizontal: 20,
        paddingVertical: 20,
        borderRadius: 20,
        marginBottom: 12,
    },
    menuIconBox: {
        width: 40,
        height: 40,
        borderRadius: 12,
        backgroundColor: '#1E1E1E',
        justifyContent: 'center',
        alignItems: 'center',
        marginRight: 16,
    },
    menuTextContainer: {
        flex: 1,
    },
    menuLabel: {
        fontSize: 17,
        fontWeight: '700',
        color: Colors.white,
    },
    menuSub: {
        fontSize: 13,
        color: Colors.textSecondary,
        marginTop: 2,
    },
    infoCard: {
        backgroundColor: Colors.surface,
        borderRadius: 20,
        paddingHorizontal: 20,
        paddingTop: 8,
    },
    infoRow: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        paddingVertical: 16,
        borderBottomWidth: 1,
        borderBottomColor: '#1E1E1E',
    },
    infoLabel: {
        fontSize: 14,
        color: Colors.textSecondary,
    },
    infoValue: {
        fontSize: 14,
        fontWeight: '700',
        color: Colors.white,
        textTransform: 'capitalize',
    },
    statusPill: {
        paddingHorizontal: 12,
        paddingVertical: 4,
        borderRadius: 20,
    },
    statusText: {
        fontSize: 12,
        fontWeight: '800',
    },
    logoutBtn: {
        flexDirection: 'row',
        alignItems: 'center',
        justifyContent: 'center',
        padding: 20,
        marginTop: 10,
        gap: 10,
    },
    logoutText: {
        fontSize: 16,
        fontWeight: '800',
        color: '#FF3B30',
    },
});
