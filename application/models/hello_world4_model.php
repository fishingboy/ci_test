<?php
//capital L for class name
class hello_world4_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
        // echo "!!!!!!!!!!!";
    }
	public function get_data() 
	{
		return array('account' => 'Leo Kuo', 'name' => '郭文彬');
	}
}

