import 'package:flutter/material.dart';
import 'package:logger/logger.dart';
import '../models/index.dart';
import '../services/api_service.dart';

class TrainingProvider extends ChangeNotifier {
  final ApiService _apiService;
  final Logger _logger = Logger();

  List<Training> _trainingList = [];
  Training? _selectedTraining;
  bool _isLoading = false;
  String? _errorMessage;
  int _currentPage = 1;
  int _totalPages = 1;

  // Getters
  List<Training> get trainingList => _trainingList;
  Training? get selectedTraining => _selectedTraining;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;

  TrainingProvider({required ApiService apiService}) : _apiService = apiService;

  Future<void> getTrainingList({
    int page = 1,
    int perPage = 10,
    String? status,
  }) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await _apiService.getTrainingList(
        page: page,
        perPage: perPage,
        status: status,
      );

      _trainingList = response.data;
      _currentPage = response.currentPage;
      _totalPages = response.lastPage;

      _isLoading = false;
      notifyListeners();
    } catch (e) {
      _errorMessage = 'Failed to load trainings: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Get Training List Error: $e');
    }
  }

  Future<bool> getTrainingDetail(int id) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final training = await _apiService.getTrainingDetail(id);
      if (training != null) {
        _selectedTraining = training;
        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = 'Training not found';
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Failed to load training detail: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Get Training Detail Error: $e');
      return false;
    }
  }

  Future<bool> enrollTraining(int trainingId) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final success = await _apiService.enrollTraining(trainingId);
      if (success) {
        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = 'Failed to enroll training';
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Failed to enroll training: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Enroll Training Error: $e');
      return false;
    }
  }

  Future<bool> cancelTrainingEnrollment(int trainingId) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final success = await _apiService.cancelTrainingEnrollment(trainingId);
      if (success) {
        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = 'Failed to cancel enrollment';
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Failed to cancel enrollment: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Cancel Training Error: $e');
      return false;
    }
  }

  void clearError() {
    _errorMessage = null;
    notifyListeners();
  }

  void clearSelected() {
    _selectedTraining = null;
    notifyListeners();
  }
}
