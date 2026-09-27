import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../models/index.dart';
import '../../providers/index.dart';
import '../../utils/index.dart';
import '../../widgets/index.dart';

class AdminKaryawanScreen extends StatefulWidget {
  const AdminKaryawanScreen({Key? key}) : super(key: key);

  @override
  State<AdminKaryawanScreen> createState() => _AdminKaryawanScreenState();
}

class _AdminKaryawanScreenState extends State<AdminKaryawanScreen> {
  final _searchController = TextEditingController();
  String? _selectedDepartment;
  String? _selectedStatus;

  @override
  void initState() {
    super.initState();
    _loadKaryawanList();
  }

  void _loadKaryawanList() {
    final provider = context.read<KaryawanProvider>();
    provider.getKaryawanList(
      search: _searchController.text.isNotEmpty ? _searchController.text : null,
      department: _selectedDepartment,
      status: _selectedStatus,
    );
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Manage Employees'),
        elevation: 0,
      ),
      floatingActionButton: FloatingActionButton(
        onPressed: () {
          Navigator.of(context).pushNamed('/admin-karyawan-create');
        },
        child: const Icon(Icons.add),
      ),
      body: Column(
        children: [
          // Search & Filters
          Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              children: [
                CustomTextField(
                  label: '',
                  hint: 'Search employees...',
                  controller: _searchController,
                  prefixIcon: const Icon(Icons.search),
                  onChanged: (_) {
                    _loadKaryawanList();
                  },
                ),
                const SizedBox(height: 12),
                // Filter chips
                SingleChildScrollView(
                  scrollDirection: Axis.horizontal,
                  child: Row(
                    children: [
                      FilterChip(
                        label: const Text('All Status'),
                        selected: _selectedStatus == null,
                        onSelected: (_) {
                          setState(() => _selectedStatus = null);
                          _loadKaryawanList();
                        },
                      ),
                      const SizedBox(width: 8),
                      FilterChip(
                        label: const Text('Active'),
                        selected: _selectedStatus == 'active',
                        onSelected: (_) {
                          setState(() => _selectedStatus = 'tetap');
                          _loadKaryawanList();
                        },
                      ),
                      const SizedBox(width: 8),
                      FilterChip(
                        label: const Text('Contract'),
                        selected: _selectedStatus == 'kontrak',
                        onSelected: (_) {
                          setState(() => _selectedStatus = 'kontrak');
                          _loadKaryawanList();
                        },
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
          // List
          Expanded(
            child: Consumer<KaryawanProvider>(
              builder: (context, provider, _) {
                if (provider.isLoading) {
                  return const CustomLoadingWidget(message: 'Loading employees...');
                }

                if (provider.karyawanList.isEmpty) {
                  return CustomEmptyWidget(
                    message: 'No employees found',
                    icon: Icons.people_outline,
                  );
                }

                return RefreshIndicator(
                  onRefresh: (_) async {
                    _loadKaryawanList();
                  },
                  child: ListView.builder(
                    padding: const EdgeInsets.symmetric(horizontal: 16),
                    itemCount: provider.karyawanList.length,
                    itemBuilder: (context, index) {
                      final karyawan = provider.karyawanList[index];
                      return _KaryawanListItem(
                        karyawan: karyawan,
                        onTap: () {
                          Navigator.of(context).pushNamed(
                            '/admin-karyawan-detail',
                            arguments: karyawan.id,
                          );
                        },
                        onDelete: () {
                          _showDeleteDialog(context, karyawan.id, provider);
                        },
                      );
                    },
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  void _showDeleteDialog(BuildContext context, int id, KaryawanProvider provider) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: const Text('Delete Employee'),
          content: const Text('Are you sure you want to delete this employee?'),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Cancel'),
            ),
            TextButton(
              onPressed: () async {
                await provider.deleteKaryawan(id);
                if (mounted) {
                  Navigator.pop(context);
                  ScaffoldMessenger.of(context).showSnackBar(
                    const SnackBar(content: Text('Employee deleted successfully')),
                  );
                }
              },
              child: const Text('Delete', style: TextStyle(color: Colors.red)),
            ),
          ],
        );
      },
    );
  }
}

class _KaryawanListItem extends StatelessWidget {
  final Karyawan karyawan;
  final VoidCallback onTap;
  final VoidCallback onDelete;

  const _KaryawanListItem({
    required this.karyawan,
    required this.onTap,
    required this.onDelete,
  });

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: onTap,
      child: CustomCard(
        margin: const EdgeInsets.only(bottom: 12),
        child: Row(
          children: [
            Container(
              width: 56,
              height: 56,
              decoration: BoxDecoration(
                color: AppTheme.primaryColor.withOpacity(0.1),
                borderRadius: BorderRadius.circular(12),
              ),
              child: const Icon(Icons.person, color: AppTheme.primaryColor),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    karyawan.name,
                    style: AppStyles.labelLarge,
                  ),
                  const SizedBox(height: 4),
                  Text(
                    karyawan.position,
                    style: AppStyles.bodySmall.copyWith(
                      color: AppTheme.textSecondary,
                    ),
                  ),
                ],
              ),
            ),
            PopupMenuButton(
              itemBuilder: (context) {
                return [
                  PopupMenuItem(
                    child: const Text('View'),
                    onTap: onTap,
                  ),
                  PopupMenuItem(
                    child: const Text('Edit'),
                    onTap: () {
                      Navigator.of(context).pushNamed(
                        '/admin-karyawan-edit',
                        arguments: karyawan.id,
                      );
                    },
                  ),
                  PopupMenuItem(
                    child: const Text('Delete', style: TextStyle(color: Colors.red)),
                    onTap: onDelete,
                  ),
                ];
              },
            ),
          ],
        ),
      ),
    );
  }
}
