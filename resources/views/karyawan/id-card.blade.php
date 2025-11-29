<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card - {{ $karyawan->nama }}</title>

    <style>
        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .id-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .id-card {
            width: 180mm;
            min-height: 100mm;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            background: #ffffff;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.08);
        }

        /* LEFT SECTION */
        .left {
            width: 60mm;
            background: linear-gradient(180deg, #003da5 0%, #0050c8 100%);
            color: white;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            padding: 12px 8px;
        }

        .logo {
            width: 34mm;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .company-sub {
            font-size: 8pt;
            opacity: 0.85;
            margin-bottom: 12px;
        }

        /* PHOTO BOX CENTER */
        .photo-box {
            width: 46mm;
            height: 56mm;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.4);

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* aman tidak pernah crop */
        }

        /* RIGHT SECTION */
        .right {
            flex: 1;
            padding: 16px 18px;
            background: #fafafa;
            display: flex;
            flex-direction: column;
        }

        .header {
            padding-bottom: 6px;
            border-bottom: 2px solid #003da5;
            margin-bottom: 12px;
        }

        .header-title {
            font-size: 16pt;
            color: #003da5;
            font-weight: bold;
            margin: 0;
        }

        .header-sub {
            font-size: 9pt;
            color: #666;
            margin: 0;
        }

        .name {
            font-size: 15pt;
            font-weight: bold;
            color: #003da5;
            margin-bottom: 3px;
        }

        .position {
            font-size: 10pt;
            color: #444;
            margin-bottom: 14px;
        }

        /* INFO TABLE */
        table {
            width: 100%;
            font-size: 9.5pt;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td.label {
            width: 30mm;
            font-weight: bold;
            color: #555;
            padding: 5px 0;
        }

        td.value {
            color: #222;
            padding: 5px 0;
            word-break: break-word;
        }

        .status-tag {
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 8.5pt;
            display: inline-block;
        }

        /* FOOTER */
        .footer {
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 9pt;

            display: flex;
            justify-content: flex-end;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="id-wrapper">
        <div class="id-card">

            <!-- LEFT SIDE -->
            <div class="left">
                <img src="{{ public_path('assets/images/logo123.png') }}" class="logo">

                <div class="company-name">PT PASENTRA</div>
                <div class="company-sub">EMPLOYEE ID CARD</div>

                <div class="photo-box">
                    @if ($karyawan->foto)
                        <img src="{{ public_path('storage/karyawan/' . $karyawan->foto) }}">
                    @else
                        <div style="
                            width:100%;height:100%;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:26pt;
                            color:#888;
                        ">
                            {{ substr($karyawan->nama, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="right">

                <div class="header">
                    <p class="header-title">ID CARD</p>
                    <p class="header-sub">Kartu Identitas Karyawan</p>
                </div>

                <div class="name">{{ $karyawan->nama }}</div>
                <div class="position">{{ $karyawan->posisi ?? '-' }}</div>

                <table>
                    <tr>
                        <td class="label">Divisi</td>
                        <td class="value">{{ $karyawan->divisi->nama ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Alamat</td>
                        <td class="value">{{ $karyawan->alamat ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Telepon</td>
                        <td class="value">{{ $karyawan->no_telepon ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Email</td>
                        <td class="value">{{ $karyawan->user->email ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="label">Status</td>
                        <td class="value">
                            <span class="status-tag"
                                style="background: {{ $karyawan->status === 'Aktif' ? '#d4edda' : '#f8d7da' }};
                                       color: {{ $karyawan->status === 'Aktif' ? '#155724' : '#721c24' }};">
                                {{ $karyawan->status }}
                            </span>
                        </td>
                    </tr>
                </table>

                <div class="footer">
                    Terbit: {{ $karyawan->created_at->format('m/Y') }}
                </div>

            </div>

        </div>
    </div>

</body>

</html>
