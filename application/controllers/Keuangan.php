<?php

class Keuangan extends CI_Controller
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

        $template->set_content('keuangan/keuangan_list', []);
        $template->set_title('Keuangan');
        $template->render();
    }
}