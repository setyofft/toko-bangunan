<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inventori Toko Bangunan</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
    <base href="<?php echo base_url();?>">
    <link rel="shortcut icon" href="favicon_16.ico"/>
    <link rel="bookmark" href="favicon_16.ico"/>

    <link rel="stylesheet" href="assets/dist/css/site.min.css">
    
    <link href="assets/bootstrap-datepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/select/css/bootstrap-select.min.css">

    <script type="text/javascript" src="assets/dist/js/site.min.js"></script>
    <script type="text/javascript" src="assets/dist/js/jquery.min.js"></script>

    <!-- <script type="text/javascript" src="assets/select/js/bootstrap-select.min.js"></script> -->
    <script src="assets/dist/js/sweetalert.js"></script>
    <script src="assets/dist/js/apexcharts.js"></script>
    
    <style>
      .printme {
        display: none;
      }
      .active{
        left:20%;
      }
    </style>
    <script type="text/javascript">
        function onReady(callback) {
          var intervalId = window.setInterval(function() {
            if (document.getElementsByTagName('body')[0] !== undefined) {
              window.clearInterval(intervalId);
              callback.call(this);
            }
          }, 200);
        }

        function setVisible(selector, visible) {
          document.querySelector(selector).style.display = visible ? 'block' : 'none';
        }

        onReady(function() {
          setVisible('.page', true);
          setVisible('.loading', false);
        });
    </script>
  </head>
  <body class="page">
  <?php
  $nm = '';
  $setting = $this->db->get('setting')->result();
  foreach($setting as $val){
    $nm = $val->nm_usaha;
  }
  ?>
  <div class="loading"></div>
  <nav role="navigation" class="no-printme navbar navbar-custom" style="margin-bottom: 0px;">
      <div class="row">
        <div class="col-lg-6 col-md-6">
          <h5 style="color: #434a54">SITEM INVENTORI <?=$nm?></h5>
        </div>
        <div class="col-lg-6 col-md-6 text-right">
          <div id="jam-digital">
              <h5><?=$this->session->userdata('nama')?></h5>
          </div>
        </div>
      </div>
  </nav>
  <div class="body">
  