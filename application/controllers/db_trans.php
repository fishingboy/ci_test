<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 資料庫交易 trans 的測試
 */
class Db_trans extends CI_Controller
{
    public function __construct()
    {
    	parent::__construct();
        $this->load->database();
        header("Content-Type:text/html; charset=utf-8");
    }

    public function index()
    {
    	echo "hello world!!";
    }

    public function test1()
    {
        // 交易開始
        $this->db->trans_begin();

        $query = $this->db->insert("category", array
        (
            'name'  => 'hahaha...',
            'count' => 100
        ));

        // 交易狀態
        $status = $this->db->trans_status();
        echo "交易狀態: {$status} <br>";

        echo "寫入筆數為: " . $this->db->affected_rows() . "<br>";
    }

    public function test2()
    {
    	// 交易開始
    	$this->db->trans_begin();

        for ($i=0; $i<3; $i++)
        {
        	$query = $this->db->insert("clicker_questions", [
                'course_id'   => 1,
                'description' => 'LALALALALA',
            ]);
        }

    	// 交易狀態
    	$status = $this->db->trans_status();
    	echo "交易狀態: {$status} <br>";

		echo "寫入筆數為: " . $this->db->affected_rows() . "<br>";
        // $this->db->trans_rollback();
        $this->db->trans_commit();
     }
}
