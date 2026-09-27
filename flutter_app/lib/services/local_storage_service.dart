import 'package:shared_preferences/shared_preferences.dart';

class LocalStorageService {
  static const String _authTokenKey = 'auth_token';
  static const String _userDataKey = 'user_data';
  static const String _userRoleKey = 'user_role';
  static const String _rememberMeKey = 'remember_me';
  static const String _emailKey = 'saved_email';

  late SharedPreferences _prefs;

  Future<void> init() async {
    _prefs = await SharedPreferences.getInstance();
  }

  // Auth Token
  Future<bool> saveAuthToken(String token) async {
    return await _prefs.setString(_authTokenKey, token);
  }

  String? getAuthToken() {
    return _prefs.getString(_authTokenKey);
  }

  Future<bool> removeAuthToken() async {
    return await _prefs.remove(_authTokenKey);
  }

  // User Data
  Future<bool> saveUserData(String userData) async {
    return await _prefs.setString(_userDataKey, userData);
  }

  String? getUserData() {
    return _prefs.getString(_userDataKey);
  }

  Future<bool> removeUserData() async {
    return await _prefs.remove(_userDataKey);
  }

  // User Role
  Future<bool> saveUserRole(String role) async {
    return await _prefs.setString(_userRoleKey, role);
  }

  String? getUserRole() {
    return _prefs.getString(_userRoleKey);
  }

  // Remember Me
  Future<bool> saveRememberMe(bool rememberMe) async {
    return await _prefs.setBool(_rememberMeKey, rememberMe);
  }

  bool getRememberMe() {
    return _prefs.getBool(_rememberMeKey) ?? false;
  }

  // Saved Email
  Future<bool> saveSavedEmail(String email) async {
    return await _prefs.setString(_emailKey, email);
  }

  String? getSavedEmail() {
    return _prefs.getString(_emailKey);
  }

  // Clear All
  Future<bool> clearAll() async {
    return await _prefs.clear();
  }

  // Logout (clear sensitive data)
  Future<bool> logout() async {
    await removeAuthToken();
    await removeUserData();
    return true;
  }
}
