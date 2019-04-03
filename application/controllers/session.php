<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");
    }

    public function get()
	{
	    $user_data = $this->session->all_userdata();
        echo "<pre>user_data = " . print_r($user_data, true) . "</pre>\n";
	}

    public function set()
	{
	    $this->session->set_userdata('test', 123);
	    echo '$this->session->set_userdata(\'test\', 123); ok ';
	}
}
