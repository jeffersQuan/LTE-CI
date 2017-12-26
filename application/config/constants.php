<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
 * 缓存文件
 * */
define('MENUS_MODEL_CACHE', 'menus_model_cache');//数据库菜单对象数组数据模型文件名
define('MENUS_CACHE', 'menus_cache');//当前条件下显示的树形结构菜单对象数组缓存文件名
define('MENUS_ALL_CACHE', 'menus_all_cache');//完整的树形结构菜单对象数组缓存文件名
define('MENUS_TREE_CACHE', 'menus_tree_cache');//树形结构菜单展开成一维数组缓存文件名

define('ROLES_MODEL_CACHE', 'roles_model_cache');//数据库角色对象数组数据模型文件名
define('PRIVILEGES_MODEL_CACHE', 'privileges_model_cache');//数据库权限对象数组数据模型文件名
define('ROLE_PRIVILEGES_CACHE', 'role_privileges_cache');//各角色权限对象数组数据模型文件名
define('ROLE_URLS_CACHE', 'role_urls_cache');//各角色权限对应url对象数组数据模型文件名
define('ALL_URLS_CACHE', 'all_urls_cache');//所有权限对应url对象数组数据模型文件名
define('USERS_MODEL_CACHE', 'users_model_cache');//数据库用户对象数组数据模型文件名

define('DEBUG_MODE', FALSE);//是否是debug模式
define('PAGE_SIZE', 20);//页面默认显示数据条数
/*
 * 错误码
 * */
define('REQUEST_SUCCESS_CODE', 0);
define('REQUEST_SUCCESS_MSG', '请求成功');

define('REQUEST_FAILED_CODE', 10000);
define('REQUEST_FAILED_MSG', '请求失败');
define('AUTH_FAILED_CODE', 10001);
define('AUTH_FAILED_MSG', '登录状态已失效');
define('LOGIN_REQUIRED_CODE', 10002);
define('LOGIN_REQUIRED_MSG', '请先登录');
define('NO_PERMISSION_CODE', 10003);
define('NO_PERMISSION_MSG', '没有权限');
define('IS_LOCKED_CODE', 10004);
define('IS_LOCKED_MSG', '帐号被禁用');


define('PARAMS_ERROR_CODE', 20001);
define('PARAMS_ERROR_MSG', '缺少参数或参数格式不正确');
define('USERNAME_NOT_EXISTS_CODE', 20002);
define('USERNAME_NOT_EXISTS_MSG', '用户名不存在');
define('USERNAME_OR_PASSWORD_ERROR_CODE', 20003);
define('USERNAME_OR_PASSWORD_ERROR_MSG', '用户名或密码错误');
