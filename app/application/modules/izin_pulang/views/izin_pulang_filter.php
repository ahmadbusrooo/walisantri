<style>
    /* Gaya untuk status */
    .status-select {
        padding: 3px 8px;
        font-size: 12px;
        width: 140px;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .status-select option {
        padding: 5px;
    }

    .status-select option[value="Tepat waktu"] {
        background-color: #d4edda;
        color: #155724;
    }

    .status-select option[value="Terlambat"] {
        background-color: #f8d7da;
        color: #721c24;
    }

    /* Gaya untuk tombol WA */
    .btn-wa {
        padding: 3px 8px;
        font-size: 12px;
        border-radius: 15px;
        margin-left: 5px;
        transition: all 0.3s ease;
    }

    .btn-wa i {
        margin-right: 3px;
    }

    /* Container status */
    .status-container {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Responsive untuk mobile */
    @media (max-width: 768px) {
        .status-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-wa {
            margin-left: 0;
            margin-top: 5px;
        }
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? $title : null; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active">Riwayat Izin Pulang</li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <!-- Filter -->
            <div class="col-md-12">

                <div class="box box-info" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                    <div class="box-header with-border">
                        <h3 class="box-title">Filter Data Izin Pulang Santri</h3>
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
            <!-- Top Santri dengan Izin Pulang Terbanyak -->
            <?php if (!isset($f['n']) && !empty($top_izin)): ?>
                <div class="col-md-12">
                    <div class="box box-danger" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Top 10 Santri dengan Izin Pulang Terbanyak - Periode <?php echo $active_period['period_start'] . '/' . $active_period['period_end'] ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="danger">
                                            <th width="30">Rank</th>
                                            <th>Nama Santri</th>
                                            <th>Alamat</th>
                                            <th>Kelas</th>
                                            <th>Total Izin</th>
                                            <th>Total Hari</th>
                                            <th>Keterlambatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($top_izin as $row): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row['student_full_name'] ?></td>
                                                <td><?php echo $row['student_address'] ?></td>
                                                <td><?php echo $row['class_name'] ?></td>
                                                <td><span class="badge bg-blue"><?php echo $row['total_izin'] ?>x</span></td>
                                                <td><span class="badge bg-purple"><?php echo $row['total_hari'] ?> Hari</span></td>
                                                <td><span class="badge bg-red"><?php echo $row['total_telat'] ?>x</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <p class="text-muted text-sm">
                                    * Data dihitung berdasarkan total hari izin pulang dan status keterlambatan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif (!isset($f['n'])): ?>
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Tidak ada data izin pulang pada periode aktif.
                    </div>
                </div>
            <?php endif; ?>
            <!-- Informasi Santri -->
            <?php if ($f) { ?>
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
                            <h3 class="box-title">Total Hari Izin Pulang Per Periode</h3>
                        </div>
                        <div class="box-body">
                            <strong>Total Hari Izin Pulang: </strong> <?php echo isset($total_days) ? $total_days : 0; ?>
                        </div>
                    </div>
                </div>


                <!-- Riwayat Izin Pulang -->
                <div class="col-md-12">

                    <div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                        <div class="box-header with-border">
                            <h3 class="box-title">Riwayat Izin Pulang</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addPermissionModal">
                                <i class="fa fa-plus"></i> Tambah Izin Pulang
                            </button>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="info">
                                            <th>No</th>
                                            <th>Tanggal Awal</th>
                                            <th>Tanggal Akhir</th>
                                            <th>Jumlah Hari</th>
                                            <th>Alasan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($izin_pulang)): ?>
                                            <?php $no = 1;
                                            foreach ($izin_pulang as $row): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['tanggal']; ?></td>
                                                    <td><?php echo $row['tanggal_akhir']; ?></td>
                                                    <td><?php echo $row['jumlah_hari']; ?></td>
                                                    <td><?php echo $row['alasan']; ?></td>
                                                    <td>
                                                        <div class="status-container">
                                                            <select class="form-control status-select"
                                                                data-izin-id="<?php echo $row['izin_id']; ?>"
                                                                style="<?php echo ($row['status'] == 'Tepat waktu') ?
                                                                            'border: 1px solid #28a745; background-color: #d4edda;' :
                                                                            'border: 1px solid #dc3545; background-color: #f8d7da;' ?>">
                                                                <option value="Tepat waktu" <?php echo ($row['status'] == 'Tepat waktu') ? 'selected' : ''; ?>>Tepat waktu</option>
                                                                <option value="Terlambat" <?php echo ($row['status'] == 'Terlambat') ? 'selected' : ''; ?>>Terlambat</option>
                                                            </select>

                                                            <!-- Tombol WA -->
                                                            <a href="javascript:void(0)" 
           class="btn btn-success btn-wa"
           data-izin-id="<?php echo $row['izin_id']; ?>"
           data-base-url="<?php echo site_url('manage/izin_pulang/send_whatsapp/'); ?>"
           data-period="<?php echo isset($f['n']) ? $f['n'] : ''; ?>"
           data-student="<?php echo isset($f['r']) ? $f['r'] : ''; ?>"
           style="<?php echo ($row['status'] != 'Terlambat') ? 'display: none;' : '' ?>"
           data-toggle="tooltip" 
           title="Kirim Peringatan ke Orang Tua">
            <i class="fab fa-whatsapp"></i> WA
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo site_url('manage/izin_pulang/delete/' . $row['izin_id'] . '?n=' . $f['n'] . '&r=' . $f['r']); ?>"
                                                            class="btn btn-danger btn-xs"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Data izin pulang kosong.</td>
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

<!-- Modal Tambah Izin Pulang -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" role="dialog" aria-labelledby="addPermissionModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open('manage/izin_pulang/add'); ?>
            <div class="modal-header">
                <h4 class="modal-title" id="addPermissionModalLabel">Tambah Izin Pulang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="student_id" value="<?php echo isset($santri_selected['student_id']) ? $santri_selected['student_id'] : ''; ?>">
                <input type="hidden" name="period_id" value="<?php echo isset($f['n']) ? $f['n'] : ''; ?>">

                <div class="form-group">
                    <label>Tanggal Awal Pulang</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Akhir Pulang</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Jumlah Hari</label>
                    <input type="number" name="jumlah_hari" id="jumlah_hari" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Alasan Izin</label>
                    <textarea name="alasan" class="form-control" rows="3" required></textarea>
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

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).on('change', '.status-select', function() {
        const container = $(this).closest('.status-container');
        const izinId = $(this).data('izin-id');
        const newStatus = $(this).val();
        const waBtn = container.find('.btn-wa');

        $.ajax({
            url: '<?php echo site_url('manage/izin_pulang/update_status'); ?>',
            method: 'POST',
            data: {
                izin_id: izinId,
                status: newStatus
            },
            success: function(response) {
                // Update tampilan
                if (newStatus === 'Tepat waktu') {
                    container.find('.status-select').css({
                        'border': '1px solid #28a745',
                        'background-color': '#d4edda'
                    });
                    waBtn.hide();
                } else {
                    container.find('.status-select').css({
                        'border': '1px solid #dc3545',
                        'background-color': '#f8d7da'
                    });
                    // Update URL WA
                    const baseUrl = waBtn.data('base-url');
                    const period = waBtn.data('period');
                    const student = waBtn.data('student');
                    waBtn.attr('href', `${baseUrl}${izinId}?n=${period}&r=${student}`);
                    waBtn.show();
                }
            }
        });
    });
    $(document).on('click', '.btn-wa', function(e) {
    e.preventDefault();
    const btn = $(this);
    const izinId = btn.data('izin-id');
    const period = btn.data('period');
    const student = btn.data('student');
    const baseUrl = btn.data('base-url');
    const url = baseUrl + izinId + '?n=' + period + '&r=' + student;
    
    if (confirm('Yakin ingin mengirim notifikasi WA?')) {
        // Tambahkan loading state
        const originalHtml = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
        btn.prop('disabled', true);
        
        // Kirim request via AJAX
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                alert('Notifikasi WA berhasil dikirim!');
                btn.html(originalHtml);
                btn.prop('disabled', false);
            },
            error: function() {
                alert('Gagal mengirim notifikasi!');
                btn.html(originalHtml);
                btn.prop('disabled', false);
            }
        });
    }
});
</script>
<script>
    // Hitung Otomatis Jumlah Hari
    document.addEventListener('DOMContentLoaded', function() {
        const startDate = document.getElementById('tanggal');
        const endDate = document.getElementById('tanggal_akhir');
        const jumlahHari = document.getElementById('jumlah_hari');

        function calculateDays() {
            if (startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);
                const diff = end.getTime() - start.getTime();
                const days = Math.ceil(diff / (1000 * 3600 * 24)) + 1;
                jumlahHari.value = days;
            }
        }

        startDate.addEventListener('change', calculateDays);
        endDate.addEventListener('change', calculateDays);
    });
</script>

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