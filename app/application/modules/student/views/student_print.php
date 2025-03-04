<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo isset($title) ? '' . $title : null; ?>
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
            <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box"> 
                    <div class="box-header">
                        <?php if ($this->session->userdata('uroleid') != USER) { ?>
                        <a href="<?php echo site_url('manage/student/add') ?>" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah</a>
                        <a href="<?php echo site_url('manage/student/import') ?>" class="btn btn-sm btn-info"><i class="fa fa-upload"></i> Upload Santri</a>
                        <?php } ?>
                        

                        <div class="box-tools">
                            <?php echo form_open(current_url(), array('class' => 'form-inline', 'method' => 'get')) ?>
                            <div class="input-group input-group-sm" style="flex-wrap: wrap;">
                                <input type="text" id="field" autofocus name="n" 
                                    <?php echo (isset($f['n'])) ? 'placeholder="'.$f['n'].'"' : 'placeholder="NIS Santri"' ?> class="form-control" style="width: auto; min-width: 200px;">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>

                            <!-- Dropdown Pilihan Kelas -->
                            <div class="input-group input-group-sm" style="flex-wrap: wrap; margin-top:5px;">
                                <select class="form-control" name="class" style="min-width: 200px;">
                                    <option value="">-- Semua Kelas --</option>
                                    <?php foreach ($class as $row): ?>
                                        <option value="<?php echo $row['class_id'] ?>" 
                                            <?php echo (isset($f['class']) && $f['class'] == $row['class_id']) ? 'selected' : '' ?>>
                                            <?php echo $row['class_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Dropdown Pilihan Kamar (Jika Mode Senior) -->
                            <?php if (majors() == 'senior') { ?>
                                <div class="input-group input-group-sm" style="flex-wrap: wrap; margin-top:5px;">
                                    <select class="form-control" name="kamar" style="min-width: 200px;">
                                        <option value="">-- Semua Kamar --</option>
                                        <?php foreach ($majors as $row): ?>
                                            <option value="<?php echo $row['majors_id'] ?>" 
                                                <?php echo (isset($f['kamar']) && $f['kamar'] == $row['majors_id']) ? 'selected' : '' ?>>
                                                <?php echo $row['majors_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php } ?>

                            <!-- Tombol Submit -->
                            <div class="input-group input-group-sm" style="flex-wrap: wrap; margin-top:5px;">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Tampilkan</button>
                            </div>

                            <?php echo form_close(); ?>
                        </div>


						<div style="margin-top: -30px; margin-left: 185px;">

    <form action="<?php echo site_url('manage/student/multiple'); ?>" method="post" id="printCardForm">
        <input type="hidden" name="action" value="printPdf">
        <button type="submit" class="btn btn-danger btn-sm" formtarget="_blank">
            <span class="fa fa-print"></span> Cetak Kartu
        </button>



						</div>
						


						
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></th> 
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Nama Ibu Kandung</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                <tbody>
                                    <?php
                                    if (!empty($student)) {
                                        $i = 1;
                                        foreach ($student as $row):
                                            ?>
                                            <tr>
                                                <td><input type="checkbox" class="checkbox" name="msg[]" value="<?php echo $row['student_id']; ?>"></td>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['student_nis']; ?></td>
                                                <td><?php echo $row['student_full_name']; ?></td>
                                                <td><?php echo $row['class_name']; ?></td>
                                                <td><?php echo $row['student_name_of_mother']; ?></td>
                                                <td><label class="label <?php echo ($row['student_status']==1) ? 'label-success' : 'label-danger' ?>"><?php echo ($row['student_status']==1) ? 'Aktif' : 'Tidak Aktif' ?></label></td>
                                                <td>
                                                    <a href="<?php echo site_url('manage/student/rpw/' . $row['student_id']) ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Reset Password"><i class="fa fa-unlock"></i></a>
                                                    <a href="<?php echo site_url('manage/student/view/' . $row['student_id']) ?>" class="btn btn-xs btn-info" data-toggle="tooltip" title="Lihat"><i class="fa fa-eye"></i></a>
                                                    <?php if ($this->session->userdata('uroleid') != USER) { ?>
                                                    <a href="<?php echo site_url('manage/student/edit/' . $row['student_id']) ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                                    <?php } ?>
                                                    <a href="<?php echo site_url('manage/student/printPdf/' . $row['student_id']) ?>" class="btn btn-success btn-xs view-pdf" data-toggle="tooltip" title="Cetak Kartu"><i class="fa fa-print"></i></a>
                                                </td>	
                                            </tr>
                                            <?php
                                            $i++;
                                        endforeach;
                                    } else {
                                        ?>
                                        <tr id="row">
                                            <td colspan="8" align="center">Data Kosong</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
							</form>
							<!-- Form terpisah untuk Cetak Data Santri -->
							<form method="post" action="<?= site_url('manage/student/printAllPdf') ?>" target="_blank">
                        <div class="box-header">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-print"></i> Cetak Data Santri
                            </button>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalWa">
                            <i class="fab fa-whatsapp"></i>
                            Kirim WA
                            </button>

                        </div>

                        <!-- Checkbox siswa agar tetap terkirim ke printAllPdf -->
                        <div class="box-body table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <?php if (!empty($student)) { 
                                        foreach ($student as $row): ?>
                                            <input type="hidden" class="checkbox" name="msg[]" value="<?php echo $row['student_id']; ?>">
                                        <?php endforeach;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                            <!-- /.box-body -->
                        </div>
                        <div>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            
			
        </section>
        <!-- /.content -->
    </div>
<!-- Modal Kirim WhatsApp -->
<div class="modal fade" id="modalWa" tabindex="-1" role="dialog" aria-labelledby="modalWaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
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
		(function(a){
			a.createModal=function(b){
				defaults={
					title:"",message:"Your Message Goes Here!",closeButton:true,scrollable:false
				};
				var b=a.extend({},defaults,b);
				var c=(b.scrollable===true)?'style="max-height: 420px;overflow-y: auto;"':"";
				html='<div class="modal fade" id="myModal">';
				html+='<div class="modal-dialog">';
				html+='<div class="modal-content">';
				html+='<div class="modal-header">';
				html+='<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>';
				if(b.title.length>0){
					html+='<h4 class="modal-title">'+b.title+"</h4>"
				}
				html+="</div>";
				html+='<div class="modal-body" '+c+">";
				html+=b.message;
				html+="</div>";
				html+='<div class="modal-footer">';
				if(b.closeButton===true){
					html+='<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>'
				}
				html+="</div>";
				html+="</div>";
				html+="</div>";
				html+="</div>";a("body").prepend(html);a("#myModal").modal().on("hidden.bs.modal",function(){
					a(this).remove()})}})(jQuery);

/*
* Here is how you use it
*/
$(function(){    
	$('.view-pdf').on('click',function(){
		var pdf_link = $(this).attr('href');      
		var iframe = '<object type="application/pdf" data="'+pdf_link+'" width="100%" height="350">No Support</object>'
		$.createModal({
			title:'Cetak Kartu Pembayaran',
			message: iframe,
			closeButton:true,
			scrollable:false
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
