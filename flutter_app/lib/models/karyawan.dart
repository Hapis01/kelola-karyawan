class Karyawan {
  final int id;
  final int userId;
  final String nip;
  final String name;
  final String email;
  final String? phone;
  final String? photo;
  final String gender;
  final String? birthDate;
  final String? birthPlace;
  final String address;
  final String? city;
  final String? province;
  final String? postalCode;
  final String? idNumber;
  final String? bankAccount;
  final String? bankName;
  final String department;
  final String position;
  final String? jurusan;
  final String status; // tetap, kontrak
  final DateTime? joinDate;
  final DateTime? resignDate;
  final bool isActive;
  final DateTime createdAt;
  final DateTime updatedAt;

  Karyawan({
    required this.id,
    required this.userId,
    required this.nip,
    required this.name,
    required this.email,
    this.phone,
    this.photo,
    required this.gender,
    this.birthDate,
    this.birthPlace,
    required this.address,
    this.city,
    this.province,
    this.postalCode,
    this.idNumber,
    this.bankAccount,
    this.bankName,
    required this.department,
    required this.position,
    this.jurusan,
    required this.status,
    this.joinDate,
    this.resignDate,
    required this.isActive,
    required this.createdAt,
    required this.updatedAt,
  });

  factory Karyawan.fromJson(Map<String, dynamic> json) {
    return Karyawan(
      id: json['id'] ?? 0,
      userId: json['user_id'] ?? 0,
      nip: json['nip'] ?? '',
      name: json['name'] ?? '',
      email: json['email'] ?? '',
      phone: json['phone'],
      photo: json['photo'],
      gender: json['gender'] ?? '',
      birthDate: json['birth_date'],
      birthPlace: json['birth_place'],
      address: json['address'] ?? '',
      city: json['city'],
      province: json['province'],
      postalCode: json['postal_code'],
      idNumber: json['id_number'],
      bankAccount: json['bank_account'],
      bankName: json['bank_name'],
      department: json['department'] ?? '',
      position: json['position'] ?? '',
      jurusan: json['jurusan'],
      status: json['status'] ?? 'tetap',
      joinDate: json['join_date'] != null ? DateTime.parse(json['join_date']) : null,
      resignDate: json['resign_date'] != null ? DateTime.parse(json['resign_date']) : null,
      isActive: json['is_active'] ?? true,
      createdAt: json['created_at'] != null ? DateTime.parse(json['created_at']) : DateTime.now(),
      updatedAt: json['updated_at'] != null ? DateTime.parse(json['updated_at']) : DateTime.now(),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'user_id': userId,
      'nip': nip,
      'name': name,
      'email': email,
      'phone': phone,
      'photo': photo,
      'gender': gender,
      'birth_date': birthDate,
      'birth_place': birthPlace,
      'address': address,
      'city': city,
      'province': province,
      'postal_code': postalCode,
      'id_number': idNumber,
      'bank_account': bankAccount,
      'bank_name': bankName,
      'department': department,
      'position': position,
      'jurusan': jurusan,
      'status': status,
      'join_date': joinDate?.toIso8601String(),
      'resign_date': resignDate?.toIso8601String(),
      'is_active': isActive,
      'created_at': createdAt.toIso8601String(),
      'updated_at': updatedAt.toIso8601String(),
    };
  }

  Karyawan copyWith({
    int? id,
    int? userId,
    String? nip,
    String? name,
    String? email,
    String? phone,
    String? photo,
    String? gender,
    String? birthDate,
    String? birthPlace,
    String? address,
    String? city,
    String? province,
    String? postalCode,
    String? idNumber,
    String? bankAccount,
    String? bankName,
    String? department,
    String? position,
    String? jurusan,
    String? status,
    DateTime? joinDate,
    DateTime? resignDate,
    bool? isActive,
    DateTime? createdAt,
    DateTime? updatedAt,
  }) {
    return Karyawan(
      id: id ?? this.id,
      userId: userId ?? this.userId,
      nip: nip ?? this.nip,
      name: name ?? this.name,
      email: email ?? this.email,
      phone: phone ?? this.phone,
      photo: photo ?? this.photo,
      gender: gender ?? this.gender,
      birthDate: birthDate ?? this.birthDate,
      birthPlace: birthPlace ?? this.birthPlace,
      address: address ?? this.address,
      city: city ?? this.city,
      province: province ?? this.province,
      postalCode: postalCode ?? this.postalCode,
      idNumber: idNumber ?? this.idNumber,
      bankAccount: bankAccount ?? this.bankAccount,
      bankName: bankName ?? this.bankName,
      department: department ?? this.department,
      position: position ?? this.position,
      jurusan: jurusan ?? this.jurusan,
      status: status ?? this.status,
      joinDate: joinDate ?? this.joinDate,
      resignDate: resignDate ?? this.resignDate,
      isActive: isActive ?? this.isActive,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
    );
  }
}
