<div class="content-wrapper">
    <section class="content-header">
        <h1>Riwayat Kesehatan Siswa</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Riwayat Kesehatan</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Kondisi Kesehatan</th>
                                    <th>Tindakan</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($kesehatan)): ?>
                                    <?php $no = 1; foreach ($kesehatan as $row): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo isset($row['tanggal']) ? date('d-m-Y', strtotime($row['tanggal'])) : '-'; ?></td>
                                        <td><?php echo isset($row['kondisi_kesehatan']) ? $row['kondisi_kesehatan'] : '-'; ?></td>
                                        <td><?php echo isset($row['tindakan']) ? $row['tindakan'] : '-'; ?></td>
                                        <td><?php echo isset($row['catatan']) ? $row['catatan'] : '-'; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data kesehatan</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
