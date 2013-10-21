<?
include BASE_PATH . '/core/core.php';

class ManagerController extends  Core {
    private $dbservice;
    /*
     * 回调Handler:: 分发请求至回调函数
     */
    public function handleRequest($varr) {
        //$req['total'] = $varr;
        $methodName = $varr['methodName'];
        $req = $varr['request'];
        $smarty = $varr['smarty'];
        $this -> dbservice = new sql_service();
        switch ($methodName) {
            case 'index' :
                $this -> do_login($req, $smarty);
                break;
            case 'code' :
                $this -> do_code($req, $smarty);
                break;
            case 'ck' :
                $this -> do_ck($req);
                break;
            case 'main' :
                $this -> do_main($req, $smarty);
                break;
            case 'clean' :
                $this -> do_clean();
                break;
            default :
                $this -> do_login($req, $smarty);
                break;
        }
    }

    /**
     * 登陆页面
     */
    private function do_login($req, $smarty) {
        $smarty -> display('admin/login.html');
    }

    /**
     * 验证码
     */
    private function do_code() {
        require_once BASE_PATH . "/common/tools/captcha.php";
    }

    /**
     * 用户登陆
     */
    private function do_ck($req) {
        if (empty($req) || count($req) < 3) {
            print_r(setAjaxMessage(0, '非法请求'));
            die();
        }
        $user = $req['user'];
        $code = $req['code'];
        $pwd = $req['pwd'];
        if ($_SESSION['ck_num'] != $code) {
            print_r(setAjaxMessage(0, '验证码错误'));
            die();
        }
        if($user=='joe'){
           $arr = array('Name' => $user, 'Age' => 20);
           print_r(setAjaxMessage(1, $arr)); 
            die();
        }else{
             print_r(setAjaxMessage(0, '用户名或密码错误'));
            die();
        }
    }
    
    /**
     * 后台管理主体程序
     */
    private function do_main($req, $smarty) {
        $smarty -> display('admin/main.html');
    }
    
    /**
     * 清除缓存
     */
    private function do_clean() {
        try {
            delCache();
            print_r(setAjaxMessage(1, "缓存清除成功"));
        } catch(Exception $e) {
            print_r(setAjaxMessage(0, "缓存清除失败"));
        }

    }

}
?>