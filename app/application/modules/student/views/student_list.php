<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Manajemen Data Santri
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('manage') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Manajemen Santri</li>
        </ol>
    </section>

    <section class="content">
        <!-- Stats Cards -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid" style="border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div style="background-color: #00a65a; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,166,90,0.2); margin-bottom: 20px; position: relative; overflow: hidden;">
                                    <div style="display: flex; align-items: center; padding: 20px;">
                                        <div style="flex: 0 0 80px; text-align: center; margin-right: 15px;">
                                            <div style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-users" style="font-size: 40px; color: white;"></i>
                                            </div>
                                        </div>
                                        <div style="flex: 1; color: white; padding-right: 15px;">
                                            <h4 style="font-size: 18px; font-weight: 600; margin-top: 0; margin-bottom: 5px;">Jumlah Santri</h4>
                                            <div style="font-size: 38px; font-weight: 700; line-height: 1.1; margin-bottom: 8px;">
                                                <?php echo $total_students; ?>
                                                <span style="font-size: 16px; font-weight: 400; margin-left: 5px;">Santri</span>
                                            </div>
                                            <div style="background-color: rgba(255,255,255,0.2); height: 8px; border-radius: 4px; margin: 10px 0;">
                                                <div style="background-color: white; width: <?php echo ($complete_count / ($complete_count + $incomplete_count) * 100); ?>%; height: 8px; border-radius: 4px;"></div>
                                            </div>
                                            <div style="font-size: 14px;">
                                                <?php echo round(($complete_count / ($complete_count + $incomplete_count) * 100), 1); ?>% data sudah lengkap
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="background-color:rgb(118, 123, 23); border-radius: 12px; box-shadow: 0 4px 10px rgba(0,166,90,0.2); margin-bottom: 20px; position: relative; overflow: hidden;">
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
                            <div class="col-md-4">
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
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" style="border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="box-header with-border" style="color: black;">
                        <h3 class="box-title"> Daftar Santri</h3>
                        <div class="box-tools pull-right">
                            
                                <a href="<?= site_url('manage/student/add') ?>" class="btn btn-sm btn-success">
                                    <i class="fa fa-plus"></i> Tambah
                                </a>
                          
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <div class="box-body" style="padding: 20px;">
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-md-4 col-xs-12">
                                <form method="get">
                                    <div class="input-group" style="border-radius: 20px;">
                                        <input type="text" name="n" class="form-control input-sm"
                                            placeholder="Cari NIS/Nama..." style="border-radius: 20px 0 0 20px;">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default btn-sm" type="submit" style="border-radius: 0 20px 20px 0;">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-4 col-xs-12">
                                <form method="get">
                                    <select class="form-control input-sm" name="class" onchange="this.form.submit()"
                                        style="border-radius: 20px; padding: 5px 15px;">
                                        <option value="">-- Semua Kelas --</option>
                                        <?php foreach ($class as $row): ?>
                                            <option value="<?= $row['class_id'] ?>" <?= isset($f['class']) && $f['class'] == $row['class_id'] ? 'selected' : '' ?>>
                                                <?= $row['class_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </div>

                            <div class="col-md-4 col-xs-12">
                                <form method="get">
                                    <select class="form-control input-sm" name="komplek_id" onchange="this.form.submit()"
                                        style="border-radius: 20px; padding: 5px 15px;">
                                        <option value="">-- Semua Komplek --</option>
                                        <?php foreach ($komplek as $k): ?>
                                            <option value="<?= $k['komplek_id'] ?>" <?= isset($_GET['komplek_id']) && $_GET['komplek_id'] == $k['komplek_id'] ? 'selected' : '' ?>>
                                                <?= $k['komplek_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <form action="<?= site_url('manage/student/multiple') ?>" method="post" id="printCardForm">
                            <div class="row" style="margin-bottom: 15px;">
                                <div class="col-xs-12">
                                    <input type="hidden" name="action" value="printPdf">
                                    <button type="submit" class="btn btn-danger btn-sm" formtarget="_blank"
                                        style="border-radius: 20px; padding: 5px 15px;">
                                        <i class="fa fa-print"></i> Cetak Kartu
                                    </button>

                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalWa"
                                        style="border-radius: 20px; padding: 5px 15px;">
                                        <i class="fab fa-whatsapp"></i> Kirim WA
                                    </button>

                                </div>
                            </div>

                            <!-- Student Table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" style="border-radius: 8px; overflow: hidden;">
                                    <thead style="background: #f4f4f4;">
                                        <tr>
                                            <th width="30"><input type="checkbox" id="selectall"></th>
                                            <th width="40">No</th>
                                            <th>NIS</th>
                                            <th>Nama Lengkap</th>
                                            <th>Kelas</th>
                                            <th>Ibu Kandung</th>
                                            <th>Status</th>
                                            <th width="150">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($student)): ?>
                                            <?php $i = 1; ?>
                                            <?php foreach ($student as $row): ?>
                                                <tr>
                                                    <td><input type="checkbox" class="checkbox" name="msg[]" value="<?= $row['student_id'] ?>"></td>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $row['student_nis'] ?></td>
                                                    <td><?= $row['student_full_name'] ?></td>
                                                    <td><?= $row['class_name'] ?></td>
                                                    <td><?= $row['student_name_of_mother'] ?></td>
                                                    <td>
                                                        <span class="label label-<?= ($row['student_status'] == 1) ? 'success' : 'danger' ?>"
                                                            style="border-radius: 20px; padding: 4px 10px;">
                                                            <?= ($row['student_status'] == 1) ? 'Aktif' : 'Non-Aktif' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="<?= site_url('manage/student/view/' . $row['student_id']) ?>"
                                                                class="btn btn-xs btn-info" title="Lihat"
                                                                style="border-radius: 20px; padding: 3px 10px;">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            
                                                                <a href="<?= site_url('manage/student/edit/' . $row['student_id']) ?>"
                                                                    class="btn btn-xs btn-warning" title="Edit"
                                                                    style="border-radius: 20px; padding: 3px 10px;">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <a href="<?= site_url('manage/student/rpw/' . $row['student_id']) ?>"
                                                                    class="btn btn-xs btn-danger" title="Reset Password"
                                                                    style="border-radius: 20px; padding: 3px 10px;">
                                                                    <i class="fa fa-unlock"></i>
                                                                </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center" style="padding: 30px;">
                                                    <i class="fa fa-database fa-3x text-muted"></i><br>
                                                    <p class="text-muted">Tidak ada data santri</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <!-- Pagination -->
                        <div class="text-center">
                            <?= $this->pagination->create_links() ?>
                        </div>
                    </div>

                    <div class="box-footer" style="background: #f8f9fa; border-top: 1px solid #f0f0f0;">
                        <small class="text-muted pull-right">
                            Terakhir diperbarui: <?= date('d M Y H:i') ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modals and JavaScript tetap sama seperti kode asli -->
<!-- Modal Kirim WhatsApp -->
<div class="modal fade" id="modalWa" tabindex="-1" role="dialog" aria-labelledby="modalWaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

            <div class="modal-header">
                <h5 class="modal-title" id="modalWaLabel">Kirim WhatsApp ke Orang Tua</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="waForm">
                    <div class="form-group">
                        <label for="waMessage">Pesan:</label>
                        <textarea class="form-control" id="waMessage" name="waMessage" rows="4" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="sendWaButton">Kirim</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Hasil Pengiriman -->
<!-- Modal Hasil Pengiriman -->
<div class="modal fade" id="modalResult" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.15);">
            <div class="modal-header" style="padding: 15px 20px;">
                <h5 class="modal-title"> Hasil Pengiriman WhatsApp</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div id="resultContent" class="p-3" style="max-height: 70vh; overflow-y: auto;"></div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #eee; padding: 12px 20px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="window.location.reload()">
                    Muat Ulang
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Result Modal Styling */
    #modalResult .modal-content {
        border: none;
    }
    
    #modalResult .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    
    #modalResult .close {
        outline: none;
        opacity: 0.8;
        margin: -15px -10px -15px 0;
        padding: 10px;
        border-radius: 50%;
        transition: all 0.2s;
    }
    
    #modalResult .close:hover {
        opacity: 1;
        background-color: rgba(255,255,255,0.1);
    }
    
    #resultContent {
        -webkit-overflow-scrolling: touch;
    }
    
    .result-card {
        border-radius: 10px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.2s;
    }
    
    .result-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }
    
    .result-card-header {
        padding: 0.9rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .result-card-header i {
        margin-right: 8px;
    }
    
    .badge-count {
        min-width: 30px;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 1 rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .result-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }
    
    .result-list-item {
        display: flex;
        align-items: center;
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: background-color 0.15s;
    }
    
    .result-list-item:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .result-list-item:last-child {
        border-bottom: none;
    }
    
    .result-list-content {
        flex: 1;
    }
    
    .result-name {
        font-weight: 600;
        margin-bottom: 2px;
    }
    
    .result-phone {
        color: #6c757d;
        font-size: 0.875rem;
    }
    
    .result-reason {
        margin-top: 3px;
        color: #dc3545;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
    }
    
    .result-reason i {
        margin-right: 4px;
    }
    
    .result-icon {
        margin-left: 12px;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    
    .result-icon.success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    .result-icon.danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .alert {
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border: 1px solid transparent;
    }
    
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        #modalResult .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }
        
        .result-card-header {
            padding: 0.75rem 1rem;
        }
        
        .result-list-item {
            padding: 0.75rem 1rem;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .result-icon {
            margin-left: 0;
            margin-top: 10px;
            align-self: flex-end;
            margin-top: -30px;
        }
    }
</style>





<script type="text/javascript">
    (function(a) {
        a.createModal = function(b) {
            defaults = {
                title: "",
                message: "Your Message Goes Here!",
                closeButton: true,
                scrollable: false
            };
            var b = a.extend({}, defaults, b);
            var c = (b.scrollable === true) ? 'style="max-height: 420px;overflow-y: auto;"' : "";
            html = '<div class="modal fade" id="myModal">';
            html += '<div class="modal-dialog">';
            html += '<div class="modal-content">';
            html += '<div class="modal-header">';
            html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>';
            if (b.title.length > 0) {
                html += '<h4 class="modal-title">' + b.title + "</h4>"
            }
            html += "</div>";
            html += '<div class="modal-body" ' + c + ">";
            html += b.message;
            html += "</div>";
            html += '<div class="modal-footer">';
            if (b.closeButton === true) {
                html += '<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'
            }
            html += "</div>";
            html += "</div>";
            html += "</div>";
            html += "</div>";
            a("body").prepend(html);
            a("#myModal").modal().on("hidden.bs.modal", function() {
                a(this).remove()
            })
        }
    })(jQuery);

    /*
     * Here is how you use it
     */
    $(function() {
        $('.view-pdf').on('click', function() {
            var pdf_link = $(this).attr('href');
            var iframe = '<object type="application/pdf" data="' + pdf_link + '" width="100%" height="350">No Support</object>'
            $.createModal({
                title: 'Cetak Kartu Pembayaran',
                message: iframe,
                closeButton: true,
                scrollable: false
            });
            return false;
        });
    })
</script>
<script>
    $(document).ready(function() {
        $("#selectall").change(function() {
            $(".checkbox").prop('checked', $(this).prop("checked"));
        });
    });
</script>
<script>
$("#sendWaButton").click(function() {
    var $btn = $(this);
    var originalText = $btn.html();
    
    // 1. Validasi pertama - Cek checkbox terpilih
    var selectedStudents = [];
    $(".checkbox:checked").each(function() {
        selectedStudents.push($(this).val());
    });

    if (selectedStudents.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Pilih Santri',
            text: 'Silakan pilih minimal satu santri terlebih dahulu!',
            width: 600,
            padding: '2em',
            customClass: {
                popup: 'custom-swal-popup',
                title: 'text-lg'
            }
        });
        return; // Hentikan proses
    }

    // 2. Validasi kedua - Cek isi pesan
    var message = $("#waMessage").val().trim();
    if (message === "") {
        Swal.fire({
            icon: 'error',
            title: 'Pesan Kosong',
            text: 'Silakan tulis pesan yang akan dikirim!',
            width: 600
        });
        return;
    }

    // 3. Jika semua validasi lolos, tampilkan loading
    $btn.html('<i class="fa fa-spinner fa-spin"></i> Mengirim...').prop('disabled', true);
    
    $.ajax({
        url: "<?php echo site_url('manage/student/send_multiple_wa'); ?>",
        type: "POST",
        data: {
            students: selectedStudents,
            message: message
        },
        dataType: "json",
        success: function(response) {
            // Reset form
            $("#waMessage").val('');
            
            let html = `<div class="container-fluid p-0">`;

            // Header Status
            html += `<div class="alert ${response.status === 'success' ? 'alert-success' : 'alert-info'} mb-4">
                <h5 class="mb-0"><i class="fa fa-${response.status === 'success' ? 'check-circle' : 'info-circle'} mr-2"></i> ${response.message}</h5>
            </div>`;

            // Bagian Berhasil
            if (response.success && response.success.length > 0) {
                html += `<div class="result-card border-success">
                    <div class="result-card-header bg-success text-white">
                        <span><i class="fa fa-check-circle"></i> Berhasil Dikirim</span>
                        <span class="badge-count bg-white text-success">${response.success.length}</span>
                    </div>
                    <div class="result-list">`;

                    response.success.forEach(student => {
    html += `<div class="result-list-item">
        <div class="result-list-content">
            <div class="result-name">${student.name}</div>
            <div class="result-phone">${student.phone}</div>
            <div class="text-muted small mt-1">
                Nama Ayah: ${student.father_name || '-'}
            </div>
        </div>
        <!-- ... -->
    </div>`;
});
                html += `</div></div>`;
            }

            // Bagian Gagal
            if (response.failed && response.failed.length > 0) {
                html += `<div class="result-card border-danger mt-4">
                    <div class="result-card-header bg-danger text-white">
                        <span><i class="fa fa-exclamation-circle"></i> Gagal Dikirim</span>
                        <span class="badge-count bg-white text-danger">${response.failed.length}</span>
                    </div>
                    <div class="result-list">`;

                response.failed.forEach(student => {
                    html += `<div class="result-list-item">
                        <div class="result-list-content">
                            <div class="result-name">${student.name}</div>
                            <div class="result-phone">${student.phone || 'Tidak ada nomor'}</div>
                            ${student.reason ? `<div class="result-reason"><i class="fa fa-info-circle"></i> ${student.reason}</div>` : ''}
                        </div>
                        <div class="result-icon danger">
                            <i class="fa fa-times"></i>
                        </div>
                    </div>`;
                });

                html += `</div></div>`;
            }

            html += `</div>`; // Tutup container-fluid

            $('#resultContent').html(html);
            $('#modalResult').modal('show');
            
            // Tambahkan ini untuk animasi smooth scroll jika hasil terlalu panjang
            $('#resultContent').animate({ scrollTop: 0 }, 'fast');
        },
        error: function(xhr, status, error) {
            let errorMessage = 'Terjadi kesalahan koneksi';
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    errorMessage = response.message;
                }
            } catch (e) {
                console.error('Error parsing response:', e);
            }
            
            $('#resultContent').html(`
                <div class="alert alert-danger">
                    <h5 class="mb-0"><i class="fa fa-exclamation-triangle mr-2"></i> Gagal</h5>
                    <p class="mt-2 mb-0">${errorMessage}</p>
                </div>
            `);
            $('#modalResult').modal('show');
        },
        complete: function() {
            $btn.html(originalText).prop('disabled', false);
            $("#modalWa").modal("hide");
        }
    });
});

// Add this to ensure modal properly scrolls on mobile devices
$('#modalResult').on('shown.bs.modal', function() {
    $('#resultContent').css('max-height', window.innerHeight * 0.7);
});

// Update scroll height on window resize
$(window).resize(function() {
    if ($('#modalResult').hasClass('show')) {
        $('#resultContent').css('max-height', window.innerHeight * 0.7);
    }
});
</script>
<script>
    $(document).ready(function() {
        $("#printCardForm").submit(function(e) {
            var selectedStudents = $(".checkbox:checked").length;
            if (selectedStudents === 0) {
                alert("Pilih minimal satu santri sebelum mencetak kartu.");
                e.preventDefault(); // Mencegah form dikirim jika tidak ada yang dipilih
            }
        });
    });
</script>