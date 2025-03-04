<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <h1><?php echo isset($title) ? $title : null; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? $title : null; ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box"> 
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <h3 class="box-title">Total Santri: <strong><?php echo $total_students; ?></strong></h3>
                            </div>
                            <div class="col-md-6 col-xs-12 text-right">
                                <?php if ($this->session->userdata('uroleid') != USER) { ?>
                                    <a href="<?php echo site_url('manage/student/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
                                    <a href="<?php echo site_url('manage/student/import') ?>" class="btn btn-sm btn-info"><i class="fa fa-upload"></i> Upload Santri</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <!-- Form Pencarian & Filter -->
                        <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <form method="get">
                                    <div class="input-group input-group-sm">
                                        <input type="text" id="field" name="n" class="form-control"
                                            placeholder="<?php echo isset($f['n']) ? $f['n'] : 'NIS Santri'; ?>">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-4 col-xs-12">
                                <form method="get">
                                    <select class="form-control" name="class" onchange="this.form.submit()">
                                        <option value="">-- Semua Kelas --</option>
                                        <?php foreach ($class as $row): ?>
                                            <option value="<?php echo $row['class_id']; ?>"
                                                <?php echo (isset($f['class']) && $f['class'] == $row['class_id']) ? 'selected' : ''; ?>>
                                                <?php echo $row['class_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </div>

                            <?php if (majors() == 'senior') { ?>
                                <div class="col-md-4 col-xs-12">
                                    <form method="get">
                                        <select class="form-control" name="kamar" onchange="this.form.submit()">
                                            <option value="">-- Semua Kamar --</option>
                                            <?php foreach ($majors as $row): ?>
                                                <option value="<?php echo $row['majors_id']; ?>"
                                                    <?php echo (isset($f['kamar']) && $f['kamar'] == $row['majors_id']) ? 'selected' : ''; ?>>
                                                    <?php echo $row['majors_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>

                        <br>

                        <!-- Tombol Cetak Kartu -->
                        <form action="<?php echo site_url('manage/student/multiple'); ?>" method="post" id="printCardForm">
                            <input type="hidden" name="action" value="printPdf">
                            <button type="submit" class="btn btn-danger btn-sm" formtarget="_blank">
                                <i class="fa fa-print"></i> Cetak Kartu
                            </button>
                        </form>

                        <br>

                        <!-- Table Santri -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th><input type="checkbox" id="selectall"></th> 
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Nama Ibu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                <tbody>
                                    <?php
                                    if (!empty($student)) {
                                        $i = 1;
                                        foreach ($student as $row):
                                    ?>
                                            <tr>
                                                <td><input type="checkbox" class="checkbox" name="msg[]" value="<?php echo $row['student_id']; ?>"></td>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['student_nis']; ?></td>
                                                <td><?php echo $row['student_full_name']; ?></td>
                                                <td><?php echo $row['class_name']; ?></td>
                                                <td><?php echo $row['student_name_of_mother']; ?></td>
                                                <td><label class="label <?php echo ($row['student_status']==1) ? 'label-success' : 'label-danger'; ?>"><?php echo ($row['student_status']==1) ? 'Aktif' : 'Tidak Aktif'; ?></label></td>
                                                <td>
                                                    <a href="<?php echo site_url('manage/student/rpw/' . $row['student_id']); ?>" class="btn btn-xs btn-danger"><i class="fa fa-unlock"></i></a>
                                                    <a href="<?php echo site_url('manage/student/view/' . $row['student_id']); ?>" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a>
                                                    <a href="<?php echo site_url('manage/student/edit/' . $row['student_id']); ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>
                                                    <a href="<?php echo site_url('manage/student/printPdf/' . $row['student_id']); ?>" class="btn btn-xs btn-success"><i class="fa fa-print"></i></a>
                                                </td>    
                                            </tr>
                                    <?php
                                            $i++;
                                        endforeach;
                                    } else {
                                    ?>
                                        <tr><td colspan="8" align="center">Data Kosong</td></tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="text-center">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>

                        <!-- Tombol Cetak dan Kirim WA -->
                        <div class="box-header text-center">
                            <form method="post" action="<?= site_url('manage/student/printAllPdf') ?>" target="_blank">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak Data Santri</button>
                            </form>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalWa"><i class="fab fa-whatsapp"></i> Kirim WA</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
