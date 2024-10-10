SELECT 
keuangan.id_keuangan,
DATE_FORMAT(keuangan.tanggal,'%d/%m/%Y') AS `tanggal`,
keuangan.tabel,
(case 
when keuangan.tabel='pembelian' then
 (
 SELECT pembelian.kode_pembelian FROM pembelian WHERE pembelian.id_pembelian=keuangan.id_trans
 )
 when keuangan.tabel='penjualan' then
 (
 SELECT penjualan.kode_penjualan FROM penjualan WHERE penjualan.id_penjualan=keuangan.id_trans
 )
ELSE
 ''
END) AS `kode_trans`
FROM keuangan

WHERE
keuangan.id_trans=(SELECT pembelian.id_pembelian FROM pembelian WHERE pembelian.kode_pembelian LIKE '%FB000%' LIMIT 1 )
OR
keuangan.keterangan LIKE '%FB000%'

ORDER BY keuangan.id_keuangan DESC
