<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? $title : 'Kelola Kitab per Kelas'; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage'); ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active">Kelola Kitab per Kelas</li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <!-- Form Kelola Kitab -->
            <div class="col-md-12">
            <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Kelola Kitab per Kelas</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open('nadzhaman/manage_kitab_class', ['class' => 'form-horizontal']); ?>
                        
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
                            <label class="col-sm-2 control-label">Kitab</label>
                            <div class="col-sm-6">
                                <select class="form-control" name="kitab_ids[]" required>
                                    <option value="">Pilih Kitab</option>
                                    <?php foreach ($kitabs as $kitab): ?>
                                        <option value="<?php echo $kitab['kitab_id']; ?>">
                                            <?php echo $kitab['nama_kitab']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-6">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="<?php echo site_url('manage'); ?>" class="btn btn-default">Batal</a>
                            </div>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
