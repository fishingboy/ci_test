<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hello_world4 extends CI_Controller 
{
	public function index()
	{
		$this->load->model('hello_world4');
		echo "";
		$this->load->view('hello_world4', $data);
	}
	public function filelog($msg)
	{

	}
}
