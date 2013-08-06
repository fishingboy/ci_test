<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Debug extends CI_Controller 
{
	public function index()
	{
		// 載入 firephp
		$this->load->helper("firephp");

		// 載入 parser
		$this->load->library("parser");

		// 輸出到 firebug
		fb_log($this);

		// 說明
		echo "請看 firebug 頁面的主控台！";
	}
}
