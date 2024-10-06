<div class="card">
    <div class="card-body">
        <form id="form_1">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="nama_kontak">Nama Kontak</label>
                        <input type="text" class="form-control" id="nama_kontak" name="nama_kontak" value="<?= $nama_kontak ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone">phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $phone ?>">
                    </div>

                    <div class="form-group">
                        <label for="whatsapp">whatsapp</label>
                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="<?= $whatsapp ?>">
                    </div>


                </div>
                <div class="col-md-4">

                    <div class="form-group">
                        <label for="email">email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $email ?>">
                    </div>

                    <div class="form-group">
                        <label for="id_kota">Kota</label>
                        <?= form_dropdown('id_kota', $opt_kota, $id_kota, ' class="form-control" id="id_kota" ') ?>
                    </div>

                    <div class="form-group">
                        <label for="alamat">alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat"><?= $alamat ?></textarea>
                    </div>

                </div>
                <div class="col-md-4 pl-4">
                    <?php
                    $checked = "";
                    if ($is_customer) {
                        $checked = "checked";
                    }
                    ?>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="is_customer" id="is_customer" value="1" <?= $checked ?>>
                        <label class="custom-control-label" for="is_customer">Adalah Customer</label>
                    </div>
                    <br>

                    <?php
                    $checked = "";
                    if ($is_supplier) {
                        $checked = "checked";
                    }
                    ?>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="is_supplier" id="is_supplier" value="1" <?= $checked ?>>
                        <label class="custom-control-label" for="is_supplier">Adalah Supplier</label>
                    </div>
                    <br>

                    <?php
                    $checked = "";
                    if ($is_karyawan) {
                        $checked = "checked";
                    }
                    ?>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" name="is_karyawan" id="is_karyawan" value="1" <?= $checked ?>>
                        <label class="custom-control-label" for="is_karyawan">Adalah Karyawan</label>
                    </div>

                </div>
            </div>
            <div style="text-align: end;">
                <button type="submit" class="btn btn-primary">save</button>
                <a class="btn btn-secondary" href="<?= base_url('kontak') ?>">Kembali</a>
            </div>

        </form>
    </div>
</div>
<?php require_once 'kontak_edit_script.php' ?>