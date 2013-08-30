<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cmd extends CI_Controller 
{
    public function __construct()
    {
    	parent::__construct();
    }

	public function is_hello($msg = "NULL")
	{
		$msg = urldecode($msg);
		echo "your message is : {$msg}<br>";
	}
}
