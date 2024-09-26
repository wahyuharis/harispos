<?php
class Auth
{
    function logged_in()
    {
        $ci = &get_instance();

        $username = $ci->session->userdata('username');
        $password = $ci->session->userdata('password');

        // print_r2($_SESSION);

        if (($username) && ($password)) {
            $where = " (username = " . $ci->db->escape($username) . " or email = " . $ci->db->escape($username) . " ) 
            and password = " . $ci->db->escape($password) . " 
            ";
            $db = $ci->db->where($where)->get('users');

            if ($db->num_rows() > 0) {
                //
            } else {
                $ci->session->sess_destroy();
                $ci->session->set_flashdata('error_message', 'Maaf Anda Belum Login');
                redirect('login');
            }
        } else {
            $ci->session->sess_destroy();
            $ci->session->set_flashdata('error_message', 'Maaf Anda Belum Login');
            redirect('login');
        }
    }

    function harus_superadmin()
    {
        $ci = &get_instance();

        $username = $ci->session->userdata('username');
        $password = $ci->session->userdata('password');

        $where = " (username = " . $ci->db->escape($username) . " or email = " . $ci->db->escape($username) . " ) 
        and password = " . $ci->db->escape($password) . " 
        ";
        $db = $ci->db->where($where)
            ->join('users_jabatan', 'users_jabatan.id_jabatan=users.id_jabatan', 'left')
            ->limit(1)
            ->get('users');

        $userdata = $db->row_array();

        if($userdata['nama_jabatan']=='superadmin'){
            return true;
        }else{
            return false;
        }        
    }
}
