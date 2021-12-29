<?php
if($this->session->userdata('message')!=''){ ?>
<div class="alert alert-info alert-dismissable set-alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Berhasil !</strong> <?=$this->session->userdata('message')?>
</div>
<?php } ?>
<div class="row" style="margin-bottom: 10px">
    <div class="col-md-4">
        <?php echo anchor(site_url('barang_masuk/create'),'Tambah Barang Masuk', 'class="btn btn-primary"'); ?>
    </div>
    
    <div class="col-md-8 text-right">
        <form action="<?php echo site_url('barang_masuk/index'); ?>" class="form-inline" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                <span class="input-group-btn">
                    <?php 
                        if ($q <> '')
                        {
                            ?>
                            <a href="<?php echo site_url('barang_masuk'); ?>" class="btn btn-default">Reset</a>
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
        <th>Kode Supplier</th>
        <th class="text-center">Jumlah</th>
        <th class="text-center">Harga Perubahan</th>
        <th class="text-center">Tanggal Masuk</th>
        <th>Action</th>
    </tr>
    <?php
    if(!empty($barang_masuk_data)){
    foreach ($barang_masuk_data as $barang_masuk){ ?>
    <tr>
        <td width="80px"><?php echo ++$start ?></td>
        <td><?=$barang_masuk->kode_barang ?> <br/><b><?=$barang_masuk->nama_barang ?></b></td>
        <td><?php echo $barang_masuk->kode_supplier ?></td>
        <td class="text-center"><?php echo $barang_masuk->jumlah ?></td>
        <td class="text-right"><?php echo number_format($barang_masuk->hrg,0,',','.');?></td>
        <td class="text-center"><?php echo date('d-m-Y', strtotime($barang_masuk->tgl_masuk)) ?></td>
        <td style="text-align:center" width="200px">
            <a class="btn btn-default" href="<?=site_url('barang_masuk/update/'.$barang_masuk->id_barang_masuk)?>">Edit Data</a>
            <button type="button" class="btn btn-danger" onclick="hapus(<?=$barang_masuk->id_barang_masuk?>)">Hapus</button>
        </td>
    </tr>
    <?php } }else{ ?>
    <tr>
        <td class="text-center" colspan="7"><b>Data Kosong</b></td>
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
                $.post(uri+'barang_masuk/delete/'+id, function(data) {
                    window.location.href = uri+'barang_masuk';
                });
            } 
        });
    }
</script>