<?
define('TAOBAO_PATH', '/Users/apple/Desktop/soft/old/kylin_ec/WEB-INF/kylin_core/taobao/top/');
define('TOP_SDK_WORK_DIR',TAOBAO_PATH);

include(TAOBAO_PATH.'TopClient.php');
include(TAOBAO_PATH.'request/ProductsGetRequest.php');
include(TAOBAO_PATH.'request/ItemsListGetRequest.php');
include(TAOBAO_PATH.'request/UserSellerGetRequest.php');
include(TAOBAO_PATH.'request/TaobaokeItemsDetailGetRequest.php');
include(TAOBAO_PATH.'request/ShopGetRequest.php');
include(TAOBAO_PATH.'RequestCheckUtil.php');
include('/Users/apple/Desktop/soft/old/kylin_ec/WEB-INF/kylin_core/taobao/lotusphp_runtime/Logger/Logger.php');

$c = new TopClient;
$c->appkey = "21498321";
$c->secretKey = "ceef5ac2afd19c801cd9eb0761fb8d34";
$sessionKey="61005155c04a9e9c64432e01f4b24f4e98a3abc70e749e228428451";




$req = new ShopGetRequest;
$req->setFields("sid,cid,title,nick,desc,bulletin,pic_path,created,modified");
$req->setNick("香菲丽莎旗舰店");
$resp = $c->execute($req);
//appkSecret：5fac3d68d84e3c455e31d8ceb246c253；sessionKey：6100511eb54edeb21a31d6c694044b5979997240261820a1041061713
//$req = new ProductsGetRequest;
//$req->setFields("product_id,outer_id,created,cid,cat_name,props,props_str,name,binds,binds_str,sale_props,desc,pic_url,modified,nick");
//$req = new ItemsOnsaleGetRequest;
//$req->setFields("approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id");
//$req = new ItemsListGetRequest;
//$req->setFields("detail_url");
//$resp = $c->execute($req, $sessionKey);

var_dump($resp);
?>