<style>
.content-row-title{
    display:none;
}
.navbar{
    display:none;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type=number] {
  -moz-appearance: textfield;
}

.stepper .up {
    border:0px;
}
.stepper .stepper-arrow {
    background-color: #FFFFFF;
}

.printme {
	display: none;
}
@media print {
	.no-printme  {
		display: none;
	}
	.printme  {
		display: block;
        margin:0px;
    }
    hr {
        border-top:1px dotted #000;
        margin:3px 0px 10px 0px;
    }
}
.warning-0-stok{
    background: #ff6a00;
    color: #fff;
}
.warning-min-stok{
    background: red;
    color: #fff;
}
</style>
<?php
$set = $this->db->get('setting')->row();
$nm_usaha = $set->nm_usaha;
$jl = $set->alamat;
$notelp = $set->notelp
?>
<input type="hidden" value="<?=$jl?>" id="nmjln">
<input type="hidden" value="<?=$nm_usaha?>" id="nmusaha">
<input type="hidden" value="<?=$notelp?>" id="notelp">
<div class="row no-printme" style="margin-bottom: 0px;">
    <div class="col-md-4 col-xs-5" style="border:1.5px solid gray">
        <h5><a href="<?base_url()?>kasir">Transaksi Hari ini</a></h5> 
        <div style="position: absolute;
            top: 2%;
            right: 4%;">
            <span style="padding: 2px;
                background: #ff6a00;
                color: #fff;
                padding-left: 15px;
                margin-right: 5px;"></span>  = Stok 0,  
            <span style="padding: 2px;
                background: red;
                color: #fff;
                padding-left: 15px;
                margin-right: 5px;"></span>  = Stok < 0
        </div>
        <div class="input-group" style="width:100%">
            <input id="search" autocomplete="off" name="search" type="text" class="form-control" placeholder="Cari Nama Barang">
        </div><br/>
        <div style="height: 701px;overflow: auto;">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 150px;">Barang</th>
                    <th class="text-center">Stok</th>
                    <th class="text-right">Harga</th>
                    <th class="text-center">Action</th>
                </tr>
                <tbody id="tabel_barang">
                <?php
                foreach($barang as $val){
                ?>
                <tr class="<?php if($val->stok==0){echo 'warning-0-stok';}else if($val->stok < 0){ echo 'warning-min-stok';}?>">
                    <td><?=$val->nama_barang?></td>
                    <td class="text-center"><?=$val->stok?></td>
                    <td class="text-right"><?=number_format($val->harga,0,',','.')?></td>
                    <td>
                        <button style="padding:0px;width:100%;height: 38px;" type="button" class="btn btn-primary ambilbrg" ref="<?=$val->id_barang?>">
                        Ambil
                        </button>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <form id="form-brg-keluar">
    <div class="col-md-5 col-xs-5" style="border:1.5px solid gray;"><h5>List Barang Keluar</h5>
        <div style="height: 752px;overflow: auto;">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 170px;">Barang</th>
                    <th style="width: 130px;" class="text-center">Harga/Jumlah</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-center">Action</th>
                </tr>
                <tbody id="list_beli">
                    
                </tbody>
               
            </table>
        </div>
    </div>
    <div class="col-md-3 col-xs-2" style="border:1.5px solid gray;height:810px">
        <h5>Pembeli</h5>
        
        <div class="input-group" style="width:100%">
            <label>Nama Pembeli</label>
            <input type="text" class="form-control" name="nmpembeli" id="nmpembeli" style="height: 48px;font-size: 12pt;">
        </div>
        <div class="input-group" style="margin-top:10px;width:100%">
            <label>No Hp Pembeli</label>
            <input type="text" class="form-control" name="nohp" id="nohp" style="height: 48px;font-size: 12pt;">
        </div>
        <div class="input-group" style="margin-top:10px;width:100%">
            <label>Alamat Pembeli</label>
            <input type="text" class="form-control" name="alamat" id="alamat" style="height: 48px;font-size: 12pt;">
        </div>

        <h5>Hitung</h5>
        
        <div class="input-group" style="width:100%">
            <label>Total Harga</label>
            <input type="hidden" name="keybrg" id="keybrg" value="<?=$nourut?>">
            <input type="hidden" value="0" name="totbyr" id="totbyr">
            <input readonly value="0" type="text" class="form-control" name="lbl_totbyr" id="lbl_totbyr" style="height: 48px;font-size: 12pt;">
        </div>
        
        <div class="input-group" style="margin-top:10px;width:100%">
            <label>Diskon (%)</label>
            <input value="0" type="text" class="form-control" name="diskon" id="diskon" style="height: 48px;font-size: 12pt;">
        </div>

        <div class="input-group" style="margin-top:10px;width:100%">
            <label>BAYAR</label>
            <input type="hidden" value="0" name="bayar" id="bayar">
            <input type="text" class="form-control" name="lbl_bayar" id="lbl_bayar" style="height: 48px;font-size: 12pt;">
        </div>

        <div class="input-group" style="margin-top:10px;width:100%">
            <label>KEMBALI</label>
            <input type="hidden" value="0" name="sisa" id="sisa">
            <input readonly type="number" class="form-control" name="lbl_sisa" id="lbl_sisa" style="height: 48px;font-size: 12pt;">
        </div>

        <div class="input-group" style="margin-top:10px;width:100%">
            <label>Keterangan</label>
            <input type="text" class="form-control" name="ket" id="ket" value="Lunas" onkeyup="valmin()">
        </div>

        <div class="input-group" style="margin-top:10px;width:100%">
            <button id="selesai_bayar" type="button" class="btn btn-primary" style="height: 60px;font-size: 20pt;width: 100%;margin-top: 18px;">
            BAYAR 
            </button>
        </div>
    </div>
    </form>
</div>

<script>
var min = '';
$('#search').keyup(function(){
    search_barang($(this).val());
})

function search_barang(value){
    $('#tabel_barang tr').each(function(){
        var found = 'false';
        $(this).each(function(){
            if($(this).text().toLowerCase().indexOf(value.toLowerCase()) >= 0)  
            {  
                found = 'true'; 
            } 
        });
        if(found == 'true')  {  
            $(this).show();  
        }else{  
            $(this).hide();  
        }  
    });
}

$('#selesai_bayar').click(function(){
    var banyak = [],
        kd_brg = [],
        harga = [],
        harga_satuan = [],
        totbyr = $('#totbyr').val(),
        bayar = $('#bayar').val(),
        sisa = $('#sisa').val(),
        diskon = $('#diskon').val(),
        keybrg = $('#keybrg').val(),
        alamat = $('#alamat').val(),
        nmpembeli = $('#nmpembeli').val(),
        nohp = $('#nohp').val(),
        nmusaha = $('#nmusaha').val(),
        notelp = $('#notelp').val(),
        nmjln  = $('#nmjln').val(),
        ket = $('#ket').val();
    var uri = '<?=site_url()?>';
    $.each($("input[name='banyak[]']"), function(){
        banyak.push($(this).val());
    });
    $.each($("input[name='kd_brg[]']"), function(){
        kd_brg.push($(this).val());
    });
    $.each($("input[name='harga[]']"), function(){
        harga.push($(this).val());
    });
    $.each($("input[name='harga_satuan[]']"), function(){
        harga_satuan.push($(this).val());
    });
    
    $.ajax({
        method: "POST",
        url: uri+'kasir/addtransaksi',
        data: { keybrg:keybrg, kd_brg:kd_brg,banyak:banyak,harga:harga, totbyr:totbyr,bayar:bayar,sisa:sisa, nohp:nohp,nmpembeli:nmpembeli,alamat:alamat, diskon:diskon, ket:ket, harga_satuan:harga_satuan},
        beforeSend: function( xhr ) {
            $('.loading').show();
        }
    })
    .done(function(data) {
        var jsonData = $.parseJSON(data);
        $('.loading').hide();
        $('#print #nmusaha').text(nmusaha);
        $('#print #jalan').text(nmjln);
        $('#print #ket_notelp').text(notelp);
        $('#print #nmpem').html('<b>Nama Pembeli: </b>'+nmpembeli);
        $('#print #nopem').html('<b>No Telp Pembeli: </b>'+nohp);
        $('#print #almtpem').html('<b>Alamat Pembeli: </b>'+alamat);
        $('#print #kdtran').html('<b>Kode Transaksi: </b>'+$('#keybrg').val());
        $('#print #keterangan').html('<b>Ketrangan: </b>'+ket);
        if($('#ket').val() == 'Lunas'){
            min = '';
        }else{
            min = '- ';
        }
        window.print();
        $('#list_beli').html('');
        $('#print .setdata').html('');
        $('#print .footerdata').html('');
        
        backt_list_transaksi();
    });
    
});

function backt_list_transaksi(){
    swal({
        title: "",
        text: "Apakah ingin melakukan transaksi lagi ?",
        icon: "warning",
        buttons: {
            confirm : {text:'Tidak',className:'sweet-warning'},
            cancel : 'Ya'
        },
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            window.location.href = '<?=base_url()?>kasir';
        }else{
            window.location.href = '<?=base_url()?>transaksi';
        } 
    });
}

function valmin(){
    if($('#ket').val() == 'Lunas'){
        min = '';
    }else{
        min = '- ';
    }
    tot_bayar()
}
function tot_bayar(){
    tot = 0;
    $( ".harga" ).each(function( index ) {
        tot=tot + parseInt($( this ).val());
    });
    $('#lbl_totbyr').val(Rp(tot));
    $('#totbyr').val(tot);
   
    var footerdata = '';
    footerdata = '<tr>'+
    '<td colspan="3"><b>Total</b></td>'+
    '<td class="text-right">'+Rp($('#totbyr').val())+'</td>'+
    '</tr>'+
    '<tr>'+
    '<td colspan="3"><b>Bayar</b></td>'+
    '<td class="text-right">'+Rp($('#bayar').val())+'</td>'+
    '</tr>'+
    '<tr>'+
    '<td colspan="3"><b>Diskon</b></td>'+
    '<td class="text-right">'+$('#diskon').val()+'%</td>'+
    '</tr>'+
    '<tr>'+
    '<td colspan="3"><b>Kembali</b></td>'+
    '<td class="text-right">'+min+Rp($('#sisa').val())+'</td>'+
    '</tr>';
    $('#print .footerdata').html(footerdata);
}

$('.ambilbrg').on('click', function(){
    var id = $(this).attr('ref');
    var ambil = '';
    var uri = '<?=site_url()?>';
    $.ajax({
        method: "POST",
        url: uri+'kasir/getId',
        data: { id: id },
    })
    .done(function(data) {
        var jsonData = $.parseJSON(data);
        var banyak=1;
        var totbyr = $('#totbyr').val();
        ambil = '<tr id="'+jsonData.id_barang+'">'+
        '<td><input type="hidden" name="kd_brg[]" id="kd_brg" value="'+jsonData.kode_barang+'">'+jsonData.nama_barang+'</td>'+
        '<td width="20px">'+
        '<label>Harga</label>'+
        '<input type="text" class="text-center form-control" name="harga_satuan[]" id="harga_key" onkeyup="total('+jsonData.id_barang+')" value="'+jsonData.harga+'">'+
        '<label>Jumlah</label>'+
        '<input type="number" name="banyak[]" id="banyak" value="'+banyak+'" onkeyup="total('+jsonData.id_barang+')" class="text-center form-control"></td>'+
        '<td class="text-right"><input type="hidden" class="harga" name="harga[]" id="harga" value="'+jsonData.harga+'"><label id="lbl_harga">'+Rp(jsonData.harga)+'</label></td>'+
        '<td><button style="padding:0px;width:100%;height: 38px;" type="button" class="btn btn-danger" onclick="batal('+jsonData.id_barang+')">Batal</button></td>'+
        '</tr>';
        $('#list_beli').append(ambil);
        tot_bayar();

        var dataprint = '';
        dataprint = '<tr id="print_'+jsonData.id_barang+'">'+
        '<td>'+jsonData.nama_barang+'</td>'+
        '<td class="print_jmlh text-center">'+banyak+'</td>'+
        '<td class="print_harga_satuan text-right">'+Rp(jsonData.harga)+'</td>'+
        '<td class="print_harga text-right">'+Rp(jsonData.harga)+'</td>'+
        '</tr>';
        $('#print .setdata').append(dataprint);
    })
})

function ambil(id){
    var ambil = '';
    var uri = '<?=site_url()?>';
    $.ajax({
        method: "POST",
        url: uri+'kasir/getId',
        data: { id: id },
    })
    .done(function(data) {
        var jsonData = $.parseJSON(data);
        var banyak=1;
        var totbyr = $('#totbyr').val();
        ambil = '<tr id="'+jsonData.id_barang+'">'+
        '<td><input type="hidden" name="kd_brg[]" id="kd_brg" value="'+jsonData.kode_barang+'">'+jsonData.nama_barang+'</td>'+
        '<td width="20px">'+
        '<input type="text" style="width: 96px;" class="text-center form-control" id="harga_key" onkeyup="total('+jsonData.id_barang+')" value="'+jsonData.harga+'">'+
        '<input type="number" style="width: 52px;position: absolute;top: 12.5%;left: 57%;" name="banyak[]" id="banyak" value="'+banyak+'" onkeyup="total('+jsonData.id_barang+')" class="text-center form-control"></td>'+
        '<td class="text-right"><input type="hidden" class="harga" name="harga[]" id="harga" value="'+jsonData.harga+'"><label id="lbl_harga">'+Rp(jsonData.harga)+'</label></td>'+
        '<td><button style="padding:0px;width:100%;height: 38px;" type="button" class="btn btn-danger" onclick="batal('+jsonData.id_barang+')">Batal</button></td>'+
        '</tr>';
        $('#list_beli').append(ambil);
        tot_bayar();

        var dataprint = '';
        dataprint = '<tr id="print_'+jsonData.id_barang+'">'+
        '<td>'+jsonData.nama_barang+'</td>'+
        '<td class="print_jmlh text-center">'+banyak+'</td>'+
        '<td class="print_harga_satuan text-right">'+Rp(jsonData.harga)+'</td>'+
        '<td class="print_harga text-right">'+Rp(jsonData.harga)+'</td>'+
        '</tr>';
        $('#print .setdata').append(dataprint);
    })
}

function total(id){
    var harga = $('#'+id+' #harga_key').val(),
        banyak = $('#'+id+' #banyak').val(),
        total = 0;
    if(banyak==''){
        banyak = 1;
    }
    total = parseInt(banyak) * parseInt(harga);
    $('#'+id+' #harga').val(total);
    $('#'+id+' #lbl_harga').text(Rp(total));
    tot_bayar();

    console.log(harga);
    $('#print_'+id+ ' .print_jmlh').text(banyak);
    $('#print_'+id+ ' .print_harga').text(Rp(total));
    $('#print_'+id+ ' .print_harga_satuan').text(Rp(harga));
}

function batal(id){
    $('#'+id).remove();
    $('#print_'+id).remove();
    tot_bayar();
}

var rupiah = document.getElementById("lbl_bayar");
rupiah.addEventListener("keyup", function(e) {
    $('#bayar').val(this.value.split(".").join(''));
    rupiah.value = formatRupiah(this.value, "Rp. ");

    var totbyr = $('#totbyr').val(), 
        sisa = 0,
        hitdiskon = 0,
        hrgdiskon = 0,
        bayar = $('#bayar').val(),
        diskon = $('#diskon').val();
    hitdiskon = diskon * totbyr / 100;
    hrgdiskon = totbyr - hitdiskon;
    // hrgdiskon = totbyr - diskon;
    sisa = parseInt(bayar) - parseInt(hrgdiskon);
    if(bayar==''){
        $('#sisa').val(0);
        $('#lbl_sisa').val(Rp(0));
    }else{
        $('#sisa').val(sisa);
        $('#lbl_sisa').val(Rp(sisa));
    }

    tot_bayar();
});
function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
}


function Rp(bilangan){
    var	reverse = bilangan.toString().split('').reverse().join(''),
        ribuan 	= reverse.match(/\d{1,3}/g);
        ribuan	= ribuan.join('.').split('').reverse().join('');
    return ribuan;
}
</script>