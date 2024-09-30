<?php

class Item_model extends CI_Model
{

    function sql_list()
    {
        $sql="SELECT 
                id_item,
                '' AS `action`,
                m_item.barcode,
                m_item.nama_item,
                m_kategori.nama_kategori,
                m_item.satuan,
                m_item.harga_beli,
                m_item.harga_jual
                FROM m_item
                LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
                WHERE m_item.deleted =0
                ORDER BY m_item.id_item desc
                ";

        return $sql;
    }
}