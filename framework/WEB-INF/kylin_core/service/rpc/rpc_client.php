<?
class rpc_client {
    private $_client;
    public function __construct() {
        $this -> _init();
    }
    
    private function _init(){
          require_once (BASE_PATH . '/config/soap_config.php');
         require_once (BASE_PATH . '/phprpc/phprpc_client.php');
         $this->_client= new PHPRPC_Client();
         $this->_client->useService(SOAP_BASE_URL);
         
    }
    
    /**
     * 获取远程数据，返回json
     */
    public function get_kysoap_catelist($pid,$name){
        return $this->_client->kysoap_get_catelist($pid,$name);
    }
    
}
?>