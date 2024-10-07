<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <table class="table table-striped">
                    <tr>
                        <th>Kode Pembelian</th>
                        <th>:</th>
                        <th><?=$pembelian['kode_pembelian']?></th>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <th>:</th>
                        <th><?=$pembelian['supplier']?></th>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-striped">
                    <tr>
                        <th>Tanggal</th>
                        <th>:</th>
                        <th><?=$pembelian['tanggal']?></th>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <th>:</th>
                        <th>
                            <?php
                            $total=$pembelian['total'];
                            $total_bayar=$pembelian['total_bayar'];
                            if($total_bayar==0){
                                echo "Belum Lunas";
                            }elseif($total_bayar>0 && $total_bayar<$total){
                                echo "Parsial";
                            }elseif($total<=$total_bayar){
                                echo "Lunas";
                            }
                            ?>
                        </th>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-striped">
                    <tr>
                        <th>Keterangan</th>
                        <th>:</th>
                        <th><?=$pembelian['keterangan']?></th>
                    </tr>
                    
                </table>
            </div>
        </div>
        <div style="text-align: end;">
            <a class="btn btn-secondary" href="<?= base_url('item') ?>">Kembali</a>
        </div>
    </div>
</div>