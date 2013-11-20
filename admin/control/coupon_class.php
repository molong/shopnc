<?php
/**
 * 优惠券分类管理
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
class coupon_classControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('coupon');
	}
	public function indexOp(){
		switch($_GET['act']){
			default :
				$this->listOp();
				break;
		}
	}
	
	/*
	 * 优惠券分类
	 * 列出优惠券类，删除优惠券类
	 */
	public function coupon_classOp(){
		$this->listOp();
	}
	
	/*
	 * 优惠券分类
	 * 列出优惠券类，删除优惠券类
	 */
	public function listOp(){
		
		$lang	= Language::getLangContent();
		
		if($_REQUEST['form_submit']=='ok'){
		
			$id	= '';
			
			if(empty($_REQUEST['class_id'])){
				showMessage(Language::get('coupon_class_del'));
			}
			if(is_array($_POST['class_id'])){
				$id	= "'".implode("','",$_POST['class_id'])."'";
			}else{
				$id	= intval($_GET['class_id']);
			}
			
			$coupon_class = Model('coupon_class');
			$condition = array() ;
			$condition['class_id_in'] = $id ;
			/*
			 * 检测分类下是否有优惠券
			 */
			$list = array() ;
			$list = $coupon_class->getCouponClass(array('class_id_in'=>$condition['class_id_in']),'','join') ;

			$num = 0 ;
			if(!empty($list)){
			
				foreach($list as $val){
				
					$num += $val['num'] ;
					
				}
			
			}
			
			$num > 0 && showMessage(Language::get('coupon_class_del_error')) ;
			
			if($coupon_class->delCouponClass($condition)){
				showMessage(Language::get('coupon_del_success'));
			}
			showMessage(Language::get('coupon_del_fail'));
		
		}
		/*
		 * 得到分类列表
		 */
		$page = new Page();
		$page->setEachNum(8) ;
		$page->setStyle('admin') ;
		
		$model_coupon_class = Model('coupon_class') ;
		$class_list = $model_coupon_class->getCouponClass(array('order'=>'class_sort asc,class_id desc'),$page) ;
		
		Tpl::output('list', $class_list) ;
		Tpl::output('show_page',$page->show()) ;
		Tpl::showpage('coupon_class.list') ;
	
	}
	
	/*
	 * 优惠券分类
	 * 新增及编辑
	 */
	public function updateOp(){
		
		$lang	= Language::getLangContent();
		$coupon_class = Model('coupon_class') ;
		
		if($_POST['form_submit']=='ok'){	//更新保存操作
		
			$update = array() ;
			$update['class_name'] = trim($_POST['class_name']) ;
			$update['class_sort'] = intval($_POST['class_sort']) ;
			$update['class_show'] = $_POST['class_show'] ;
			/*
			 * 验证
			 */
			$validate = new Validate() ;
			$validate->validateparam = array(array('input'=>trim($_POST['class_name']),'require'=>true,'message'=>Language::get('coupon_class_name_null')),
										array('input'=>$_POST['class_sort'],'require'=>true,'validator'=>'Range','min'=>0,'max'=>255,'message'=>Language::get('coupon_class_sort_null'))
										) ;
			$error = $validate->validate() ;
			
			if($error){
				showMessage($error) ;
			}
			if(intval($_POST['class_id'])>0){	//更新
				$list = $coupon_class->getCouponClass(array('class_id'=>intval($_POST['class_id'])),'','join') ;
				if($_POST['class_show']==0 && $list[0]['num']>0){
					showMessage(Language::get('coupon_class_edit_error'));
				}
				$rs = $coupon_class->updateCouponClass($update,array('class_id'=>intval($_POST['class_id']))) ;
			
			}else{	//新增
				
				$rs = $coupon_class->addCouponClass($update) ;
				
			}
			
			$rs == true ? showMessage(Language::get('coupon_class_success'),'index.php?act=coupon_class') : showMessage(Language::get('coupon_class_fail')) ;
		}
		
		if(intval($_GET['class_id'])>0){	//编辑操作
			$class_detail = $coupon_class->getCouponClass(array('class_id'=>intval($_GET['class_id']))) ;
			if(is_array($class_detail)&&!empty($class_detail)){
				Tpl::output('class',$class_detail[0]) ;
				Tpl::output('type','edit') ;
				Tpl::showpage('coupon_class.detail') ;
			}else{
				showMessage(Language::get('coupon_class_null_error')) ;
				exit;
			}
		}
		/*
		 * 新增操作
		 */
		Tpl::output('type','add') ;
		Tpl::showpage('coupon_class.detail') ;
	}
	
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 验证是否有重复的名称
			 */
			case 'coupon_class_name':
				if(trim($_GET['class_name']) == trim($_GET['old_name'])){
					echo 'true';exit;
				} 
				$model_class = Model('coupon_class');
				$class_array = $model_class->getCouponClass(array('class_name'=>$_GET['class_name']));
				if (empty($class_array)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
		}
	}
}