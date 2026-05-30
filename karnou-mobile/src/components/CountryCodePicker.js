import React from 'react';
import { Modal, View, Text, TouchableOpacity, FlatList, StyleSheet, SafeAreaView, Dimensions } from 'react-native';
import { Colors, Spacing, Radius } from '../constants/Theme';
import { X } from 'lucide-react-native';

const { height } = Dimensions.get('window');

const REGISTERED_COUNTRIES = [
    { name: 'Sénégal', code: 'SN', phoneCode: '+221', flag: '🇸🇳', format: '00 000 00 00' },
    { name: 'Congo-Brazzaville', code: 'CG', phoneCode: '+242', flag: '🇨🇬', format: '00 00 00 00' },
    { name: 'Botswana', code: 'BW', phoneCode: '+267', flag: '🇧🇼', format: '00 000 000' },
    { name: 'Côte d\'Ivoire', code: 'CI', phoneCode: '+225', flag: '🇨🇮', format: '00 00 00 00 00' },
];

export default function CountryCodePicker({ visible, onClose, onSelect, selectedCode }) {
    return (
        <Modal
            visible={visible}
            animationType="slide"
            transparent={true}
            onRequestClose={onClose}
        >
            <View style={styles.modalOverlay}>
                <SafeAreaView style={styles.modalContent}>
                    <View style={styles.header}>
                        <Text style={styles.headerTitle}>Sélectionnez un pays</Text>
                        <TouchableOpacity onPress={onClose} style={styles.closeButton}>
                            <X size={24} color="#000" />
                        </TouchableOpacity>
                    </View>

                    <FlatList
                        data={REGISTERED_COUNTRIES}
                        keyExtractor={(item) => item.code}
                        contentContainerStyle={styles.listContent}
                        renderItem={({ item }) => (
                            <TouchableOpacity
                                style={[
                                    styles.countryItem,
                                    selectedCode === item.phoneCode && styles.selectedItem
                                ]}
                                onPress={() => {
                                    onSelect(item);
                                    onClose();
                                }}
                            >
                                <View style={styles.countryInfo}>
                                    <Text style={styles.flag}>{item.flag}</Text>
                                    <Text style={styles.countryName}>{item.name}</Text>
                                </View>
                                <Text style={styles.phoneCode}>{item.phoneCode}</Text>
                            </TouchableOpacity>
                        )}
                    />
                </SafeAreaView>
            </View>
        </Modal>
    );
}

const styles = StyleSheet.create({
    modalOverlay: {
        flex: 1,
        backgroundColor: 'rgba(0,0,0,0.5)',
        justifyContent: 'flex-end',
    },
    modalContent: {
        backgroundColor: Colors.white,
        borderTopLeftRadius: Radius.card,
        borderTopRightRadius: Radius.card,
        height: height * 0.5,
    },
    header: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        padding: Spacing.lg,
        borderBottomWidth: 1,
        borderBottomColor: '#F0F0F0',
    },
    headerTitle: {
        fontSize: 18,
        fontWeight: 'bold',
        color: Colors.text,
    },
    closeButton: {
        padding: 5,
    },
    listContent: {
        paddingVertical: 10,
    },
    countryItem: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        paddingVertical: Spacing.md,
        paddingHorizontal: Spacing.lg,
    },
    selectedItem: {
        backgroundColor: '#F0F7FF',
    },
    countryInfo: {
        flexDirection: 'row',
        alignItems: 'center',
    },
    flag: {
        fontSize: 24,
        marginRight: 15,
    },
    countryName: {
        fontSize: 16,
        color: Colors.text,
    },
    phoneCode: {
        fontSize: 16,
        fontWeight: '600',
        color: Colors.primary,
    },
});
