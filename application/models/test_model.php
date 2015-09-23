<?php
class Test_model extends CI_Model
{
    private $_CI;

    function __construct()
    {
        parent::__construct();
        $this->_CI = & get_instance();
        echo $this->_CI->_get_db_ro();
    }
}

