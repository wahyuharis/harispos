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
        <i class="far fa-circle"></i>
        <p>Beranda</p>
    </a>
</li>

<?php
$active = "";
if ( $segment1 == 'kontak') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('kontak') ?>" class="nav-link <?= $active ?>">
        <i class="far fa-circle"></i>
        <p>Kontak</p>
    </a>
</li>





<?php
$menu_open = "";
$display = 'display: none;';
if (in_array($segment1, ['category', 'item'])) {
    $menu_open = " menu-is-opening menu-open ";
    $display = 'display: block;';
}
?>

<li class="nav-item <?= $menu_open ?> ">
    <a href="#" class="nav-link">
        <i class="far fa-circle"></i>
        <p>
            Item
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="<?= $display ?>">
        <?php
        $active = "";
        if ($segment1 == 'category') {
            $active = ' active ';
        }
        ?>
        <li class="nav-item">
            <a href="<?= base_url('category') ?>" class="nav-link <?= $active ?>">
                <i class="far fa-circle"></i>
                <p>Category</p>
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
                <i class="far fa-circle"></i>
                <p>Item</p>
            </a>
        </li>

    </ul>
</li>




<?php
$active = "";
if ($segment1 == 'purchase') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('purchase') ?>" class="nav-link <?= $active ?>">
        <i class="far fa-circle"></i>
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
        <i class="far fa-circle"></i>
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
        <i class="far fa-circle"></i>
        <p>Stock</p>
    </a>
</li>

<?php
$active = "";
if ($segment1 == 'rekening') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('rekening') ?>" class="nav-link <?= $active ?>">
        <i class="far fa-circle"></i>
        <p>Rekening</p>
    </a>
</li>


<?php
$active = "";
if ($segment1 == 'cashflow') {
    $active = ' active ';
}
?>
<li class="nav-item">
    <a href="<?= base_url('cashflow') ?>" class="nav-link <?= $active ?>">
        <i class="far fa-circle"></i>
        <p>Register Kas</p>
    </a>
</li>