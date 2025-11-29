# Kelola Karyawan - Test Credentials

## Admin Account

-   **Email:** admin@pasentra.com
-   **Password:** admin123
-   **Route:** /admin/dashboard

## Employee Accounts

Semua karyawan akan memiliki password default: `password123`

### Existing Employees:

1. **John Doe**

    - Email: john.doe@pasentra.com
    - Password: password123
    - Status: Aktif
    - Posisi: Manager

2. **Jane Smith**

    - Email: jane.smith@pasentra.com
    - Password: password123
    - Status: Aktif
    - Posisi: Staff

3. **Budi Santoso**
    - Email: budi.santoso@pasentra.com
    - Password: password123
    - Status: Aktif
    - Posisi: Supervisor

## Features

-   ✅ Login Admin (tidak punya relasi karyawan)
-   ✅ Login Karyawan (punya relasi karyawan)
-   ✅ Dashboard Karyawan dengan profile preview
-   ✅ Profile Lengkap Karyawan
-   ✅ Print ID Card Karyawan (2-sided: Front & Back)
-   ✅ Admin Dashboard (manage all employees)
-   ✅ Admin Report (generate PDF laporan karyawan)

## Test Scenarios

### 1. Login Admin

```
Email: admin@pasentra.com
Password: admin123
Expected: Redirect to /admin/dashboard
```

### 2. Login Karyawan (John Doe)

```
Email: john.doe@pasentra.com
Password: password123
Expected: Redirect to /karyawan/dashboard
```

### 3. Karyawan Features

-   View Dashboard
-   View Profile
-   Download ID Card (PDF)

### 4. Admin Features

-   Manage Karyawan (CRUD)
-   View Dashboard
-   View History
-   Generate Report
-   View/Edit Profile

## Database Info

-   Users Table: Punya relasi ke Karyawan (karyawan_id)
-   Admin: karyawan_id = NULL
-   Karyawan: karyawan_id = [ID Karyawan]
