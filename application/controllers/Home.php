<?php

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $auth=new Auth();
        $auth->logged_in();

        // $auth->is_superadmin();
    }

    function index()
    {

        $template=new Template();

        $template->set_html('');
        $template->set_title('Home');
        $template->render();

    }

}