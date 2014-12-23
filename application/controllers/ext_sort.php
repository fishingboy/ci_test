<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ext_sort extends CI_Controller 
{
    public function __construct()
    {
    	parent::__construct();
    	$this->load->helper("external_sort");
    }

	public function index()
	{
        // 建立外部排序元件
		$sort_hander = new External_sort(array
        (
            'block_size' => 10,
            'data_type'  => 'text'
        ));


		for ($i=0; $i <1000; $i++) 
		{ 
			$sort_hander->add_data(rand(0, 10000));
		}

        // $sort_hander->add_data(5);
        // $sort_hander->add_data(41);
        // $sort_hander->add_data(53);
        // $sort_hander->add_data(1);
        // $sort_hander->add_data(4);
        // $sort_hander->add_data(32);
        // $sort_hander->add_data(15);
        // $sort_hander->add_data(78);
        // $sort_hander->add_data(99);
        // $sort_hander->add_data(57 );

		// $sort_hander->get_result();
		$sort_hander->create_result();
        echo "排序完畢!";
	}
}
