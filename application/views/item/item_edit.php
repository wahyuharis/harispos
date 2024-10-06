<div class="card">
    <div class="card-body">
        <form id="form_1">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="barcode">Barcode</label>
                        <input type="text" class="form-control" id="barcode" name="barcode" value="<?= $barcode ?>">
                    </div>

                    <div class="form-group">
                        <label for="nama_item">Nama Item</label>
                        <input type="text" class="form-control" id="nama_item" name="nama_item" value="<?= $nama_item ?>">
                    </div>

                    <div class="form-group">
                        <label for="id_kategori">Kategori</label>
                        <?= form_dropdown('id_kategori', $opt_kategori, $id_kategori, ' class="form-control" id="id_kategori" ') ?>

                    </div>

                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <input type="text" maxlength="5" class="form-control" id="satuan" name="satuan" value="<?= $satuan ?>">
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="text" class="form-control thousand" id="harga_beli" name="harga_beli" value="<?= $harga_beli ?>">
                    </div>

                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="text" class="form-control thousand" id="harga_jual" name="harga_jual" value="<?= $harga_jual ?>">
                    </div>

                    <div class="form-group">

                        <br>
                        <?php
                        $checked = "";
                        if ($hitung_stock) {
                            $checked = "checked";
                        }
                        ?>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="hitung_stock" id="hitung_stock" value="1" <?= $checked ?>>
                            <label class="custom-control-label" for="hitung_stock">Hitung Stock</label>
                        </div>
                        <br>
                    </div>



                </div>
                <div class="col-md-4 pl-4">
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control"><?= $keterangan ?></textarea>
                    </div>


                </div>
            </div>
            <div style="text-align: end;">

                <button type="submit" class="btn btn-primary">save</button>
                <a class="btn btn-secondary" href="<?= base_url('item') ?>">Kembali</a>
            </div>
        </form>
    </div>
</div>
<?php require_once 'item_edit_script.php' ?>