<?php
$myloc = dirname(__FILE__);
require_once('../base.php');
echo "<pre>\n";

$now = time();
$datestr = date('Y-m-d',$now);
$weekday = date('N',$now);
$day_starttime = strtotime($datestr);
$day_endtime = $day_starttime + 86400;
$logt = TT::get_tt('debug');
$logt->needSV=false;
$id = $logt->genUid();
echo "max : $id:\n";
#exit;

$num = $logt->num();


$cont_no = 0;
$end = $id;
$vnum=$_REQUEST['num'];
$u=$_REQUEST['u'];
if(!$vnum)
	$vnum = 50;

	$start = $end - $vnum;
	if($start<1){
		$start = 1;
	}
for($i=$id;$i>$start;--$i){
	$data =  $logt->get($i);		
	if(!$data){
		continue;
	}
	print_r($data);
	

}


