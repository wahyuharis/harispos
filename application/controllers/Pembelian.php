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
        $content_data=array();

        $template = new Template();
        $template->set_content('pembelian/pembelian_add', $content_data);
        $template->set_title('Add Pembelian');
        $template->render();
    }
}
