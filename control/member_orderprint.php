<?php
/**
 * 会员中心——账户概览
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class member_orderprintControl extends BaseMemberControl {
	public function __construct() {
		parent::__construct();
		Language::read('member_printorder');
	}
	/**
	 * 查看订单
	 */
	public function indexOp() {
		/*if ($_GET['s']){
			session_write_close();
			session_id($_GET['s']);
			session_start();
		}*/
		$order_id	= intval($_GET['order_id']);
		if ($order_id <= 0){
			showMessage(Language::get('wrong_argument'),'','html','error');
		}
		$order_model = Model('order');
		$condition['order_id'] = $order_id;
		$order_info = $order_model->getOrderById($order_id,'all',$condition);
		if (empty($order_info)){
			showMessage(Language::get('member_printorder_ordererror'),'','html','error');
		}
		if ($order_info['seller_id'] != $_SESSION['member_id']){
			showMessage(Language::get('member_printorder_ordererror'),'','html','error');
		}
		Tpl::output('order_info',$order_info);
		//卖家信息
		$model_store	= Model('store');
		$store_info		= $model_store->shopStore(array('store_id'=>$order_info['store_id']));
		if (!empty($store_info['store_label'])){
			if (file_exists(BasePath.DS.ATTACH_STORE.DS.$store_info['store_label'])){
				$store_info['store_label'] = SiteUrl.DS.ATTACH_STORE.DS.$store_info['store_label'];
			}else {
				$store_info['store_label'] = '';
			}
		}
		if (!empty($store_info['store_stamp'])){
			if (file_exists(BasePath.DS.ATTACH_STORE.DS.$store_info['store_stamp'])){
				$store_info['store_stamp'] = SiteUrl.DS.ATTACH_STORE.DS.$store_info['store_stamp'];
			}else {
				$store_info['store_stamp'] = '';
			}
		}
		Tpl::output('store_info',$store_info);
		//实例化买家订单模型
		$ordergoods_model = Model('order_goods');
		//订单商品
		$ordergoods_list= $ordergoods_model->getOrderGoodsList(array('order_id'=>$order_id));
		$ordergoods_listnew = array();
		$goods_allnum = 0;
		$goods_totleprice = 0;
		if (!empty($ordergoods_list)){
			$goods_count = count($ordergoods_list);
			$i = 1;
			foreach ($ordergoods_list as $k=>$v){
				$v['goods_name'] = str_cut($v['goods_name'],100);
				$v['spec_info'] = str_cut($v['spec_info'],40);
				$goods_allnum += $v['goods_num'];				
				$v['goods_allprice'] = ncPriceFormat($v['goods_num']*$v['goods_price']);
				$goods_totleprice += $v['goods_allprice'];
				$ordergoods_listnew[ceil($i/4)][$i] = $v;
				$i++;
			}
		}
		//优惠金额
		$order_info['discount'] = ncPriceFormat($order_info['voucher_price']);
		//运费
		$order_info['shipping_fee'] = $order_info['shipping_fee'];
		Tpl::output('discount',$discount);
		Tpl::output('goods_allnum',$goods_allnum);
		Tpl::output('goods_totleprice',ncPriceFormat($goods_totleprice));
		Tpl::output('ordergoods_list',$ordergoods_listnew);
		Tpl::showpage('member_orderprint',"null_layout");
	}
	/**
	 * PDF
	 */
/*	public function pdfOp(){
		$order_id	= intval($_GET['order_id']);
		if ($order_id <= 0){
			showMessage("参数错误",'','html','error');
		}
		$order_model = Model('order');
		$condition['order_id'] = $order_id;
		$order_info = $order_model->getOrderById($order_id,'all',$condition);
		if (empty($order_info)){
			showMessage("订单信息错误",'','html','error');
		}
		if ($order_info['seller_id'] != $_SESSION['member_id'] && $order_info['buyer_id'] != $_SESSION['member_id']){
			showMessage("订单信息错误",'','html','error');
		}
		require_once(BasePath.DS."resource".DS."html2pdf".DS."html2fpdf.php");
		$pdf=new HTML2FPDF();
		$pdf->AddGBFont();
		$pdf->SetLeftMargin(10);
		
		$pdf->AddPage();
		$pdf->SetFont('GB','B',10);
		session_write_close();
		$content = file_get_contents(SiteUrl.DS.'index.php?act=member_orderprint&order_id='.$order_id."&s=".session_id());
		$pdf->WriteHTML($content);
				
		$pdf_name=$order_info['order_sn'].".pdf";
		//$pdf->Output($pdf_name);
		$pdf->Output(BasePath.DS."pdf".DS.$pdf_name);
		//return $pdf_name;
	}*/
}
