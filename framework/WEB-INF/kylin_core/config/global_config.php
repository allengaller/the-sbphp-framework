<?
/**
 * Core Configurations.
 *
 *
 */

// 包含所需配置
define('BASE_PATH', dirname(dirname(__FILE__)));
define('ROOT_PATH', dirname(BASE_PATH));
define('WEB_PATH', dirname(ROOT_PATH));

define('SMARTY_COMPLIE_DIR',ROOT_PATH.'/tpl_c');
define('CONF_DIR_WIDGETS',ROOT_PATH.'/widget/');
define('WIDGETS_TPL_DIR',WEB_PATH.'/template/widget/');

define('RDOMAIN_NAME', $_SERVER['SERVER_NAME']);
define('SYSNAME','麒麟电子商务管理系统');


include(ROOT_PATH.'/config/router.php');
include(ROOT_PATH.'/config/db_config.php');
include(BASE_PATH.'/common/tools/func_common.php');
include(BASE_PATH.'/smarty/libs/Smarty.class.php');
include(BASE_PATH.'/service/dbfactory/sql_service.php');
include(BASE_PATH.'/service/rpc/rpc_client.php');

// 打开输出控制缓冲
ob_start();

// Seesion
if ( !empty($_GET['s_id']) )  {
	session_id($_GET['s_id']); 
}

// 开启新Seesion或沿用已有Session
session_start();

// 设定所有日期时间函数的默认时区
//date_default_timezone_set("Asia/Shanghai");

// 获得当前PHP版本信息
$PHPversion = phpversion();

// 向前兼容
if($PHPversion < '4.1.0'){
  $_GET = $HTTP_GET_VARS;
  $_POST = $HTTP_POST_VARS;
  $_SERVER = $HTTP_SERVER_VARS;
  $_SESSION = $HTTP_SESSION_VARS;
  $_FILES=$HTTP_POST_FILES;
  $_COOKIE= $HTTP_COOKIE_VARS;
}

// 判断PHP的Host系统
$isWin = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ;
if($isWin) {
	// Windows 兼容性配置
} else {
	// 其他Host系统配置
}

// 显式的加入特殊符号的自动转义
if($PHPversion < '5.3.0') {
	set_magic_quotes_runtime(0);
	if(!get_magic_quotes_gpc()){ 
		add_Slashes($_POST);
		add_Slashes($_GET);
		add_Slashes($_COOKIE);
	}
}

// 将HTTP传参变量转化为魔术变量
// Exp. $req_pid 等价于 $_REQUEST['pid']
foreach($_POST as $_key=>$_value){  
	!preg_match("/^_/",$_key) && ${'req_'.$_key} = $_POST[$_key];
}
unset($_POST);
foreach($_GET as $_key=>$_value){
	!preg_match("/^_/",$_key) && ${'req_'.$_key}=$_GET[$_key];

}

// 加载相应数据库
switch($DB['DBtype'])
{
	case 'mysql':
		include(dirname(dirname(__FILE__)).'/db/mysql.php');
		break;
	default:
		echo "Unsupported Databse!";
		die();
}


// $ENV=1为正式环境，0为测试环境
if($ENV == 1){
    $db_con = $DB;
}else{
     $db_con = $DB_TEST;
}

// 数据库连接
$db = new sql_db($db_con['DBhost'], $db_con['DBuser'], $db_con['DBpwd'], $db_con['DBname'], 0);

// 连接指示
($db->db_connect_id) or die('Could not connect to the database');

// 保留数据库前缀
$PRE = $DB['DBpre'] ;

// 清理数据库连接信息
unset($db_con['DBpre'], $db_con['DBtype'], $db_con['DBhost'], $db_con['DBuser'], $db_con['DBpwd'], $db_con['DBname']);
?>