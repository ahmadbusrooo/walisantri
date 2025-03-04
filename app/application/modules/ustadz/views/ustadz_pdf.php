<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Ustadz</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 15px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-sizing: border-box;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 5px 0;
            color: #2c3e50;
        }
        .header p {
            margin: 2px 0;
            color: #7f8c8d;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            background: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }
        th {
            background-color: rgb(169, 223, 147);
            color: black;
            text-transform: uppercase;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: right;
            font-size: 12px;
            margin-top: 20px;
            color: #555;
        }
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            .container {
                width: 100%;
                padding: 10px;
            }
            th, td {
                font-size: 10px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3><?= $setting_school['setting_value'] ?></h3>
            <p><?= $setting_address['setting_value'] ?>, <?= $setting_city['setting_value'] ?> - <?= $setting_district['setting_value'] ?></p>
            <p>Telp: <?= $setting_phone['setting_value'] ?></p>
            <hr>
            <h4>Laporan Data Ustadz</h4>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>Tanggal Lahir</th>
                    <th>Status</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($ustadz as $u): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $u['ustadz_nama'] ?></td>
                    <td><?= $u['ustadz_nik'] ?></td>
                    <td><?= date('d-m-Y', strtotime($u['ustadz_tgl_lahir'])) ?></td>
                    <td><?= ($u['ustadz_status'] == 1) ? 'Aktif' : 'Tidak Aktif' ?></td>
                    <td><?= $u['ustadz_alamat'] ?></td>
                    <td><?= $u['ustadz_telepon'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="footer">
            <p><strong>Dicetak pada:</strong> <?= date('d-m-Y H:i') ?></p>
        </div>
    </div>
</body>
</html>
