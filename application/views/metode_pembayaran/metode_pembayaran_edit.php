<div class="card">
    <div class="card-body">
        <form id="form_1">
            <div class="row">
                <div class="col-md-4">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <div class="form-group">
                        <label for="nama_metode_pembayaran">Nama Metode Pembayaran</label>
                        <input type="text" class="form-control" id="nama_metode_pembayaran" name="nama_metode_pembayaran" value="<?= $nama_metode_pembayaran ?>">
                    </div>
                    <div class="form-group">
                        <label for="bank">Bank</label>
                        <input type="text" class="form-control" id="bank" name="bank" value="<?= $bank ?>">
                    </div>
                    <div class="form-group">
                        <label for="no_rekening">No Rekening</label>
                        <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="<?= $no_rekening ?>">
                    </div>

                </div>
                <div class="col-md-4">



                </div>
                <div class="col-md-4 pl-4">

                </div>
            </div>
            <div style="text-align: end;">

                <button type="submit" class="btn btn-primary">save</button>
                <a class="btn btn-secondary" href="<?= base_url('metode_pembayaran') ?>">Kembali</a>
            </div>
        </form>
    </div>
</div>
<?php require_once 'metode_pembayaran_edit_script.php' ?>