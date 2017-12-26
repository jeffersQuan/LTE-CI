<?php
class MY_Controller extends CI_Controller {

    public $page_data = array(
        'keywords'=>'',//页面SEO关键字
        'description'=>'',//页面SEO描述
        'title'=>'LTE-CI',//页面标题
        'name'=>'',//当前路由对应的菜单名称
        'body_class'=>'',//页面body中需要添加的class
        'has_md5'=>false,//页面是否需要使用md5加密功能
        'has_form'=>false,//页面是否需要使用表单检测功能
        'has_editor'=>false,//页面是否需要使用富文本编辑组件
        'has_date_time_picker'=>false,//页面是否需要日期时间选择组件
        'has_date_range_picker'=>false,//页面是否需要日期范围选择组件
        'uri'=>'',//当前页面路由
        'current_menu'=>array(),//当前页面菜单数组,元素为从一级菜单到当前等级菜单的对象
        'menus'=>array(),//按菜单等级从属关系组成的树形菜单对象数组
        'menus_model'=>array(),//从数据库中获取的菜单对象数组
        'params'=>array(),//页面参数
        'data'=>array()//页面显示的数据
    );

    public $menus_tree = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache',array('adapter'=>'file'));
        $this->load->model('menu_model');
        $this->load->model('role_model');
        $this->load->model('privilege_model');
        $this->load->model('user_model');
        $this->load_all_cache();
        $this->init_data();

        $current_url = '/' . uri_string();
        $all_urls = get_cache(ALL_URLS_CACHE);

        if (!current_user_id()) {
            //没有登录,如果该路由需要权限验证,则需要重新登录
            if (in_array($current_url, $all_urls)) {
                if ($this->input->is_ajax_request()) {
                    exit($this->get_auth_failed_error_response('登录状态已失效,请重新登录后操作'));
                } else {
                    redirect('/?redirect=' . urlencode(base_url($current_url) . '?' . $_SERVER['QUERY_STRING']));
                }
            }
        } else {
            log_var_message('------------------权限判断');
            $current_user_urls = get_cache(ROLE_URLS_CACHE)['role_' . current_user_role_id()];

            if (in_array($current_url, $all_urls) && !in_array($current_url, $current_user_urls)) {
                //没有权限
                log_var_message('没有权限');

                if ($this->input->is_ajax_request()) {
                    exit($this->get_permission_error_response());
                } else {
                    show_error(NO_PERMISSION_MSG, 400);
                    exit();
                }
            } else if (!uri_string() || (uri_string() == 'welcome') || (uri_string() == 'login')) {
                $menu_tree = get_cache(MENUS_TREE_CACHE);

                foreach ($menu_tree as $menu) {
                    if (($menu['level'] == 2) && in_array($menu['url'], $current_user_urls)) {
                        redirect($menu['url']);
                        break;
                    }
                }
            }
        }

        //生产环境处理
        if (ENVIRONMENT == 'production') {

        } else {
            //非开发环境可以输出调试信息
            $this->output->enable_profiler(TRUE);
        }
    }

    public function load_all_cache()
    {
        $this->load_roles_model_cache();
        $this->load_privileges_model_cache();
        $this->load_all_privilege_urls_cache();
        $this->load_role_privileges_cache();
        $this->load_users_model_cache();
        $this->load_menus_model_cache();
        $this->load_menus_cache();
        $this->load_menus_all_cache();
        $this->load_menus_tree_cache();
    }

    public function clear_all_cache()
    {
        delete_cache(MENUS_MODEL_CACHE);
        delete_cache(MENUS_CACHE);
        delete_cache(MENUS_ALL_CACHE);
        delete_cache(MENUS_TREE_CACHE);
        delete_cache(ALL_URLS_CACHE);
        delete_cache(USERS_MODEL_CACHE);
        delete_cache(PRIVILEGES_MODEL_CACHE);
        delete_cache(ROLE_PRIVILEGES_CACHE);
        delete_cache(ROLE_URLS_CACHE);
        delete_cache(ROLES_MODEL_CACHE);
    }

    public function load_roles_model_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (!DEBUG_MODE && is_file(APPPATH . 'cache/' . ROLES_MODEL_CACHE)) {
            return null;
        }

        log_var_message('----------load_roles_model_cache');
        $roles = $this->role_model->get_roles_list();
        set_cache(ROLES_MODEL_CACHE, $roles);
    }

    public function load_privileges_model_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (!DEBUG_MODE && is_file(APPPATH . 'cache/' . PRIVILEGES_MODEL_CACHE)) {
            return null;
        }

        log_var_message('----------load_privileges_model_cache');
        $privileges = $this->privilege_model->get_privileges_list();
        set_cache(PRIVILEGES_MODEL_CACHE, $privileges);
    }

    public function load_all_privilege_urls_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (!DEBUG_MODE && is_file(APPPATH . 'cache/' . ALL_URLS_CACHE)) {
            return null;
        }

        log_var_message('----------load_all_privilege_urls_cache');
        $all_urls = array();
        $privileges = array2map(get_cache(PRIVILEGES_MODEL_CACHE), 'privilege_id');

        foreach ($privileges as $privilege) {
            array_push($all_urls, $privilege['url']);
        }

        set_cache(ALL_URLS_CACHE, $all_urls);
    }

    public function load_role_privileges_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (!DEBUG_MODE && is_file(APPPATH . 'cache/' . ROLE_PRIVILEGES_CACHE) && is_file(APPPATH . 'cache/' . ROLE_URLS_CACHE)) {
            return null;
        }

        log_var_message('----------load_role_privileges_cache');
        $role_privileges = array();
        $role_urls = array();
        $roles = get_cache(ROLES_MODEL_CACHE);
        $privileges = array2map(get_cache(PRIVILEGES_MODEL_CACHE), 'privilege_id');

        foreach ($roles as $role) {
            $r_privileges = json_decode($role['privileges']);
            $role_privileges['role_' . $role['role_id']] = $r_privileges;
            $role_urls['role_' . $role['role_id']] = array();

            foreach ($r_privileges as $r_privilege) {
                array_push($role_urls['role_' . $role['role_id']], $privileges[$r_privilege]['url']);
            }
        }

        set_cache(ROLE_PRIVILEGES_CACHE, $role_privileges);
        set_cache(ROLE_URLS_CACHE, $role_urls);
    }

    public function load_users_model_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (!DEBUG_MODE && is_file(APPPATH . 'cache/' . USERS_MODEL_CACHE)) {
            return null;
        }

        log_var_message('----------load_users_model_cache');
        $users = $this->user_model->get_users_list();
        set_cache(USERS_MODEL_CACHE, $users);
    }

    public function load_menus_model_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (!DEBUG_MODE && is_file(APPPATH . 'cache/' . MENUS_MODEL_CACHE)) {
            return null;
        }

        log_var_message('----------load_menus_model_cache');
        $menus = $this->menu_model->get_menus_list();
        set_cache(MENUS_MODEL_CACHE, $menus);
    }

    public function load_menus_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (!DEBUG_MODE && is_file(APPPATH . 'cache/' . MENUS_CACHE)) {
            return null;
        }

        log_var_message('----------load_menus_cache');
        $menus = get_cache(MENUS_MODEL_CACHE);
        $menus_cache = array();
        $roles = get_cache(ROLES_MODEL_CACHE);
        $all_urls = array();
        $privileges = array2map(get_cache(PRIVILEGES_MODEL_CACHE), 'privilege_id');

        foreach ($privileges as $privilege) {
            array_push($all_urls, $privilege['url']);
        }

        foreach ($roles as $role) {
            $urls = array();
            $role_privileges = json_decode($role['privileges']);

            foreach ($role_privileges as $role_privilege) {
                array_push($urls, $privileges[$role_privilege]['url']);
            }

            $menus_cache['role_' . $role['role_id']] = array();
            $menus_max_level = 1;
            $menus_id_arr = array();//以menu的id为键值组成的menu数组

            foreach ($menus as $key=>$menu) {
                if (in_array($menu['url'], $all_urls) && !in_array($menu['url'], $urls)) {
                    continue;
                }

                if ($menu['not_display'] > 0) {
                    continue;
                }

                if ($menu['pid'] > 0) {
                    $menus_id_arr[$menu['id']] = $menu;
                    $menus_id_arr[$menu['id']]['children'] = array();
                }

                if ($menu['level'] > $menus_max_level) {
                    $menus_max_level = $menu['level'];
                }
            }

            for ($level = $menus_max_level; $level > 1; $level--) {
                foreach ($menus_id_arr as $key=>$menu) {
                    if ($menu['level'] == $level) {
                        $menus_id_arr[$menu['pid']]['children'][$menu['position']] = $menus_id_arr[$key];
                    }
                }
            }

            foreach ($menus_id_arr as $key=>$menu) {
                if (isset($menu['level']) && ($menu['level'] == 1) && count($menu['children'])) {
                    $menus_cache['role_' . $role['role_id']][$menu['position']] = $menu;
                }
            }
        }

        set_cache(MENUS_CACHE, $menus_cache);
    }

    public function load_menus_all_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (!DEBUG_MODE && is_file(APPPATH . 'cache/' . MENUS_ALL_CACHE)) {
            return null;
        }

        log_var_message('----------load_menus_all_cache');
        $menus = get_cache(MENUS_MODEL_CACHE);
        $menus_all_cache = array();
        $menus_max_level = 1;
        $menus_id_arr = array();//以menu的id为键值组成的menu数组

        foreach ($menus as $key=>$menu) {
            if ($menu['pid'] > 0) {
                $menus_id_arr[$menu['id']] = $menu;
                $menus_id_arr[$menu['id']]['children'] = array();
            }

            if ($menu['level'] > $menus_max_level) {
                $menus_max_level = $menu['level'];
            }
        }

        for ($level = $menus_max_level; $level > 1; $level--) {
            foreach ($menus_id_arr as $key=>$menu) {
                if ($menu['level'] == $level) {
                    $menus_id_arr[$menu['pid']]['children'][$menu['position']] = $menus_id_arr[$key];
                }
            }
        }

        foreach ($menus_id_arr as $key=>$menu) {
            if (isset($menu['level']) && ($menu['level'] == 1)) {
                $menus_all_cache[$menu['position']] = $menu;
            }
        }

        set_cache(MENUS_ALL_CACHE, $menus_all_cache);
    }

    public function load_menus_tree_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (!DEBUG_MODE && is_file(APPPATH . 'cache/' . MENUS_TREE_CACHE)) {
            return null;
        }

        log_var_message('----------load_menus_tree_cache');
        $menus_all = get_cache(MENUS_ALL_CACHE);
        $this->filter_menu($menus_all);
        set_cache(MENUS_TREE_CACHE, $this->menus_tree);
    }

    public function filter_menu($menus)
    {
        foreach ($menus as $menu) {
            $temp_menu = array();
            $temp_menu['id'] = $menu['id'];
            $temp_menu['name'] = $menu['name'];
            $temp_menu['level'] = $menu['level'];
            $temp_menu['icon'] = $menu['icon'];
            $temp_menu['pid'] = $menu['pid'];
            $temp_menu['url'] = $menu['url'];
            $temp_menu['position'] = $menu['position'];

            array_push($this->menus_tree, $temp_menu);

            if (count($menu['children'])) {
                $this->filter_menu($menu['children']);
            }
        }
    }

    public function init_data()
    {
        if (current_user_role_id()) {
            $this->page_data['menus'] = get_cache(MENUS_CACHE)['role_' . current_user_role_id()];
        }
        $this->page_data['uri'] = uri_string();
        $this->page_data['menus_model'] = get_cache(MENUS_MODEL_CACHE);
        $this->page_data['current_menu'] = current_menu($this->page_data['menus_model'], uri_string());
        $name = current_menu_name($this->page_data['menus_model'], uri_string());
        $name && ($this->page_data['name'] = $name);
        $this->page_data['menus_tree'] = get_cache(MENUS_TREE_CACHE);
    }

    public function set_view_data($data)
    {
        $this->page_data['data'] = $data;
    }

    public function view($file)
    {
        $this->load->view($file, $this->page_data);
    }

    public function get_permission_error_response ($msg='') {
        $msg = $msg? $msg : NO_PERMISSION_MSG;
        return json_encode(array('code'=>NO_PERMISSION_CODE, 'msg'=>$msg));
    }

    public function get_locked_error_response ($msg='') {
        $msg = $msg? $msg : IS_LOCKED_MSG;
        return json_encode(array('code'=>IS_LOCKED_CODE, 'msg'=>$msg));
    }

    public function get_params_error_response ($msg='') {
        $msg = $msg? $msg : PARAMS_ERROR_MSG;
        return json_encode(array('code'=>PARAMS_ERROR_CODE, 'msg'=>$msg));
    }

    public function get_request_failed_error_response ($msg='') {
        $msg = $msg? $msg : REQUEST_FAILED_MSG;
        return json_encode(array('code'=>REQUEST_FAILED_CODE, 'msg'=>$msg));
    }

    public function get_request_success_response ($msg='', $data=array()) {
        $msg = $msg? $msg : REQUEST_SUCCESS_MSG;
        $res = array('code'=>REQUEST_SUCCESS_CODE, 'msg'=>$msg);

        if (isset($data)) {
            $res['data'] = $data;
        }

        return json_encode($res);
    }

    public function get_auth_failed_error_response ($msg='') {
        $msg = $msg? $msg : AUTH_FAILED_MSG;
        return json_encode(array('code'=>AUTH_FAILED_CODE, 'msg'=>$msg));
    }
}