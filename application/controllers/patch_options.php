<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class patch_options extends CI_Controller
{
    private $old_table = "content";
    // private $old_table = "clicker_options_backup";

    private $table = "content2";
    // private $table = "clicker_options";

    private $time_field = "create_time";
    // private $time_field = "created_at";

    private $page_size = 10;
    // private $page_size = 1000;

    private $page = 1;

    private $count = 0;

    private $total_page = 0;

    private $update = FALSE;

    private $start_id = 1;

    private $debug_mode = FALSE;

    public function index()
    {
    	echo "patch start...<br><br>";
        $this->update = $this->input->get('update');
        $this->page = $this->input->get('page');
        $this->page = ($this->page) ? intval($this->page) : 1;

        // 舊資料
        $rows = $this->get_old_data();
        $old_data = $old_ids = [];
        foreach ($rows as $i => $row)
        {
            $old_data[$row['id']] = $row;
            $old_ids[] = $row['id'];
        }

        // 新資料
        $new_data = $ignore_data = [];
        $rows = $this->get_new_data(['id' => $old_ids]);
        foreach ($rows as $i => $row)
        {
            $new_data[$row['id']] = $row;
        }

		// 顯示分頁資訊
        $this->show_page_info();

        // 處理資料
        $old2new_id = [];
        $old_rollback_id = [];
        foreach ($old_data as $i => $old_row)
        {
            $old_id = $old_row['id'];
            if (isset($new_data[$old_id]))
            {
                $new_row = $new_data[$old_id];

                if ($this->debug_mode)
                {
	                echo "<pre>old = " .  print_r($old_row, TRUE) ."</pre>";
	                echo "<pre>new = " .  print_r($new_row, TRUE) ."</pre>";
                }

                if ($new_row[$this->time_field] == $old_row[$this->time_field])
                {
                    // 已匯入的資料，直接忽略
                    echo "忽略 " . $old_row['id'] . " (新舊資料相同)....<br>";
                }
                else
                {
                    // 重複 id 要重新建立
                    if ($this->update)
                    {
                    	// 取新的 id
                        unset($old_row['id']);

                        $new_id = $this->insert_data($old_row);
                        if (FALSE === $new_id)
                        {
                            echo '新增失敗<br>';
                            exit;
                        }

                        $old2new_id[$old_id] = $new_id;
                    }
                    else
                    {
                        echo "重複 id : " . print_r($old_row, TRUE) . "<br>";
                    }
                }
            }
            else
            {
                // 新增資料
                if ($this->update)
                {
                    $status = $this->insert_data($old_row);
                    if (FALSE === $status)
                    {
                        echo '新增失敗<br>';
                        exit;
                    }

                    $old_rollback_id[] = $old_id;
                }
                else
                {
                    echo "不存在的 id : " . print_r($old_row, TRUE) . "<br>";
                }
            }
        }

        // 重複 id 成功
        if (count($old2new_id) > 0)
        {
            echo "<pre>重複 id 的 舊資料 rollback = " . print_r($old2new_id, TRUE). "</pre>";

            // 處理關聯資料表的轉換
            // foreach ($old2new_id as $i => $id)
            // {
            // 	// do something...
            // }
        }

        // 不存在的 id 成功
        if (count($old_rollback_id) > 0)
        {
            // var_dump(expression)
            echo "<pre>舊資料 rollback = " . print_r($old_rollback_id, TRUE). "</pre>";
        }

        // 前往下一頁
        if ($this->page < $this->total_page && $this->update)
        {
        	$next_url = "/index.php/patch_options?page=" . ($this->page + 1) . "&update=1";
        	echo "<br>" . $next_url . "<br>";

            if ( ! $this->debug_mode)
            {
        	   echo "<script>window.location.href = '" . $next_url . "';</script>";
            }
        }

        echo "patch end ...<br>";
    }


    /**
     * 顯示分頁資訊
     */
    public function show_page_info()
    {
    	$finish_record_count = ($this->page) * $this->page_size;
        if ($finish_record_count > $this->count) $finish_record_count = $this->count;
    	$finish_percent = number_format(($finish_record_count / $this->count) * 100, 2);

    	echo <<<HTML
	    <div>符合筆數: {$this->count}</div>
	    <div>完成度: {$finish_record_count} / {$this->count} ({$finish_percent} %)</div>
	    <div>頁數: {$this->page} / {$this->total_page}</div>
        <br>
        <br>
HTML;
    }

    /**
     * 取得舊資料
     */
    public function get_old_data()
    {
        $page_size = $this->page_size;
        $page = $this->page;

        $obj = $this->db->from($this->old_table)
                        ->where('id > ', $this->start_id)
                        ->order_by('id', 'ASC');

        $obj2 = clone $obj;

        $query = $obj->limit($page_size, ($page - 1) * $page_size)->get();

        if ($this->debug_mode)
        {
            $sql = $this->db->last_query();
            echo "get_old_data.sql = " . $sql . "<br>";
        }

        // 取得資料總數
        $count = $obj2->count_all_results();


        $this->count = $count;
        $this->total_page = ceil($this->count / $this->page_size);

        return $query->result_array();
    }

    /**
     * 取得新資料
     */
    public function get_new_data($params)
    {
        $ids = (isset($params['id'])) ? $params['id'] : [];
        if (count($ids) == 0)
        {
            echo "get_new_data error! <br>";
            return FALSE;
        }
        $query = $this->db->from($this->table)
                        ->where_in('id', $ids)
                        ->get();

        if ($this->debug_mode)
        {
            $sql = $this->db->last_query();
            echo "get_new_data.sql = " . $sql . "<br>";
        }

        return $query->result_array();
    }

    /**
     * 寫入資料
     */
    public function insert_data($param = [])
    {
        $ret = $this->db->insert($this->table, $param);
        if ( ! $ret)
        {
            $this->_error = "新增資料表資料 {$this->table} 失敗!";
        }
        return ($ret) ? $this->db->insert_id() : FALSE;
    }
}