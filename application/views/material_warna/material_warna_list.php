<?php
if($this->session->userdata('message')!=''){ ?>
<div class="alert alert-info alert-dismissable set-alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Berhasil !</strong> <?=$this->session->userdata('message')?>
</div>
<?php } ?>
<div class="row" style="margin-bottom: 10px">
    <div class="col-md-9">
        <?php echo anchor(site_url('material_warna/create'),'Tambah Material Warna', 'class="btn btn-primary"'); ?>
    </div>
    <div class="col-md-1 text-right">
    </div>
    <div class="col-md-3 text-right">
        <form action="<?php echo site_url('material_warna/index'); ?>" class="form-inline" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                <span class="input-group-btn">
                    <?php 
                        if ($q <> '')
                        {
                            ?>
                            <a href="<?php echo site_url('material_warna'); ?>" class="btn btn-default">Reset</a>
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
        <th class="text-center">No</th>
        <th>Kode Warna</th>
        <!-- <th>Ukuran</th>
        <th>Beart</th> -->
        <th class="text-center">Warna</th>
        <!-- <th class="text-center">Harga</th> -->
        <th>Action</th>
    </tr>
    <?php
    if(!empty($material_warna_data)){
    foreach ($material_warna_data as $warna){ ?>
    <tr>
        <td class="text-center" width="50px"><?php echo ++$start ?></td>
        <td width="200px"><?php echo $warna->kode_warna ?></td>
        <!-- <td><?php echo $warna->ukuran ?></td>
        <td><?php echo $warna->berat ?></td> -->
        <td class="text-center"><?php echo strtoupper($warna->warna) ?></td>
        <!-- <td class="text-center"><?php echo number_format($warna->harga,0,',','.');?></td> -->
        <td style="text-align:center" width="200px">
            <a class="btn btn-default" href="<?=site_url('material_warna/update/'.$warna->id_warna)?>">Edit Data</a>
            <button type="button" class="btn btn-danger" onclick="hapus(<?=$warna->id_warna?>)">Hapus</button>
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
        <a href="#" class="btn btn-default">Total Data : <?php echo $total_rows ?></a>
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
            title: "",
            text: "Yakin ingin menghapus data ini ?",
            icon: "warning",
            buttons: {
                confirm : {text:'Hapus',className:'sweet-warning'},
                cancel : 'Batalkan'
            },
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.post(uri+'material_warna/delete/'+id, function(data) {
                    window.location.href = uri+'material_warna';
                });
            } 
        });
    }
</script>