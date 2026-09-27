import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'providers/index.dart';
import 'services/index.dart';
import 'screens/auth/index.dart';
import 'screens/common/index.dart';
import 'screens/admin/index.dart';
import 'screens/karyawan/index.dart';
import 'utils/index.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // Initialize local storage
  final localStorageService = LocalStorageService();
  await localStorageService.init();

  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        Provider<ApiService>(create: (_) => ApiService()),
        Provider<LocalStorageService>(create: (_) => LocalStorageService()),
        ChangeNotifierProvider<AuthProvider>(
          create: (context) => AuthProvider(
            apiService: context.read<ApiService>(),
            storageService: context.read<LocalStorageService>(),
          ),
        ),
        ChangeNotifierProvider<KaryawanProvider>(
          create: (context) => KaryawanProvider(apiService: context.read<ApiService>()),
        ),
        ChangeNotifierProvider<LeaveProvider>(
          create: (context) => LeaveProvider(apiService: context.read<ApiService>()),
        ),
        ChangeNotifierProvider<TrainingProvider>(
          create: (context) => TrainingProvider(apiService: context.read<ApiService>()),
        ),
      ],
      child: Consumer<AuthProvider>(
        builder: (context, authProvider, _) {
          return MaterialApp(
            title: 'Kelola Karyawan',
            theme: AppTheme.lightTheme,
            darkTheme: AppTheme.darkTheme,
            themeMode: ThemeMode.light,
            home: const SplashScreen(),
            routes: {
              '/landing': (context) => const LandingScreen(),
              '/login': (context) => const LoginScreen(),
              '/register': (context) => const RegisterScreen(),
              '/admin-dashboard': (context) => const AdminDashboardScreen(),
              '/admin-karyawan': (context) => const AdminKaryawanScreen(),
              '/admin-leaves': (context) => const AdminLeaveScreen(),
              '/karyawan-dashboard': (context) => const KaryawanDashboardScreen(),
            },
            debugShowCheckedModeBanner: false,
          );
        },
      ),
    );
  }
}

class SplashScreen extends StatefulWidget {
  const SplashScreen({Key? key}) : super(key: key);

  @override
  State<SplashScreen> createState() => _SplashScreenState();
}

class _SplashScreenState extends State<SplashScreen> {
  @override
  void initState() {
    super.initState();
    _initializeApp();
  }

  Future<void> _initializeApp() async {
    final authProvider = context.read<AuthProvider>();

    // Initialize auth provider
    await authProvider.initialize();

    // Navigate based on auth state
    if (mounted) {
      if (authProvider.isLoggedIn) {
        if (authProvider.isAdmin()) {
          Navigator.of(context).pushReplacementNamed('/admin-dashboard');
        } else {
          Navigator.of(context).pushReplacementNamed('/karyawan-dashboard');
        }
      } else {
        Navigator.of(context).pushReplacementNamed('/landing');
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              width: 100,
              height: 100,
              decoration: BoxDecoration(
                color: AppTheme.primaryColor,
                borderRadius: BorderRadius.circular(20),
              ),
              child: const Icon(
                Icons.people_outline,
                size: 60,
                color: Colors.white,
              ),
            ),
            const SizedBox(height: 32),
            const Text(
              'Kelola Karyawan',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.bold,
              ),
            ),
            const SizedBox(height: 16),
            const CircularProgressIndicator(),
          ],
        ),
      ),
    );
  }
}
