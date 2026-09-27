class Training {
  final int id;
  final String name;
  final String description;
  final String provider;
  final String? location;
  final DateTime startDate;
  final DateTime endDate;
  final String? certificateUrl;
  final int? certificateFileId;
  final bool isRequired;
  final String status; // draft, active, completed, cancelled
  final DateTime createdAt;
  final DateTime updatedAt;

  Training({
    required this.id,
    required this.name,
    required this.description,
    required this.provider,
    this.location,
    required this.startDate,
    required this.endDate,
    this.certificateUrl,
    this.certificateFileId,
    required this.isRequired,
    required this.status,
    required this.createdAt,
    required this.updatedAt,
  });

  factory Training.fromJson(Map<String, dynamic> json) {
    return Training(
      id: json['id'] ?? 0,
      name: json['name'] ?? '',
      description: json['description'] ?? '',
      provider: json['provider'] ?? '',
      location: json['location'],
      startDate: json['start_date'] != null ? DateTime.parse(json['start_date']) : DateTime.now(),
      endDate: json['end_date'] != null ? DateTime.parse(json['end_date']) : DateTime.now(),
      certificateUrl: json['certificate_url'],
      certificateFileId: json['certificate_file_id'],
      isRequired: json['is_required'] ?? false,
      status: json['status'] ?? 'draft',
      createdAt: json['created_at'] != null ? DateTime.parse(json['created_at']) : DateTime.now(),
      updatedAt: json['updated_at'] != null ? DateTime.parse(json['updated_at']) : DateTime.now(),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'provider': provider,
      'location': location,
      'start_date': startDate.toIso8601String(),
      'end_date': endDate.toIso8601String(),
      'certificate_url': certificateUrl,
      'certificate_file_id': certificateFileId,
      'is_required': isRequired,
      'status': status,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }
}

class TrainingParticipant {
  final int id;
  final int trainingId;
  final int karyawanId;
  final String status; // pending, enrolled, completed, cancelled
  final String? certificateNumber;
  final DateTime? completedAt;
  final DateTime createdAt;
  final DateTime updatedAt;

  TrainingParticipant({
    required this.id,
    required this.trainingId,
    required this.karyawanId,
    required this.status,
    this.certificateNumber,
    this.completedAt,
    required this.createdAt,
    required this.updatedAt,
  });

  factory TrainingParticipant.fromJson(Map<String, dynamic> json) {
    return TrainingParticipant(
      id: json['id'] ?? 0,
      trainingId: json['training_id'] ?? 0,
      karyawanId: json['karyawan_id'] ?? 0,
      status: json['status'] ?? 'pending',
      certificateNumber: json['certificate_number'],
      completedAt: json['completed_at'] != null ? DateTime.parse(json['completed_at']) : null,
      createdAt: json['created_at'] != null ? DateTime.parse(json['created_at']) : DateTime.now(),
      updatedAt: json['updated_at'] != null ? DateTime.parse(json['updated_at']) : DateTime.now(),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'training_id': trainingId,
      'karyawan_id': karyawanId,
      'status': status,
      'certificate_number': certificateNumber,
      'completed_at': completedAt?.toIso8601String(),
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }
}
