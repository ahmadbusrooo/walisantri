<div class="content-wrapper">
    <section class="content-header">
        <h1>Monitoring Kelengkapan Data Santri</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Data Lengkap</span>
                        <span class="info-box-number"><?php echo $complete_count; ?></span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red">
                    <span class="info-box-icon"><i class="fa fa-warning"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Data Belum Lengkap</span>
                        <span class="info-box-number"><?php echo $incomplete_count; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <div class="btn-group">
                            <a href="?status=complete" class="btn btn-success">Lengkap</a>
                            <a href="?status=incomplete" class="btn btn-danger">Belum Lengkap</a>
                            <a href="<?= site_url('manage/student/monitoring') ?>" class="btn btn-default">Reset</a>
                        </div>
                    </div>
                    
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Komplek</th>
                                    <th>Kamar</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($students as $student): ?>
                                <tr>
                                    <td><?= $student['student_nis'] ?></td>
                                    <td><?= $student['student_full_name'] ?></td>
                                    <td><?= $student['class_name'] ?></td>
                                    <td><?= $student['komplek_name'] ?></td>
                                    <td><?= $student['majors_name'] ?></td>
                                    <td>
                                        <?php if($student['is_complete']): ?>
                                            <span class="label label-success">Lengkap</span>
                                        <?php else: ?>
                                            <span class="label label-danger">Belum Lengkap</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('manage/student/view/'.$student['student_id']) ?>" 
                                           class="btn btn-xs btn-info">
                                            <i class="fa fa-search"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>