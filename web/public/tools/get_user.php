<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
echo "<pre>\n";
require_once '../base.php';
$u=$argv[1];
if(!$u){
	$u=$_REQUEST['u'];
}
if(!$u){
	$pid = $argv[2];
	if(!$pid){
		$pid=$_REQUEST['pid'];
	}
	if(!$pid){
		$pid = $_COOKIE['user_name'];

	}
	if(!$pid){
		die( "no param");

	}
	$data = TTGenid::getbypid($pid);
}else
	$data = TTGenid::getbyid($u);
if($data['id'])
	$u = $data['id'];
if(!$data)
	die( "$u $pid no u get");
$tu = new TTUser( $u,true );
print_r($data);
$tt=$tu->getAll(false);
$all = TTExtend::processmap( $tt );
print_r( $all );
print_r($tt);


//检查是否有位置重叠的卡车 (只检查横向重叠)
$car_pos = array();
foreach( $all['c'] as $car_obj ){
    $x = $car_obj['pos']['x'];
    $y = $car_obj['pos']['y'];    
    $car = ItemConfig::getItem( $car_obj['tag'] );
    for( $i=0;$i<$car['gridWidth'];$i++ ){
        if( !$car_pos[$x+$i][$y] ){
            $car_pos[$x+$i][$y] = 1;
        }
        else{
            echo "出现重叠车位： \n";
            print_r( $car_obj );
            break;
        }
    }
}

//检查店铺相关 
$shops = $tu->get( TT::SHOP_GROUP );
$shop_pos = array();
foreach( $shops as $shop_obj){
    if( $shop_obj['pos'] == 's' && $shop_obj['goods'] ){
        echo "出现shop['goods']不为空，但实际货物已经卖完的情况： \n";
        echo "店铺数据： \n";
        print_r( $shop_obj );
        echo "货物数据： \n";
        foreach ( $shop_obj['goods'] as $id ){
            $goods = $tu->getbyid( $id );
            print_r( $goods );
            if( $goods['stime'] ){
                $time1 = date( TM_FORMAT,$goods['stime'] );
                echo "上架时间： $time1 \n";
            }
            if( $goods['ctime'] ){
                $time2 = date( TM_FORMAT,$goods['ctime'] );
                echo "结算时间： $time2 \n";
            }
        }
    }
    if( $shop_obj['pos'] != 's' ){
	    $shop = ItemConfig::getItem( $shop_obj['tag'] );
        if( $shop_obj['goods'] ){
            foreach( $shop_obj['goods'] as $id ){
                $goods = $tu->getbyid( $id );
                if( $goods ){
                    $item = ItemConfig::getItem( $goods['tag'] );
                    if( $item['gridWidth'] != $shop['gridWidth'] ){
                        echo "出现宽度与店铺宽度不一致的货物 : \n";
                        print_r( $goods );
                    }
                }
            }
        }
        else{
            echo "出现卖光货物但没有及时移动到仓库的店铺 ： \n";
            print_r( $shop_obj );
        }
        $x = $shop_obj['pos']['x'];
        $y = $shop_obj['pos']['y'];
        for( $i = 0;$i < $shop['gridWidth'];$i++ ){
            if( !$shop_pos[$x+$i][$y] ){
                $shop_pos[$x+$i][$y] = 1;
            }
            else{
                echo "出现重叠店面： \n";   //只检查横向重叠
                print_r( $shop_obj );
                break;
            }
        }
    }
}

//检查是否有楼体等 
$bb = array(99501=>1
           ,99502=>2
           ,99503=>3
           ,99504=>4
           ,99505=>5
           ,99506=>6
           ,99507=>7
            );
foreach( $all['o'] as $item_obj ){
    if( array_key_exists( $item_obj['tag'],$bb ) ){
        echo "有楼体数据： \n";
        print_r( $item_obj );
        break;
    }
}

?>
</body>
</html>