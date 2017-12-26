<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privilege extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('privilege_model');
	}

	public function manage()
	{
		$params = params_check($_GET, array('name', 'group_name', 'page_index', 'page_size'));
		$where = '1=1';
		$page_size = PAGE_SIZE;
		$page_index = 0;
		$order_by = '';
		$limit = '';

		if ($params['name']) {
			$where = $where . " AND name LIKE '%" . $params['name'] . "%'";
		}

		if ($params['group_name']) {
			$where = $where . " AND group_name LIKE '%" . $params['group_name'] . "%'";
		}

		if ($params['page_size'] && is_numeric($params['page_size'])) {
			$page_size = $params['page_size'];
		}

		if ($params['page_index'] && is_numeric($params['page_index'])) {
			$page_index = $params['page_index'];
		}

		$limit = " $page_size OFFSET " . $page_size * $page_index;
		$list = $this->privilege_model->get_privileges_list($where, null, $limit);
		$total = $this->privilege_model->get_privileges($where);
		$data = array(
			'list'=>$list,
			'sum'=>array(
				'total'=>$total
			)
		);
		$this->set_view_data($data);
		$this->page_data['params'] = $params;
		$this->view('privilege/list');
	}

	public function info()
	{
		$params = params_check($_GET, array('privilege_id'));

		if (!is_numeric($params['privilege_id'])) {
			show_404();
		} else {
			$info = $this->privilege_model->get_privilege($params['privilege_id']);
			$this->set_view_data($info);
			$this->page_data['has_form'] = true;
			$this->view('privilege/info');
		}
	}

	public function add()
	{
		if ($this->input->is_ajax_request()) {
			$params = params_check($_POST, array('name', 'url', 'group_name'));

			if (!$params['all_params']) {
				exit($this->get_params_error_response());
			}

			$data = params_filter($_POST, array('name', 'url', 'group_name'));
			$id = $this->privilege_model->insert_privilege($data);

			if ($id > 0) {
				$this->clear_all_cache();
				exit($this->get_request_success_response());
			} else {
				exit($this->get_request_failed_error_response());
			}
		} else {
			$this->page_data['has_form'] = true;
			$this->view('privilege/add');
		}
	}
	
	public function update()
	{
		$params = params_check($_POST, array('privilege_id', 'name', 'url', 'group_name'));

		if (!$params['privilege_id']) {
			exit($this->get_params_error_response());
		}

		$data = params_filter($_POST, array('name', 'url', 'group_name'));
		$this->privilege_model->update_privilege($data, array('privilege_id'=>$params['privilege_id']));
		$this->clear_all_cache();
		exit($this->get_request_success_response());
	}
}
