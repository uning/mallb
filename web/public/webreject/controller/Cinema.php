<?php
class Cinema
{
	/**
	 * 把顾客强行拖进电影院，目前按4分钟进一个计算
	 * @param $params
	 *   require  u               -- 玩家id
	 *            cid             -- cinema id
	 *            fid             -- 好友id
	 * @return 
	 *            s         --  OK
	 *                      --  notexsit 电影院不存在
	 *                      --  showing  正在播放，不能拖人
	 */	
	public function enter( $params )
	{
		$uid = $params['u'];
		$cid = $params['cid'];
		$fid = $params['fid'];
		$now = time();
		if( $fid )
		    $uid = $fid;
		$tu = new TTUser( $uid );
		$cinema_obj = $tu->getbyid( $cid );
//		$ret['bcinemaobj'] = $cinema_obj;  //for debug
//		$ret['btime'] = date( TM_FORMAT,$cinema_obj['ctime'] );   //for debug
		if( !$cinema_obj ){
			$ret['s'] = 'notexsit';
			return $ret;
		}
		$item = ItemConfig::getItem( $cinema_obj['tag'] );
		if(  floor(  ( $now - $cinema_obj['ctime'] ) * 2 / $item['mintime'] ) % 2 == 1  ){
		    $ret['s'] = 'showing';
		    return $ret;
		}
		$cinema_obj['ctime'] -= $item['selltime'];
//		$ret['atime'] = date( TM_FORMAT,$cinema_obj['ctime'] );  //for debug
//		$ret['acinemaobj'] = $cinema_obj;  //for debug
		$tu->puto( $cinema_obj,TT::CINEMA_GROUP );
		$ret['s'] = 'OK';
		return $ret;
	}

	/**
	 * 捡钱并结算
	 * @param $params
	 *   require  u               -- 玩家id
	 *            sid             -- shop id 不仅限于cinema
	 * @return 
	 *            s         --  OK
	 */	
	public function pick( $params )
	{
		$uid = $params['u'];
		$sid = $params['sid'];
		$now = time();
		$tu = new TTUser( $uid );
		$shop_obj = $tu->getbyid( $sid );
//		$ret['now'] = $now;  //for debug
//		$ret['fnow'] = date( TM_FORMAT,$now );  //for debug
//		$ret['bshopobj'] = $shop_obj;  //for debug
//		$ret['fbshopobj'] = date( TM_FORMAT,$shop_obj['ctime'] );  //for debug
		if( !$shop_obj ){
			$ret['s'] = 'notexist';
			return $ret;
		}	
		$item = ItemConfig::getItem( $shop_obj['tag'] );
		if( !$item ){
			$ret['s'] = 'itemnotexsit';
			return $ret;
		}
		if( $now - $shop_obj['ctime'] < $item['mintime'] ){   //开业mintime后就可以收钱，但最多只能积累maxtime
			$ret['s'] = 'time';
			return $ret;
		}
		$gap = $now - $shop_obj['ctime'];
		$factor = floor( $gap / $item['mintime'] );
		$money = $factor * $item['sellmoney'];
		$shop_obj['ctime'] += $factor * $item['mintime'];
		if( $gap > $item['maxtime'] ){
			$money = floor( $item['maxtime'] / $item['mintime'] ) * $item['sellmoney'];
            $shop_obj['ctime'] = $now;
		}
		$tu->chMoney($money );
		$tu->puto( $shop_obj,TT::CINEMA_GROUP );
//		$ret['fashopobj'] = date( TM_FORMAT,$shop_obj['ctime'] );  //for debug
//		$ret['ashopobj'] = $shop_obj;  //for debug
        TTLog::record( array('m'=>__METHOD__,'tm'=> $_SERVER['REQUEST_TIME'],'u'=>$uid,'intp1'=>$money,'sp1'=>$shop_obj['ctime'] ) );
		$ret['money'] = $money;
		$ret['s'] = 'OK';
        return $ret;
	}
}
