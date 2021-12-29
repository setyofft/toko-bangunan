<style>
    .active {
        left: 0%;
    }
</style>
<form action="<?php echo $action; ?>" method="post">
    <div class="form-group">
        <label for="varchar">Kode Barang <?php echo form_error('kode_barang') ?></label>
        <!-- <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Barang" value="<?php echo $kode_barang; ?>" /> -->
            <select name="kode_barang" id="kode_barang" class="form-control search-select" data-live-search="true" data-title="Pilih Barang">
            <?php 
            $this->db->order_by('id_barang', 'DESC');
            $sql = $this->db->get('barang');
            foreach ($sql->result() as $row) {
                ?>
            <option <?php if ($kode_barang == $row->kode_barang ) echo 'selected';?> value="<?php echo $row->kode_barang ?>"><?php echo $row->nama_barang ?></option>
        <?php } ?>
        </select>
        <span id="satuan" style="font-size: 9pt;font-weight: bold;">Harga Satuan</span>
    </div>
    <div class="form-group">
        <label for="date">Tgl Keluar <?php echo form_error('tgl_keluar') ?></label>
        <input type="date" class="form-control tgl" name="tgl_keluar" id="tgl_keluar" placeholder="Tgl Keluar" value="<?php echo $tgl_keluar; ?>" />
    </div>
    <div class="form-group">
        <label for="int">Jumlah <?php echo form_error('jumlah') ?></label>
        <input autocomplete="off" type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php if($jumlah==''){ echo 0;}else{ echo $jumlah;} ?>" />
    </div>
    <div class="form-group">
        <label for="int">Total Harga <?php echo form_error('tot_harga') ?></label>
        <input type="text" class="form-control" name="tot_harga" id="tot_harga" placeholder="Total Harga" value="<?php echo number_format($tot_harga,0,',','.'); ?>" readonly/>
    </div>
    <input type="hidden" id="harga" /> 
    <input type="hidden" name="jml_awal" value="<?php echo $jumlah; ?>" /> 
    <input type="hidden" name="id_barang_keluar" value="<?php echo $id_barang_keluar; ?>" /> 
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    <a href="<?php echo site_url('barang_keluar') ?>" class="btn btn-default">Cancel</a>
</form>

<script type="text/javascript" src="assets/select/js/bootstrap-select.min.js"></script>
<script>
    $('.search-select').selectpicker();
    $('#kode_barang').on('change',function(){
        var uri = '<?=site_url()?>';
        var kd = $(this).val();
        $.ajax({
            method: "POST",
            url: uri+'barang_keluar/ambil_hrg',
            data: { kd: kd},
            beforeSend: function( xhr ) {
                $('.loading').show();
            }
        })
        .done(function(data) {
            $('.loading').hide();
            var jsonData = $.parseJSON(data);
            for(i=0; i< jsonData.length; i++){
                $('#satuan').text('Harga Satuan '+Rp(jsonData[i].harga));
                $('#harga').val(jsonData[i].harga);
                $('#satuan').css('display','block');
            }
        });
    })
    if( '<?=$button?>'!='Simpan'){
        $('#satuan').css('display','none');
        $('#kode_barang').trigger('change');
    }
    
    $('#jumlah').on('keyup', function(){
        var hrg = $('#harga').val();
       
        if($(this).val()==''){
            $('#tot_harga').val(Rp(hrg));
        }else{
            var totharga = parseInt(hrg) * parseInt($(this).val());
            $('#tot_harga').val(Rp(totharga));
        }
        
    })
    $('#jumlah').trigger('keyup');
 
    function Rp(bilangan){
        var	reverse = bilangan.toString().split('').reverse().join(''),
            ribuan 	= reverse.match(/\d{1,3}/g);
            ribuan	= ribuan.join('.').split('').reverse().join('');
        return ribuan;
    }
</script>