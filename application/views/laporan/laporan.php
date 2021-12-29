<style>
.active{
    left: 0;
}
</style>
<label>Flter Laporan Transaksi:</label>
<div style="width:230px">
    <select name="jns_laporan" id="jns_laporan" class="form-control search-select">
    <option value="">-Pilih Jenis Laporan-</option>
        <option value="barang_masuk">Barang Masuk</option>
        <option value="barang_keluar">Barang Keluar</option>
    </select>
</div>
<div class="row" style="margin-top: 5%;">
	
    <div class="col-md-4 col-lg-4 col-xs-4">
        <div style="position: absolute;top: -27px;">
            <input type="radio" id="brg" name="jns" checked>&nbsp;Barang&nbsp;&nbsp;
            <input type="radio" id="jns" name="jns">&nbsp;Jenis Barang
            <button type="button" class="btn label label-success" style="margin-left: 10px;" id="reset">Reset</button>
        </div>
        <div id="dowjns">
            <select name="jenis" id="id_jenis" class="form-control search-select" data-live-search="true" data-title="Semua Jenis Barang">
                <?php 
                $sql = $this->db->get('jenis_barang');
                foreach ($sql->result() as $row) { ?>
                <option value="<?php echo $row->id_jenis ?>"><?php echo $row->jenis_barang ?></option>
                <?php } ?>
            </select>
        </div>
        <div id="dowbrg">
            <select name="barang" id="kode_barang" class="form-control search-select" data-live-search="true" data-title="Semua Barang">
                <?php 
                $sql = $this->db->get('barang');
                foreach ($sql->result() as $row) {
                    ?>
                <option value="<?php echo $row->kode_barang ?>"><?php echo $row->nama_barang ?></option>
            <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-4 col-lg-4 col-xs-4">
        <label style="position: absolute;top: -27px;">Tanggal Dari</label>
        <input type="date" class="form-control tgl" name="tgl_dari" id="tgl_dari" placeholder="Tgl Transaksi" />
    </div>
    <div class="col-md-4 col-lg-4 col-xs-4">
    <label style="position: absolute;top: -27px;">Tanggal Sampai</label>
        <input type="date" class="form-control tgl" name="tgl_sampai" id="tgl_sampai" placeholder="Tgl Transaksi" />
    </div>
    
    
    <div class="col-md-12 col-lg-12 col-xs-12 text-right">
        <button type="button" class="btn btn-primary" id="tampilkan" style="width: 95px;height: 49px;">Tampilkan</button>
        <!-- <button type="button" class="btn btn-info" id="export" style="height: 49px;">export</button> -->
    </div>
</div>

<table class="table table-bordered" style="margin-bottom: 10px;display:none">
    <tr>
        <th class="text-center" style="width: 10px;">No</th>
        <th style="width: 250px;">Nama Barang</th>
        <th class="text-center" style="width: 10px;">Stok</th>
        <th id="lbl_stok" class="text-center" style="width: 100px;">Stok Masuk</th>
        <th class="text-right" style="width: 120px;">Harga</th>
        <th id="jns_msk" class="text-right" style="width: 120px;">Perubahan Harga</th>
        <th id="lbl_tgl" class="text-center" style="width: 128px;">Tanggal Masuk</th>
        <th id="nmpem">Nama Pembeli</th>
        <th id="nohppem">No Telp Pembeli</th>
        <th id="alamatpem">Alamat Pembeli</th>
    </tr>
    <tbody id="datatabel">
        <!-- <tr>
            <td class="text-center" colspan="7"><b>Data Belum Di Tampilkan</b></td>
        </tr> -->
    </tbody>
    <tr id="datatotal">
        
    </tr>
</table>
<script type="text/javascript" src="assets/select/js/bootstrap-select.min.js"></script>
<script>
    $('.search-select').selectpicker();

    if($("#brg").is(":checked")){
        $('#dowjns').css('display','none');
    }

    $('#reset').click(function(){
        $('#kode_barang').val('').trigger('change');
        $('#id_jenis').val('').trigger('change');
    })

    $('input[type=radio]').on('change', function(){
        if($("#jns").is(":checked")){
            $('#dowbrg').css('display','none');
            $('#dowjns').css('display','block');
            $('#kode_barang').val('').trigger('change');
        }else if($("#brg").is(":checked")){
            $('#dowjns').css('display','none');
            $('#dowbrg').css('display','block');
            $('#id_jenis').val('').trigger('change');
        }
    })

    $('#export').attr("disabled", true);
    $('#tampilkan').click(function(){
        $('#datatabel').html('');
        var jns_tran = $('#jns_laporan').val();
        var id_jns_brg = $('#id_jenis').val();
        var kode_barang = $('#kode_barang').val();
        var tgl_dari = $('#tgl_dari').val();
        var tgl_sampai = $('#tgl_sampai').val();
        var uri = '<?=site_url()?>';
        var html='', html1='';
        if(jns_tran=='' || tgl_dari=='' || tgl_sampai==''){
            swal({
                title: "",
                text:"Jenis Transaksi, Tanggal Dari dan Tanggal Sampai harus diisi !",
                icon: "warning",
            });
        }else{
        $.ajax({
            method: "POST",
            url: uri+'laporan/load_transaksi',
            data: { jns_tran: jns_tran, id_jns_brg: id_jns_brg, tgl_dari:tgl_dari,tgl_sampai:tgl_sampai, kode_barang:kode_barang },
            beforeSend: function( xhr ) {
                $('.loading').show();
            }
        })
        .done(function(data) {
            $('.table').css('display','block');
            $('.loading').hide();
            var p_hrg='';
            var nmpem = '', nohpepem='',alamatpem='', ket='';
            var no=1;
            var tothrg=0, totstok=0, peru_hrg=0, jum_keluar=0, hrgall=0;
            var jsonData = $.parseJSON(data);
            var tagharga = '';
            console.log(jsonData)
            if(jsonData.length!=0){
            for(i=0; i< jsonData.length; i++){
                if(jns_tran=='barang_keluar'){
                    // $('#jns_msk').css('display','none');
                    $('#lbl_stok').text('Jumlah Keluar');
                    $('#lbl_tgl').text('Tanggal Keluar');
                    totstok +=parseInt(jsonData[i].stok);
                    jum_keluar +=parseInt(jsonData[i].jumlah);
                    tothrg +=parseInt(jsonData[i].harga_satuan);
                    hrgall += parseInt(jsonData[i].tot_harga);
                    nmpem = '<td class="text-left">'+jsonData[i].nama_pembeli+'</td>';
                    nohppem = '<td class="text-left">'+jsonData[i].nohp_pembeli+'</td>';
                    alamatpem = '<td class="text-left">'+jsonData[i].alamtpem+'</td>';
                    ket = '<td class="text-left">'+jsonData[i].ket+'</td>';
                    p_hrg='<td class="text-right">-</td>';
                    tagharga = '<td class="text-right"><b>'+Rp(jsonData[i].harga_satuan)+'</br><b>'+Rp(parseInt(jsonData[i].tot_harga))+'</b></td>';
                }else if(jns_tran=='barang_masuk'){
                    // $('#jns_msk').css('display','block');
                    $('#lbl_stok').text('Stok Masuk');
                    $('#lbl_tgl').text('Tanggal Masuk');
                    // $('#nmpem').css('display','none');
                    // $('#nohppem').css('display','none');
                    // $('#alamatpem').css('display','none');
                    p_hrg = '<td class="text-right">'+jsonData[i].hrg_perubahan+'</td>';
                    totstok +=parseInt(jsonData[i].stok);
                    jum_keluar +=parseInt(jsonData[i].jumlah);
                    tothrg +=parseInt(jsonData[i].harga);
                    peru_hrg +=parseInt(jsonData[i].hrg_perubahan);
                    hrgall += parseInt(jsonData[i].harga) * parseInt(jsonData[i].jumlah);
                    nmpem = '<td class="text-left">-</td>';
                    nohppem = '<td class="text-left">-</td>';
                    alamatpem = '<td class="text-left">-</td>';
                    ket = '<td class="text-left">-</td>';
                    tagharga = '<td class="text-right"><b>'+Rp(jsonData[i].harga)+'</br><b>'+Rp(parseInt(jsonData[i].harga)*parseInt(jsonData[i].jumlah))+'</b></td>';
                }
                html +='<tr><td class="text-center">'+(no++)+'</td>'+
                '<td>'+jsonData[i].kode_barang+'</br><b>'+jsonData[i].nama_barang+'</b></td>'+
                '<td class="text-center">'+jsonData[i].stok+'</td>'+
                '<td class="text-center">'+jsonData[i].jumlah+'</td>'+
                tagharga+
                p_hrg+
                '<td class="text-center">'+format_tgl(jsonData[i].tgl)+'</td>'+
                nmpem+
                nohppem+
                alamatpem+
                ket+
                '</tr>';
              
            }
                if(jns_tran=='barang_keluar'){
                    html1 = '<td colspan="2"><b>Total</b></td>'+
                    '<td class="text-center"><b>'+totstok+'</b></td>'+
                    '<td class="text-center"><b>'+jum_keluar+'</b></td>'+
                    '<td class="text-right">> '+Rp(tothrg)+'</br><b>'+Rp(hrgall)+'</b></td>'+
                    '<td class="text-right"><b></b></td>'+
                    '<td colspan="4"></td>';
                }else if(jns_tran=='barang_masuk'){
                    html1 = '<td colspan="2"><b>Total</b></td>'+
                    '<td class="text-center"><b>'+totstok+'</b></td>'+
                    '<td class="text-center"><b>'+jum_keluar+'</b></td>'+
                    '<td class="text-right"><b>'+Rp(tothrg)+'</br><b>'+Rp(hrgall)+'</b></td>'+
                    '<td class="text-right"><b>'+peru_hrg+'</b></td>'+
                    '<td></td>';
                }
            }else{
                html = '<tr><td class="text-center" colspan="10"><b>Data Kosong</b></td></tr>';
            }
            
            $('#datatabel').append(html);
            $('#datatotal').html(html1);
            $('#export').attr("disabled", false);
        });
        }
    })

    $('#export').click(function(){
        $('.loading').show();
        var jns_tran = $('#jns_laporan').val();
        var id_jns_brg = $('#id_jenis').val();
        var kode_barang = $('#kode_barang').val();
        var tgl_dari = $('#tgl_dari').val();
        var tgl_sampai = $('#tgl_sampai').val();
        var uri = '<?=site_url()?>';
        if(jns_tran=='' || tgl_dari=='' || tgl_sampai==''){
            $('.loading').hide();
            swal({
                title: "",
                text:"Jenis Transaksi, Tanggal Dari dan Tanggal Sampai harus diisi !",
                icon: "warning",
            });
        }else{
            if(id_jns_brg==''){ id_jns_brg = 'kosong'; }else{ id_jns_brg = id_jns_brg; }
            if(kode_barang==''){ kode_barang = 'kosong'; }else{ kode_barang = kode_barang; }

            window.open(uri+'laporan/export_pdf/' + jns_tran+'/'+id_jns_brg+'/'+tgl_dari+'/'+tgl_sampai+'/'+kode_barang, '_blank');
            $('.loading').hide();
        }
    })

    function Rp(bilangan){
        var	reverse = bilangan.toString().split('').reverse().join(''),
            ribuan 	= reverse.match(/\d{1,3}/g);
            ribuan	= ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }
    function format_tgl(tgl) { 
        var today = new Date(tgl),
            date = today.toJSON().slice(0, 10),
            nDate = date.slice(8, 10) + '-'  
                    + date.slice(5, 7) + '-'  
                    + date.slice(0, 4); 
        return nDate; 
    } 
</script>