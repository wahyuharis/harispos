<?php

class Pembelian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $auth = new Auth();
        $auth->logged_in();
    }

    function index() {}

    function add()
    {
        $content_data = array();

        $this->db->where('deleted', 0);
        $db = $this->db->get('metode_pembayaran');

        $content_data['opt_metode_pembayaran'] = $db->result_array();

        $template = new Template();
        $template->set_content('pembelian/pembelian_add', $content_data);
        $template->set_title('Add Pembelian');
        $template->render();
    }

    function submit()
    {
        $message = '';
        $data = [];
        $success = true;

        $post_data = $this->input->post();
        $ko_output_str = in_post('ko_output');
        $ko_output = json_decode($ko_output_str, true);

        // print_r2($ko_output);

        $this->db->where('kode_pembelian', trim($ko_output['kode_pembelian']));
        $this->db->from('pembelian');
        $count = $this->db->count_all_results();
        if ($count > 0) {
            $success = false;
            $message .= "<p>Kode Pembelian Sudah Ada</p>";
        }

        if (empty(trim($ko_output['tanggal']))) {
            $success = false;
            $message .= "<p>Tanggal Wajib Di isi</p>";
        }
        if (!isset($ko_output['id_kontak'])) {
            $success = false;
            $message .= "<p>Supplier Wajib Diisi</p>";
        }

        if (count($ko_output['item_list']) < 1) {
            $success = false;
            $message .= "<p>Item Masih Kosong</p>";
        }

        foreach ($ko_output['item_list'] as $row) {
            if (floatval2($row['harga_beli']) < 1) {
                $success = false;
                $message .= "<p>Harga Item " . $row['nama_item'] . " Tidak Boleh Kosong</p>";
            }
            if (floatval2($row['qty']) < 1) {
                $success = false;
                $message .= "<p>Qty Item " . $row['nama_item'] . " Tidak Boleh Kosong</p>";
            }
        }

        if (!$ko_output['is_hutang']) {
            if (floatval2($ko_output['bayar']) < 1) {
                $success = false;
                $message .= "<p>Jumlah Bayar Masih Kosong</p>";
            }
            if (!isset($ko_output['id_metode_pembayaran_cash'])) {
                $success = false;
                $message .= "<p>Pilih Metode Bayar</p>";
            }
            if (floatval2($ko_output['bayar']) < floatval2($ko_output['total'])) {
                $success = false;
                $message .= "<p>Jumlah Pembayaran Kurang Dari Total</p>";
            }
        } else {
            // uang_muka
            if (floatval2($ko_output['uang_muka']) < 1) {
                $success = false;
                $message .= "<p>Jumlah Uang Muka Masih Kosong</p>";
            }
            if (!isset($ko_output['id_metode_pembayaran_dp'])) {
                $success = false;
                $message .= "<p>Pilih Metode Bayar</p>";
            }
        }

        if ($success) {
            // $tanggal=waktu_dmy_to_ymd($ko_output['tanggal'])." ".date('H:i:s');
            // if(isset($ko_output['kode_pembelian'])){
            //     $insert['kode_pembelian']=$ko_output['kode_pembelian'];
            // }
            // $insert['tanggal']=$tanggal;
        }

        $res = array(
            'message' => $message,
            'data' => $data,
            'success' => $success,
        );
        header_json();
        echo json_encode($res);
    }
}
