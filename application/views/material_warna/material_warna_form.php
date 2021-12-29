<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="varchar">Kode Warna <?php echo form_error('kode_warna') ?></label>
        <input type="text" class="form-control" name="kode_warna" id="kode_warna" placeholder="Kode Warna" value="<?php echo $kode_warna; ?>" readonly/>
    </div>
    <!-- <div class="form-group">
        <label for="varchar">Ukuran <?php echo form_error('ukuran') ?></label>
        <input type="text" class="form-control" name="ukuran" id="ukuran" placeholder="Ukuran" value="<?php echo $ukuran; ?>" />
    </div>
    <div class="form-group">
        <label for="int">Berat (Kg)<?php echo form_error('berat') ?></label>
        <input type="text" class="form-control" name="berat" id="berat" placeholder="Berat" value="<?php echo $berat; ?>" />
    </div> -->
    <!-- <div class="form-group">
        <label for="int">Foto Barang </label>
        <input type="file" class="form-control" name="foto_barang" />
    </div> -->
    <div class="form-group">
        <label for="int">Warna </label>
        <input type="text" class="form-control" name="warna" id="warna" placeholder="Warna" value="<?php echo $warna; ?>" />
    </div>

    <!-- <div class="form-group">
        <label for="int">Harga </label>
        <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo number_format($harga,0,',','.'); ?>" />
    </div> -->

    <input type="hidden" name="id_warna" value="<?php echo $id_warna; ?>" /> 
    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    <a href="<?php echo site_url('material_warna') ?>" class="btn btn-default">Batalkan</a>
</form>
