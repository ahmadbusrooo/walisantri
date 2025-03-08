<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Kitab</h1>
    </section>
    <section class="content">
    <div class="box" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Kitab</h3>
                <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addKitabModal">
                    <i class="fa fa-plus"></i> Tambah Kitab
                </button>
            </div>

            <!-- Pesan Flash -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <div class="box-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kitab</th>
                            <th>Target Hafalan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kitab)): ?>
                            <?php $no = 1; foreach ($kitab as $row): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['nama_kitab']; ?></td>
                                    <td><?php echo $row['target']; ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editKitabModal<?php echo $row['kitab_id']; ?>">
                                            <i class="fa fa-edit"></i> 
                                        </button>
                                        <a href="<?php echo site_url('kitab/delete/' . $row['kitab_id']); ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus kitab ini?');">
                                            <i class="fa fa-trash"></i> 
                                        </a>
                                    </td>
                                </tr>

                                <!-- Modal Edit Kitab -->
                                <div class="modal fade" id="editKitabModal<?php echo $row['kitab_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editKitabModalLabel<?php echo $row['kitab_id']; ?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <?php echo form_open('kitab/edit/' . $row['kitab_id']); ?>
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="editKitabModalLabel<?php echo $row['kitab_id']; ?>">Edit Kitab</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Nama Kitab</label>
                                                    <input type="text" name="nama_kitab" class="form-control" value="<?php echo $row['nama_kitab']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Target Hafalan</label>
                                                    <input type="text" name="target" class="form-control" value="<?php echo $row['target']; ?>" required>
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
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data kitab.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal Tambah Kitab -->
<div class="modal fade" id="addKitabModal" tabindex="-1" role="dialog" aria-labelledby="addKitabModalLabel">
    <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
            <?php echo form_open('kitab/add'); ?>
            <div class="modal-header">
                <h4 class="modal-title" id="addKitabModalLabel">Tambah Kitab</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kitab</label>
                    <input type="text" name="nama_kitab" class="form-control" placeholder="Contoh: Alfiyah Ibnu Malik" required>
                </div>
                <div class="form-group">
                    <label>Target Hafalan</label>
                    <input type="text" name="target" class="form-control" placeholder="Contoh: 100" required>
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
