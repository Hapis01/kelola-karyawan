# 🚀 Quick Start Guide - Flutter App

## 5 Menit Setup

### Step 1: Install Dependencies
```bash
cd flutter_app
flutter pub get
```

### Step 2: Update API URL
Edit `lib/services/api_service.dart`:
```dart
static const String baseUrl = 'http://YOUR_SERVER:8000/api';
```

### Step 3: Run App
```bash
flutter run
```

## 📱 Testing User Accounts

### Admin Account
```
Email: admin@example.com
Password: password123
```

### Employee Account
```
Email: employee@example.com
Password: password123
```

## 🎯 Key Screens

1. **Landing Page** → `/landing`
   - Welcome screen dengan feature list
   - Login & Register buttons

2. **Login** → `/login`
   - Email & password input
   - Remember me checkbox

3. **Admin Dashboard** → `/admin-dashboard`
   - Stats cards
   - Quick action menu

4. **Employee Dashboard** → `/karyawan-dashboard`
   - Personal stats
   - Menu untuk semua fitur

## 🔧 Core Features

### Authentication
- ✅ Register user
- ✅ Login dengan token
- ✅ Logout
- ✅ Auto-redirect berdasarkan role

### Admin Panel
- ✅ Employee list dengan search & filter
- ✅ Employee CRUD
- ✅ Leave approval/rejection
- ✅ Dashboard statistics

### Employee Dashboard
- ✅ Personal dashboard
- ✅ Profile management
- ✅ Leave request
- ✅ Training enrollment

## 📊 Database Connection

Data otomatis tersinkronisasi dengan MySQL database via Laravel API:

```
App → API Request → Laravel → MySQL Database → Response → App
```

## 🐛 Troubleshooting

### API Connection Error
```bash
# Check if Laravel backend running
# Check URL di api_service.dart
# Check CORS settings di backend
```

### Build Error
```bash
flutter clean
flutter pub get
flutter run
```

### Port Already in Use
```bash
# Change API port di api_service.dart
# atau
lsof -i :8000  # Check port usage
```

## 📁 Important Files to Modify

1. **API Configuration**
   - Location: `lib/services/api_service.dart`
   - Change: `static const String baseUrl`

2. **App Theme**
   - Location: `lib/utils/theme.dart`
   - Change: Colors, fonts, dimensions

3. **Routes Configuration**
   - Location: `lib/main.dart`
   - Add/modify: Route definitions

## 🚀 Deploy to Device

### Android
```bash
flutter run -d <device-name>
flutter build apk --release
```

### iOS
```bash
flutter run -d <device-name>
flutter build ios --release
```

### Web
```bash
flutter run -d chrome
flutter build web
```

## 📚 API Response Format

Semua API responses follow format:
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { /* actual data */ },
  "token": "token_string" // for auth endpoints
}
```

## 🔑 State Management

Aplikasi menggunakan **Provider** package:

```dart
// Access auth state
final auth = context.read<AuthProvider>();

// Listen to changes
Consumer<AuthProvider>(
  builder: (context, auth, _) {
    return Text(auth.currentUser?.name ?? 'Guest');
  }
)
```

## 💾 Local Storage

Data disimpan dengan **SharedPreferences**:

```dart
final storage = LocalStorageService();
await storage.saveAuthToken(token);
final token = storage.getAuthToken();
```

## 🔐 Token Management

Token automatically:
1. Saved di local storage after login
2. Attached ke setiap API request
3. Cleared saat logout
4. Validated di splash screen

## 📱 Responsive Design

App automatically adapts to:
- Mobile phones (portrait & landscape)
- Tablets
- Web browsers

Using:
- `MediaQuery` untuk responsive values
- `SingleChildScrollView` untuk scrollable content
- `GridView` & `ListView` untuk list items

## 🎨 UI Customization

### Change Theme Color
```dart
// lib/utils/theme.dart
static const Color primaryColor = Color(0xFF2196F3); // Change this
```

### Modify Text Styles
```dart
// lib/utils/theme.dart → AppStyles class
static const TextStyle customStyle = TextStyle(
  fontSize: 16,
  fontWeight: FontWeight.bold,
);
```

## 📈 Performance Tips

1. Use `const` constructors
2. Implement pagination untuk list
3. Lazy load images
4. Cache API responses
5. Use `SingleChildScrollView` bukan `Column` untuk many items

## 🚨 Error Handling

App includes automatic error handling:
- Network errors
- Validation errors
- API errors
- Authentication errors

Check `errorMessage` di providers untuk error details.

## 📞 API Endpoints Used

```
POST   /api/auth/register
POST   /api/auth/login
GET    /api/auth/user
POST   /api/auth/logout

GET    /api/karyawan
POST   /api/karyawan
PUT    /api/karyawan/{id}
DELETE /api/karyawan/{id}

GET    /api/leaves
POST   /api/leaves
POST   /api/leaves/{id}/approve
POST   /api/leaves/{id}/reject

GET    /api/trainings
POST   /api/trainings/{id}/enroll
POST   /api/trainings/{id}/cancel

GET    /api/dashboard/stats
```

## ✨ Features Checklist

- [x] Landing page
- [x] Authentication (register/login)
- [x] Admin dashboard
- [x] Employee management
- [x] Leave management
- [x] Employee dashboard
- [ ] Training screens (in development)
- [ ] Profile management (in development)
- [ ] Notifications (coming soon)
- [ ] Offline support (coming soon)

## 🎓 Learning Resources

- Flutter Docs: https://flutter.dev/docs
- Provider Package: https://pub.dev/packages/provider
- HTTP Package: https://pub.dev/packages/http
- Dart Language: https://dart.dev/guides

## 🤔 FAQ

**Q: How to change app name?**
A: Edit `pubspec.yaml` → `name: new_name`

**Q: How to add new screen?**
A:
1. Create file di `lib/screens/`
2. Add route di `lib/main.dart`
3. Add navigation di button

**Q: How to modify API response?**
A: Update model di `lib/models/`

**Q: How to change colors?**
A: Edit `lib/utils/theme.dart` → `AppTheme` class

## 📞 Support

For issues or questions:
1. Check `flutter doctor` output
2. Review error messages di console
3. Check API responses di network tab
4. Read documentation files

---

**Happy Coding! 🎉**

**Version**: 1.0.0
**Last Updated**: December 10, 2024
