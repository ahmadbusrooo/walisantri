<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Pelanggaran Siswa</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Riwayat Pelanggaran</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Poin</th>
                                    <th>Pelanggaran</th>
                                    <th>Tindakan</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pelanggaran)): ?>
                                    <?php $no = 1; foreach ($pelanggaran as $row): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                        <td><?php echo $row['poin']; ?></td>
                                        <td><?php echo $row['pelanggaran']; ?></td>
                                        <td><?php echo $row['tindakan']; ?></td>
                                        <td><?php echo $row['catatan']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data pelanggaran</td>
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
