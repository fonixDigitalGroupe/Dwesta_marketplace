import React from 'react';
import { StyleSheet, View, Text, SafeAreaView, TouchableOpacity, Dimensions, Platform } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { Truck, Bike, ChevronRight, ArrowLeft } from 'lucide-react-native';

const { width } = Dimensions.get('window');

export default function UserTypeSelectionScreen({ navigation }) {
    return (
        <SafeAreaView style={styles.container}>
            <View style={styles.header}>
                <TouchableOpacity onPress={() => navigation.goBack()} style={styles.backButton}>
                    <ArrowLeft size={24} color={Colors.white} />
                </TouchableOpacity>
                <View style={styles.progressContainer}>
                    <View style={[styles.progressBar, { width: '60%', backgroundColor: Colors.primary }]} />
                </View>
            </View>

            <View style={styles.content}>
                <Text style={styles.title}>Choisissez votre métier</Text>
                <Text style={styles.subtitle}>
                    Karnou s'adapte à votre logistique. Sélectionnez le profil qui vous correspond.
                </Text>

                <View style={styles.optionsContainer}>
                    {/* Option: Livreur */}
                    <TouchableOpacity
                        style={styles.optionCard}
                        onPress={() => navigation.navigate('LivreurForm')}
                        activeOpacity={0.8}
                    >
                        <View style={styles.iconBox}>
                            <Bike size={40} color={Colors.primary} strokeWidth={2} />
                        </View>
                        <View style={styles.optionTextContainer}>
                            <Text style={styles.optionTitle}>Livreur</Text>
                            <Text style={styles.optionDescription}>Coursier urbain, moto ou voiture légère</Text>
                        </View>
                        <ChevronRight size={20} color={Colors.textSecondary} />
                    </TouchableOpacity>

                    {/* Option: Transporteur */}
                    <TouchableOpacity
                        style={styles.optionCard}
                        onPress={() => navigation.navigate('TransporteurForm')}
                        activeOpacity={0.8}
                    >
                        <View style={styles.iconBox}>
                            <Truck size={40} color={Colors.primary} strokeWidth={2} />
                        </View>
                        <View style={styles.optionTextContainer}>
                            <Text style={styles.optionTitle}>Transporteur</Text>
                            <Text style={styles.optionDescription}>Fret lourd, camion, van et inter-urbain</Text>
                        </View>
                        <ChevronRight size={20} color={Colors.textSecondary} />
                    </TouchableOpacity>
                </View>
            </View>

            <View style={styles.footer}>
                <Text style={styles.footerText}>KARNOU LOGISTICS PLATFORM</Text>
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
    optionsContainer: {
        gap: 16,
    },
    optionCard: {
        flexDirection: 'row',
        alignItems: 'center',
        padding: 24,
        backgroundColor: Colors.surface,
        borderRadius: 24,
    },
    iconBox: {
        width: 64,
        height: 64,
        borderRadius: 20,
        backgroundColor: '#262626',
        justifyContent: 'center',
        alignItems: 'center',
        marginRight: 20,
    },
    optionTextContainer: {
        flex: 1,
    },
    optionTitle: {
        fontSize: 22,
        fontWeight: '900',
        color: Colors.white,
        marginBottom: 4,
    },
    optionDescription: {
        fontSize: 14,
        color: Colors.textSecondary,
        lineHeight: 20,
    },
    footer: {
        padding: 40,
        alignItems: 'center',
    },
    footerText: {
        fontSize: 11,
        fontWeight: 'bold',
        color: '#262626',
        letterSpacing: 2,
    },
});
