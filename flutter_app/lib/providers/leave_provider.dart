import 'package:flutter/material.dart';
import 'package:logger/logger.dart';
import '../models/index.dart';
import '../services/api_service.dart';

class LeaveProvider extends ChangeNotifier {
  final ApiService _apiService;
  final Logger _logger = Logger();

  List<Leave> _leaveList = [];
  Leave? _selectedLeave;
  bool _isLoading = false;
  String? _errorMessage;
  int _currentPage = 1;
  int _totalPages = 1;

  // Getters
  List<Leave> get leaveList => _leaveList;
  Leave? get selectedLeave => _selectedLeave;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;

  LeaveProvider({required ApiService apiService}) : _apiService = apiService;

  Future<void> getLeaveList({
    int page = 1,
    int perPage = 10,
    String? status,
    String? type,
  }) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await _apiService.getLeaveList(
        page: page,
        perPage: perPage,
        status: status,
        type: type,
      );

      _leaveList = response.data;
      _currentPage = response.currentPage;
      _totalPages = response.lastPage;

      _isLoading = false;
      notifyListeners();
    } catch (e) {
      _errorMessage = 'Failed to load leaves: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Get Leave List Error: $e');
    }
  }

  Future<bool> getLeaveDetail(int id) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final leave = await _apiService.getLeaveDetail(id);
      if (leave != null) {
        _selectedLeave = leave;
        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = 'Leave not found';
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Failed to load leave detail: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Get Leave Detail Error: $e');
      return false;
    }
  }

  Future<bool> createLeave(Map<String, dynamic> data) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await _apiService.createLeave(data);
      if (response.success && response.data != null) {
        _leaveList.insert(0, response.data!);
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
      _errorMessage = 'Failed to create leave: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Create Leave Error: $e');
      return false;
    }
  }

  Future<bool> approveLeave(int id) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final success = await _apiService.approveLeave(id);
      if (success) {
        int index = _leaveList.indexWhere((l) => l.id == id);
        if (index != -1) {
          _leaveList[index] = _leaveList[index].copyWith(status: 'approved');
        }
        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = 'Failed to approve leave';
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Failed to approve leave: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Approve Leave Error: $e');
      return false;
    }
  }

  Future<bool> rejectLeave(int id, String reason) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final success = await _apiService.rejectLeave(id, reason);
      if (success) {
        int index = _leaveList.indexWhere((l) => l.id == id);
        if (index != -1) {
          _leaveList[index] = _leaveList[index].copyWith(
            status: 'rejected',
            rejectionReason: reason,
          );
        }
        _isLoading = false;
        notifyListeners();
        return true;
      } else {
        _errorMessage = 'Failed to reject leave';
        _isLoading = false;
        notifyListeners();
        return false;
      }
    } catch (e) {
      _errorMessage = 'Failed to reject leave: $e';
      _isLoading = false;
      notifyListeners();
      _logger.e('Reject Leave Error: $e');
      return false;
    }
  }

  void clearError() {
    _errorMessage = null;
    notifyListeners();
  }

  void clearSelected() {
    _selectedLeave = null;
    notifyListeners();
  }

  // CopyWith method for Leave (helper)
  Leave _copyWithLeaveStatus(Leave leave, {required String status, String? reason}) {
    return Leave(
      id: leave.id,
      karyawanId: leave.karyawanId,
      leaveType: leave.leaveType,
      startDate: leave.startDate,
      endDate: leave.endDate,
      numberOfDays: leave.numberOfDays,
      reason: leave.reason,
      status: status,
      rejectionReason: reason ?? leave.rejectionReason,
      approvedBy: leave.approvedBy,
      approvedAt: leave.approvedAt,
      attachment: leave.attachment,
      createdAt: leave.createdAt,
      updatedAt: leave.updatedAt,
    );
  }
}
