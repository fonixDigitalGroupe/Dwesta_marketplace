import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';

// Temporary Screens (Placeholder for now)
import HomeScreen from '../screens/HomeScreen';
import ProfileScreen from '../screens/ProfileScreen';
import EarningsScreen from '../screens/EarningsScreen';
import SplashScreen from '../screens/SplashScreen';
import OnboardingScreen from '../screens/OnboardingScreen';
import LicenseFormScreen from '../screens/LicenseFormScreen';
import PhoneLoginScreen from '../screens/PhoneLoginScreen';
import OTPScreen from '../screens/OTPScreen';
import PermissionsScreen from '../screens/PermissionsScreen';
import UserTypeSelectionScreen from '../screens/UserTypeSelectionScreen';
import LivreurFormScreen from '../screens/LivreurFormScreen';
import TransporteurFormScreen from '../screens/TransporteurFormScreen';

const Stack = createNativeStackNavigator();

export default function AppNavigation() {
    return (
        <NavigationContainer>
            <Stack.Navigator
                initialRouteName="Splash"
                screenOptions={{
                    headerShown: false,
                    animation: 'slide_from_right',
                }}
            >
                <Stack.Screen name="Splash" component={SplashScreen} />
                <Stack.Screen name="PhoneLogin" component={PhoneLoginScreen} />
                <Stack.Screen name="OTP" component={OTPScreen} />
                <Stack.Screen name="Permissions" component={PermissionsScreen} />
                <Stack.Screen name="UserTypeSelection" component={UserTypeSelectionScreen} />
                <Stack.Screen name="LivreurForm" component={LivreurFormScreen} />
                <Stack.Screen name="TransporteurForm" component={TransporteurFormScreen} />
                <Stack.Screen name="Onboarding" component={OnboardingScreen} />
                <Stack.Screen name="LicenseForm" component={LicenseFormScreen} />
                <Stack.Screen name="Home" component={HomeScreen} />
                <Stack.Screen name="Profile" component={ProfileScreen} />
                <Stack.Screen name="Earnings" component={EarningsScreen} />
            </Stack.Navigator>
        </NavigationContainer>
    );
}
