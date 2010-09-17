<?php
require_once('config.php');
$u=$_GET['u'];
if($u){
	$sess = TTGenid::getbyid($u);
	if(!$sess){
		die('no session');
	}
}
$tu = new TTUser($u);
$curaward = 1;

$getids[]=$tu->getdid('caward');
$getids[]=$tu->getdid('exp');
$getids[]=$tu->getdid('');
$coid=$tu->getoid('copilot',TT::OTHER_GROUP );
$getids[]= $coid;
$datas = $tu->getbyids($getids);	
$caward = $datas['caward'];
if($caward >=$curaward){
	return 'awarded';
}
$level = $tu->getLevel($datas['exp']);
$cops = $datas['copilot'];
$cops['id']=$coid;
if($level>30){
	$tu->chMoney(300000);
	$tu->chGem(15);
	$copilot['bag'][2002] += 4;//加两箱的道具
	$copilot['bag'][2004] += 6;//加6小时的道具
}
else if($level>20){
	$tu->chMoney(150000);
	$tu->chGem(8);
	$copilot['bag'][2002] += 3;//加两箱的道具
	$copilot['bag'][2004] += 4;//加两箱的道具
}
else if($level>20){
	$tu->chMoney(100000);
	$tu->chGem(5);
	$copilot['bag'][2002] += 2;//加两箱的道具
	$copilot['bag'][2004] += 2;//加两箱的道具
}
else ($level>20){
	$tu->chMoney(50000);
	$tu->chGem(3);
	$copilot['bag'][2002] += 1;//加两箱的道具
	//$copilot['bag'][2004] += 6;//加两箱的道具
}


