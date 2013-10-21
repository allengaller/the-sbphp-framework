<?php
//调用widget基类
include_once ROOT_PATH . '/widget/SmartyWidget.php';
function smarty_function_widget($params, $template) {
    //判断参数是否为空
    if (empty($params['name'])) {
        user_error('Widget is missing name.', E_USER_ERROR);
    }


    //if(name)


    //利用controller来实现不同的function
    if (file_exists($controller = sprintf('%s.php', CONF_DIR_WIDGETS . strtolower($params['name'])))) {
        require_once ($controller);
    } else {
        eval(sprintf('class %s extends Smarty_Widget {}', $params['name']));
    }

    //初始化相关类(从视图指定)
    $widget = call_user_func($params['name'] . '::factory', $params);

    //读取前台传过来的模板参数(从视图指定)
    $widget -> loadView($template -> smarty) -> $params['html']($params);
}
