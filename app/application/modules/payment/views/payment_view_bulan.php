<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
            <small>Detail</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tarif - <?php echo $payment['pos_name'] . ' - T.A ' . $payment['period_start'] . '/' . $payment['period_end'] ?></h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
                        <div class="form-group row">
                            <label for="" class="col-md-1 col-form-label">Tahun</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" value="<?php echo $payment['period_start'] . '/' . $payment['period_end'] ?>" readonly>
                            </div>

                            <label for="" class="col-md-1 col-form-label">Kelas</label>
                            <div class="col-md-2">
                                <select class="form-control" name="pr">
                                    <option value="">-- Semua Kelas --</option>
                                    <?php foreach ($class as $row): ?>
                                        <option value="<?php echo $row['class_id'] ?>" <?php echo (isset($q['pr']) && $q['pr'] == $row['class_id']) ? 'selected' : '' ?>><?php echo $row['class_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <?php if (majors() == 'senior') { ?>
                                <label for="" class="col-md-2 col-form-label">Kamar</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="k">
                                        <option value="">-- Semua Kamar --</option>
                                        <?php foreach ($majors as $row): ?>
                                            <option value="<?php echo $row['majors_id'] ?>" <?php echo (isset($q['k']) && $q['k'] == $row['majors_id']) ? 'selected' : '' ?>><?php echo $row['majors_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php } ?>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-search"></i> Cari / Tampilkan</button>
                            </div>
                        </div>
                        </form>
                        <hr>
                        <label for="" class="col-md-2 col-form-label">Setting Tarif</label>
                        <div class="col-md-10">
                            <a class="btn btn-primary btn-sm" style="min-width: 170px;" href="<?php echo site_url('manage/payment/add_payment_bulan/' . $payment['payment_id']) ?>">
                                <i class="glyphicon glyphicon-plus"></i> Berdasarkan Kelas
                            </a>
                            <?php if (majors() == 'senior') { ?>
                                <a class="btn btn-warning btn-sm" style="min-width: 170px;" href="<?php echo site_url('manage/payment/add_payment_bulan_majors/' . $payment['payment_id']) ?>">
                                    <i class="glyphicon glyphicon-plus"></i> Berdasarkan Kamar
                                </a>
                            <?php } ?>
                            <a class="btn btn-info btn-sm" style="min-width: 170px;" href="<?php echo site_url('manage/payment/add_payment_bulan_student/' . $payment['payment_id']) ?>">
                                <i class="glyphicon glyphicon-plus"></i> Berdasarkan Santri
                            </a>
                            <?php if (isset($payment['payment_id'])): ?>
                                <a href="<?php echo site_url('manage/payment/delete_pos_bulan/' . $payment['payment_id']); ?>" class="btn btn-danger btn-sm" style="min-width: 170px;" onclick="return confirm('Apakah Anda yakin ingin menghapus semua tagihan untuk jenis pembayaran ini?');">
                                    <i class="fa fa-trash"></i> Hapus Semua Tarif
                                </a>
                            <?php else: ?>
                                <span class="text-danger">ID Pembayaran tidak tersedia</span>
                            <?php endif; ?>
                            <a class="btn btn-default btn-sm" style="min-width: 170px;" href="<?php echo site_url('manage/payment') ?>">
                                <i class="glyphicon glyphicon-repeat"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <?php if (majors() == 'senior') : ?>
                                        <th>Kelas</th>
                                    <?php endif ?>
                                    <th>Tarif Bulanan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($student as $row): 
                                    $bulan_siswa = array_filter($bulan_tarif, function ($item) use ($row) {
                                        return isset($item['student_student_id']) && $item['student_student_id'] == $row['student_student_id'];
                                    });
                                    $bulan_siswa = reset($bulan_siswa); 
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['student_nis']; ?></td>
                                    <td><?php echo $row['student_full_name']; ?></td>
                                    <td><?php echo $row['class_name']; ?></td>
                                    <?php if (majors() == 'senior') : ?>
                                        <td><?php echo $row['majors_name']; ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <?php
                                        echo isset($bulan_siswa['bulan_bill']) ? 'Rp ' . number_format($bulan_siswa['bulan_bill'], 0, ',', '.') : '-';
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo site_url('manage/payment/edit_payment_bulan/' . $row['payment_payment_id'] . '/' . $row['student_student_id']); ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" title="Ubah Tarif">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="<?php echo site_url('manage/payment/delete_payment_bulan_by_pos/' . $payment['payment_id'] . '/' . $row['student_student_id']); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus semua tagihan siswa ini untuk POS ini?');">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php $i++; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
