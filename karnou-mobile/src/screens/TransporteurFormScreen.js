import React, { useState } from 'react';
import { StyleSheet, View, Text, SafeAreaView, ScrollView, TextInput, TouchableOpacity, Platform, ActivityIndicator, Dimensions } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { ArrowLeft, Truck, MapPin, Globe, User, Phone, Briefcase, Mail } from 'lucide-react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';

const { width } = Dimensions.get('window');

export default function TransporteurFormScreen({ navigation }) {
    const [formData, setFormData] = useState({
        prenom: '',
        nom: '',
        email: '',
        vehicleType: 'camion',
        transportType: 'urbain', // urbain, inter, international
        itineraire: '',
    });
    const [loading, setLoading] = useState(false);

    const API_URL = 'http://10.109.247.85:8001/api/profile/complete';

    const handleRegister = async () => {
        if (!formData.prenom || !formData.nom) {
            alert('Veuillez remplir votre nom et prénom');
            return;
        }

        setLoading(true);
        try {
            const token = await AsyncStorage.getItem('userToken');
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    user_type: 'transporteur',
                    prenom: formData.prenom,
                    nom: formData.nom,
                    email: formData.email,
                    vehicle_type: formData.vehicleType,
                    transport_type: formData.transportType,
                    itineraire: formData.itineraire,
                }),
            });

            const responseText = await response.text();
            let data;
            try {
                data = JSON.parse(responseText);
            } catch (err) {
                console.error('JSON Parse Error:', err, 'Response Text:', responseText);
                throw new Error('Le serveur a renvoyé une réponse invalide.');
            }

            if (data.success) {
                alert('Profil Transporteur enregistré !');
                navigation.navigate('Home');
            } else {
                alert(data.message || 'Erreur lors de l\'enregistrement');
            }
        } catch (error) {
            console.error('Transporteur Register Error:', error);
            alert('Erreur: ' + error.message);
        } finally {
            setLoading(false);
        }
    };

    return (
        <SafeAreaView style={styles.container}>
            <View style={styles.header}>
                <TouchableOpacity onPress={() => navigation.goBack()} style={styles.backButton}>
                    <ArrowLeft size={24} color={Colors.white} />
                </TouchableOpacity>
                <View style={styles.progressContainer}>
                    <View style={[styles.progressBar, { width: '100%', backgroundColor: Colors.primary }]} />
                </View>
            </View>

            <ScrollView style={styles.scrollView} showsVerticalScrollIndicator={false}>
                <View style={styles.content}>
                    <Text style={styles.title}>Devenez Transporteur</Text>
                    <Text style={styles.subtitle}>
                        Rejoignez le réseau logistique Karnou et gérez vos trajets de fret lourd.
                    </Text>

                    <View style={styles.section}>
                        <Text style={styles.sectionHeader}>Responsable</Text>
                        <View style={styles.card}>
                            <View style={styles.inputWrapper}>
                                <User size={18} color={Colors.textSecondary} style={styles.fieldIcon} />
                                <TextInput
                                    style={styles.fieldInput}
                                    placeholder="Prénom"
                                    placeholderTextColor="#475569"
                                    value={formData.prenom}
                                    onChangeText={(text) => setFormData({ ...formData, prenom: text })}
                                />
                            </View>
                            <View style={styles.divider} />
                            <View style={styles.inputWrapper}>
                                <User size={18} color={Colors.textSecondary} style={styles.fieldIcon} />
                                <TextInput
                                    style={styles.fieldInput}
                                    placeholder="Nom"
                                    placeholderTextColor="#475569"
                                    value={formData.nom}
                                    onChangeText={(text) => setFormData({ ...formData, nom: text })}
                                />
                            </View>
                            <View style={styles.divider} />
                            <View style={styles.inputWrapper}>
                                <Mail size={18} color={Colors.textSecondary} style={styles.fieldIcon} />
                                <TextInput
                                    style={styles.fieldInput}
                                    placeholder="Adresse Email pro"
                                    placeholderTextColor="#475569"
                                    keyboardType="email-address"
                                    value={formData.email}
                                    onChangeText={(text) => setFormData({ ...formData, email: text })}
                                />
                            </View>
                        </View>
                    </View>

                    <View style={styles.section}>
                        <Text style={styles.sectionHeader}>Flotte de Véhicules</Text>
                        <View style={styles.choiceRow}>
                            <TouchableOpacity
                                style={[styles.choiceItem, formData.vehicleType === 'vane' && styles.choiceItemActive]}
                                onPress={() => setFormData({ ...formData, vehicleType: 'vane' })}
                                activeOpacity={0.8}
                            >
                                <View style={[styles.choiceIconBox, formData.vehicleType === 'vane' && { backgroundColor: Colors.secondary }]}>
                                    <Truck size={24} color={formData.vehicleType === 'vane' ? Colors.primary : Colors.textSecondary} />
                                </View>
                                <Text style={[styles.choiceLabel, formData.vehicleType === 'vane' && styles.choiceLabelActive]}>Van</Text>
                            </TouchableOpacity>

                            <TouchableOpacity
                                style={[styles.choiceItem, formData.vehicleType === 'camion' && styles.choiceItemActive]}
                                onPress={() => setFormData({ ...formData, vehicleType: 'camion' })}
                                activeOpacity={0.8}
                            >
                                <View style={[styles.choiceIconBox, formData.vehicleType === 'camion' && { backgroundColor: Colors.secondary }]}>
                                    <Truck size={24} color={formData.vehicleType === 'camion' ? Colors.primary : Colors.textSecondary} />
                                </View>
                                <Text style={[styles.choiceLabel, formData.vehicleType === 'camion' && styles.choiceLabelActive]}>Camion</Text>
                            </TouchableOpacity>
                        </View>
                    </View>

                    <View style={styles.section}>
                        <Text style={styles.sectionHeader}>Portée Logistique</Text>
                        <View style={styles.transportList}>
                            {[
                                { id: 'urbain', label: 'Transport Urbain' },
                                { id: 'inter', label: 'Transport Inter-urbain' },
                                { id: 'international', label: 'Transport International' }
                            ].map((item) => (
                                <TouchableOpacity
                                    key={item.id}
                                    style={[styles.transportItem, formData.transportType === item.id && styles.transportItemActive]}
                                    onPress={() => setFormData({ ...formData, transportType: item.id })}
                                    activeOpacity={0.7}
                                >
                                    <View style={[styles.radio, formData.transportType === item.id && styles.radioActive]}>
                                        {formData.transportType === item.id && <View style={styles.radioInner} />}
                                    </View>
                                    <Text style={[styles.transportLabel, formData.transportType === item.id && styles.transportLabelActive]}>
                                        {item.label}
                                    </Text>
                                </TouchableOpacity>
                            ))}
                        </View>
                    </View>

                    <View style={styles.section}>
                        <Text style={styles.sectionHeader}>Itinéraires stratégiques</Text>
                        <View style={styles.card}>
                            <View style={styles.inputWrapper}>
                                <MapPin size={18} color={Colors.textSecondary} style={styles.fieldIcon} />
                                <TextInput
                                    style={styles.fieldInput}
                                    placeholder={formData.transportType === 'international' ? "Ex: Côte d'Ivoire - Mali" : "Ex: Abidjan - San Pedro"}
                                    placeholderTextColor="#475569"
                                    value={formData.itineraire}
                                    onChangeText={(text) => setFormData({ ...formData, itineraire: text })}
                                />
                            </View>
                        </View>
                    </View>

                    <View style={{ height: 40 }} />
                </View>
            </ScrollView>

            <View style={styles.footer}>
                <TouchableOpacity
                    style={[styles.submitButton, { opacity: loading ? 0.7 : 1 }]}
                    onPress={handleRegister}
                    disabled={loading}
                >
                    {loading ? (
                        <ActivityIndicator color={Colors.secondary} />
                    ) : (
                        <Text style={styles.submitButtonText}>Finaliser l'inscription</Text>
                    )}
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
    scrollView: {
        flex: 1,
    },
    content: {
        paddingHorizontal: Spacing.lg,
        paddingTop: 32,
    },
    title: {
        fontSize: 34,
        fontWeight: '900',
        color: Colors.white,
        marginBottom: 12,
        lineHeight: 40,
    },
    subtitle: {
        fontSize: 16,
        color: Colors.textSecondary,
        lineHeight: 24,
        marginBottom: 32,
    },
    section: {
        marginBottom: 32,
    },
    sectionHeader: {
        fontSize: 12,
        fontWeight: '900',
        color: Colors.primary,
        textTransform: 'uppercase',
        letterSpacing: 1.5,
        marginBottom: 16,
        marginLeft: 4,
    },
    card: {
        backgroundColor: Colors.surface,
        borderRadius: 24,
        overflow: 'hidden',
    },
    inputWrapper: {
        flexDirection: 'row',
        alignItems: 'center',
        paddingHorizontal: 20,
        height: 64,
    },
    fieldIcon: {
        marginRight: 12,
    },
    fieldInput: {
        flex: 1,
        fontSize: 16,
        fontWeight: '600',
        color: Colors.white,
    },
    divider: {
        height: 1,
        backgroundColor: '#262626',
        marginHorizontal: 20,
    },
    choiceRow: {
        flexDirection: 'row',
        gap: 12,
    },
    choiceItem: {
        flex: 1,
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: Colors.surface,
        padding: 16,
        borderRadius: 20,
        gap: 12,
    },
    choiceItemActive: {
        backgroundColor: Colors.primary,
    },
    choiceIconBox: {
        width: 44,
        height: 44,
        borderRadius: 12,
        backgroundColor: '#262626',
        justifyContent: 'center',
        alignItems: 'center',
    },
    choiceLabel: {
        fontSize: 16,
        fontWeight: 'bold',
        color: Colors.textSecondary,
    },
    choiceLabelActive: {
        color: Colors.secondary,
    },
    transportList: {
        gap: 12,
    },
    transportItem: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: Colors.surface,
        padding: 20,
        borderRadius: 24,
        gap: 16,
    },
    transportItemActive: {
        backgroundColor: '#1E1E1E',
        borderWidth: 1,
        borderColor: Colors.primary,
    },
    radio: {
        width: 24,
        height: 24,
        borderRadius: 12,
        borderWidth: 2,
        borderColor: '#334155',
        justifyContent: 'center',
        alignItems: 'center',
    },
    radioActive: {
        borderColor: Colors.primary,
    },
    radioInner: {
        width: 12,
        height: 12,
        borderRadius: 6,
        backgroundColor: Colors.primary,
    },
    transportLabel: {
        fontSize: 16,
        fontWeight: '700',
        color: Colors.textSecondary,
    },
    transportLabelActive: {
        color: Colors.white,
    },
    footer: {
        padding: Spacing.lg,
        paddingBottom: Platform.OS === 'ios' ? 40 : 30,
        backgroundColor: Colors.background,
    },
    submitButton: {
        backgroundColor: Colors.primary,
        height: 64,
        borderRadius: 16,
        justifyContent: 'center',
        alignItems: 'center',
    },
    submitButtonText: {
        color: Colors.secondary,
        fontSize: 18,
        fontWeight: '900',
        letterSpacing: 0.5,
    },
});
