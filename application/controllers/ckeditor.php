<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ckeditor extends CI_Controller
{
    public function __construct()
    {
    	parent::__construct();
    }

	public function index()
	{
		$value = $this->input->get_post('editor1');

		$this->load->view("ckeditor_view", ['value' => $value]);
	}
}
