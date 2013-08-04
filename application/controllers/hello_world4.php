<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hello_world4 extends CI_Controller 
{
	public function index()
	{
		$this->load->model('hello_world4_model');
		// echo "<pre>" . print_r($this, true) . "</pre>";
		$data = $this->hello_world4_model->get_data();
		$this->load->view('hello_world4', $data);
	}
	public function filelog($msg)
	{

	}
}
