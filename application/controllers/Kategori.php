<?php

class Kategori extends CI_Controller
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

        $template->set_content('kategori/kategori_list', []);
        $template->set_title('Kategori');
        $template->render();
    }
    function datatables()
    {
        $data = array();

        $sql = "SELECT 
                id_kategori,
                '' AS action,
                nama_kategori
                FROM m_kategori
                ORDER BY m_kategori.id_kategori desc
                ";

        $db = $this->db->query($sql);
        foreach ($db->result_array() as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<div style="width:150px" >';
                    $val .= '<a href="' . base_url('kategori/edit/' . $row['id_kategori']) . '" class="btn btn-primary btn-sm" >edit</a>';
                    $val .= '<a href="' . base_url('kategori/detail/' . $row['id_kategori']) . '" class="btn btn-success btn-sm" >detail</a>';
                    $val .= '<a href="' . base_url('kategori/delete/' . $row['id_kategori']) . '" class="btn btn-danger btn-sm delete_btn" >delete</a>';
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
        $contet_data['nama_kategori'] = '';



        $db = $this->db->where('m_kategori.id_kategori', $id)->get('m_kategori');
        if ($db->num_rows() > 0) {
            $dbres = $db->row_array();
            $contet_data['id'] = $id;
            $contet_data['nama_kategori'] = $dbres['nama_kategori'];
        }

        $template = new Template();
        $template->set_content('kategori/kategori_edit', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Add Kategori');
        } else {
            $template->set_title('Edit Kategori');
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
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $success = false;
            $message .= validation_errors();
        } else {
            $success = true;
        }

        $id = in_post('id');

        if ($success) {
            if (empty($id)) {

                $insert['nama_kategori'] = in_post('nama_kategori');

                $this->db->insert('m_kategori', $insert);
            } else {
                $insert['nama_kategori'] = in_post('nama_kategori');

                $this->db->where('id_kategori', $id);
                $this->db->update('m_kategori', $insert);
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
        $this->db->where('m_kategori.id_kategori', $id);
        $db = $this->db->get('m_kategori');

        $contet_data = $db->row_array();

        // print_r2($contet_data);

        $template = new Template();
        $template->set_content('kategori/kategori_detail', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Detail Kategori');
        } else {
            $template->set_title('Detail Kategori');
        }

        $template->render();
    }

    function delete($id)
    {
        $this->db->where('id_kategori', $id);
        $this->db->delete('m_kategori');
    }

    function select2_kategori()
    {
        $search = $this->db->escape_str($this->input->get('search'));
        $sql = "SELECT  
        m_kategori.id_kategori AS id,
        m_kategori.nama_kategori AS `text`
        FROM m_kategori
        WHERE
        m_kategori.nama_kategori LIKE '%".$search."%'
        ORDER BY m_kategori.id_kategori DESC
        LIMIT 10";

        $db = $this->db->query($sql);

        $res = array(
            'results' => $db->result_array(),
            'pagination' => array(
                'more' => false
            )
        );
        header_json();
        echo json_encode($res);
    }
}
