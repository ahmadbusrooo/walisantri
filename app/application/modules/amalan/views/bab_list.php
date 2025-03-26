<!-- application/modules/amalan/views/bab_list.php -->
<div class="content-wrapper">
    <section class="content-header">
        <h1><?= $title ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li><a href="<?= site_url('amalan/amalan') ?>">Kitab</a></li>
            <li class="active"><?= $amalan['amalan_title'] ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <a href="<?= site_url('amalan/bab/add/'.$amalan['amalan_id']) ?>" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i> Tambah Bab
                        </a>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>No</th>
                                <th>Urutan</th>
                                <th>Judul Bab</th>
                                <th>Aksi</th>
                            </tr>
                            <tbody>
                                <?php if(!empty($bab)): ?>
                                    <?php $no=1; foreach($bab as $row): ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $row['bab_order'] ?></td>
                                        <td><?= $row['bab_title'] ?></td>
                                        <td>
                                            <a href="<?= site_url('amalan/bab/edit/'.$row['bab_id']) ?>" class="btn btn-xs btn-warning">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('amalan/isi/edit/'.$row['bab_id']) ?>" class="btn btn-xs btn-info">
                                                <i class="fa fa-edit"></i> Isi
                                            </a>
                                            <a href="#deleteBab<?= $row['bab_id'] ?>" data-toggle="modal" class="btn btn-xs btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteBab<?= $row['bab_id'] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title">Hapus Bab</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin ingin menghapus bab ini?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <?= form_open('amalan/bab/delete/'.$row['bab_id']) ?>
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    <?= form_close() ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $no++; endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada bab</td>
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