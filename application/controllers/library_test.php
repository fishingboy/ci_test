<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class library_test extends CI_Controller
{
	public function index()
	{
		$status = $this->load->library("api", ['name' => 123]);
		var_dump($status);
		echo "<pre>this->api = " . print_r($this->api, TRUE). "</pre>";
		$status = $this->load->library("api", ['name' => 456]);
		var_dump($status);
		echo "<pre>this->api = " . print_r($this->api, TRUE). "</pre>";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */