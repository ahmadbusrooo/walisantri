<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Data Santri
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('manage') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active"> Santri</li>
        </ol>
    </section>

    <section class="content">


        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary" style="border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="box-header with-border" style="color: black;">
                        <h3 class="box-title"> Daftar Santri</h3>
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


                            <!-- Student Table -->
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" style="border-radius: 8px; overflow: hidden;">
                                    <thead style="background: #f4f4f4;">
                                        <tr>
                                            <th width="40">No</th>
                                            <th>NIS</th>
                                            <th>Nama Lengkap</th>
                                            <th>Kamar</th>
                                            <th>Kelas</th>
                                            <th>Ibu Kandung</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($student)): ?>
                                            <?php $i = 1; ?>
                                            <?php foreach ($student as $row): ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $row['student_nis'] ?></td>
                                                    <td><?= $row['student_full_name'] ?></td>
                                                    <td><?= $row['majors_name'] ?></td>
                                                    <td><?= $row['class_name'] ?></td>
                                                    <td><?= $row['student_name_of_mother'] ?></td>
                                                    <td>
                                                        <span class="label label-<?= ($row['student_status'] == 1) ? 'success' : 'danger' ?>"
                                                            style="border-radius: 20px; padding: 4px 10px;">
                                                            <?= ($row['student_status'] == 1) ? 'Aktif' : 'Non-Aktif' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                    <a href="<?= site_url('manage/student/view/' . $row['student_id']) ?>"
                                                                class="btn btn-xs btn-info" title="Lihat"
                                                                style="border-radius: 20px; padding: 3px 10px;">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center" style="padding: 30px;">
                                                    
                                                    <p class="text-muted">Tidak ada data santri</p>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>


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
    $(document).ready(function() {
        $("#sendWaButton").click(function() {
            var selectedStudents = [];
            $(".checkbox:checked").each(function() {
                selectedStudents.push($(this).val());
            });

            if (selectedStudents.length === 0) {
                alert("Pilih minimal satu santri untuk dikirimi pesan WA.");
                return;
            }

            var message = $("#waMessage").val();
            if (message.trim() === "") {
                alert("Pesan WA tidak boleh kosong.");
                return;
            }

            $.ajax({
                url: "<?php echo site_url('manage/student/send_multiple_wa'); ?>",
                type: "POST",
                data: {
                    students: selectedStudents,
                    message: message
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        alert("Pesan berhasil dikirim!");
                    } else {
                        alert("Gagal mengirim pesan: " + response.message);
                    }
                    $("#modalWa").modal("hide");
                },
                error: function() {
                    alert("Terjadi kesalahan. Coba lagi.");
                }
            });
        });
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