

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? '' . $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
		</ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="box-body">
				<?php echo form_open_multipart(current_url(), array('class' => 'form-horizontal')); ?>
				<?php echo validation_errors(); ?>

				<div class="col-sm-6">
					<div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">Informasi Pembayaran</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo $payment['pos_name'].' - T.A '.$payment['period_start'].'/'.$payment['period_end'] ?>" readonly="">
								</div>
							</div>
							<div class="form-group">						
								<label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo $payment['period_start'].'/'.$payment['period_end'] ?>" readonly="">
								</div>
							</div>
							<div class="form-group">						
								<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?php echo ($payment['payment_type']=='BULAN' ? 'Bulanan' : 'Bebas') ?>" readonly="">
								</div>
							</div>						  

						</div>
					</div>

				</div>
				<div class="col-md-6">

					<div class="box box-success">
						<div class="box-header">
							<h3 class="box-title">Tarif Tagihan Per Santri</h3>
						</div>
						<div class="box-body table-responsive">

							<table class="table">
								<tbody>
									<tr>
										<td><strong>Nama Santri</strong></td>
										<td><input type="text" class="form-control" value="<?php echo $student['student_full_name'] ?>" readonly>
										</td>
									</tr>
									<tr>
										<td><strong>Kelas</strong></td>
										<td><input type="text" class="form-control" value="<?php echo $student['class_name'] ?>" readonly>
										</td>
									</tr>
									<tr>
										<td><strong>Tarif (Rp.)</strong></td>
										<?php foreach ($bebas as $row) { ?>
										<td><input autofocus="" type="text" id="" name="bebas_bill" placeholder="Masukan Tarif" value="<?php echo $row['bebas_bill'] ?>" class="form-control numeric">
										</td>
										<?php } ?>
									</tr>


								</tbody>
							</table>
						</div>
						<div class="box-footer">
							<button type="submit" class="btn btn-success">Simpan</button>
							<a href="<?php echo site_url('manage/payment/view_bebas/'. $payment['payment_id']) ?>" class="btn btn-default">Cancel</a>
						</div>
					</div>
				</div>					
				<?php echo form_close(); ?>
			</div>
		</div>		
	</section>
</div>