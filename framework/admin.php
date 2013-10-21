<?
/**
 * Filename:	main.php
 * 
 * Function: 	Basic Kylin functionality.
 * 
 * Description:	全局控制管理中心::整个网站的所有请求由此进行调度
 * 				Core functions for including other source files, loading models and so forth.
 *
 * Support:		PHP versions 4 and 5
 *
 * Framework:	KylinPHP(tm) : Rapid Development Framework (http://vkylin.net)
 * 				Copyright 2013, SNSSHOP Inc.
 *
 * Licensed:	The MIT License
 * 				Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2013, SNSSHOP Inc.
 * @link          http://vkylin.net KylinPHP(tm) Project
 * @package       kylin
 * @subpackage    kylin.kylin
 * @since         KylinPHP(tm) v 0.1
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author 		  Binko
 */

// URL解析以及模版初始化
function init($path){
	$varr = array();
	$p = explode('?', $path);
	$v = explode('/', $p[0]);
    
    //if(count($v)<4){
    //  echo "非法的请求";  
    //  die();
    //}
    
    
    if(empty($v[2])){
        $v[2] = "manager";
    }
    
     if(empty($v[3])){
        $v[3] = "index";
    }
	$varr['className'] = $v[2];
	$varr['methodName'] = $v[3];
	$varr['request'] = $_REQUEST;

	// Smarty模版初始化
    $smarty = new Smarty;
    $smarty->template_dir = WEB_PATH.'/template/tpl/';
    $smarty->compile_dir = SMARTY_COMPLIE_DIR;
    $smarty->cache_dir = ROOT_PATH."/tpl_e";

    $smarty->caching = FALSE;
	$smarty->cache_lifetime = 300;//第一次设置缓存
	$smarty->assign("SYSNAME", SYSNAME);
    
	$varr['smarty'] = $smarty;
	return $varr;
}

// 读取全局设置
include('./WEB-INF/kylin_core/config/global_config.php');

// Send a raw HTTP header
header("Content-type: text/html; charset=utf-8");

// 获取完整URL
$path = $_SERVER["REQUEST_URI"];

// 调用init函数配置类，方法和模版
$varr = init($path);

// 地址验证
if (empty($varr['className']) || empty($varr['methodName'])) {
	echo "非法的请求!";
	die();
}

// 通过ROUTER获取Controller文件路径
$class_name = @$ROUTER[$varr['className']];

// 获得类名并实例化类
if (!empty($class_name) && checkClass(ROOT_PATH.$class_name)) {
    // 获得Controller绝对地址
	require_once ROOT_PATH.$class_name;
	$arrclasspath = explode('/', ROOT_PATH.$class_name);
	$objname = $arrclasspath[count($arrclasspath) - 1];
	$filetype = strrchr($objname, ".");
	$class_name = str_replace($filetype, "", $objname);

	// 实例化类并调用回调方法
	$module = new $class_name;
	$module -> handleRequest($varr);
} else {
	//TODO: 若文件不存在，则自动从远程服务器上下载
	echo "请求的页面不存在";
}
$db->sql_close();
exit();
?>