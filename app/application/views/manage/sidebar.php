<!-- Left side column. contains the logo and sidebar -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
  .user-panel .image img {
    border-radius: 50%;
  }
</style>

<aside class="main-sidebar">
  <section class="sidebar">
    <!-- User Panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <?php if ($this->session->userdata('user_image')) { ?>
          <img src="<?= upload_url('users/' . $this->session->userdata('user_image')) ?>" class="img-responsive">
        <?php } else { ?>
          <img src="<?= media_url('img/avatar1.png') ?>" class="img-responsive">
        <?php } ?>
      </div>
      <div class="pull-left info">
        <p><?= ucfirst($this->session->userdata('ufullname')) ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <!-- Menu Items -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU UTAMA</li>

      <!-- Dashboard -->
      <li class="<?= ($this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == '') ? 'active' : '' ?>">
        <a href="<?= site_url('manage') ?>">
          <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
        </a>
      </li>

      <?php 
// Cek apakah user BUKAN SUPERUSER dan BUKAN SEKRETARIS
if ($this->session->userdata('uroleid') != SUPERUSER && $this->session->userdata('uroleid') != SEKRETARIS) { 
?>
    <li class="<?= ($this->uri->segment(2) == 'student' && $this->uri->segment(3) == 'view_only') ? 'active' : '' ?>">
        <a href="<?= site_url('manage/student/view_only') ?>">
            <i class="fas fa-users"></i> <span>Data Santri</span>
        </a>
    </li>
<?php } ?>
      <!-- Sekretaris -->
      <?php if ($this->session->userdata('uroleid') == SEKRETARIS || $this->session->userdata('uroleid') == SUPERUSER) { ?>

        <li class="treeview <?= (in_array($this->uri->segment(2), [
                              'class',
                              'majors',
                              'period',
                              'information',
                              'setting',
                              'month',
                              'users',
                              'maintenance',
                              'student_print',
                              'student'
                            ]) || in_array($this->uri->segment(1), [
                              'ustadz',
                              'pengurus',
                              'komplek'
                            ])) ? 'active menu-open' : '' ?>">
          <a href="#">
            <i class="fas fa-user-secret"></i> <span>Sekretaris</span>
            <span class="pull-right-container">
              <i class="fas fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?= ($this->uri->segment(2) == 'period') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/period') ?>"><i class="fas fa-calendar-alt"></i> Tahun Pelajaran</a>
            </li>
            <li class="<?= ($this->uri->segment(1) == 'komplek') ? 'active' : '' ?>">
              <a href="<?= site_url('komplek') ?>"><i class="fas fa-building"></i> Data Komplek</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'majors') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/majors') ?>"><i class="fas fa-bed"></i> Kamar</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'class') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/class') ?>"><i class="fas fa-chalkboard-teacher"></i> Kelas</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'student' && $this->uri->segment(3) == '') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/student') ?>"><i class="fas fa-user-graduate"></i> Santri</a>
            </li>
            <li class="<?= ($this->uri->segment(1) == 'ustadz') ? 'active' : '' ?>">
              <a href="<?= site_url('ustadz') ?>"><i class="fas fa-user-tie"></i> Ustadz</a>
            </li>
            <li class="<?= ($this->uri->segment(1) == 'pengurus') ? 'active' : '' ?>">
              <a href="<?= site_url('pengurus') ?>"><i class="fas fa-users-cog"></i> Pengurus</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'information') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/information') ?>"><i class="fas fa-bullhorn"></i> Informasi</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'month') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/month') ?>"><i class="fas fa-calendar-week"></i> Bulan</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'setting') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/setting') ?>"><i class="fas fa-cogs"></i> Pengaturan</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'users') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/users') ?>"><i class="fas fa-user-shield"></i> Manajemen Pengguna</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'maintenance') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/maintenance') ?>"><i class="fas fa-database"></i> Backup Data</a>
            </li>
            <li class="<?= ($this->uri->segment(3) == 'report') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/student/report') ?>"><i class="fas fa-file-pdf"></i> Laporan Santri</a>
            </li>
            <li class="<?= ($this->uri->segment(3) == 'monitoring') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/student/monitoring') ?>"><i class="fas fa-clipboard-check"></i> Monitoring</a>
            </li>
          </ul>
        </li>
      <?php } ?>

      <!-- Bendahara -->
      <?php if ($this->session->userdata('uroleid') == BENDAHARA || $this->session->userdata('uroleid') == SUPERUSER) { ?>

        <li class="treeview <?= (in_array($this->uri->segment(2), ['payout', 'pos', 'payment', 'kredit', 'debit', 'report']) ? 'active menu-open' : '') ?>">
          <a href="#">
            <i class="fas fa-cash-register"></i> <span>Bendahara</span>
            <span class="pull-right-container">
              <i class="fas fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?= ($this->uri->segment(2) == 'payout') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/payout') ?>"><i class="fas fa-hand-holding-usd"></i> Pembayaran Santri</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'pos') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/pos') ?>"><i class="fas fa-receipt"></i> Pos Keuangan</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'payment') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/payment') ?>"><i class="fas fa-money-check-alt"></i> Jenis Pembayaran</a>
            </li>
            <li class="treeview <?= (in_array($this->uri->segment(2), ['kredit', 'debit'])) ? 'active menu-open' : '' ?>">
              <a href="#"><i class="fas fa-exchange-alt"></i> Transaksi
                <span class="pull-right-container">
                  <i class="fas fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?= ($this->uri->segment(2) == 'debit') ? 'active' : '' ?>">
                  <a href="<?= site_url('manage/debit') ?>"><i class="fas fa-arrow-circle-down text-success"></i> Pemasukan</a>
                </li>
                <li class="<?= ($this->uri->segment(2) == 'kredit') ? 'active' : '' ?>">
                  <a href="<?= site_url('manage/kredit') ?>"><i class="fas fa-arrow-circle-up text-danger"></i> Pengeluaran</a>
                </li>
              </ul>
            </li>
            <li class="treeview <?= ($this->uri->segment(2) == 'report') ? 'active menu-open' : '' ?>">
              <a href="#"><i class="fas fa-file-invoice-dollar"></i> Laporan
                <span class="pull-right-container">
                  <i class="fas fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?= ($this->uri->segment(3) == 'report_bill') ? 'active' : '' ?>">
                  <a href="<?= site_url('manage/report/report_bill') ?>"><i class="fas fa-file-contract"></i> Rekapitulasi</a>
                </li>
                <li class="<?= ($this->uri->segment(2) == 'report') ? 'active' : '' ?>">
                  <a href="<?= site_url('manage/report') ?>"><i class="fas fa-chart-line"></i> Laporan Keuangan</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      <?php } ?>

      <!-- M3 -->
      <?php if ($this->session->userdata('uroleid') == M3 || $this->session->userdata('uroleid') == SUPERUSER) { ?>
        <li class="treeview <?= (in_array($this->uri->segment(1), ['nadzhaman', 'kitab', 'pelanggaran']) || in_array($this->uri->segment(3), ['pass', 'upgrade']) ? 'active menu-open' : '') ?>">
          <a href="#">
            <i class="fas fa-book-open"></i> <span>M3</span>
            <span class="pull-right-container">
              <i class="fas fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?= ($this->uri->segment(1) == 'kitab') ? 'active' : '' ?>">
              <a href="<?= site_url('kitab') ?>"><i class="fas fa-quran"></i> Data Kitab</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'absen_mengaji') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/absen_mengaji') ?>"><i class="fas fa-times-circle"></i> Pelanggaran Mengaji</a>
            </li>
            <li class="treeview <?= ($this->uri->segment(1) == 'nadzhaman') ? 'active menu-open' : '' ?>">
              <a href="#"><i class="fas fa-book-reader"></i> Hafalan
                <span class="pull-right-container">
                  <i class="fas fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?= ($this->uri->segment(2) == 'filter_nadzhaman') ? 'active' : '' ?>">
                  <a href="<?= site_url('nadzhaman/filter_nadzhaman') ?>"><i class="fas fa-plus-circle"></i> Tambah Hafalan</a>
                </li>
                <li class="<?= ($this->uri->segment(2) == 'manage_kitab_class') ? 'active' : '' ?>">
                  <a href="<?= site_url('nadzhaman/manage_kitab_class') ?>"><i class="fas fa-tasks"></i> Set Kitab per Kelas</a>
                </li>
              </ul>
            </li>
            <li class="treeview <?= (in_array($this->uri->segment(3), ['pass', 'upgrade'])) ? 'active menu-open' : '' ?>">
              <a href="#"><i class="fas fa-chalkboard"></i> Kelas
                <span class="pull-right-container">
                  <i class="fas fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="<?= ($this->uri->segment(3) == 'pass') ? 'active' : '' ?>">
                  <a href="<?= site_url('manage/student/pass') ?>"><i class="fas fa-graduation-cap"></i> Kelulusan</a>
                </li>
                <li class="<?= ($this->uri->segment(3) == 'upgrade') ? 'active' : '' ?>">
                  <a href="<?= site_url('manage/student/upgrade') ?>"><i class="fas fa-level-up-alt"></i> Kenaikan Kelas</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      <?php } ?>


      <!-- Pendidikan -->
      <?php if ($this->session->userdata('uroleid') == PENDIDIKAN || $this->session->userdata('uroleid') == SUPERUSER) { ?>
        <li class="treeview <?= (in_array($this->uri->segment(2), ['juzz', 'absen_setoran']) ||
                              $this->uri->segment(3) == 'kenaikan_juz') ? 'active menu-open' : '' ?>">
          <a href="#">
            <i class="fas fa-graduation-cap"></i> <span>Pendidikan</span>
            <span class="pull-right-container">
              <i class="fas fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?= ($this->uri->segment(2) == 'juzz') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/juzz') ?>"><i class="fas fa-bookmark"></i> Manajemen Juz</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'absen_setoran') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/absen_setoran') ?>"><i class="fas fa-user-times"></i> Pelanggaran Setoran</a>
            </li>
            <li class="<?= ($this->uri->segment(3) == 'kenaikan_juz') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/student/kenaikan_juz') ?>"><i class="fas fa-step-forward"></i> Kenaikan Juz</a>
            </li>
          </ul>
        </li>
      <?php } ?>

      <!-- Keamanan -->
      <?php if ($this->session->userdata('uroleid') == KEAMANAN || $this->session->userdata('uroleid') == SUPERUSER) { ?>

        <li class="treeview <?= (in_array($this->uri->segment(2), ['pelanggaran', 'absen_jamaah', 'izin_pulang'])) ? 'active menu-open' : '' ?>">
          <a href="#">
            <i class="fas fa-shield-alt"></i> <span>Keamanan</span>
            <span class="pull-right-container">
              <i class="fas fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?= ($this->uri->segment(2) == 'pelanggaran') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/pelanggaran') ?>"><i class="fas fa-exclamation-triangle"></i> Pelanggaran Harian</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'absen_jamaah') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/absen_jamaah') ?>"><i class="fas fa-calendar-times"></i> Absen Jama'ah</a>
            </li>
            <li class="<?= ($this->uri->segment(2) == 'izin_pulang') ? 'active' : '' ?>">
              <a href="<?= site_url('manage/izin_pulang') ?>"><i class="fas fa-home"></i> Izin Pulang</a>
            </li>
          </ul>
        </li>
      <?php } ?>

      <!-- Kesehatan -->
      <?php if ($this->session->userdata('uroleid') == KESEHATAN || $this->session->userdata('uroleid') == SUPERUSER) { ?>
        <li class="<?= ($this->uri->segment(1) == 'health') ? 'active' : '' ?>">
          <a href="<?= site_url('health') ?>">
            <i class="fas fa-heartbeat"></i> <span>Kesehatan</span>
          </a>
        </li>
      <?php } ?>
    </ul>
  </section>
</aside>