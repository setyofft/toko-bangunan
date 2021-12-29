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
<form action="<?php echo $action; ?>" method="post">
    <div class="form-group">
        <label for="varchar">Kode Barang <?php echo form_error('kode_barang') ?></label>
        <select name="kode_barang" class="form-control search-select" data-live-search="true" data-title="Pilih Barang">
            <?php 
            $this->db->order_by('id_barang', 'DESC');
            $sql = $this->db->get('barang');
            foreach ($sql->result() as $row) {
                ?>
            <option <?php if ($kode_barang == $row->kode_barang ) echo 'selected';?> value="<?php echo $row->kode_barang ?>"><?php echo $row->nama_barang ?></option>
        <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="varchar">Kode Supplier <?php echo form_error('kode_supplier') ?></label>
        <select name="kode_supplier" class="form-control search-select" data-live-search="true" data-title="Pilih Supplier">
            <?php 
            $this->db->order_by('id_supplier', 'DESC');
            $sql = $this->db->get('supplier');
            foreach ($sql->result() as $row) {
                ?>
            <option <?php if ($kode_supplier == $row->nama_supplier ) echo 'selected';?> value="<?php echo $row->nama_supplier ?>"><?php echo $row->nama_supplier ?></option>
        <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="int">Jumlah <?php echo form_error('jumlah') ?></label>
        <input type="text" class="form-control" name="jumlah" id="jumlah" placeholder="Jumlah" value="<?php echo $jumlah; ?>" autocomplete="off"/>
    </div>
    <div class="form-group">
        <label for="int">Harga Baru<?php echo form_error('harga') ?></label>
        <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php if($harga==''){ echo 0;}else{ echo $harga;}; ?>" />
    </div>
    <div class="form-group">
        <label for="date">Tgl Masuk <?php echo form_error('tgl_masuk') ?></label>
        <input type="date" class="form-control tgl" name="tgl_masuk" id="tgl_masuk" placeholder="Tanggal Masul" value="<?php echo $tgl_masuk; ?>" />
    </div>
    <input type="hidden" name="id_barang_masuk" value="<?php echo $id_barang_masuk; ?>" />
    <input type="hidden" name="jml_awal" value="<?php echo $jumlah; ?>" /> 
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    <a href="<?php echo site_url('barang_masuk') ?>" class="btn btn-default">Cancel</a>
</form>
<script type="text/javascript" src="assets/select/js/bootstrap-select.min.js"></script>
<script>
    $('.search-select').selectpicker();
    var rupiah = document.getElementById("harga");
    rupiah.addEventListener("keyup", function(e) {
        rupiah.value = formatRupiah(this.value, "");    
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "" + rupiah : "";
    }

</script>