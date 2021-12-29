<div class="no-printme col-xs-6 col-sm-3 sidebar-offcanvas" role="navigation">
  <ul class="list-group panel">
    <li class="list-group-item"><i class="glyphicon glyphicon-align-justify"></i> <b>MENU UTAMA</b></li>
    <li class="list-group-item"><a href="<?php echo base_url()?>"><i class="glyphicon glyphicon-home"></i>Dashboard </a></li>
    <li class="list-group-item"><a href="kasir"><i class="glyphicon glyphicon-print"></i>KASIR </a></li>
  </ul>
    
    <?php 
      if ($this->session->userdata('level') == 'admin') {
    ?>

    <ul class="list-group panel">
      <li>
          <a href="#demo4" class="list-group-item" data-toggle="collapse"><i class="glyphicon glyphicon-th-large"></i>Data Master  <span class="glyphicon glyphicon-chevron-down" style="float: right;"></span></a>
            <li class="collapse in" id="demo4">
              <a href="barang" class="list-group-item"> Data Barang</a>
              <a href="jenis_barang" class="list-group-item"> Jenis Barang</a>
              <a href="merk_barang" class="list-group-item"> Merk Barang</a>
              <a href="material_warna" class="list-group-item"> Material Warna</a>
              <a href="supplier" class="list-group-item"> Supplier</a>
            </li>
      </li>
    </ul>

    <ul class="list-group panel">
      <li>
          <a href="#demo5" class="list-group-item " data-toggle="collapse"><i class="glyphicon glyphicon-folder-open"></i>Data Transaksi  <span class="glyphicon glyphicon-chevron-down" style="float: right;"></span></a>
            <li class="collapse in" id="demo5">
              <a href="barang_masuk" class="list-group-item">Barang Masuk</a>
              <a href="barang_keluar" class="list-group-item">Barang Keluar</a>
              <a href="laporan" class="list-group-item">Laporan Transaksi</a>
            </li>
      </li>
    </ul>
    
    <ul class="list-group panel">
      <li class="list-group-item"><a href="users"><i class="glyphicon glyphicon-user"></i>Manajemen User </a></li>
      <li class="list-group-item"><a href="setting"><i class="glyphicon glyphicon-wrench"></i>Setting Aplikasi</a></li>
    </ul>

    <ul class="list-group panel">
      <li class="list-group-item"><a href="app/logout"><i class="glyphicon glyphicon-share"></i>Logout</a></li>
    </ul>

    <?php 
      } elseif ($this->session->userdata('level') == 'manajer') {
    ?>

    <ul class="list-group panel">
      <li>
          <a href="#demo4" class="list-group-item" data-toggle="collapse"><i class="glyphicon glyphicon-th-large"></i>Data Master  <span class="glyphicon glyphicon-chevron-down" style="float: right;"></span></a>
            <li class="collapse in" id="demo4">
              <a href="barang" class="list-group-item"> Data Barang</a>
              <a href="jenis_barang" class="list-group-item"> Jenis Barang</a>
              <a href="merk_barang" class="list-group-item"> Merk Barang</a>
              <a href="material_warna" class="list-group-item"> Material Warna</a>
              <a href="supplier" class="list-group-item"> Supplier</a>
            </li>
      </li>
    </ul>

    <ul class="list-group panel">
      <li>
          <a href="#demo5" class="list-group-item " data-toggle="collapse"><i class="glyphicon glyphicon-folder-open"></i>Data Transaksi  <span class="glyphicon glyphicon-chevron-down" style="float: right;"></span></a>
            <li class="collapse in" id="demo5">
              <a href="barang_masuk" class="list-group-item">Barang Masuk</a>
              <a href="barang_keluar" class="list-group-item">Barang Keluar</a>
              <a href="app/penjualan" class="list-group-item">Pemesanan Ke Supplier</a>
            </li>
      </li>
    </ul>

    <ul class="list-group panel">
      <li class="list-group-item"><a href="users"><i class="glyphicon glyphicon-user"></i>Manajemen User </a></li>
      <li class="list-group-item"><a href="setting"><i class="glyphicon glyphicon-wrench"></i>Setting Aplikasi</a></li>
    </ul>

    <ul class="list-group panel">
      <li class="list-group-item"><a href="<?php echo base_url()?>app/logout"><i class="glyphicon glyphicon-share"></i>Logout</a></li>
    </ul>
    
    <?php 
      } elseif ($this->session->userdata('level') == 'petugas gudang') {
    ?>

  <ul class="list-group panel">
      <li>
          <a href="#demo5" class="list-group-item " data-toggle="collapse"><i class="glyphicon glyphicon-folder-open"></i>Data Transaksi  <span class="glyphicon glyphicon-chevron-down" style="float: right;"></span></a>
            <li class="collapse in" id="demo5">
              <a href="barang_masuk" class="list-group-item">Barang Masuk</a>
              <a href="barang_keluar" class="list-group-item">Barang Keluar</a>
              <a href="app/penjualan" class="list-group-item">Pemesanan Ke Supplier</a>
            </li>
      </li>
    </ul>

    <ul class="list-group panel">
      <li class="list-group-item"><a href="<?php echo base_url()?>app/logout"><i class="glyphicon glyphicon-share"></i>Logout</a></li>
    </ul>
    
    <?php 
      } elseif ($this->session->userdata('level') == 'supplier') {
    ?>
    <ul class="list-group panel">
      <li class="list-group-item"><a href="app/penjualan" class="list-group-item">Pemesanan Ke Supplier</a></li>
    </ul>
    <ul class="list-group panel">
      <li class="list-group-item"><a href="<?php echo base_url()?>app/logout"><i class="glyphicon glyphicon-share"></i>Logout</a></li>
    </ul>
    <?php } ?>
</div>