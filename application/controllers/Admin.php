<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function caches()
	{
		$list = get_dir_file_info(APPPATH . 'cache/');
		$this->set_view_data($list);
		$this->view('admin/caches');
	}

	public function delete_cache()
	{
		$params = params_check($_POST, array('cache_name'));

		if (!$params['cache_name']) {
			exit($this->get_params_error_response());
		}

		unlink(APPPATH . 'cache/' . $params['cache_name']);
		exit($this->get_request_success_response());
	}
}
