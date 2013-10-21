<?php
/**
 * @Copyright (C), 2013-2014, www.snsshop.cn, hongchen
 * @Name smartyWidget 基类
 * @Author hongchen
 * @Version Beta 1.0
 * @Date 2013-04-03
 * @Description
 * @Class List:
 *     1. Smarty_Widget
 * @Function List:
 *     1. factory()
 *     2. __construct()
 *     3. loadView()
 *     4. display()
 *     5. execute()
 *     6. hook()
 *     7. __get()
 *
 */


class Smarty_Widget {

    //定义所用到的 model
    protected $uses = array();

    //
    protected static $smartyCake;

    //
    protected $smarty;

    //定义参数
    private $_vars = array();

    public static function factory($params = array()) {
    if(!function_exists('get_called_class')) {
        require_once 'class_tools.php';
         //$className = get_called_class();
    }
         $className = get_called_class();


        
        return new $className($params);
    }

    //接收参数
    public function __construct($params) {
        $this -> _vars = $params;        unset($params);
    }

    //将参数赋值，可用于视图调用
    public function loadView($smarty) {
        $this -> smarty = $smarty;
        $this -> smarty -> assign($this -> _vars);
        return $this;
    }

    //处理输出哪个模板
    protected function display() {
        $className = strtolower(get_called_class());
        /*
         * 新加用于显示不同模板
         */
        if (empty($this -> _vars['html'])) {
            //如果为空，则显示默认模板
            $showTpl = 'index.html';
        } else {
            $showTpl = $this -> _vars['html'] . '.html';
        }
    
        $tplDir = $this -> _vars['dir'];
        $this -> smarty -> display(WIDGETS_TPL_DIR .$tplDir . '/' . $showTpl);
    }

    //输出模板
    public function execute() {
        return $this -> display();
    }

    //实例化总控制器
    public function hook() {
        $app = new AppController();
        return $app;
    }

}
