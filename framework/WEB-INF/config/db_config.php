<?
/**
 * Filename:	config.php
 * 
 * Function: 	Basic Database configuration
 * 
 * Description:	全局数据库管理中心
 * 				Core configuration for database settings.
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

// Default database settings.
$DB = array(
	'DBhost' => 'localhost',  // 数据库服务器
	'DBuser' => 'root',        	  // 数据库用户名
	'DBpwd' => '123456',          // 数据库密码
	'DBname' => 'test',         // 数据库名
	'DBpre' => '',                // 数据库表前缀
	'DBtype' => 'mysql',          // 数据库类型
	'DBpconnect' => '0',          //是否持久连接
	'SysDir' => ''
);

$DB_TEST = array(
	'DBhost' => '192.168.0.195',  // 数据库服务器
	'DBuser' => 'root',        	  // 数据库用户名
	'DBpwd' => '123456',          // 数据库密码
	'DBname' => 'test',          // 数据库名
	'DBpre' => '',                // 数据库表前缀
	'DBtype' => 'mysql',          // 数据库类型
	'DBpconnect' => '0',          //是否持久连接
	'SysDir' => ''
);

$ENV = 0; //环境配置，0 为测试环境 1 为正式环境





?>