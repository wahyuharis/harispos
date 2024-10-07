<?php

class Item extends CI_Controller
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

        $template->set_content('item/item_list', []);
        $template->set_title('Barang & Jasa');
        $template->render();
    }
    function datatables()
    {
        $data = array();

        $this->load->model('Item_model');
        $this->load->model('Stock_model');
        $item_model = new Item_model();

        $sql = $item_model->sql_list();

        foreach ($sql['data'] as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<div style="width:150px" >';
                    $val .= '<a href="' . base_url('item/edit/' . $row['id_item']) . '" class="btn btn-primary btn-sm" >edit</a>';
                    $val .= '<a href="' . base_url('item/detail/' . $row['id_item']) . '" class="btn btn-success btn-sm" >detail</a>';
                    $val .= '<a href="' . base_url('item/delete/' . $row['id_item']) . '" class="btn btn-danger btn-sm delete_btn" >delete</a>';
                    $val .= '</div>';
                }
                if ($key == 'harga_beli') {
                    $val = "Rp " . format_currency($val);
                }
                if ($key == 'harga_jual') {
                    $val = "Rp " . format_currency($val);
                }

                if ($key == 'stock') {
                    if (intval($row['hitung_stock']) > 0) {
                        $stock_model = new Stock_model();
                        $val = $stock_model->stock_akhir($row['id_item']);
                    } else {
                        $val = '<span class="badge badge-secondary">Jasa</span><br>';
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

    function item_detail($id_item)
    {
        $this->load->model('Item_model');
        $item_model = new Item_model();
        // $item_detail=
        $item_detail = $item_model->sql_item_detail($id_item);
        header_json();
        echo json_encode($item_detail);
    }

    function item_detail_barcode($barcode)
    {
        $this->load->model('Item_model');
        $item_model = new Item_model();
        // $item_detail=
        $item_detail = $item_model->sql_item_detail_barcode($barcode);
        header_json();
        echo json_encode($item_detail);
    }

    function item_modal()
    {
        $data = array();

        $this->load->model('Item_model');
        $this->load->model('Stock_model');
        $item_model = new Item_model();

        $sql = $item_model->sql_item_modal();

        foreach ($sql['data'] as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<span id_item="' . $row['id_item'] . '" class="btn btn-primary btn-sm pilih_item">pilih</span>';
                }
                if ($key == 'harga_beli') {
                    $val = "Rp " . format_currency($val);
                }
                if ($key == 'harga_jual') {
                    $val = "Rp " . format_currency($val);
                }



                if ($key == 'stock') {
                    if (intval($row['hitung_stock']) > 0) {
                        $stock_model = new Stock_model();
                        $val = $stock_model->stock_akhir($row['id_item']);
                    } else {
                        $val = '<span class="badge badge-secondary">Jasa</span><br>';
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
        $this->edit('');
    }

    function edit($id = '')
    {

        $contet_data['id'] = $id;
        $contet_data['barcode'] = '';
        $contet_data['nama_item'] = '';
        $contet_data['id_kategori'] = '';
        $contet_data['satuan'] = '';
        $contet_data['harga_beli'] = '';
        $contet_data['harga_jual'] = '';
        $contet_data['keterangan'] = '';
        $contet_data['hitung_stock'] = 1;
        $contet_data['stock_awal'] = '';


        $kota_db = $this->db->get('m_kategori');
        $opt_kategori = dropdown_array($kota_db->result_array(), 'id_kategori', 'nama_kategori', '-- Pilih Kategori --');
        $contet_data['opt_kategori'] = $opt_kategori;


        $db = $this->db->where('m_item.id_item', $id)->get('m_item');
        if ($db->num_rows() > 0) {
            $dbres = $db->row_array();
            $contet_data['id'] = $id;
            $contet_data['barcode'] = $dbres['barcode'];
            $contet_data['nama_item'] = $dbres['nama_item'];
            $contet_data['id_kategori'] = $dbres['id_kategori'];
            $contet_data['satuan'] = $dbres['satuan'];
            $contet_data['harga_beli'] = $dbres['harga_beli'];
            $contet_data['harga_jual'] = $dbres['harga_jual'];
            $contet_data['keterangan'] = $dbres['keterangan'];
            $contet_data['hitung_stock'] = $dbres['hitung_stock'];
        }

        $template = new Template();
        $template->set_content('item/item_edit', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Add Barang & Jasa');
        } else {
            $template->set_title('Edit Barang & Jasa');
        }

        $template->render();
    }

    function submit()
    {
        $message = '';
        $data = [];
        $success = true;

        $post_data = $this->input->post();

        // print_r2($post_data);

        $this->load->library('form_validation');
        // $this->form_validation->set_rules('barcode', 'Barcode', 'trim|required');
        $this->form_validation->set_rules('nama_item', 'Nama Item', 'trim|required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'trim|required');
        if (intval(in_post('hitung_stock')) > 0) {
            $this->form_validation->set_rules('harga_beli', 'Harga Beli', 'trim|required');
        }
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $success = false;
            $message .= validation_errors();
        }

        if (!empty(in_post('barcode'))) {
            if (empty(in_post('id'))) {
                $this->db->where('deleted', 0);
                $this->db->where('barcode', in_post('barcode'));
                $this->db->from('m_item');
                $count = $this->db->count_all_results();
                if ($count > 0) {
                    $success = false;
                    $message .= "<p>Barcode Sudah Terpakai</p>";
                }
            } else {
                $this->db->where('deleted', 0);
                $this->db->where('id_item !=', in_post('id'));
                $this->db->where('barcode', in_post('barcode'));
                $this->db->from('m_item');
                $count = $this->db->count_all_results();
                if ($count > 0) {
                    $success = false;
                    $message .= "<p>Barcode Sudah Terpakai</p>";
                }
            }
        }


        $id = in_post('id');
        if ($success) {
            if (empty($id)) {

                $insert['barcode'] = in_post('barcode');
                $insert['nama_item'] = in_post('nama_item');
                $insert['id_kategori'] = in_post('id_kategori');
                $insert['satuan'] = in_post('satuan');
                $insert['harga_beli'] = floatval2(in_post('harga_beli'));
                $insert['harga_jual'] = floatval2(in_post('harga_jual'));
                $insert['hitung_stock'] = intval2(in_post('hitung_stock'));
                $insert['keterangan'] = in_post('keterangan');

                $this->db->insert('m_item', $insert);
            } else {
                $insert['barcode'] = in_post('barcode');
                $insert['nama_item'] = in_post('nama_item');
                $insert['id_kategori'] = in_post('id_kategori');
                $insert['satuan'] = in_post('satuan');
                $insert['harga_beli'] = floatval2(in_post('harga_beli'));
                $insert['harga_jual'] = floatval2(in_post('harga_jual'));
                $insert['hitung_stock'] = intval2(in_post('hitung_stock'));
                $insert['keterangan'] = in_post('keterangan');

                $this->db->where('id_item', $id);
                $this->db->update('m_item', $insert);
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

    function detail($id)
    {
        $this->db->where('m_item.id_item', $id);
        $this->db->join('m_kategori', 'm_kategori.id_kategori=m_item.id_kategori', 'left');
        $db = $this->db->get('m_item');

        $contet_data = $db->row_array();

        // print_r2($contet_data);

        $template = new Template();
        $template->set_content('item/item_detail', $contet_data);

        $template->set_title('Detail Barang & Jasa');

        $template->render();
    }

    function delete($id)
    {
        $this->db->where('id_item', $id);
        $this->db->set(array('deleted' => 1));
        $this->db->update('m_item');
    }
}
