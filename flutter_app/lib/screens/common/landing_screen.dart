import 'package:flutter/material.dart';
import '../../utils/index.dart';
import '../../widgets/index.dart';

class LandingScreen extends StatelessWidget {
  const LandingScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final size = MediaQuery.of(context).size;

    return Scaffold(
      body: SingleChildScrollView(
        child: Column(
          children: [
            // Header
            Container(
              width: double.infinity,
              decoration: const BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topLeft,
                  end: Alignment.bottomRight,
                  colors: [AppTheme.primaryColor, AppTheme.primaryDarkColor],
                ),
              ),
              child: SafeArea(
                child: Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 32),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          const Text(
                            'Kelola\nKaryawan',
                            style: TextStyle(
                              fontSize: 28,
                              fontWeight: FontWeight.bold,
                              color: Colors.white,
                            ),
                          ),
                          Container(
                            width: 50,
                            height: 50,
                            decoration: BoxDecoration(
                              color: Colors.white.withOpacity(0.2),
                              borderRadius: BorderRadius.circular(12),
                            ),
                            child: const Icon(
                              Icons.people_outline,
                              color: Colors.white,
                            ),
                          ),
                        ],
                      ),
                      const SizedBox(height: 32),
                      const Text(
                        'Employee Management System',
                        style: TextStyle(
                          fontSize: 16,
                          color: Colors.white70,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
            // Features Section
            Padding(
              padding: const EdgeInsets.all(24),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const SizedBox(height: 32),
                  const Text(
                    'Key Features',
                    style: AppStyles.headingMedium,
                  ),
                  const SizedBox(height: 24),
                  _FeatureCard(
                    icon: Icons.people,
                    title: 'Employee Management',
                    description: 'Manage all employee data including profiles and information',
                  ),
                  const SizedBox(height: 16),
                  _FeatureCard(
                    icon: Icons.calendar_today,
                    title: 'Leave Management',
                    description: 'Request and track employee leave and time off',
                  ),
                  const SizedBox(height: 16),
                  _FeatureCard(
                    icon: Icons.school,
                    title: 'Training Programs',
                    description: 'Manage training programs and employee certifications',
                  ),
                  const SizedBox(height: 16),
                  _FeatureCard(
                    icon: Icons.analytics,
                    title: 'Analytics & Reporting',
                    description: 'View detailed reports and analytics about your team',
                  ),
                  const SizedBox(height: 48),
                  // CTA Buttons
                  const Text(
                    'Get Started',
                    style: AppStyles.headingMedium,
                  ),
                  const SizedBox(height: 24),
                  CustomButton(
                    label: 'Sign In',
                    onPressed: () {
                      Navigator.of(context).pushNamed('/login');
                    },
                    isFullWidth: true,
                  ),
                  const SizedBox(height: 12),
                  CustomButton(
                    label: 'Create Account',
                    onPressed: () {
                      Navigator.of(context).pushNamed('/register');
                    },
                    isOutlined: true,
                    isFullWidth: true,
                  ),
                  const SizedBox(height: 32),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _FeatureCard extends StatelessWidget {
  final IconData icon;
  final String title;
  final String description;

  const _FeatureCard({
    required this.icon,
    required this.title,
    required this.description,
  });

  @override
  Widget build(BuildContext context) {
    return CustomCard(
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Container(
            width: 56,
            height: 56,
            decoration: BoxDecoration(
              color: AppTheme.primaryColor.withOpacity(0.1),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(
              icon,
              color: AppTheme.primaryColor,
              size: 28,
            ),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: AppStyles.labelLarge,
                ),
                const SizedBox(height: 4),
                Text(
                  description,
                  style: AppStyles.bodySmall.copyWith(
                    color: AppTheme.textSecondary,
                  ),
                  maxLines: 2,
                  overflow: TextOverflow.ellipsis,
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
