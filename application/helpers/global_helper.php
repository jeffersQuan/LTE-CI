<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if (!function_exists('params_check')) {
    /**
     * 参数检测,检测请求是否携带所需参数
     */
    function params_check($params, $keys)
    {
        $return = array(
            'all_params' => true
        );

        foreach ($keys as $key) {
            $param_is_seted = isset($params[$key]);
            $return[$key] = $param_is_seted ? $params[$key] : '';
            $return['all_params'] = $return['all_params'] && $param_is_seted;
        }

        return $return;
    }
}

if (!function_exists('params_filter')) {
    /**
     * 参数过滤,过滤请求携带的参数
     */
    function params_filter($params, $keys)
    {
        $return = array();

        foreach ($keys as $key) {
            if (isset($params[$key]) && ($params[$key] != null) && ($params[$key] != '')) {
                $return[$key] = $params[$key];
            }
        }

        return $return;
    }
}

if (!function_exists('set_cache')) {
    //写入缓存文件
    function set_cache($name, $data, $time_sec = 315576000)
    {
        global $CI;
        if (!isset($CI)) {
            $CI =& get_instance();
        }
        $CI->cache->save($name, $data, $time_sec);
    }
}

if (!function_exists('get_cache')) {
    //读取缓存文件
    function get_cache($name)
    {
        global $CI;
        if (!isset($CI)) {
            $CI =& get_instance();
        }
        return $CI->cache->get($name);
    }
}

if (!function_exists('delete_cache')) {
    //写入缓存文件
    function delete_cache($name)
    {
        global $CI;
        if (!isset($CI)) {
            $CI =& get_instance();
        }
        $CI->cache->delete($name);
    }
}

if (!function_exists('current_user_id')) {
    //当前登录用户ID
    function current_user_id()
    {
        global $CI;
        if (!isset($CI)) {
            $CI =& get_instance();
        }
        return $CI->session->userdata('user_id');
    }
}

if (!function_exists('current_user_role_id')) {
    //当前登录用户ID
    function current_user_role_id()
    {
        global $CI;
        if (!isset($CI)) {
            $CI =& get_instance();
        }
        return $CI->session->userdata('role_id');
    }
}

if (!function_exists('set_created_by')) {
    //设置创建人
    function set_created_by($data)
    {
        $data['created_by'] = current_user_id();

        return $data;
    }
}

if (!function_exists('set_updated_by')) {
    //设置更新人
    function set_updated_by($data)
    {
        $data['updated_by'] = current_user_id();

        return $data;
    }
}

if (!function_exists('current_menu')) {
    //获取当前左侧菜单中出于激活状态的菜单
    function current_menu($menus, $uri)
    {
        foreach ($menus as $menu) {
            if (($menu['url'] == $uri) || ($menu['url'] == '/' . $uri)) {
                if ($menu['not_display'] == 1) {
                    foreach ($menus as $menu1) {
                        if ($menu1['id'] == $menu['pid']) {
                            return $menu1;
                        }
                    }
                }
                return $menu;
            }
        }
        return null;
    }
}

if (!function_exists('current_menu_name')) {
    //获取当前路由下对应菜单名称
    function current_menu_name($menus, $uri)
    {
        foreach ($menus as $menu) {
            if (($menu['url'] == $uri) || ($menu['url'] == '/' . $uri)) {
                return $menu['name'];
            }
        }
        return null;
    }
}

if (!function_exists('array2map')) {
    //数组转map
    function array2map($array, $key)
    {
        $map = array();

        foreach ($array as $item) {
            $map[$item[$key]] = $item;
        }

        return $map;
    }
}

if (!function_exists('map2array')) {
    //map转数组
    function map2array($map)
    {
        $arr = array();

        foreach ($map as $item) {
            array_push($arr, $item);
        }

        return $arr;
    }
}

if (!function_exists('copy_map')) {
    //复制map中的部分属性
    function copy_map($src, $des, $keys)
    {
        foreach ($src as $item) {
            foreach ($keys as $key) {
                $des[$key] = $src[$key];
            }
            array_push($arr, $des);
        }
    }
}

if (!function_exists('get_datetime')) {
    //获取时间
    function get_datetime($date_time)
    {
        return substr($date_time, 0, 16);
    }
}

if (!function_exists('get_date')) {
    //获取日期
    function get_date($date_time)
    {
        return substr($date_time, 0, 10);
    }
}

if (!function_exists('get_time')) {
    //获取时间
    function get_time($date_time)
    {
        return substr($date_time, 11, 5);
    }
}

if (!function_exists('http_get')) {
    //get请求
    function http_get($url)
    {
        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $contents = curl_exec($ch);
        log_var_message($url, 'debug');
        log_array_message($contents, 'debug');
        return $contents;
    }
}

if (!function_exists('get_array_item')) {
    //从数组对象中获取元素,并设置默认值
    function get_array_item($array, $key1, $key2, $default)
    {
        if (isset($array[$key1]) && isset($array[$key1][$key2])) {
            return $array[$key1][$key2];
        }

        return $default;
    }
}

if (!function_exists('fix_resource_url')) {
    //完善资源url
    function fix_resource_url($url, $type='')
    {
        if (!$url) {
            return '';
        }

        if (substr($url, 0, 7) != 'http://') {
            $url = 'http://' . $url;
        }

        return $url;
    }
}

if (!function_exists('log_var_message')) {
    //日志输出变量
    function log_var_message($var, $type='info')
    {
        log_message($type, $var);
    }
}

if (!function_exists('log_array_message')) {
    //日志输出数组
    function log_array_message($arr, $type='info')
    {
        log_message($type, var_export($arr, true));
    }
}


