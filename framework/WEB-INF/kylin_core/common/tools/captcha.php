<?php
/**
 * Filename:	ck_num.php
 * 
 * Function: 	生成Captcha验证码
 * 
 * Description:	
 * 				
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

error_reporting(0);
session_start();

$x_size=60;
$y_size=30;
$nmsg=num_rand(4);
$S=$_SERVER['SERVER_PORT']=='443' ? 1:0;

$_SESSION['ck_num'] = $nmsg;

$aimg = imagecreate($x_size,$y_size);
$back = imagecolorallocate($aimg, 255, 255, 255);
$border = imagecolorallocate($aimg, 0, 0, 0);
imagefilledrectangle($aimg, 0, 0, $x_size - 1, $y_size - 1, $back);
imagerectangle($aimg, 0, 0, $x_size - 1, $y_size - 1, $border);

//下面该生成雪花背景了，其实就是在图片上生成一些符号
for ($i=1; $i<=200; $i++) { 
    imageString($aimg,1,mt_rand(1,$x_size-5),mt_rand(0,$y_size-8),"*",imageColorAllocate($aimg,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255)));
}

for ($i=0;$i<strlen($nmsg);$i++){ 
    //为了区别于背景，这里的颜色不超过200，上面的不小于200
    imageString($aimg, 20,$i*$x_size/4+mt_rand(1,5),1+mt_rand(2,13),$nmsg[$i],imageColorAllocate($aimg,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200)));
}

header("Content-type: image/png");
imagepng($aimg);
imagedestroy($aimg);exit;
function num_rand($lenth){
    mt_srand((double)microtime() * 1000000);
    for($i=0;$i<$lenth;$i++){
        $randval.= mt_rand(0,9);
    }
    $randval=substr(md5($randval),mt_rand(0,32-$lenth),$lenth);
    return $randval;
}
?>