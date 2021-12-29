<?php
$almt='';
$setting = $this->db->get('setting')->result();
foreach($setting as $val){
  $almt = $val->alamat;
}
?>
<div class="alert alert-success">
  <strong>Selamat Datang</strong> <?php echo $this->session->userdata('nama'); ?>.<br/>
  <?=$almt?>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="color-swatches">
      <div class="swatches">
        <div class="clearfix">
          <?php foreach($totbrg as $val){ ?>
          <div class="pull-left light text-center" style="background-color:#5D9CEC">
            <label style="color:#fff;font-size: 19pt;margin-top: 7px;"><?=intval($val->totbrg)?></label>
          </div>
          <div class="pull-right dark text-center" style="background-color:#4A89DC">
            <label style="color:#fff;font-size: 12pt;margin-top: 12px;">Barang</label>
          </div>
        <?php } ?>
        </div>
        <div class="infos">
          <h4>DATA BARANG</h4>
          <p>Keseluruhan data barang</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="color-swatches">
      <div class="swatches">
        <div class="clearfix">
          <?php foreach($tranmasuk as $val){ 
            $in = intval($val->tranmasuk);
          ?>
          <div class="pull-left light text-center" style="background-color:#48CFAD">
            <label style="color:#fff;font-size: 19pt;margin-top: 7px;"><?=intval($val->tranmasuk)?></label>
          </div>
          <div class="pull-right dark text-center" style="background-color:#37BC9B">
            <label style="color:#fff;font-size: 12pt;margin-top: 12px;">Transaksi</label>
          </div>
          <?php } ?>
        </div>
        <div class="infos">
          <?php foreach($tranmasuk as $val){ $hrgin = $val->trantotharga; ?>
          <h4><?=number_format($val->trantotharga,0,',','.')?></h4>
          <?php } ?>
          <p>Total Transaksi Masuk</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="color-swatches">
      <div class="swatches">
        <div class="clearfix">
          <?php foreach($trankeluar as $val){ 
            $out = intval($val->trankeluar);
          ?>
          <div class="pull-left light text-center" style="background-color:#FC6E51">
            <label style="color:#fff;font-size: 19pt;margin-top: 7px;"><?=intval($val->trankeluar)?></label>
          </div>
          <div class="pull-right dark text-center" style="background-color:#E9573F">
            <label style="color:#fff;font-size: 12pt;margin-top: 12px;">Transaksi</label>
          </div>
          <?php } ?>
        </div>
        <div class="infos">
          <?php foreach($trankeluar as $valkelu){ $hrgout = $valkelu->totharga; ?>
            <h4><?=number_format($valkelu->totharga,0,',','.')?></h4>
          <?php } ?>
          <p>Total Transaksi Keluar</p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="color-swatches">
      <div class="swatches">
        <div class="clearfix">
          <div class="pull-left light text-center" style="background-color:#EC87C0">
            <label style="color:#fff;font-size: 19pt;margin-top: 7px;"><?=$in+$out?></label>
          </div>
          <div class="pull-right dark text-center" style="background-color:#D770AD">
            <label style="color:#fff;font-size: 12pt;margin-top: 12px;">Transaksi</label>
          </div>
        </div>
        <div class="infos">
          <?php foreach($perbulan as $mskbulan){ $mskperbulan = $mskbulan->perbulan; ?>
          <h4><?=number_format((intval($mskperbulan)),0,',','.')?></h4>
          <?php } ?>
          <p>Total Pendapatan Perbulan</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <div id="chart-masuk"></div>
  </div>
  <div class="col-md-6">
    <div id="chart-keluar"></div>
  </div>
</div>


<script>
  // $('#slide').addClass('active');
  chart_masuk();
  chart_keluar();
  
  function chart_masuk(){
    $.ajax({
          type: 'POST',
          url: '<?=base_url()?>app/getDatamasuk',
          success: function (data) {
              jsonData = $.parseJSON(data);
              var barang = [];
              var bulan = [];
          	  for (var i = 0; i < jsonData.length; i++) {
                barang.push(jsonData[i].totbrg);  
                bulan.push(format_tgl(jsonData[i].tgl_masuk));         
              }
              MasukChart(barang,bulan);
          }
        });
  }

  function chart_keluar(){
    $.ajax({
          type: 'POST',
          url: '<?=base_url()?>app/getDatakeluar',
          success: function (data) {
              jsonData = $.parseJSON(data);
              var barang = [];
              var bulan = [];
          	  for (var i = 0; i < jsonData.length; i++) {
                barang.push(jsonData[i].totbrg);  
                bulan.push(format_tgl(jsonData[i].tgl_keluar));         
              }
              KeluarChart(barang,bulan);
          }
        });
  }

  function MasukChart(barang,bulan){
    var options = {
          series: [{
          name: 'Barang',
          data: barang
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: 7,
          curve: 'smooth'
        },
        xaxis: {
          categories: bulan,
        },
        title: {
          text: 'Transaksi Masuk Perbulan',
          align: 'left',
          style: {
            fontSize: "16px",
            color: '#666'
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            gradientToColors: [ '#FDD835'],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
          },
        },
        markers: {
          size: 4,
          colors: ["#FFA41B"],
          strokeColors: "#fff",
          strokeWidth: 2,
          hover: {
            size: 7,
          }
        },
        yaxis: {
          title: {
            text: 'Jumlah Transaksi Masuk',
          },
        }
        };
   
    var masuk = new ApexCharts(document.querySelector("#chart-masuk"), options);
    masuk.render();
    $('.apexcharts-toolbar').css('display','none');
  }

  function KeluarChart(barang,bulan){
    var options = {
          series: [{
          name: 'Barang',
          data: barang
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: 7,
          curve: 'smooth'
        },
        xaxis: {
          categories: bulan,
        },
        title: {
          text: 'Transaksi Keluar Perbulan',
          align: 'left',
          style: {
            fontSize: "16px",
            color: '#666'
          }
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'dark',
            gradientToColors: [ '#FDD835'],
            shadeIntensity: 1,
            type: 'horizontal',
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100, 100, 100]
          },
        },
        markers: {
          size: 4,
          colors: ["#FFA41B"],
          strokeColors: "#fff",
          strokeWidth: 2,
          hover: {
            size: 7,
          }
        },
        yaxis: {
         
          title: {
            text: 'Jumlah Transaksi Keluar',
          },
        }
        };
    var keluar = new ApexCharts(document.querySelector("#chart-keluar"), options);
    keluar.render();
    $('.apexcharts-toolbar').css('display','none');
  }
 
  function format_tgl(tgl) { 
      var today = new Date(tgl);
      const mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(today)
          
      return mo; 
  } 
</script>

