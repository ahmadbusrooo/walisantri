<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $title; ?></h1>
    </section>

    <section class="content">
    <div class="box" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

            <div class="box-body">
                <a href="<?php echo site_url('pengurus/form'); ?>" class="btn btn-success">
                    <i class="fa fa-plus"></i> Tambah Pengurus
                </a>
                <br><br>

                <!-- Tombol Cetak PDF dan Kirim WhatsApp -->
                <form id="pdfForm" action="<?php echo site_url('pengurus/printPdf'); ?>" method="post" target="_blank">
    <input type="hidden" name="pengurus_ids" id="pengurusIds">
</form>

<button type="button" class="btn btn-primary btn-sm" id="printPdf">
    <i class="fa fa-print"></i> Cetak PDF
</button>

                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalWa">
                    <i class="fab fa-whatsapp"></i> Kirim WA
                </button>
                <br><br>

                <!-- Form untuk cetak PDF -->
                <form id="pdfForm" action="<?php echo site_url('pengurus/printPdf'); ?>" method="post" target="_blank">
                    <input type="hidden" name="pengurus_ids" id="pengurusIds">
                </form>

                <!-- Tabel Responsif -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Tanggal Lahir</th>
                                <th>Status</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Jabatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($pengurus as $p) { ?>
                            <tr>
                            <td><input type="checkbox" class="checkbox" name="pengurus[]" value="<?php echo $p['pengurus_id']; ?>"></td>

                                <td><?php echo $no++; ?></td>
                                <td><?php echo $p['pengurus_nama']; ?></td>
                                <td><?php echo $p['pengurus_nik']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($p['pengurus_tgl_lahir'])); ?></td>
                                <td>
                                    <span class="badge <?php echo ($p['pengurus_status']) ? 'badge-success' : 'badge-danger'; ?>">
                                        <?php echo $p['pengurus_status'] ? 'Aktif' : 'Tidak Aktif'; ?>
                                    </span>
                                </td>
                                <td><?php echo $p['pengurus_alamat']; ?></td>
                                <td><?php echo $p['pengurus_telepon']; ?></td>
                                <td><?php echo $p['pengurus_jabatan']; ?></td>
                                <td>
                                    <a href="<?php echo site_url('pengurus/form/'.$p['pengurus_id']); ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> 
                                    </a>
                                    <a href="<?php echo site_url('pengurus/delete/'.$p['pengurus_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">
                                        <i class="fa fa-trash"></i> 
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- Modal Kirim WhatsApp -->
<div class="modal fade" id="modalWa" tabindex="-1" role="dialog" aria-labelledby="modalWaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">

            <div class="modal-header">
                <h5 class="modal-title" id="modalWaLabel">Kirim WhatsApp ke Pengurus</h5>
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

<script>
$(document).ready(function() {
    // Select All Checkbox
    $("#selectAll").change(function() {
        $(".checkbox").prop('checked', $(this).prop("checked"));
    });

    // Tombol Cetak PDF
    $("#printPdf").click(function() {
    var selectedPengurus = [];
    $(".checkbox:checked").each(function() {
        selectedPengurus.push($(this).val());
    });

    if (selectedPengurus.length === 0) {
        alert("Pilih minimal satu pengurus untuk dicetak.");
        return;
    }

    $("#pengurusIds").val(selectedPengurus.join(","));
    $("#pdfForm").submit();
});

    // Tombol Kirim WA
    $("#sendWaButton").click(function() {
    var selectedPengurus = [];
    $(".checkbox:checked").each(function() {
        var status = $(this).closest("tr").find("td:eq(5)").text().trim();
        if (status === "Aktif") {
            selectedPengurus.push($(this).val());
        }
    });

    if (selectedPengurus.length === 0) {
        alert("Pilih minimal satu pengurus aktif untuk dikirimi pesan WA.");
        return;
    }

    var message = $("#waMessage").val();
    if (message.trim() === "") {
        alert("Pesan WA tidak boleh kosong.");
        return;
    }

    $.ajax({
        url: "<?php echo site_url('pengurus/send_multiple_wa'); ?>",
        type: "POST",
        data: {
            pengurus: selectedPengurus, // Kirim hanya pengurus aktif
            message: message
        },
        dataType: "json",
        success: function(response) {
            console.log("Response dari server:", response); // Debugging
            if (response && response.status === "success") {
                alert("Pesan berhasil dikirim!");
                $("#modalWa").modal("hide");
            } else {
                alert("Gagal mengirim pesan: " + (response.message || "Terjadi kesalahan."));
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", xhr.responseText);
            alert("Terjadi kesalahan. Coba lagi.");
        }
    });
});






});
</script>
