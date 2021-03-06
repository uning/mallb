<?php
require_once 'TTG.php';
class TT extends TTG{
	public static $ttservers = array(
			'main'=> array(
				'type'=>'TTExtend',
				'procs'=>array(
					array(
						array('host'=>'122.11.61.27','port'=>'15000'),
						array('host'=>'122.11.61.28','port'=>'15000')
					     ),
					array(
						array('host'=>'122.11.61.27','port'=>'17000'),
						array('host'=>'122.11.61.28','port'=>'17000')
					     ),
					)
				),
			//前台用数据
			'data'=> array(
				'type'=>'TTExtend',
				'procs'=>array(
					array(
						array('host'=>'122.11.61.27','port'=>'15002')
					     ),
					),
				),
			//邀请，送礼等存储数据
			'other'=> array(
				'type'=>'TTExtend',
				'procs'=>array(
					array(
						array('host'=>'122.11.61.27','port'=>'15004')
					     ),
					),
				),
			//页面端暂存数据
			'web'=> array(
					'type'=>'TTExtend',
					'procs'=>array(
						array(
							array('host'=>'122.11.61.27','port'=>'16000')
						     ),
						),
				     ),

			//========================================table===========================
			//id 增长
			'genid' => array(
					'type'=>'TokyoTyrantTable',
					'procs'=>
					array(
						array(
							array('host'=>'122.11.61.27','port'=>'16004'),
							array('host'=>'122.11.61.28','port'=>'16004')
						     ),
					     )
					),

			'log'=> array(
					'type'=>'TokyoTyrantTable',
					'procs'=>array(
						array(
							array('host'=>'122.11.61.27','port'=>'16002')
							,array('host'=>'122.11.61.28','port'=>'16002')
						     ),
						),
				     ),
			'gem' => array(
					'type'=>'TTable',
					'procs'=>
					array(
						array(
							array('host'=>'122.11.61.27','port'=>'16010')
						     ),
					     )
				       ),

			'link'=> array(
					'type'=>'TTable',
					'procs'=>array(
						array(
							array('host'=>'122.11.61.27','port'=>'16006')
						     ),
						),
				      ),
			'order'=> array(
					'type'=>'TTable',
					'procs'=>array(
						array(
							array('host'=>'122.11.61.27','port'=>'16008')
						     ),
						),
				       ),
			'debug'=> array(
					'type'=>'TTable',
					'procs'=>array(
						array(
							array('host'=>'122.11.61.27','port'=>'16100')
						     ),
						),
				       ),
			);
}
