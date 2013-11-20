<?php
/**
 * 评价统计功能
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
require_once(dirname(dirname(__FILE__)).'/api_global.php');
class eval_stat extends APIControl {
	public function __construct() {
		parent::__construct();
		$this->setHeader();
	}
	/**
	 * 一键统计评价信息
	 */
    public function index() {
    	//自动回复功能
    	$this->autoreplay();
    	//统计会员信用功能
    	$this->buyereval(1);
    	//统计卖家信用功能
    	$this->sellereval(1);
    	//统计店铺动态评分
    	$this->storeeval(1);
    	//商品评论数统计
    	$this->goodseval(1);
    	exit('success');
    }
	/**
	 * 统计会员信用功能
	 */
	public function buyereval($step){
		//更新会员信用
		$member_model = $this->getModel('member');
		$condition_arr = array();
		$condition_arr['member_state'] = '1';
		//步长
		$num = 100;
		$condition_arr['limit'] = $num*($step-1).','.$num*$step;
		$member_list = $member_model->getMemberList($condition_arr);
		if (empty($member_list)){
			return 'end';
		}else {
			$evaluate_model = $this->getModel('evaluate');
			foreach ($member_list as $k=>$v){
				$evaluate_model->memberEvalstat($v['member_id']);
			}
			$this->buyereval($step+1);
		}
	}
	/**
	 * 统计卖家信用功能
	 */
	public function sellereval($step){
		//更新会员信用
		$store_model = $this->getModel('store');
		$condition_arr = array();
		$condition_arr['store_state'] = '1';
		//步长
		$num = 100;
		$condition_arr['limit'] = $num*($step-1).','.$num*$step;
		$store_list = $store_model->getStoreList($condition_arr);
		if (empty($store_list)){
			return 'end';
		}else {
			$evaluate_model = $this->getModel('evaluate');
			foreach ($store_list as $k=>$v){
				$evaluate_model->goodsEvalstat($v['store_id']);
			}
			$this->sellereval($step+1);
		}
	}
	/**
	 * 统计店铺动态评分
	 */
	public function storeeval($step){
		//更新会员信用
		$store_model = $this->getModel('store');
		$condition_arr = array();
		$condition_arr['store_state'] = '1';
		//步长
		$num = 100;
		$condition_arr['limit'] = $num*($step-1).','.$num*$step;
		$store_list = $store_model->getStoreList($condition_arr);
		if (empty($store_list)){
			return 'end';
		}else {
			$evaluate_model = $this->getModel('evaluate');
			foreach ($store_list as $k=>$v){
				$evaluate_model->storeEvalstat($v['store_id']);
			}
			$this->storeeval($step+1);
		}
	}
	/**
	 * 商品评论数统计
	 */
	public function goodseval($step){
		//更新会员信用
		$goods_model = $this->getModel('goods');
		$condition_arr = array();
		$condition_arr['goods_show'] = '1';
		$condition_arr['goods_state'] = '0';
		//步长
		$num = 100;
		$condition_arr['limit'] = $num*($step-1).','.$num*$step;
		$goods_list = $goods_model->getGoods($condition_arr,'','*','goods');
		if (empty($goods_list)){
			return 'end';
		}else {
			$evaluate_model = $this->getModel('evaluate');
			foreach ($goods_list as $k=>$v){
				$evaluate_model->goodsEvalCountNum($v['goods_id']);
			}
			$this->goodseval($step+1);
		}
	}
	/**
	 * 自动回复功能
	 */
	public function autoreplay(){
		$starttime = time();//开始执行时间
		//一方好评15天后，对方未评价，则自动回复好评
		$member_model = $this->getModel('member');
		$evaluate_model = $this->getModel('evaluate');
		$condition_arr = array();
		$condition_arr['geval_bothstate'] = '1';
		$condition_arr['geval_scores'] = '1';
		$condition_arr['geval_showtime_lt'] = time();
		$condition_arr['order'] = 'evaluate_goods.geval_id asc';
		$goodseval_list = $evaluate_model->getGoodsEvalList($condition_arr);
		unset($condition_arr);
		if (!empty($goodseval_list)){
			foreach ($goodseval_list as $k=>$v){
				$insert_arr = array();
				foreach ($v as $skey => $sval){
					if (!is_numeric($skey) && $skey!='geval_id'){
						$insert_arr[$skey] = $sval;
					}
				}
				$insert_arr['geval_content'] = '';
				$insert_arr['geval_isanonymous'] = '0';
				$insert_arr['geval_addtime'] = time();
				$insert_arr['geval_frommemberid'] = $v['geval_tomemberid'];
				$insert_arr['geval_frommembername'] = $v['geval_tomembername'];
				$insert_arr['geval_tomemberid'] = $v['geval_frommemberid'];
				$insert_arr['geval_tomembername'] = $v['geval_frommembername'];
				$insert_arr['geval_state'] = 0;
				$insert_arr['geval_remark'] = '';
				$insert_arr['geval_explain'] = '';
				$insert_arr['geval_bothstate'] = '2';
				if ($v['geval_type'] == 1){
					$insert_arr['geval_type'] = '2';
				}else {
					$insert_arr['geval_type'] = '1';
				}
				$state = $evaluate_model->addGoodsEval($insert_arr);
				unset($insert_arr);
				if ($state){
					//更新原评价数据
					$evaluate_model->editGoodsEval(array('geval_bothstate'=>'2'),array('geval_id'=>"{$v['geval_id']}"));
					//更新订单的评价状态
					$order_model = $this->getModel('order');					
					$uparr = array();
					if ($v['geval_type'] == 1){
						$uparr['evalseller_status'] = 1;
						$uparr['evalseller_time'] = time();
					}else {
						$uparr['evaluation_status'] = 1;
						$uparr['evaluation_time'] = time();
					}
					$order_model->updateOrder($uparr,$v['geval_orderid']);
				}
				if (time()-$starttime >= 25){//执行了25秒后刷新一次
					autoreplay();
				}
			}
		}else {
			//进入下一步统计会员信用功能
			return 'end';
		}
	}
}
$eval_stat = new eval_stat();
$eval_stat->index();
?>