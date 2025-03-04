<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Santri</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: auto;
            padding: 10px;
            text-align: center;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h3, .header p {
            margin: 5px 0;
        }
        .sub-header {
            text-align: left;
            font-size: 12px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: rgb(169, 223, 147);
            text-transform: uppercase;
        }
        .footer {
            text-align: right;
            font-size: 12px;
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Laporan -->
        <div class="header">
            <h3><?= isset($setting_school['setting_value']) ? $setting_school['setting_value'] : 'Nama Sekolah' ?></h3>
            <p><?= isset($setting_address['setting_value']) ? $setting_address['setting_value'] : '-' ?>, 
                <?= isset($setting_city['setting_value']) ? $setting_city['setting_value'] : '-' ?> - 
                <?= isset($setting_district['setting_value']) ? $setting_district['setting_value'] : '-' ?>
            </p>
            <p>Telp: <?= isset($setting_phone['setting_value']) ? $setting_phone['setting_value'] : '-' ?></p>
            <hr>
            <h4>Laporan Data Santri</h4>
        </div>

        <!-- Info Kelas yang Dipilih -->
        <div class="sub-header">
            <p><strong>Kelas:</strong> <?= isset($selected_class) ? $selected_class : 'Semua Kelas' ?></p>
        </div>

        <!-- Tabel Data Santri -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Tempat, Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Kamar</th> <!-- Kamar dipindahkan setelah alamat -->
                    <th>Kelas</th>
                    <th>Nama Ayah</th>
                    <th>Nama Ibu</th>
                    <th>No. HP</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($students as $student): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= isset($student['student_nis']) ? $student['student_nis'] : '-' ?></td>
                    <td><?= isset($student['student_full_name']) ? $student['student_full_name'] : '-' ?></td>
                    <td>
                        <?= isset($student['student_born_place']) && !empty($student['student_born_place']) ? $student['student_born_place'] : '-' ?>, 
                        <?= isset($student['student_born_date']) && !empty($student['student_born_date']) ? date('d-m-Y', strtotime($student['student_born_date'])) : '-' ?>
                    </td>
                    <td><?= isset($student['student_address']) ? $student['student_address'] : '-' ?></td>
                    <td><?= isset($student['majors_name']) ? $student['majors_name'] : '-' ?></td> <!-- Kamar dipindahkan ke sini -->
                    <td><?= isset($student['class_name']) ? $student['class_name'] : '-' ?></td>
                    <td><?= isset($student['student_name_of_father']) ? $student['student_name_of_father'] : '-' ?></td>
                    <td><?= isset($student['student_name_of_mother']) ? $student['student_name_of_mother'] : '-' ?></td>
                    <td><?= isset($student['student_phone']) ? $student['student_phone'] : '-' ?></td>
                    <td>
                        <span>
                            <?= isset($student['student_status']) ? (($student['student_status'] == 1) ? 'Aktif' : 'Tidak Aktif') : '-' ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Dicetak pada:</strong> <?= date('d-m-Y H:i') ?></p>
        </div>
    </div>
</body>
</html>
