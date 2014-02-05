<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Benchmark_test extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->benchmark->mark('a');
		for ($i=0; $i < 10000; $i++) 
		{ 
			$j++;
		}
		echo $this->benchmark->elapsed_time('a');
		echo $this->benchmark->memory_usage();
	}
	// $this->benchmark->elapsed_time('tag');
	$this->benchmark->memory_usage();
	$this->benchmark->mark('tag');
}
