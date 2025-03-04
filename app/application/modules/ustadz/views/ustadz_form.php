<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-body">

                <!-- Tampilkan Pesan Error -->
                <?php if ($this->session->flashdata('error')) { ?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
    </div>
<?php } ?>

<?php if ($this->session->flashdata('success')) { ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php } ?>


                <!-- Form Ustadz -->
                <?php echo form_open('ustadz/save'); ?>
                <?php if (isset($ustadz)) { ?>
                    <input type="hidden" name="ustadz_id" value="<?php echo $ustadz['ustadz_id']; ?>">
                <?php } ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Nama Ustadz</strong></label>
                            <input type="text" class="form-control" name="ustadz_nama" 
                                   value="<?php echo isset($ustadz) ? $ustadz['ustadz_nama'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label><strong>NIK</strong></label>
                            <input type="text" class="form-control" name="ustadz_nik" 
                                   value="<?php echo isset($ustadz) ? $ustadz['ustadz_nik'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label><strong>Tanggal Lahir</strong></label>
                            <input type="date" class="form-control" name="ustadz_tgl_lahir" 
                                   value="<?php echo isset($ustadz) ? $ustadz['ustadz_tgl_lahir'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label><strong>Alamat Ustadz</strong></label>
                            <textarea name="ustadz_alamat" class="form-control" required><?php echo isset($ustadz) ? $ustadz['ustadz_alamat'] : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Nomor Telepon</strong></label>
                            <input type="text" name="ustadz_telepon" class="form-control" 
                                   value="<?php echo isset($ustadz) ? $ustadz['ustadz_telepon'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label><strong>Status Ustadz</strong></label>
                            <select name="ustadz_status" class="form-control" required>
                                <option value="1" <?php echo (isset($ustadz) && $ustadz['ustadz_status'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                                <option value="0" <?php echo (isset($ustadz) && $ustadz['ustadz_status'] == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><strong>Kelas Mengajar</strong></label>
                            <select name="class_id" class="form-control">
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($classes as $class) { ?>
                                    <option value="<?php echo $class['class_id']; ?>" 
                                        <?php echo isset($ustadz) && $ustadz['class_id'] == $class['class_id'] ? 'selected' : ''; ?>>
                                        <?php echo $class['class_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo site_url('ustadz'); ?>" class="btn btn-secondary"><i class="fa fa-times"></i> Batal</a>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </section>
</div>
