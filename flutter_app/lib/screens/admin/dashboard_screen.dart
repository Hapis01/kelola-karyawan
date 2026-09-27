import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../models/index.dart';
import '../../providers/index.dart';
import '../../services/index.dart';
import '../../utils/index.dart';
import '../../widgets/index.dart';

class AdminDashboardScreen extends StatefulWidget {
  const AdminDashboardScreen({Key? key}) : super(key: key);

  @override
  State<AdminDashboardScreen> createState() => _AdminDashboardScreenState();
}

class _AdminDashboardScreenState extends State<AdminDashboardScreen> {
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
        title: const Text('Admin Dashboard'),
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
                          'Welcome, ${authProvider.currentUser?.name}!',
                          style: AppStyles.headingMedium,
                        ),
                        const SizedBox(height: 8),
                        Text(
                          'Here is your dashboard overview',
                          style: AppStyles.bodySmall.copyWith(
                            color: AppTheme.textSecondary,
                          ),
                        ),
                      ],
                    );
                  },
                ),
                const SizedBox(height: 24),
                // Stats Section
                if (_isLoadingStats)
                  const CustomLoadingWidget(message: 'Loading dashboard...')
                else
                  _buildStatsGrid(),
                const SizedBox(height: 24),
                // Quick Actions
                const Text(
                  'Quick Actions',
                  style: AppStyles.headingSmall,
                ),
                const SizedBox(height: 16),
                _buildQuickActions(context),
                const SizedBox(height: 24),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildStatsGrid() {
    return GridView.count(
      crossAxisCount: 2,
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      mainAxisSpacing: 16,
      crossAxisSpacing: 16,
      children: [
        _StatCard(
          title: 'Total Employees',
          value: '${_stats?['total_employees'] ?? 0}',
          icon: Icons.people,
          color: AppTheme.primaryColor,
        ),
        _StatCard(
          title: 'Active Trainings',
          value: '${_stats?['active_trainings'] ?? 0}',
          icon: Icons.school,
          color: AppTheme.successColor,
        ),
        _StatCard(
          title: 'Pending Leaves',
          value: '${_stats?['pending_leaves'] ?? 0}',
          icon: Icons.calendar_today,
          color: AppTheme.warningColor,
        ),
        _StatCard(
          title: 'Departments',
          value: '${_stats?['total_departments'] ?? 0}',
          icon: Icons.business,
          color: AppTheme.infoColor,
        ),
      ],
    );
  }

  Widget _buildQuickActions(BuildContext context) {
    return GridView.count(
      crossAxisCount: 2,
      shrinkWrap: true,
      physics: const NeverScrollableScrollPhysics(),
      mainAxisSpacing: 16,
      crossAxisSpacing: 16,
      children: [
        _QuickActionCard(
          title: 'Manage Employees',
          icon: Icons.people,
          onTap: () {
            Navigator.of(context).pushNamed('/admin-karyawan');
          },
        ),
        _QuickActionCard(
          title: 'Manage Leaves',
          icon: Icons.calendar_today,
          onTap: () {
            Navigator.of(context).pushNamed('/admin-leaves');
          },
        ),
        _QuickActionCard(
          title: 'Manage Training',
          icon: Icons.school,
          onTap: () {
            Navigator.of(context).pushNamed('/admin-training');
          },
        ),
        _QuickActionCard(
          title: 'View Reports',
          icon: Icons.analytics,
          onTap: () {
            ScaffoldMessenger.of(context).showSnackBar(
              const SnackBar(content: Text('Reports coming soon')),
            );
          },
        ),
      ],
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

class _StatCard extends StatelessWidget {
  final String title;
  final String value;
  final IconData icon;
  final Color color;

  const _StatCard({
    required this.title,
    required this.value,
    required this.icon,
    required this.color,
  });

  @override
  Widget build(BuildContext context) {
    return CustomCard(
      color: Colors.white,
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Container(
            width: 48,
            height: 48,
            decoration: BoxDecoration(
              color: color.withOpacity(0.1),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, color: color),
          ),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                value,
                style: const TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(height: 4),
              Text(
                title,
                style: AppStyles.bodySmall.copyWith(
                  color: AppTheme.textSecondary,
                ),
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
              ),
            ],
          ),
        ],
      ),
    );
  }
}

class _QuickActionCard extends StatelessWidget {
  final String title;
  final IconData icon;
  final VoidCallback onTap;

  const _QuickActionCard({
    required this.title,
    required this.icon,
    required this.onTap,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        decoration: BoxDecoration(
          color: AppTheme.primaryColor.withOpacity(0.1),
          borderRadius: BorderRadius.circular(16),
          border: Border.all(
            color: AppTheme.primaryColor.withOpacity(0.2),
          ),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              icon,
              size: 32,
              color: AppTheme.primaryColor,
            ),
            const SizedBox(height: 12),
            Text(
              title,
              textAlign: TextAlign.center,
              style: AppStyles.labelMedium,
            ),
          ],
        ),
      ),
    );
  }
}
