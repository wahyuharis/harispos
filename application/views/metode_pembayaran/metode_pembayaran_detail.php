<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <table class="table table-striped">
                    <tr>
                        <td><?=label2('nama_metode_pembayaran')?></td>
                        <td>:</td>
                        <td><?=$nama_metode_pembayaran?></td>
                    </tr>

                    <tr>
                        <td><?=label2('bank')?></td>
                        <td>:</td>
                        <td><?=$bank?></td>
                    </tr>

                    <tr>
                        <td><?=label2('no_rekening')?></td>
                        <td>:</td>
                        <td><?=$no_rekening?></td>
                    </tr>

                </table>

  
            </div>
        </div>
        <a class="btn btn-secondary" href="<?= base_url('metode_pembayaran') ?>">Kembali</a>
    </div>
</div>