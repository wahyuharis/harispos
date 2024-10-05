<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tester extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // $this->load->model('Stock_model');
        // $stock=new Stock_model();
        // $stock->stock_in('2024-10-04 19:48:26',1,5,6000);

        $kode_pembelian = str_pad(10000000, 5, "0",STR_PAD_LEFT);
        echo $kode_pembelian;
    }
}
