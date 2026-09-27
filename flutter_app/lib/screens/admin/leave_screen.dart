import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../providers/index.dart';
import '../../utils/index.dart';
import '../../widgets/index.dart';

class AdminLeaveScreen extends StatefulWidget {
  const AdminLeaveScreen({Key? key}) : super(key: key);

  @override
  State<AdminLeaveScreen> createState() => _AdminLeaveScreenState();
}

class _AdminLeaveScreenState extends State<AdminLeaveScreen> {
  String? _selectedStatus = 'pending';

  @override
  void initState() {
    super.initState();
    _loadLeaves();
  }

  void _loadLeaves() {
    final provider = context.read<LeaveProvider>();
    provider.getLeaveList(status: _selectedStatus);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Manage Leaves'),
        elevation: 0,
      ),
      body: Column(
        children: [
          // Filter tabs
          Padding(
            padding: const EdgeInsets.all(16),
            child: SingleChildScrollView(
              scrollDirection: Axis.horizontal,
              child: Row(
                children: [
                  FilterChip(
                    label: const Text('All'),
                    selected: _selectedStatus == null,
                    onSelected: (_) {
                      setState(() => _selectedStatus = null);
                      _loadLeaves();
                    },
                  ),
                  const SizedBox(width: 8),
                  FilterChip(
                    label: const Text('Pending'),
                    selected: _selectedStatus == 'pending',
                    onSelected: (_) {
                      setState(() => _selectedStatus = 'pending');
                      _loadLeaves();
                    },
                  ),
                  const SizedBox(width: 8),
                  FilterChip(
                    label: const Text('Approved'),
                    selected: _selectedStatus == 'approved',
                    onSelected: (_) {
                      setState(() => _selectedStatus = 'approved');
                      _loadLeaves();
                    },
                  ),
                  const SizedBox(width: 8),
                  FilterChip(
                    label: const Text('Rejected'),
                    selected: _selectedStatus == 'rejected',
                    onSelected: (_) {
                      setState(() => _selectedStatus = 'rejected');
                      _loadLeaves();
                    },
                  ),
                ],
              ),
            ),
          ),
          // List
          Expanded(
            child: Consumer<LeaveProvider>(
              builder: (context, provider, _) {
                if (provider.isLoading) {
                  return const CustomLoadingWidget(message: 'Loading leaves...');
                }

                if (provider.leaveList.isEmpty) {
                  return CustomEmptyWidget(
                    message: 'No leaves found',
                    icon: Icons.calendar_today,
                  );
                }

                return RefreshIndicator(
                  onRefresh: (_) async {
                    _loadLeaves();
                  },
                  child: ListView.builder(
                    padding: const EdgeInsets.symmetric(horizontal: 16),
                    itemCount: provider.leaveList.length,
                    itemBuilder: (context, index) {
                      final leave = provider.leaveList[index];
                      return _LeaveListItem(
                        leave: leave,
                        onApprove: leave.status == 'pending'
                            ? () => _handleApproveLeave(context, leave.id, provider)
                            : null,
                        onReject: leave.status == 'pending'
                            ? () => _handleRejectLeave(context, leave.id, provider)
                            : null,
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

  void _handleApproveLeave(BuildContext context, int leaveId, LeaveProvider provider) {
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: const Text('Approve Leave'),
          content: const Text('Are you sure you want to approve this leave?'),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Cancel'),
            ),
            TextButton(
              onPressed: () async {
                await provider.approveLeave(leaveId);
                if (mounted) {
                  Navigator.pop(context);
                  ScaffoldMessenger.of(context).showSnackBar(
                    const SnackBar(content: Text('Leave approved successfully')),
                  );
                }
              },
              child: const Text('Approve', style: TextStyle(color: Colors.green)),
            ),
          ],
        );
      },
    );
  }

  void _handleRejectLeave(BuildContext context, int leaveId, LeaveProvider provider) {
    final reasonController = TextEditingController();
    showDialog(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: const Text('Reject Leave'),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              const Text('Are you sure you want to reject this leave?'),
              const SizedBox(height: 16),
              TextField(
                controller: reasonController,
                decoration: InputDecoration(
                  hintText: 'Rejection reason (optional)',
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8),
                  ),
                ),
                maxLines: 3,
              ),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context),
              child: const Text('Cancel'),
            ),
            TextButton(
              onPressed: () async {
                await provider.rejectLeave(leaveId, reasonController.text);
                if (mounted) {
                  Navigator.pop(context);
                  ScaffoldMessenger.of(context).showSnackBar(
                    const SnackBar(content: Text('Leave rejected')),
                  );
                }
              },
              child: const Text('Reject', style: TextStyle(color: Colors.red)),
            ),
          ],
        );
      },
    );
  }
}

class _LeaveListItem extends StatelessWidget {
  final Leave leave;
  final VoidCallback? onApprove;
  final VoidCallback? onReject;

  const _LeaveListItem({
    required this.leave,
    this.onApprove,
    this.onReject,
  });

  Color _getStatusColor() {
    switch (leave.status) {
      case 'approved':
        return AppTheme.successColor;
      case 'rejected':
        return AppTheme.errorColor;
      default:
        return AppTheme.warningColor;
    }
  }

  @override
  Widget build(BuildContext context) {
    return CustomCard(
      margin: const EdgeInsets.only(bottom: 12),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Expanded(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      leave.leaveType.toUpperCase(),
                      style: AppStyles.labelLarge,
                    ),
                    const SizedBox(height: 4),
                    Text(
                      '${DateTimeUtils.formatDate(leave.startDate)} - ${DateTimeUtils.formatDate(leave.endDate)}',
                      style: AppStyles.bodySmall.copyWith(
                        color: AppTheme.textSecondary,
                      ),
                    ),
                  ],
                ),
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                decoration: BoxDecoration(
                  color: _getStatusColor().withOpacity(0.1),
                  borderRadius: BorderRadius.circular(20),
                ),
                child: Text(
                  leave.status.toUpperCase(),
                  style: TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.w600,
                    color: _getStatusColor(),
                  ),
                ),
              ),
            ],
          ),
          if (leave.status == 'pending') ...[
            const SizedBox(height: 12),
            Row(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                TextButton(
                  onPressed: onReject,
                  style: TextButton.styleFrom(
                    foregroundColor: Colors.red,
                  ),
                  child: const Text('Reject'),
                ),
                const SizedBox(width: 8),
                ElevatedButton(
                  onPressed: onApprove,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.green,
                  ),
                  child: const Text('Approve'),
                ),
              ],
            ),
          ],
        ],
      ),
    );
  }
}
