<script type="text/javascript" src="<?php echo media_url('js/jquery-migrate-3.0.0.min.js') ?>"></script>

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? $title : null; ?></li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
			<div class="box" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
					<div class="box-header">
						<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addKomplek">
							<i class="fa fa-plus"></i> Tambah
						</button>
					</div>

					<!-- /.box-header -->
					<div class="box-body table-responsive">
						<table class="table table-hover">
						<thead>
    <tr>
        <th>No</th>
        <th>Nama Komplek</th>
        <th>ID Komplek</th>
        <th>Jumlah Kamar</th>
        <th>Aksi</th>
    </tr>
</thead>

							<tbody>
								<?php
								if (!empty($komplek)) {
									$i = 1;
									foreach ($komplek as $row):
										?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row['komplek_name']; ?></td>
											<td><?php echo $row['komplek_id']; ?></td>
											<td><?php echo $row['jumlah_kamar']; ?></td>
											<td>
											<a href="<?php echo site_url('komplek/kamar/' . $row['komplek_id']) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Lihat Kamar">
        <i class="fa fa-eye"></i>
    </a>
												<a href="<?php echo site_url('komplek/add/' . $row['komplek_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
													<i class="fa fa-edit"></i>
												</a>
												
												<a href="#delModal<?php echo $row['komplek_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger">
													<i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i>
												</a>
											</td>	
										</tr>

										<!-- Modal Hapus -->
										<div class="modal modal-default fade" id="delModal<?php echo $row['komplek_id']; ?>">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span></button>
														<h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi Penghapusan</h3>
													</div>
													<div class="modal-body">
														<p>Apakah Anda yakin ingin menghapus data ini?</p>
													</div>
													<div class="modal-footer">
														<?php echo form_open('komplek/delete/' . $row['komplek_id']); ?>
														<input type="hidden" name="delName" value="<?php echo $row['komplek_name']; ?>">
														<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
														<button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
														<?php echo form_close(); ?>
													</div>
												</div>
												<!-- /.modal-content -->
											</div>
											<!-- /.modal-dialog -->
										</div>

										<?php
										$i++;
									endforeach;
								} else {
									?>
									<tr>
										<td colspan="4" align="center">Data Kosong</td>
									</tr>
									<?php 
								} 
								?>
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->

				<div>
					<?php echo $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
	</section>
	<!-- /.content -->
</div>

<!-- Modal Tambah Komplek -->
<div class="modal fade" id="addKomplek" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Tambah Komplek</h4>
			</div>
			<?php echo form_open('komplek/add', array('method'=>'post')); ?>
			<div class="modal-body">
				<div id="p_scents_komplek">
					<div class="row">
						<div class="col-md-12">
							<label>Nama Komplek</label>
							<input type="text" required="" name="komplek_name" class="form-control" placeholder="Nama Komplek">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Simpan</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script>
	$(function() {
		var scntDiv = $('#p_scents_komplek');
		var i = $('#p_scents_komplek .row').size() + 1;

		$("#addScnt_komplek").click(function() {
			$('<div class="row"><div class="col-md-12"><label>Nama Komplek</label><input type="text" required name="komplek_name[]" class="form-control" placeholder="Nama Komplek"><a href="#" class="btn btn-xs btn-danger remScnt_komplek">Hapus Baris</a></div></div>').appendTo(scntDiv);
			i++;
			return false;
		});

		$(document).on("click", ".remScnt_komplek", function() {
			if (i > 2) {
				$(this).parents('.row').remove();
				i--;
			}
			return false;
		});
	});
</script>
