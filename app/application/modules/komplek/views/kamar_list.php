<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kamar di <?= $komplek['komplek_name']; ?></title>
    <script type="text/javascript" src="<?php echo media_url('js/jquery-migrate-3.0.0.min.js') ?>"></script>
</head>
<body>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Daftar Kamar di <?= $komplek['komplek_name']; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?php echo site_url('komplek') ?>">Komplek</a></li>
            <li class="active">Daftar Kamar</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <a href="<?php echo site_url('komplek'); ?>" class="btn btn-default btn-sm">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addKamar">
                            <i class="fa fa-plus"></i> Tambah Kamar
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kamar</th>
                                    <th>ID Kamar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($kamar)) {
                                    $i = 1;
                                    foreach ($kamar as $row):
                                ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $row['majors_name']; ?></td>
                                            <td><?= $row['majors_id']; ?></td>
                                            <td>
                                                <!-- Tombol Edit -->
                                                <a href="<?php echo site_url('komplek/kamar/edit/' . $row['majors_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">

                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <!-- Tombol Hapus -->
                                                <a href="#delModal<?= $row['majors_id']; ?>" data-toggle="modal" class="btn btn-xs btn-danger">
                                                    <i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Modal Hapus -->
                                        <div class="modal modal-default fade" id="delModal<?= $row['majors_id']; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi Penghapusan</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus kamar ini?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                    <?php echo form_open('komplek/kamar/delete/' . $row['majors_id']); ?>

                                                        <input type="hidden" name="delName" value="<?= $row['majors_name']; ?>">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                                        <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                                        <?php echo form_close(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                <?php
                                    $i++;
                                    endforeach;
                                } else {
                                ?>
                                    <tr>
                                        <td colspan="4" align="center">Tidak ada kamar di komplek ini.</td>
                                    </tr>
                                <?php 
                                } 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah Kamar -->
<div class="modal fade" id="addKamar" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Kamar</h4>
            </div>
            <?php echo form_open('komplek/kamar/add/' . $komplek['komplek_id'], array('method'=>'post')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Nama Kamar</label>
                        <input type="text" required name="majors_name" class="form-control" placeholder="Nama Kamar">
                        <input type="hidden" name="komplek_id" value="<?= $komplek['komplek_id']; ?>">
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
        var scntDiv = $('#p_scents_kamar');
        var i = $('#p_scents_kamar .row').size() + 1;

        $("#addScnt_kamar").click(function() {
            $('<div class="row"><div class="col-md-12"><label>Nama Kamar</label><input type="text" required name="majors_name[]" class="form-control" placeholder="Nama Kamar"><a href="#" class="btn btn-xs btn-danger remScnt_kamar">Hapus Baris</a></div></div>').appendTo(scntDiv);
            i++;
            return false;
        });

        $(document).on("click", ".remScnt_kamar", function() {
            if (i > 2) {
                $(this).parents('.row').remove();
                i--;
            }
            return false;
        });
    });
</script>

</body>
</html>
