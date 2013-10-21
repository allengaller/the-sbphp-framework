<?
include BASE_PATH . '/core/core.php';

class MenuController extends  Core {
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
                $this -> do_index($req, $smarty);
                break;
            default :
                $this -> do_index($req, $smarty);
                break;
        }
    }
    
    /**
     * 菜单管理首页
     */
    private function do_index($req, $smarty) {
        $smarty -> display('menu/index.html');
    }

}
?>