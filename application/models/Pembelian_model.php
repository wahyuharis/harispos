<?php
class Pembelian_model extends CI_Model
{

	function sql_list()
	{
		$start = $this->input->get('start');
		$limit = $this->input->get('length');

		$sql = "
SELECT id_pembelian,'' AS `action`,kode_pembelian,tanggal,supplier,total,'' as status,total_bayar,id_kontak FROM (
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
WHERE 1
        ";

		if (strlen($this->input->get('kode_pembelian')) > 0) {
			$sql.=" and  kode_pembelian like ".$this->db->escape($this->input->get('kode_pembelian'))." ";
		}
		if (strlen($this->input->get('id_kontak')) > 0) {
			$sql.=" and  id_kontak like ".$this->db->escape($this->input->get('id_kontak'))." ";
		}
		if (strlen($this->input->get('tanggal')) > 0) {
			$sql.=" and  tanggal like ".$this->db->escape($this->input->get('tanggal'))." ";
		}

		if (strlen($this->input->get('status')) > 0) {
			$status=$this->input->get('status');
			if($status=='lunas'){
				$sql.=" and  total <= total_bayar ";
			}
			if($status=='parsial'){
				$sql.=" and total_bayar > 0 and total > total_bayar ";
			}
			if($status=='belum_lunas'){
				$sql.=" and total_bayar = 0 ";
				
			}
		}
		// print_r2($sql);

		$totalrows = $this->db->query("  SELECT COUNT(*) AS totalrows FROM ( " . $sql . ") AS tb");
		$sql .= "limit " . intval($start) . "," . intval($limit) . " ";
		$data = $this->db->query($sql);


		return array(
			'data' => $data->result_array(),
			'totalrows' => $totalrows->row_array()['totalrows']
		);
	}
}
