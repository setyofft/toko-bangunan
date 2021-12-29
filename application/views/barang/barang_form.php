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
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6 col-lg-6 col-xs-6">
            <div class="form-group">
                <label for="varchar">Kode Barang <?php echo form_error('kode_barang') ?></label>
                <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Barang" value="<?php echo $kode_barang; ?>" readonly/>
            </div>
            <div class="form-group">
                <label for="varchar">Nama Barang <?php echo form_error('nama_barang') ?></label>
                <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?php echo $nama_barang; ?>" />
            </div>
            
            <!-- <div class="form-group">
                <label for="int">Foto Barang </label>
                <input type="file" class="form-control" name="foto_barang" />
            </div> -->
            <div class="form-group">
                <label for="int">Jenis Barang </label>
                <select name="id_jenis" class="form-control search-select" data-live-search="true" data-title="Pilih Jenis Barang">
                    <?php 
                    $sql = $this->db->get('jenis_barang');
                    foreach ($sql->result() as $row) {
                        ?>
                    <option <?php if ($id_jenis == $row->id_jenis ) echo 'selected';?> value="<?php echo $row->id_jenis ?>"><?php echo $row->jenis_barang ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="int">Merk Barang </label>
                <select name="id_merk" class="form-control search-select" data-live-search="true" data-title="Pilih Merk Barang">
                    <?php 
                    $sql = $this->db->get('merk_barang');
                    foreach ($sql->result() as $row) {
                        ?>
                    <option <?php if ($id_merk == $row->id_merk ) echo 'selected';?> value="<?php echo $row->id_merk ?>"><?php echo $row->merk_barang ?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="int">Material Warna </label>
                <select name="id_warna" class="form-control search-select" data-live-search="true" data-title="Pilih Material Warna">
                    <?php 
                    $sql = $this->db->get('material_warna');
                    foreach ($sql->result() as $row) {
                        ?>
                    <option <?php if ($id_warna == $row->id_warna ) echo 'selected';?> value="<?php echo $row->id_warna ?>">
                        <?php echo strtoupper($row->warna)?>
                    </option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="int">Supplier </label>
                <select name="kode_supplier" class="form-control search-select" data-live-search="true" data-title="Pilih Supplier">
                    <?php 
                    $sql = $this->db->get('supplier');
                    foreach ($sql->result() as $row) {
                        ?>
                    <option <?php if ($kode_supplier == $row->nama_supplier ) echo 'selected';?> value="<?php echo $row->nama_supplier ?>"><?php echo $row->nama_supplier ?></option>
                <?php } ?>
                </select>
            </div>

        </div>
        <div class="colmd-6 col-lg-6 col-xs-6">
        
            <div class="form-group">
                <label for="int">Stok <?php echo form_error('stok') ?></label>
                <input type="text" class="form-control" name="stok" id="stok" placeholder="Stok Barang" value="<?php echo $stok; ?>" />
            </div>

            <div class="form-group">
                <label for="int">Ukuran <?php echo form_error('ukuran') ?></label>
                <input type="text" class="form-control" name="ukuran" id="ukuran" placeholder="Ukuran Barang" value="<?php echo $ukuran; ?>" />
            </div>

            <div class="form-group">
                <label for="int">Berat <?php echo form_error('berat') ?></label>
                <input type="text" class="form-control" name="berat" id="berat" placeholder="Berat Barang" value="<?php echo $berat; ?>" />
            </div>

            <div class="form-group">
                <label for="int">Harga Barang<?php echo form_error('harga') ?></label>
                <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo number_format($harga,0,',','.'); ?>" />
            </div>

            <div class="form-group">
                <label for="int">Keterangan <?php echo form_error('keterangan') ?></label>
                <textarea class="form-control" name="keterangan" id="" cols="5" rows="5"><?php echo $keterangan; ?></textarea>
            </div>
        </div>
    </div>
    
    <input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>" /> 
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    <a href="<?php echo site_url('barang') ?>" class="btn btn-default">Batalkan</a>
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