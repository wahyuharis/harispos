<?php

class Stock_model extends CI_Model
{
    function hpp($id_item)
    {
        $sql = "SELECT
                (SUM( stock.qty_in * stock.harga ) - SUM( stock.qty_out* stock.harga )) / (
                    SELECT stock.qty_akhir FROM stock 
                    WHERE stock.id_item=" . $this->db->escape($id_item) . "
                    ORDER BY stock.id_stock DESC LIMIT 1
                ) AS hpp
                FROM
                stock
                WHERE stock.id_item=" . $this->db->escape($id_item) . "
                ";
        $db = $this->db->query($sql);
        return floatval($db->row_array()['hpp']);
    }

    function stock_akhir($id_item)
    {
        $sql = "SELECT stock.qty_akhir 
        FROM stock 
        WHERE stock.id_item=" . $this->db->escape($id_item) . " 
        ORDER BY stock.id_stock DESC LIMIT 1";

        $db = $this->db->query($sql);

        $stock_akhir = "0";
        if ($db->num_rows() > 0) {
            $stock_akhir = $db->row_array()['qty_akhir'];
        }

        return $stock_akhir;
    }

    function stock_in($waktu, $id_item, $qty, $harga)
    {
        $insert['waktu'] = $waktu;
        $insert['id_item'] = $id_item;
        $insert['qty_awal'] = $this->stock_akhir($id_item);
        $insert['qty_in'] = $qty;
        $insert['qty_akhir'] = $insert['qty_awal'] + $qty;
        $insert['harga'] = $harga;

        $this->db->insert('stock',$insert);
    }
}
