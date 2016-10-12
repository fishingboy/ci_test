<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->lang->load('common', 'tw');
	}

	public function index()
	{
		$hello = $this->lang->language;
		header("Content-Type:text/html; charset=utf-8");
		echo "<pre>hello = " . print_r($hello, TRUE). "</pre>";
	}

	public function index2()
	{
		$this->load->view('lang_view');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */