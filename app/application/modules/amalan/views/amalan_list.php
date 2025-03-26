<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?= $title ?></li>
        </ol>
    </section>
    
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <a href="<?= site_url('amalan/amalan/add') ?>" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i> Tambah Kitab
                        </a>
                    </div>
                    
                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            <tbody>
                                <?php if(!empty($amalan)): ?>
                                    <?php $no=1; foreach($amalan as $row): ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $row['amalan_title'] ?></td>
                                        <td><?= date('d F Y', strtotime($row['created_at'])) ?></td>
                                        <td><?= $row['amalan_publish'] ? 'Published' : 'Draft' ?></td>
                                        <td>
                                            <a href="<?= site_url('amalan/amalan/edit/'.$row['amalan_id']) ?>" class="btn btn-xs btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('amalan/bab/index/'.$row['amalan_id']) ?>" class="btn btn-xs btn-info">
                                                <i class="fa fa-list"></i> Bab
                                            </a>
                                            <a href="#deleteModal<?= $row['amalan_id'] ?>" data-toggle="modal" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; endforeach; ?>
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
        </div>
        <!-- Tambahkan ini di dalam section content, setelah tabel atau di dalam loop -->
<?php if(!empty($amalan)): ?>
    <?php foreach($amalan as $row): ?>
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal<?= $row['amalan_id'] ?>" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus kitab:</p>
                        <h4>"<?= $row['amalan_title'] ?>"</h4>
                        <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan!</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="<?= site_url('amalan/amalan/delete/'.$row['amalan_id']) ?>" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
    </section>
</div>