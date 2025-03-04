<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? $title : 'Tambah Pelanggaran'; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?php echo site_url('manage/pelanggaran') ?>">Pelanggaran</a></li>
            <li class="active">Tambah Pelanggaran</li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Tambah Pelanggaran</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open(site_url('manage/pelanggaran/add'), array('class' => 'form-horizontal')) ?>
                        
                        <!-- Dropdown Pilih Siswa -->
                        <div class="form-group">
                            <label for="student_id" class="col-sm-2 control-label">Pilih Siswa</label>
                            <div class="col-sm-6">
                                <select id="student_id" name="student_id" class="form-control select2" required>
                                    <option value="">Pilih Siswa</option>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?php echo $student['student_id']; ?>">
                                            <?php echo $student['student_nis'] . ' - ' . $student['student_full_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Dropdown Pilih Kelas -->
                        <div class="form-group">
                            <label for="class_id" class="col-sm-2 control-label">Pilih Kelas</label>
                            <div class="col-sm-6">
                                <select id="class_id" name="class_id" class="form-control select2" required>
                                    <option value="">Pilih Kelas</option>
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?php echo $class['class_id']; ?>">
                                            <?php echo $class['class_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Dropdown Pilih Periode -->
                        <div class="form-group">
                            <label for="period_id" class="col-sm-2 control-label">Pilih Periode</label>
                            <div class="col-sm-6">
                                <select id="period_id" name="period_id" class="form-control select2" required>
                                    <option value="">Pilih Periode</option>
                                    <?php foreach ($periods as $period): ?>
                                        <option value="<?php echo $period['period_id']; ?>">
                                            <?php echo $period['period_start'] . '/' . $period['period_end']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Input Tanggal -->
                        <div class="form-group">
                            <label for="tanggal" class="col-sm-2 control-label">Tanggal</label>
                            <div class="col-sm-6">
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                        </div>

                        <!-- Input Poin -->
                        <div class="form-group">
                            <label for="poin" class="col-sm-2 control-label">Poin</label>
                            <div class="col-sm-6">
                                <input type="number" name="poin" class="form-control" placeholder="Masukkan Poin Pelanggaran" required>
                            </div>
                        </div>

                        <!-- Input Pelanggaran -->
                        <div class="form-group">
                            <label for="pelanggaran" class="col-sm-2 control-label">Pelanggaran</label>
                            <div class="col-sm-6">
                                <input type="text" name="pelanggaran" class="form-control" placeholder="Jenis Pelanggaran" required>
                            </div>
                        </div>

                        <!-- Input Tindakan -->
                        <div class="form-group">
                            <label for="tindakan" class="col-sm-2 control-label">Tindakan</label>
                            <div class="col-sm-6">
                                <input type="text" name="tindakan" class="form-control" placeholder="Tindakan yang Diambil" required>
                            </div>
                        </div>

                        <!-- Input Catatan -->
                        <div class="form-group">
                            <label for="catatan" class="col-sm-2 control-label">Catatan</label>
                            <div class="col-sm-6">
                                <textarea name="catatan" class="form-control" placeholder="Catatan Tambahan (Opsional)"></textarea>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="<?php echo site_url('manage/pelanggaran'); ?>" class="btn btn-default">Batal</a>
                            </div>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Tambahkan CSS dan JS Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Data",
            allowClear: true
        });
    });
</script>
