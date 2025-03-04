<?php
echo '<pre>';
print_r($pelanggaran);
exit;
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Pelanggaran</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage'); ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?php echo site_url('manage/pelanggaran'); ?>">Pelanggaran</a></li>
            <li class="active">Edit Pelanggaran</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Edit Pelanggaran</h3>
                    </div>
                    <?php echo form_open(current_url()); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?php echo $pelanggaran['tanggal']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Poin</label>
                            <input type="number" name="poin" class="form-control" value="<?php echo $pelanggaran['poin']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Pelanggaran</label>
                            <input type="text" name="pelanggaran" class="form-control" value="<?php echo $pelanggaran['pelanggaran']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Tindakan</label>
                            <input type="text" name="tindakan" class="form-control" value="<?php echo $pelanggaran['tindakan']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control"><?php echo $pelanggaran['catatan']; ?></textarea>
                        </div>
                        <input type="hidden" name="student_id" value="<?php echo $pelanggaran['student_id']; ?>">
                        <input type="hidden" name="period_id" value="<?php echo $pelanggaran['period_id']; ?>">
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?php echo site_url('manage/pelanggaran?n=' . $period_id . '&r=' . $student_id); ?>" class="btn btn-default">Batal</a>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
