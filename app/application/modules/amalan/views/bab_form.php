<!-- application/modules/amalan/views/bab_form.php -->
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?= site_url('amalan/amalan') ?>">Kitab</a></li>
            <li><a href="<?= site_url('amalan/bab/index/'.$amalan['amalan_id']) ?>"><?= $amalan['amalan_title'] ?></a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Bab</h3>
                    </div>
                    
                    <form role="form" method="post" action="">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Judul Bab *</label>
                                <input type="text" name="bab_title" class="form-control" 
                                    value="<?= isset($bab['bab_title']) ? $bab['bab_title'] : '' ?>" 
                                    placeholder="Contoh: Niat Shalat" required>
                            </div>

                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="bab_order" class="form-control" 
                                    value="<?= isset($bab['bab_order']) ? $bab['bab_order'] : 0 ?>" 
                                    min="0">
                            </div>

                            <?php if(isset($bab)): ?>
                                <input type="hidden" name="amalan_id" value="<?= $bab['amalan_id'] ?>">
                            <?php endif; ?>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                            <a href="<?= site_url('amalan/bab/index/'.$amalan['amalan_id']) ?>" class="btn btn-default">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>