# Flutter App Setup Checklist

## Pre-Development Setup

- [ ] Install Flutter SDK
- [ ] Install Dart SDK
- [ ] Configure Flutter environment variables
- [ ] Verify Flutter installation: `flutter doctor`
- [ ] Install Android Studio & Android SDK
- [ ] Install Xcode (untuk iOS)
- [ ] Setup emulator/simulator

## Project Setup

- [ ] Navigate ke `flutter_app` folder
- [ ] Run `flutter pub get`
- [ ] Update API base URL di `lib/services/api_service.dart`
- [ ] Create `.env` file untuk environment variables (optional)
- [ ] Run `flutter run` untuk test aplikasi

## Backend Integration

### Laravel API Setup

Pastikan backend Laravel sudah implement endpoints berikut:

#### 1. Authentication Endpoints

- [x] `POST /api/auth/register`
  ```json
  {
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }
  ```

- [x] `POST /api/auth/login`
  ```json
  {
    "email": "john@example.com",
    "password": "password123"
  }
  ```

- [x] `GET /api/auth/user` (Authenticated)
  Returns: User object

- [x] `POST /api/auth/logout` (Authenticated)

#### 2. Employee Management Endpoints

- [ ] `GET /api/karyawan?page=1&per_page=10&search=&department=&status=`
  Returns: Paginated Karyawan list

- [ ] `GET /api/karyawan/{id}`
  Returns: Karyawan detail

- [ ] `POST /api/karyawan`
  ```json
  {
    "nip": "2023001",
    "name": "John Doe",
    "email": "john@company.com",
    "gender": "M",
    "address": "123 Main St",
    "department": "IT",
    "position": "Developer",
    "jurusan": "Computer Science",
    "status": "tetap"
  }
  ```

- [ ] `PUT /api/karyawan/{id}` (Same fields as POST)

- [ ] `DELETE /api/karyawan/{id}`

#### 3. Leave Management Endpoints

- [ ] `GET /api/leaves?page=1&per_page=10&status=&type=`
  Returns: Paginated Leave list

- [ ] `GET /api/leaves/{id}`
  Returns: Leave detail

- [ ] `POST /api/leaves`
  ```json
  {
    "leave_type": "cuti",
    "start_date": "2024-01-15",
    "end_date": "2024-01-20",
    "reason": "Vacation"
  }
  ```

- [ ] `POST /api/leaves/{id}/approve` (Admin only)

- [ ] `POST /api/leaves/{id}/reject`
  ```json
  {
    "reason": "Rejection reason"
  }
  ```

#### 4. Training Management Endpoints

- [ ] `GET /api/trainings?page=1&per_page=10&status=`
  Returns: Paginated Training list

- [ ] `GET /api/trainings/{id}`
  Returns: Training detail with participants

- [ ] `POST /api/trainings/{id}/enroll` (Authenticated)

- [ ] `POST /api/trainings/{id}/cancel` (Authenticated)

#### 5. Dashboard Endpoint

- [ ] `GET /api/dashboard/stats` (Authenticated)
  Returns:
  ```json
  {
    "total_employees": 50,
    "active_trainings": 5,
    "pending_leaves": 3,
    "total_departments": 4,
    "my_pending_leaves": 1,
    "my_trainings": 2
  }
  ```

## Testing

### Unit Tests
- [ ] Create unit tests for models
- [ ] Create unit tests for providers
- [ ] Create unit tests for services

### Widget Tests
- [ ] Test login screen
- [ ] Test dashboard screens
- [ ] Test list screens

### Integration Tests
- [ ] Test login flow
- [ ] Test employee CRUD
- [ ] Test leave request flow
- [ ] Test training enrollment

### Manual Testing

**Login Flow:**
- [ ] Register new account
- [ ] Login with credentials
- [ ] Logout

**Admin Features:**
- [ ] View dashboard stats
- [ ] List employees
- [ ] Create employee
- [ ] Edit employee
- [ ] Delete employee
- [ ] View leaves
- [ ] Approve/Reject leave
- [ ] View trainings

**Employee Features:**
- [ ] View dashboard
- [ ] View profile
- [ ] Edit profile
- [ ] Request leave
- [ ] View leave status
- [ ] View trainings
- [ ] Enroll training

## Performance Optimization

- [ ] Implement pagination for list screens
- [ ] Lazy load images
- [ ] Cache API responses where applicable
- [ ] Optimize database queries (Backend)
- [ ] Use const constructors
- [ ] Remove unused imports

## Security

- [ ] Verify token validation
- [ ] Implement token refresh mechanism
- [ ] Secure local storage (no sensitive data)
- [ ] Implement SSL/TLS for API calls
- [ ] Validate all user inputs
- [ ] Implement rate limiting (Backend)

## UI/UX

- [ ] Design responsive layouts for all screen sizes
- [ ] Test on different devices
- [ ] Implement dark mode (optional)
- [ ] Add loading indicators
- [ ] Add error messages
- [ ] Add success notifications
- [ ] Implement proper navigation

## Documentation

- [ ] Create API documentation
- [ ] Document Flutter code with comments
- [ ] Create user manual
- [ ] Create admin guide
- [ ] Document setup process

## Deployment

### Pre-Deployment

- [ ] Update app version
- [ ] Configure app icon
- [ ] Configure app name
- [ ] Configure splash screen
- [ ] Test on production-like environment

### Android

- [ ] Update compileSdkVersion
- [ ] Configure signing key
- [ ] Build release APK
- [ ] Test on real device
- [ ] Upload to Google Play Store

### iOS

- [ ] Update iOS deployment target
- [ ] Configure provisioning profile
- [ ] Build release IPA
- [ ] Test on real device
- [ ] Upload to App Store

### Web (Optional)

- [ ] Test web version
- [ ] Optimize for mobile browsers
- [ ] Deploy to hosting

## Post-Deployment

- [ ] Monitor app performance
- [ ] Check error logs
- [ ] Gather user feedback
- [ ] Plan next features
- [ ] Schedule updates

## Maintenance

- [ ] Regular security updates
- [ ] Fix reported bugs
- [ ] Add new features based on feedback
- [ ] Keep dependencies updated
- [ ] Monitor API usage

## Notes

- API base URL harus diupdate sesuai environment
- Pastikan CORS enabled di backend Laravel
- Test dengan berbagai network conditions
- Monitor app size (target < 50MB)
- Handle offline mode jika diperlukan

---
**Status**: Development in progress
**Last Updated**: December 10, 2024
