<style>
    .disc_select {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        color: #495057;
    }
</style>
<div id="pembelian_add">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="kode_pembelian">Kode Pembelian</label>
                        <input type="text" class="form-control" id="kode_pembelian" data-bind="value:kode_pembelian" placeholder="Biarkan Kosong Untuk Auto Generate">
                    </div>

                    <div class="form-group">
                        <label for="id_kontak">Supplier</label>
                        <select id="id_kontak" class="form-control" data-bind="value:id_kontak"></select>
                    </div>


                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="text" class="form-control" id="tanggal" data-bind="value:tanggal">
                    </div>

                    <div class="form-group">
                        <label for="is_hutang"></label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_hutang" data-bind="checked:is_hutang">
                            <label class="custom-control-label" for="is_hutang">Hutang</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" class="form-control" data-bind="value:keterangan" placeholder="Jika Ada Note Penting"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form id="form_barcode">
                        <div class="input-group">
                            <input id="barcode" type="text" class="form-control" placeholder="Kode Barcode">
                            <div class="input-group-append" id="button-addon4">
                                <button id="fokus2barcode" class="btn btn-outline-secondary" type="button"><i class="fas fa-barcode"></i></button>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#pick_item_modal" type="button"><i class="fas fa-boxes"></i> Pilih Barang</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <table id="ko_binded" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barcode</th>
                                <th style="width: 20%;">Nama Item</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Disc</th>
                                <th style="width: 15%;">Sub</th>
                            </tr>
                        </thead>
                        <tbody data-bind="foreach:item_list">
                            <tr>
                                <td> <span data-bind="click: $root.delete_item_list" class="btn btn-danger btn-sm">delete</span> </td>
                                <td> <span data-bind="text:barcode"></span> </td>
                                <td> <span data-bind="text:nama_item"></span> </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp.</span>
                                        </div>
                                        <input data-bind="value:harga_beli" type="text" style="text-align:end;" class="thousand form-control">
                                    </div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input data-bind="value:qty" type="text" style="text-align:end;" class="number form-control">
                                        <div class="input-group-append">
                                            <span data-bind="text:satuan" class="input-group-text"></span>
                                        </div>
                                    </div>
                                </td>
                                <td>

                                    <div class="input-group">
                                        <input data-bind="value:disc" type="text" style="text-align:end;" class="number form-control">
                                        <select data-bind="value:disc_type" class="input-group-addon disc_select">
                                            <option value="persen">%</option>
                                            <option value="rp">Rp</option>
                                        </select>
                                    </div>
                                </td>
                                <td style="text-align: end;">Rp.
                                    <span data-bind="text:sub"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3"></div>
                <div class="col-md-7">
                    <table class="table table-striped">
                        <tr>
                            <th>Biaya Lain</th>
                            <th><input type="text" data-bind="value:nama_biaya" class="form-control" placeholder="keterangan biaya"></th>
                            <th>:</th>
                            <th>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" data-bind="value:jumlah_biaya" class="form-control thousand" style="text-align: end;">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th></th>
                            <th>:</th>
                            <th style="text-align: end;">Rp.
                                <span data-bind="text:total"></span>
                            </th>
                        </tr>

                        <tr class="cash_payment">
                            <th>Bayar</th>
                            <th style="width: 200px;">
                                <select class="form-control" id="id_rekening_cash"
                                    data-bind="options: opt_metode_pembayaran,
                                    optionsText: 'nama_metode_pembayaran',
                                    optionsValue: 'id_metode_pembayaran',
                                    value: id_rekening_cash,
                                    optionsCaption: 'Pilih rekening..'">
                                </select>
                            </th>
                            <th> :</th>
                            <th>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp.</span>
                                    </div>
                                    <input type="text" data-bind="textInput:bayar" class="form-control thousand" style="text-align: end;">
                                </div>
                            </th>
                        </tr>
                        <tr class="cash_payment">
                            <th>Kembalian</th>
                            <th></th>
                            <th>:</th>
                            <th style="text-align: end;"> Rp.
                                <span data-bind="text:kembalian"></span>
                            </th>
                        </tr>


                        <tr class="down_payment">
                            <th>Uang muka</th>
                            <th style="width: 200px;">
                                <select class="form-control" id="id_rekening_dp"
                                    data-bind="options: opt_metode_pembayaran,
                                    optionsText: 'nama_metode_pembayaran',
                                    optionsValue: 'id_metode_pembayaran',
                                    value: id_rekening_dp,
                                    optionsCaption: 'Pilih rekening..'">
                                </select>
                            </th>
                            <th> :</th>
                            <th> <input type="text" class="form-control thousand" data-bind="textInput:uang_muka" style="text-align: end;"> </th>
                        </tr>
                        <tr class="down_payment">
                            <th>Sisa Tagihan</th>
                            <th></th>
                            <th>:</th>
                            <th data-bind="text:sisa_tagihan" style="text-align: end;"></th>
                        </tr>


                    </table>
                </div>
            </div>

            <form id="form_1">
                <textarea name="ko_output" class="form-control" data-bind="value:ko.toJSON($root)"></textarea>
                <button class="btn btn-primary" type="submit">Save</button>
                <a class="btn btn-secondary" href="<?= base_url('pembelian') ?>">Kembali</a>
            </form>
        </div>
    </div>

    <div class="modal fade" id="pick_item_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Item</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <table id="pick_item_table" class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barcode</th>
                                <th width="25%">Nama Item</th>
                                <th>Category</th>
                                <th>harga beli</th>
                                <th>harga jual</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


</div>
<?php require_once "pembelian_add_script.php" ?>