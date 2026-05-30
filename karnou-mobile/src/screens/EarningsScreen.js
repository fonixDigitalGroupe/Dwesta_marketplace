import React from 'react';
import { StyleSheet, View, Text, TouchableOpacity, SafeAreaView, ScrollView, Platform } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { X, ArrowUpRight, TrendingUp, Wallet, ChevronRight } from 'lucide-react-native';

export default function EarningsScreen({ navigation }) {
    const transactions = [
        { id: 1, label: 'Course #8872', price: '1 500', time: '10 min ago' },
        { id: 2, label: 'Course #8865', price: '2 800', time: '1h ago' },
        { id: 3, label: 'Course #8859', price: '1 200', time: '09:12' },
        { id: 4, label: 'Bonus Quotidien', price: '2 000', time: 'Hier 18:30' },
    ];

    return (
        <SafeAreaView style={styles.container}>
            {/* Header */}
            <View style={styles.header}>
                <TouchableOpacity onPress={() => navigation.goBack()} style={styles.circleBtn}>
                    <X size={24} color={Colors.white} />
                </TouchableOpacity>
                <Text style={styles.headerTitle}>Mes Gains</Text>
                <View style={{ width: 44 }} />
            </View>

            <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
                {/* Balance Section */}
                <View style={styles.balanceSection}>
                    <Text style={styles.balanceLabel}>SOLDE DISPONIBLE</Text>
                    <View style={styles.priceRow}>
                        <Text style={styles.balanceValue}>21 700</Text>
                        <Text style={styles.currency}>CFA</Text>
                    </View>

                    <View style={styles.trendBadge}>
                        <TrendingUp size={14} color={Colors.primary} />
                        <Text style={styles.trendText}>+1 500 CFA aujourd'hui</Text>
                    </View>

                    <TouchableOpacity style={styles.payoutBtn} activeOpacity={0.8}>
                        <Wallet size={20} color={Colors.secondary} />
                        <Text style={styles.payoutBtnText}>Retirer mes fonds</Text>
                    </TouchableOpacity>
                </View>

                {/* History Section */}
                <View style={styles.historySection}>
                    <View style={styles.sectionHeader}>
                        <Text style={styles.sectionTitle}>DERNIERS TRAJETS</Text>
                        <TouchableOpacity>
                            <Text style={styles.seeAll}>Tout voir</Text>
                        </TouchableOpacity>
                    </View>

                    {transactions.map((tx) => (
                        <TouchableOpacity key={tx.id} style={styles.txCard} activeOpacity={0.7}>
                            <View style={styles.txIconBox}>
                                <ArrowUpRight size={20} color={Colors.primary} />
                            </View>
                            <View style={styles.txInfo}>
                                <Text style={styles.txLabel}>{tx.label}</Text>
                                <Text style={styles.txTime}>{tx.time}</Text>
                            </View>
                            <View style={styles.txAmountBox}>
                                <Text style={styles.txPrice}>+{tx.price}</Text>
                                <Text style={styles.txCurrency}>CFA</Text>
                            </View>
                        </TouchableOpacity>
                    ))}
                </View>

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
        alignItems: 'center',
        paddingHorizontal: 20,
        paddingTop: Platform.OS === 'ios' ? 0 : 20,
        height: 60,
    },
    headerTitle: {
        fontSize: 18,
        fontWeight: '900',
        color: Colors.white,
        letterSpacing: 0.5,
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
    balanceSection: {
        paddingHorizontal: 20,
        alignItems: 'center',
        marginBottom: 40,
    },
    balanceLabel: {
        fontSize: 12,
        fontWeight: '900',
        color: Colors.textSecondary,
        letterSpacing: 1.5,
        marginBottom: 12,
    },
    priceRow: {
        flexDirection: 'row',
        alignItems: 'flex-end',
        marginBottom: 16,
    },
    balanceValue: {
        fontSize: 64,
        fontWeight: '900',
        color: Colors.orange,
        lineHeight: 70,
    },
    currency: {
        fontSize: 24,
        fontWeight: '900',
        color: Colors.orange,
        marginBottom: 10,
        marginLeft: 8,
    },
    trendBadge: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: '#1E1E1E',
        paddingHorizontal: 16,
        paddingVertical: 8,
        borderRadius: 12,
        marginBottom: 32,
    },
    trendText: {
        color: Colors.white,
        fontSize: 13,
        fontWeight: '700',
        marginLeft: 8,
    },
    payoutBtn: {
        width: '100%',
        height: 64,
        backgroundColor: Colors.orange,
        borderRadius: 20,
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        gap: 12,
    },
    payoutBtnText: {
        color: Colors.white,
        fontSize: 18,
        fontWeight: '900',
    },
    historySection: {
        paddingHorizontal: 20,
    },
    sectionHeader: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        marginBottom: 20,
    },
    sectionTitle: {
        fontSize: 12,
        fontWeight: '900',
        color: Colors.textSecondary,
        letterSpacing: 1.5,
    },
    seeAll: {
        fontSize: 12,
        fontWeight: 'bold',
        color: Colors.orange,
    },
    txCard: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: Colors.surface,
        padding: 20,
        borderRadius: 24,
        marginBottom: 12,
    },
    txIconBox: {
        width: 48,
        height: 48,
        borderRadius: 16,
        backgroundColor: '#1E1E1E',
        justifyContent: 'center',
        alignItems: 'center',
        marginRight: 16,
    },
    txInfo: {
        flex: 1,
    },
    txLabel: {
        fontSize: 17,
        fontWeight: '800',
        color: Colors.white,
    },
    txTime: {
        fontSize: 13,
        color: Colors.textSecondary,
        marginTop: 4,
    },
    txAmountBox: {
        alignItems: 'flex-end',
    },
    txPrice: {
        fontSize: 18,
        fontWeight: '900',
        color: Colors.white,
    },
    txCurrency: {
        fontSize: 10,
        color: Colors.textSecondary,
        fontWeight: 'bold',
    },
});
