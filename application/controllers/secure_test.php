<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secure_test extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		echo <<<HTML
		<a href='http://ci/secure_test/E??'>http://ci/secure_test/E??</a>
HTML;
	}
}
