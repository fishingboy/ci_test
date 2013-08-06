<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bingo extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
	}

	public function index($match)
	{
		echo "<h1>Bingo!!</h1>";
		echo "<h1>$match</h1>";
		write_file("D:/www/log.txt", "'$match'");
	}
}
