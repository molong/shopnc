<?php 
/**
 * 优惠券店铺前台
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

class coupon_storeControl extends BaseStoreControl {
	
	/*
	 * 优惠券详细信息
	 */
	public function detailOp(){	
		
		Language::read('home_coupon_index');
		$lang	= Language::getLangContent();
		
		$id = intval($_GET['coupon_id']);
		if($id<1){
			showMessage(Language::get('coupon_index_error'),'','html','error');//'该优惠券不存在' 
		}
		$model_coupon = Model('coupon') ;
		$coupon_detail = $model_coupon->getOneById($id) ;
		if(is_array($coupon_detail)&&!empty($coupon_detail)){

		 	//获取店铺信息
            $store_info = $this->getStoreInfo($coupon_detail['store_id']);

			$_GET['id'] = $store_info['store_id'] ;//左侧分类的数据用到
			
      //查询店铺动态评价
      $this->show_storeeval($store_info['store_id']);
			/*
			 * 下架到期的优惠券
			 */
			$this->offsaleCoupon($store_info['store_id']) ;
			/*
			 * 获取最新的优惠券
			 */
			$condition = array() ;
			$new = $model_coupon->getCoupon(array('order'=>'coupon_add_date desc','limit'=>3,'coupon_state'=>'2','store_id'=>$store_info['store_id'])) ;
			if(!empty($new)){
				foreach($new as $key=>$val){
				
					$new[$key]['coupon_pic'] = $val['coupon_pic'] != '' ? $val['coupon_pic'] : SiteUrl.DS.ATTACH_COUPON.DS.'default.gif' ;
				
				}			
			}
			Tpl::output('new',$new) ;
			
			/*
			 * 如果存在则调用数据库生成数组
			 */
			$coupon_detail['coupon_pic'] = $coupon_detail['coupon_pic'] != '' ? $coupon_detail['coupon_pic'] : SiteUrl.DS.ATTACH_COUPON.DS.'default.gif' ;
			$model_coupon->update_coupon(array('coupon_click'=>array('sign'=>'increase','value'=>1)),array('coupon_id'=>$_GET['coupon_id'])) ;
			Tpl::output('index_sign', 'coupon') ;
			Tpl::output('detail',$coupon_detail) ;
			Tpl::output('page','coupon');
			
			Model('seo')->type('coupon')->param(array('name'=>$coupon_detail['coupon_title']))->show();
			Tpl::showpage('coupon_detail');
		}else{
			showMessage(Language::get('coupon_index_error'),'','html','error') ;//'该优惠券不存在'
		}
	}

	/*
	 * 下架到期优惠券
	 */
	private function offsaleCoupon($store_id){
		$coupon = Model('coupon') ;
		$coupon->update_coupon(array('coupon_state'=>'1'),array('coupon_state'=>'2','coupon_novalid'=>true,'store_id'=>$store_id));
	}

	/*
	 * 优惠券打印
	 * 
	 */
	public function coupon_printOp(){
		/**
		 * 读取语言包
		 */
		Language::read('member_store_index');
		/**
		 * 页面title
		 */
		Tpl::output('html_title',Language::get('store_coupon_print'));
	
		/*
		 * 验证传值
		 */
		$validate = new Validate() ;
		$validate->validateparam = array(array('input'=>$_GET['coupon_id'],'require'=>true,'validator'=>'Number','message'=>Language::get('store_coupon_id_error')),
										array('input'=>$_GET['num'],'require'=>true,'validator'=>'Range','min'=>1,'max'=>8,'message'=>Language::get('store_coupon_num_error'))) ;
		$error = $validate->validate() ;
		if($error){
			showMessage($error,'','html','error');
		}else{
			/*
			 * 获得优惠券
			 */
			$model = Model('coupon') ;
			$detail = $model->getOneById(intval($_GET['coupon_id'])) ;
			if(empty($detail)) {
				showMessage(Language::get('store_coupon_error'),'','html','error');
			}else{
				if(stripos($detail['coupon_pic'] ,'http://') === false){
					$pic = SiteUrl.DS.$detail['coupon_pic'] ;
				}else{
					$pic = $detail['coupon_pic'] ;
				}
				/*
				 * 更新下载数量
				 */
				$model->update_coupon(array('coupon_usage'=>array('sign'=>'increase','value'=>1)),array('coupon_id'=>$_GET['coupon_id'])) ;
				/*
				 * 页面输出
				 */
				Tpl::output('pic',$pic);
				Tpl::output('num',$_GET['num']);
				Tpl::showpage('coupon_print','null_layout');
			}
		}
	}
}
