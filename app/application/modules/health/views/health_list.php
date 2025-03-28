<style>
    .status-select {
        padding: 3px 8px;
        border-radius: 15px;
        border: 1px solid #ddd;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .status-select:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(81, 203, 238, 1);
    }

    .status-container {
        display: flex;
        align-items: center;
        gap: 5px;
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
            <li class="active"><?php echo isset($title) ? $title : 'Data Kesehatan'; ?></li>
        </ol>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="row">
            <!-- Filter -->
            <!-- Filter -->
            <div class="col-md-12">
                <div class="box box-info" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                    <div class="box-header with-border">
                        <h3 class="box-title">Data Kesehatan Santri</h3>
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
            <!-- Santri yang Sedang Sakit Hari Ini -->
            <?php if (!isset($f['n'])): ?>
                <div class="col-md-12">
                    <div class="box box-danger" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Santri Sedang Sakit - <?php echo date('d F Y') ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="danger">
                                            <th>No</th>
                                            <th>Nama Santri</th>
                                            <th>Kamar</th>
                                            <th>Kelas</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Kondisi Kesehatan</th>
                                            <th>Lama Sakit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($current_sick)): ?>
                                            <?php $no = 1;
                                            foreach ($current_sick as $row): ?>
                                                <?php
                                                $start = new DateTime($row['tanggal']);
                                                $now = new DateTime();
                                                $interval = $start->diff($now);
                                                ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['student_full_name'] ?></td>
                                                    <td><?php echo $row['majors_name'] ?></td>
                                                    <td><?php echo $row['class_name'] ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                                                    <td><?php echo $row['kondisi_kesehatan'] ?></td>
                                                    <td>
                                                        <span class="badge bg-red"><?php echo $interval->days ?> Hari</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Tidak ada data santri sakit saat ini.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>


            <!-- Top Santri Sering Sakit -->
            <?php if (!isset($f['n'])): ?>
                <div class="col-md-12">
                    <div class="box box-warning" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Top 10 Santri Sering Sakit - Periode <?php echo $active_period['period_start'] . '/' . $active_period['period_end'] ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="warning">
                                            <th width="30">Rank</th>
                                            <th>Nama Santri</th>
                                            <th>Kelas</th>
                                            <th>Total Sakit</th>
                                            <th>Penyakit Terakhir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($top_sick)): ?>
                                            <?php $no = 1;
                                            foreach ($top_sick as $row): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['student_full_name'] ?></td>
                                                    <td><?php echo $row['class_name'] ?></td>
                                                    <td><span class="badge bg-red"><?php echo $row['total_sakit'] ?>x</span></td>
                                                    <td><?php echo $this->Health_model->get_last_sickness($row['student_id']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tidak ada data santri yang sering sakit dalam periode ini.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

                <!-- Riwayat Kesehatan -->
                <div class="col-md-12">
                    <div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

                        <div class="box-header with-border">
                            <h3 class="box-title">Riwayat Kesehatan</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addHealthModal">
                                <i class="fa fa-plus"></i> Tambah Data Kesehatan
                            </button>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="info">
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Kondisi Kesehatan</th>
                                            <th>Tindakan</th>
                                            <th>Status</th>
                                            <th>Tanggal Sembuh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($kesehatan)): ?>
                                            <?php $no = 1;
                                            foreach ($kesehatan as $row): ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row['tanggal']; ?></td>
                                                    <td><?php echo $row['kondisi_kesehatan']; ?></td>
                                                    <td><?php echo $row['tindakan']; ?></td>
                                                    <td>
                                                        <select class="status-select"
                                                            data-health-id="<?= $row['health_record_id'] ?>"
                                                            style="<?= $row['status'] == 'Sudah Sembuh' ?
                                                                        'background-color: #d4edda;' :
                                                                        'background-color: #f8d7da;' ?>">
                                                            <option value="Masih Sakit" <?= $row['status'] == 'Masih Sakit' ? 'selected' : '' ?>>Masih Sakit</option>
                                                            <option value="Sudah Sembuh" <?= $row['status'] == 'Sudah Sembuh' ? 'selected' : '' ?>>Sudah Sembuh</option>
                                                        </select>
                                                    </td>
                                                    <td class="tanggal-sembuh"><?= $row['tanggal_sembuh'] ?: '-' ?></td>
                                                    <td>
                                                        <a href="<?php echo site_url('health/delete/' . $row['health_record_id']); ?>"
                                                            class="btn btn-danger btn-xs"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Data kesehatan kosong.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="modal fade" id="addHealthModal" tabindex="-1" role="dialog" aria-labelledby="addHealthModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                        <?php echo form_open('health/add'); ?>
                        <div class="modal-header">
                            <h4 class="modal-title" id="addHealthModalLabel">Tambah Data Kesehatan</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Input -->
                            <input type="hidden" name="nis" value="<?php echo isset($santri_selected['student_nis']) ? $santri_selected['student_nis'] : ''; ?>">

                            <input type="hidden" name="student_id" value="<?php echo isset($santri_selected['student_id']) ? $santri_selected['student_id'] : ''; ?>">
                            <input type="hidden" name="period_id" value="<?php echo isset($f['n']) ? $f['n'] : ''; ?>">

                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Kondisi Kesehatan</label>
                                <input type="text" name="kondisi_kesehatan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tindakan</label>
                                <input type="text" name="tindakan" class="form-control" required>
                            </div>
                            <input type="hidden" name="status" value="Masih Sakit">

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).on('change', '.status-select', function() {
        const select = $(this);
        const healthId = select.data('health-id');
        const newStatus = select.val();
        const row = select.closest('tr');

        $.ajax({
            url: '<?= site_url('health/update_status') ?>',
            method: 'POST',
            data: {
                health_id: healthId,
                status: newStatus
            },
            success: function(response) {
                // Update warna dropdown
                if (newStatus === 'Sudah Sembuh') {
                    select.css('background-color', '#d4edda');
                    row.find('.tanggal-sembuh').text(response.tanggal_sembuh);
                } else {
                    select.css('background-color', '#f8d7da');
                    row.find('.tanggal-sembuh').text('-');
                }
            }
        });
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