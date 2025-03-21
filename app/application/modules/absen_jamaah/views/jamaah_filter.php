<?php
// Konfigurasi nama hari dan bulan Indonesia
$hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
$bulan = array(
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
);
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage'); ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter Data Tidak Jama'ah Santri</h3>
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
                                            <?php echo $row['period_start'] . '/' . $row['period_end'] ?>
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
                                        <option <?php echo (isset($f['r']) and $f['r'] == $row['student_nis']) ? 'selected' : '' ?> value="<?php echo $row['student_nis']; ?>">
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
            <?php if (empty($f['n'])): // Tampilkan hanya jika belum ada filter 
            ?>
                <div class="col-md-12">
                    <div class="box box-danger" style="border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Top 10 Pelanggaran Absen Jamaah Periode <?php echo $active_period['period_start'] ?>-<?php echo $active_period['period_end'] ?></h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="danger">
                                            <th width="30">Rank</th>
                                            <th>Nama Santri</th>
                                            <th>Kelas</th>
                                            <th>Total Tidak Berjama'ah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($top_absent)): ?>
                                            <?php $rank = 1;
                                            foreach ($top_absent as $row): ?>
                                                <tr>
                                                    <td><?php echo $rank++; ?></td>
                                                    <td><?php echo $row['student_full_name'] ?></td>
                                                    <td><?php echo $row['class_name'] ?></td>
                                                    <td><span class="badge bg-red"><?php echo $row['total'] ?></span></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data absen</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <p class="text-muted text-sm">* Data peringkat berdasarkan total ketidakhadiran jamaah pada periode aktif</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($f['n']) && !empty($f['r'])): ?>
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
                                        <td>Total Tidak Berjam'ah</td>
                                        <td>:</td>
                                        <td><strong><?php echo isset($total_absen) ? $total_absen : 0; ?></strong></td>
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
                    <div class="box box-info" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                        <div class="box-header with-border">
                            <h3 class="box-title">Total Tidak Jama'ah Per Tahun</h3>
                        </div>
                        <div class="box-body">
                            <strong>Total Tidak Berjama'ah: </strong> <?php echo $total_absen; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                        <div class="box-header with-border">
                            <h3 class="box-title">Riwayat Absen Jama'ah</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addModal">
                                <i class="fa fa-plus"></i> Tambah
                            </button>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="info">
                                        <th>No</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Jumlah Tidak Jama'ah</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($absen)): ?>
                                        <?php $no = 1;
                                        foreach ($absen as $row): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <?php
                                                    $timestamp = strtotime($row['tanggal_mulai']);
                                                    echo $hari[date('w', $timestamp)] . ', ' . date('j', $timestamp) . ' ' . $bulan[date('n', $timestamp)] . ' ' . date('Y', $timestamp);
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $timestamp = strtotime($row['tanggal_selesai']);
                                                    echo $hari[date('w', $timestamp)] . ', ' . date('j', $timestamp) . ' ' . $bulan[date('n', $timestamp)] . ' ' . date('Y', $timestamp);
                                                    ?>
                                                </td>
                                                <td><?php echo $row['jumlah_tidak_jamaah']; ?> Kali</td>
                                                <td><?php echo $row['keterangan']; ?></td>
                                                <!-- Di dalam tabel -->
                                                <td>
                                                    <button class="btn btn-success btn-xs btn-send-wa"
                                                        data-pesan="<?php echo "Periode: {$row['tanggal_mulai']} - {$row['tanggal_selesai']}\nJumlah Tidak Jama'ah: {$row['jumlah_tidak_jamaah']}\nKeterangan: {$row['keterangan']}"; ?>"
                                                        data-url="<?php echo site_url('manage/absen_jamaah/send_whatsapp/' . $row['jamaah_id'] . '?n=' . $f['n'] . '&r=' . $f['r']); ?>"
                                                        data-wali="<?php echo isset($santri_selected['student_name_of_father']) ? $santri_selected['student_name_of_father'] : '-'; ?>"
                                                        data-telepon="<?php echo isset($santri_selected['student_parent_phone']) ? $santri_selected['student_parent_phone'] : '-'; ?>">
                                                        <i class="fab fa-whatsapp"></i> WA
                                                    </button>

                                                    <a href="<?php echo site_url('manage/absen_jamaah/delete/' . $row['jamaah_id'] . '?n=' . $f['n'] . '&r=' . $f['r']); ?>"
                                                        class="btn btn-danger btn-xs"
                                                        onclick="return confirm('Hapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php echo form_open('manage/absen_jamaah/add'); ?>
            <div class="modal-header">
                <h4 class="modal-title">Tambah Laporan Tidak Jama'ah</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="student_id" value="<?php echo isset($santri_selected['student_id']) ? $santri_selected['student_id'] : ''; ?>">
                <input type="hidden" name="student_nis" value="<?php echo isset($santri_selected['student_nis']) ? $santri_selected['student_nis'] : ''; ?>">
                <input type="hidden" name="period_id" value="<?php echo isset($f['n']) ? $f['n'] : ''; ?>">

                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jumlah Tidak Jama'ah</label>
                    <input type="number" name="jumlah_tidak_jamaah" class="form-control"
                        min="1" required
                        placeholder="Masukkan jumlah Absen">
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- Modal Konfirmasi WhatsApp -->
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nisDropdown').select2({
            placeholder: "Cari Nama atau NIS Santri",
            allowClear: true,
            ajax: {
                url: "<?php echo site_url('manage/absen_jamaah/search_santri'); ?>",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        keyword: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
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

            // Update URL tombol konfirmasi
            $('#confirmSendWa').attr('href', url);

            // Tampilkan modal
            $('#sendWaModal').modal('show');
        });
    });
</script>
<script>
    // Hitung otomatis jumlah hari
    document.addEventListener('DOMContentLoaded', function() {
        var tglMulai = document.getElementById('tglMulai');
        var tglSelesai = document.getElementById('tglSelesai');
        var jumlahHari = document.getElementById('jumlahHari');

        function hitungHari() {
            if (tglMulai.value && tglSelesai.value) {
                var start = new Date(tglMulai.value);
                var end = new Date(tglSelesai.value);
                var diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
                jumlahHari.value = diff + ' Hari';
            }
        }

        tglMulai.addEventListener('change', hitungHari);
        tglSelesai.addEventListener('change', hitungHari);
    });
</script>