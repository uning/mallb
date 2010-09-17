<?php
$mypos=dirname(__FILE__).'/';
require_once('config.php');

$rdir=$mypos.'/static/flash/';
$confile = $rdir.'0_mall_config.xml';
$xml =  simplexml_load_file($confile);
$outf = $mypos.'/static/flash/o_0_mall_config.xml'; 
#echo CURRENT_PLATFORM.' = CURRENT_PLATFORM';
#exit;

if(CURRENT_PLATFORM!='test'){
	while(true){
		$str_md51 = file_get_contents('http://files5.qq494.cn/pig/hotel/flash/version.txt');
		$str_md5 = file_get_contents('http://58.83.132.57/mall/flash/version.txt');
		$new_md5 = file_get_contents($mypos.'/static/flash/version.txt');
		if($str_md5 != $new_md5){
			echo "version not equal--------remote=$str_md5 new_md5=$new_md5\n";	
			if($retry >3 )
				die('genconfig errror valid not equal ');
			$retry++;
			sleep(30);
			continue;
		}
		break;
	}
}


$out .= <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<config>
	<version tag="beta1.0"/>
	
	<resources parallel="false" use_cache="false">
EOT;


foreach($xml->resources->resource as $r){
	$src=$r['url'];
	$src = explode('?',$src);
	$src = $src[0];
	$file = $rdir.$src;
	if(!file_exists($file)){
		die("CONF resource not exists $file");
	}
	$src.='?v='.md5_file($file);
	$size = filesize ($file);
	$total_size +=$size;
	if($size>100000)
		echo " $size bytes $src \n ";
	$r['url']=$src;
	$out .= "   ".$r->asXML()."\n";
	//print_r($v);

}

$out .= <<<EOT

	</resources>

EOT;
//<main name="main" label="加载主程式" url="MallGame.swf?v=tc1.1" use_cache="false"/>
//<progress_aspect url="resource/common/swf/loadinglogo.swf" />
$fs = array('main','progress_aspect');
foreach($fs as $v){
	$r = $xml->$v;

	$src=$r['url'];
	$srcs = explode('?',$src);
	$src = $srcs[0];
	$file = $rdir.$src;
	if(!file_exists($file)){
		die("CONF resource not exists $file");
	}
	$size = filesize ($file);
	$total_size +=$size;
	if($size>100000)
		echo " $size bytes $src \n ";
	$src.='?v='.md5_file($file);
	$r['url']=$src;
	$out .= "   ".$r->asXML()."\n";
}
		/*
		 <server name="test" purl="http://s26.coolplusplus.com/static/flash/" />
	 	<server name="test" purl="http://58.83.132.57/mall/flash/" /> 

	 	<server name="test" purl="http://files5.qq494.cn/pig/hotel/flash/" /> 
		<server name="test" purl="http://s26.coolplusplus.com/bg/" />
		<server name="test" purl="http://rrmall.playcrab.com/bg/" />
		 */
if(CURRENT_PLATFORM == 'test'){
$out .= <<<EOT
	<resource_servers>
	 	<server name="test" purl="http://rrmall.playcrab.com/static/flash/" /> 
	</resource_servers>	
	<app_servers>
	    <server name="test" purl="http://s26.coolplusplus.com/bg/" />
	</app_servers>	
</config>
EOT;
}else{

$out .= <<<EOT
	<resource_servers>
	 	<server name="test" purl="http://58.83.132.57/mall/flash/" /> 
	</resource_servers>	
	<app_servers>
	    <server name="test" purl="http://s27.coolplusplus.com/bg/" />
	    <server name="test" purl="http://s26.coolplusplus.com/bg/" />
	</app_servers>	
</config>
EOT;
}
echo "total_size: $total_size\n";
echo $out;
file_put_contents($outf,$out);
