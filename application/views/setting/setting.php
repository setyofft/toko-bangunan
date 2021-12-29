<?php
if($this->session->userdata('message')!=''){ ?>
<div class="alert alert-info alert-dismissable set-alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Berhasil !</strong> <?=$this->session->userdata('message')?>
</div>
<?php } ?>
    <div class="row">
    <form action="<?php echo $action; ?>" method="post">
        <div class="col-md-6">
            <div class="form-group">
                <label for="varchar">Nama Usaha <?php echo form_error('nm_usaha') ?></label>
                <input type="text" class="form-control" name="nm_usaha" id="nm_usaha" value="<?php echo $nm_usaha;?>" placeholder="Nama Usaha" />
            </div>
            <div class="form-group">
                <label for="varchar">No Telp. <?php echo form_error('notelp') ?></label>
                <input type="text" class="form-control" name="notelp" id="notelp" value="<?php echo $notelp;?>" placeholder="No Telphone" />
            </div>
            <div class="form-group">
                <label for="varchar">Fax <?php echo form_error('fax') ?></label>
                <input type="text" class="form-control" name="fax" id="fax" value="<?php echo $fax;?>" placeholder="No Fax" />
            </div>
            <div class="form-group">
                <label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
                <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3"><?=$alamat?></textarea>
            </div>
            <input type="hidden" name="id_setting" value="<?php echo $id_setting; ?>" /> 
            <button type="submit" class="btn btn-primary" id="simpan"><?php echo $button ?></button> 
            <a href="<?php echo site_url('users') ?>" class="btn btn-default">Cancel</a>     
        </div>
    </form>
        <div class="col-md-6">
            <div class="form-group">
                <label for="varchar">Nama Usaha <?php echo form_error('nm_usaha') ?></label>
                <input type="text" class="form-control" name="nm_usaha" placeholder="Nama Usaha" value="<?php echo $nm_usaha;?>" readonly/>
            </div>
            <div class="form-group">
                <label for="varchar">No Telp. <?php echo form_error('notelp') ?></label>
                <input type="text" class="form-control" name="notelp" placeholder="Username" value="<?php echo $notelp;?>" readonly/>
            </div>
            <div class="form-group">
                <label for="varchar">Fax <?php echo form_error('fax') ?></label>
                <input type="text" class="form-control" name="fax" placeholder="Password" value="<?php echo $fax;?>" readonly/>
            </div>
            <div class="form-group">
                <label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
                <textarea class="form-control" name="alamat" cols="30" rows="3" readonly><?=$alamat?></textarea>
            </div>
        </div>
    </div>


<script>
    setTimeout(function(){
        $('.set-alert').css('display','none');
    }, 3000);
</script>