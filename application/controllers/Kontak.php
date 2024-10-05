<?php

class Kontak extends CI_Controller
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

        $template->set_content('kontak/kontak_list', []);
        $template->set_title('Kontak');
        $template->render();
    }
    function datatables()
    {
        $data = array();



        $sql = "SELECT 
        id_kontak,
            '' AS action,
            '' AS jenis_kontak,
            m_kontak.nama_kontak,
            m_kontak.phone,
            m_kontak.whatsapp,
            m_kontak.email,
            is_customer,
            is_supplier,
            is_karyawan
            FROM m_kontak
            where m_kontak.deleted = '0'
            ORDER BY m_kontak.id_kontak desc";

        $db = $this->db->query($sql);
        foreach ($db->result_array() as $row) {
            $buff = array();
            foreach ($row as $key => $val) {

                if ($key == 'action') {
                    $val = '<div style="width:150px" >';
                    $val .= '<a href="' . base_url('kontak/edit/' . $row['id_kontak']) . '" class="btn btn-primary btn-sm" >edit</a>';
                    $val .= '<a href="' . base_url('kontak/detail/' . $row['id_kontak']) . '" class="btn btn-success btn-sm" >detail</a>';
                    $val .= '<a href="' . base_url('kontak/delete/' . $row['id_kontak']) . '" class="btn btn-danger btn-sm delete_btn" >delete</a>';
                    $val .= '</div>';
                }
                if ($key == 'jenis_kontak') {
                    $val = "";
                    if ($row['is_customer']) {
                        $val .= '<span class="badge badge-primary">Customer</span><br>';
                    }
                    if ($row['is_supplier']) {
                        $val .= '<span class="badge badge-success">Supplier</span><br>';
                    }
                    if ($row['is_karyawan']) {
                        $val .= '<span class="badge badge-info">Karyawan</span>';
                    }
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
        $contet_data['nama_kontak'] = '';
        $contet_data['phone'] = '';
        $contet_data['whatsapp'] = '';
        $contet_data['email'] = '';
        $contet_data['id_kota'] = '';
        $contet_data['alamat'] = '';
        $contet_data['is_customer'] = '0';
        $contet_data['is_supplier'] = '0';
        $contet_data['is_karyawan'] = '0';

        $kota_db = $this->db->get('_lok_regencies');
        $opt_kota = dropdown_array($kota_db->result_array(), 'id', 'nama_kota', '-- Pilih Kota --');
        $contet_data['opt_kota'] = $opt_kota;


        $db = $this->db->where('m_kontak.id_kontak', $id)->get('m_kontak');
        if ($db->num_rows() > 0) {
            $dbres = $db->row_array();
            $contet_data['id'] = $id;
            $contet_data['nama_kontak'] = $dbres['nama_kontak'];
            $contet_data['phone'] = $dbres['phone'];
            $contet_data['whatsapp'] = $dbres['whatsapp'];
            $contet_data['email'] = $dbres['email'];
            $contet_data['id_kota'] = $dbres['id_kota'];
            $contet_data['alamat'] = $dbres['alamat'];
            $contet_data['is_customer'] = $dbres['is_customer'];
            $contet_data['is_supplier'] = $dbres['is_supplier'];
            $contet_data['is_karyawan'] = $dbres['is_karyawan'];
        }

        $template = new Template();
        $template->set_content('kontak/kontak_edit', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Add Kontak');
        } else {
            $template->set_title('Edit Kontak');
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
        $this->form_validation->set_rules('nama_kontak', 'Nama Kontak', 'trim|required');
        $this->form_validation->set_rules('phone', 'phone', 'trim|required');
        $this->form_validation->set_rules('whatsapp', 'Whatsapp', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('id_kota', 'Kota', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $success = false;
            $message .= validation_errors();
        } else {
            $success = true;
        }

        $id = in_post('id');

        if ($success) {
            if (empty($id)) {

                $insert['nama_kontak'] = in_post('nama_kontak');
                $insert['phone'] = in_post('phone');
                $insert['whatsapp'] = in_post('whatsapp');
                $insert['email'] = in_post('email');
                $insert['alamat'] = in_post('alamat');
                $insert['id_kota'] = in_post('id_kota');
                $insert['is_customer'] = intval(in_post('is_customer'));
                $insert['is_supplier'] = intval(in_post('is_supplier'));
                $insert['is_karyawan'] = intval(in_post('is_karyawan'));

                $this->db->insert('m_kontak', $insert);
            } else {

                $insert['nama_kontak'] = in_post('nama_kontak');
                $insert['phone'] = in_post('phone');
                $insert['whatsapp'] = in_post('whatsapp');
                $insert['email'] = in_post('email');
                $insert['alamat'] = in_post('alamat');
                $insert['id_kota'] = in_post('id_kota');
                $insert['is_customer'] = intval(in_post('is_customer'));
                $insert['is_supplier'] = intval(in_post('is_supplier'));
                $insert['is_karyawan'] = intval(in_post('is_karyawan'));

                $this->db->where('id_kontak', $id);
                $this->db->update('m_kontak', $insert);
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
        $this->db->where('m_kontak.id_kontak', $id);
        $this->db->join('_lok_regencies', '_lok_regencies.id=m_kontak.id_kota', 'left');
        $db = $this->db->get('m_kontak');

        $contet_data = $db->row_array();


        $template = new Template();
        $template->set_content('kontak/kontak_detail', $contet_data);

        if (empty(trim($id))) {
            $template->set_title('Detail Kontak');
        } else {
            $template->set_title('Detail Kontak');
        }

        $template->render();
    }

    function delete($id)
    {
        $this->db->where('id_kontak', $id);
        $this->db->set(array('deleted' => 1));
        $this->db->update('m_kontak');
    }

    function select2()
    {
        $res = array();

        $search = $this->db->escape_str($this->input->get('search'));

        $sql = "SELECT * 
            FROM m_kontak
            LEFT JOIN _lok_regencies ON _lok_regencies.id=m_kontak.id_kota
            where m_kontak.deleted = '0' and m_kontak.is_supplier='1' and (
                m_kontak.nama_kontak like '%" . $search . "%'
                or m_kontak.phone like '%" . $search . "%'
                or  m_kontak.whatsapp  like '%" . $search . "%'
                or m_kontak.email like '%" . $search . "%'
            )
            ORDER BY m_kontak.id_kontak desc
            limit 10
            ";
        $db = $this->db->query($sql);

        // print_r2($db->result_array());
        $result = array();
        foreach ($db->result_array() as $row) {
            $buff=array(
                'id'=>$row['id_kontak'],
                'text'=>$row['nama_kontak']." (".$row['nama_kota'].")"
            );
            array_push($result,$buff);
        }

        $res = array(
            'results' => $result,
            'pagination' => array(
                'more' => false
            )
        );
        header_json();
        echo json_encode($res);
    }
}
