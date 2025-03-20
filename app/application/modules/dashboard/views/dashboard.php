<style>
  .info-box {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .info-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
  }


  .info-box-content {
    padding: 20px;
  }


  .bg-green {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
  }

  .bg-red {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
  }

  .bg-blue {
    background: linear-gradient(135deg, #3498db, #2980b9);
  }

  .bg-yellow {
    background: linear-gradient(135deg, #f1c40f, #f39c12);
  }

  .bg-purple {
    background: linear-gradient(135deg, #9b59b6, #8e44ad);
  }

  .bg-orange {
    background: linear-gradient(135deg, #e67e22, #d35400);
  }

  .bg-teal {
    background: linear-gradient(135deg, #1abc9c, #16a085);
  }

  .bg-cyan {
    background: linear-gradient(135deg, #00bcd4, #0097a7);
  }

  .bg-cyan .info-box-icon i,
  .bg-cyan .info-box-text,
  .bg-cyan .info-box-number {
    color: white !important;
  }


  .carousel-img {
    max-width: 100%;
    height: auto;
    object-fit: cover;
    width: 100%;
    height: 300px;
    border-radius: 12px;
  }

  .carousel-inner {
    text-align: center;
  }

  .box {
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .box-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0;
  }

  .box-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
  }

  .box-body {
    padding: 20px;
  }

  .modal-content {
    border-radius: 12px;
  }

  .modal-header {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0;
  }

  .modal-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
  }

  .modal-body {
    padding: 20px;
  }

  .modal-footer {
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    border-radius: 0 0 12px 12px;
  }

  #loading-overlay {
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #loading-overlay .spinner {
    border: 4px solid rgba(0, 0, 0, 0.1);
    border-left-color: #3498db;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    to {
      transform: rotate(360deg);
    }
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div id="loading-overlay">
  <div class="spinner"></div>
</div>

<script>
  window.onload = function() {
    document.getElementById("loading-overlay").style.display = "none";
  };
</script>


<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <!-- Card Penerimaan Hari Ini -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="card info-box bg-green">
          <div class="card-body">
            <div class="info-box-icon"><i class="fas fa-wallet"></i></div>
            <div class="info-box-content">
              <span class="info-box-text dash-text">Penerimaan Hari Ini</span>
              <span class="info-box-number"><?php echo 'Rp. ' . number_format($total_bulan + $total_bebas + $total_debit, 0, ',', '.') ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Pengeluaran Hari Ini -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="card info-box bg-red">
          <div class="card-body">
            <div class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></div>
            <div class="info-box-content">
              <span class="info-box-text dash-text">Pengeluaran Hari Ini</span>
              <span class="info-box-number"><?php echo 'Rp. ' . number_format($total_kredit, 0, ',', '.') ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Total Penerimaan -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="card info-box bg-blue">
          <div class="card-body">
            <div class="info-box-icon"><i class="fas fa-coins"></i></div>
            <div class="info-box-content">
              <?php
              $totalAll = $total_bulan + $total_bebas + $total_debit;
              ?>
              <span class="info-box-text dash-text">Total Penerimaan</span>
              <span class="info-box-number"><?php echo 'Rp. ' . number_format($totalAll - $total_kredit, 0, ',', '.') ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Santri Aktif -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="card info-box bg-yellow">
          <div class="card-body">
            <div class="info-box-icon"><i class="fa fa-users"></i></div>
            <div class="info-box-content">
              <span class="info-box-text dash-text">Santri Aktif</span>
              <span class="info-box-number"><?php echo $student ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Ustadz Aktif -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="card info-box bg-purple">
          <div class="card-body">
            <div class="info-box-icon"><i class="fas fa-chalkboard-teacher"></i></div>
            <div class="info-box-content">
              <span class="info-box-text dash-text">Ustadz Aktif</span>
              <span class="info-box-number"><?php echo $total_ustadz; ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Total Pengurus -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="card info-box bg-cyan">
          <div class="card-body">
            <div class="info-box-icon"><i class="fas fa-users-cog"></i></div>
            <div class="info-box-content">
              <span class="info-box-text dash-text">Total Pengurus</span>
              <span class="info-box-number"><?php echo $total_active_pengurus; ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Total Kelas -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="card info-box bg-orange">
          <div class="card-body">
            <div class="info-box-icon"><i class="fas fa-school"></i></div>
            <div class="info-box-content">
              <span class="info-box-text dash-text">Total Kelas</span>
              <span class="info-box-number"><?php echo $total_classes; ?></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Card Total Kamar -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="card info-box bg-teal">
          <div class="card-body">
            <div class="info-box-icon"><i class="fas fa-bed"></i></div>
            <div class="info-box-content">
              <span class="info-box-text dash-text">Total Kamar</span>
              <span class="info-box-number"><?php echo $total_majors; ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Grafik Keuangan dan Papan Informasi -->
    <div class="row">
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Distribusi Santri per Komplek</h3>
          </div>
          <div class="box-body">
            <canvas id="studentsByKomplekChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Distribusi Santri per Kelas</h3>
          </div>
          <div class="box-body">
            <canvas id="studentsByClassChart"></canvas>
          </div>
        </div>
      </div>
      <!-- <div class="col-md-6">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Grafik Keuangan</h3>
          </div>
          <div class="box-body">
            <canvas id="financeChart"></canvas>
          </div>
        </div>
      </div> -->

    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Data Masuk & Keluar Santri</h3>
          </div>
          <div class="box-body">
            <form method="GET" action="">
              <div class="form-group">
                <label for="month">Pilih Bulan:</label>
                <select name="month" id="month" class="form-control">
                  <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>"
                      <?php echo ($i == $selected_month) ? 'selected' : ''; ?>>
                      <?php echo date('F', mktime(0, 0, 0, $i, 1)); ?>
                    </option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="year">Pilih Tahun:</label>
                <select name="year" id="year" class="form-control">
                  <?php for ($y = date('Y') - 5; $y <= date('Y'); $y++): ?>
                    <option value="<?php echo $y; ?>"
                      <?php echo ($y == $selected_year) ? 'selected' : ''; ?>>
                      <?php echo $y; ?>
                    </option>
                  <?php endfor; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Filter</button>
            </form>
            <br>
            <ul class="list-group">
              <li class="list-group-item">
                <strong>Santri Masuk:</strong>
                <?php echo $santri_masuk_keluar['total_masuk']; ?>
              </li>
              <li class="list-group-item">
                <strong>Santri Keluar:</strong>
                <?php echo $santri_masuk_keluar['total_keluar']; ?>
              </li>
              <li class="list-group-item">
                <strong>Selisih:</strong>
                <?php echo $santri_masuk_keluar['total_masuk'] - $santri_masuk_keluar['total_keluar']; ?>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Grafik Masuk & Keluar Santri</h3>
          </div>
          <div class="box-body">
            <canvas id="santriInOutChart"></canvas>
          </div>
        </div>
      </div>
    </div>
<!-- Tambahkan di bagian konten utama setelah row pertama -->
<div class="row">
  <div class="col-md-12">
    <div class="box box-danger">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-exclamation-triangle"></i> Pelanggaran Hari Ini 
          <small class="text-white">(<?= date('d F Y') ?>)</small>
        </h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="refresh" onclick="refreshViolations()">
            <i class="fa fa-sync-alt"></i>
          </button>
        </div>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover table-striped">
            <thead class="bg-red">
              <tr>
                <th class="text-center">Waktu</th>
                <th>Nama Santri</th>
                <th>Jenis Pelanggaran</th>
                <th class="text-center">Poin</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($today_violations)) : ?>
                <?php foreach ($today_violations as $violation) : ?>
                  <tr>
                    <td class="text-center">
                      <span class="badge bg-red">
                      <?= $violation['pelanggaran_created_at'] ?>
                      </span>
                    </td>
                    <td><?= $violation['student_full_name'] ?></td>
                    <td><?= $violation['pelanggaran'] ?></td>
                    <td class="text-center">
                      <span class="badge bg-orange">
                        <?= $violation['poin'] ?>
                      </span>
                    </td>
                    <td><?= $violation['tindakan'] ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="5" class="text-center text-muted">
                    <i class="fa fa-check-circle"></i> Tidak ada pelanggaran hari ini
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer text-right">
        <small class="text-muted">Diperbarui: <?= date('H:i:s') ?></small>
      </div>
    </div>
  </div>
</div>

<script>
function refreshViolations() {
  $('#loading-overlay').show();
  $.ajax({
    url: '<?= site_url('manage/dashboard_set/get_today_violations_api') ?>',
    type: 'GET',
    success: function(response) {
      let data = JSON.parse(response);
      let html = '';
      
      if(data.length > 0) {
        data.forEach(function(violation) {
          html += `
            <tr>
              <td class="text-center">
                <span class="badge bg-red">
                  ${new Date(violation.tanggal).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}
                </span>
              </td>
              <td>${violation.student_full_name}</td>
              <td>${violation.jenis_pelanggaran}</td>
              <td class="text-center">
                <span class="badge bg-orange">
                  ${violation.poin}
                </span>
              </td>
              <td>${violation.keterangan || '-'}</td>
            </tr>
          `;
        });
      } else {
        html = `
          <tr>
            <td colspan="5" class="text-center text-muted">
              <i class="fa fa-check-circle"></i> Tidak ada pelanggaran hari ini
            </td>
          </tr>
        `;
      }
      
      $('table tbody').html(html);
      $('.box-footer small').text('Diperbarui: ' + new Date().toLocaleTimeString('id-ID'));
    },
    complete: function() {
      $('#loading-overlay').hide();
    }
  });
}

// Auto refresh setiap 1 menit
setInterval(refreshViolations, 60000);
</script>

<div class="col-md-12">
                    <div class="box box-danger" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                Top 10 Santri dengan Izin Pulang Terbanyak - Periode <?php echo $active_period['period_start'] . '/' . $active_period['period_end'] ?>
                            </h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="danger">
                                            <th width="30">Rank</th>
                                            <th>Nama Santri</th>
                                            <th>Alamat</th>
                                            <th>Kelas</th>
                                            <th>Total Izin</th>
                                            <th>Total Hari</th>
                                            <th>Keterlambatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($top_izin as $row): ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row['student_full_name'] ?></td>
                                                <td><?php echo $row['student_address'] ?></td>
                                                <td><?php echo $row['class_name'] ?></td>
                                                <td><span class="badge bg-blue"><?php echo $row['total_izin'] ?>x</span></td>
                                                <td><span class="badge bg-purple"><?php echo $row['total_hari'] ?> Hari</span></td>
                                                <td><span class="badge bg-red"><?php echo $row['total_telat'] ?>x</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <p class="text-muted text-sm">
                                    * Data dihitung berdasarkan total hari izin pulang dan status keterlambatan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

    <!-- Santri Sering Melanggar dan Grafik Pelanggaran -->
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Santri Sering Melanggar</h3>
          </div>
          <div class="box-body">
            <form method="GET" action="">
              <div class="form-group">
                <label for="month">Pilih Bulan:</label>
                <select name="month" id="month" class="form-control">
                  <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>"
                      <?php echo ($i == $selected_month) ? 'selected' : ''; ?>>
                      <?php echo date('F', mktime(0, 0, 0, $i, 1)); ?>
                    </option>
                  <?php endfor; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="year">Pilih Tahun:</label>
                <select name="year" id="year" class="form-control">
                  <?php for ($y = date('Y') - 5; $y <= date('Y'); $y++): ?>
                    <option value="<?php echo $y; ?>"
                      <?php echo ($y == $selected_year) ? 'selected' : ''; ?>>
                      <?php echo $y; ?>
                    </option>
                  <?php endfor; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Filter</button>
            </form>
            <br>
            <ul class="list-group">
              <?php foreach ($top_violators as $santri): ?>
                <li class="list-group-item">
                  <strong><?php echo $santri['student_full_name']; ?>:</strong>
                  <?php echo $santri['total_points']; ?> Pelanggaran
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Grafik Pelanggaran</h3>
          </div>
          <div class="box-body">
            <canvas id="violationsChart"></canvas>
          </div>
        </div>
      </div>

    </div>

    <!-- Distribusi Santri dan Ustadz -->
    <div class="row">
      <div class="col-md-6">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"><strong>Papan Informasi</strong></h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators ind">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <?php
                $i = 1;
                foreach ($information as $row):
                ?>
                  <div class="item <?php echo ($i == 1) ? 'active' : ''; ?>">
                    <div class="row">
                      <div class="adjust1 text-center">
                        <img src="<?php echo base_url('uploads/information/' . $row['information_img']); ?>" class="img-responsive carousel-img" alt="Information Image">
                        <br>
                        <div class="caption">
                          <p class="text-info lead adjust2"><?php echo $row['information_title'] ?></p>
                          <blockquote class="adjust2">
                            <p><?php echo strip_tags(character_limiter($row['information_desc'], 250)) ?></p>
                          </blockquote>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                  $i++;
                endforeach;
                ?>
              </div>
              <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" style="font-size:20px"></span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" style="font-size:20px"></span>
              </a>
            </div>
          </div>
        </div>
      </div>


      <!-- Kalender -->
      <div class="col-md-6">
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Kalender</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </div>



  </section>
</div>
<!-- Modals remain unchanged -->

<div class="modal fade in" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php echo form_open(current_url()); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="addModalLabel">Tambah Agenda</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="add" value="1">
        <label>Tanggal*</label>
        <p id="labelDate"></p>
        <input type="hidden" name="date" class="form-control" id="inputDate">
        <label>Keterangan*</label>
        <textarea name="info" id="inputDesc" class="form-control"></textarea><br />
      </div>
      <div class="modal-footer">
        <button type="submit" id="btnSimpan" class="btn btn-success">Simpan</button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php echo form_open(current_url()); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="delModalLabel">Hapus Hari Libur</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="del" value="1">
        <input type="hidden" name="id" id="idDel">
        <label>Tahun</label>
        <p id="showYear"></p>
        <label>Tanggal</label>
        <p id="showDate"></p>
        <label>Keterangan*</label>
        <p id="showDesc"></p>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Hapus</button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var ctxSantriInOut = document.getElementById("santriInOutChart").getContext("2d");

    var santriInOutChart = new Chart(ctxSantriInOut, {
      type: "bar",
      data: {
        labels: ["Santri Masuk", "Santri Keluar", "Selisih"],
        datasets: [{
          label: "Jumlah Santri",
          data: [
            <?php echo $santri_masuk_keluar['total_masuk']; ?>,
            <?php echo $santri_masuk_keluar['total_keluar']; ?>,
            <?php echo $santri_masuk_keluar['total_masuk'] - $santri_masuk_keluar['total_keluar']; ?>
          ],
          backgroundColor: [
            "#2ecc71", "#e74c3c", "#3498db"
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var ctxKomplek = document.getElementById("studentsByKomplekChart").getContext("2d");

    var komplekNames = [];
    var studentCounts = [];

    <?php foreach ($students_by_komplek as $row) : ?>
      komplekNames.push("<?php echo $row['komplek_name']; ?>");
      studentCounts.push(<?php echo $row['total_students']; ?>);
    <?php endforeach; ?>

    var studentsByKomplekChart = new Chart(ctxKomplek, {
      type: "bar",
      data: {
        labels: komplekNames,
        datasets: [{
          label: "Jumlah Santri per Komplek",
          data: studentCounts,
          backgroundColor: [
            "#2ecc71", "#e74c3c", "#3498db", "#f1c40f",
            "#9b59b6", "#e67e22", "#1abc9c", "#00bcd4"
          ],
          borderColor: "rgba(0, 0, 0, 0.1)",
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("studentsByClassChart").getContext("2d");

    var classNames = [];
    var studentCounts = [];

    <?php foreach ($students_by_class as $row) : ?>
      classNames.push("<?php echo $row['class_name']; ?>");
      studentCounts.push(<?php echo $row['total_students']; ?>);
    <?php endforeach; ?>

    var studentsByClassChart = new Chart(ctx, {
      type: "bar",
      data: {
        labels: classNames,
        datasets: [{
          label: "Jumlah Santri per Kelas",
          data: studentCounts,
          backgroundColor: [
            "#2ecc71", "#e74c3c", "#3498db", "#f1c40f",
            "#9b59b6", "#e67e22", "#1abc9c", "#00bcd4"
          ],
          borderColor: "rgba(0, 0, 0, 0.1)",
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var ctxMonthly = document.getElementById('monthlyHafalanChart').getContext('2d');
    var monthlyHafalanChart = new Chart(ctxMonthly, {
      type: 'bar',
      data: {
        labels: [<?php foreach ($monthly_hafalan as $row) echo "'Bulan " . $row['bulan'] . ",',"; ?>],
        datasets: [{
          label: 'Total Hafalan',
          data: [<?php foreach ($monthly_hafalan as $row) echo $row['total_hafalan'] . ","; ?>],
          backgroundColor: '#3498db'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    var ctxKhatam = document.getElementById('khatamChart').getContext('2d');
    var khatamChart = new Chart(ctxKhatam, {
      type: 'pie',
      data: {
        labels: ['Khatam', 'Belum Khatam'],
        datasets: [{
          data: [<?php echo $percent_khatam; ?>, <?php echo $percent_belum_khatam; ?>],
          backgroundColor: ['#2ecc71', '#e74c3c']
        }]
      },
      options: {
        responsive: true
      }
    });
  });
</script>
<script>
  var ctx = document.getElementById('financeChart').getContext('2d');
  var financeChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Penerimaan', 'Pengeluaran', 'Saldo Akhir'],
      datasets: [{
        label: 'Keuangan Hari Ini (Rp)',
        data: [
          <?php echo $total_bulan + $total_bebas + $total_debit; ?>,
          <?php echo $total_kredit; ?>,
          <?php echo ($total_bulan + $total_bebas + $total_debit) - $total_kredit; ?>
        ],
        backgroundColor: ['#2ecc71', '#e74c3c', '#3498db'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script>
  var ctxSantri = document.getElementById('santriChart').getContext('2d');
  var santriChart = new Chart(ctxSantri, {
    type: 'doughnut',
    data: {
      labels: ['Santri Aktif', 'Ustadz Aktif', 'Total Pengurus'],
      datasets: [{
        data: [
          <?php echo $student; ?>,
          <?php echo $total_ustadz; ?>,
          <?php echo $total_active_pengurus; ?> // Misalnya pengurus juga diambil dari jumlah ustadz
        ],
        backgroundColor: ['#f39c12', '#8e44ad', '#1abc9c']
      }]
    },
    options: {
      responsive: true
    }
  });
</script>

<script>
  var ctxViolations = document.getElementById('violationsChart').getContext('2d');
  var violationsChart = new Chart(ctxViolations, {
    type: 'bar',
    data: {
      labels: [<?php foreach ($top_violators as $row) echo "'" . $row['student_full_name'] . "',"; ?>],
      datasets: [{
        label: 'Total Pelanggaran',
        data: [<?php foreach ($top_violators as $row) echo $row['total_points'] . ","; ?>],
        backgroundColor: '#e74c3c'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
<script type="text/javascript">
  $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'prevYear,nextYear',
    },

    events: "<?php echo site_url('manage/dashboard/get'); ?>",

    dayClick: function(date, jsEvent, view) {

      var tanggal = date.getDate();
      var bulan = date.getMonth() + 1;
      var tahun = date.getFullYear();
      var fullDate = tahun + '-' + bulan + '-' + tanggal;

      $('#addModal').modal('toggle');
      $('#addModal').modal('show');

      $("#inputDate").val(fullDate);
      $("#labelDate").text(fullDate);
      $("#inputYear").val(date.getFullYear());
      $("#labelYear").text(date.getFullYear());
    },

    eventClick: function(calEvent, jsEvent, view) {
      $("#delModal").modal('toggle');
      $("#delModal").modal('show');
      $("#idDel").val(calEvent.id);
      $("#showYear").text(calEvent.year);

      var tgl = calEvent.start.getDate();
      var bln = calEvent.start.getMonth() + 1;
      var thn = calEvent.start.getFullYear();

      $("#showDate").text(tgl + '-' + bln + '-' + thn);
      $("#showDesc").text(calEvent.title);
    }


  });

  $("#inputDesc").on('change keyup focus input propertychange', function() {
    var desc = $("#inputDesc").val();
    if (desc.trim().length > 0) {
      $("#btnSimpan").removeClass('disabled');
    } else {
      $("#btnSimpan").addClass('disabled');
    }
  })

  $("#closeModal").click(function() {
    $("#inputDesc").val('');
    $("#btnSimpan").addClass('disabled');
  });
</script>