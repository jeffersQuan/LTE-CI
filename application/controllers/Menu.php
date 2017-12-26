<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('menu_model');
	}

	public function manage()
	{
		$this->view('menu/list');
	}

	public function add()
	{
		if ($this->input->is_ajax_request()) {
			$params = params_check($_POST, array('pid', 'name', 'icon', 'url', 'not_display'));

			if (!$params['name'] || !$params['pid']) {
				exit($this->get_params_error_response());
			}

			$data = params_filter($_POST, array('pid', 'name', 'icon', 'url', 'not_display'));
			$parent = $this->menu_model->get_menu($data['pid']);
			$brother = $this->menu_model->get_menu_children($data['pid']);

			if (count($brother) > 0) {
				$data['position'] = +$brother[count($brother) - 1]['position'] + 1;
			} else {
				$data['position'] = 1;
			}

			if ($parent['level'] != 0) {
				$data['group_id'] = $parent['group_id'];
			}

			$data['level'] = +$parent['level'] + 1;


			$id = $this->menu_model->insert_menu($data);

			//如果插入的是一级菜单,插入成功后需要更新该菜单的group_id为自己的id
			if ($data['level'] == 1) {
				$this->menu_model->update_menu(array('group_id'=>$id), array('id'=>$id));
			}

			$this->clear_all_cache();

			if ($id > 0) {
				exit($this->get_request_success_response());
			} else {
				exit($this->get_request_failed_error_response());
			}
		} else {
			$this->page_data['has_form'] = true;
			$this->view('menu/add');
		}
	}

	public function info()
	{
		$params = params_check($_GET, array('id'));

		if (!is_numeric($params['id'])) {
			show_404();
		} else {
			$info = $this->menu_model->get_menu($params['id']);
			$this->set_view_data($info);
			$this->page_data['has_form'] = true;
			$this->view('menu/info');
		}
	}
	
	public function update()
	{
		$params = params_check($_POST, array('id', 'pid', 'name', 'icon', 'url', 'not_display'));

		if (!$params['id']) {
			exit($this->get_params_error_response());
		}

		$data = params_filter($_POST, array('pid', 'name', 'icon', 'url', 'not_display', 'deleted'));

		if ($data['pid']) {
			$parent = $this->menu_model->get_menu($data['pid']);
			$data['level'] = +$parent['level'] + 1;

			if ($parent['level'] != 0) {
				$data['group_id'] = $parent['group_id'];
			}
		}
		
		$this->menu_model->update_menu($data, array('id'=>$params['id']));
		$this->clear_all_cache();
		exit($this->get_request_success_response());
	}
	
	public function update_position()
	{
		$params = params_check($_POST, array('menu_id', 'type'));

		if (!$params['all_params']) {
			exit($this->get_params_error_response());
		}
		
		$menu = $this->menu_model->get_menu($params['menu_id']);
		
		if (!$menu) {
			show_404();
		}
		
		$menus = $this->menu_model->get_menus_list(" pid=" . $menu['pid']);
		$current_position = $menu['position'];

		if (count($menus) > 1) {
			if ($params['type'] == 'up') {
				if ($current_position == 1) {
					$new_position = count($menus);
				} else {
					$new_position = $current_position - 1;
				}
			} else {
				if ($current_position == count($menus)) {
					$new_position = 1;
				} else {
					$new_position = $current_position + 1;
				}
			}
			$menus[$current_position - 1]['position'] = $new_position;
			$menus[$new_position - 1]['position'] = $current_position;

			$this->menu_model->update_menu(array('position'=>$menus[$current_position - 1]['position']), array('id'=>$menus[$current_position - 1]['id']));
			$this->menu_model->update_menu(array('position'=>$menus[$new_position - 1]['position']), array('id'=>$menus[$new_position - 1]['id']));
		}
		$this->clear_all_cache();
		exit($this->get_request_success_response());
	}
}
