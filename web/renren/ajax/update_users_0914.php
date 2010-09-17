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

 
$time= time();
$to_ids = $_POST['to_ids'];
if(!$to_ids){
	die(' no toids');
	$to_ids = "30578"; 
}
$sql = "update `user_s`
		set notify_send_lst = $time
		WHERE pid in ($to_ids)";
 
$rdata = $db->query($sql);
echo "ok";
 		

?>