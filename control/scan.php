<?php
/**
 * 完成AJAX检测状态并进行更新
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
define('MYSQL_RESULT_TYPE',1);
class scanControl extends BaseHomeControl{

	public function indexOp(){
		if (empty($_GET['type'])) return ;
		foreach (explode('|',$_GET['type']) as $v) {
			$func = $v.'Op';
			if (method_exists($this,$func)){
				$this->$func();
			}
		}
	}

	/**
	 * 商品到期自动上架，更新商品开始与结束时间
	 *
	 */
	private function updownOp(){
		$model = Model();
		$condition = array();
		$condition['goods_state'] = 0;
		$condition['goods_starttime'] = array('lt',TIMESTAMP);
		$condition['goods_endtime'] = array('gt',TIMESTAMP);
		
		// 上架
		$model->table('goods')->where($condition)->attr('LOW_PRIORITY')->update(array('goods_show'=>1));

		// 更新商品开始结束时间
		$data['goods_starttime'] = TIMESTAMP;
		$data['goods_endtime'] =array('exp',C('product_indate')*86400+TIMESTAMP);	
		$model->table('goods')->where(array('goods_show'=>1,'goods_endtime' => array('lt',TIMESTAMP)))->attr('LOW_PRIORITY')->update($data);
	}
}
