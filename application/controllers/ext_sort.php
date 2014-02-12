<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ext_sort extends CI_Controller 
{
    public function __construct()
    {
    	parent::__construct();
    	$this->load->helper("external_sort");
    }

	public function index()
	{
		$sort_hander = new External_sort();
		for ($i=0; $i <10; $i++) 
		{ 
			$sort_hander->add_data(rand(0, 100));
		}
		// $sort_hander->add_data(array(1,6,4,9,8,2));
		$sort_hander->get_result();
		$sort_hander->create_result();
	}
}
