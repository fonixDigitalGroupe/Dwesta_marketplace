import React from 'react';
import { StyleSheet, View, Text, TouchableOpacity, SafeAreaView, TextInput, KeyboardAvoidingView, Platform, Dimensions, ActivityIndicator } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { ArrowLeft } from 'lucide-react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';

const { width } = Dimensions.get('window');

export default function OTPScreen({ navigation, route }) {
    const { phoneNumber } = route.params || { phoneNumber: '+225 00 00 00 00' };
    const [code, setCode] = React.useState(['', '', '', '']);
    const [loading, setLoading] = React.useState(false);
    const [timer, setTimer] = React.useState(59);
    const inputs = React.useRef([]);

    const API_URL_VERIFY = 'http://10.109.247.85:8001/api/otp/verify';
    const API_URL_SEND = 'http://10.109.247.85:8001/api/otp/send';

    React.useEffect(() => {
        let interval = null;
        if (timer > 0) {
            interval = setInterval(() => {
                setTimer((prev) => prev - 1);
            }, 1000);
        } else {
            clearInterval(interval);
        }
        return () => clearInterval(interval);
    }, [timer]);

    const handleCodeChange = (text, index) => {
        const newCode = [...code];
        newCode[index] = text;
        setCode(newCode);

        // Move to next input
        if (text && index < 3) {
            inputs.current[index + 1].focus();
        }
    };

    const handleVerify = async () => {
        const otp = code.join('');
        setLoading(true);
        try {
            const response = await fetch(API_URL_VERIFY, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    phone: phoneNumber.replace(/\s/g, ''),
                    otp: otp
                }),
            });

            const data = await response.json();

            if (data.success) {
                // Sauvegarde du token pour les appels futurs personnels
                if (data.token) {
                    await AsyncStorage.setItem('userToken', data.token);
                }
                // Succès : Redirection vers les Permissions
                navigation.navigate('Permissions');
            } else {
                alert(data.message || "Code invalide");
            }
        } catch (error) {
            console.error('Verify Error:', error);
            alert("Erreur de connexion lors de la vérification");
        } finally {
            setLoading(false);
        }
    };

    const handleResend = async () => {
        if (timer > 0) return;

        setLoading(true);
        try {
            const response = await fetch(API_URL_SEND, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ phone: phoneNumber.replace(/\s/g, '') }),
            });
            const data = await response.json();
            if (data.success) {
                setTimer(59);
                alert("Nouveau code envoyé !");
            }
        } catch (error) {
            alert("Erreur lors du renvoi du code");
        } finally {
            setLoading(false);
        }
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
                        <View style={[styles.progressBar, { width: '50%', backgroundColor: Colors.primary }]} />
                    </View>
                </View>

                <View style={styles.content}>
                    <Text style={styles.title}>Vérification</Text>
                    <Text style={styles.subtitle}>
                        Saisissez le code à 4 chiffres envoyé au {phoneNumber}
                    </Text>

                    <View style={styles.codeRow}>
                        {code.map((digit, i) => (
                            <TextInput
                                key={i}
                                ref={(el) => (inputs.current[i] = el)}
                                style={[styles.codeInput, digit !== '' && styles.codeInputActive]}
                                maxLength={1}
                                keyboardType="number-pad"
                                value={digit}
                                onChangeText={(text) => handleCodeChange(text, i)}
                                autoFocus={i === 0}
                                placeholderTextColor="#475569"
                            />
                        ))}
                    </View>

                    <TouchableOpacity
                        style={styles.resendContainer}
                        onPress={handleResend}
                        disabled={timer > 0 || loading}
                    >
                        <Text style={[styles.resendText, timer === 0 && styles.resendTextActive]}>
                            {timer > 0
                                ? `Renvoyer le code dans 00:${timer < 10 ? `0${timer}` : timer}`
                                : "Renvoyer le code maintenant"}
                        </Text>
                    </TouchableOpacity>
                </View>

                <View style={styles.footer}>
                    <TouchableOpacity
                        style={[styles.button, { backgroundColor: code.every(d => d !== '') && !loading ? Colors.primary : '#262626' }]}
                        disabled={!code.every(d => d !== '') || loading}
                        onPress={handleVerify}
                    >
                        {loading ? (
                            <ActivityIndicator color={Colors.secondary} />
                        ) : (
                            <Text style={[styles.buttonText, { color: code.every(d => d !== '') ? Colors.secondary : Colors.textSecondary }]}>Confirmer</Text>
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
    codeRow: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        marginBottom: 40,
    },
    codeInput: {
        width: (width - 80) / 4,
        height: 72,
        backgroundColor: Colors.surface,
        borderRadius: 16,
        fontSize: 28,
        fontWeight: 'bold',
        color: Colors.white,
        textAlign: 'center',
    },
    codeInputActive: {
        borderWidth: 2,
        borderColor: Colors.primary,
    },
    resendContainer: {
        alignItems: 'center',
        marginTop: 20,
    },
    resendText: {
        color: Colors.textSecondary,
        fontSize: 15,
        fontWeight: '500',
    },
    resendTextActive: {
        color: Colors.primary,
        fontWeight: 'bold',
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
