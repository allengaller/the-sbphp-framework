<?
// 读取全局设置
include('./WEB-INF/kylin_core/config/global_config.php');

// Send a raw HTTP header
header("Content-type: text/html; charset=utf-8");

	$varr = array();
	$v[1] ="v";
 	$v[2] = "manager";
    $v[3] = "index";
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
	$class_name = @$ROUTER[$varr['className']];
	require_once ROOT_PATH.$class_name;
	$arrclasspath = explode('/', ROOT_PATH.$class_name);
	$objname = $arrclasspath[count($arrclasspath) - 1];
	$filetype = strrchr($objname, ".");
	$class_name = str_replace($filetype, "", $objname);
	// 实例化类并调用回调方法
	$module = new $class_name;
	$module -> handleRequest($varr);
	$db->sql_close();
	exit();
?>