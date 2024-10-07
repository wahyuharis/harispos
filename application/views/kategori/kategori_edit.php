<div class="card">
    <div class="card-body">
        <form id="form_1">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori*</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= $nama_kategori ?>">
                    </div>



                </div>
                <div class="col-md-4">



                </div>
                <div class="col-md-4 pl-4">

                </div>
            </div>
            <div style="text-align: end;">

                <button type="submit" class="btn btn-primary">save</button>
                <a class="btn btn-secondary" href="<?= base_url('kategori') ?>">Kembali</a>
            </div>
            (*) Wajib Diisi
        </form>
    </div>
</div>
<?php require_once 'kategori_edit_script.php' ?>