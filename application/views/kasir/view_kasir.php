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
.text-red{
    color: red;
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

<div class="row">
    <div class="col-md-6">
        <h5>Transaksi hari ini</h5>
        <div class="row" style="margin-bottom: 0px;">
            <div class="col-md-6">
                <input id="search_transaksi" autocomplete="off" type="text" class="form-control" placeholder="Cari Nama Pembeli">
            </div>
            <div class="col-md-6 text-right">
                <button style="padding:0px;width:70%;height: 38px;" type="button" class="btn btn-primary" id="tambah_pembelian">
                    <b>Tambah Pembelian</b>
                </button>
            </div>
        </div>
        <div>
            <table class="table" id="list_transaksi">
                <thead>
                    <th>No</th>
                    <th>Kode Pembelian</th>
                    <th>Nama Pembeli</th>
                    <th class="text-right">Total Pembelian</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody id="data_transaksi"></tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <h5 class="text-center">Detail Nota</h5>
        <div class="card" style="border:1px solid gray;padding: 10px;" id="detail_nota">
            <h6 class="text-center">Tidak ada data nota yang di pilih</h6>
        </div>
    </div>
</div>


<script>
$('#search_transaksi').keyup(function(){
    search_transaksi($(this).val());
})

$('#tambah_pembelian').click(function(){
    window.location.href = '<?=base_url()?>transaksi';
})
function search_transaksi(value){
    $('#list_transaksi #data_transaksi tr').each(function(){
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

list_transaksi();
async function list_transaksi(){
    await $.ajax({
        method: "POST",
        url: '<?=base_url()?>kasir/list_transaksi_now',
        data: {},
        beforeSend: function( xhr ) {
            $('.loading').show();
        }
    }).done(function(data) {
        var jsonData = $.parseJSON(data);
        var html = '';
        var no = 1;
        var total = 0;
        var lunas = '';
        for (let i = 0; i < jsonData.length; i++) {
            if(jsonData[i].ket=='Lunas'){
                lunas = '';
            }else{
                lunas = 'Lunasi';
            }
            html += '<tr>'+
                '<td class="text-center">'+no+'</td>'+
                '<td>'+jsonData[i].kode_transaksi+'</td>'+
                '<td>'+jsonData[i].nama_pembeli+'</td>'+
                '<td class="text-right">'+Rp(jsonData[i].total_harga)+'</td>'+
                '<td><a href="javascript:void(0)" onclick="view_nota('+jsonData[i].id_transaksi+')">Lihat Nota</td>'+
                '<td><a href="javascript:void(0)" onclick="lunasi('+jsonData[i].id_transaksi+')">'+lunas+'</td>'+
            '</tr>';
            no++;
            total += parseInt(jsonData[i].total_harga);
        }
        html += '<tr>'+
            '<td colspan="3"><b>Total</b></td>'+
            '<td class="text-right text-red"><b>'+Rp(total)+'</b></td>'+
        '</tr>';
        $('#data_transaksi').html(html)
    });
}

async function view_nota(id){
    await $.ajax({
        method: "POST",
        url: '<?=base_url()?>kasir/detail_nota',
        data: {id:id},
        beforeSend: function( xhr ) {
            $('.loading').show();
        }
    }).done(function(data) {
        var jsonData = $.parseJSON(data);
        var html = '';
        html += '<h5 class="text-center" style="margin:0px 3px 0px 0px">'+$('#nmusaha').val()+'</h5>';
        html += '<h6 class="text-center" style="margin:3px 0px 10px 0px;">'+$('#nmjln').val()+'</h6>'; 
        html += '<h6 class="text-center" style="margin:0px 0px 0px 0px;">'+$('#notelp').val()+'</h6>'; 
        html += '<hr style="margin: 10px;"/>';
        html += '<h6 style="margin:0px" class="text-center">Data Pembeli</h6>';
        
        html += '<p style="font-size:7pt;margin:5px"><b>Nama Pembeli:</b> '+jsonData[0].nama_pembeli+'</p>'+
        '<p style="font-size:7pt;margin:5px"><b>No Telp. Pembeli:</b> '+jsonData[0].nohp_pembeli+'</p>'+
        '<p style="font-size:7pt;margin:5px"><b>Alamat Pembeli:</b> '+jsonData[0].alamat+'</p>'+
        '<p style="font-size:7pt;margin:5px"><b>Kode Transaksi:</b> '+jsonData[0].kode_transaksi+'</p>'+
        '<p style="font-size:7pt;margin:5px"><b>Tanggal Transaksi:</b> '+jsonData[0].tgl_transaksi+'</p>'+
        '<p style="font-size:7pt;margin:5px"><b>Keterangan:</b> '+jsonData[0].ket+'</p>';

        html+= '<div style="margin-top:10px">';
        html += '<table class="table">'+
        '<tr>'+
            '<th>Barang</th>'+
            '<th class="text-center">Banyak</th>'+
            '<th class="text-right">Harga Satuan</th>'+
            '<th class="text-right">Harga Total</th>'+
        '</tr>';
        for (let i = 0; i < jsonData.length; i++) {
            html += '<tr id="print_'+jsonData[i].id_barang+'">'+
                '<td>'+jsonData[i].nama_barang+'</td>'+
                '<td class="print_jmlh text-center">'+jsonData[i].jumlah+'</td>'+
                '<td class="print_jmlh text-center">'+Rp(jsonData[i].harga_satuan)+'</td>'+
                '<td class="print_harga text-right">'+Rp(jsonData[i].tot_harga)+'</td>'+
            '</tr>';
        }
        var min = '';
        if(jsonData[0].ket=='Lunas'){
            min = '';
        }else{
            min = '- ';
        }
        html += '<tr>'+
            '<td colspan="3"><b>Total</b></td>'+
            '<td class="text-right">'+Rp(jsonData[0].total_harga)+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td colspan="3"><b>Bayar</b></td>'+
            '<td class="text-right">'+Rp(jsonData[0].bayar)+'</td>'+
            '</tr>'+
            '<tr>'+
            '<td colspan="3"><b>Diskon</b></td>'+
            '<td class="text-right">'+jsonData[0].diskon+'%</td>'+
            '</tr>'+
            '<tr>'+
            '<td colspan="3"><b>Kembali</b></td>'+
            '<td class="text-right">'+min+Rp(jsonData[0].sisa)+'</td>'+
        '</tr>';
        html +='</table></div>';
        $('#detail_nota').html(html);
        $('.loading').hide();
    });
}

function lunasi(id){
    swal({
        title: "",
        text: "Yakin ingin lunasi data ini ?",
        icon: "warning",
        buttons: {
            confirm : {text:'Ya',className:'sweet-warning'},
            cancel : 'Tidak'
        },
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                method: "POST",
                url: '<?=base_url()?>kasir/lunasi',
                data: {id:id},
                beforeSend: function( xhr ) {
                    $('.loading').show();
                }
            }).done(function(data) {
                window.location.href = '<?=base_url("kasir")?>';
            })
        } 
    });
}

function Rp(bilangan){
    var	reverse = bilangan.toString().split('').reverse().join(''),
        ribuan 	= reverse.match(/\d{1,3}/g);
        ribuan	= ribuan.join('.').split('').reverse().join('');
    return ribuan;
}
</script>