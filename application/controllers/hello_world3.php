<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class hello_world3 extends CI_Controller 
{
	public function index()
	{
		$data = array
		(
			'account' => 'wbkuo',
			'name'    => '郭文彬'
		);

		$this->load->view('hello_world3', $data);
	}
}
