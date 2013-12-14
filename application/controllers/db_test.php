<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DB_test extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();

        // 沒有使用 autoload 才需要載入
        // $this->load->database();
        $this->load->helper("firephp");
    }

    public function index()
    {
        $this->load->view('db_test_view');
    }

    // 基本的 query 
    
    public function test1()
    {
        $query = $this->db->query("SELECT * FROM category");

        echo "\$this->db->query() 回傳的物件:<pre>" . print_r($query, true) . "</pre>";
        echo "\$query->num_rows(), 資料總共" . $query->num_rows() . "筆, 欄位共 " . $query->num_fields() . " 個.<br>";
        echo "\$query->result(), 回傳結果(Object):<pre>" . print_r($query->result(), true) . "</pre>";
        echo "\$query->result_array(), 回傳結果(Array):<pre>" . print_r($query->result_array(), true) . "</pre>";
    }
    
    // 一次回傳一筆
    public function test2()
    {
        $query = $this->db->query("SELECT * FROM category WHERE name=?", array("哈哈'哈"));
        
        // 取回 query 的字串        
        $this->_print_queries();

        echo "\$query->next_row(), 一次回傳一筆記錄(不好用!)<br>";

        $i = 0;
        while ($obj = $query->next_row())
        {
            $i++;
            echo "<pre>" . print_r($obj, true). "</pre>";
            if ($i == 10) break;
        }
    }

    // active Record 
    public function test3()
    {
        // 查詢
        $query = $this->db->get("category");        
        echo "<pre>" . print_r($query, true) . "</pre>";
        echo "資料總共" . $query->num_rows() . "筆.<br>";
        echo "<pre>" . print_r($query->result(), true) . "</pre>";
    }
    
    public function test4()
    {
        // active Recore 寫入
        $this->db->insert("CATEGORY", array
        (
            'name'  => "哈哈'哈",
            'count' => 3
        ));
        echo "新增共 " . $this->db->affected_rows() . " 筆, 編號" . $this->db->insert_id() . ".<br>";

        // 封裝寫入(類似 pdo)
        $query = $this->db->query("INSERT INTO CATEGORY SET name=?, count=?", array("123'", 333));
        echo "新增共 " . $this->db->affected_rows() . " 筆, 編號" . $this->db->insert_id() . ".<br>";

        fb_log($this->db);

        // 封裝寫入(類似 pdo key?)
        // 看起來行不通啊 !!
        // $query = $this->db->query("INSERT INTO CATEGORY SET name=:name, count=:count", array(':name' => '123', ':count' => 333));
        // echo "新增共 " . $this->db->affected_rows() . " 筆, 編號" . $this->db->insert_id() . ".<br>";

        // 取回 query 的字串        
        $this->_print_queries();
    }

    //
    public function test5()
    {
        // 最後的查詢
        $query = $this->db->query("SELECT * FROM category");
        echo "最後的查詢為: " . $this->db->last_query() . "<br>";
        
        // insert string
        $sql = $this->db->insert_string("CATEGORY", array
        (
            'name'        => "I'm try it !",
            "count"       => 3,
        ));
        echo "新增語法: \$sql = $sql <br>";

        // update string
        $sql = $this->db->update_string("CATEGORY", array
        (
            'name'        => "I'm try it !",
            "count"       => 3,
        ), "count='3'");
        echo "更新語法: \$sql = $sql <br>";
    }

    public function test6()
    {
        
    }

    // 取回 query 的字串
    private function _print_queries()
    {
        echo "query 字串: <pre>" . print_r($this->db->queries, TRUE). "</pre>";
    }
}
