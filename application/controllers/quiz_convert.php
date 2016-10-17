<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 題庫資料轉換
 */
class Quiz_convert extends CI_Controller 
{
    public function __construct()
    {
    	parent::__construct();
    }

    public function index()
    {
        header("Content-Type:text/html; charset=utf-8");
        $this->load->library("quiz_parser");
        $this->quiz_parser->setContent();
        $data = $this->quiz_parser->getData();
        echo "<pre>data = " . print_r($data, TRUE). "</pre>";
    }

	public function json()
	{
        header("Content-Type:text/html; charset=utf-8");
        $this->load->library("quiz_parser");
        $this->quiz_parser->setContent();
        $data = $this->quiz_parser->getData();
        // echo "<pre>data = " . print_r($data, TRUE). "</pre>";
        echo json_encode($data);
	}
}
