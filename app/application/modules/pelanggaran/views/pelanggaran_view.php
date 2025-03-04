<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? $title : 'Detail Pelanggaran Siswa'; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?php echo site_url('manage/pelanggaran') ?>">Pelanggaran</a></li>
            <li class="active">Detail Pelanggaran</li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Informasi Siswa -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informasi Siswa</h3>
                    </div>
                    <div class="box-body">
                    <table class="table table-striped">
    <tr>
        <td width="200">Nama Siswa</td>
        <td width="10">:</td>
        <td><?php echo isset($student['student_full_name']) ? $student['student_full_name'] : '-'; ?></td>
    </tr>
    <tr>
        <td>NIS</td>
        <td>:</td>
        <td><?php echo isset($student['student_nis']) ? $student['student_nis'] : '-'; ?></td>
    </tr>
    <tr>
        <td>Kelas</td>
        <td>:</td>
        <td><?php echo isset($student['class_name']) ? $student['class_name'] : '-'; ?></td>
    </tr>
    <tr>
        <td>Periode</td>
        <td>:</td>
        <td><?php echo isset($student['period_start']) && isset($student['period_end']) 
                ? $student['period_start'] . '/' . $student['period_end'] 
                : '-'; ?></td>
    </tr>
    <tr>
        <td>Nama Ibu Kandung</td>
        <td>:</td>
        <td><?php echo isset($student['student_name_of_mother']) ? $student['student_name_of_mother'] : '-'; ?></td>
    </tr>
</table>

                    </div>
                </div>

                <!-- Data Pelanggaran -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Pelanggaran</h3>
                        <a href="<?php echo site_url('manage/pelanggaran/add') ?>" class="btn btn-success btn-sm pull-right">
                            <i class="fa fa-plus"></i> Tambah Pelanggaran
                        </a>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="info">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Poin</th>
                                    <th>Pelanggaran</th>
                                    <th>Tindakan</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pelanggaran)): ?>
                                    <?php $no = 1; foreach ($pelanggaran as $row): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['tanggal']; ?></td>
                                            <td><?php echo $row['poin']; ?></td>
                                            <td><?php echo $row['pelanggaran']; ?></td>
                                            <td><?php echo $row['tindakan']; ?></td>
                                            <td><?php echo $row['catatan']; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('manage/pelanggaran/edit/' . $row['pelanggaran_id']); ?>" class="btn btn-warning btn-xs">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="<?php echo site_url('manage/pelanggaran/delete/' . $row['pelanggaran_id']); ?>" 
                                                   class="btn btn-danger btn-xs" 
                                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Data pelanggaran kosong.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
