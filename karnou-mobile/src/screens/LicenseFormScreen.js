import React from 'react';
import { StyleSheet, View, Text, TouchableOpacity, SafeAreaView, TextInput, ScrollView, Platform } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { ArrowLeft, ChevronRight, Camera } from 'lucide-react-native';

export default function LicenseFormScreen({ navigation }) {
    return (
        <SafeAreaView style={styles.container}>
            <View style={styles.header}>
                <TouchableOpacity onPress={() => navigation.goBack()} style={styles.circleBtn}>
                    <ArrowLeft size={24} color={Colors.white} />
                </TouchableOpacity>
            </View>

            <ScrollView contentContainerStyle={styles.content} showsVerticalScrollIndicator={false}>
                <Text style={styles.title}>Détails du permis</Text>

                <View style={styles.card}>
                    <View style={styles.inputGroup}>
                        <Text style={styles.label}>PAYS ÉMETTEUR</Text>
                        <TouchableOpacity style={styles.selectField}>
                            <Text style={styles.selectText}>Côte d'Ivoire</Text>
                            <ChevronRight size={18} color={Colors.primary} />
                        </TouchableOpacity>
                    </View>

                    <View style={styles.inputGroup}>
                        <Text style={styles.label}>NOM COMPLET</Text>
                        <TextInput
                            style={styles.input}
                            placeholder="Entrez votre nom"
                            placeholderTextColor="rgba(255,255,255,0.2)"
                        />
                    </View>

                    <View style={styles.inputGroup}>
                        <Text style={styles.label}>NUMÉRO DU PERMIS</Text>
                        <TextInput
                            style={styles.input}
                            placeholder="0000-0000-0000"
                            placeholderTextColor="rgba(255,255,255,0.2)"
                        />
                    </View>

                    <View style={styles.inputGroup}>
                        <Text style={styles.label}>VALIDE JUSQU'AU</Text>
                        <TextInput
                            style={styles.input}
                            placeholder="JJ/MM/AAAA"
                            placeholderTextColor="rgba(255,255,255,0.2)"
                        />
                    </View>
                </View>

                {/* Photo Section */}
                <TouchableOpacity style={styles.photoBox}>
                    <Camera size={32} color={Colors.primary} />
                    <Text style={styles.photoText}>Photo du permis (Recto)</Text>
                </TouchableOpacity>
            </ScrollView>

            <View style={styles.footer}>
                <TouchableOpacity
                    style={styles.button}
                    onPress={() => navigation.navigate('Home')}
                    activeOpacity={0.8}
                >
                    <Text style={styles.buttonText}>Finaliser l'inscription</Text>
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
        paddingHorizontal: 20,
        paddingTop: Platform.OS === 'ios' ? 0 : 20,
        height: 60,
        justifyContent: 'center',
    },
    circleBtn: {
        width: 44,
        height: 44,
        borderRadius: 22,
        backgroundColor: Colors.surface,
        justifyContent: 'center',
        alignItems: 'center',
    },
    content: {
        paddingHorizontal: 20,
        paddingTop: 20,
        paddingBottom: 40,
    },
    title: {
        fontSize: 34,
        fontWeight: '900',
        color: Colors.white,
        marginBottom: 30,
    },
    card: {
        backgroundColor: Colors.surface,
        borderRadius: 24,
        padding: 24,
        marginBottom: 20,
    },
    inputGroup: {
        marginBottom: 24,
        borderBottomWidth: 1,
        borderBottomColor: '#1E1E1E',
        paddingBottom: 8,
    },
    label: {
        fontSize: 10,
        fontWeight: '900',
        color: Colors.textSecondary,
        letterSpacing: 1.5,
        marginBottom: 8,
    },
    input: {
        fontSize: 18,
        fontWeight: '700',
        color: Colors.white,
        height: 40,
    },
    selectField: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        height: 40,
    },
    selectText: {
        fontSize: 18,
        fontWeight: '700',
        color: Colors.white,
    },
    photoBox: {
        width: '100%',
        height: 120,
        borderRadius: 24,
        backgroundColor: Colors.surface,
        borderWidth: 1,
        borderColor: '#1E1E1E',
        borderStyle: 'dashed',
        justifyContent: 'center',
        alignItems: 'center',
        gap: 12,
    },
    photoText: {
        color: Colors.textSecondary,
        fontSize: 14,
        fontWeight: '600',
    },
    footer: {
        padding: 24,
        paddingBottom: Platform.OS === 'ios' ? 40 : 30,
    },
    button: {
        backgroundColor: Colors.primary,
        height: 64,
        borderRadius: 20,
        justifyContent: 'center',
        alignItems: 'center',
    },
    buttonText: {
        color: Colors.secondary,
        fontSize: 18,
        fontWeight: '900',
    },
});
