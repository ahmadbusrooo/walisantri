<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? $title : 'Filter Data Nadzhaman'; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage'); ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? $title : 'Filter Data Nadzhaman'; ?></li>
        </ol>
    </section>

 <!-- Main Content -->
<section class="content">
    <div class="row">
        <!-- Form Filter -->
        <div class="col-md-12">
        <div class="box box-info" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Data Nadzhaman</h3>
                </div>
                <div class="box-body">
                    <?php echo form_open('nadzhaman/filter_nadzhaman', ['class' => 'form-horizontal', 'method' => 'get']); ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Kelas</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="class_id" required>
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($classes as $class): ?>
                                    <option value="<?php echo $class['class_id']; ?>"
                                        <?php echo (isset($selected_class) && $selected_class == $class['class_id']) ? 'selected' : ''; ?>>
                                        <?php echo $class['class_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Tahun Pelajaran</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="period_id" required>
                                <option value="">Pilih Tahun Pelajaran</option>
                                <?php foreach ($periods as $period): ?>
                                    <option value="<?php echo $period['period_id']; ?>"
                                        <?php echo (isset($selected_period) && $selected_period == $period['period_id']) ? 'selected' : ''; ?>>
                                        <?php echo $period['period_start'] . '/' . $period['period_end']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="<?php echo site_url('manage'); ?>" class="btn btn-default">Batal</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Kitab Data -->
    <?php if (!empty($kitabs)): ?>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Kitab untuk Kelas dan Tahun Pelajaran Ini</h3>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kitab</th>
                    <th>Target Hafalan (Bait)</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($kitabs as $kitab): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $kitab['nama_kitab']; ?></td>
                    <td><?php echo $kitab['target_hafalan']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else: ?>
<div class="alert alert-warning">
    <strong>Perhatian!</strong> Tidak ada kitab yang terdaftar untuk kelas dan tahun pelajaran ini.
</div>
<?php endif; ?>


        <!-- Tabel Data Nadzhaman -->
        <?php if (!empty($nadzhaman)): ?>
            <div class="row">
            <div class="col-md-12">

	<div class="box box-success" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                    <div class="box-header with-border">
                        <h3 class="box-title">Data Nadzhaman Siswa</h3>
                        <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addNadzhamanModal">
                            <i class="fa fa-plus"></i> Tambah Data Nadzhaman
                        </button>
                    </div>
                    <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Tanggal</th>
            <th>Kitab</th>
            <th>Jumlah Hafalan</th>
            <th>Keterangan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($nadzhaman)): ?>
            <?php $no = 1; foreach ($nadzhaman as $row): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo isset($row['student_full_name']) ? $row['student_full_name'] : '-'; ?></td>
                    <td><?php echo isset($row['tanggal']) ? $row['tanggal'] : '-'; ?></td>
                    <td><?php echo isset($row['nama_kitab']) ? $row['nama_kitab'] : '-'; ?></td>
                    <td><?php echo isset($row['jumlah_hafalan']) ? $row['jumlah_hafalan'] : '-'; ?></td>
                    <td><?php echo isset($row['keterangan']) ? $row['keterangan'] : '-'; ?></td>
                    <td><?php echo isset($row['status']) ? $row['status'] : '-'; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Data tidak tersedia.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

                    </div>
                </div>
            </div>
        </div>
        
        <?php endif; ?>
    </section>

</div>

<!-- Modal Tambah Data Nadzhaman -->
<div class="modal fade" id="addNadzhamanModal" tabindex="-1" role="dialog" aria-labelledby="addNadzhamanModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

            <?php echo form_open('nadzhaman/bulk_add'); ?>
            <div class="modal-header">
                <h4 class="modal-title" id="addNadzhamanModalLabel">Tambah Data Nadzhaman</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="class_id" value="<?php echo $this->input->get('class_id'); ?>">
                <input type="hidden" name="period_id" value="<?php echo $this->input->get('period_id'); ?>">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Tanggal</th>
                            <th>Jumlah Hafalan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($santri as $index => $s): ?>
                            <tr>
                                <td>
                                    <?php echo $s['student_full_name']; ?>
                                    <input type="hidden" name="students[<?php echo $index; ?>][student_id]" value="<?php echo $s['student_id']; ?>">
                                </td>
                                <td>
    <input type="date" name="students[<?php echo $index; ?>][tanggal]" 
           class="form-control" 
           value="<?php echo date('Y-m-d'); ?>" required>
</td>

<td><input type="text" name="students[<?php echo $index; ?>][jumlah_hafalan]" class="form-control" required></td>

                                <td><input type="text" name="students[<?php echo $index; ?>][keterangan]" class="form-control"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
