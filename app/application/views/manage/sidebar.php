<!-- Left side column. contains the logo and sidebar -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
   .user-panel .image img {
    border-radius: 50%; /* Circular user image */
  }

</style>
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <?php if ($this->session->userdata('user_image') != null) { ?>
          <img src="<?php echo upload_url().'/users/'.$this->session->userdata('user_image'); ?>" class="img-responsive">
        <?php } else { ?>
          <img src="<?php echo media_url() ?>img/avatar1.png" class="img-responsive">
        <?php } ?>
      </div>
      <div class="pull-left info">
        <p><?php echo ucfirst($this->session->userdata('ufullname')); ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <div style="margin-top: 20px"></div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU</li>

      <!-- Dashboard -->
      <li class="<?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'active' : '' ?>">
        <a href="<?php echo site_url('manage'); ?>">
          <i class="fa fa-tachometer-alt"></i> <span>Dashboard</span>
        </a>
      </li>

<!-- Sekretaris -->
<li class="treeview <?php echo (in_array($this->uri->segment(2), ['class', 'majors', 'period', 'information', 'setting', 'month', 'users', 'maintenance', 'student_print','student/report','student/monitoring']) || 
        ($this->uri->segment(2) == 'student' && $this->uri->segment(3) == '') || 
        in_array($this->uri->segment(1), ['ustadz', 'pengurus', 'komplek'])) ? 'active' : ''; ?>">
  <a href="#">
    <i class="fa fa-cogs"></i> <span>Sekretaris</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="<?php echo ($this->uri->segment(2) == 'period') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/period'); ?>"><i class="fa fa-calendar-alt"></i> Tahun Pelajaran</a>
    </li>
    <li class="<?php echo ($this->uri->segment(1) == 'komplek') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('komplek'); ?>"><i class="fa fa-building"></i> Data Komplek</a>
    </li>
    <li class="<?php echo ($this->uri->segment(2) == 'majors') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/majors'); ?>"><i class="fa fa-home"></i> Kamar</a>
    </li>
    <li class="<?php echo ($this->uri->segment(2) == 'class' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/class'); ?>"><i class="fa fa-chalkboard-teacher"></i> Kelas</a>
    </li>
    <li class="<?php echo ($this->uri->segment(2) == 'student' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/student'); ?>"><i class="fa fa-user-graduate"></i> Santri</a>
    </li>
    <li class="<?php echo ($this->uri->segment(1) == 'ustadz') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('ustadz'); ?>"><i class="fa fa-user-tie"></i> Ustadz</a>
    </li>
    <li class="<?php echo ($this->uri->segment(1) == 'pengurus') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('pengurus'); ?>"><i class="fa fa-users"></i> Pengurus</a>
    </li>
    <li class="<?php echo ($this->uri->segment(2) == 'information') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/information'); ?>"><i class="fa fa-bullhorn"></i> Informasi</a>
    </li>
    <li class="<?php echo ($this->uri->segment(2) == 'setting') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/setting'); ?>"><i class="fa fa-cog"></i> Pengaturan</a>
    </li>
    <li class="<?php echo ($this->uri->segment(2) == 'month') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/month'); ?>">
          <i class="fa fa-calendar-alt"></i> Bulan
      </a>
    </li>
    <li class="<?php echo ($this->uri->segment(2) == 'users') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/users'); ?>"><i class="fa fa-users-cog"></i> Manajemen Pengguna</a>
    </li>
    <li class="<?php echo ($this->uri->segment(2) == 'maintenance') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/maintenance'); ?>"><i class="fa fa-database"></i> Backup Data</a>
    </li>
    <li class="<?php echo ($this->uri->segment(2) == 'report') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/student/report'); ?>"><i class="fa fa-print"></i> Laporan Data Santri</a>
    </li>
    <li class="<?php echo ($this->uri->segment(3) == 'monitoring') ? 'active' : ''; ?>">
          <a href="<?php echo site_url('manage/student/monitoring'); ?>">
            <i class="fa fa-clipboard-check"></i> Monitoring Kelengkapan
          </a>
        </li>
  </ul>
</li>




      <!-- Bendahara -->
<?php if ($this->session->userdata('uroleid') == SUPERUSER) { ?>
<li class="treeview <?php echo in_array($this->uri->segment(2), ['payout', 'pos', 'payment', 'kredit', 'debit', 'report']) || $this->uri->segment(3) == 'report_bill' ? 'active' : ''; ?>">
    <a href="#">
        <i class="fa fa-wallet"></i> <span>Bendahara</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="<?php echo ($this->uri->segment(2) == 'payout') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('manage/payout'); ?>"><i class="fa fa-credit-card"></i> Pembayaran Santri</a>
        </li>
        <li class="<?php echo ($this->uri->segment(2) == 'pos') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('manage/pos'); ?>"><i class="fa fa-money-check-alt"></i> Pos Keuangan</a>
        </li>
        <li class="<?php echo ($this->uri->segment(2) == 'payment') ? 'active' : ''; ?>">
            <a href="<?php echo site_url('manage/payment'); ?>"><i class="fa fa-money-bill-wave"></i> Jenis Pembayaran</a>
        </li>
        <li class="treeview <?php echo in_array($this->uri->segment(2), ['kredit', 'debit']) ? 'active' : ''; ?>">
            <a href="#">
                <i class="fa fa-exchange-alt"></i> <span>Pemasukan/Pengeluaran</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="<?php echo ($this->uri->segment(2) == 'kredit') ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('manage/kredit'); ?>"><i class="fa fa-arrow-down"></i> Pengeluaran</a>
                </li>
                <li class="<?php echo ($this->uri->segment(2) == 'debit') ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('manage/debit'); ?>"><i class="fa fa-arrow-up"></i> Pemasukan</a>
                </li>
            </ul>
        </li>
        <li class="treeview <?php echo ($this->uri->segment(2) == 'report' || $this->uri->segment(3) == 'report_bill') ? 'active' : ''; ?>">
            <a href="#">
                <i class="fa fa-file-alt"></i> <span>Laporan</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="<?php echo ($this->uri->segment(2) == 'report' && $this->uri->segment(3) != 'report_bill') ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('manage/report'); ?>"><i class="fa fa-file-invoice-dollar"></i> Laporan Keuangan</a>
                </li>
                <li class="<?php echo ($this->uri->segment(3) == 'report_bill') ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('manage/report/report_bill'); ?>"><i class="fa fa-file-invoice"></i> Rekapitulasi</a>
                </li>
            </ul>
        </li>
    </ul>
</li>
<?php } ?>

<!-- Pendidikan -->
<li class="treeview <?php echo ($this->uri->segment(1) == ['nadzhaman', 'kitab', 'pelanggaran']|| ($this->uri->segment(2) == 'student' && in_array($this->uri->segment(3), ['pass', 'upgrade']))) ? 'active' : ''; ?>">
    <a href="#">
        <i class="fa fa-graduation-cap"></i> <span>Pendidikan</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    
    <ul class="treeview-menu">
    <li class="<?php echo ($this->uri->segment(1) == 'kitab') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('kitab'); ?>"><i class="fa fa-book"></i> Data Kitab</a>
    </li>
    <li class="<?php echo ($this->uri->segment(1) == 'pelanggaran') ? 'active' : ''; ?>">
      <a href="<?php echo site_url('manage/absen_mengaji'); ?>"><i class="fa fa-exclamation-triangle"></i> Pelanggaran</a>
    </li>
        <!-- Nadzhaman -->
        <li class="treeview <?php echo ($this->uri->segment(1) == 'nadzhaman') ? 'active' : ''; ?>">
            <a href="#">
                <i class="fa fa-book"></i> <span>Hafalan</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="<?php echo ($this->uri->segment(1) == 'nadzhaman' && $this->uri->segment(2) == '') ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('nadzhaman'); ?>">
                        <i class="fa fa-folder-open"></i> Cek Hafalan Santri
                    </a>
                </li>
                <li class="<?php echo ($this->uri->segment(2) == 'manage_kitab_class') ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('nadzhaman/manage_kitab_class'); ?>">
                        <i class="fa fa-book-reader"></i> Seting Kitab per Kelas
                    </a>
                </li>
                <li class="<?php echo ($this->uri->segment(2) == 'filter_nadzhaman') ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('nadzhaman/filter_nadzhaman'); ?>">
                        <i class="fa fa-filter"></i> Tambah Hafalan Santri
                    </a>
                </li>
            </ul>
        </li>

        <!-- Kelas -->
        <li class="treeview <?php echo ($this->uri->segment(2) == 'student' && in_array($this->uri->segment(3), ['pass', 'upgrade'])) ? 'active' : ''; ?>">
            <a href="#">
                <i class="fa fa-chalkboard-teacher"></i> <span>Kelas</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="<?php echo ($this->uri->segment(3) == 'pass') ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('manage/student/pass'); ?>">
                        <i class="fa fa-check-circle"></i> Kelulusan
                    </a>
                </li>
                <li class="<?php echo ($this->uri->segment(3) == 'upgrade') ? 'active' : ''; ?>">
                    <a href="<?php echo site_url('manage/student/upgrade'); ?>">
                        <i class="fa fa-level-up-alt"></i> Kenaikan Kelas
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</li>

      <!-- Keamanan -->
      <li class="treeview <?php echo in_array($this->uri->segment(2), ['pelanggaran', 'izin_pulang']) ? 'active' : '' ?>">
        <a href="#">
          <i class="fa fa-shield-alt"></i> <span>Keamanan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?php echo ($this->uri->segment(2) == 'pelanggaran') ? 'active' : '' ?>">
            <a href="<?php echo site_url('manage/pelanggaran'); ?>"><i class="fa fa-exclamation-triangle"></i> Pelanggaran</a>
          </li>
          <li class="<?php echo ($this->uri->segment(2) == 'izin_pulang') ? 'active' : '' ?>">
            <a href="<?php echo site_url('manage/izin_pulang'); ?>"><i class="fa fa-calendar-check"></i> Izin Pulang</a>
          </li>
        </ul>
      </li>

      <!-- Kesehatan -->
      <li class="<?php echo ($this->uri->segment(1) == 'health') ? 'active' : '' ?>">
        <a href="<?php echo site_url('health'); ?>">
          <i class="fa fa-heartbeat"></i> <span>Kesehatan</span>
        </a>
      </li>

    </ul>
  </section>
</aside>