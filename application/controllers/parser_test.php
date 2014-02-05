<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parser_test extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
    {
    	parent::__construct();
    	$this->load->library("parser");
    }

	public function index()
	{
		$data = array("title" => "fishingboy", "body" => "很菜!!");
		$this->parser->parse("parser_test_tmpl", $data);
	}

	public function test2()
	{
		$data = array('data' => array
		(
			array('account' => 'wbkuo',   'name' => "郭文彬"),
			array('account' => 'leo.kuo', 'name' => "Leo.Kuo")
		));
		$this->parser->parse("parser_test_view", $data);
	}
}
