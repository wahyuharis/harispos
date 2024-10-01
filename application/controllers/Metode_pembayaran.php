<?php

class Metode_pembayaran extends CI_Controller
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

        $template->set_content('metode_pembayaran/metode_pembayaran_list', []);
        $template->set_title('Metode Pembayaran');
        $template->render();
    }
    function datatables()
    {
        $data = array();

        $sql = "SELECT 
                metode_pembayaran.id_metode_pembayaran,
                '' AS `action`,
                metode_pembayaran.nama_metode_pembayaran,
                metode_pembayaran.bank,
                metode_pembayaran.no_rekening
                FROM metode_pembayaran
                where metode_pembayaran.deleted = '0'
                ORDER BY metode_pembayaran.id_metode_pembayaran desc
                ";

        $db = $this->db->query($sql);
        foreach ($db->result_array() as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<div style="width:150px" >';
                    $val .= '<a href="' . base_url('metode_pembayaran/edit/' . $row['id_metode_pembayaran']) . '" class="btn btn-primary btn-sm" >edit</a>';
                    $val .= '<a href="' . base_url('metode_pembayaran/detail/' . $row['id_metode_pembayaran']) . '" class="btn btn-success btn-sm" >detail</a>';
                    $val .= '<a href="' . base_url('metode_pembayaran/delete/' . $row['id_metode_pembayaran']) . '" class="btn btn-danger btn-sm delete_btn" >delete</a>';
                    $val .= '</div>';
                }

                array_push($buff, $val);
            }
            array_push($data, $buff);
        }

        header_json();
        $res = array(
            'data' => $data,
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
        $contet_data['nama_metode_pembayaran'] = '';
        $contet_data['bank'] = '';
        $contet_data['no_rekening'] = '';



        $db = $this->db->where('id_metode_pembayaran', $id)->get('metode_pembayaran');
        if ($db->num_rows() > 0) {
            $dbres = $db->row_array();
            $contet_data['id'] = $id;
            $contet_data['nama_metode_pembayaran'] = $dbres['nama_metode_pembayaran'];
            $contet_data['bank'] = $dbres['bank'];
            $contet_data['no_rekening'] = $dbres['no_rekening'];
        }

        $template = new Template();
        $template->set_content('metode_pembayaran/metode_pembayaran_edit', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Add Metode Pembayaran');
        } else {
            $template->set_title('Edit Metode Pembayaran');
        }

        $template->render();
    }

    function submit()
    {
        $message = '';
        $data = [];
        $success = false;

        $post_data = $this->input->post();

        // print_r2($post_data);

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_metode_pembayaran', 'Nama Metode Pembayaran', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $success = false;
            $message .= validation_errors();
        } else {
            $success = true;
        }

        $id = in_post('id');

        if ($success) {
            if (empty($id)) {

                $insert['nama_metode_pembayaran'] = in_post('nama_metode_pembayaran');
                $insert['bank'] = in_post('bank');
                $insert['no_rekening'] = in_post('no_rekening');

                $this->db->insert('metode_pembayaran', $insert);
            } else {
                $insert['nama_metode_pembayaran'] = in_post('nama_metode_pembayaran');
                $insert['bank'] = in_post('bank');
                $insert['no_rekening'] = in_post('no_rekening');

                $this->db->where('id_metode_pembayaran', $id);
                $this->db->update('metode_pembayaran', $insert);
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
        $this->db->where('metode_pembayaran.id_metode_pembayaran', $id);
        $db = $this->db->get('metode_pembayaran');

        $contet_data = $db->row_array();

        // print_r2($contet_data);

        $template = new Template();
        $template->set_content('metode_pembayaran/metode_pembayaran_detail', $contet_data);


        $template->set_title('Detail Metode Pembayaran');


        $template->render();
    }

    function delete($id)
    {
        $this->db->where('id_metode_pembayaran', $id);
        $this->db->set(array('deleted' => 1));
        $this->db->update('metode_pembayaran');
    }
}
