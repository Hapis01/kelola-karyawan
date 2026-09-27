import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'package:logger/logger.dart';
import '../models/index.dart';

class ApiService {
  static const String baseUrl = 'http://localhost:8000/api'; // Change to your Laravel URL
  static const String timeout = '30';

  final Logger _logger = Logger();
  late SharedPreferences _prefs;
  String? _token;

  ApiService() {
    _initPrefs();
  }

  Future<void> _initPrefs() async {
    _prefs = await SharedPreferences.getInstance();
    _token = _prefs.getString('auth_token');
  }

  Map<String, String> _getHeaders({bool isMultipart = false}) {
    Map<String, String> headers = {
      'Accept': 'application/json',
      'Content-Type': isMultipart ? 'multipart/form-data' : 'application/json',
    };

    if (_token != null) {
      headers['Authorization'] = 'Bearer $_token';
    }

    return headers;
  }

  void setToken(String token) {
    _token = token;
    _prefs.setString('auth_token', token);
  }

  void clearToken() {
    _token = null;
    _prefs.remove('auth_token');
  }

  String? getToken() => _token;

  // ============ AUTH ENDPOINTS ============

  Future<AuthResponse> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/auth/register'),
        headers: _getHeaders(),
        body: jsonEncode({
          'name': name,
          'email': email,
          'password': password,
          'password_confirmation': passwordConfirmation,
        }),
      ).timeout(const Duration(seconds: 30));

      _logger.i('Register Response: ${response.statusCode}');

      if (response.statusCode == 201 || response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return AuthResponse.fromJson(data);
      } else {
        final data = jsonDecode(response.body);
        return AuthResponse(
          success: false,
          message: data['message'] ?? 'Registration failed',
        );
      }
    } catch (e) {
      _logger.e('Register Error: $e');
      return AuthResponse(
        success: false,
        message: 'Network error: $e',
      );
    }
  }

  Future<AuthResponse> login({
    required String email,
    required String password,
  }) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/auth/login'),
        headers: _getHeaders(),
        body: jsonEncode({
          'email': email,
          'password': password,
        }),
      ).timeout(const Duration(seconds: 30));

      _logger.i('Login Response: ${response.statusCode}');

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        if (data['token'] != null) {
          setToken(data['token']);
        }
        return AuthResponse.fromJson(data);
      } else {
        final data = jsonDecode(response.body);
        return AuthResponse(
          success: false,
          message: data['message'] ?? 'Login failed',
        );
      }
    } catch (e) {
      _logger.e('Login Error: $e');
      return AuthResponse(
        success: false,
        message: 'Network error: $e',
      );
    }
  }

  Future<bool> logout() async {
    try {
      await http.post(
        Uri.parse('$baseUrl/auth/logout'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      clearToken();
      return true;
    } catch (e) {
      _logger.e('Logout Error: $e');
      clearToken();
      return false;
    }
  }

  Future<User?> getCurrentUser() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/auth/user'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return User.fromJson(data['data'] ?? data['user'] ?? data);
      }
      return null;
    } catch (e) {
      _logger.e('Get Current User Error: $e');
      return null;
    }
  }

  // ============ KARYAWAN ENDPOINTS ============

  Future<PaginatedResponse<Karyawan>> getKaryawanList({
    int page = 1,
    int perPage = 10,
    String? search,
    String? department,
    String? position,
    String? status,
  }) async {
    try {
      Map<String, String> params = {
        'page': page.toString(),
        'per_page': perPage.toString(),
      };

      if (search != null && search.isNotEmpty) params['search'] = search;
      if (department != null && department.isNotEmpty) params['department'] = department;
      if (position != null && position.isNotEmpty) params['position'] = position;
      if (status != null && status.isNotEmpty) params['status'] = status;

      final uri = Uri.parse('$baseUrl/karyawan').replace(queryParameters: params);
      final response = await http.get(uri, headers: _getHeaders())
          .timeout(const Duration(seconds: 30));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return PaginatedResponse.fromJson(data['data'] ?? data, (json) => Karyawan.fromJson(json));
      }
      return PaginatedResponse(data: [], currentPage: 1, lastPage: 1, perPage: 10, total: 0);
    } catch (e) {
      _logger.e('Get Karyawan List Error: $e');
      return PaginatedResponse(data: [], currentPage: 1, lastPage: 1, perPage: 10, total: 0);
    }
  }

  Future<Karyawan?> getKaryawanDetail(int id) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/karyawan/$id'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return Karyawan.fromJson(data['data'] ?? data);
      }
      return null;
    } catch (e) {
      _logger.e('Get Karyawan Detail Error: $e');
      return null;
    }
  }

  Future<ApiResponse<Karyawan>> createKaryawan(Map<String, dynamic> data) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/karyawan'),
        headers: _getHeaders(),
        body: jsonEncode(data),
      ).timeout(const Duration(seconds: 30));

      if (response.statusCode == 201 || response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        return ApiResponse.fromJson(
          responseData,
          (json) => Karyawan.fromJson(json),
        );
      } else {
        final responseData = jsonDecode(response.body);
        return ApiResponse(
          success: false,
          message: responseData['message'] ?? 'Failed to create karyawan',
          statusCode: response.statusCode,
        );
      }
    } catch (e) {
      _logger.e('Create Karyawan Error: $e');
      return ApiResponse(
        success: false,
        message: 'Network error: $e',
      );
    }
  }

  Future<ApiResponse<Karyawan>> updateKaryawan(int id, Map<String, dynamic> data) async {
    try {
      final response = await http.put(
        Uri.parse('$baseUrl/karyawan/$id'),
        headers: _getHeaders(),
        body: jsonEncode(data),
      ).timeout(const Duration(seconds: 30));

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        return ApiResponse.fromJson(
          responseData,
          (json) => Karyawan.fromJson(json),
        );
      } else {
        final responseData = jsonDecode(response.body);
        return ApiResponse(
          success: false,
          message: responseData['message'] ?? 'Failed to update karyawan',
          statusCode: response.statusCode,
        );
      }
    } catch (e) {
      _logger.e('Update Karyawan Error: $e');
      return ApiResponse(
        success: false,
        message: 'Network error: $e',
      );
    }
  }

  Future<bool> deleteKaryawan(int id) async {
    try {
      final response = await http.delete(
        Uri.parse('$baseUrl/karyawan/$id'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      return response.statusCode == 200 || response.statusCode == 204;
    } catch (e) {
      _logger.e('Delete Karyawan Error: $e');
      return false;
    }
  }

  // ============ LEAVE ENDPOINTS ============

  Future<PaginatedResponse<Leave>> getLeaveList({
    int page = 1,
    int perPage = 10,
    String? status,
    String? type,
  }) async {
    try {
      Map<String, String> params = {
        'page': page.toString(),
        'per_page': perPage.toString(),
      };

      if (status != null && status.isNotEmpty) params['status'] = status;
      if (type != null && type.isNotEmpty) params['type'] = type;

      final uri = Uri.parse('$baseUrl/leaves').replace(queryParameters: params);
      final response = await http.get(uri, headers: _getHeaders())
          .timeout(const Duration(seconds: 30));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return PaginatedResponse.fromJson(data['data'] ?? data, (json) => Leave.fromJson(json));
      }
      return PaginatedResponse(data: [], currentPage: 1, lastPage: 1, perPage: 10, total: 0);
    } catch (e) {
      _logger.e('Get Leave List Error: $e');
      return PaginatedResponse(data: [], currentPage: 1, lastPage: 1, perPage: 10, total: 0);
    }
  }

  Future<Leave?> getLeaveDetail(int id) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/leaves/$id'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return Leave.fromJson(data['data'] ?? data);
      }
      return null;
    } catch (e) {
      _logger.e('Get Leave Detail Error: $e');
      return null;
    }
  }

  Future<ApiResponse<Leave>> createLeave(Map<String, dynamic> data) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/leaves'),
        headers: _getHeaders(),
        body: jsonEncode(data),
      ).timeout(const Duration(seconds: 30));

      if (response.statusCode == 201 || response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        return ApiResponse.fromJson(
          responseData,
          (json) => Leave.fromJson(json),
        );
      } else {
        final responseData = jsonDecode(response.body);
        return ApiResponse(
          success: false,
          message: responseData['message'] ?? 'Failed to create leave',
          statusCode: response.statusCode,
        );
      }
    } catch (e) {
      _logger.e('Create Leave Error: $e');
      return ApiResponse(
        success: false,
        message: 'Network error: $e',
      );
    }
  }

  Future<bool> approveLeave(int id) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/leaves/$id/approve'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      return response.statusCode == 200;
    } catch (e) {
      _logger.e('Approve Leave Error: $e');
      return false;
    }
  }

  Future<bool> rejectLeave(int id, String reason) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/leaves/$id/reject'),
        headers: _getHeaders(),
        body: jsonEncode({'reason': reason}),
      ).timeout(const Duration(seconds: 30));

      return response.statusCode == 200;
    } catch (e) {
      _logger.e('Reject Leave Error: $e');
      return false;
    }
  }

  // ============ TRAINING ENDPOINTS ============

  Future<PaginatedResponse<Training>> getTrainingList({
    int page = 1,
    int perPage = 10,
    String? status,
  }) async {
    try {
      Map<String, String> params = {
        'page': page.toString(),
        'per_page': perPage.toString(),
      };

      if (status != null && status.isNotEmpty) params['status'] = status;

      final uri = Uri.parse('$baseUrl/trainings').replace(queryParameters: params);
      final response = await http.get(uri, headers: _getHeaders())
          .timeout(const Duration(seconds: 30));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return PaginatedResponse.fromJson(data['data'] ?? data, (json) => Training.fromJson(json));
      }
      return PaginatedResponse(data: [], currentPage: 1, lastPage: 1, perPage: 10, total: 0);
    } catch (e) {
      _logger.e('Get Training List Error: $e');
      return PaginatedResponse(data: [], currentPage: 1, lastPage: 1, perPage: 10, total: 0);
    }
  }

  Future<Training?> getTrainingDetail(int id) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/trainings/$id'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return Training.fromJson(data['data'] ?? data);
      }
      return null;
    } catch (e) {
      _logger.e('Get Training Detail Error: $e');
      return null;
    }
  }

  Future<bool> enrollTraining(int trainingId) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/trainings/$trainingId/enroll'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      return response.statusCode == 200 || response.statusCode == 201;
    } catch (e) {
      _logger.e('Enroll Training Error: $e');
      return false;
    }
  }

  Future<bool> cancelTrainingEnrollment(int trainingId) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/trainings/$trainingId/cancel'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      return response.statusCode == 200;
    } catch (e) {
      _logger.e('Cancel Training Error: $e');
      return false;
    }
  }

  // ============ DASHBOARD ENDPOINTS ============

  Future<Map<String, dynamic>?> getDashboardStats() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/dashboard/stats'),
        headers: _getHeaders(),
      ).timeout(const Duration(seconds: 30));

      if (response.statusCode == 200) {
        return jsonDecode(response.body)['data'] ?? jsonDecode(response.body);
      }
      return null;
    } catch (e) {
      _logger.e('Get Dashboard Stats Error: $e');
      return null;
    }
  }
}
