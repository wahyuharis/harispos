<?php
class Pembelian_model extends CI_Model
{

    function sql_list()
    {
        $start = $this->input->get('start');
        $limit = $this->input->get('length');
        
        $sql = "
SELECT * FROM (
	SELECT 
	pembelian.id_pembelian,
	pembelian.kode_pembelian,
	date_format(pembelian.tanggal,'%d/%m/%Y') AS `tanggal`,
	m_kontak.nama_kontak AS supplier,
	pembelian.total,
	(case 
	when 
		(SELECT SUM(keuangan.total_trans) 
		FROM keuangan 
		WHERE keuangan.tabel='pembelian' 
		AND keuangan.id_trans=pembelian.id_pembelian) IS NULL then
		0
	ELSE
		(SELECT SUM(keuangan.total_trans) 
		FROM keuangan 
		WHERE keuangan.tabel='pembelian' 
		AND keuangan.id_trans=pembelian.id_pembelian)
	end
	) AS total_bayar,
	pembelian.id_kontak
	FROM
	pembelian
	LEFT JOIN m_kontak ON m_kontak.id_kontak=pembelian.id_kontak
) AS tb_pembelian
WHERE kode_pembelian LIKE '%%'
AND
tanggal LIKE '%05/10/2024%'
AND
id_kontak LIKE '4'
        ";
        
        $totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");
        $sql .= "limit " . intval($start) . "," . intval($limit) . " ";
        $data = $this->db->query($sql);

        return array(
            'data' => $data->result_array(),
            'totalrows' => $totalrows->row_array()['totalrows']
        );
    }
}
