<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('role_model');
	}

	public function manage()
	{
		$list = $this->role_model->get_roles_list();
		$this->set_view_data($list);
		$this->view('role/list');
	}

	public function info()
	{
		$params = params_check($_GET, array('role_id'));

		if (!is_numeric($params['role_id'])) {
			show_404();
		} else {
			$info = $this->role_model->get_role($params['role_id']);
			$this->set_view_data($info);
			$this->page_data['has_form'] = true;
			$this->view('role/info');
		}
	}

	public function add()
	{
		if ($this->input->is_ajax_request()) {
			$params = params_check($_POST, array('name', 'description'));

			if (!$params['name']) {
				exit($this->get_params_error_response());
			}

			$data = params_filter($_POST, array('name', 'description', 'privileges'));
			$id = $this->role_model->insert_role($data);

			if ($id > 0) {
				$this->clear_all_cache();
				exit($this->get_request_success_response());
			} else {
				exit($this->get_request_failed_error_response());
			}
		} else {
			$this->page_data['has_form'] = true;
			$this->view('role/add');
		}
	}
	
	public function update()
	{
		$params = params_check($_POST, array('role_id', 'name', 'description'));

		if (!$params['role_id']) {
			exit($this->get_params_error_response());
		}

		$data = params_filter($_POST, array('name', 'description', 'privileges'));
		$this->role_model->update_role($data, array('role_id'=>$params['role_id']));
		$this->clear_all_cache();
		exit($this->get_request_success_response());
	}
}
