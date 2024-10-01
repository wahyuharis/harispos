<?php

class Item_model extends CI_Model
{

    function sql_list()
    {

        $start=$this->input->get('start');
        $limit=$this->input->get('length');
        $search_arr=$this->input->get('search');
        $search=$search_arr['value'];

        $sql="SELECT 
                id_item,
                '' AS `action`,
                m_item.barcode,
                m_item.nama_item,
                m_kategori.nama_kategori,
                m_item.harga_beli,
                m_item.harga_jual,
                '' as `stock`,
                m_item.satuan
                FROM m_item
                LEFT JOIN m_kategori ON m_kategori.id_kategori=m_item.id_kategori
                WHERE m_item.deleted =0 and (
                m_item.barcode like '%".$this->db->escape_str($search)."%'
                or
                m_item.nama_item like '%".$this->db->escape_str($search)."%'
                )
                ORDER BY m_item.id_item desc
                ";
        $totalrows=$this->db->query("  SELECT COUNT(*) AS totalrows FROM ( ".$sql.") AS tb" );
        
        $sql.="limit ".intval($start).",".intval($limit)." ";
        $data=$this->db->query($sql);

        return array(
            'data' => $data->result_array(),
            'totalrows' =>$totalrows->row_array()['totalrows']
        );

    }
}