-- ==========================================
-- INSERT USERS & KARYAWAN - PT PASENTRA
-- ==========================================
-- Password Admin: admin123 (bcrypt hash)
-- Password Users: password123 (bcrypt hash)
-- ==========================================

-- INSERT USERS (ADMIN)
INSERT INTO users (name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
('Admin Pasentra', 'admin@pasentra.com', NOW(), '$2y$12$5GPFQJ8.TDxPjxZ5K6d3J.2gQbNrpLZ.yt2K6I5K3YV7R4S8T9U0W', NULL, NOW(), NOW());

-- INSERT USERS (KARYAWAN)
INSERT INTO users (name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
('Hafiz Rahman', 'hafiz.rahman@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Siti Nurhaliza', 'siti.nurhaliza@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Budi Santoso', 'budi.santoso@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Dewi Lestari', 'dewi.lestari@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Ahmad Wijaya', 'ahmad.wijaya@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Rina Kusumawardhani', 'rina.kusumawardhani@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Hendra Gunawan', 'hendra.gunawan@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Citra Dewi', 'citra.dewi@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Rendra Pratama', 'rendra.pratama@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Sonia Putri', 'sonia.putri@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Eko Susanto', 'eko.susanto@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Maya Hasanah', 'maya.hasanah@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Irfan Hidayat', 'irfan.hidayat@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Lena Wijaya', 'lena.wijaya@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Fahmi Aziz', 'fahmi.aziz@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Nisa Ramadhani', 'nisa.ramadhani@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Gilang Saputra', 'gilang.saputra@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Ayu Sundari', 'ayu.sundari@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Riyadi Hermanto', 'riyadi.hermanto@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Tina Kusuma', 'tina.kusuma@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Boedi Hartono', 'boedi.hartono@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Ratna Sari', 'ratna.sari@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Doni Setiawan', 'doni.setiawan@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Fiona Wijaya', 'fiona.wijaya@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Hendri Kusuma', 'hendri.kusuma@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Joni Pratama', 'joni.pratama@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Ketut Suryadi', 'ketut.suryadi@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Lilis Handayani', 'lilis.handayani@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Muhamad Rizky', 'muhamad.rizky@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW()),
('Nur Azizah', 'nur.azizah@pasentra.com', NOW(), '$2y$12$dB0K5lX9W2M7pZ3N8qV1tOe4J6sR5cQ2hF8T3X1L7m9Y4n0J2K', NULL, NOW(), NOW());

-- ==========================================
-- INSERT KARYAWAN (STAFF AKTIF & NON-AKTIF)
-- ==========================================

INSERT INTO karyawans (user_id, divisi_id, nik, nama, posisi, jenis_kelamin, alamat, no_telepon, tanggal_lahir, tempat_lahir, pendidikan, gaji, status, foto, keterangan, created_at, updated_at) VALUES

-- 1. HAFIZ RAHMAN - IT STAFF (AKTIF)
(2, 1, '101001', 'Hafiz Rahman', 'IT Staff', 'Laki-laki', 'Jl. Merdeka No. 25, Jakarta Selatan 12345', '08123456789', '1995-03-15', 'Jakarta', 'S1 Teknik Informatika', 5500000, 'Aktif', 'hafiz.png', 'Staff IT berpengalaman dalam network management dan server administration. Bertanggung jawab atas maintenance sistem dan support teknis keseluruhan.', NOW(), NOW()),

-- 2. SITI NURHALIZA - HRD (AKTIF)
(3, 2, '101002', 'Siti Nurhaliza', 'HRD Manager', 'Perempuan', 'Jl. Sudirman No. 42, Jakarta Pusat 12340', '08129876543', '1992-07-22', 'Bandung', 'S1 Manajemen', 7500000, 'Aktif', 'siti.png', 'Manager HRD dengan track record yang baik dalam recruitment dan employee engagement. Mengelola semua proses HR dan pengembangan SDM.', NOW(), NOW()),

-- 3. BUDI SANTOSO - FINANCE (AKTIF)
(4, 3, '101003', 'Budi Santoso', 'Finance Manager', 'Laki-laki', 'Jl. Gatot Subroto No. 88, Jakarta Selatan 12345', '08121234567', '1990-05-10', 'Surabaya', 'S1 Akuntansi', 8000000, 'Aktif', 'budi.png', 'Manager Finance dengan sertifikasi akuntansi internasional. Mengelola cash flow, budget planning, dan financial reporting perusahaan.', NOW(), NOW()),

-- 4. DEWI LESTARI - MARKETING (AKTIF)
(5, 4, '101004', 'Dewi Lestari', 'Marketing Manager', 'Perempuan', 'Jl. Thamrin No. 15, Jakarta Pusat 12340', '08123987654', '1994-11-18', 'Medan', 'S1 Komunikasi', 7000000, 'Aktif', 'dewi.png', 'Marketing Manager kreatif dan strategis. Mengelola brand awareness, digital marketing, dan customer relationship management.', NOW(), NOW()),

-- 5. AHMAD WIJAYA - SALES (AKTIF)
(6, 5, '101005', 'Ahmad Wijaya', 'Sales Executive', 'Laki-laki', 'Jl. Hayam Wuruk No. 33, Jakarta Pusat 12345', '08125555555', '1996-02-28', 'Jakarta', 'D3 Bisnis Manajemen', 5200000, 'Aktif', 'ahmad.png', 'Sales Executive terbaik dengan pencapaian penjualan konsisten. Menangani client relationship dan business development.', NOW(), NOW()),

-- 6. RINA KUSUMAWARDHANI - OPERASIONAL (AKTIF)
(7, 6, '101006', 'Rina Kusumawardhani', 'Operational Staff', 'Perempuan', 'Jl. Tanah Abang No. 50, Jakarta Pusat 12340', '08129999999', '1997-09-05', 'Jakarta', 'S1 Manajemen', 4800000, 'Aktif', 'rina.png', 'Staff Operasional yang bertanggung jawab atas proses bisnis sehari-hari dan koordinasi antar departemen.', NOW(), NOW()),

-- 7. HENDRA GUNAWAN - PRODUCTION (AKTIF)
(8, 7, '101007', 'Hendra Gunawan', 'Production Manager', 'Laki-laki', 'Jl. Jendral Sudirman No. 99, Jakarta Selatan 12345', '08123333333', '1991-04-12', 'Bandung', 'S1 Teknik Industri', 7200000, 'Aktif', 'hendra.png', 'Production Manager berpengalaman 15 tahun dalam manufaktur dan quality control. Mengoptimalkan efisiensi produksi.', NOW(), NOW()),

-- 8. CITRA DEWI - QUALITY ASSURANCE (AKTIF)
(9, 7, '101008', 'Citra Dewi', 'QA Manager', 'Perempuan', 'Jl. Kalimantan No. 77, Jakarta Pusat 12345', '08124444444', '1993-12-20', 'Jakarta', 'S1 Teknik', 6800000, 'Aktif', 'citra.png', 'QA Manager profesional dengan sertifikasi ISO. Memastikan quality standard produk dan dokumentasi sesuai prosedur.', NOW(), NOW()),

-- 9. RENDRA PRATAMA - PROCUREMENT (AKTIF)
(10, 6, '101009', 'Rendra Pratama', 'Procurement Officer', 'Laki-laki', 'Jl. Blok M No. 20, Jakarta Selatan 12345', '08125555555', '1995-08-14', 'Jakarta', 'S1 Manajemen', 5300000, 'Aktif', 'rendra.png', 'Procurement Officer yang mengelola supplier relationship dan purchasing activities dengan transparansi tinggi.', NOW(), NOW()),

-- 10. SONIA PUTRI - CUSTOMER SERVICE (AKTIF)
(11, 4, '101010', 'Sonia Putri', 'Customer Service Lead', 'Perempuan', 'Jl. Menteng No. 44, Jakarta Pusat 12345', '08126666666', '1996-06-09', 'Jakarta', 'D3 Hospitality', 4600000, 'Aktif', 'sonia.png', 'Customer Service Lead dengan komunikasi luar biasa. Meningkatkan customer satisfaction dan menangani keluhan dengan baik.', NOW(), NOW()),

-- 11. EKO SUSANTO - LEGAL COUNSEL (AKTIF)
(12, 8, '101011', 'Eko Susanto', 'Legal Consultant', 'Laki-laki', 'Jl. Rasuna Said No. 66, Jakarta Selatan 12345', '08127777777', '1988-01-22', 'Surabaya', 'S2 Hukum', 8500000, 'Aktif', 'eko.png', 'Legal Consultant bersertifikat dengan expertise di corporate law dan contract management. Melindungi kepentingan perusahaan.', NOW(), NOW()),

-- 12. MAYA HASANAH - COMPLIANCE (AKTIF)
(13, 8, '101012', 'Maya Hasanah', 'Compliance Officer', 'Perempuan', 'Jl. Prapatan No. 55, Jakarta Pusat 12345', '08128888888', '1994-10-30', 'Jakarta', 'S1 Hukum', 5800000, 'Aktif', 'maya.png', 'Compliance Officer yang memastikan operasional perusahaan sesuai regulasi dan standard governance.', NOW(), NOW()),

-- 13. IRFAN HIDAYAT - LOGISTIK (AKTIF)
(14, 9, '101013', 'Irfan Hidayat', 'Logistics Manager', 'Laki-laki', 'Jl. Kuningan No. 77, Jakarta Selatan 12345', '08129999999', '1992-03-17', 'Jakarta', 'S1 Manajemen Logistik', 6500000, 'Aktif', 'irfan.png', 'Logistics Manager yang mengelola supply chain dan distribusi dengan sistem tracking real-time.', NOW(), NOW()),

-- 14. LENA WIJAYA - ACCOUNTING (AKTIF)
(15, 3, '101014', 'Lena Wijaya', 'Accounting Supervisor', 'Perempuan', 'Jl. Senayan No. 88, Jakarta Selatan 12345', '08121111111', '1997-07-05', 'Jakarta', 'S1 Akuntansi', 5600000, 'Aktif', 'lena.png', 'Accounting Supervisor yang menangani bookkeeping, tax filing, dan financial reconciliation dengan akurat.', NOW(), NOW()),

-- 15. FAHMI AZIZ - IT DEVELOPMENT (AKTIF)
(16, 1, '101015', 'Fahmi Aziz', 'Developer', 'Laki-laki', 'Jl. Satrio No. 123, Jakarta Selatan 12345', '08122222222', '1998-09-12', 'Jakarta', 'S1 Teknik Informatika', 5900000, 'Aktif', 'fahmi.png', 'Developer Full-Stack yang menguasai Laravel, React, dan mobile development. Mengembangkan solusi software custom.', NOW(), NOW()),

-- 16. NISA RAMADHANI - GRAPHIC DESIGN (AKTIF)
(17, 4, '101016', 'Nisa Ramadhani', 'Graphic Designer', 'Perempuan', 'Jl. Bintaro No. 99, Jakarta Selatan 12345', '08123333333', '1999-02-14', 'Jakarta', 'S1 Desain Komunikasi Visual', 4700000, 'Aktif', 'nisa.png', 'Graphic Designer berbakat dengan portofolio internasional. Menciptakan desain kreatif untuk branding dan marketing materials.', NOW(), NOW()),

-- 17. GILANG SAPUTRA - PROJECT MANAGER (AKTIF)
(18, 1, '101017', 'Gilang Saputra', 'Project Manager', 'Laki-laki', 'Jl. Puri Indah No. 55, Jakarta Barat 12345', '08124444444', '1993-11-08', 'Jakarta', 'S1 Teknik', 6900000, 'Aktif', 'gilang.png', 'Project Manager bersertifikasi PMP yang mengelola project IT skala besar dengan metodologi Agile dan Waterfall.', NOW(), NOW()),

-- 18. AYU SUNDARI - HUMAN CAPITAL (AKTIF)
(19, 2, '101018', 'Ayu Sundari', 'Human Capital Specialist', 'Perempuan', 'Jl. Pondok Indah No. 44, Jakarta Selatan 12345', '08125555555', '1996-04-20', 'Jakarta', 'S1 Psikologi', 5200000, 'Aktif', 'ayu.png', 'Human Capital Specialist yang fokus pada talent management, training development, dan employee engagement program.', NOW(), NOW()),

-- 19. RIYADI HERMANTO - MAINTENANCE (AKTIF)
(20, 6, '101019', 'Riyadi Hermanto', 'Maintenance Technician', 'Laki-laki', 'Jl. Kelapa Dua No. 33, Jakarta Utara 12345', '08126666666', '1989-06-25', 'Jakarta', 'D3 Teknik Mesin', 4200000, 'Aktif', 'riyadi.png', 'Maintenance Technician berpengalaman dalam perawatan mesin dan equipment. Menjaga produktivitas operasional.', NOW(), NOW()),

-- 20. TINA KUSUMA - WAREHOUSE (AKTIF)
(21, 9, '101020', 'Tina Kusuma', 'Warehouse Supervisor', 'Perempuan', 'Jl. Tanjungsari No. 77, Tangerang 15345', '08127777777', '1994-08-18', 'Tangerang', 'S1 Manajemen', 4900000, 'Aktif', 'tina.png', 'Warehouse Supervisor yang mengelola inventory, stock accuracy, dan warehouse operations dengan sistem WMS.', NOW(), NOW()),

-- 21. BOEDI HARTONO - SENIOR ENGINEER (AKTIF)
(22, 1, '101021', 'Boedi Hartono', 'Senior IT Engineer', 'Laki-laki', 'Jl. Bukit Golf No. 88, Jakarta Selatan 12345', '08128888888', '1985-10-05', 'Jakarta', 'S1 Teknik Elektro', 8200000, 'Aktif', 'boedi.png', 'Senior IT Engineer dengan pengalaman 20 tahun. Melakukan infrastructure design dan technical consultation.', NOW(), NOW()),

-- 22. RATNA SARI - RESEARCH & DEVELOPMENT (AKTIF)
(23, 7, '101022', 'Ratna Sari', 'R&D Specialist', 'Perempuan', 'Jl. Semanggi No. 99, Jakarta Selatan 12345', '08129999999', '1991-05-12', 'Jakarta', 'S2 Teknik', 7600000, 'Aktif', 'ratna.png', 'R&D Specialist yang mengembangkan produk inovatif. Melakukan riset pasar dan product improvement berkelanjutan.', NOW(), NOW()),

-- 23. DONI SETIAWAN - SALES REGIONAL (AKTIF)
(24, 5, '101023', 'Doni Setiawan', 'Regional Sales Manager', 'Laki-laki', 'Jl. Pasar Baru No. 44, Jakarta Pusat 12345', '08121111111', '1990-09-15', 'Jakarta', 'S1 Manajemen', 7300000, 'Aktif', 'doni.png', 'Regional Sales Manager yang memimpin tim sales dan mencapai target revenue dengan strategi penjualan inovatif.', NOW(), NOW()),

-- 24. FIONA WIJAYA - CONTENT CREATOR (AKTIF)
(25, 4, '101024', 'Fiona Wijaya', 'Content Manager', 'Perempuan', 'Jl. Terogong No. 55, Jakarta Selatan 12345', '08122222222', '1998-01-22', 'Jakarta', 'S1 Jurnalistik', 4800000, 'Aktif', 'fiona.png', 'Content Manager yang mengelola social media dan content strategy. Meningkatkan brand engagement dan reach.', NOW(), NOW()),

-- 25. HENDRI KUSUMA - SECURITY (AKTIF)
(26, 10, '101025', 'Hendri Kusuma', 'Security Manager', 'Laki-laki', 'Jl. Lebak Bulus No. 66, Jakarta Selatan 12345', '08123333333', '1987-12-10', 'Jakarta', 'D3 Keamanan', 5100000, 'Aktif', 'hendri.png', 'Security Manager yang mengelola keamanan fisik dan cyber security. Menjaga keamanan aset dan data perusahaan.', NOW(), NOW()),

-- 26. JONI PRATAMA - ADMIN (AKTIF)
(27, 6, '101026', 'Joni Pratama', 'Administrative Officer', 'Laki-laki', 'Jl. Lenteng Agung No. 77, Jakarta Selatan 12345', '08124444444', '1999-03-18', 'Jakarta', 'D3 Administrasi', 3800000, 'Aktif', 'joni.png', 'Administrative Officer yang menangani dokumentasi, agenda meeting, dan administrative support lainnya.', NOW(), NOW()),

-- 27. KETUT SURYADI - DRIVER (AKTIF)
(28, 6, '101027', 'Ketut Suryadi', 'Driver', 'Laki-laki', 'Jl. Raya Bogor No. 88, Depok 16345', '08125555555', '1985-07-20', 'Depok', 'SMA', 3200000, 'Aktif', 'ketut.png', 'Driver profesional dengan SIM A internasional. Bertanggung jawab dalam pengiriman dan transportasi karyawan.', NOW(), NOW()),

-- 28. LILIS HANDAYANI - CLEANING SERVICE (AKTIF)
(29, 6, '101028', 'Lilis Handayani', 'Cleaning Service Staff', 'Perempuan', 'Jl. Cilangkap No. 99, Jakarta Timur 12345', '08126666666', '1988-11-02', 'Jakarta', 'SMA', 2800000, 'Aktif', 'lilis.png', 'Cleaning Service Staff yang menjaga kebersihan dan kerapihan area kantor setiap hari.', NOW(), NOW()),

-- 29. MUHAMAD RIZKY - INTERN (AKTIF)
(30, 1, '101029', 'Muhamad Rizky', 'IT Intern', 'Laki-laki', 'Jl. Kampus No. 44, Jakarta Selatan 12345', '08127777777', '2002-05-14', 'Jakarta', 'Mahasiswa S1 Teknik Informatika', 1500000, 'Aktif', 'muhamad.png', 'IT Intern yang sedang belajar dan berkontribusi dalam project development. Akan permanent setelah lulus.', NOW(), NOW()),

-- 30. NUR AZIZAH - MEDICAL OFFICER (NON-AKTIF)
(31, 2, '101030', 'Nur Azizah', 'Medical Officer', 'Perempuan', 'Jl. Perhubungan No. 55, Jakarta Pusat 12345', '08128888888', '1989-02-28', 'Jakarta', 'S1 Keperawatan', 5000000, 'Non Aktif', 'nur.png', 'Medical Officer - Status: Non-aktif sejak 15 November 2024 karena mengundurkan diri untuk melanjutkan pendidikan Master Kesehatan di universitas luar negeri. Kontribusi bagus dalam program kesehatan karyawan selama 5 tahun.', NOW(), NOW());
