<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Zsetting extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $auth = new Auth();
        $auth->logged_in();
        $auth->harus_superadmin();
    }

    function index()
    {
        $content_data = array();

        $db = $this->db->get('_setting');

        $buff = array();
        foreach ($db->result_array() as $row) {
            $buff[$row['variable']] = $row['value'];
        }

        $content_data['company_name'] = $buff['company_name'];
        $content_data['company_logo'] = $buff['company_logo'];
        $content_data['company_address'] = $buff['company_address'];
        $content_data['pos_printer_addres'] = $buff['pos_printer_addres'];

        $template = new Template();

        $template->set_content('zsetting/setting', $content_data);
        $template->set_title('Setting');
        $template->render();
    }
    function submit()
    {
        $message = '';
        $data = [];
        $success = true;

        $post_data = $this->input->post();
        // print_r2($post_data);

        $file_uploaded = "";

        $config['upload_path']          = './company_logo/';
        $config['allowed_types']        = 'gif|jpg|png';
        $this->load->library('upload', $config);

        if (!empty($_FILES['company_logo']['name'])) {
            if ($this->upload->do_upload('company_logo')) {
                $upload_data = $this->upload->data();
                $file_uploaded = $upload_data['file_name'];
            } else {
                $err = $this->upload->display_errors();
                $success = false;
                $message .= $err;
            }
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('company_name', 'Nama Perusahaan', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $success = false;
            $message .= validation_errors();
        }

        if ($success) {
            $this->db->where('variable', 'company_name');
            $this->db->update('_setting', array('value' => in_post('company_name')));

            $this->db->where('variable', 'company_address');
            $this->db->update('_setting', array('value' => in_post('company_address')));

            $this->db->where('variable', 'pos_printer_addres');
            $this->db->update('_setting', array('value' => in_post('pos_printer_addres')));

            if (!empty($file_uploaded)) {
                $file_uploaded = "company_logo/" . $file_uploaded;
                $this->db->where('variable', 'company_logo');
                $this->db->update('_setting', array('value' => $file_uploaded));
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
}
