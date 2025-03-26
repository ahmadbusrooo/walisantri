<!-- application/modules/amalan/views/amalan_form.php -->
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?= site_url('amalan/amalan') ?>">Kitab</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Kitab</h3>
                    </div>
                    
                    <form role="form" method="post" action="">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Judul Kitab *</label>
                                <input type="text" name="amalan_title" class="form-control" 
                                    value="<?= isset($amalan['amalan_title']) ? $amalan['amalan_title'] : '' ?>" 
                                    placeholder="Contoh: Shalat Wajib" required>
                            </div>

                            <div class="form-group">
                                <label>Status Publikasi</label>
                                <select name="amalan_publish" class="form-control">
                                    <option value="1" <?= (isset($amalan['amalan_publish']) && $amalan['amalan_publish'] == 1) ? 'selected' : '' ?>>Published</option>
                                    <option value="0" <?= (isset($amalan['amalan_publish']) && $amalan['amalan_publish'] == 0) ? 'selected' : '' ?>>Draft</option>
                                </select>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            <a href="<?= site_url('amalan/amalan') ?>" class="btn btn-default">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>