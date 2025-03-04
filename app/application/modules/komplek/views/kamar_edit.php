<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo isset($kamar) ? 'Edit' : 'Tambah'; ?> Kamar</h1>
    </section>

    <section class="content">
        <?php echo form_open(current_url()); ?>
        <div class="box box-primary">
            <div class="box-body">
                <?php echo validation_errors(); ?>

                <div class="form-group">
                    <label>Nama Kamar <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                    <input name="majors_name" type="text" class="form-control" value="<?php echo isset($kamar) ? $kamar['majors_name'] : set_value('majors_name'); ?>" placeholder="Isi Nama Kamar">
                </div>

                <input type="hidden" name="komplek_id" value="<?php echo $kamar['komplek_id']; ?>">
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?php echo site_url('komplek/kamar/' . $kamar['komplek_id']); ?>" class="btn btn-info">Batal</a>
            </div>
        </div>
        <?php echo form_close(); ?>
    </section>
</div>
