<?php
/**
 * 外部排序
 * @author Leo.Kuo
 */
class External_sort
{
    // 設定
    var $unique      = FALSE;           // 是否移除重覆資料
    var $block_size  = 10;            // 幾筆資料寫入一次檔案
    var $result_file = "result.txt";    // 結果檔案

    // 資料
    var $num        = 0;                // 項目數量
    var $tmp_array  = array();          // 資料暫存區
    var $file_num   = 0;                // 檔案數量
    var $file_array = array();          // 排序使用的檔案

    public function __construct($config=NULL)
    {
        if (isset($config['unique']))     $this->unique = $config['unique'];
        if (isset($config['block_size'])) $this->block_size = $config['block_size'];
    }

    // 新增項目
    public function add_data($data)
    {
        // 寫入暫存陣列
        if (is_array($data))
        {
            $this->tmp_array = array_merge($this->tmp_array, $data);
        }
        else
        {
            $this->tmp_array[] = $data;
        }

        // 超過數量限制，寫入檔案
        if (count($this->tmp_array) > $this->block_size)
        {
            $this->write_file($this->tmp_array);
        }
    }

    // 寫入暫存檔案
    public function write_file($data)
    {
        $this->file_array[] = tmpfile();
        $fp = $this->file_array[count($this->file_array)-1];

        sort($this->tmp_array);
        foreach ($this->tmp_array as $value) 
        {
            fwrite($fp, $value."\n");
        }

        // 清空暫存陣列
        $this->tmp_array = array();
    }

    // 產生結果檔案
    public function create_result()
    {
        // 合併結果
    }

    public function get_result()
    {
        // 把剩餘的資料寫入
        if (count($this->tmp_array) > 0)
        {
            $this->write_file($this->tmp_array);
        }

        echo "\$file_num = " . count($this->file_array) . "<br>";
        echo "<pre>" . print_r($this->file_array, TRUE). "</pre>";
        
        while (count($this->file_array))
        {
            $fp = array_pop($this->file_array);
            fseek($fp, 0);            
            while (($line = fgets($fp)) !== FALSE)
            {
                echo "$line <br>";
            }
            fclose($fp); // this removes the file
        }
    }
}