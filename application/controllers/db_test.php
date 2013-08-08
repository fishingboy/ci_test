<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DB_test extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();

        // 沒有使用 autoload 才需要載入
        // $this->load->database();
    }

    public function test1()
    {
        $query = $this->db->query("SELECT * FROM category");

        echo "<pre>" . print_r($query, true) . "</pre>";
        echo "資料總共" . $query->num_rows() . "筆.<br>";
        echo "<pre>" . print_r($query->result(), true) . "</pre>";
    }
    
    public function test2()
    {
        $query = $this->db->query("SELECT * FROM category");
        
        $i = 0;
        while ($obj = $query->next_row())
        {
            $i++;
            echo "<pre>" . print_r($obj, true). "</pre>";
            if ($i == 10) break;
        }
    }
    
}
