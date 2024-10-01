<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="kode_pembelian">Kode Pembelian</label>
                        <input type="text" class="form-control" id="kode_pembelian">
                    </div>

                    <div class="form-group">
                        <label for="id_kontak">Supplier</label>
                        <select id="id_kontak" class="form-control"></select>
                    </div>


                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="text" class="form-control" id="tanggal">
                    </div>

                    <div class="form-group">
                        <label for="is_hutang"></label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_hutang">
                            <label class="custom-control-label" for="is_hutang">Hutang</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <input id="barcode" type="text" class="form-control" placeholder="Kode Barcode">
                        <div class="input-group-append" id="button-addon4">
                            <button id="fokus2barcode" class="btn btn-outline-secondary" type="button"><i class="fas fa-barcode"></i></button>
                            <button class="btn btn-primary" type="button"><i class="fas fa-boxes"></i> Pilih Barang</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Item</th>
                                <th>Nama Item</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Disc</th>
                                <th>Sub</th>
                            </tr>
                        </thead>
                        <tbody>

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
                            <th>Total</th>
                            <th></th>
                            <th>:</th>
                            <th> <span data-bind="text:total"></span> </th>
                        </tr>
                        <tr class="down_payment" >
                            <th>Uang muka</th>
                            <th> <select class="form-control" id="id_rekening" data-bind="options: opt_rekening,
                       optionsText: 'nama_rekening',
                       optionsValue: 'id_rekening',
                       value: id_rekening,
                       optionsCaption: 'Pilih rekening..'"></select> </th>
                            <th> :</th>
                            <th> <input type="text" data-bind="value:uang_muka" class="form-control thousand"> </th>
                        </tr>
                        <tr  class="down_payment"  >
                            <th>Sisa Tagihan</th>
                            <th></th>
                            <th>:</th>
                            <th> <span data-bind="text:sisa_tagihan"></span> </th>
                        </tr>

                        <tr  class="cash_payment" >
                            <th>Bayar</th>
                            <th> <select class="form-control" id="id_rekening" data-bind="options: opt_rekening,
                       optionsText: 'nama_rekening',
                       optionsValue: 'id_rekening',
                       value: id_rekening,
                       optionsCaption: 'Pilih rekening..'"></select> </th>
                            <th> :</th>
                            <th> <input type="text" data-bind="value:uang_muka" class="form-control thousand"> </th>
                        </tr>
                        <tr  class="cash_payment" >
                            <th>Kembalian</th>
                            <th></th>
                            <th>:</th>
                            <th> <span data-bind="text:sisa_tagihan"></span> </th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "pembelian_add_script.php" ?>