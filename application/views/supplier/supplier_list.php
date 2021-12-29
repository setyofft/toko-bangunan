<?php
if($this->session->userdata('message')!=''){ ?>
<div class="alert alert-info alert-dismissable set-alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Berhasil !</strong> <?=$this->session->userdata('message')?>
</div>
<?php } ?>
<div class="row" style="margin-bottom: 10px">
    <div class="col-md-4">
        <?php echo anchor(site_url('supplier/create'),'Tambah Supplier', 'class="btn btn-primary"'); ?>
    </div>
    <div class="col-md-4 text-center">
        <div style="margin-top: 8px" id="message">
            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
        </div>
    </div>
    <div class="col-md-1 text-right">
    </div>
    <div class="col-md-3 text-right">
        <form action="<?php echo site_url('supplier/index'); ?>" class="form-inline" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                <span class="input-group-btn">
                    <?php 
                        if ($q <> '')
                        {
                            ?>
                            <a href="<?php echo site_url('supplier'); ?>" class="btn btn-default">Reset</a>
                            <?php
                        }
                    ?>
                    <button class="btn btn-primary" type="submit">Search</button>
                </span>
            </div>
        </form>
    </div>
</div>
<table class="table table-bordered" style="margin-bottom: 10px">
    <tr>
        <th class="text-center">No</th>
        <th>Kode Supplier</th>
        <th>Nama Supplier</th>
        <th>No Hp</th>
        <th>Alamat</th>
        <th>Action</th>
    </tr>
    <?php
    if(!empty($supplier_data)){
    foreach ($supplier_data as $supplier) { ?>
    <tr>
        <td class="text-center"><?php echo ++$start ?></td>
        <td><?php echo $supplier->kode_supplier ?></td>
        <td><?php echo $supplier->nama_supplier ?></td>
        <td><?php echo $supplier->no_hp ?></td>
        <td><?php echo $supplier->alamat ?></td>
        <td style="text-align:center" width="200px">
            <a class="btn btn-default" href="<?=site_url('supplier/update/'.$supplier->id_supplier)?>">Edit Data</a>
            <button type="button" class="btn btn-danger" onclick="hapus(<?=$supplier->id_supplier?>)">Hapus</button>
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
                $.post(uri+'supplier/delete/'+id, function(data) {
                    window.location.href = uri+'supplier';
                });
            } 
        });
    }

</script>