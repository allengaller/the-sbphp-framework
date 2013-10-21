<?php /* Smarty version Smarty-3.1.13, created on 2013-10-18 16:55:09
         compiled from "/Users/apple/Desktop/soft/old/kylin_ec/template/tpl/admin/login.html" */ ?>
<?php /*%%SmartyHeaderCode:17758587675260f76d168f33-27002363%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a8431d2ed327ab84dee87f198eb4c7e3e1baf358' => 
    array (
      0 => '/Users/apple/Desktop/soft/old/kylin_ec/template/tpl/admin/login.html',
      1 => 1365832923,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17758587675260f76d168f33-27002363',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SYSNAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5260f76d32efd9_47997950',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5260f76d32efd9_47997950')) {function content_5260f76d32efd9_47997950($_smarty_tpl) {?><!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $_smarty_tpl->tpl_vars['SYSNAME']->value;?>
</title>
		<script src="../../js/basic/jquery-1.9.1.js"></script>
		<script src="../../js/admin/login.js"></script>
	</head>
	<body>
		<div class="container" style="margin-top: 40PX;">
			<form class="form-signin">
				<h2 class="form-signin-heading"><i class="icon-user"></i> 麒麟后台管理登录</h2>
				<input type="text" class="input-block-level" id="user" placeholder="用户名">
				<input type="password" class="input-block-level" id="pwd" placeholder="密 码">
				<input type="text" class="input-block-level" id="code" style="width: 120px" maxlength="4" placeholder="验证码">
				<img id="verify_code" style="margin-left: 10px;margin-top:-18px;cursor:pointer" src="/admin/manager/code"  onclick="LoadVerifyPic()">
				<button class="btn btn-large btn-primary" style="display: block;width: 100%" type="button" onclick="login();">
					登 录
				</button>
			</form>
		</div>
	</body>
</html><?php }} ?>