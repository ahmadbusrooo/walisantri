<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo isset($title) ? '' . $title : null; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url('manage') ?>"><i class="fa fa-th"></i> Home</a></li>
      <li class="active"><?php echo isset($title) ? '' . $title : null; ?></li>
    </ol>
  </section>
  <section class="content">
    <div class="col-md-6">

      <?php echo form_open_multipart(current_url()); ?>
      <div class="box-body">

        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Tingkat Pondok</label>
              <select name="setting_level" class="form-control">
                <option value="senior" <?php echo ($setting_level['setting_value'] == 'senior') ? 'selected' : '' ?>>SPM AL MA'RUF</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nama Pondok</label>
              <input type="text" name="setting_school" value="<?php echo $setting_school['setting_value'] ?>" class="form-control" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Alamat Pondok</label>
              <input name="setting_address" type="text" value="<?php echo $setting_address['setting_value'] ?>" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nama Kecamatan</label>
              <input type="text" name="setting_district" value="<?php echo $setting_district['setting_value'] ?>" class="form-control" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nama Kota/Kab</label>
              <input type="text" name="setting_city" value="<?php echo $setting_city['setting_value'] ?>" class="form-control" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="">
            <div class="form-group label-floating">
              <label class="control-label">Nomor Telepon</label>
              <input type="text" name="setting_phone" value="<?php echo $setting_phone['setting_value'] ?>" class="form-control" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="">
            <input type="submit" value="Simpan" class="btn btn-success pull-left">
          </div>
        </div>

      </div>
    </div>
    <br>
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-3">
          <label >Logo Pondok</label>
          <a href="#" class="thumbnail">
            <?php if (isset($setting_logo) AND $setting_logo['setting_value'] != NULL) { ?>
            <img src="<?php echo upload_url('school/' . $setting_logo['setting_value']) ?>" style="height: 50px" >
            <?php } else { ?>
            <img src="<?php echo media_url('img/missing_logo.gif') ?>" id="target" alt="Choose image to upload">
            <?php } ?>
          </a>
          <input type='file' id="setting_logo" name="setting_logo">
          <p>Ukuran Logo 50x50 pixel</p>
        </div>
      </div>
      <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#gateway"><i class="fa fa-arrow-down"></i> Set WA Gateway</button>
      <div id="gateway" class="collapse">
        <div class="form-group label-floating">
          <label class="control-label">Url WA Gateway</label>
          <input type="text" name="setting_wa_gateway_url" value="<?php echo $setting_wa_gateway_url['setting_value'] ?>" class="form-control" required>
        </div>
        <div class="form-group label-floating">
          <label class="control-label">Token WA Gateway</label>
          <input type="password" name="setting_wa_api_key" value="<?php echo $setting_wa_api_key['setting_value'] ?>" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Aktifkan WA Gateway</label>
          <div class="radio">
            <label>
              <input type="radio" name="setting_sms" value="Y" <?php echo ($setting_sms['setting_value'] == 'Y') ? 'checked' : ''; ?>> Ya
            </label>&nbsp;&nbsp;
            <label>
              <input type="radio" name="setting_sms" value="N" <?php echo ($setting_sms['setting_value'] == 'N') ? 'checked' : ''; ?>> Tidak
            </label>
          </div>
        </div>
      </div>
    </div>
    <?php echo form_close() ?>
  </section>
</div>

<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#target').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#setting_logo").change(function() {
    readURL(this);
  });

</script>
