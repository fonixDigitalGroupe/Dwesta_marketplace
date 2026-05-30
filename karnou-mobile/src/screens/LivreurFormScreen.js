import React, { useState } from 'react';
import { StyleSheet, View, Text, SafeAreaView, ScrollView, TextInput, TouchableOpacity, Platform, ActivityIndicator, Dimensions } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { ArrowLeft, User, Mail, Calendar, Bike, Car, FileText, Camera } from 'lucide-react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';

const { width } = Dimensions.get('window');

export default function LivreurFormScreen({ navigation }) {
    const [formData, setFormData] = useState({
        prenom: '',
        nom: '',
        email: '',
        dob: '',
        vehicleType: 'moto',
        docType: 'cni',
        docNumber: '',
    });
    const [loading, setLoading] = useState(false);

    const API_URL = 'http://10.109.247.85:8001/api/profile/complete';

    const handleRegister = async () => {
        if (!formData.prenom || !formData.nom || !formData.email) {
            alert('Veuillez remplir les champs obligatoires');
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
                    user_type: 'livreur',
                    prenom: formData.prenom,
                    nom: formData.nom,
                    email: formData.email,
                    dob: formData.dob,
                    vehicle_type: formData.vehicleType,
                    doc_type: formData.docType,
                    doc_number: formData.docNumber,
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
                alert('Félicitations ! Votre profil est en cours de vérification.');
                navigation.navigate('Home');
            } else {
                alert(data.message || 'Une erreur est survenue');
            }
        } catch (error) {
            console.error('Register Error:', error);
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
                    <Text style={styles.title}>Finalisez votre profil</Text>
                    <Text style={styles.subtitle}>
                        Dernière étape avant de commencer vos premières livraisons sur Karnou.
                    </Text>

                    <View style={styles.section}>
                        <Text style={styles.sectionHeader}>Identité</Text>
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
                                    placeholder="Adresse Email"
                                    placeholderTextColor="#475569"
                                    keyboardType="email-address"
                                    value={formData.email}
                                    onChangeText={(text) => setFormData({ ...formData, email: text })}
                                />
                            </View>
                        </View>
                    </View>

                    <View style={styles.section}>
                        <Text style={styles.sectionHeader}>Type de véhicule</Text>
                        <View style={styles.choiceRow}>
                            <TouchableOpacity
                                style={[styles.choiceItem, formData.vehicleType === 'moto' && styles.choiceItemActive]}
                                onPress={() => setFormData({ ...formData, vehicleType: 'moto' })}
                                activeOpacity={0.8}
                            >
                                <View style={[styles.choiceIconBox, formData.vehicleType === 'moto' && { backgroundColor: Colors.secondary }]}>
                                    <Bike size={24} color={formData.vehicleType === 'moto' ? Colors.primary : Colors.textSecondary} />
                                </View>
                                <Text style={[styles.choiceLabel, formData.vehicleType === 'moto' && styles.choiceLabelActive]}>Moto</Text>
                            </TouchableOpacity>

                            <TouchableOpacity
                                style={[styles.choiceItem, formData.vehicleType === 'voiture' && styles.choiceItemActive]}
                                onPress={() => setFormData({ ...formData, vehicleType: 'voiture' })}
                                activeOpacity={0.8}
                            >
                                <View style={[styles.choiceIconBox, formData.vehicleType === 'voiture' && { backgroundColor: Colors.secondary }]}>
                                    <Car size={24} color={formData.vehicleType === 'voiture' ? Colors.primary : Colors.textSecondary} />
                                </View>
                                <Text style={[styles.choiceLabel, formData.vehicleType === 'voiture' && styles.choiceLabelActive]}>Voiture</Text>
                            </TouchableOpacity>
                        </View>
                    </View>

                    <View style={styles.section}>
                        <Text style={styles.sectionHeader}>Pièce d'identité</Text>
                        <View style={styles.card}>
                            <View style={styles.inputWrapper}>
                                <FileText size={18} color={Colors.textSecondary} style={styles.fieldIcon} />
                                <TextInput
                                    style={styles.fieldInput}
                                    placeholder="Numéro CNI / Passeport"
                                    placeholderTextColor="#475569"
                                    value={formData.docNumber}
                                    onChangeText={(text) => setFormData({ ...formData, docNumber: text })}
                                />
                            </View>
                        </View>

                        <TouchableOpacity style={styles.uploadCard} activeOpacity={0.7}>
                            <View style={styles.uploadIconCircle}>
                                <Camera size={24} color={Colors.secondary} />
                            </View>
                            <View>
                                <Text style={styles.uploadTitle}>Photo du document</Text>
                                <Text style={styles.uploadSubtitle}>Recto / Verso obligatoire</Text>
                            </View>
                        </TouchableOpacity>
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
    uploadCard: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: '#1E1E1E',
        padding: 20,
        borderRadius: 24,
        marginTop: 16,
        borderWidth: 1,
        borderStyle: 'dashed',
        borderColor: '#334155',
        gap: 16,
    },
    uploadIconCircle: {
        width: 56,
        height: 56,
        borderRadius: 28,
        backgroundColor: Colors.primary,
        justifyContent: 'center',
        alignItems: 'center',
    },
    uploadTitle: {
        fontSize: 17,
        fontWeight: '800',
        color: Colors.white,
    },
    uploadSubtitle: {
        fontSize: 13,
        color: Colors.textSecondary,
        marginTop: 2,
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
