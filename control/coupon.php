<?php
/**
 * 优惠券
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
class couponControl extends BaseHomeControl {
	
	public function __construct(){
	
		parent::__construct() ;
		
	}
	
	public function indexOp(){
		$this->listOp();		
	}

	/*
	 * 优惠券列表页
	 */
	public function listOp(){
		Language::read('home_coupon_index');
		/**
		 * 分类导航
		 */
		$nav_link = array(
			0=>array(
				'title'=>Language::get('homepage'),
				'link'=>'index.php'
			),
			1=>array(
				'title'=>Language::get('coupon_index_all')
			)
		);
		Tpl::output('nav_link_list',$nav_link);
		/*
		 * 下架到期优惠券
		 */
		$this->offsaleCoupon() ;
		/*
		 * 生成分页
		 */
		$page = new Page() ;
		$page->setEachNum(8);
		$page->setStyle('admin') ;	
		$keyword = trim($_GET['coupon_keyword']) ;
		$class_id = intval($_GET['catid']) ;
		/*
		 * 得到优惠券列表
		 */		
		$coupon = Model('coupon') ;
		$list = $coupon->getCoupon(array('order'=>'coupon_add_date desc','coupon_state'=>'2','coupon_name_like'=>$keyword, 'coupon_class'=>$class_id,'coupon_allowstate'=>'1','coupon_valid'=>true), $page) ;
		/*
		 * 得到热销优惠券及其商家 
		 */
		$hot = $coupon->getCoupon(array('order'=>'coupon_usage desc', 'coupon_state'=>'2', 'limit'=>8,'coupon_allowstate'=>'1','coupon_recommend'=>'1','coupon_valid'=>true),'','store') ;
		/*
		 * 得到优惠券类别
		 */
		$coupon_class = Model('coupon_class') ;
		if(intval($class_id) > 0) {
			$class = $coupon_class->getCouponClass(array('class_id'=>intval($class_id))) ;
			if($class[0]['class_id'] > 0) {
				$nav_link[1]['link'] = 'index.php?act=coupon';
				$nav_link[2]['title'] = $class[0]['class_name'];//分类导航
				Tpl::output('nav_link_list', $nav_link) ;
			}
		}
		
		$class_list = $coupon_class->getCouponClass(array('coupon_name_like'=>$keyword,'class_id'=>$class_id,'coupon_state'=>'2','coupon_allowstate'=>'1','coupon_valid'=>true),'','join') ;	//得到含优惠券数量的结果

		/*
		 * 得到符合条件的优惠券总数
		 */
		$num = 0 ;
		if(is_array($class_list)&&!empty($class_list)){
			
			foreach($class_list as $k=>$v){
				
				$num += intval($v['num']) ;
			
			}

		}
		
		Tpl::output('num', $num) ;
		/*
		 * 得到推荐商铺列表
		 */
		$model_store = Model('store') ;
		$recommend_shop = $model_store->getRecommendStore(5) ;

		Tpl::output('recommend',$recommend_shop) ;
		Tpl::output('class',$class_list) ;
		Tpl::output('hot',$hot) ;
		Tpl::output('coupon_keyword',$keyword) ;
		Tpl::output('list',$list) ;
		Tpl::output('index_sign','coupon');
		Tpl::output('show_page',$page->show()) ;

		Model('seo')->type('coupon')->show();
		Tpl::showpage('coupon_list') ;
	}

	/*
	 * 下架到期优惠券
	 */
	private function offsaleCoupon(){
		$coupon = Model('coupon') ;
		$coupon->update_coupon(array('coupon_state'=>'1'),array('coupon_state'=>'2','coupon_novalid'=>true));
	}
	
}
