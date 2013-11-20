<?php
/**
 * 商品评价
 * 
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class updatestatControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('updatestat');
	}

	public function indexOp(){
		$this->liststatOp();
	}

	/**
	 * 统计功能展示
	 */
	public function liststatOp(){
		Tpl::showpage('updatestat.index');
	}
	/**
	 * 统计会员信用功能
	 */
	public function buyerevalOp(){
		if ($_GET['end']!='ok'){
			//执行自动回复
			$this->autoreplayOp();		
		}
		//更新会员信用
		$member_model = Model('member');
		$condition_arr = array();
		$condition_arr['member_state'] = '1';
		//步长
		$num = intval($_GET['num'])> 0?intval($_GET['num']):100;
		$step = intval($_GET['step']) >0 ?intval($_GET['step']):1;
		$condition_arr['limit'] = $num*($step-1).','.$num*$step;
		$member_list = $member_model->getMemberList($condition_arr);
		if (empty($member_list)){
			showMessage(Language::get('admin_updatesuccess'),'index.php?act=updatestat');
		}else {
			$evaluate_model = Model('evaluate');
			foreach ($member_list as $k=>$v){
				$evaluate_model->memberEvalstat($v['member_id']);
			}
			$url = 'index.php?act=updatestat&op=buyereval&end=ok&num='.$num.'&step='.($step+1);
			$url_arr = array();
			$url_arr[] = array('url'=>$url,'msg'=>Language::get('admin_nextstep'));
			$url_arr[] = array('url'=>'index.php?act=updatestat','msg'=>Language::get('admin_cancelupdate'));
			showMessage(Language::get('admin_updatedoing'),$url_arr);
		}
	}
	/**
	 * 统计卖家信用功能
	 */
	public function sellerevalOp(){
		if ($_GET['end']!='ok'){
			//执行自动回复
			$this->autoreplayOp();		
		}
		//更新会员信用
		$store_model = Model('store');
		$condition_arr = array();
		$condition_arr['store_state'] = '1';
		//步长
		$num = intval($_GET['num'])> 0?intval($_GET['num']):100;
		$step = intval($_GET['step']) >0 ?intval($_GET['step']):1;
		$condition_arr['limit'] = $num*($step-1).','.$num*$step;
		$store_list = $store_model->getStoreList($condition_arr);
		if (empty($store_list)){
			showMessage(Language::get('admin_updatesuccess'),'index.php?act=updatestat');
		}else {
			$evaluate_model = Model('evaluate');
			foreach ($store_list as $k=>$v){
				$evaluate_model->goodsEvalstat($v['store_id']);
			}
			$url = 'index.php?act=updatestat&op=sellereval&end=ok&num='.$num.'&step='.($step+1);
			$url_arr = array();
			$url_arr[] = array('url'=>$url,'msg'=>Language::get('admin_nextstep'));
			$url_arr[] = array('url'=>'index.php?act=updatestat','msg'=>Language::get('admin_cancelupdate'));
			showMessage(Language::get('admin_updatedoing'),$url_arr);
		}
	}
	/**
	 * 统计店铺动态评分
	 */
	public function storeevalOp(){
		if ($_GET['end']!='ok'){
			//执行自动回复
			$this->autoreplayOp();		
		}
		//更新会员信用
		$store_model = Model('store');
		$condition_arr = array();
		$condition_arr['store_state'] = '1';
		//步长
		$num = intval($_GET['num'])> 0?intval($_GET['num']):100;
		$step = intval($_GET['step']) >0 ?intval($_GET['step']):1;
		$condition_arr['limit'] = $num*($step-1).','.$num*$step;
		$store_list = $store_model->getStoreList($condition_arr);
		if (empty($store_list)){
			showMessage(Language::get('admin_updatesuccess'),'index.php?act=updatestat');
		}else {
			$evaluate_model = Model('evaluate');
			foreach ($store_list as $k=>$v){
				$evaluate_model->storeEvalstat($v['store_id']);
			}
			$url = 'index.php?act=updatestat&op=storeeval&end=ok&num='.$num.'&step='.($step+1);
			$url_arr = array();
			$url_arr[] = array('url'=>$url,'msg'=>Language::get('admin_nextstep'));
			$url_arr[] = array('url'=>'index.php?act=updatestat','msg'=>Language::get('admin_cancelupdate'));
			showMessage(Language::get('admin_updatedoing'),$url_arr);
		}
	}
	/**
	 * 商品评论数统计
	 */
	public function goodsevalOp(){
		if ($_GET['end']!='ok'){
			//执行自动回复
			$this->autoreplayOp();		
		}
		//更新会员信用
		$goods_model = Model('goods');
		$condition_arr = array();
		$condition_arr['goods_show'] = '1';
		$condition_arr['goods_state'] = '0';
		//步长
		$num = intval($_GET['num'])> 0?intval($_GET['num']):100;
		$step = intval($_GET['step']) >0 ?intval($_GET['step']):1;
		$condition_arr['limit'] = $num*($step-1).','.$num*$step;
		$goods_list = $goods_model->getGoods($condition_arr,'','*','goods');
		if (empty($goods_list)){
			showMessage(Language::get('admin_updatesuccess'),'index.php?act=updatestat');
		}else {
			$evaluate_model = Model('evaluate');
			foreach ($goods_list as $k=>$v){
				$evaluate_model->goodsEvalCountNum($v['goods_id']);
			}
			$url = 'index.php?act=updatestat&op=goodseval&end=ok&num='.$num.'&step='.($step+1);
			$url_arr = array();
			$url_arr[] = array('url'=>$url,'msg'=>Language::get('admin_nextstep'));
			$url_arr[] = array('url'=>'index.php?act=updatestat','msg'=>Language::get('admin_cancelupdate'));
			showMessage(Language::get('admin_updatedoing'),$url_arr);
		}
	}
	/**
	 * 自动回复功能
	 */
	public function autoreplayOp(){
		$current_url = request_uri();
		$starttime = time();//开始执行时间
		//一方好评15天后，对方未评价，则自动回复好评
		$member_model = Model('member');
		$evaluate_model = Model('evaluate');
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
					$order_model = Model('order');					
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
				if (time()-$starttime >= 25){//页面执行了25秒后刷新一次
					@header('Location:'.$current_url);
				}
			}
		}else {
			//进入下一步统计会员信用功能
			@header('Location:'.$current_url.'&end=ok');
		}
	}
}
?>