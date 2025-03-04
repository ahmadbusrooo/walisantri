<div class="content-wrapper">
    <section class="content-header">
        <h1>Riwayat Nadzhaman Siswa</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Riwayat Nadzhaman</h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Kitab</th>
                                    <th>Jumlah Hafalan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($nadzhaman)): ?>
                                    <?php $no = 1; foreach ($nadzhaman as $row): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo isset($row['tanggal']) ? date('d-m-Y', strtotime($row['tanggal'])) : '-'; ?></td>
                                        <td><?php echo isset($row['nama_kitab']) ? $row['nama_kitab'] : '-'; ?></td>
                                        <td><?php echo isset($row['jumlah_hafalan']) ? $row['jumlah_hafalan'] : '-'; ?></td>
                                        <td><?php echo isset($row['keterangan']) ? $row['keterangan'] : '-'; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data nadzhaman</td>
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
