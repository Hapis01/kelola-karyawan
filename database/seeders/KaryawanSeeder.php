<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Divisi;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. HAFIZ RAHMAN - IT STAFF
        $karyawan1 = Karyawan::create([
            'nama' => 'Hafiz Rahman',
            'nik' => '101001',
            'divisi_id' => 1,
            'posisi' => 'IT Staff',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Merdeka No. 25, Jakarta Selatan 12345',
            'no_telepon' => '08123456789',
            'tanggal_lahir' => '1995-03-15',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Teknik Informatika',
            'gaji' => 5500000,
            'status' => 'Aktif',
            'foto' => 'hafiz.png',
            'keterangan' => 'Staff IT berpengalaman dalam network management dan server administration. Bertanggung jawab atas maintenance sistem dan support teknis keseluruhan.',
        ]);
        User::create([
            'karyawan_id' => $karyawan1->id,
            'name' => 'Hafiz Rahman',
            'email' => 'hafiz.rahman@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 2. SITI NURHALIZA - HRD
        $karyawan2 = Karyawan::create([
            'nama' => 'Siti Nurhaliza',
            'nik' => '101002',
            'divisi_id' => 2,
            'posisi' => 'HRD Manager',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Sudirman No. 42, Jakarta Pusat 12340',
            'no_telepon' => '08129876543',
            'tanggal_lahir' => '1992-07-22',
            'tempat_lahir' => 'Bandung',
            'pendidikan' => 'S1 Manajemen',
            'gaji' => 7500000,
            'status' => 'Aktif',
            'foto' => 'siti.png',
            'keterangan' => 'Manager HRD dengan track record yang baik dalam recruitment dan employee engagement. Mengelola semua proses HR dan pengembangan SDM.',
        ]);
        User::create([
            'karyawan_id' => $karyawan2->id,
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 3. BUDI SANTOSO - FINANCE
        $karyawan3 = Karyawan::create([
            'nama' => 'Budi Santoso',
            'nik' => '101003',
            'divisi_id' => 3,
            'posisi' => 'Finance Manager',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Gatot Subroto No. 88, Jakarta Selatan 12345',
            'no_telepon' => '08121234567',
            'tanggal_lahir' => '1990-05-10',
            'tempat_lahir' => 'Surabaya',
            'pendidikan' => 'S1 Akuntansi',
            'gaji' => 8000000,
            'status' => 'Aktif',
            'foto' => 'budi.png',
            'keterangan' => 'Manager Finance dengan sertifikasi akuntansi internasional. Mengelola cash flow, budget planning, dan financial reporting perusahaan.',
        ]);
        User::create([
            'karyawan_id' => $karyawan3->id,
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 4. DEWI LESTARI - MARKETING
        $karyawan4 = Karyawan::create([
            'nama' => 'Dewi Lestari',
            'nik' => '101004',
            'divisi_id' => 4,
            'posisi' => 'Marketing Manager',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Thamrin No. 15, Jakarta Pusat 12340',
            'no_telepon' => '08123987654',
            'tanggal_lahir' => '1994-11-18',
            'tempat_lahir' => 'Medan',
            'pendidikan' => 'S1 Komunikasi',
            'gaji' => 7000000,
            'status' => 'Aktif',
            'foto' => 'dewi.png',
            'keterangan' => 'Marketing Manager kreatif dan strategis. Mengelola brand awareness, digital marketing, dan customer relationship management.',
        ]);
        User::create([
            'karyawan_id' => $karyawan4->id,
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 5. AHMAD WIJAYA - SALES
        $karyawan5 = Karyawan::create([
            'nama' => 'Ahmad Wijaya',
            'nik' => '101005',
            'divisi_id' => 5,
            'posisi' => 'Sales Executive',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Hayam Wuruk No. 33, Jakarta Pusat 12345',
            'no_telepon' => '08125555555',
            'tanggal_lahir' => '1996-02-28',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'D3 Bisnis Manajemen',
            'gaji' => 5200000,
            'status' => 'Aktif',
            'foto' => 'ahmad.png',
            'keterangan' => 'Sales Executive terbaik dengan pencapaian penjualan konsisten. Menangani client relationship dan business development.',
        ]);
        User::create([
            'karyawan_id' => $karyawan5->id,
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad.wijaya@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 6. RINA KUSUMAWARDHANI - OPERASIONAL
        $karyawan6 = Karyawan::create([
            'nama' => 'Rina Kusumawardhani',
            'nik' => '101006',
            'divisi_id' => 6,
            'posisi' => 'Operational Staff',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Tanah Abang No. 50, Jakarta Pusat 12340',
            'no_telepon' => '08129999999',
            'tanggal_lahir' => '1997-09-05',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Manajemen',
            'gaji' => 4800000,
            'status' => 'Aktif',
            'foto' => 'rina.png',
            'keterangan' => 'Staff Operasional yang bertanggung jawab atas proses bisnis sehari-hari dan koordinasi antar departemen.',
        ]);
        User::create([
            'karyawan_id' => $karyawan6->id,
            'name' => 'Rina Kusumawardhani',
            'email' => 'rina.kusumawardhani@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 7. HENDRA GUNAWAN - PRODUCTION
        $karyawan7 = Karyawan::create([
            'nama' => 'Hendra Gunawan',
            'nik' => '101007',
            'divisi_id' => 7,
            'posisi' => 'Production Manager',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Jendral Sudirman No. 99, Jakarta Selatan 12345',
            'no_telepon' => '08123333333',
            'tanggal_lahir' => '1991-04-12',
            'tempat_lahir' => 'Bandung',
            'pendidikan' => 'S1 Teknik Industri',
            'gaji' => 7200000,
            'status' => 'Aktif',
            'foto' => 'hendra.png',
            'keterangan' => 'Production Manager berpengalaman 15 tahun dalam manufaktur dan quality control. Mengoptimalkan efisiensi produksi.',
        ]);
        User::create([
            'karyawan_id' => $karyawan7->id,
            'name' => 'Hendra Gunawan',
            'email' => 'hendra.gunawan@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 8. CITRA DEWI - QUALITY ASSURANCE
        $karyawan8 = Karyawan::create([
            'nama' => 'Citra Dewi',
            'nik' => '101008',
            'divisi_id' => 7,
            'posisi' => 'QA Manager',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Kalimantan No. 77, Jakarta Pusat 12345',
            'no_telepon' => '08124444444',
            'tanggal_lahir' => '1993-12-20',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Teknik',
            'gaji' => 6800000,
            'status' => 'Aktif',
            'foto' => 'citra.png',
            'keterangan' => 'QA Manager profesional dengan sertifikasi ISO. Memastikan quality standard produk dan dokumentasi sesuai prosedur.',
        ]);
        User::create([
            'karyawan_id' => $karyawan8->id,
            'name' => 'Citra Dewi',
            'email' => 'citra.dewi@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 9. RENDRA PRATAMA - PROCUREMENT
        $karyawan9 = Karyawan::create([
            'nama' => 'Rendra Pratama',
            'nik' => '101009',
            'divisi_id' => 6,
            'posisi' => 'Procurement Officer',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Blok M No. 20, Jakarta Selatan 12345',
            'no_telepon' => '08125555555',
            'tanggal_lahir' => '1995-08-14',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Manajemen',
            'gaji' => 5300000,
            'status' => 'Aktif',
            'foto' => 'rendra.png',
            'keterangan' => 'Procurement Officer yang mengelola supplier relationship dan purchasing activities dengan transparansi tinggi.',
        ]);
        User::create([
            'karyawan_id' => $karyawan9->id,
            'name' => 'Rendra Pratama',
            'email' => 'rendra.pratama@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 10. SONIA PUTRI - CUSTOMER SERVICE
        $karyawan10 = Karyawan::create([
            'nama' => 'Sonia Putri',
            'nik' => '101010',
            'divisi_id' => 4,
            'posisi' => 'Customer Service Lead',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Menteng No. 44, Jakarta Pusat 12345',
            'no_telepon' => '08126666666',
            'tanggal_lahir' => '1996-06-09',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'D3 Hospitality',
            'gaji' => 4600000,
            'status' => 'Aktif',
            'foto' => 'sonia.png',
            'keterangan' => 'Customer Service Lead dengan komunikasi luar biasa. Meningkatkan customer satisfaction dan menangani keluhan dengan baik.',
        ]);
        User::create([
            'karyawan_id' => $karyawan10->id,
            'name' => 'Sonia Putri',
            'email' => 'sonia.putri@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 11. EKO SUSANTO - LEGAL COUNSEL
        $karyawan11 = Karyawan::create([
            'nama' => 'Eko Susanto',
            'nik' => '101011',
            'divisi_id' => 8,
            'posisi' => 'Legal Consultant',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Rasuna Said No. 66, Jakarta Selatan 12345',
            'no_telepon' => '08127777777',
            'tanggal_lahir' => '1988-01-22',
            'tempat_lahir' => 'Surabaya',
            'pendidikan' => 'S2 Hukum',
            'gaji' => 8500000,
            'status' => 'Aktif',
            'foto' => 'eko.png',
            'keterangan' => 'Legal Consultant bersertifikat dengan expertise di corporate law dan contract management. Melindungi kepentingan perusahaan.',
        ]);
        User::create([
            'karyawan_id' => $karyawan11->id,
            'name' => 'Eko Susanto',
            'email' => 'eko.susanto@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 12. MAYA HASANAH - COMPLIANCE
        $karyawan12 = Karyawan::create([
            'nama' => 'Maya Hasanah',
            'nik' => '101012',
            'divisi_id' => 8,
            'posisi' => 'Compliance Officer',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Prapatan No. 55, Jakarta Pusat 12345',
            'no_telepon' => '08128888888',
            'tanggal_lahir' => '1994-10-30',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Hukum',
            'gaji' => 5800000,
            'status' => 'Aktif',
            'foto' => 'maya.png',
            'keterangan' => 'Compliance Officer yang memastikan operasional perusahaan sesuai regulasi dan standard governance.',
        ]);
        User::create([
            'karyawan_id' => $karyawan12->id,
            'name' => 'Maya Hasanah',
            'email' => 'maya.hasanah@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 13. IRFAN HIDAYAT - LOGISTIK
        $karyawan13 = Karyawan::create([
            'nama' => 'Irfan Hidayat',
            'nik' => '101013',
            'divisi_id' => 9,
            'posisi' => 'Logistics Manager',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Kuningan No. 77, Jakarta Selatan 12345',
            'no_telepon' => '08129999999',
            'tanggal_lahir' => '1992-03-17',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Manajemen Logistik',
            'gaji' => 6500000,
            'status' => 'Aktif',
            'foto' => 'irfan.png',
            'keterangan' => 'Logistics Manager yang mengelola supply chain dan distribusi dengan sistem tracking real-time.',
        ]);
        User::create([
            'karyawan_id' => $karyawan13->id,
            'name' => 'Irfan Hidayat',
            'email' => 'irfan.hidayat@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 14. LENA WIJAYA - ACCOUNTING
        $karyawan14 = Karyawan::create([
            'nama' => 'Lena Wijaya',
            'nik' => '101014',
            'divisi_id' => 3,
            'posisi' => 'Accounting Supervisor',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Senayan No. 88, Jakarta Selatan 12345',
            'no_telepon' => '08121111111',
            'tanggal_lahir' => '1997-07-05',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Akuntansi',
            'gaji' => 5600000,
            'status' => 'Aktif',
            'foto' => 'lena.png',
            'keterangan' => 'Accounting Supervisor yang menangani bookkeeping, tax filing, dan financial reconciliation dengan akurat.',
        ]);
        User::create([
            'karyawan_id' => $karyawan14->id,
            'name' => 'Lena Wijaya',
            'email' => 'lena.wijaya@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 15. FAHMI AZIZ - IT DEVELOPMENT
        $karyawan15 = Karyawan::create([
            'nama' => 'Fahmi Aziz',
            'nik' => '101015',
            'divisi_id' => 1,
            'posisi' => 'Developer',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Satrio No. 123, Jakarta Selatan 12345',
            'no_telepon' => '08122222222',
            'tanggal_lahir' => '1998-09-12',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Teknik Informatika',
            'gaji' => 5900000,
            'status' => 'Aktif',
            'foto' => 'fahmi.png',
            'keterangan' => 'Developer Full-Stack yang menguasai Laravel, React, dan mobile development. Mengembangkan solusi software custom.',
        ]);
        User::create([
            'karyawan_id' => $karyawan15->id,
            'name' => 'Fahmi Aziz',
            'email' => 'fahmi.aziz@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 16. NISA RAMADHANI - GRAPHIC DESIGN
        $karyawan16 = Karyawan::create([
            'nama' => 'Nisa Ramadhani',
            'nik' => '101016',
            'divisi_id' => 4,
            'posisi' => 'Graphic Designer',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Bintaro No. 99, Jakarta Selatan 12345',
            'no_telepon' => '08123333333',
            'tanggal_lahir' => '1999-02-14',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Desain Komunikasi Visual',
            'gaji' => 4700000,
            'status' => 'Aktif',
            'foto' => 'nisa.png',
            'keterangan' => 'Graphic Designer berbakat dengan portofolio internasional. Menciptakan desain kreatif untuk branding dan marketing materials.',
        ]);
        User::create([
            'karyawan_id' => $karyawan16->id,
            'name' => 'Nisa Ramadhani',
            'email' => 'nisa.ramadhani@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 17. GILANG SAPUTRA - PROJECT MANAGER
        $karyawan17 = Karyawan::create([
            'nama' => 'Gilang Saputra',
            'nik' => '101017',
            'divisi_id' => 1,
            'posisi' => 'Project Manager',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Puri Indah No. 55, Jakarta Barat 12345',
            'no_telepon' => '08124444444',
            'tanggal_lahir' => '1993-11-08',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Teknik',
            'gaji' => 6900000,
            'status' => 'Aktif',
            'foto' => 'gilang.png',
            'keterangan' => 'Project Manager bersertifikasi PMP yang mengelola project IT skala besar dengan metodologi Agile dan Waterfall.',
        ]);
        User::create([
            'karyawan_id' => $karyawan17->id,
            'name' => 'Gilang Saputra',
            'email' => 'gilang.saputra@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 18. AYU SUNDARI - HUMAN CAPITAL
        $karyawan18 = Karyawan::create([
            'nama' => 'Ayu Sundari',
            'nik' => '101018',
            'divisi_id' => 2,
            'posisi' => 'Human Capital Specialist',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Pondok Indah No. 44, Jakarta Selatan 12345',
            'no_telepon' => '08125555555',
            'tanggal_lahir' => '1996-04-20',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Psikologi',
            'gaji' => 5200000,
            'status' => 'Aktif',
            'foto' => 'ayu.png',
            'keterangan' => 'Human Capital Specialist yang fokus pada talent management, training development, dan employee engagement program.',
        ]);
        User::create([
            'karyawan_id' => $karyawan18->id,
            'name' => 'Ayu Sundari',
            'email' => 'ayu.sundari@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 19. RIYADI HERMANTO - MAINTENANCE
        $karyawan19 = Karyawan::create([
            'nama' => 'Riyadi Hermanto',
            'nik' => '101019',
            'divisi_id' => 6,
            'posisi' => 'Maintenance Technician',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Kelapa Dua No. 33, Jakarta Utara 12345',
            'no_telepon' => '08126666666',
            'tanggal_lahir' => '1989-06-25',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'D3 Teknik Mesin',
            'gaji' => 4200000,
            'status' => 'Aktif',
            'foto' => 'riyadi.png',
            'keterangan' => 'Maintenance Technician berpengalaman dalam perawatan mesin dan equipment. Menjaga produktivitas operasional.',
        ]);
        User::create([
            'karyawan_id' => $karyawan19->id,
            'name' => 'Riyadi Hermanto',
            'email' => 'riyadi.hermanto@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 20. TINA KUSUMA - WAREHOUSE
        $karyawan20 = Karyawan::create([
            'nama' => 'Tina Kusuma',
            'nik' => '101020',
            'divisi_id' => 9,
            'posisi' => 'Warehouse Supervisor',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Tanjungsari No. 77, Tangerang 15345',
            'no_telepon' => '08127777777',
            'tanggal_lahir' => '1994-08-18',
            'tempat_lahir' => 'Tangerang',
            'pendidikan' => 'S1 Manajemen',
            'gaji' => 4900000,
            'status' => 'Aktif',
            'foto' => 'tina.png',
            'keterangan' => 'Warehouse Supervisor yang mengelola inventory, stock accuracy, dan warehouse operations dengan sistem WMS.',
        ]);
        User::create([
            'karyawan_id' => $karyawan20->id,
            'name' => 'Tina Kusuma',
            'email' => 'tina.kusuma@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 21. BOEDI HARTONO - SENIOR ENGINEER
        $karyawan21 = Karyawan::create([
            'nama' => 'Boedi Hartono',
            'nik' => '101021',
            'divisi_id' => 1,
            'posisi' => 'Senior IT Engineer',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Bukit Golf No. 88, Jakarta Selatan 12345',
            'no_telepon' => '08128888888',
            'tanggal_lahir' => '1985-10-05',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Teknik Elektro',
            'gaji' => 8200000,
            'status' => 'Aktif',
            'foto' => 'boedi.png',
            'keterangan' => 'Senior IT Engineer dengan pengalaman 20 tahun. Melakukan infrastructure design dan technical consultation.',
        ]);
        User::create([
            'karyawan_id' => $karyawan21->id,
            'name' => 'Boedi Hartono',
            'email' => 'boedi.hartono@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 22. RATNA SARI - RESEARCH & DEVELOPMENT
        $karyawan22 = Karyawan::create([
            'nama' => 'Ratna Sari',
            'nik' => '101022',
            'divisi_id' => 7,
            'posisi' => 'R&D Specialist',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Semanggi No. 99, Jakarta Selatan 12345',
            'no_telepon' => '08129999999',
            'tanggal_lahir' => '1991-05-12',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S2 Teknik',
            'gaji' => 7600000,
            'status' => 'Aktif',
            'foto' => 'ratna.png',
            'keterangan' => 'R&D Specialist yang mengembangkan produk inovatif. Melakukan riset pasar dan product improvement berkelanjutan.',
        ]);
        User::create([
            'karyawan_id' => $karyawan22->id,
            'name' => 'Ratna Sari',
            'email' => 'ratna.sari@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 23. DONI SETIAWAN - SALES REGIONAL
        $karyawan23 = Karyawan::create([
            'nama' => 'Doni Setiawan',
            'nik' => '101023',
            'divisi_id' => 5,
            'posisi' => 'Regional Sales Manager',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Pasar Baru No. 44, Jakarta Pusat 12345',
            'no_telepon' => '08121111111',
            'tanggal_lahir' => '1990-09-15',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Manajemen',
            'gaji' => 7300000,
            'status' => 'Aktif',
            'foto' => 'doni.png',
            'keterangan' => 'Regional Sales Manager yang memimpin tim sales dan mencapai target revenue dengan strategi penjualan inovatif.',
        ]);
        User::create([
            'karyawan_id' => $karyawan23->id,
            'name' => 'Doni Setiawan',
            'email' => 'doni.setiawan@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 24. FIONA WIJAYA - CONTENT CREATOR
        $karyawan24 = Karyawan::create([
            'nama' => 'Fiona Wijaya',
            'nik' => '101024',
            'divisi_id' => 4,
            'posisi' => 'Content Manager',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Terogong No. 55, Jakarta Selatan 12345',
            'no_telepon' => '08122222222',
            'tanggal_lahir' => '1998-01-22',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Jurnalistik',
            'gaji' => 4800000,
            'status' => 'Aktif',
            'foto' => 'fiona.png',
            'keterangan' => 'Content Manager yang mengelola social media dan content strategy. Meningkatkan brand engagement dan reach.',
        ]);
        User::create([
            'karyawan_id' => $karyawan24->id,
            'name' => 'Fiona Wijaya',
            'email' => 'fiona.wijaya@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 25. HENDRI KUSUMA - SECURITY
        $karyawan25 = Karyawan::create([
            'nama' => 'Hendri Kusuma',
            'nik' => '101025',
            'divisi_id' => 10,
            'posisi' => 'Security Manager',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Lebak Bulus No. 66, Jakarta Selatan 12345',
            'no_telepon' => '08123333333',
            'tanggal_lahir' => '1987-12-10',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'D3 Keamanan',
            'gaji' => 5100000,
            'status' => 'Aktif',
            'foto' => 'hendri.png',
            'keterangan' => 'Security Manager yang mengelola keamanan fisik dan cyber security. Menjaga keamanan aset dan data perusahaan.',
        ]);
        User::create([
            'karyawan_id' => $karyawan25->id,
            'name' => 'Hendri Kusuma',
            'email' => 'hendri.kusuma@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 26. JONI PRATAMA - ADMIN
        $karyawan26 = Karyawan::create([
            'nama' => 'Joni Pratama',
            'nik' => '101026',
            'divisi_id' => 6,
            'posisi' => 'Administrative Officer',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Lenteng Agung No. 77, Jakarta Selatan 12345',
            'no_telepon' => '08124444444',
            'tanggal_lahir' => '1999-03-18',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'D3 Administrasi',
            'gaji' => 3800000,
            'status' => 'Aktif',
            'foto' => 'joni.png',
            'keterangan' => 'Administrative Officer yang menangani dokumentasi, agenda meeting, dan administrative support lainnya.',
        ]);
        User::create([
            'karyawan_id' => $karyawan26->id,
            'name' => 'Joni Pratama',
            'email' => 'joni.pratama@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 27. KETUT SURYADI - DRIVER
        $karyawan27 = Karyawan::create([
            'nama' => 'Ketut Suryadi',
            'nik' => '101027',
            'divisi_id' => 6,
            'posisi' => 'Driver',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Raya Bogor No. 88, Depok 16345',
            'no_telepon' => '08125555555',
            'tanggal_lahir' => '1985-07-20',
            'tempat_lahir' => 'Depok',
            'pendidikan' => 'SMA',
            'gaji' => 3200000,
            'status' => 'Aktif',
            'foto' => 'ketut.png',
            'keterangan' => 'Driver profesional dengan SIM A internasional. Bertanggung jawab dalam pengiriman dan transportasi karyawan.',
        ]);
        User::create([
            'karyawan_id' => $karyawan27->id,
            'name' => 'Ketut Suryadi',
            'email' => 'ketut.suryadi@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 28. LILIS HANDAYANI - CLEANING SERVICE
        $karyawan28 = Karyawan::create([
            'nama' => 'Lilis Handayani',
            'nik' => '101028',
            'divisi_id' => 6,
            'posisi' => 'Cleaning Service Staff',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Cilangkap No. 99, Jakarta Timur 12345',
            'no_telepon' => '08126666666',
            'tanggal_lahir' => '1988-11-02',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'SMA',
            'gaji' => 2800000,
            'status' => 'Aktif',
            'foto' => 'lilis.png',
            'keterangan' => 'Cleaning Service Staff yang menjaga kebersihan dan kerapihan area kantor setiap hari.',
        ]);
        User::create([
            'karyawan_id' => $karyawan28->id,
            'name' => 'Lilis Handayani',
            'email' => 'lilis.handayani@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 29. MUHAMAD RIZKY - INTERN
        $karyawan29 = Karyawan::create([
            'nama' => 'Muhamad Rizky',
            'nik' => '101029',
            'divisi_id' => 1,
            'posisi' => 'IT Intern',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Kampus No. 44, Jakarta Selatan 12345',
            'no_telepon' => '08127777777',
            'tanggal_lahir' => '2002-05-14',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'Mahasiswa S1 Teknik Informatika',
            'gaji' => 1500000,
            'status' => 'Aktif',
            'foto' => 'muhamad.png',
            'keterangan' => 'IT Intern yang sedang belajar dan berkontribusi dalam project development. Akan permanent setelah lulus.',
        ]);
        User::create([
            'karyawan_id' => $karyawan29->id,
            'name' => 'Muhamad Rizky',
            'email' => 'muhamad.rizky@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // 30. NUR AZIZAH - MEDICAL OFFICER (TIDAK AKTIF)
        $karyawan30 = Karyawan::create([
            'nama' => 'Nur Azizah',
            'nik' => '101030',
            'divisi_id' => 2,
            'posisi' => 'Medical Officer',
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'Jl. Perhubungan No. 55, Jakarta Pusat 12345',
            'no_telepon' => '08128888888',
            'tanggal_lahir' => '1989-02-28',
            'tempat_lahir' => 'Jakarta',
            'pendidikan' => 'S1 Keperawatan',
            'gaji' => 5000000,
            'status' => 'Tidak Aktif',
            'foto' => 'nur.png',
            'keterangan' => 'Medical Officer - Status: Tidak aktif sejak 15 November 2024 karena mengundurkan diri untuk melanjutkan pendidikan Master Kesehatan di universitas luar negeri. Kontribusi bagus dalam program kesehatan karyawan selama 5 tahun.',
        ]);
        User::create([
            'karyawan_id' => $karyawan30->id,
            'name' => 'Nur Azizah',
            'email' => 'nur.azizah@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        // ADMIN USER (Tanpa karyawan_id)
        User::create([
            'karyawan_id' => null,
            'name' => 'Admin Pasentra',
            'email' => 'admin@pasentra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
        ]);
    }
}

