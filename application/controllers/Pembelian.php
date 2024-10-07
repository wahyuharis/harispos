<?php

class Pembelian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $auth = new Auth();
        $auth->logged_in();
    }

    function index()
    {
        $template = new Template();

        $template->set_content('pembelian/pembelian_list', []);
        $template->set_title('Pembelian');
        $template->render();
    }

    function datatables()
    {
        // print_r2($_GET);

        $data = array();

        $this->load->model('Pembelian_model');
        $pembelian_model = new Pembelian_model();

        $sql = $pembelian_model->sql_list();

        foreach ($sql['data'] as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '';
                    $val .= '<a href="' . base_url('pembelian/detail/' . $row['id_pembelian']) . '" class="btn btn-success btn-sm" >detail</a>';
                }

                if ($key == 'total') {
                    $val = "Rp ".format_currency($row['total']);
                }
                if ($key == 'status') {
                    if ((floatval($row['total_bayar']) == 0)) {
                        $val = '<span class="badge badge-danger" >Belum Lunas</span>';
                    } elseif ((floatval($row['total']) > floatval($row['total_bayar']) && floatval($row['total_bayar']) > 0)) {
                        $val = '<span class="badge badge-warning" >Parsial</span>';
                    } elseif (floatval($row['total']) <= floatval($row['total_bayar'])) {
                        $val = '<span class="badge badge-primary" >Lunas</span>';
                    }
                }

                array_push($buff, $val);
            }
            array_push($data, $buff);
        }

        header_json();
        $res = array(
            // 'draw' => 1,
            "recordsTotal" => intval($sql['totalrows']),
            "recordsFiltered" => intval($sql['totalrows']),
            "data" => $data,
        );
        echo json_encode($res);
    }

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
            // if (floatval2($ko_output['uang_muka']) < 1) {
            //     $success = false;
            //     $message .= "<p>Jumlah Uang Muka Masih Kosong</p>";
            // }
            if (floatval2($ko_output['uang_muka']) > floatval2($ko_output['total'])) {
                $success = false;
                $message .= "<p>Uang Muka melebihi Total</p>";
            }
            if (floatval2($ko_output['uang_muka']) > 0) {
                if (!isset($ko_output['id_metode_pembayaran_dp'])) {
                    $success = false;
                    $message .= "<p>Pilih Metode Bayar</p>";
                }
            }
        }
        if (floatval2($ko_output['jumlah_biaya']) > 0 && strlen(trim($ko_output['nama_biaya'])) < 1) {
            $success = false;
            $message .= "<p>Beri Keterangan Biaya</p>";
        }

        if ($success) {
            $this->db->trans_start(); # Starting Transaction
            $this->db->trans_strict(FALSE); # See Note 01. If you wish, you can remove as well 

            $tanggal = waktu_dmy_to_ymd($ko_output['tanggal']) . " " . date('H:i:s');
            if (strlen($ko_output['kode_pembelian']) > 0) {
                $insert['kode_pembelian'] = $ko_output['kode_pembelian'];
            }
            $insert['tanggal'] = $tanggal;
            if (isset($ko_output['id_kontak'])) {
                $insert['id_kontak'] = $ko_output['id_kontak'];
            }
            $insert['total'] = floatval2($ko_output['total']);
            $insert['keterangan'] = $ko_output['keterangan'];

            $this->db->insert('pembelian', $insert);
            $insert_id = $this->db->insert_id();

            if (strlen($ko_output['kode_pembelian']) < 1) {
                $kode_pembelian = "FB" . str_pad($insert_id, 5, "0", STR_PAD_LEFT);
                $this->db->where('id_pembelian', $insert_id);
                $this->db->update('pembelian', array('kode_pembelian' => $kode_pembelian));
            }

            $this->load->model('Stock_model');
            $stock = new Stock_model();

            foreach ($ko_output['item_list'] as $row2) {

                $insert2['id_pembelian'] = $insert_id;
                $insert2['id_item'] = $row2['id_item'];
                $insert2['qty'] = floatval2($row2['qty']);
                $insert2['harga'] = floatval2($row2['harga_beli']);

                $insert2['disc_persen'] = 0;
                $insert2['disc_rp'] = 0;

                if ($row2['disc_type'] == 'persen') {
                    $insert2['disc_persen'] = floatval2($row2['disc']);
                } else {
                    $insert2['disc_rp'] = floatval2($row2['disc']);
                }
                $insert2['sub'] = floatval2($row2['sub']);

                $this->db->insert('pembelian_detail', $insert2);
                $stock->stock_in($tanggal, $insert2['id_item'], $insert2['qty'], $insert2['harga']);
            }

            if (floatval2($ko_output['jumlah_biaya']) > 0) {
                $insert3['id_pembelian'] = $insert_id;
                $insert3['nama_biaya'] = $ko_output['nama_biaya'];
                $insert3['jumlah_biaya'] = floatval2($ko_output['jumlah_biaya']);
                $this->db->insert('pembelian_biaya', $insert3);
            }


            if (!$ko_output['is_hutang']) {
                $insert4['tanggal'] = $tanggal;
                $insert4['tabel'] = 'pembelian';
                $insert4['id_trans'] = $insert_id;
                $insert4['id_metode_pembayaran'] = $ko_output['id_metode_pembayaran_cash'];
                $insert4['total_trans'] = floatval2($ko_output['total']);
                $this->db->insert('keuangan', $insert4);
            } else {
                if (floatval2($ko_output['uang_muka']) > 0) {
                    $insert4['tanggal'] = $tanggal;
                    $insert4['tabel'] = 'pembelian';
                    $insert4['id_trans'] = $insert_id;
                    $insert4['id_metode_pembayaran'] = $ko_output['id_metode_pembayaran_dp'];
                    $insert4['total_trans'] = floatval2($ko_output['uang_muka']);
                    $this->db->insert('keuangan', $insert4);
                }
            }

            $data['insert_id'] = $insert_id;

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
            }
        }

        $res = array(
            'message' => $message,
            'data' => $data,
            'success' => $success,
        );
        header_json();
        echo json_encode($res);
    }

    function detail($id_pembelian=null){

        $this->load->model('Pembelian_model');
        $this->load->model('Pembelian_detail_model');
        $this->load->model('Pembelian_biaya_model');
        $pembelian_model=new Pembelian_model();
        $pembelian_detil_model=new Pembelian_detail_model();
        $pembelian_biaya_model=new Pembelian_biaya_model();
        

        $content_data=array();
        $content_data['pembelian']=$pembelian_model->detail($id_pembelian);
        $content_data['pembelian_detil']=$pembelian_detil_model->detail($id_pembelian);
        $content_data['pembelian_biaya']=$pembelian_biaya_model->detail($id_pembelian);

        // print_r2($content_data['pembelian_biaya']);

        $template = new Template();
        $template->set_content('pembelian/pembelian_detail', $content_data);

        $template->set_title('Detail Barang & Jasa');

        $template->render();
    }
}
