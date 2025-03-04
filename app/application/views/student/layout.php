<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->config->item('app_name') ?> <?php echo isset($title) ? ' | ' . $title : null; ?></title>
  <link rel="icon" type="image/png" href="<?php echo media_url('img/logo.png') ?>">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo media_url() ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>/css/style.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>/css/load-font-googleapis.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>css/jquery.notyfy.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>/css/skin-purple-light.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo media_url() ?>/css/daterangepicker.css">
  <link href="<?php echo base_url('/media/js/fullcalendar/fullcalendar.css');?>" rel="stylesheet">
  <script src="<?php echo media_url() ?>/js/jquery.min.js"></script>
  <script src="<?php echo media_url() ?>/js/angular.min.js"></script>
  <script src="<?php echo media_url() ?>/js/jquery-ui.min.js"></script>
  <script src="<?php echo media_url() ?>/js/jquery.inputmask.bundle.js"></script>
  <script src="<?php echo base_url('/media/js/fullcalendar/fullcalendar.js');?>"></script>
</head>
<body class="hold-transition skin-purple-light fixed sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
             WALI SANTRI PPAM
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php if ($this->session->userdata('student_img')) { ?>
                <img src="<?php echo upload_url().'/student/'.$this->session->userdata('student_img'); ?>" class="user-image">
                <?php } else { ?>
                <img src="<?php echo media_url() ?>img/user.png" class="user-image">
                <?php } ?>
                <span class="hidden-xs"><?php echo ucfirst($this->session->userdata('ufullname_student')); ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <?php if ($this->session->userdata('student_img')) { ?>
                  <img src="<?php echo upload_url().'/student/'.$this->session->userdata('student_img'); ?>" class="img-circle">
                  <?php } else { ?>
                  <img src="<?php echo media_url() ?>img/user.png" class="img-circle">
                  <?php } ?>
                  <p>
                    <?php echo ucfirst($this->session->userdata('ufullname_student')); ?>
                    <small><?php echo $this->session->userdata('unis_student'); ?></small>
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="<?php echo site_url('student/profile') ?>" class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="<?php echo site_url('student/auth/logout?location=' . htmlspecialchars($_SERVER['REQUEST_URI'])) ?>" class="btn btn-default btn-flat">Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <?php if ($this->session->userdata('student_img')) { ?>
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
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MENU</li>
          <li class="<?php echo ($this->uri->segment(1) == 'student' && ($this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == NULL)) ? 'active' : '' ?>">
            <a href="<?php echo site_url('student'); ?>">
              <i class="fa fa-th"></i> <span>Dashboard</span>
            </a>
          </li>
          <li class="<?php echo ($this->uri->segment(1) == 'pelanggaran_student') ? 'active' : '' ?>">
            <a href="<?php echo site_url('pelanggaran_student'); ?>">
              <i class="fa fa-exclamation-circle"></i> <span>Pelanggaran</span>
            </a>
          </li>
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

    <?php isset($main) ? $this->load->view($main) : null; ?>

    <footer class="main-footer hidden-xs">
      <div class="pull-right hidden-xs">
        <?php echo $this->config->item('app_name').' '.$this->config->item('version') ?>
      </div>
      <p class="hidden-xs"><?php echo $this->config->item('created') ?></p>
    </footer>

    <script src="<?php echo media_url() ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo media_url() ?>/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo media_url() ?>/js/adminlte.min.js"></script>
    <script src="<?php echo media_url() ?>/js/jquery.notyfy.js"></script>
    <script>
      $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
    </script>
  </div>
</body>
</html>
