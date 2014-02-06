<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Err extends CI_Controller 
{
	public function index()
	{
		echo "<div style='font-size:200px;'>ERROR PAGE</div>";
	}

	public function page_404()
	{
		echo "<div style='font-size:200px;'>404 PAGE</div>";
	}
}
