<?php
//capital L for class name
class cal_model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }

	public function add($a, $b) 
	{
		return $a + $b;;
	}
}

