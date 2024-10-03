<?php

class Pembelian extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $auth = new Auth();
        $auth->logged_in();
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
        $post_data = $this->input->post();
        $ko_output_str = in_post('ko_output');
        $ko_output = json_decode($ko_output_str, true);

        print_r2($ko_output);
    }
}
