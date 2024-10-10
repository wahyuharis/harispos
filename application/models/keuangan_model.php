<?php
class Keuangan_model extends CI_Model
{

    function sql_list()
    {
        $sql = "SELECT 
            keuangan.id_keuangan,
            '' AS `action`,
            DATE_FORMAT(keuangan.tanggal,'%d/%m/%Y') AS `tanggal`,
            keuangan.tabel,
            (
                case 
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
                END
            ) AS `kode_trans`,
            metode_pembayaran.nama_metode_pembayaran,
            keuangan.total_trans,
            keuangan.keterangan

            FROM keuangan
            LEFT JOIN metode_pembayaran ON metode_pembayaran.id_metode_pembayaran=keuangan.id_metode_pembayaran
            WHERE
            1

            ORDER BY keuangan.id_keuangan DESC ";

        $totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");
        $sql .= "limit " . intval($start) . "," . intval($limit) . " ";
        $data = $this->db->query($sql);


        return array(
            'data' => $data->result_array(),
            'totalrows' => $totalrows->row_array()['totalrows']
        );
    }
}
