<?php

class Stock_model extends CI_Model
{
    function stock_akhir($id_item)
    {
        $sql = "SELECT stock.qty_akhir 
        FROM stock 
        WHERE stock.id_item=" . $this->db->escape($id_item) . " 
        ORDER BY stock.id_stock DESC LIMIT 1";

        $db = $this->db->query($sql);

        $stock_akhir="0";

        if($db->num_rows()>0){
            $stock_akhir=$db->row_array()['qty_akhir'];
        }

        return $stock_akhir;
    }
}
