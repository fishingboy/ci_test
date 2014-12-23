<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nokia_sms_to_android extends CI_Controller 
{
    var $file            = 'C:\Users\Leo\Desktop\evonne_nokia_sms_clear.csv';
    var $result_file     = 'C:\Users\Leo\Desktop\leo_nokia_sms_clear.xml';
    var $result_xml_file = 'C:\Users\Leo\Desktop\evonne.sms.xml';

    public function __construct()
    {
        parent::__construct();

        define('TYPE_READ', 1);
        define('TYPE_SEND', 2);

        $this->load->library("parser");
    }

	public function index()
	{
        echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';

		$fp = fopen($this->file, "r");
        $total = 0;
        $data = array();
        while (($csv_data = $this->fgetcsv_reg($fp, 1000, "UTF-8", ",")) !== FALSE)
        {
            $total++;
            $status_code = $csv_data[1];
            $type = ($status_code == "READ,RECEIVED") ? TYPE_READ : TYPE_SEND;
            $sms_time = $this->convert_date($csv_data[5]);
            $read_time = $this->convert_read_date($sms_time);
            if ($type == 1)
            {
                $send_time = $sms_time;
                $address = $this->convert_send_phone($csv_data[2], $type);                
            }
            else
            {
                $send_time = 0;
                $address = $this->convert_send_phone($csv_data[3], $type);                   
            }

            if ($address != "+886911862970" && $address != "+886 911 862 970")  continue;

            $data[] = array
            (
                'address'      => $address,
                'date'         => $sms_time,
                'type'         => $type,
                'message'      => $this->xml_specialchars($csv_data[7]),
                'send_date'    => $send_time,
                'read_date'    => $read_time,
                'contact_name' => "",
            );

            // if (++$total >= 10) break;
        }

        echo "<pre>data = " . print_r($data, TRUE). "</pre>";

        $view_data = array
        (
            'sms_total' => $total,
            'data'      => $data, 
        );
        $xml_result = $this->parser->parse("nokia_sms_xml", $view_data, TRUE);
        echo $xml_result;

        // 寫入檔案
        $fp2 = fopen($this->result_file, "w");
        fwrite($fp2, $xml_result);
        fclose($fp2);

        // 關閉檔案
        fclose($fp);
	}

    public function check()
    {
        // 存取結果檔案
        // echo $this->result_xml_file . "<br>";
        $result_content = file_get_contents($this->result_xml_file);
        // echo $result_content . "<br><br>";
        $fp = fopen($this->file, "r");
        $total = 0;
        $data = array();
        while (($csv_data = $this->fgetcsv_reg($fp, 1000, "UTF-8", ",")) !== FALSE)
        {
            $total++;
            $sms_time = $this->convert_date($csv_data[5]);
            if (strpos($result_content, $sms_time) !== FALSE)
            {
                // echo "$total: find! <br>";
            }
            else
            {
                echo "$total: Not find! <br>";   
                echo "<pre>csv_data = " . print_r($csv_data, TRUE). "</pre>";
            }
        }

    }

    public function convert_date($date='')
    {
        // 2014.06.04 16:08
        $tmp  = explode(" ", $date);
        $tmp1 = explode('.', $tmp[0]);
        $tmp2 = explode(':', $tmp[1]);
        $year = $tmp1[0];
        $month = $tmp1[1];
        $day = $tmp1[2];
        $hour = $tmp2[0];
        $minute = $tmp2[1];
        $second = 0;
        // echo "$date => $year-$month-$day $hour:$minute <br>";

        return mktime($hour, $minute, $second, $month, $day, $year) . '000';
    }

    public function convert_read_date($date)
    {
        $new_date = date("Y/m/d Ah:i:00", $date);
        $new_date = str_replace("AM", "上午", $new_date);
        $new_date = str_replace("PM", "下午", $new_date);
        return $new_date;
    }

    public function convert_send_phone($phone="", $type=1)
    {
        // echo "\$phone => '$phone' <br>";
        if (substr($phone, 0, 1) == '0')
        {
            $phone = '+886' . substr($phone, 1);
        }

        if (substr($phone, 0, 1) != '+')
        {
            $phone = '+' . $phone;
        }

        $new_phone = $phone;
        if ($type == 2)
        {
            $p1 = substr($phone, 0, 4);
            $p2 = substr($phone, 4, 3);
            $p3 = substr($phone, 7, 3);
            $p4 = substr($phone, 10);
            $new_phone = "$p1 $p2 $p3 $p4";
        }
        // echo "$phone => $new_phone <br>";
        return $new_phone;
    }

    public function xml_specialchars($str)
    {
        $str = str_replace("\x0B", "", $str);  // 垂直tab字元(\v)
        $str = str_replace("\x0C", "", $str);  // 跳頁字元(\f)
        $str = str_replace("\x08", "", $str);  // backspace
        $str = htmlspecialchars($str, ENT_QUOTES);
        return $str;
    }

    public function fgetcsv_reg(&$handle, $length=null, $charset='UTF-8', $d=',', $e='"')
    {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        $eof = false;
        while ($eof != true && !feof($handle))
        {
            $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
            if ($itemcnt % 2 == 0) $eof = true;
        }

        $charset = strtoupper($charset);
        if ($charset == "UTF-8" || $charset == "UTF8")
            $_line = $this->remove_bom_str($_line);
        else        
            $_line = iconv($charset, "UTF-8//IGNORE", $_line);  

        $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));
        $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];

        for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++)
        {
            $_csv_data[$_csv_i] = preg_replace('/^' . $e . '(.*)' . $e . '$/s', '$1', $_csv_data[$_csv_i]);
            $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
        }

        return empty ($_line) ? false : $_csv_data;
    }

    function remove_bom_str($contents)
    {
        $charset[1] = substr($contents, 0, 1);
        $charset[2] = substr($contents, 1, 1);
        $charset[3] = substr($contents, 2, 1);
        if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191)
        {
            $rest = substr($contents, 3);
            return $rest;
        }
        else
        {
            return $contents;
        }
    }
}
