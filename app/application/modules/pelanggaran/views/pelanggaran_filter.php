<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? $title : null; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? $title : 'Data Pelanggaran'; ?></li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <!-- Filter -->
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter Data Pelanggaran Santri</h3>
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
            <?php if ($f) { ?>
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informasi Santri</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-md-9">
                                <table class="table table-striped">
                                    <tr>
                                        <td width="200">Tahun Ajaran</td>
                                        <td width="4">:</td>
                                        <?php foreach ($period as $row): ?>
                                            <?php echo (isset($f['n']) && $f['n'] == $row['period_id']) ? 
                                            '<td><strong>' . $row['period_start'] . '/' . $row['period_end'] . '</strong></td>' : ''; ?>
                                        <?php endforeach; ?>
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
                                        <td>Total Poin</td>
                                        <td>:</td>
                                        <td><strong><?php echo isset($total_points) ? $total_points : 0; ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <?php if (!empty($santri_selected['student_img'])) { ?>
                                    <img src="<?php echo upload_url('student/' . $santri_selected['student_img']); ?>" class="img-thumbnail img-responsive">
                                <?php } else { ?>
                                    <img src="<?php echo media_url('img/user.png'); ?>" class="img-thumbnail img-responsive">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Total Pelanggaran Per Bulan</h3>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="info">
                            <th>Bulan</th>
                            <th>Total Poin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($monthly_violations)): ?>
                            <?php foreach ($monthly_violations as $row): ?>
                                <tr>
                                    <td><?php echo date('F', mktime(0, 0, 0, $row['month'], 10)); // Nama bulan ?></td>
                                    <td><?php echo $row['total_points']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">Tidak ada data pelanggaran per bulan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="col-md-12">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Total Pelanggaran Per Tahun</h3>
        </div>
        <div class="box-body">
            <strong>Total Poin: </strong> <?php echo $yearly_violations; ?>
        </div>
    </div>
</div>


                <!-- Riwayat Pelanggaran -->
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Riwayat Pelanggaran</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addViolationModal">
                                <i class="fa fa-plus"></i> Tambah Pelanggaran
                            </button>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="info">
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Poin</th>
                                            <th>Pelanggaran</th>
                                            <th>Tindakan</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($pelanggaran)): ?>
                                            <?php $no = 1; foreach ($pelanggaran as $row): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['tanggal']; ?></td>
                                                    <td><?php echo $row['poin']; ?></td>
                                                    <td><?php echo $row['pelanggaran']; ?></td>
                                                    <td><?php echo $row['tindakan']; ?></td>
                                                    <td><?php echo $row['catatan']; ?></td>
                                                    <td>
                                                    <button class="btn btn-primary btn-xs btn-send-wa" 
        data-pesan="<?php echo "Tanggal: {$row['tanggal']}\nPoin: {$row['poin']}\nPelanggaran: {$row['pelanggaran']}\nTindakan: {$row['tindakan']}\nCatatan: {$row['catatan']}"; ?>" 
        data-url="<?php echo site_url('manage/pelanggaran/send_whatsapp/' . $row['pelanggaran_id'] . '?n=' . $f['n'] . '&r=' . $f['r']); ?>"
        data-wali="<?php echo isset($santri_selected['student_name_of_father']) ? $santri_selected['student_name_of_father'] : '-'; ?>"
        data-telepon="<?php echo isset($santri_selected['student_parent_phone']) ? $santri_selected['student_parent_phone'] : '-'; ?>">
    <i class="fa fa-whatsapp"></i> Kirim WA
</button>

                                                        <a href="<?php echo site_url('manage/pelanggaran/delete/' . $row['pelanggaran_id'] . '?n=' . $f['n'] . '&r=' . $f['r']); ?>" 
                                                           class="btn btn-danger btn-xs"
                                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                           <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center">Data pelanggaran kosong.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</div>

<!-- Modal Tambah Pelanggaran -->
<div class="modal fade" id="sendWaModal" tabindex="-1" role="dialog" aria-labelledby="sendWaModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="sendWaModalLabel">Konfirmasi Kirim WhatsApp</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Wali:</strong> <span id="waliNama"></span></p>
                <p><strong>Nomor Telepon:</strong> <span id="waliTelepon"></span></p>
                <p>Pesan yang akan dikirim:</p>
                <textarea id="waMessagePreview" class="form-control" rows="5" readonly></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <a href="#" id="confirmSendWa" class="btn btn-primary">Kirim Pesan</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addViolationModal" tabindex="-1" role="dialog" aria-labelledby="addViolationModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('manage/pelanggaran/add'); ?>
            <div class="modal-header">
                <h4 class="modal-title" id="addViolationModalLabel">Tambah Pelanggaran</h4>
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
                    <label>Poin</label>
                    <input type="number" name="poin" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Pelanggaran</label>
                    <input type="text" name="pelanggaran" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tindakan</label>
                    <input type="text" name="tindakan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control"></textarea>
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
<script>
    $(document).ready(function() {
        // Tangkap klik tombol "Kirim WA"
        $('.btn-send-wa').on('click', function() {
            // Ambil data dari atribut tombol
            var pesan = $(this).data('pesan');
            var url = $(this).data('url');
            var waliNama = $(this).data('wali');
            var waliTelepon = $(this).data('telepon');

            // Masukkan data ke dalam modal
            $('#waliNama').text(waliNama);
            $('#waliTelepon').text(waliTelepon);
            $('#waMessagePreview').val(pesan);

            // Tambahkan URL ke tombol konfirmasi
            $('#confirmSendWa').attr('href', url);

            // Tampilkan modal
            $('#sendWaModal').modal('show');
        });
    });
</script>
