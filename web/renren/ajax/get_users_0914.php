<?php 

require_once('../config.php');

$dbconfig=array(
		'host' => '122.11.61.28',
		//'host' => '127.0.0.1',
		'username' => 'admin',
		'password' => '123456',
		'port'     =>'3307',
		'charset'     =>'utf8',
		'dbname'   => 'mall_stat');
$cmd = "mysql -u{$dbconfig['username']} -P{$dbconfig['port']}  -h{$dbconfig['host']} ";
if($dbconfig['password']){
  $cmd.=" -p'{$dbconfig['password']}'";
}

$db = ServerConfig::connect_mysql($dbconfig);


$start= 0;
$limit = 16;
$start_t = strtotime('2010-09-05');
$lastt= time()-86400*5;
 

$sql = "SELECT pid
		FROM `user_s`
		WHERE `exp`<300 and authat<$lastt and notify_send_lst =0
		LIMIT $start , $limit";

		
$rdata = $db->fetchAll($sql);
function get_pid($u)
{
	return $u['pid'];
}
$to_ids  = implode(",", array_map("get_pid",$rdata) ); 
   
echo $to_ids;
 
		

?>