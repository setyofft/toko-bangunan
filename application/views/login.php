<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Sistem Inventori Barang</title>
    <base href="<?php echo base_url() ?>">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="shortcut icon" href="favicon_16.ico"/>
    <link rel="bookmark" href="favicon_16.ico"/>
    <!-- site css -->
    <link rel="stylesheet" href="assets/dist/css/site.min.css">

    <script type="text/javascript" src="assets/dist/js/site.min.js"></script>
    <style>
      body {
        padding-top: 7.5%;
        padding-bottom: 0px;
        background-color: #303641;
        color: #C1C3C6;
      }
    </style>
  </head>
  <body>
    <?php
    $nm = '';
    $setting = $this->db->get('setting')->result();
    foreach($setting as $val){
      $nm = $val->nm_usaha;
    }
    ?>
    <div class="container">
      <form class="form-signin" role="form" action="app/login" method="post">
        <h3  class="form-signin-heading text-center" style="margin-top: -43px;">Sistem Inventori Barang</h3>
        <h3 class="text-center form-sigin-heading" style="margin-top:15px"><?=$nm?></h3>
        <div class="form-group mt-30">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="glyphicon glyphicon-user"></i>
            </div>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" autocomplete="off" autofocus />
          </div>
        </div>

        <div class="form-group">
          <div class="input-group">
            <div class="input-group-addon">
              <i class=" glyphicon glyphicon-lock "></i>
            </div>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" />
          </div>
        </div>

        <!-- <label class="checkbox mt-30">
          <input type="checkbox" value="remember-me" checked style="position: absolute;top: -8%;left: 0;display: block;width: 120%;height: 99% !important;margin: 0px;padding: 0px;background: rgb(255, 255, 255);border: 0px;opacity: 1 !important;"> &nbsp Remember me
        </label> -->
        <button class="btn btn-lg btn-primary btn-block h-60" type="submit">Masuk</button>
        <br>
       
      </form>

    </div>
    <div class="clearfix"></div>
    <br><br>
    <!--footer-->
    <div class="login-footer">
      <div class="container">
        <div class="copyright clearfix text-center">
          <p>--------------</p>
          <p><b>Creative</b>&nbsp;&nbsp;<a href="#">Development</a>&nbsp;&nbsp;<a href="#">Digital</a> & UMKM <a href="#" target="_blank" rel="external nofollow">Development</a> Technology</p>
        </div>
      </div>
    </div>
  </body>
</html>
