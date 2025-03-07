<div class="content-wrapper">
    <section class="content-header">
        <h1>Laporan Data Santri</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active">Laporan Data Santri</li>
        </ol>
    </section>

    <section class="content">
    <div class="box" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
            <div class="box-header with-border">
                <h3 class="box-title">Total Santri: <strong><?php echo $total_students; ?></strong></h3>
                <div class="box-tools">
                <a href="<?php echo site_url('manage/student/print_report_pdf') . '?' . http_build_query($_GET); ?>" target="_blank" class="btn btn-danger btn-sm">
    <i class="fa fa-file-pdf"></i> Cetak PDF
</a>

</div>

            </div>

            <!-- Form Filter -->
            <div class="box-body">
                <form method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="n" class="form-control" placeholder="Cari NIS / Nama" value="<?php echo isset($f['n']) ? $f['n'] : ''; ?>">
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" name="class" onchange="this.form.submit()">
                                <option value="">-- Semua Kelas --</option>
                                <?php foreach ($classes as $row): ?>
                                    <option value="<?php echo $row['class_id']; ?>" <?php echo (isset($f['class']) && $f['class'] == $row['class_id']) ? 'selected' : ''; ?>>
                                        <?php echo $row['class_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
    <select class="form-control" name="komplek_id" onchange="this.form.submit()">
        <option value="">-- Semua Komplek --</option>
        <?php foreach ($komplek as $row): ?>
            <option value="<?php echo $row['komplek_id']; ?>" 
                <?php echo (isset($f['komplek_id']) && $f['komplek_id'] == $row['komplek_id']) ? 'selected' : ''; ?>>
                <?php echo $row['komplek_name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
                    </div>
                </form>
            </div>

            <!-- Tabel Laporan -->
            <div class="box-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($students)) { 
                            $i = 1;
                            foreach ($students as $row): ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['student_nis']; ?></td>
                                    <td><?php echo $row['student_full_name']; ?></td>
                                    <td><?php echo $row['class_name']; ?></td>
                                    <td>
                                        <span class="label <?php echo ($row['student_status'] == 1) ? 'label-success' : 'label-danger'; ?>">
                                            <?php echo ($row['student_status'] == 1) ? 'Aktif' : 'Tidak Aktif'; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; 
                        } else { ?>
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript Cetak -->
<script>
function printReport() {
    window.print();
}
</script>
