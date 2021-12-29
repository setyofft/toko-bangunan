<?php
if($this->session->userdata('message')!=''){ ?>
<div class="alert alert-info alert-dismissable set-alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Berhasil !</strong> <?=$this->session->userdata('message')?>
</div>
<?php } ?>
<div class="row" style="margin-bottom: 10px">
    <div class="col-md-4">
        <?php echo anchor(site_url('users/create'),'Tambah User', 'class="btn btn-primary"'); ?>
    </div>
   
    <div class="col-md-8 text-right">
        <form action="<?php echo site_url('users/index'); ?>" class="form-inline" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                <span class="input-group-btn">
                    <?php 
                        if ($q <> '')
                        {
                            ?>
                            <a href="<?php echo site_url('users'); ?>" class="btn btn-default">Reset</a>
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
        <th>Nama User</th>
        <th>Username</th>
        <th>Level</th>
        <th>Action</th>
    </tr>
    <?php
    if(!empty($users_data)){
    foreach ($users_data as $users){ ?>
    <tr>
        <td class="text-center" width="50px"><?php echo ++$start ?></td>
        <td><?php echo $users->nama_user ?></td>
        <td><?php echo $users->username ?></td>
        <td><?php echo $users->level ?></td>
        <td style="text-align:center" width="200px">
            <a class="btn btn-default" href="<?=site_url('users/update/'.$users->id_user)?>">Edit Data</a>
            <button type="button" class="btn btn-danger" onclick="hapus(<?=$users->id_user?>)">Hapus</button>
        </td>
    </tr>
    <?php } }else{ ?>
    <tr>
        <td class="text-center" colspan="5"><b>Data Kosong</b></td>
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
                $.post(uri+'users/delete/'+id, function(data) {
                    window.location.href = uri+'users';
                });
            } 
        });
    }
</script>