<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo $title; ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> Kenaikan Juz tidak mempengaruhi status kelulusan.
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="box-body">
                        <?php echo form_open(current_url(), array('method' => 'get')) ?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon alert-info">Pilih Juz Saat Ini</div>
                                <select class="form-control" name="pr" onchange="this.form.submit()">
                                    <option value="">-- Semua Juz --</option>
                                    <?php foreach ($juzz as $row): ?>
                                        <option <?php echo (isset($f['pr']) && $f['pr'] == $row['juzz_id']) ? 'selected' : '' ?> 
                                            value="<?php echo $row['juzz_id'] ?>">
                                            <?php echo $row['juzz_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php echo form_close() ?>

                        <table class="table table-bordered">
                            <form action="<?php echo site_url('manage/student/multiple'); ?>" method="post">
                                <input type="hidden" name="action" value="upgrade_juz">
                                <tr>
                                    <th><input type="checkbox" id="selectall"></th>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Juz Saat Ini</th>
                                </tr>
                                <tbody>
                                    <?php if (!empty($student)): ?>
                                        <?php $i = 1; ?>
                                        <?php foreach ($student as $row): ?>
                                            <tr>
                                                <td><input type="checkbox" class="checkbox" name="msg[]" value="<?php echo $row['student_id'] ?>"></td>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $row['student_nis'] ?></td>
                                                <td><?php echo $row['student_full_name'] ?></td>
                                                <td><?php echo isset($row['juzz_name']) ? $row['juzz_name'] : 'Belum Ada'; ?></td>
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

                <div class="col-md-3">
                    <div class="panel panel-success" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                        <div class="panel-body">
                            <select class="form-control" name="juzz_id" required>
                                <option value="">-- Ke Juzz --</option>
                                <?php foreach ($upgrade_juzz as $juz): ?>
                                    <option value="<?php echo $juz['juzz_id'] ?>">
                                        <?php echo $juz['juzz_name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <br>
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fa fa-arrow-up"></i> Naikkan Juz
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function() {
            $("#selectall").change(function() {
                $(".checkbox").prop('checked', $(this).prop("checked"));
            });
        });
    </script>