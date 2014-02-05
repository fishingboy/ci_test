<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stack extends CI_Controller 
{
    public function __construct()
    {
    	parent::__construct();
    }

	public function index()
	{
	}


	public function test()
	{
		$point_array = array
		(
			array('00', '01'),
			array('10', '11'),
		);

		// $point_array = array
		// (
		// 	array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0'),
		// 	array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'),
		// 	array('!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '~'),
		// 	array('z', 'x', 'c', 'v', 'b', 'n', 'm', 'a', 's', 'd', 'f', 'g', 'h', 'j'),
		// );

		$this->benchmark->mark('m1');
		$this->all_path($point_array);
		$this->benchmark->mark('m2');
		echo $this->benchmark->elapsed_time('m1', 'm2') . " Second. <br>";	

		$this->benchmark->mark('m3');
		$this->all_path2($point_array);
		$this->benchmark->mark('m4');
		echo $this->benchmark->elapsed_time('m3', 'm4') . " Second. <br>";	
	}

	/* 遞迴寫法 */
	public function all_path($point_array, $depth=0, $path="")
	{
		static $max_depth;
		$max_depth = count($point_array);

		if ($depth == $max_depth) 
		{
			$this->show_path($path);
			return true;
		}

		for ($i=0, $i_max=count($point_array[$depth]); $i<$i_max; $i++)
		{
			$path[$depth] = $point_array[$depth][$i];
			$this->all_path($point_array, $depth+1, $path);
		}		

		return true;
	}

	public function show_path($path)
	{
		echo implode(" -> ", $path) . "<br>";
	}

	/* 堆疊寫法 */
	public function all_path2($point_array)
	{
		$max_depth = count($point_array);

		// 堆疊
		$stack = array();

		
		$index = array();  // 每一層目前的位置
		$length = array(); // 找出每一層的深度
		for ($i=0, $i_max=count($point_array); $i<$i_max; $i++)
		{
			$length[] = count($point_array[$i]);
			$index[] = 0;
		}

		echo "<pre>" . print_r($length, TRUE). "</pre>";



		// 把 0,0  放進堆疊
		array_push($stack, $point_array[0][0]);

		$depth = 0;
		$k=0;
		while (count($stack))
		{
			if ($k++ > 100) break;

			$next_depth = $depth + 1;
			if ($next_depth == $max_depth) 
			{
				$this->show_path($stack);
				$node = array_pop($stack);
				$index[$depth]++;
				$depth--;
				continue;
			}

			if ($index[$next_depth] < $length[$next_depth] -1)
			{
				$node = $point_array[$next_depth][$index[$next_depth]];
				array_push($stack, $node);
				$depth++;
			}
			else
			{
				$node = array_pop($stack);
				$index[$depth]++;
				$depth--;
			}
			echo print_r($stack) . "<br>";
		}

		return true;
	}


	public function test1()
	{
		$this->benchmark->mark('m1');
		echo $this->bbb(10000) . "<br>";
		$this->benchmark->mark('m2');
		echo $this->benchmark->elapsed_time('m1', 'm2') . "<br>";	


		$this->benchmark->mark('m3');
		echo $this->aaa(10000) . "<br>";
		$this->benchmark->mark('m4');
		echo $this->benchmark->elapsed_time('m3', 'm4') . "<br>";

	}

	public function aaa($n)
	{
		if ($n == 1) return 1;
		return $n + $this->aaa($n-1);
	}

	public function bbb($n)
	{
		$stack = array($n);
		$ans = 0;
		$back = 0;
		while (count($stack))
		{
			if ($n == 1) $back = 1;
			if ($back)
			{
				$n = array_pop($stack);
				$ans += $n;
			}
			else
			{
				$n--;
				array_push($stack, $n);
			}
		}

		return $ans;
	}
}
