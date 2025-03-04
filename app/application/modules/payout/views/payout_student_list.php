<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<?php echo isset($title) ? $title : null; ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('manage'); ?>"><i class="fa fa-th"></i> Home</a></li>
			<li class="active"><?php echo isset($title) ? $title : null; ?></li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-body table-responsive">

						<!-- Tabel Jenis Pembayaran -->
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Jenis Pembayaran</th>
									<th>Total Tagihan</th>
									<th>Sudah Dibayar</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($student)) : $i = 1; foreach ($student as $row):
									$namePay = $row['pos_name'] . ' - T.A ' . $row['period_start'] . '/' . $row['period_end'];
									$color = ($total == $pay) ? '#00E640' : 'red';
									$labelClass = ($total == $pay) ? 'label-success' : 'label-warning';
								?>
								<tr style="color:<?php echo $color; ?>;">
									<td><?php echo $i; ?></td>
									<td><?php echo $namePay; ?></td>
									<td><?php echo 'Rp. ' . number_format($total - $pay, 0, ',', '.'); ?></td>
									<td><?php echo 'Rp. ' . number_format($pay, 0, ',', '.'); ?></td>
									<td><label class="label <?php echo $labelClass; ?>"><?php echo ($total == $pay) ? 'Lengkap' : 'Belum Lengkap'; ?></label></td>
								</tr>
								<?php $i++; endforeach; else: ?>
								<tr>
									<td colspan="5" style="text-align: center;">Tidak ada data pembayaran siswa</td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>

						<!-- Rincian Pembayaran Bulanan -->
						<h3>Rincian Pembayaran Bulanan</h3>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Bulan</th>
									<th>Tahun Pelajaran</th>
									<th>Tagihan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($bulan)) : $i = 1; foreach ($bulan as $row):
									$mont = ($row['month_month_id'] <= 6) ? $row['period_start'] : $row['period_end'];
									$color = ($row['bulan_status'] == 1) ? '#00E640' : 'red';
								?>
								<tr style="color:<?php echo $color; ?>;">
									<td><?php echo $i; ?></td>
									<td><?php echo $row['month_name']; ?></td>
									<td><?php echo $mont; ?></td>
									<td><?php echo 'Rp. ' . number_format($row['bulan_bill'], 0, ',', '.'); ?></td>
									<td style="text-align: center;">
										<?php echo ($row['bulan_status'] == 1) ? 'Lunas' : 'Belum Lunas'; ?>
									</td>
								</tr>
								<?php $i++; endforeach; else: ?>
								<tr>
									<td colspan="5" style="text-align: center;">Tidak ada data pembayaran siswa</td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>

						<!-- Rincian Pembayaran Lainnya -->
						<h3>Rincian Pembayaran Lainnya</h3>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>No.</th>
									<th>Jenis Pembayaran</th>
									<th>Total Tagihan</th>
									<th>Sudah Dibayar</th>
									<th>Sisa Tagihan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($bebas)) : $i = 1; foreach ($bebas as $row):
									$sisa = isset($row['bebas_bill']) ? $row['bebas_bill'] - $row['bebas_total_pay'] : 0;
									$namePay = $row['pos_name'] . ' - T.A ' . $row['period_start'] . '/' . $row['period_end'];
									$color = ($sisa == 0) ? '#00E640' : 'red';
								?>
								<tr style="color:<?php echo $color; ?>;">
									<td><?php echo $i; ?></td>
									<td><?php echo $namePay; ?></td>
									<td><?php echo isset($row['bebas_bill']) ? 'Rp. ' . number_format($row['bebas_bill'], 0, ',', '.') : '-'; ?></td>
									<td><?php echo isset($row['bebas_total_pay']) ? 'Rp. ' . number_format($row['bebas_total_pay'], 0, ',', '.') : '-'; ?></td>
									<td><?php echo isset($row['bebas_bill']) ? 'Rp. ' . number_format($sisa, 0, ',', '.') : '-'; ?></td>
									<td><?php echo ($sisa == 0) ? 'Lunas' : 'Belum Lunas'; ?></td>
								</tr>
								<?php $i++; endforeach; else: ?>
								<tr>
									<td colspan="6" style="text-align: center;">Tidak ada data pembayaran siswa</td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</section>
</div>
