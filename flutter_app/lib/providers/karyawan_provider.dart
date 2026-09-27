import 'package:flutter/material.dart';
import 'package:logger/logger.dart';
import '../models/index.dart';
import '../services/api_service.dart';

class KaryawanProvider extends ChangeNotifier {
  final ApiService _apiService;
  final Logger _logger = Logger();

  List<Karyawan> _karyawanList = [];
  Karyawan? _selectedKaryawan;
  bool _isLoading = false;
  String? _errorMessage;
  int _currentPage = 1;
  int _totalPages = 1;
  int _totalItems = 0;

  // Getters
  List<Karyawan> get karyawanList => _karyawanList;
  Karyawan? get selectedKaryawan => _selectedKaryawan;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;
  int get currentPage => _currentPage;
  int get totalPages => _totalPages;
  int get totalItems => _totalItems;

  KaryawanProvider({required ApiService apiService}) : _apiService = apiService;

  Future<void> getKaryawanList({
    int page = 1,
    int perPage = 10,
    String? search,
    String? department,
    String? position,
    String? status,
  }) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await _apiService.getKaryawanList(
        page: page,
        perPage: perPage,
        search: search,
        department: department,
        position: position,
        status: status,
      );

      _karyawanList = response.data;
      _currentPage = response.currentPage;
      _totalPages = response.lastPage;
      _totalItems = response.total;

      _isLoading = false;
      notifyListeners();
    } catch (e) {
      _errorMessage = 'Failed to load karyawan: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Get Karyawan List Error: $e');
    }
  }

  Future<bool> getKaryawanDetail(int id) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final karyawan = await _apiService.getKaryawanDetail(id);
      if (karyawan != null) {
        _selectedKaryawan = karyawan;
        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = 'Karyawan not found';
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Failed to load karyawan detail: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Get Karyawan Detail Error: $e');
      return false;
    }
  }

  Future<bool> createKaryawan(Map<String, dynamic> data) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await _apiService.createKaryawan(data);
      if (response.success && response.data != null) {
        _karyawanList.insert(0, response.data!);
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
      _errorMessage = 'Failed to create karyawan: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Create Karyawan Error: $e');
      return false;
    }
  }

  Future<bool> updateKaryawan(int id, Map<String, dynamic> data) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await _apiService.updateKaryawan(id, data);
      if (response.success && response.data != null) {
        int index = _karyawanList.indexWhere((k) => k.id == id);
        if (index != -1) {
          _karyawanList[index] = response.data!;
        }
        _selectedKaryawan = response.data;
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
      _errorMessage = 'Failed to update karyawan: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Update Karyawan Error: $e');
      return false;
    }
  }

  Future<bool> deleteKaryawan(int id) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final success = await _apiService.deleteKaryawan(id);
      if (success) {
        _karyawanList.removeWhere((k) => k.id == id);
        if (_selectedKaryawan?.id == id) {
          _selectedKaryawan = null;
        }
        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = 'Failed to delete karyawan';
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Failed to delete karyawan: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Delete Karyawan Error: $e');
      return false;
    }
  }

  void clearError() {
    _errorMessage = null;
    notifyListeners();
  }

  void clearSelected() {
    _selectedKaryawan = null;
    notifyListeners();
  }
}
