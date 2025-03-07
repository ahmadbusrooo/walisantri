<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Monitoring Kelengkapan Data Santri
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('manage') ?>"><i class="fa fa-th"></i> Beranda</a></li>
            <li class="active">Monitoring Data Santri</li>
        </ol>
    </section>

    <section class="content">
        <!-- Dashboard stats -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="box-header with-border" style="border-radius: 10px 10px 0 0; background-color: #f8f9fa; border-bottom: 1px solid #f0f0f0; padding: 15px 20px;">
                        <h3 class="box-title"> Statistik Kelengkapan Data</h3>
                    </div>
                    <div class="box-body" style="padding: 20px;">
                        <div class="row">
                            <!-- Data Lengkap -->
                            <div class="col-md-6">
                                <div style="background-color: #00a65a; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,166,90,0.2); margin-bottom: 20px; position: relative; overflow: hidden;">
                                    <div style="display: flex; align-items: center; padding: 20px;">
                                        <div style="flex: 0 0 80px; text-align: center; margin-right: 15px;">
                                            <div style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-check-circle" style="font-size: 40px; color: white;"></i>
                                            </div>
                                        </div>
                                        <div style="flex: 1; color: white; padding-right: 15px;">
                                            <h4 style="font-size: 18px; font-weight: 600; margin-top: 0; margin-bottom: 5px;">Data Lengkap</h4>
                                            <div style="font-size: 38px; font-weight: 700; line-height: 1.1; margin-bottom: 8px;">
                                                <?php echo $complete_count; ?>
                                                <span style="font-size: 16px; font-weight: 400; margin-left: 5px;">Santri</span>
                                            </div>
                                            <div style="background-color: rgba(255,255,255,0.2); height: 8px; border-radius: 4px; margin: 10px 0;">
                                                <div style="background-color: white; width: <?php echo ($complete_count / ($complete_count + $incomplete_count) * 100); ?>%; height: 8px; border-radius: 4px;"></div>
                                            </div>
                                            <div style="font-size: 14px;">
                                                <?php echo round(($complete_count / ($complete_count + $incomplete_count) * 100), 1); ?>% dari total santri
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Data Belum Lengkap -->
                            <div class="col-md-6">
                                <div style="background-color: #dd4b39; border-radius: 12px; box-shadow: 0 4px 10px rgba(221,75,57,0.2); margin-bottom: 20px; position: relative; overflow: hidden;">
                                    <div style="display: flex; align-items: center; padding: 20px;">
                                        <div style="flex: 0 0 80px; text-align: center; margin-right: 15px;">
                                            <div style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-exclamation-circle" style="font-size: 40px; color: white;"></i>
                                            </div>
                                        </div>
                                        <div style="flex: 1; color: white; padding-right: 15px;">
                                            <h4 style="font-size: 18px; font-weight: 600; margin-top: 0; margin-bottom: 5px;">Data Belum Lengkap</h4>
                                            <div style="font-size: 38px; font-weight: 700; line-height: 1.1; margin-bottom: 8px;">
                                                <?php echo $incomplete_count; ?>
                                                <span style="font-size: 16px; font-weight: 400; margin-left: 5px;">Santri</span>
                                            </div>
                                            <div style="background-color: rgba(255,255,255,0.2); height: 8px; border-radius: 4px; margin: 10px 0;">
                                                <div style="background-color: white; width: <?php echo ($incomplete_count / ($complete_count + $incomplete_count) * 100); ?>%; height: 8px; border-radius: 4px;"></div>
                                            </div>
                                            <div style="font-size: 14px;">
                                                <?php echo round(($incomplete_count / ($complete_count + $incomplete_count) * 100), 1); ?>% dari total santri
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Santri Info -->
                        <div class="row">
                            <div class="col-md-12">
                                <div style="background-color: #00c0ef; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,192,239,0.2); margin-top: 5px; margin-bottom: 10px; overflow: hidden; position: relative;">
                                    <div style="padding: 20px; color: white;">
                                        <div style="display: flex; align-items: center;">
                                            <div style="flex: 1;">
                                                <h3 style="font-size: 36px; font-weight: 700; margin: 0 0 5px 0;"><?php echo $complete_count + $incomplete_count; ?></h3>
                                                <p style="font-size: 18px; margin: 0;">Total Santri</p>
                                            </div>
                                            <div style="flex: 0 0 auto; margin-right: 20px;">
                                                <div style="width: 70px; height: 70px; background-color: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-users" style="font-size: 35px; color: white;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="<?= site_url('manage/student') ?>" 
                                       style="display: block; background-color: rgba(0,0,0,0.1); color: white; text-align: center; padding: 10px; text-decoration: none; transition: background-color 0.3s;">
                                        Lihat Semua Data <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="box-header with-border" style="border-radius: 10px 10px 0 0; background-color:rgb(255, 255, 255); color: black; padding: 15px 20px;">
                        <h3 class="box-title"> Daftar Santri</h3>
                        <div class="box-tools pull-right">
                            <div class="btn-group">
                                <a href="?status=complete" class="btn btn-sm btn-success" style="border-radius: 20px 0 0 20px; padding: 5px 15px;"><i class="fa fa-check"></i> Lengkap</a>
                                <a href="?status=incomplete" class="btn btn-sm btn-danger" style="padding: 5px 15px;"><i class="fa fa-warning"></i> Belum Lengkap</a>
                                <a href="<?= site_url('manage/student/monitoring') ?>" class="btn btn-sm btn-default" style="border-radius: 0 20px 20px 0; padding: 5px 15px;"><i class="fa fa-refresh"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-body table-responsive" style="padding: 20px;">
                        <?php if(!empty($students)): ?>
                            <table class="table table-bordered table-striped" style="border-radius: 5px; overflow: hidden;">
                                <thead>
                                    <tr style="background-color: #f4f4f4;">
                                        <th width="5%" class="text-center">No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Komplek</th>
                                        <th>Kamar</th>
                                        <th class="text-center">Status</th>
                                        <th width="10%" class="text-center">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    foreach($students as $student): 
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $student['student_nis'] ?></td>
                                        <td><?= $student['student_full_name'] ?></td>
                                        <td><?= $student['class_name'] ?></td>
                                        <td><?= $student['komplek_name'] ?></td>
                                        <td><?= $student['majors_name'] ?></td>
                                        <td class="text-center">
                                            <?php if($student['is_complete']): ?>
                                                <span style="display: inline-block; background-color: #00a65a; color: white; border-radius: 20px; padding: 5px 12px; font-size: 12px;">
                                                    <i class="fa fa-check"></i> Lengkap
                                                </span>
                                            <?php else: ?>
                                                <span style="display: inline-block; background-color: #dd4b39; color: white; border-radius: 20px; padding: 5px 12px; font-size: 12px;">
                                                    <i class="fa fa-warning"></i> Belum Lengkap
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= site_url('manage/student/view/'.$student['student_id']) ?>" 
                                               style="display: inline-block; background-color: #00c0ef; color: white; border-radius: 4px; padding: 5px 10px; text-decoration: none; font-size: 12px; transition: background-color 0.3s;">
                                                <i class="fa fa-search"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div style="background-color: #f8f9fa; border-left: 4px solid #00c0ef; padding: 20px; border-radius: 5px; text-align: center;">
                                <i class="fa fa-info-circle fa-3x" style="color: #00c0ef; margin-bottom: 10px;"></i>
                                <p style="font-size: 16px; color: #666;">Tidak ada data santri yang tersedia saat ini.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="box-footer" style="border-radius: 0 0 10px 10px; background-color: #f8f9fa; border-top: 1px solid #f0f0f0; padding: 12px 20px;">
                        <div class="text-right">
                            <small class="text-muted">Terakhir diperbarui: <?php echo date('d M Y H:i'); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>