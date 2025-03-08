<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? $title : 'Data Hafalan Santri'; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? $title : 'Data Hafalan Santri'; ?></li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <!-- Filter -->
            <div class="col-md-12">
            <div class="box box-info" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                    <div class="box-header with-border">
                        <h3 class="box-title">Filter Data Hafalan Santri</h3>
                    </div>
                    <div class="box-body">
                        <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'method' => 'get')) ?>
                        <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Tahun Pelajaran</label>
    <div class="col-sm-2">
        <select class="form-control" name="n" required>
            <option value="">Pilih Tahun Pelajaran</option>
            <?php foreach ($period as $row): ?>
                <option 
                    <?php 
                        // Set otomatis tahun aktif jika belum ada filter yang dipilih
                        echo (isset($f['n']) && $f['n'] == $row['period_id']) || (!isset($f['n']) && $row['period_status'] == 1) ? 'selected' : ''; 
                    ?>
                    value="<?php echo $row['period_id'] ?>">
                    <?php echo $row['period_start'].'/'.$row['period_end'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Filter NIS Santri -->
    <label for="" class="col-sm-2 control-label">Pilih Santri</label>
    <div class="col-sm-3">
        <select id="nisDropdown" class="form-control" name="r" required>
            <option value="">Pilih Santri</option>
            <?php foreach ($santri as $row): ?>
                <option <?php echo (isset($f['r']) AND $f['r'] == $row['student_nis']) ? 'selected' : '' ?> value="<?php echo $row['student_nis']; ?>">
                    <?php echo $row['student_nis'] . ' - ' . $row['student_full_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
                            <div class="col-sm-1">
                                <button class="btn btn-success" type="submit">Cari</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Informasi Santri -->
            <?php if ($f): ?>
                <div class="col-md-12">
                <div class="box box-success" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                        <div class="box-header with-border">
                            <h3 class="box-title">Informasi Santri</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-9">
                                <table class="table table-striped">
                                    <tr>
                                        <td width="200">Tahun Ajaran</td>
                                        <td width="4">:</td>
                                        <td>
                                            <?php foreach ($period as $row): ?>
                                                <?php echo (isset($f['n']) && $f['n'] == $row['period_id']) ? 
                                                '<strong>' . $row['period_start'] . '/' . $row['period_end'] . '</strong>' : ''; ?>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>NIS</td>
                                        <td>:</td>
                                        <td><?php echo isset($santri_selected['student_nis']) ? $santri_selected['student_nis'] : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Santri</td>
                                        <td>:</td>
                                        <td><?php echo isset($santri_selected['student_full_name']) ? $santri_selected['student_full_name'] : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <td><?php echo isset($santri_selected['class_name']) ? $santri_selected['class_name'] : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ibu Kandung</td>
                                        <td>:</td>
                                        <td><?php echo isset($santri_selected['student_name_of_mother']) ? $santri_selected['student_name_of_mother'] : '-'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ibu Kandung</td>
                                        <td>:</td>
                                        <td><?php echo isset($santri_selected['student_name_of_mother']) ? $santri_selected['student_name_of_mother'] : '-'; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <?php if (!empty($santri_selected['student_img'])): ?>
                                    <img src="<?php echo upload_url('student/' . $santri_selected['student_img']); ?>" class="img-thumbnail img-responsive">
                                <?php else: ?>
                                    <img src="<?php echo media_url('img/user.png'); ?>" class="img-thumbnail img-responsive">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Hafalan -->
<div class="col-md-12">
<div class="box box-success" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

        <div class="box-header with-border">
            <h3 class="box-title">Total Hafalan</h3>
        </div>
        <div class="box-body">
            <p><strong>Total Hafalan: </strong><?php echo $total_hafalan; ?> Bait</p>
        </div>
    </div>
</div>

<!-- Rekap Hafalan Bulanan -->
<div class="col-md-12">

	<div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

        <div class="box-header with-border">
            <h3 class="box-title">Rekap Hafalan Bulanan</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Total Hafalan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($monthly_hafalan)): ?>
                        <?php foreach ($monthly_hafalan as $row): ?>
                            <tr>
                                <td><?php echo date('F', mktime(0, 0, 0, $row['bulan'], 10)); ?></td>
                                <td><?php echo $row['total_hafalan']; ?> Bait</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center">Data tidak tersedia</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Rekap Hafalan Tahunan -->
<div class="col-md-12">
<div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
<div class="box-header with-border">
            <h3 class="box-title">Rekap Hafalan Tahunan</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Total Hafalan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($yearly_hafalan)): ?>
                        <?php foreach ($yearly_hafalan as $row): ?>
                            <tr>
                                <td><?php echo $row['tahun']; ?></td>
                                <td><?php echo $row['total_hafalan']; ?> Bait</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center">Data tidak tersedia</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


                <!-- Riwayat Nadzhaman -->
                <div class="col-md-12">
                <div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                        <div class="box-header with-border">
                            <h3 class="box-title">Riwayat Nadzhaman</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addNadzhamanModal">
                                <i class="fa fa-plus"></i> Tambah Nadzhaman
                            </button>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="info">
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kitab</th>
                                            <th>Jumlah Hafalan</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($nadzhaman)): ?>
                                            <?php $no = 1; foreach ($nadzhaman as $row): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['tanggal']; ?></td>
                                                    <td><?php echo $row['nama_kitab']; ?></td>
                                                    <td><?php echo $row['jumlah_hafalan']; ?></td>
                                                    <td><?php echo $row['keterangan']; ?></td>
                                                    <td>
                                                        <a href="<?php echo site_url('nadzhaman/delete/' . $row['nadzhaman_id'] . '?n=' . $f['n'] . '&r=' . $f['r']); ?>" 
                                                           class="btn btn-danger btn-xs"
                                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                           <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Data nadzhaman kosong.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<!-- Modal Tambah Nadzhaman -->
<div class="modal fade" id="addNadzhamanModal" tabindex="-1" role="dialog" aria-labelledby="addNadzhamanModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('nadzhaman/add'); ?>
            <div class="modal-header">
                <h4 class="modal-title" id="addNadzhamanModalLabel">Tambah Nadzhaman</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="student_id" value="<?php echo isset($santri_selected['student_id']) ? $santri_selected['student_id'] : ''; ?>">
                <input type="hidden" name="period_id" value="<?php echo isset($f['n']) ? $f['n'] : ''; ?>">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Kitab</label>
                    <select name="kitab_id" class="form-control" required>
                        <?php foreach ($kitab as $k): ?>
                            <option value="<?php echo $k['kitab_id']; ?>"><?php echo $k['nama_kitab']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah Hafalan</label>
                    <input type="text" name="jumlah_hafalan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- Tambahkan Select2 dan AJAX -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nisDropdown').select2({
            placeholder: "Cari Nama atau NIS Santri",
            allowClear: true,
            ajax: {
                url: "<?php echo site_url('manage/pelanggaran/search_santri'); ?>",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return { keyword: params.term };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return { id: item.id, text: item.text };
                        })
                    };
                },
                cache: true
            }
        });
    });
</script>