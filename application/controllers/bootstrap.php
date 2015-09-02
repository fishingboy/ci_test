<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bootstrap extends CI_Controller
{
    public function __construct()
    {
    	parent::__construct();
    	$this->load->library('parser');
    }

	public function index($view = '')
	{
		$view_name = "bootstrap_view" . $view;
    	$this->parser->parse($view_name, []);
	}
}
