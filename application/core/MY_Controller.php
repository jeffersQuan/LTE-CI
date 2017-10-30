<?php
class MY_Controller extends CI_Controller {

    public $page_data = array(
        'keywords'=>'',//页面SEO关键字
        'description'=>'',//页面SEO描述
        'title'=>'',//页面标题
        'body_class'=>'',//页面body中需要添加的class
        'has_form'=>false,//页面是否需要使用表单检测相关函数
        'uri'=>'',//当前页面路由
        'current_menu'=>array(),//当前页面菜单数组,元素为从一级菜单到当前等级菜单的对象
        'menus'=>array(),//按菜单等级从属关系组成的树形菜单对象数组
        'menus_model'=>array()//从数据库中获取的菜单对象数组
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache',array('adapter'=>'file'));
        $this->load->model('menu_model');

        $this->load_all_cache();
        $this->init_data();

        //生产环境的页面缓存30天
        if (ENVIRONMENT == 'production') {
            $this->output->cache(30 * 24 * 60);
        }
    }

    public function load_all_cache()
    {
        $this->load_menu_model_cache();
        $this->load_menu_cache();
    }

    public function load_menu_model_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (ENVIRONMENT == 'production' && is_file(APPPATH . 'cache/' . MENUS_MODEL_CACHE)) {
            return null;
        }
        $menus = $this->menu_model->get_menus();
        set_cache(MENUS_MODEL_CACHE, $menus);
    }

    public function load_menu_cache()
    {
        //正式环境的缓存文件如果存在就不用再读取数据库
        if (ENVIRONMENT == 'production' && is_file(APPPATH . 'cache/' . MENUS_CACHE)) {
            return null;
        }
        $menus = get_cache(MENUS_MODEL_CACHE);
        $menus_cache = array();
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
            if ($menu['level'] == 1) {
                $menus_cache[$menu['position']] = $menu;
            }
        }

        set_cache(MENUS_CACHE, $menus_cache);
    }

    public function init_data()
    {
        $this->page_data['uri'] = uri_string();
        $this->page_data['menus'] = get_cache(MENUS_CACHE);
        $this->page_data['menus_model'] = get_cache(MENUS_MODEL_CACHE);
        $this->page_data['current_menu'] = current_menu($this->page_data['menus_model'], uri_string());
        $title = current_menu_name($this->page_data['menus_model'], uri_string());
        $title && ($this->page_data['title'] = $title);
    }

    public function view($file)
    {
        $this->load->view($file, $this->page_data);
    }

    public function get_params_error_response ($msg) {
        $msg = $msg? $msg : PARAMS_ERROR['msg'];
        return json_encode(array('code'=>PARAMS_ERROR['code'], 'msg'=>$msg));
    }

    public function get_request_failed_error_response ($msg) {
        $msg = $msg? $msg : REQUEST_FAILED['msg'];
        return json_encode(array('code'=>REQUEST_FAILED['code'], 'msg'=>$msg));
    }

    public function get_request_success_response ($msg, $data) {
        $msg = $msg? $msg : REQUEST_SUCCESS['msg'];
        $res = array('code'=>REQUEST_SUCCESS['code'], 'msg'=>$msg);

        if (isset($data)) {
            $res['data'] = $data;
        }

        return json_encode($res);
    }

    public function get_auth_failed_error_response ($msg) {
        $msg = $msg? $msg : AUTH_FAILED['msg'];
        return json_encode(array('code'=>AUTH_FAILED['code'], 'msg'=>$msg));
    }
}