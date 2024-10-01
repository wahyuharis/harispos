<?php
$segment1 = segment_uri(1);
$segment2 = segment_uri(2);
$segment3 = segment_uri(3);
?>


<?php
$active = "";
if ($segment1 == '' || $segment1 == 'home') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('home') ?>" class="nav-link <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <i class="fas fa-home"></i>
        <p>Beranda</p>
    </a>
</li>





<?php
$menu_open = "";
$display = 'display: none;';
if (in_array($segment1, ['kontak','kategori', 'item', 'metode_pembayaran'])) {
    $menu_open = " menu-is-opening menu-open ";
    $display = 'display: block;';
}
?>

<li class="nav-item <?= $menu_open ?> ">
    <a href="#" class="nav-link">
        <i class="far fa-folder"></i>
        <p>
            Master
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="<?= $display ?>">
        <?php
        $active = "";
        if ($segment1 == 'kontak') {
            $active = ' active ';
        }
        ?>
        <li class="nav-item">
            <a href="<?= base_url('kontak') ?>" class="nav-link <?= $active ?>">
                <!-- <i class="far fa-circle"></i> -->
                <i class="far fa-address-book"></i>
                <p>Kontak</p>
            </a>
        </li>

        <?php
        $active = "";
        if ($segment1 == 'kategori') {
            $active = ' active ';
        }
        ?>
        <li class="nav-item">
            <a href="<?= base_url('kategori') ?>" class="nav-link <?= $active ?>">
                <!-- <i class="far fa-circle"></i> -->
                <i class="fas fa-sitemap"></i>
                <p>Kategori Barang & Jasa</p>
            </a>
        </li>
        <?php
        $active = "";
        if ($segment1 == 'item') {
            $active = ' active ';
        }
        ?>
        <li class="nav-item">
            <a href="<?= base_url('item') ?>" class="nav-link <?= $active ?>">
                <!-- <i class="far fa-circle"></i> -->
                <i class="fas fa-boxes"></i>
                <p>Barang & Jasa</p>
            </a>
        </li>

        <?php
        $active = "";
        if ($segment1 == 'metode_pembayaran') {
            $active = ' active ';
        }
        ?>
        <li class="nav-item">
            <a href="<?= base_url('metode_pembayaran') ?>" class="nav-link <?= $active ?>">
                <i class="fas fa-wallet"></i>
                <p>Metode Pembayaran</p>
            </a>
        </li>
    </ul>
</li>




<?php
$active = "";
if ($segment1 == 'pembelian') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('pembelian') ?>" class="nav-link <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <i class="fas fa-cart-arrow-down"></i>
        <p>Pembelian</p>
    </a>
</li>


<?php
$active = "";
if ($segment1 == 'sales') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('sales') ?>" class="nav-link <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <i class="fas fa-cash-register"></i>
        <p>Penjualan</p>
    </a>
</li>

<?php
$active = "";
if ($segment1 == 'stock') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('stock') ?>" class="nav-link <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <i class="fas fa-cubes"></i>
        <p>Stock</p>
    </a>
</li>

<?php
$active = "";
if ($segment1 == 'keuangan') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('keuangan') ?>" class="nav-link <?= $active ?>">
        <!-- <i class="far fa-circle"></i> -->
        <!-- <i class="fas fa-book"></i> -->
        <i class="fas fa-money-bill"></i>
        <p>Keuangan</p>
    </a>
</li>