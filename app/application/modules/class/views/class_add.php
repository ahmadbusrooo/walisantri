<?php
if (isset($class)) {
    $inputClassValue = $class['class_name'];
    $selectedWaliKelas = $class['wali_kelas_id']; // Ambil wali kelas yang sudah dipilih
} else {
    $inputClassValue = set_value('class_name');
    $selectedWaliKelas = set_value('wali_kelas_id');
}
?>

<div class="content-wrapper"> 
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li><a href="<?php echo site_url('manage/class') ?>">Kelas</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<?php echo form_open_multipart(current_url()); ?>
		<div class="row">
			<div class="col-md-9">
				<div class="box box-primary">
					<div class="box-body">
						<?php echo validation_errors(); ?>
						<?php if (isset($class)) { ?>
							<input type="hidden" name="class_id" value="<?php echo $class['class_id']; ?>">
						<?php } ?>

						<!-- Nama Kelas -->
						<div class="form-group">
							<label>Nama Kelas <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
							<input name="class_name" type="text" class="form-control" value="<?php echo $inputClassValue ?>" placeholder="Isi Nama Kelas">
						</div>

						<!-- Wali Kelas -->
						<div class="form-group">
							<label>Wali Kelas</label>
							<select name="wali_kelas_id" class="form-control">
								<option value="">-- Pilih Wali Kelas --</option>
								<?php foreach ($ustadz as $u) { ?>
									<option value="<?= $u['ustadz_id']; ?>" <?= ($selectedWaliKelas == $u['ustadz_id']) ? 'selected' : ''; ?>>
										<?= $u['ustadz_nama']; ?>
									</option>
								<?php } ?>
							</select>
						</div>

						<p class="text-muted">*) Kolom wajib diisi.</p>
					</div>
				</div>
			</div>
			
			<!-- Tombol Aksi -->
			<div class="col-md-3">
				<div class="box box-primary">
					<div class="box-body">
						<button type="submit" class="btn btn-block btn-success">Simpan</button>
						<a href="<?php echo site_url('manage/class'); ?>" class="btn btn-block btn-info">Batal</a>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</section>
</div>
