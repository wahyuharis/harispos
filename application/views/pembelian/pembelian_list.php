<div class="modal fade" id="filter_modal" aria-labelledby="filter_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filter_modal_label">Pencarian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_filter">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="kode_pembelian">Kode Pembelian</label>
                                <input type="text" class="form-control" id="kode_pembelian" name="kode_pembelian">
                            </div>

                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" style="background-color: #fff;" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="id_kontak">Supplier</label>
                                <select id="id_kontak" class="form-control" name="id_kontak"></select>
                            </div>

                            <div class="form-group">
                                <label for="tanggal">Status</label>
                                <select class="form-control" name="status" id="status">

                                    <option>-- Pilih Status --</option>
                                    <option>Lunas</option>
                                    <option>Parsial</option>
                                    <option>Belum Lunas</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-primary" href="<?= base_url('pembelian/add') ?>">Add</a>

            </div>
            <div class="col-md-6 text-right">
                <a class="btn btn-outline-secondary" data-toggle="modal" data-target="#filter_modal">
                    <i class="fas fa-search"></i> Search
                </a>
            </div>
        </div>
        <br>
        <table id="dtt_tables" class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>#</th>
                    <th><?= label2("kode_pembelian") ?></th>
                    <th><?= label2("tanggal") ?></th>
                    <th><?= label2("supplier") ?></th>
                    <th><?= label2("total") ?></th>
                    <th><?= label2("status") ?></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<?php require_once "pembelian_list_script.php" ?>