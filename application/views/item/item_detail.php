<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tr>
                        <td><?= label2('barcode') ?></td>
                        <td>:</td>
                        <td><?= $barcode ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('nama_item') ?></td>
                        <td>:</td>
                        <td><?= $nama_item ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('nama_kategori') ?></td>
                        <td>:</td>
                        <td><?= $nama_kategori ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('satuan') ?></td>
                        <td>:</td>
                        <td><?= $satuan ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('harga_beli') ?></td>
                        <td>:</td>
                        <td><?= $harga_beli ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('harga_jual') ?></td>
                        <td>:</td>
                        <td><?= $harga_jual ?></td>
                    </tr>
                    <tr>
                        <td><?= label2('hitung_stock') ?></td>
                        <td>:</td>
                        <td><?= $hitung_stock ?></td>
                    </tr>

                    <tr>
                        <td><?= label2('keterangan') ?></td>
                        <td>:</td>
                        <td><?= $keterangan ?></td>
                    </tr>

                </table>


            </div>
        </div>
        <div style="text-align: end;">

            <a class="btn btn-secondary" href="<?= base_url('item') ?>">Kembali</a>
        </div>
    </div>
</div>