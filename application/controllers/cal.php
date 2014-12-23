<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cal extends CI_Controller 
{
    public function __construct()
    {
    	parent::__construct();
    	$this->load->model("cal_model");
    }

	public function index()
	{
		echo $this->cal_model->add(1,2);
	}

	public function get_def()
	{
		// echo BASEPATH;
		echo "<pre>" . print_r(get_defined_constants(1)[user], TRUE). "</pre>";

	}

	public function pow($n)
	{
		return $n * $n;
	}
}
