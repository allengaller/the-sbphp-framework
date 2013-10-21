<?
class commWidget extends Smarty_Widget {
     public function head() {
         $this->smarty->assign("Profile", '配置');
         return $this -> display();
     }
     
     public function menu(){
         
     }
}
?>