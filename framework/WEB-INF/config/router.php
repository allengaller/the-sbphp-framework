<?
/**
 * Filename:	router.php
 * 
 * Function: 	Basic mapping between URL keyword and Controller.
 * 
 * Description:	全局地址-控制器映射
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

$ROUTER = array(
	'manager' => '/controller/manager/ManagerController.php',
	'menu'=> '/controller/menu/MenuController.php',
);
?>
