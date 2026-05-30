import React, { useState } from 'react';
import { StyleSheet, View, Text, TouchableOpacity, SafeAreaView, TextInput, KeyboardAvoidingView, Platform, ActivityIndicator } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { ArrowLeft, ChevronDown } from 'lucide-react-native';
import CountryCodePicker from '../components/CountryCodePicker';

export default function PhoneLoginScreen({ navigation }) {
    const [phone, setPhone] = useState('');
    const [loading, setLoading] = useState(false);
    const [isPickerVisible, setIsPickerVisible] = useState(false);
    const [selectedCountry, setSelectedCountry] = useState({
        name: 'Sénégal',
        code: 'SN',
        phoneCode: '+221',
        flag: '🇸🇳',
        format: '00 000 00 00'
    });

    const API_URL = 'http://10.109.247.85:8001/api/otp/send';

    const handleNext = async () => {
        setLoading(true);
        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ phone: `${selectedCountry.phoneCode}${phone.replace(/\s/g, '')}` }),
            });
            console.log('Response Status:', response.status);
            const data = await response.json();
            console.log('Response Data:', data);

            if (data.success) {
                navigation.navigate('OTP', {
                    phoneNumber: `${selectedCountry.phoneCode} ${phone}`
                });
            } else {
                alert("Erreur serveur : " + (data.message || "Inconnue"));
            }
        } catch (error) {
            console.log('Fetch Error Detail:', error);
            alert("Erreur de connexion : Vérifiez que votre téléphone est sur le même Wi-Fi que l'ordinateur (" + API_URL + ")");
        } finally {
            setLoading(false);
        }
    };

    const applyMask = (text, format) => {
        // Remove all non-digits
        const digits = text.replace(/\D/g, '');
        let masked = '';
        let digitIndex = 0;

        for (let i = 0; i < format.length && digitIndex < digits.length; i++) {
            if (format[i] === '0') {
                masked += digits[digitIndex];
                digitIndex++;
            } else {
                masked += format[i];
            }
        }
        return masked;
    };

    const handlePhoneChange = (text) => {
        const masked = applyMask(text, selectedCountry.format);
        setPhone(masked);
    };

    const isPhoneValid = () => {
        const digits = phone.replace(/\D/g, '');
        const requiredDigits = selectedCountry.format.replace(/[^0]/g, '').length;
        return digits.length === requiredDigits;
    };

    return (
        <SafeAreaView style={styles.container}>
            <KeyboardAvoidingView
                behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
                style={styles.flex}
            >
                <View style={styles.header}>
                    <TouchableOpacity onPress={() => navigation.goBack()} style={styles.backButton}>
                        <ArrowLeft size={24} color={Colors.white} />
                    </TouchableOpacity>
                    <View style={styles.progressContainer}>
                        <View style={[styles.progressBar, { width: '25%', backgroundColor: Colors.primary }]} />
                    </View>
                </View>

                <View style={styles.content}>
                    <Text style={styles.title}>Quel est votre numéro ?</Text>
                    <Text style={styles.subtitle}>
                        Saisissez votre numéro pour commencer l'aventure Karnou Marketplace.
                    </Text>

                    <View style={styles.inputCard}>
                        <TouchableOpacity
                            style={styles.countryPicker}
                            onPress={() => setIsPickerVisible(true)}
                        >
                            <Text style={styles.flag}>{selectedCountry.flag}</Text>
                            <Text style={styles.countryCode}>{selectedCountry.phoneCode}</Text>
                            <ChevronDown size={14} color={Colors.textSecondary} />
                        </TouchableOpacity>

                        <TextInput
                            style={styles.input}
                            placeholder={selectedCountry.format}
                            placeholderTextColor="#475569"
                            keyboardType="phone-pad"
                            value={phone}
                            onChangeText={handlePhoneChange}
                            autoFocus={true}
                            maxLength={selectedCountry.format.length}
                        />
                    </View>

                    <Text style={styles.infoText}>
                        Un code de vérification vous sera envoyé par SMS.
                    </Text>
                </View>

                <CountryCodePicker
                    visible={isPickerVisible}
                    onClose={() => setIsPickerVisible(false)}
                    selectedCode={selectedCountry.phoneCode}
                    onSelect={(country) => {
                        setSelectedCountry(country);
                        setPhone('');
                    }}
                />

                <View style={styles.footer}>
                    <TouchableOpacity
                        style={[styles.button, { backgroundColor: isPhoneValid() && !loading ? Colors.primary : '#262626' }]}
                        disabled={!isPhoneValid() || loading}
                        onPress={handleNext}
                    >
                        {loading ? (
                            <ActivityIndicator color={Colors.secondary} />
                        ) : (
                            <Text style={[styles.buttonText, { color: isPhoneValid() ? Colors.secondary : Colors.textSecondary }]}>Continuer</Text>
                        )}
                    </TouchableOpacity>
                </View>
            </KeyboardAvoidingView>
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: Colors.background,
    },
    flex: {
        flex: 1,
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
        backgroundColor: Colors.primary,
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
    inputCard: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: Colors.surface,
        borderRadius: 16,
        paddingHorizontal: 20,
        height: 72,
    },
    countryPicker: {
        flexDirection: 'row',
        alignItems: 'center',
        marginRight: 16,
        paddingRight: 12,
        borderRightWidth: 1,
        borderRightColor: '#262626',
    },
    flag: {
        fontSize: 24,
        marginRight: 8,
    },
    countryCode: {
        fontSize: 18,
        fontWeight: '900',
        color: Colors.white,
        marginRight: 4,
    },
    input: {
        flex: 1,
        fontSize: 22,
        fontWeight: 'bold',
        color: Colors.white,
        letterSpacing: 1,
    },
    infoText: {
        marginTop: 20,
        fontSize: 13,
        color: Colors.textSecondary,
        textAlign: 'center',
    },
    footer: {
        padding: Spacing.lg,
        paddingBottom: Platform.OS === 'ios' ? 40 : 30,
    },
    button: {
        height: 64,
        borderRadius: 16,
        justifyContent: 'center',
        alignItems: 'center',
    },
    buttonText: {
        fontSize: 18,
        fontWeight: '900',
        letterSpacing: 0.5,
    },
});
