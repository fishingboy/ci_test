<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller
{
	private $_db_ro = 'success!!';

    public function __construct()
    {
    	parent::__construct();
    	$this->load->model("test_model");
    }

    public function _get_db_ro()
    {
    	return $this->_db_ro;
    }
}
