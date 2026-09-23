<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perangkingan WASPAS Kamera - {{ date('Y-m-d') }}</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 30px;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 8px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .footer-sign {
            margin-top: 40px;
            float: right;
            text-align: center;
            width: 200px;
        }
        .no-print {
            margin-bottom: 20px;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4f46e5; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            🖨️ Cetak / Print Laporan
        </button>
    </div>

    <div class="header">
        <h2>SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN KAMERA</h2>
        <h2>LAPORAN PERANGKINGAN METODE WASPAS</h2>
        <p>Tanggal Cetak: {{ date('d F Y, H:i') }} WIB • Parameter Lambda (&lambda;): 0.5</p>
    </div>

    <h3>Daftar Peringkat Rekomendasi Kamera</h3>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="8%">Rank</th>
                <th width="10%">Kode</th>
                <th width="30%">Nama Kamera</th>
                <th width="15%">Merk</th>
                <th width="20%" class="text-center">Qi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankings as $item)
                <tr style="{{ $item['rank'] == 1 ? 'background-color: #fffbeb;' : '' }}">
                    <td class="text-center font-bold">#{{ $item['rank'] }}</td>
                    <td class="font-bold">{{ $item['kamera']->kode }}</td>
                    <td class="font-bold">{{ $item['kamera']->nama }}</td>
                    <td>{{ $item['kamera']->merk }}</td>
                    <td class="text-center font-bold" style="color: #4f46e5;">{{ number_format($item['qi'], 3) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-sign">
        <p>Tanggal: {{ date('d F Y') }}</p>
        <p>Administrator System</p>
        <br><br><br>
        <p><b>( Admin WASPAS )</b></p>
    </div>

</body>
</html>
