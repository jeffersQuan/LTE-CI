<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function manage()
	{
		$params = params_check($_GET, array('username', 'nickname', 'page_index', 'page_size'));
		$where = '1=1';
		$page_size = PAGE_SIZE;
		$page_index = 0;
		$order_by = '';
		$limit = '';

		if ($params['username']) {
			$where = $where . " AND username LIKE '%" . $params['username'] . "%'";
		}

		if ($params['nickname']) {
			$where = $where . " AND nickname LIKE '%" . $params['nickname'] . "%'";
		}

		if ($params['page_size'] && is_numeric($params['page_size'])) {
			$page_size = $params['page_size'];
		}

		if ($params['page_index'] && is_numeric($params['page_index'])) {
			$page_index = $params['page_index'];
		}

		$limit = " $page_size OFFSET " . $page_size * $page_index;
		$list = $this->user_model->get_users_list($where, null, $limit);
		$total = $this->user_model->get_users($where);
		$data = array(
			'list'=>$list,
			'sum'=>array(
				'total'=>$total
			)
		);
		$this->set_view_data($data);
		$this->page_data['params'] = $params;
		$this->view('user/list');
	}

	public function info()
	{
		$params = params_check($_GET, array('user_id'));

		if (!is_numeric($params['user_id'])) {
			show_404();
		} else {
			$info = $this->user_model->get_user($params['user_id']);
			$this->set_view_data($info);
			$this->page_data['has_form'] = true;
			$this->view('user/info');
		}
	}

	public function reset_password()
	{
		$params = params_check($_GET, array('user_id'));

		if (!is_numeric($params['user_id'])) {
			show_404();
		} else {
			$info = $this->user_model->get_user($params['user_id']);
			$this->set_view_data($info);
			$this->page_data['has_form'] = true;
			$this->page_data['has_md5'] = true;
			$this->view('user/reset_password');
		}
	}

	public function add()
	{
		if ($this->input->is_ajax_request()) {
			$params = params_check($_POST, array('username', 'nickname', 'password', 'role_id'));

			if (!$params['all_params']) {
				exit($this->get_params_error_response());
			}

			$data = params_filter($_POST, array('username', 'nickname', 'password', 'role_id'));
			$data['password'] = md5($data['password'] . $data['username']);
			$data = set_created_by($data);
			$id = $this->user_model->insert_user($data);

			if ($id > 0) {
				$this->clear_all_cache();
				exit($this->get_request_success_response());
			} else {
				exit($this->get_request_failed_error_response());
			}
		} else {
			$this->page_data['has_form'] = true;
			$this->page_data['has_md5'] = true;
			$this->view('user/add');
		}
	}

	public function update()
	{
		$params = params_check($_POST, array('user_id', 'nickname', 'password', 'role_id', 'is_locked'));
		$current_uid = current_user_id();
		$users = array2map(get_cache(USERS_MODEL_CACHE), 'user_id');
		$current_user = $users[$current_uid];

		if (!$params['user_id']) {
			exit($this->get_params_error_response());
		}

		if (($params['user_id'] == 1) && ($params['is_locked'] > 0)) {
			//不允许禁用admin
			exit($this->get_request_failed_error_response('admin账户不能禁用!'));
		}

		$data = params_filter($_POST, array('nickname', 'password', 'role_id', 'is_locked'));

		if ($params['password'] || ($params['is_locked'] > 0)) {
			if (!$current_user || ($current_user['role_id'] != 1)) {
				//只有admin才允许重置密码和禁用账户
				exit($this->get_permission_error_response());
			}

			if ($params['password']) {
				$user = $users[$params['user_id']];
				$data['password'] = md5($data['password'] . $user['username']);
			}
		}

		$data = set_updated_by($data);
		$this->user_model->update_user($data, array('user_id'=>$params['user_id']));
		$this->clear_all_cache();
		exit($this->get_request_success_response());
	}
}
