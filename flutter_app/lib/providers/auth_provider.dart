import 'package:flutter/material.dart';
import 'package:logger/logger.dart';
import '../models/index.dart';
import '../services/index.dart';

class AuthProvider extends ChangeNotifier {
  final ApiService _apiService;
  final LocalStorageService _storageService;
  final Logger _logger = Logger();

  User? _currentUser;
  String? _token;
  bool _isLoading = false;
  bool _isLoggedIn = false;
  String? _errorMessage;

  // Getters
  User? get currentUser => _currentUser;
  String? get token => _token;
  bool get isLoading => _isLoading;
  bool get isLoggedIn => _isLoggedIn;
  String? get errorMessage => _errorMessage;

  AuthProvider({
    required ApiService apiService,
    required LocalStorageService storageService,
  })  : _apiService = apiService,
        _storageService = storageService;

  Future<void> initialize() async {
    _token = _storageService.getAuthToken();
    if (_token != null) {
      _apiService.setToken(_token!);
      await getCurrentUser();
    }
  }

  Future<bool> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
  }) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await _apiService.register(
        name: name,
        email: email,
        password: password,
        passwordConfirmation: passwordConfirmation,
      );

      if (response.success && response.token != null && response.user != null) {
        _token = response.token;
        _currentUser = response.user;
        _isLoggedIn = true;

        await _storageService.saveAuthToken(response.token!);
        _apiService.setToken(response.token!);

        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = response.message;
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Registration failed: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Register Error: $e');
      return false;
    }
  }

  Future<bool> login({
    required String email,
    required String password,
    bool rememberMe = false,
  }) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await _apiService.login(
        email: email,
        password: password,
      );

      if (response.success && response.token != null && response.user != null) {
        _token = response.token;
        _currentUser = response.user;
        _isLoggedIn = true;

        await _storageService.saveAuthToken(response.token!);
        await _storageService.saveUserRole(response.user!.role);
        if (rememberMe) {
          await _storageService.saveSavedEmail(email);
        }

        _apiService.setToken(response.token!);

        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = response.message;
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Login failed: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Login Error: $e');
      return false;
    }
  }

  Future<void> logout() async {
    _isLoading = true;
    notifyListeners();

    try {
      await _apiService.logout();
      await _storageService.logout();

      _currentUser = null;
      _token = null;
      _isLoggedIn = false;
      _errorMessage = null;
    } catch (e) {
      _logger.e('Logout Error: $e');
    }

    _isLoading = false;
    notifyListeners();
  }

  Future<bool> getCurrentUser() async {
    try {
      final user = await _apiService.getCurrentUser();
      if (user != null) {
        _currentUser = user;
        _isLoggedIn = true;
        await _storageService.saveUserRole(user.role);
        notifyListeners();
        return true;
      } else {
        _isLoggedIn = false;
        await logout();
        return false;
      }
    } catch (e) {
      _logger.e('Get Current User Error: $e');
      _isLoggedIn = false;
      return false;
    }
  }

  bool isAdmin() => _currentUser?.role == 'admin';
  bool isKaryawan() => _currentUser?.role == 'karyawan';

  void clearError() {
    _errorMessage = null;
    notifyListeners();
  }
}
