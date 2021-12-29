<style>
    .active {
        left: 0%;
    }
</style>
<?php
if($this->session->userdata('message')!=''){ ?>
<div class="alert alert-info alert-dismissable set-alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Berhasil !</strong> <?=$this->session->userdata('message')?>
</div>
<?php } ?>
<div class="row" style="margin-bottom: 10px">
    <div class="col-md-4">
        <?php echo anchor(site_url('barang_keluar/create'),'Tambah Barang Keluar', 'class="btn btn-primary"'); ?>
    </div>
    
    <div class="col-md-8 text-right">
        <form action="<?php echo site_url('barang_keluar/index'); ?>" class="form-inline" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                <span class="input-group-btn">
                    <?php 
                        if ($q <> '')
                        {
                            ?>
                            <a href="<?php echo site_url('barang_keluar'); ?>" class="btn btn-default">Reset</a>
                            <?php
                        }
                    ?>
                    <button class="btn btn-primary" type="submit">Cari</button>
                </span>
            </div>
        </form>
    </div>
</div>
<table class="table table-bordered" style="margin-bottom: 10px">
    <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th class="text-center">Tgl Keluar</th>
        <th class="text-center">Jumlah</th>
        <th class="text-right">Total Harga</th>
        <th>Action</th>
    </tr>
    <?php
    if(!empty($barang_keluar_data)){
    foreach ($barang_keluar_data as $barang_keluar){ ?>
    <tr>
        <td width="80px"><?php echo ++$start ?></td>
        <td><?=$barang_keluar->kode_barang ?><br/><b><?=$barang_keluar->nama_barang ?></b></td>
        <td class="text-center"><?php echo date('d-m-Y', strtotime($barang_keluar->tgl_keluar)) ?></td>
        <td class="text-center"><?php echo $barang_keluar->jumlah ?></td>
        <td class="text-right">
            > <?php echo number_format($barang_keluar->harga,0,',','.');?>
            </br>
            <b><?php echo number_format($barang_keluar->tot_harga,0,',','.');?></b>
        </td>
        <td style="text-align:center" width="200px">
        <a class="btn btn-default" href="<?=site_url('barang_keluar/update/'.$barang_keluar->id_barang_keluar)?>">Edit Data</a>
            <button type="button" class="btn btn-danger" onclick="hapus(<?=$barang_keluar->id_barang_keluar?>)">Hapus</button>
        </td>
    </tr>
    <?php } }else{ ?>
    <tr>
        <td class="text-center" colspan="6"><b>Data Kosong</b></td>
    </tr>
    <?php } ?>
</table>
<div class="row">
    <div class="col-md-6">
        <a href="#" class="btn btn-default">Total Record : <?php echo $total_rows ?></a>
</div>
    <div class="col-md-6 text-right">
        <?php echo $pagination ?>
    </div>
</div>

<script>
     setTimeout(function(){
        $('.set-alert').css('display','none');
    }, 3000);
    function hapus(id){
        var uri = '<?=site_url()?>';
        swal({
            title: "Hapus data ini",
            text: "akan berpengaruh pada stok barang ?",
            icon: "warning",
            buttons: {
                confirm : {text:'Hapus',className:'sweet-warning'},
                cancel : 'Batalkan'
            },
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.post(uri+'barang_keluar/delete/'+id, function(data) {
                    window.location.href = uri+'barang_keluar';
                });
            } 
        });
    }
</script>