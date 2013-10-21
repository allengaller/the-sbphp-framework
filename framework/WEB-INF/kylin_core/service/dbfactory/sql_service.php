<?
class sql_service {
    private $_memcached;
    public function __construct() {
        $this->_init();
    }

    //初始化类
    private function _init() {
        require_once (BASE_PATH . '/service/cache/cache_memcache.php');
        $this -> _memcached = new cache_memcache();
    }

    public function getList($sql, $is_cache = false, $cache_time = 30) {
        if (empty($sql)) {
            return Array();
            die();
        }
        $key = md5($sql.RDOMAIN_NAME);

        if ($is_cache) {
            $rs = $this -> _memcached -> get($key);
            if (isset($rs) && is_array($rs)) {
                return $rs;
            } else {
                $rs = $this -> _getList($sql);
                $this -> _memcached -> set($key, $rs, $cache_time);
                return $rs;
            }
        } else {
            $rs = $this -> _getList($sql);
            return $rs;
        }
    }
    
    public function getOnce($sql, $is_cache = false, $cache_time = 30){
        if (empty($sql)) {
            return Array();
            die();
        }
        $key = md5($sql.RDOMAIN_NAME);

        if ($is_cache) {
            $rs = $this -> _memcached -> get($key);
            if (isset($rs) && is_array($rs)) {
                return $rs;
            } else {
                $rs = $this -> _getonce($sql);
                $this -> _memcached -> set($key, $rs, $cache_time);
                return $rs;
            }
        } else {
            $rs = $this -> _getonce($sql);
            return $rs;
        }
    }
    
    
    private function _getOnce($sql){
         global $db; 
         return $db->sql_fetchRecord($sql);  
    }
    
    
    private function _getList($sql) {
        global $db;
        $result = $db -> sql_fetchrowset($db -> sql_query($sql));
        $db -> sql_freeresult();
        return $result;
    }
    

}
?>