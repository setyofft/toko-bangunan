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
    <div class="col-md-2 col-xs-2">
        <?php echo anchor(site_url('barang/create'),'Tambah Barang', 'class="btn btn-primary"'); ?>
    </div>
    
    <div class="col-md-10 col-xs-10 text-right">
        <form action="<?php echo site_url('barang/index'); ?>" class="form-inline" method="get">
            <div class="input-group" style="width: 257px;">
                <select name="jns_brg" id="jns_brg" class="form-control search-select" data-live-search="true" data-title="Pilih Jenis Barang">
                <?php 
                    $sql = $this->db->get('jenis_barang');
                    foreach ($sql->result() as $row) {
                        ?>
                    <option <?php if ($id_jenis == $row->id_jenis ) echo 'selected';?> value="<?php echo $row->id_jenis ?>"><?php echo $row->jenis_barang ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="input-group">
                <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                <span class="input-group-btn">
                    <?php 
                        if ($q <> '')
                        {
                            ?>
                            <a href="<?php echo site_url('barang'); ?>" class="btn btn-default">Reset</a>
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
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th class="text-center">Stok</th>
        <th>Ukuran</th>
        <th class="text-center">Berat</th>
        <th class="text-right">Harga</th>
        <th>Keterangan</th>
        <th>Action</th>
    </tr>
    <tbody id="bydata">
    <?php
    if(!empty($barang_data)){
    foreach ($barang_data as $barang){ ?>
    <tr>
        <td class="text-center"><?php echo ++$start ?></td>
        <td><?php echo $barang->kode_barang ?></td>
        <td><b><?php echo $barang->nama_barang ?></b></td>
        <td class="text-center"><b><?php echo $barang->stok ?></b></td>
        <td><?php if($barang->ukuran==''){ echo '-';}else{echo $barang->ukuran;} ?></td>
        <td class="text-center"><?php if($barang->berat==''){ echo '-';}else{echo $barang->berat;} ?></td>
        <td class="text-right"><b><?php echo number_format($barang->harga,0,',','.');?></b></td>
        <td><?php if($barang->keterangan==''){ echo '-';}else{echo $barang->keterangan;} ?></td>
        <td style="text-align:center" width="200px">
            <a class="btn btn-default" href="<?=site_url('barang/update/'.$barang->id_barang)?>">Edit Data</a>
            <button type="button" class="btn btn-danger" onclick="hapus(<?=$barang->id_barang?>)">Hapus</button>
        </td>
    </tr>
    <?php } }else{ ?>
    <tr>
        <td class="text-center" colspan="9"><b>Data Kosong</b></td>
    </tr>
    <?php } ?>
    </tbody>
</table>
<div class="row">
    <div class="col-md-6">
        <a href="#" class="btn btn-default total">Total Data : <b><?php echo $total_rows ?></b></a>
    </div>
    <div class="col-md-6 text-right">
        <?php echo $pagination ?>
    </div>
</div>

<script type="text/javascript" src="assets/select/js/bootstrap-select.min.js"></script>
<script>
    $('.search-select').selectpicker();
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
                $.post(uri+'barang/delete/'+id, function(data) {
                    window.location.href = uri+'barang';
                });
            } 
        });
    }

    $('select').on('change', function() {
        var jns_brg = $("#jns_brg option:selected").val();
        console.log(jns_brg);
        var uri = '<?=site_url()?>';
        $.ajax({
            method: "POST",
            url: uri+'barang/Byjnsbrg',
            data: { jns_brg: jns_brg },
            beforeSend: function( xhr ) {
                $('.loading').show();
            }
        }).done(function(data) {
            $('.loading').hide();
            var jsonData = $.parseJSON(data);
            console.log(jsonData.length)
            var html = '';
            if(jsonData.length!=0){
                $('#bydata').html('');
               for(i=0; i < jsonData.length; i++){
                    if(jsonData[i].keterangan==''){
                        jsonData[i].keterangan = '-';
                    }
                    if(jsonData[i].ukuran==''){
                        jsonData[i].ukuran = '-';
                    }
                    if(jsonData[i].berat==''){
                        jsonData[i].berat ='-';
                    }
                    html +='<tr>'+
                    '<td class="text-center">'+(i+1)+'</td>'+
                    '<td>'+jsonData[i].kode_barang+'</td>'+
                    '<td>'+jsonData[i].nama_barang+'</td>'+
                    '<td class="text-center">'+jsonData[i].stok+'</td>'+
                    '<td>'+jsonData[i].ukuran+'</td>'+
                    '<td class="text-center">'+jsonData[i].berat+'</td>'+
                    '<td class="text-right">'+Rp(jsonData[i].harga)+'</td>'+
                    '<td>'+jsonData[i].keterangan+'</td>'+
                    '<td style="text-align:center" width="200px">'+
                        '<a class="btn btn-default" href="<?=site_url()?>barang/update/'+jsonData[i].id_barang+'">Edit Data</a>'+
                        '<button style="margin-left: 5px;" type="button" class="btn btn-danger" onclick="hapus('+jsonData[i].id_barang+')">Hapus</button>'+
                    '</td>'+
                    '</tr>';
               }
            }else{
                $('#bydata').html('');
                html ='<tr>'+
                '<td class="text-center" colspan="9"><b>Jenis Barang ini tidak ditemukan</b></td>'+
                '</tr>';
            }
            $('#bydata').append(html);
        });
    });

    function Rp(bilangan){
        var	reverse = bilangan.toString().split('').reverse().join(''),
            ribuan 	= reverse.match(/\d{1,3}/g);
            ribuan	= ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }
</script>