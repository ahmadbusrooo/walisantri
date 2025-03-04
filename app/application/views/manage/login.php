<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PP AL MA'RUF - Login</title>

  <link rel="icon" type="image/png" href="<?php echo media_url('img/logopondok.png') ?>">
  <link href="<?php echo media_url() ?>css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?php echo media_url() ?>css/font-awesome.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #206d25, #4caf50);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      padding: 20px;
    }
    .container {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      overflow: hidden;
      max-width: 900px;
      width: 100%;
      display: flex;
      flex-direction: column;
    }
    @media (min-width: 768px) {
      .container {
        flex-direction: row;
      }
    }
    .logo-section {
      background: #206d25;
      color: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 20px;
      text-align: center;
    }
    .logo-section img {
      max-width: 120px;
      margin-bottom: 20px;
    }
    .logo-section p {
      margin: 5px 0;
      font-size: 18px;
    }
    .login-section {
      padding: 30px;
      width: 100%;
    }
    .title-login {
      font-size: 24px;
      font-weight: bold;
      color: #206d25;
      margin-bottom: 20px;
      text-align: center;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-control {
      border-radius: 30px;
      padding: 10px 15px;
      border: 1px solid #ddd;
    }
    .form-control:focus {
      border-color: #206d25;
      box-shadow: 0 0 5px rgba(32, 109, 37, 0.5);
    }
    .btn-login {
      background: #206d25;
      color: #fff;
      border: none;
      border-radius: 30px;
      padding: 10px 20px;
      font-size: 16px;
      width: 100%;
      transition: background 0.3s ease;
    }
    .btn-login:hover {
      background: #4caf50;
    }
    .alert {
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo-section">
      <?php if (isset($setting_logo) AND $setting_logo['setting_value'] == NULL) { ?>
        <img src="<?php echo media_url('img/logopondok.png') ?>" alt="Logo">
      <?php } else { ?>
        <img src="<?php echo upload_url('school/' . $setting_logo['setting_value']) ?>" alt="Logo">
      <?php } ?>
      <p><strong>SISTEM INFORMASI</strong></p>
      <?php if (isset($setting_school) AND $setting_school['setting_value'] == '-') { ?>
        <p>Pondok Pesantren Al Ma'ruf</p>
      <?php } else { ?>
        <p><?php echo $setting_school['setting_value'] ?></p>
      <?php } ?>
    </div>
    <div class="login-section">
      <?php echo form_open('manage/auth/login', array('class'=>'login100-form validate-form')); ?>
        <p class="title-login">Login Pengurus</p>
        <?php if ($this->session->flashdata('failed')) { ?>
          <div class="alert alert-danger">
            <h5><i class="fa fa-close"></i> Email atau Password salah!</h5>
          </div>
        <?php } ?>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" required autofocus>
        </div>
        <style>
/* Tambahkan CSS ini */
.password-wrapper {
  position: relative;
  width: 100%;
}

.toggle-password {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #666;
  z-index: 2;
  background: white;
  padding: 5px;
  height: 20px;
  width: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
}

.toggle-password:hover {
  color: #206d25;
  background: #f0f0f0;
}

#password {
  padding-right: 45px !important;
}
</style>

<!-- Perbaiki bagian password input -->
<div class="form-group">
  <label for="password">Password</label>
  <div class="password-wrapper">
    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
    <i class="fa fa-eye toggle-password" onclick="togglePassword()"></i>
  </div>
</div>
        <button type="submit" class="btn btn-login">Login</button>
      <?php echo form_close(); ?>
    </div>
  </div>
  <script>
    function togglePassword() {
      var passwordInput = document.getElementById("password");
      var icon = document.querySelector(".toggle-password");
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>
</body>
</html>