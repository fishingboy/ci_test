<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debug extends CI_Controller 
{
	public function index()
	{
		$this->load->helper("firephp");
		fb($this);
	}
}
