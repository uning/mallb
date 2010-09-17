<?php
require_once 'base.php';
function get_session($id,$is_pid=false)
{
	static $sess;
	if($sess)
		return $sess;
	if($is_pid)
		return $sess = TTGenid::getbypid($id);
	return $sess = TTGenid::getbyid($id);
}

function check_dup($uid,$cid,&$ret)
{
	$sess = get_session($uid);
	if($sess['fv']>100){
		if($sess['_cid']!=$cid){
			$ret['s'] = 'dup';
			return $ret;
		}
	}
	return false;
}

function auth_playcrab($key)
{
	static $use_auth = false;
	if(!$use_auth){
		return true;	
	} 
	$now = $_SERVER['REQUEST_TIME'];	
	if(!$key){
		$pid  = '';//get by 
		$sess = TTGenid::getbypid($pid);
		$kdata[]=$sess['pid'];
		$kdata[]=$sess['id'];
		$kdata[]=$now;
		return base64_encode(implode(':',$kdata));
	}
	$keyd = base64_decode($key);
	$kdata = explode(':',$keyd,3);
	if($kdata[2]<100){
		return false;
	}
	if($kdata[2]+3600 >$now)
		return $key;
	$kdata[2]=$now;
	return base64_encode(implode(':',$kdata));
}

