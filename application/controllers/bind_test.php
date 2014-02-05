<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bind_test extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();

        // 沒有使用 autoload 才需要載入
        // $this->load->database();
    }

    // 基本的 query 
    public function test1()
    {
        $query = $this->db->query("SELECT * FROM category");
        echo "<pre>" . print_r($query->result(), TRUE). "</pre>";
    }

    // 基本的 query 
    public function test2()
    {
        $query = $this->db->query("SELECT * FROM category WHERE id=?", array(1));
        echo "<pre>" . print_r($query->result(), TRUE). "</pre>";
    }

    // 基本的 query 
    public function test3()
    {
        $query = $this->db->query("SELECT * FROM category WHERE id=:id", array(':id' => 1));
        echo "<pre>" . print_r($query->result(), TRUE). "</pre>";
    }
}
