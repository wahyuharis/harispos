<?php
$this->load->model('Setting_model');
$setting_model = new Setting_model();
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        table.bordered {
            border-collapse: collapse;
        }

        table.bordered td,
        table.bordered th {
            border: 1px solid black;
        }

        table.bordered2 {
            border-collapse: collapse;
        }

        table.bordered2 td,
        table.bordered2 th {
            border-bottom: 1px solid black;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>
                <img src="<?= base_url($setting_model->get('company_logo')) ?>" style="width: 70px;height: 70px;">
            </td>
            <td style="width: 600px;text-align: center;">
                <h1><?php echo $setting_model->get('company_name'); ?></h1>
                <?php echo $setting_model->get('company_address'); ?>
            </td>
            <td style="width: 70px;">
            </td>
        </tr>
    </table>
    <hr>
    <table>
        <tr>
            <td style="width: 220px;">
                <table>
                    <tr>
                        <th>Kode Pembelian</th>
                        <th>:</th>
                        <th><?= $pembelian['kode_pembelian'] ?></th>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <th>:</th>
                        <th><?= $pembelian['supplier'] ?></th>
                    </tr>
                </table>

            </td>
            <td style="width: 220px;">

                <table>
                    <tr>
                        <th>Tanggal</th>
                        <th>:</th>
                        <th><?= $pembelian['tanggal'] ?></th>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <th>:</th>
                        <th><?php
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

            </td>
            <td style="width: 220px;">
                <table>
                    <tr>
                        <th>Keterangan</th>
                        <th>:</th>
                        <th><?= $pembelian['keterangan'] ?></th>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <br>
    <table class="bordered">
        <tr>
            <th style="width: 30px;">No</th>
            <th style="width: 150px;">Nama Item</th>
            <th style="width: 150px;">Harga</th>
            <th style="width: 100px;">Qty</th>
            <th style="width: 150px;">Disc</th>
            <th style="width: 150px;">Sub</th>
        </tr>
        <?php $no = 0; ?>
        <?php foreach ($pembelian_detil as $row) { ?>
            <tr>
                <td><?php $no++;
                    echo $no ?></td>
                <td><?= $row['nama_item'] ?></td>
                <td class="text-right">Rp <?= format_currency($row['harga']) ?></td>
                <td class="text-right"><?= $row['qty'] ?></td>
                <td class="text-right">
                    <?php
                    if ($row['disc_persen'] > 0) {
                        echo $row['disc_persen'];
                    } elseif ($row['disc_rp'] > 0) {
                        echo "Rp " . format_currency($row['disc_rp']);
                    }
                    ?>
                </td>
                <td class="text-right">Rp <?= format_currency($row['sub']) ?></td>
            </tr>
        <?php } ?>
    </table>

    <table>
        <tr>
            <td style="width: 350px;">

            </td>
            <td>
                <table class="bordered2">
                    <?php foreach ($pembelian_biaya as $row) { ?>
                        <tr>
                            <th style="width: 190px;"><?= $row['nama_biaya'] ?></th>
                            <th style="width: 10px;">:</th>
                            <th class="text-right" style="width: 190px;">Rp <?= format_currency($row['jumlah_biaya']) ?></th>
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
                                $sisa_tagihan = floatval2($pembelian['total']) - floatval2($pembelian['total_bayar']);
                                echo format_currency($sisa_tagihan);
                                ?>
                            </th>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
    <br>
    Admin : Admin Name


</body>

</html>