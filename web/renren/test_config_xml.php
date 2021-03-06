<?php
header('Content-type: application/xml');
$mypos=dirname(__FILE__).'/';
$rdir=$mypos.'/../../../Venus/to-company/';
$confile = $rdir.'0_mall_config.xml';
$xml =  simplexml_load_file($confile);
$outf = $mypos.'/static/flash/o_0_mall_config.xml'; 



$out .= <<<EOT
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
		$comment.= " $size bytes $src \n ";
	$r['url']=$src;
	$out .= "   ".$r->asXML()."\n";

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
		$comment.= " $size bytes $src \n ";
	$src.='?v='.md5_file($file);
	$r['url']=$src;
	$out .= "   ".$r->asXML()."\n";
}/*
	    <server name="test" purl="http://s26.coolplusplus.com/static/flash/" />
	    <server name="test" purl="/work/mall/backend/web/public/" />
*/
$on = $_GET['on'];
if($on==1){
$out .= <<<EOT
	
	<resource_servers>
	 	<server name="test" purl="/work/mall/Venus/to-company/" /> 
	</resource_servers>	
	<app_servers>
	    <server name="test" purl="http://s26.coolplusplus.com/bg/" />
	</app_servers>	
</config>
EOT;
}else if($on==2){
$out .= <<<EOT
	<resource_servers>
	    <server name="test" purl="http://s26.coolplusplus.com/static/flash/" />
	</resource_servers>	
	<app_servers>
	    <server name="test" purl="/work/mall/backend/web/public/" />
	</app_servers>	
</config>
EOT;
}else if($on==3){
$out .= <<<EOT
	<resource_servers>
	    <server name="test" purl="http://58.83.132.57/mall/flash/" />
	</resource_servers>	
	<app_servers>
	    <server name="test" purl="/work/mall/backend/web/public/" />
	</app_servers>	
</config>
EOT;
}else {
$out .= <<<EOT
	<resource_servers>
	 	<server name="test" purl="http://192.168.1.50/work/mall/Venus/to-company/" /> 
	</resource_servers>	
	<app_servers>
	    <server name="test" purl="http://rrmall.playcrab.com/tweb/bg/" />
	</app_servers>	
</config>
EOT;
}
$comment.= "total_size: $total_size bytes\n";
echo "<!-- \n";
echo $comment;
echo "\n-->\n";
echo $out;
