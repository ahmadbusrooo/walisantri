<!-- application/modules/amalan/views/isi_form.php -->
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?= site_url('amalan/amalan') ?>">Kitab</a></li>
            <li><a href="<?= site_url('amalan/bab/index/'.$bab['amalan_id']) ?>"><?= $bab['bab_title'] ?></a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editor Konten</h3>
                    </div>
                    
                    <?php echo form_open_multipart(current_url(), ['id' => 'content-form']); ?>
                        <div class="box-body">
                            <?php $this->load->view('amalan/tinymce_init'); ?>
                            
                            <?php if (!empty($this->session->flashdata('error'))): ?>
                                <div class="alert alert-danger">
                                    <?= $this->session->flashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($isi['isi_id'])): ?>
                                <input type="hidden" name="isi_id" value="<?= $isi['isi_id'] ?>">
                            <?php endif; ?>
                            
                            <input type="hidden" name="bab_id" value="<?= $bab['bab_id'] ?>">
                            <input type="hidden" name="amalan_id" value="<?= $bab['amalan_id'] ?>">

                            <div class="form-group">
                                <textarea id="isi_content" name="isi_content" class="form-control" rows="20">
                                    <?= isset($isi['isi_content']) ? htmlspecialchars($isi['isi_content']) : '' ?>
                                </textarea>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Konten</button>
                            <a href="<?= site_url('amalan/bab/index/'.$bab['amalan_id']) ?>" class="btn btn-default">Kembali</a>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('content-form');
    form.addEventListener('submit', function(e) {
        // Optional: Add client-side validation if needed
        var content = tinymce.get('isi_content').getContent();
        
        // Ensure the content is not empty
        if (content.trim() === '') {
            e.preventDefault();
            alert('Konten tidak boleh kosong');
            return false;
        }
    });
});
</script>