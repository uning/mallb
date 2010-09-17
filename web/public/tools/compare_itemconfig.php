<?php
require_once dirname(__FILE__).'/../ItemConfig.php';
$xmldir = dirname(__FILE__).'/../../../../Venus/to-company/resource/simplifiedchinese/xml/';
$file = $xmldir.'items.xml';
$xml = simplexml_load_file( $file );
$items = $xml->items;
foreach( $items as $item ){
    foreach( $item as $objects ){
        $tag = $objects['id'];  
        $attrs = $objects->attributes( );
        $config = ItemConfig::$_config[(int)$tag];
        //编码处理
        unset( $attrs['name'] );
        unset( $config['name'] );
        
        foreach( $attrs as $key => $value ){
            if( $key == 'id' ){
                continue;
            }
            if( isset( $config[$key] )){
                if( $config[$key] != $value ){
                    echo "unequal when key = $key and tag = $tag \n";
                    exit;
                }
                echo "equal\n";
            }
        } 
    }
}
echo "finish\n";