 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

 <?php
 	require_once('config.php'); 
	
 	$pid = $_REQUEST['pid'];
	if($pid){
		$sess=TTGenid::getbypid($pid);
		$u = $sess['id'];
	}	
	$ot = TT::get_tt('order');   
	
	$q = $ot->getQuery();
	if($u)
	  $q->addCond('uid', TokyoTyrant::RDBQC_NUMEQ,$u); 
	 else{
		$q->addCond('handledTime', TokyoTyrant::RDBQC_NUMGT ,strtotime(date("Y-m-d") ));   
    }	 
	
	$q->addCond('status', TokyoTyrant::RDBQC_NUMEQ,1); 
 
		
	  
//	$q->setLimit(100);
	echo "<pre>";
	$rets  = $q->search();
	$amount = 0;
	$cs = Array();
	foreach($rets as $k => $ret){
	  $amount += $ret['amount'];
	  if($cs[$ret['amount']] === null ){
		 $cs[$ret['amount']]  = 0;
	  } 
	  $cs[$ret['amount']] ++;
	   
	}
	
	
	echo '成功订单数: '.count($rets)."\n";
	echo '人人豆:'.$amount."\n";
	echo "按充值额度分类：\n";
	print_r($cs);
	
	print_r(array_reverse($rets));
	echo "</pre>";
	
	
	?>
</body>
</html>
