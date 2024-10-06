<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tr>
                        <td><?= label2('nama_kontak') ?></td>
                        <td>:</td>
                        <td><?= $nama_kontak ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('kota') ?></td>
                        <td>:</td>
                        <td><?= $nama_kota ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('phone') ?></td>
                        <td>:</td>
                        <td><?= $phone ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('whatsapp') ?></td>
                        <td>:</td>
                        <td><?= $whatsapp ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('email') ?></td>
                        <td>:</td>
                        <td><?= $email ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('alamat') ?></td>
                        <td>:</td>
                        <td><?= $alamat ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div style="text-align: end;">

            <a class="btn btn-secondary" href="<?= base_url('kontak') ?>">Kembali</a>
        </div>
    </div>
</div>