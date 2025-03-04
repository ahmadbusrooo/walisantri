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

                <!-- Form Pengurus -->
                <?php echo form_open('pengurus/save'); ?>
                <?php if (isset($pengurus)) { ?>
                    <input type="hidden" name="pengurus_id" value="<?php echo $pengurus['pengurus_id']; ?>">
                <?php } ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Nama Pengurus</strong></label>
                            <input type="text" class="form-control" name="pengurus_nama" 
                                   value="<?php echo isset($pengurus) ? $pengurus['pengurus_nama'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label><strong>NIK</strong></label>
                            <input type="text" class="form-control" name="pengurus_nik" 
                                   value="<?php echo isset($pengurus) ? $pengurus['pengurus_nik'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label><strong>Tanggal Lahir</strong></label>
                            <input type="date" class="form-control" name="pengurus_tgl_lahir" 
                                   value="<?php echo isset($pengurus) ? $pengurus['pengurus_tgl_lahir'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label><strong>Alamat Pengurus</strong></label>
                            <textarea name="pengurus_alamat" class="form-control" required><?php echo isset($pengurus) ? $pengurus['pengurus_alamat'] : ''; ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Nomor Telepon</strong></label>
                            <input type="text" name="pengurus_telepon" class="form-control" 
                                   value="<?php echo isset($pengurus) ? $pengurus['pengurus_telepon'] : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label><strong>Status Pengurus</strong></label>
                            <select name="pengurus_status" class="form-control" required>
                                <option value="1" <?php echo (isset($pengurus) && $pengurus['pengurus_status'] == 1) ? 'selected' : ''; ?>>Aktif</option>
                                <option value="0" <?php echo (isset($pengurus) && $pengurus['pengurus_status'] == 0) ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="form-group">
    <label><strong>Jabatan</strong></label>
    <select name="pengurus_jabatan" class="form-control" required>
        <option value="">-- Pilih Jabatan --</option>
        <option value="Ketua" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Ketua') ? 'selected' : ''; ?>>Ketua</option>
        <option value="Sekretaris" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Sekretaris') ? 'selected' : ''; ?>>Sekretaris</option>
        <option value="Bendahara" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Bendahara') ? 'selected' : ''; ?>>Bendahara</option>
        <option value="Keamanan" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Keamanan') ? 'selected' : ''; ?>>Keamanan</option>
        <option value="Pendidikan" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Pendidikan') ? 'selected' : ''; ?>>Pendidikan</option>
        <option value="M3" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'M3') ? 'selected' : ''; ?>>M3</option>
        <option value="Kebersihan" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Kebersihan') ? 'selected' : ''; ?>>Kebersihan</option>
        <option value="Pembangunan" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Pembangunan') ? 'selected' : ''; ?>>Pembangunan</option>
        <option value="Kesehatan" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Kesehatan') ? 'selected' : ''; ?>>Kesehatan</option>
        <option value="Perlengkapan" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Perlengkapan') ? 'selected' : ''; ?>>Perlengkapan</option>
        <option value="Media" <?php echo (isset($pengurus) && $pengurus['pengurus_jabatan'] == 'Media') ? 'selected' : ''; ?>>Media</option>
    </select>
</div>

                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo site_url('pengurus'); ?>" class="btn btn-secondary"><i class="fa fa-times"></i> Batal</a>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </section>
</div>
