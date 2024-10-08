<div id="pdf_content" class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 30%;">Kode Pembelian</th>
                        <th>:</th>
                        <th><?= $pembelian['kode_pembelian'] ?></th>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <th>:</th>
                        <th><?= $pembelian['supplier'] ?></th>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 40%;">Tanggal</th>
                        <th>:</th>
                        <th><?= $pembelian['tanggal'] ?></th>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <th>:</th>
                        <th>
                            <?php
                            $total = $pembelian['total'];
                            $total_bayar = $pembelian['total_bayar'];
                            if ($total_bayar == 0) {
                                echo "Belum Lunas";
                            } elseif ($total_bayar > 0 && $total_bayar < $total) {
                                echo "Parsial";
                            } elseif ($total <= $total_bayar) {
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
                        <th style="width: 40%;">Keterangan</th>
                        <th>:</th>
                        <th><?= $pembelian['keterangan'] ?></th>
                    </tr>

                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <th>No</th>
                        <th>Nama Item</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Disc</th>
                        <th>Sub</th>
                    </thead>
                    <tbody>
                        <?php $no = 0; ?>
                        <?php foreach ($pembelian_detil as $row) { ?>
                            <tr>
                                <td><?php $no++;
                                    echo $no ?></td>
                                <td><?= $row['nama_item'] ?></td>
                                <td class="text-right">Rp <?= format_currency($row['harga']) ?></td>
                                <td class="text-right"><?= $row['qty'] ?></td>
                                <td class="text-right"><?php

                                                        if ($row['disc_persen'] > 0) {
                                                            echo $row['disc_persen'];
                                                        } elseif ($row['disc_rp'] > 0) {
                                                            echo "Rp " . format_currency($row['disc_rp']);
                                                        }

                                                        ?></td>
                                <td class="text-right">Rp <?= format_currency($row['sub']) ?></td>

                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">

            </div>

            <div class="col-md-5">
                <table class="table table-striped">
                    <?php foreach ($pembelian_biaya as $row) { ?>
                        <tr>
                            <th><?= $row['nama_biaya'] ?></th>
                            <th>:</th>
                            <th class="text-right">Rp <?= format_currency($row['jumlah_biaya']) ?></th>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th>Total</th>
                        <th>:</th>
                        <th class="text-right">Rp <?= format_currency($pembelian['total']) ?></th>
                    </tr>
                    <?php if ($pembelian['is_hutang'] < 1) { ?>
                        <tr>
                            <th>Bayar</th>
                            <th>:</th>
                            <th class="text-right">Rp <?= format_currency($pembelian['bayar']) ?></th>
                        </tr>
                        <tr>
                            <th>Kembalian</th>
                            <th>:</th>
                            <th class="text-right">Rp <?= format_currency($pembelian['kembalian']) ?></th>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <th>Total Bayar</th>
                            <th>:</th>
                            <th class="text-right">Rp <?= format_currency($pembelian['total_bayar']) ?></th>
                        </tr>
                        <tr>
                            <th>Sisa Tagihan</th>
                            <th>:</th>
                            <th class="text-right">Rp
                                <?php
                                $sisa_tagihan=floatval2($pembelian['total'])-floatval2($pembelian['total_bayar']);
                                echo format_currency($sisa_tagihan);
                                ?>
                            </th>
                        </tr>
                    <?php } ?>
                </table>
            </div>

        </div>

        <div style="text-align: end;">
            <button id="pdf_print" type="button" class="btn btn-secondary">Print</button>
            <a class="btn btn-secondary" href="<?= base_url('pembelian') ?>">Kembali</a>
        </div>
    </div>
</div>