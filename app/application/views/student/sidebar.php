<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <?php if ($this->session->userdata('student_img') != null) { ?>
        <img src="<?php echo upload_url().'/student/'.$this->session->userdata('student_img'); ?>" class="img-responsive">
        <?php } else { ?>
        <img src="<?php echo media_url() ?>img/user.png" class="img-responsive">
        <?php } ?>
      </div>
      <div class="pull-left info">
        <p><?php echo ucfirst($this->session->userdata('ufullname_student')); ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>

    <div style="margin-top: 20px"></div>
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU</li>

      <!-- Menu Dashboard -->
      <li class="<?php echo ($this->uri->segment(1) == 'student' && ($this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == NULL)) ? 'active' : '' ?>">
        <a href="<?php echo site_url('student'); ?>">
          <i class="fa fa-th"></i> <span>Dashboard</span>
        </a>
      </li>

      <!-- Menu Pelanggaran -->
      <li class="<?php echo ($this->uri->segment(1) == 'pelanggaran_student') ? 'active' : '' ?>">
        <a href="<?php echo site_url('pelanggaran_student'); ?>">
          <i class="fa fa-exclamation-circle"></i> <span>Pelanggaran</span>
        </a>
      </li>

      <!-- Menu Cek Pembayaran -->
      <li class="<?php echo ($this->uri->segment(1) == 'student/payout') ? 'active' : '' ?>">
        <a href="<?php echo site_url('student/payout'); ?>">
          <i class="fa fa-money"></i> <span>Cek Pembayaran</span>
        </a>
      </li>


      <li class="<?php echo ($this->uri->segment(1) == 'health_student') ? 'active' : ''; ?>">
    <a href="<?php echo site_url('health_student'); ?>">
        <i class="fa fa-heartbeat"></i> <span>Riwayat Kesehatan</span>
    </a>
</li>

<li class="<?php echo ($this->uri->segment(1) == 'nadzhaman_student') ? 'active' : ''; ?>">
    <a href="<?php echo site_url('nadzhaman_student'); ?>">
        <i class="fa fa-book"></i> <span>Riwayat Nadzhaman</span>
    </a>
</li>



    </ul>
  </section>
</aside>
