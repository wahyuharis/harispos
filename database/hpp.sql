SELECT
(SUM( stock.qty_in * stock.harga ) - SUM( stock.qty_out* stock.harga )) / (
SELECT stock.qty_akhir FROM stock 
WHERE stock.id_item=1
ORDER BY stock.id_stock DESC LIMIT 1
) AS hpp
FROM
stock
WHERE stock.id_item=1
