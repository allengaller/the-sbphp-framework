<?
class cache_memcache {
    //private static $handler;
    private $_memcached;

    public function __construct() {
         $this->_init();
        // if(is_null(self::$handler)){
            // self::$handler = $this -> _init();
        // }
        // return self::$handler;
     }
     
    //初始化类
    private function _init() {
        require_once (BASE_PATH . '/config/memcached_config.php');
        $this -> _memcached = new Memcache;
        $this -> _memcached -> addServer($MEMCACHED_CONF['CacheHost'], $MEMCACHED_CONF['CachePort'], $MEMCACHED_CONF['CacheWeight']);
    }
    
    /**
     * 添加服务器
     */
    public function addServer($cachehost,$port,$weight){
        $this -> _memcached ->addServer($cachehost,$port,$weight);
    }
    
    /**
     * 保存数据到缓存服务器
     * $ttl 时间设置 单位为秒;
     */
    public function set($key, $data, $ttl = 3600) {
        if (get_class($this -> _memcached) == 'Memcache') {
            return $this -> _memcached -> set($key, $data, 0, $ttl);
        } else {
            return false;
        }
    }
    
    /**
     * 通过key获取value
     */
    public function get($key) {
        $data = $this -> _memcached -> get($key);
        return (!empty($data)) ? $data : false;
    }
    
    public function del($key,$ttl=0){
        return $this->_memcached->delete($key);
    }
    
    public function clean(){
        return $this->_memcached->flush();
    }
    
    public function getVersion(){
        return $this->_memcached->getVersion();
    }

}
?>