<?php
/**
 * 交易管理
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class tradeControl extends SystemControl{
	const EXPORT_SIZE = 5000;
	public function order_manageOp(){
		/**
		 * 读取语言包
		 */
		Language::read('trade');
		$lang	= Language::getLangContent();

		$condition	= array();
		$filterd	= false;
		if(trim($_GET['search_name']) != '' and trim($_GET['field']) != ''){
			$condition[$_GET['field']]	= trim($_GET['search_name']);
			$filterd	= true;
		}
		if(in_array($_GET['status'],array('0','10','11','20','30','40','50'))){
			$condition['status']	= $_GET['status'];
			$filterd	= true;
		}
		if(trim($_GET['add_time_from']) != ''){
			$add_time_from	= strtotime(trim($_GET['add_time_from']));
			if($add_time_from !== false){
				$condition['add_time_from']	= $add_time_from;
				unset($add_time_from);
				$filterd	= true;
			}
		}
		if(trim($_GET['add_time_to']) != ''){
			$add_time_to	= strtotime(trim($_GET['add_time_to']));
			if($add_time_to !== false){
				$condition['add_time_to']	= $add_time_to+86400;
				unset($add_time_to);
				$filterd	= true;
			}
		}
		if(trim($_GET['order_amount_from']) != ''){
			$condition['order_amount_from']	= trim($_GET['order_amount_from']);
			$filterd	= true;
		}
		if(trim($_GET['order_amount_to']) != ''){
			$condition['order_amount_to']	= trim($_GET['order_amount_to']);
			$filterd	= true;
		}
		
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');

		$order	= Model('order');
		$order_list	= $order->getOrderList($condition,$page);

		Tpl::output('order_list',$order_list);
		Tpl::output('show_page',$page->show());
		Tpl::output('search',$_GET);
		Tpl::output('filterd',$filterd);
		Tpl::showpage('order.index');
	}

	/**
	 * 查看订单
	 *
	 */
	public function show_orderOp(){
		Language::read('trade');
		$lang	= Language::getLangContent();

		if(empty($_GET['order_id'])){
			showMessage($lang['miss_order_number']);
		}
		$order_id	= intval($_GET['order_id']);
		$order	= Model('order');
		$list	= $order->OrderGoodsList(array('order_id'=>$order_id));
		/**
		 * 实例化退款模型
		 */
		$model_refund	= Model('refund');
		$condition = array();
		$condition['order_id'] = $order_id;
		$condition['refund_state'] = '2';
		$condition['order']	=  'log_id asc';
		$refund_list = $model_refund->getList($condition);
		Tpl::output('refund_list',$refund_list);
		/**
		 * 实例化退货模型
		 */
		$model_return	= Model('return'); 
		$condition = array();
		$condition['order_id'] = $order_id;
		$condition['return_state'] = '2';
		$condition['order']	=  'return.return_id asc';
		$return_list= $model_return->getReturnGoodsList($condition);
		Tpl::output('return_list',$return_list);
		Tpl::output('list',$list);
		Tpl::showpage('order.view');
	}

	/**
	 * 导出
	 *
	 */
	public function export_step1Op(){
		Language::read('trade');
		$lang	= Language::getLangContent();

		$condition	= array();
		if(trim($_GET['search_name']) != '' and trim($_GET['field']) != ''){
			$condition[$_GET['field']]	= trim($_GET['search_name']);
		}
		if(in_array($_GET['status'],array('0','10','11','20','30','40','50'))){
			$condition['order_state']	= $_GET['status'];
		}
		if(!empty($_GET['add_time_from'])){
			$time1	= strtotime($_GET['add_time_from']);
		}
		if(!empty($_GET['add_time_to'])){
			$time2	= strtotime($_GET['add_time_to']);
			if($time2 !== false) $time2 = $time2 + 86400;
		}
		if ($time1 && $time2){
			$condition['addtime'] = array('between',array($time1,$time2));
		}elseif($time1){
			$condition['addtime'] = array('egt',$time1);
		}elseif($time2){
			$condition['addtime'] = array('elt',$time2);
		}
		if (is_numeric($_GET['order_amount_from']) && is_numeric($_GET['order_amount_to'])){
			$condition['order_amount'] = array('between',array($_GET['order_amount_from'],$_GET['order_amount_to']));
		}elseif (is_numeric($_GET['order_amount_from'])){
			$condition['order_amount'] = array('egt',$_GET['order_amount_from']);
		}elseif (is_numeric($_GET['order_amount_to'])){
			$condition['order_amount'] = array('elt',$_GET['order_amount_to']);
		}

		$model = Model();
		if (!is_numeric($_GET['curpage'])){		
			$count = $model->table('order')->where($condition)->count();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('download_lang',Language::get('order_manage'));
				Tpl::output('murl','index.php?act=trade&op=order_manage');
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$field = 'order_sn,seller_id,store_id,store_name,order_state,order_amount,buyer_id,buyer_name,buyer_email,add_time,payment_id,payment_name,shipping_fee,shipping_name';
				$data = $model->table('order')->field($field)->where($condition)->order('order_id desc')->limit(self::EXPORT_SIZE)->select();
				$this->createExcel($data);
			}
		}else{	//下载
			$field = 'order_sn,seller_id,store_id,store_name,order_state,order_amount,buyer_id,buyer_name,buyer_email,add_time,payment_id,payment_name,shipping_fee,shipping_name';
			$limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
			$limit2 = self::EXPORT_SIZE;
			$data = $model->table('order')->field($field)->where($condition)->order('order_id desc')->limit("{$limit1},{$limit2}")->select();
			$this->createExcel($data);
		}
	}

	/**
	 * 生成excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_no'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_store'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_buyer'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_xtimd'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_count'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_yfei'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_paytype'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_state'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_storeid'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_selerid'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_buyerid'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_od_bemail'));
		//data
		$cn_state = array(L('exp_od_sta_qx'),L('exp_od_sta_dfk'),L('exp_od_sta_dqr'),L('exp_od_sta_yfk'),L('exp_od_sta_yfh'),L('exp_od_sta_yjs'),L('exp_od_sta_dsh'),L('exp_od_sta_yqr'));
		foreach ((array)$data as $k=>$v){
			if ($v['order_state'] == 0) $v['order_state'] = '00';
			$v['order_state'] = str_replace(array('00',10,11,20,30,40,50,60),$cn_state,$v['order_state']);
			$tmp = array();
			$tmp[] = array('data'=>$v['order_sn']);
			$tmp[] = array('data'=>$v['store_name']);
			$tmp[] = array('data'=>$v['buyer_name']);
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['add_time']));
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['order_amount']));
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['shipping_fee']));
			$tmp[] = array('data'=>$v['payment_name']);
			$tmp[] = array('data'=>$v['order_state']);
			$tmp[] = array('data'=>$v['store_id']);
			$tmp[] = array('data'=>$v['seller_id']);
			$tmp[] = array('data'=>$v['buyer_id']);
			$tmp[] = array('data'=>$v['buyer_email']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_od_order'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_od_order'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}