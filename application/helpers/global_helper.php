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
            $return[$key] = $param_is_seted ? $params[$key] : false;
            $return['all_params'] = $return['all_params'] && $param_is_seted;
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

if (!function_exists('current_menu')) {
    //获取当前路由下对应菜单对象
    function current_menu($menus, $uri)
    {
        foreach ($menus as $menu) {
            if (($menu['url'] == $uri) || ($menu['url'] == '/' . $uri)) {
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

if (!function_exists('log_var_message')) {
    //日志输出变量
    function log_var_message($var)
    {
        log_message('info', $var);
    }
}

if (!function_exists('log_array_message')) {
    //日志输出数组
    function log_array_message($arr)
    {
        log_message('info', var_export($arr, true));
    }
}


