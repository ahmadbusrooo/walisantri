<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo isset($komplek) ? 'Edit' : 'Tambah'; ?> Komplek</h1>
    </section>

    <section class="content">
        <?php echo form_open(current_url()); ?>
        <div class="box box-primary">
            <div class="box-body">
                <?php echo validation_errors(); ?>

                <div class="form-group">
                    <label>Nama Komplek <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                    <input name="komplek_name" type="text" class="form-control" value="<?php echo isset($komplek) ? $komplek['komplek_name'] : set_value('komplek_name'); ?>" placeholder="Isi Nama Komplek">
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="<?php echo site_url('komplek'); ?>" class="btn btn-info">Batal</a>
            </div>
        </div>
        <?php echo form_close(); ?>
    </section>
</div>
