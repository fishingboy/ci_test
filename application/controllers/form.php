<?php

/**
 * form_validation 使用範例
 */
class Form extends CI_Controller {

	function index()
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');

		// $this->form_validation->set_message('required', '[%s] 為必填欄位!');
		// $this->form_validation->set_rules('username', '姓名', 'required');
		// $this->form_validation->set_rules('password', '密碼', 'required|regex_match[/^[a-d]$/]',[
		// 	'required'    => 'required error!',
		// 	'regex_match' => 'regex_match error!',
		// ]);
		$this->form_validation->set_rules('password', '密碼', 'required',[
			'required'    => 'required error!',
			// 'regex_match' => 'regex_match error!',
		]);
		// $this->form_validation->set_rules('password', '密碼', '');
		// $this->form_validation->set_rules('passconf', '密碼確認', 'required');
		// $this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('myform');
		}
		else
		{
			$this->load->view('formsuccess');
		}
	}
}
?>