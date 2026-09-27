class Leave {
  final int id;
  final int karyawanId;
  final String leaveType; // cuti, sakit, izin, dll
  final DateTime startDate;
  final DateTime endDate;
  final int numberOfDays;
  final String reason;
  final String status; // pending, approved, rejected
  final String? rejectionReason;
  final int? approvedBy;
  final DateTime? approvedAt;
  final String? attachment;
  final DateTime createdAt;
  final DateTime updatedAt;

  Leave({
    required this.id,
    required this.karyawanId,
    required this.leaveType,
    required this.startDate,
    required this.endDate,
    required this.numberOfDays,
    required this.reason,
    required this.status,
    this.rejectionReason,
    this.approvedBy,
    this.approvedAt,
    this.attachment,
    required this.createdAt,
    required this.updatedAt,
  });

  factory Leave.fromJson(Map<String, dynamic> json) {
    return Leave(
      id: json['id'] ?? 0,
      karyawanId: json['karyawan_id'] ?? 0,
      leaveType: json['leave_type'] ?? '',
      startDate: json['start_date'] != null ? DateTime.parse(json['start_date']) : DateTime.now(),
      endDate: json['end_date'] != null ? DateTime.parse(json['end_date']) : DateTime.now(),
      numberOfDays: json['number_of_days'] ?? 0,
      reason: json['reason'] ?? '',
      status: json['status'] ?? 'pending',
      rejectionReason: json['rejection_reason'],
      approvedBy: json['approved_by'],
      approvedAt: json['approved_at'] != null ? DateTime.parse(json['approved_at']) : null,
      attachment: json['attachment'],
      createdAt: json['created_at'] != null ? DateTime.parse(json['created_at']) : DateTime.now(),
      updatedAt: json['updated_at'] != null ? DateTime.parse(json['updated_at']) : DateTime.now(),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'karyawan_id': karyawanId,
      'leave_type': leaveType,
      'start_date': startDate.toIso8601String(),
      'end_date': endDate.toIso8601String(),
      'number_of_days': numberOfDays,
      'reason': reason,
      'status': status,
      'rejection_reason': rejectionReason,
      'approved_by': approvedBy,
      'approved_at': approvedAt?.toIso8601String(),
      'attachment': attachment,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }
}
