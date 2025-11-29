<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Karyawan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            background: white;
        }

        .page-break {
            page-break-after: always;
            margin-bottom: 40px;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            margin: -10px -10px 30px -10px;
            text-align: center;
            border-bottom: 4px solid #e74c3c;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 8px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .header .company-name {
            font-size: 16px;
            margin-bottom: 12px;
            opacity: 0.95;
        }

        .header .print-info {
            font-size: 11px;
            opacity: 0.8;
            border-top: 1px solid rgba(255,255,255,0.3);
            padding-top: 10px;
            margin-top: 10px;
        }

        /* Karyawan Card */
        .karyawan-card {
            margin-bottom: 40px;
            padding: 0;
            border: 2px solid #ecf0f1;
            border-radius: 12px;
            background-color: #fff;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        /* Card Header with Photo */
        .card-header {
            background: linear-gradient(135deg, #ecf0f1 0%, #bdc3c7 100%);
            display: flex;
            gap: 30px;
            padding: 30px;
            align-items: flex-start;
        }

        .card-photo {
            width: 140px;
            height: 140px;
            border-radius: 12px;
            border: 4px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 48px;
            font-weight: bold;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .card-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-info {
            flex: 1;
            padding-top: 10px;
        }

        .card-info h2 {
            color: #2c3e50;
            font-size: 26px;
            margin-bottom: 12px;
            font-weight: bold;
        }

        .card-info-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 13px;
            align-items: center;
        }

        .card-info-label {
            font-weight: bold;
            color: #555;
            width: 120px;
            min-width: 120px;
        }

        .card-info-value {
            color: #333;
            flex: 1;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 12px;
            margin-top: 5px;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Section Title */
        .section-title {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            padding: 14px 25px;
            margin: 25px 0 15px 0;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            border-left: 4px solid #e74c3c;
        }

        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
            padding: 0 30px;
        }

        .detail-box {
            padding: 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 12px;
        }

        .detail-box-label {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 6px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-box-value {
            color: #333;
            word-wrap: break-word;
            line-height: 1.5;
        }

        /* History Section */
        .history-section {
            padding: 0 30px 30px 30px;
        }

        /* History Table */
        .history-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
            border-radius: 6px;
            overflow: hidden;
        }

        .history-table thead {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
            color: white;
        }

        .history-table th {
            border: none;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #2c3e50;
        }

        .history-table td {
            border: 1px solid #ecf0f1;
            padding: 10px 12px;
            vertical-align: top;
        }

        .history-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .history-table tbody tr:hover {
            background-color: #ecf0f1;
        }

        .action-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: bold;
            color: white;
            font-size: 10px;
            text-transform: uppercase;
        }

        .badge-create {
            background-color: #27ae60;
        }

        .badge-update {
            background-color: #f39c12;
            color: white;
        }

        .badge-delete {
            background-color: #e74c3c;
        }

        /* Empty State */
        .no-history {
            text-align: center;
            padding: 30px;
            color: #95a5a6;
            font-style: italic;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px dashed #bdc3c7;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #ecf0f1;
            text-align: center;
            font-size: 11px;
            color: #666;
        }

        .generated-info {
            font-size: 10px;
            color: #95a5a6;
            text-align: right;
            margin-top: 15px;
        }

        /* Page Counter */
        .page-counter {
            text-align: right;
            font-size: 10px;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>📋 LAPORAN DATA KARYAWAN</h1>
        <div class="company-name">PT PASIFIK ENERGI TRANS</div>
        <div class="print-info">
            Tanggal Cetak: {{ $generatedAt->format('d F Y H:i') }}
        </div>
    </div>

    @forelse($karyawans as $index => $karyawan)
    <!-- Karyawan Card -->
    <div class="karyawan-card">
        <!-- Card Header with Photo -->
        <div class="card-header">
            <div class="card-photo">
                @if($karyawan->foto)
                    <img src="{{ public_path('storage/karyawan/' . $karyawan->foto) }}" alt="{{ $karyawan->nama }}">
                @else
                    {{ substr($karyawan->nama, 0, 1) }}
                @endif
            </div>
            <div class="card-info">
                <h2>{{ $karyawan->nama }}</h2>
                <div class="card-info-row">
                    <span class="card-info-label">NIK</span>
                    <span class="card-info-value"><strong>{{ $karyawan->nik }}</strong></span>
                </div>
                <div class="card-info-row">
                    <span class="card-info-label">Posisi</span>
                    <span class="card-info-value">{{ $karyawan->posisi }}</span>
                </div>
                <div class="card-info-row">
                    <span class="card-info-label">Divisi</span>
                    <span class="card-info-value">{{ $karyawan->divisi->nama ?? 'N/A' }}</span>
                </div>
                <div class="card-info-row">
                    <span class="card-info-label">Gaji</span>
                    <span class="card-info-value"><strong>Rp {{ number_format($karyawan->gaji ?? 0, 0, ',', '.') }}</strong></span>
                </div>
                <div class="card-info-row">
                    <span class="card-info-label">Status</span>
                    <span class="card-info-value">
                        <span class="status-badge {{ $karyawan->status === 'Aktif' ? 'status-active' : 'status-inactive' }}">
                            {{ $karyawan->status }}
                        </span>
                    </span>
                </div>
                <div class="card-info-row" style="margin-top: 8px;">
                    <span class="card-info-label">Bergabung</span>
                    <span class="card-info-value">{{ $karyawan->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="section-title">📄 INFORMASI DETAIL</div>
        <div class="details-grid">
            <div class="detail-box">
                <div class="detail-box-label">Jenis Kelamin</div>
                <div class="detail-box-value">{{ $karyawan->jenis_kelamin }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-box-label">Jenis Kelamin Alternatif</div>
                <div class="detail-box-value">
                    @if($karyawan->jenis_kelamin === 'Laki-laki')
                        Laki-laki / Pria
                    @else
                        Perempuan / Wanita
                    @endif
                </div>
            </div>
            <div class="detail-box">
                <div class="detail-box-label">Alamat Lengkap</div>
                <div class="detail-box-value">{{ $karyawan->alamat ?? '(Tidak ada data)' }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-box-label">Divisi Kerja</div>
                <div class="detail-box-value">{{ $karyawan->divisi->nama ?? '(Tidak ada data)' }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-box-label">Gaji Pokok</div>
                <div class="detail-box-value"><strong>Rp {{ number_format($karyawan->gaji ?? 0, 0, ',', '.') }}</strong></div>
            </div>
            <div class="detail-box">
                <div class="detail-box-label">Tanggal Bergabung</div>
                <div class="detail-box-value">{{ $karyawan->created_at->format('d F Y') }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-box-label">Terakhir Diperbarui</div>
                <div class="detail-box-value">{{ $karyawan->updated_at->format('d F Y H:i') }}</div>
            </div>
        </div>

        <!-- Keterangan Section -->
        <div style="padding: 0 30px 20px 30px;">
            @php
                $hasKeterangan = isset($karyawan->keterangan) && !empty(trim($karyawan->keterangan));
            @endphp
            
            @if($hasKeterangan)
                <div class="section-title" style="margin: 15px 0;">ℹ️ KETERANGAN TAMBAHAN</div>
                <div class="detail-box" style="grid-column: 1 / -1; background: linear-gradient(135deg, #fef9e7 0%, #fef5e0 100%); border-left: 4px solid #f39c12;">
                    <div class="detail-box-value" style="white-space: pre-wrap; word-break: break-word; line-height: 1.6;">{{ $karyawan->keterangan }}</div>
                </div>
            @else
                <div class="detail-box" style="grid-column: 1 / -1; color: #95a5a6; font-style: italic; background: #f8f9fa;">
                    <small>Tidak ada keterangan tambahan untuk karyawan ini</small>
                </div>
            @endif
        </div>

        <!-- History Section -->
        <div class="history-section">
            <div class="section-title">📜 RIWAYAT PERUBAHAN DATA</div>
            @if(isset($histories[$karyawan->id]) && count($histories[$karyawan->id]) > 0)
                <table class="history-table">
                    <thead>
                        <tr>
                            <th width="18%">Tanggal & Waktu</th>
                            <th width="10%">Aksi</th>
                            <th width="15%">User</th>
                            <th width="57%">Keterangan Perubahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories[$karyawan->id] as $history)
                        <tr>
                            <td>
                                <strong>{{ $history->created_at->format('d/m/Y') }}</strong>
                                <br>
                                <small>{{ $history->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                @if($history->action === 'create')
                                    <span class="action-badge badge-create">Tambah</span>
                                @elseif($history->action === 'update')
                                    <span class="action-badge badge-update">Edit</span>
                                @else
                                    <span class="action-badge badge-delete">Hapus</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $history->user->name ?? 'System' }}</strong>
                            </td>
                            <td>
                                @if($history->action === 'create')
                                    <strong style="color: #27ae60;">✓ Data karyawan ditambahkan ke sistem</strong>
                                @elseif($history->action === 'delete')
                                    <strong style="color: #e74c3c;">✕ Data karyawan dihapus dari sistem</strong>
                                @else
                                    @php
                                        $changes = [];
                                        if ($history->old_data && $history->new_data) {
                                            foreach ($history->new_data as $key => $newVal) {
                                                if (isset($history->old_data[$key]) && $history->old_data[$key] != $newVal) {
                                                    $changes[] = $key;
                                                }
                                            }
                                        }
                                    @endphp
                                    @if(count($changes) > 0)
                                        <strong style="color: #f39c12;">{{ count($changes) }} field diubah:</strong>
                                        <br>
                                        <small>{{ implode(', ', $changes) }}</small>
                                    @else
                                        <small style="color: #95a5a6;">Tidak ada perubahan signifikan</small>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-history">
                    <p>📭 Belum ada riwayat perubahan data untuk karyawan ini</p>
                </div>
            @endif
        </div>
    </div>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
    @empty
    <div class="no-history">
        <p>Tidak ada data karyawan yang tersedia</p>
    </div>
    @endforelse

    <!-- Footer -->
    <div class="footer">
        <div>✓ Dokumen ini dicetak otomatis dari Sistem Kelola Karyawan PT PASIFIK ENERGI TRANS</div>
        <div class="generated-info">
            Dihasilkan pada: {{ $generatedAt->format('d F Y \\p\\u\\k\\u\\l H:i:s') }}
            <br>
            Total Karyawan: {{ count($karyawans) }}
        </div>
    </div>
</body>
</html>

