<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan - SMKN 2 Padang</title>
    <style>
        /* 1. Pengaturan Kertas HVS (A4) */
        @media print {
            @page {
                size: A4;
                margin: 1.5cm 1cm 1.5cm 2cm; /* Atas, Kanan, Bawah, Kiri (Margin Kiri lebih lebar buat jilid) */
            }
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", Times, serif;
            color: #000;
            line-height: 1.2;
            background: #fff;
        }

        /* 2. KOP SURAT DENGAN LOGO */
        .kop-container {
            display: flex;
            align-items: center;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .logo-box {
            flex: 0 0 80px; /* Lebar area logo */
            text-align: left;
        }

        .logo-box img {
            width: 75px; /* Sesuaikan ukuran logo.png lu */
            height: auto;
        }

        .text-kop {
            flex: 1;
            text-align: center;
            padding-right: 80px; /* Biar teks bener-bener center imbang sama logo */
        }

        .text-kop h2 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
            font-weight: bold;
        }

        .text-kop h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
            font-weight: bold;
        }

        .text-kop p {
            margin: 2px 0;
            font-size: 9pt;
            font-style: italic;
        }

        .garis-kop {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-bottom: 20px;
        }

        /* 3. Judul & Info */
        h3 {
            text-align: center;
            text-transform: uppercase;
            font-size: 13pt;
            margin-bottom: 15px;
            text-decoration: underline;
        }

        .info-rekap {
            margin-bottom: 10px;
            font-size: 10pt;
        }

        /* 4. Tabel Laporan */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* Biar gak luber keluar kertas */
        }

        table, th, td {
            border: 1px solid black;
        }

        th {
            background-color: #e9e9e9 !important;
            padding: 8px 4px;
            font-size: 9pt;
            text-transform: uppercase;
        }

        td {
            padding: 6px 4px;
            font-size: 9pt;
            vertical-align: top;
            word-wrap: break-word; /* Biar teks panjang otomatis turun kebawah */
        }

        .text-center { text-align: center; }

        /* 5. Tanda Tangan */
        .signature-section {
            margin-top: 30px;
            width: 100%;
        }

        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }

        .space-ttd {
            height: 70px;
        }

        .clear { clear: both; }
    </style>
</head>
<body onload="window.print()">

    <div class="kop-container">
        <div class="logo-box">
            <img src="{{ asset('logo.png') }}" alt="Logo">
        </div>
        <div class="text-kop">
            <h2>PEMERINTAH PROVINSI SUMATERA BARAT</h2>
            <h2>DINAS PENDIDIKAN</h2>
            <h1>SMK NEGERI 2 PADANG</h1>
            <p>Jl. Jati No.5, Jati Baru, Kec. Padang Timur, Kota Padang, Sumatera Barat</p>
            <p>Email: smkn2padang@yahoo.com | Website: www.smkn2padang.sch.id</p>
        </div>
    </div>
    <div class="garis-kop"></div>

    <h3>{{ $title }}</h3>

    <div class="info-rekap">
        <strong>PERIODE:</strong> {{ $since }} s/d {{ $until }} <br>
        <strong>TOTAL:</strong> {{ count($data) }} Surat Masuk
    </div>

    <table>
        <thead>
            <tr>
                <th width="30px">No</th>
                <th width="60px">Agenda</th>
                <th width="120px">No. Surat</th>
                <th width="120px">Asal / Pengirim</th>
                <th width="80px">Tgl. Surat</th>
                <th>Perihal / Ringkasan</th>
                <th width="90px">Admin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $letter)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">#{{ $letter->agenda_number }}</td>
                    <td>{{ $letter->reference_number }}</td>
                    <td>{{ $letter->from }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($letter->letter_date)->format('d/m/Y') }}</td>
                    <td>{{ $letter->description }}</td>
                    <td class="text-center">{{ $letter->user->name ?? 'System' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature-section">
        <div class="ttd-box">
            <p>Padang, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Mengetahui,</p>
            <p><strong>Kepala SMKN 2 Padang</strong></p>
            <div class="space-ttd"></div>
            <p><strong><u>Drs. Nama Kepala Sekolah, M.Pd</u></strong></p>
            <p>NIP. 19700101 199501 1 001</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>