# Flutter App - Kelola Karyawan

Aplikasi Flutter untuk sistem manajemen karyawan yang terintegrasi dengan backend Laravel.

## Fitur

- **Login & Register**: Autentikasi pengguna dengan Sanctum tokens
- **Landing Page**: Halaman penyambutan dengan daftar fitur
- **Admin Dashboard**:
  - Statistik karyawan
  - Manajemen data karyawan (CRUD)
  - Manajemen cuti/leave
  - Manajemen training
- **Karyawan Dashboard**:
  - Profile management
  - Request leave
  - Browse training programs
  - View profile history

## Persyaratan

- Flutter 3.0+
- Dart 3.0+
- Android SDK (untuk development Android)
- Xcode (untuk development iOS)
- Laravel backend running (default: http://localhost:8000)

## Setup

### 1. Install Dependencies

```bash
cd flutter_app
flutter pub get
```

### 2. Konfigurasi API URL

Edit file `lib/services/api_service.dart` dan ubah base URL sesuai dengan URL backend Laravel Anda:

```dart
static const String baseUrl = 'http://localhost:8000/api'; // Ubah ke URL Laravel Anda
```

### 3. Generate Dart Models (Optional)

Jika Anda menggunakan build_runner untuk generate models:

```bash
flutter pub run build_runner build
```

### 4. Jalankan Aplikasi

**Android:**
```bash
flutter run -d <device-id>
```

**iOS:**
```bash
flutter run -d <device-id>
```

**Web:**
```bash
flutter run -d chrome
```

## Struktur Project

```
lib/
├── main.dart                 # Entry point aplikasi
├── models/                   # Data models (User, Karyawan, Leave, Training, etc)
├── services/                 # API service & local storage
├── providers/                # State management (Provider)
├── screens/
│   ├── auth/                # Login & Register screens
│   ├── common/              # Landing page
│   ├── admin/               # Admin dashboard & management screens
│   └── karyawan/            # Employee dashboard & screens
├── widgets/                 # Reusable widgets
└── utils/                   # Utilities (theme, helpers, etc)
```

## API Integration

Aplikasi ini menggunakan API dari Laravel backend. Pastikan endpoints berikut tersedia:

### Auth Endpoints
- `POST /api/auth/register` - Registrasi pengguna baru
- `POST /api/auth/login` - Login
- `POST /api/auth/logout` - Logout
- `GET /api/auth/user` - Get current user

### Karyawan Endpoints
- `GET /api/karyawan` - List karyawan dengan pagination
- `GET /api/karyawan/{id}` - Detail karyawan
- `POST /api/karyawan` - Create karyawan
- `PUT /api/karyawan/{id}` - Update karyawan
- `DELETE /api/karyawan/{id}` - Delete karyawan

### Leave Endpoints
- `GET /api/leaves` - List leaves
- `GET /api/leaves/{id}` - Detail leave
- `POST /api/leaves` - Create leave
- `POST /api/leaves/{id}/approve` - Approve leave
- `POST /api/leaves/{id}/reject` - Reject leave

### Training Endpoints
- `GET /api/trainings` - List trainings
- `GET /api/trainings/{id}` - Detail training
- `POST /api/trainings/{id}/enroll` - Enroll training
- `POST /api/trainings/{id}/cancel` - Cancel enrollment

### Dashboard Endpoint
- `GET /api/dashboard/stats` - Get dashboard statistics

## Authentication

Aplikasi menggunakan Laravel Sanctum untuk autentikasi. Token disimpan di local storage dan dikirim dengan setiap request melalui header Authorization.

```
Authorization: Bearer <token>
```

## State Management

Aplikasi menggunakan `Provider` package untuk state management. Ada 4 providers utama:

- **AuthProvider**: Mengelola autentikasi dan user state
- **KaryawanProvider**: Mengelola data karyawan
- **LeaveProvider**: Mengelola data leave
- **TrainingProvider**: Mengelola data training

## Customization

### Theme

Ubah tema aplikasi di `lib/utils/theme.dart`:

```dart
class AppTheme {
  static const Color primaryColor = Color(0xFF2196F3);
  // Ubah warna sesuai kebutuhan
}
```

### Permissions

Untuk Android, edit `android/app/src/main/AndroidManifest.xml`:

```xml
<uses-permission android:name="android.permission.INTERNET" />
<uses-permission android:name="android.permission.READ_EXTERNAL_STORAGE" />
<uses-permission android:name="android.permission.WRITE_EXTERNAL_STORAGE" />
<uses-permission android:name="android.permission.CAMERA" />
```

## Troubleshooting

### Issue: Cannot connect to API

1. Pastikan URL backend correct di `api_service.dart`
2. Pastikan backend Laravel sedang berjalan
3. Check CORS settings di backend
4. Check firewall/network settings

### Issue: Login gagal

1. Verify credentials di database Laravel
2. Check token generation di backend
3. Check local storage permissions

### Issue: Build error

```bash
flutter clean
flutter pub get
flutter run
```

## Testing

Akun test yang tersedia:

**Admin:**
- Email: `admin@example.com`
- Password: `password`

**Employee:**
- Email: `employee@example.com`
- Password: `password`

## Production Build

**Android:**
```bash
flutter build apk --release
# atau
flutter build appbundle --release
```

**iOS:**
```bash
flutter build ios --release
```

**Web:**
```bash
flutter build web --release
```

## Commit ke Production Checklist

- [ ] Update API URL ke production
- [ ] Configure push notifications
- [ ] Test semua fitur
- [ ] Check error handling
- [ ] Optimize images
- [ ] Update app version
- [ ] Generate signing key (Android)
- [ ] Build release version
- [ ] Test di device fisik

## Support

Untuk bantuan lebih lanjut, lihat documentation di folder `docs/` atau dokumentasi Flutter official.

## License

Proprietary - All Rights Reserved
