<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	public function index()
	{
		$params = params_check($_POST, array('username', 'password'));

		if (!$params['username'] || !$params['password']) {
			exit($this->get_params_error_response());
		}

		$username = $params['username'];
		$password = md5($params['password'] . $username);
		$user = $this->user_model->get_user_by_username($username);

		if (!$user) {
			exit(json_encode(array(
				'code'=>USERNAME_NOT_EXISTS_CODE,
				'msg'=>USERNAME_NOT_EXISTS_MSG
			)));
		}

		if ($user['is_locked'] > 0) {
			exit($this->get_locked_error_response());
		}

		if ($password != $user['password']) {
			exit(json_encode(array(
				'code'=>USERNAME_OR_PASSWORD_ERROR_CODE,
				'msg'=>USERNAME_OR_PASSWORD_ERROR_MSG
			)));
		}

		$this->user_model->update_user(array('last_login_time'=>date('Y-m-d H:i:s')), array('user_id='=>$user['user_id']));
		$this->session->set_userdata('user_id', $user['user_id']);
		$this->session->set_userdata('username', $user['username']);
		$this->session->set_userdata('nickname', $user['nickname']);
		$this->session->set_userdata('role_id', $user['role_id']);

		$menu_tree = get_cache(MENUS_TREE_CACHE);
		$current_user_urls = get_cache(ROLE_URLS_CACHE)['role_' . current_user_role_id()];
		$next_url = '';//设置为首页地址

		//如果有权限限制,则需要根据当前角色权限查找该角色可访问的首页地址
		foreach ($menu_tree as $menu) {
			if (($menu['level'] == 2) && in_array($menu['url'], $current_user_urls)) {
				$next_url = $menu['url'];
				break;
			}
		}

		exit(json_encode(array('code'=>REQUEST_SUCCESS_CODE, 'msg'=>'登录成功', 'next_url'=>$next_url)));
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

	public function reset_password()
	{
		if ($this->input->is_ajax_request()) {
			$params = params_check($_POST, array('password'));

			if ($params['password']) {
				$user = array2map(get_cache(USERS_MODEL_CACHE), 'user_id')[current_user_id()];
				$data['password'] = md5($params['password'] . $user['username']);
				$data = set_updated_by($data);
				$this->user_model->update_user($data, array('user_id'=>$user['user_id']));
				delete_cache(USERS_MODEL_CACHE);
				$this->session->sess_destroy();
				exit($this->get_request_success_response());
			} else {
				exit($this->get_params_error_response());
			}
		} else {
			$this->page_data['has_form'] = true;
			$this->page_data['has_md5'] = true;
			$this->view('reset_password');
		}
	}
}
