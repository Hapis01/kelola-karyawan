import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../models/index.dart';
import '../../providers/index.dart';
import '../../services/index.dart';
import '../../utils/index.dart';
import '../../widgets/index.dart';

class KaryawanDashboardScreen extends StatefulWidget {
  const KaryawanDashboardScreen({Key? key}) : super(key: key);

  @override
  State<KaryawanDashboardScreen> createState() => _KaryawanDashboardScreenState();
}

class _KaryawanDashboardScreenState extends State<KaryawanDashboardScreen> {
  late ApiService _apiService;
  Map<String, dynamic>? _stats;
  bool _isLoadingStats = true;

  @override
  void initState() {
    super.initState();
    _apiService = ApiService();
    _loadDashboardStats();
  }

  Future<void> _loadDashboardStats() async {
    try {
      final stats = await _apiService.getDashboardStats();
      setState(() {
        _stats = stats;
        _isLoadingStats = false;
      });
    } catch (e) {
      setState(() {
        _isLoadingStats = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Dashboard'),
        elevation: 0,
        actions: [
          Consumer<AuthProvider>(
            builder: (context, authProvider, _) {
              return IconButton(
                icon: const Icon(Icons.logout),
                onPressed: () {
                  _showLogoutDialog(context, authProvider);
                },
              );
            },
          ),
        ],
      ),
      drawer: _buildDrawer(context),
      body: RefreshIndicator(
        onRefresh: _loadDashboardStats,
        child: SingleChildScrollView(
          physics: const AlwaysScrollableScrollPhysics(),
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Welcome Section
                Consumer<AuthProvider>(
                  builder: (context, authProvider, _) {
                    return Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'Hello, ${authProvider.currentUser?.name}!',
                          style: AppStyles.headingMedium,
                        ),
                        const SizedBox(height: 8),
                        Text(
                          'Your personal dashboard',
                          style: AppStyles.bodySmall.copyWith(
                            color: AppTheme.textSecondary,
                          ),
                        ),
                      ],
                    );
                  },
                ),
                const SizedBox(height: 24),
                // Quick Info
                if (_isLoadingStats)
                  const CustomLoadingWidget(message: 'Loading dashboard...')
                else
                  _buildQuickInfo(),
                const SizedBox(height: 24),
                // Menu Items
                const Text(
                  'Menu',
                  style: AppStyles.headingSmall,
                ),
                const SizedBox(height: 16),
                _buildMenuItems(context),
                const SizedBox(height: 24),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildQuickInfo() {
    return Column(
      children: [
        Row(
          children: [
            Expanded(
              child: CustomCard(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Container(
                      width: 40,
                      height: 40,
                      decoration: BoxDecoration(
                        color: AppTheme.primaryColor.withOpacity(0.1),
                        borderRadius: BorderRadius.circular(8),
                      ),
                      child: const Icon(Icons.calendar_today, color: AppTheme.primaryColor),
                    ),
                    const SizedBox(height: 12),
                    const Text(
                      'Pending Leaves',
                      style: AppStyles.bodySmall,
                    ),
                    const SizedBox(height: 4),
                    Text(
                      '${_stats?['my_pending_leaves'] ?? 0}',
                      style: const TextStyle(
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ],
                ),
              ),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: CustomCard(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Container(
                      width: 40,
                      height: 40,
                      decoration: BoxDecoration(
                        color: AppTheme.successColor.withOpacity(0.1),
                        borderRadius: BorderRadius.circular(8),
                      ),
                      child: const Icon(Icons.school, color: AppTheme.successColor),
                    ),
                    const SizedBox(height: 12),
                    const Text(
                      'Enrolled Training',
                      style: AppStyles.bodySmall,
                    ),
                    const SizedBox(height: 4),
                    Text(
                      '${_stats?['my_trainings'] ?? 0}',
                      style: const TextStyle(
                        fontSize: 24,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ],
        ),
      ],
    );
  }

  Widget _buildMenuItems(BuildContext context) {
    return Column(
      children: [
        _MenuItemCard(
          icon: Icons.person,
          title: 'My Profile',
          subtitle: 'View and edit your profile',
          onTap: () {
            Navigator.of(context).pushNamed('/karyawan-profile');
          },
        ),
        const SizedBox(height: 12),
        _MenuItemCard(
          icon: Icons.calendar_today,
          title: 'My Leaves',
          subtitle: 'Request and track leaves',
          onTap: () {
            Navigator.of(context).pushNamed('/karyawan-leaves');
          },
        ),
        const SizedBox(height: 12),
        _MenuItemCard(
          icon: Icons.school,
          title: 'Trainings',
          subtitle: 'Browse and enroll trainings',
          onTap: () {
            Navigator.of(context).pushNamed('/karyawan-training');
          },
        ),
        const SizedBox(height: 12),
        _MenuItemCard(
          icon: Icons.history,
          title: 'Profile History',
          subtitle: 'View your profile changes',
          onTap: () {
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(content: Text('Profile history coming soon')),
            );
          },
        ),
      ],
    );
  }

  Drawer _buildDrawer(BuildContext context) {
    return Drawer(
      child: ListView(
        padding: EdgeInsets.zero,
        children: [
          Consumer<AuthProvider>(
            builder: (context, authProvider, _) {
              return DrawerHeader(
                decoration: const BoxDecoration(
                  color: AppTheme.primaryColor,
                ),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    const Icon(
                      Icons.person_circle,
                      size: 56,
                      color: Colors.white,
                    ),
                    const SizedBox(height: 12),
                    Text(
                      authProvider.currentUser?.name ?? 'User',
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 18,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    const SizedBox(height: 4),
                    Text(
                      authProvider.currentUser?.email ?? '',
                      style: const TextStyle(
                        color: Colors.white70,
                        fontSize: 12,
                      ),
                    ),
                  ],
                ),
              );
            },
          ),
          ListTile(
            leading: const Icon(Icons.dashboard),
            title: const Text('Dashboard'),
            onTap: () {
              Navigator.pop(context);
            },
          ),
          ListTile(
            leading: const Icon(Icons.person),
            title: const Text('My Profile'),
            onTap: () {
              Navigator.pop(context);
              Navigator.of(context).pushNamed('/karyawan-profile');
            },
          ),
          ListTile(
            leading: const Icon(Icons.calendar_today),
            title: const Text('My Leaves'),
            onTap: () {
              Navigator.pop(context);
              Navigator.of(context).pushNamed('/karyawan-leaves');
            },
          ),
          ListTile(
            leading: const Icon(Icons.school),
            title: const Text('Trainings'),
            onTap: () {
              Navigator.pop(context);
              Navigator.of(context).pushNamed('/karyawan-training');
            },
          ),
          const Divider(),
          ListTile(
            leading: const Icon(Icons.logout),
            title: const Text('Logout'),
            onTap: () {
              Navigator.pop(context);
              final authProvider = context.read<AuthProvider>();
              _showLogoutDialog(context, authProvider);
            },
          ),
        ],
      ),
    );
  }

  void _showLogoutDialog(BuildContext context, AuthProvider authProvider) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: const Text('Logout'),
          content: const Text('Are you sure you want to logout?'),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Cancel'),
            ),
            TextButton(
              onPressed: () async {
                await authProvider.logout();
                if (mounted) {
                  Navigator.of(context).pushReplacementNamed('/landing');
                }
              },
              child: const Text('Logout', style: TextStyle(color: Colors.red)),
            ),
          ],
        );
      },
    );
  }
}

class _MenuItemCard extends StatelessWidget {
  final IconData icon;
  final String title;
  final String subtitle;
  final VoidCallback onTap;

  const _MenuItemCard({
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: CustomCard(
        child: Row(
          children: [
            Container(
              width: 48,
              height: 48,
              decoration: BoxDecoration(
                color: AppTheme.primaryColor.withOpacity(0.1),
                borderRadius: BorderRadius.circular(12),
              ),
              child: Icon(icon, color: AppTheme.primaryColor),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(title, style: AppStyles.labelLarge),
                  const SizedBox(height: 4),
                  Text(
                    subtitle,
                    style: AppStyles.bodySmall.copyWith(
                      color: AppTheme.textSecondary,
                    ),
                  ),
                ],
              ),
            ),
            const Icon(Icons.arrow_forward_ios, size: 16),
          ],
        ),
      ),
    );
  }
}
