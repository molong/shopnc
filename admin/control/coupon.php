<?php
/**
 * 优惠券管理
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class couponControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('coupon');
		switch ($_POST['submit_type']) {
			case 'del':
				$this->delOp();
				break ;
				exit;
			case 'recommend':
				$this->recommendOp();
				break;
//			case 'unrecommend':
//				$this->recommendOp();
//				break;
		}
	}
	/*
	 * 列出优惠券
	 */
	public function couponOp(){
		$this->listOp();
	}
	/*
	 * 列出优惠券
	 */
	public function listOp(){
		$lang	= Language::getLangContent();
		
		/*
		 * 得到搜索条件
		 */
		$search = array() ;
		if(trim($_GET['search_coupon_name'])!=''){
			
			$search['coupon_name_like'] = trim($_GET['search_coupon_name']) ;
			
		}
		if(trim($_GET['search_store_name'])!=''){
			
			$search['store_name'] = trim($_GET['search_store_name']) ;
			
		}
		if($_GET['time_from']!=''){
				
			$time = explode('-', $_GET['time_from']) ;
			$search['time_from'] = mktime(0,0,0,$time[1],$time[2],$time[0]) ;
					
		}
		if($_GET['time_to']!=''){
					
			$time = explode('-', $_GET['time_to']) ;
			$search['time_to'] = mktime(0,0,0,$time[1],$time[2],$time[0]) ;
				
		}
		if($_GET['time_to']!=''&&$_GET['time_from']!=''&&$search['time_from']>$search['time_to'] )
		{
			$_GET['time_from'] = $_GET['time_to'] = '' ;
			showMessage(Language::get('coupon_time_error')) ;
		}
		if($_GET['coupon_class']!=''){
			$search['coupon_class'] = $_GET['coupon_class'] ;
		}

		$model_coupon = Model('coupon');
		$model_coupon->update_coupon(array('coupon_state'=>'1','coupon_recommend'=>0),array('coupon_state'=>'2','coupon_novalid'=>true));//下架到期优惠券
		/**
		 * 创建分页对象
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$condition = array() ;
		$condition['coupon_allowstate'] = '1';
		$condition = array_merge($condition,$search) ;

		$list = $model_coupon->getCoupon($condition, $page, 'store') ;
		unset($condition) ;
		Tpl::output('search',$search) ;
		unset($search) ;
		
		/*
		 * 获得分类信息
		 */
		$model_class = Model('coupon_class') ;
		$class_list = array() ;	
		$class_list = $model_class->getCouponClass(array('order'=>'class_sort asc')) ;
		
		Tpl::output('class_list',$class_list) ;
		Tpl::output('list', $list) ;
		Tpl::output('show_page',$page->show());
		Tpl::showpage('coupon.list') ;
		
	}
	/*
	 * 待审核优惠券
	 */
	public function applyOp(){
		/**
		 * 创建分页对象
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$model_coupon = Model('coupon');
		if ($_POST['form_submit'] == 'ok'){
			$coupon_id = $_POST['coupon_id'];
			if(is_array($coupon_id) && !empty($coupon_id)) {
				$id	= "'".implode("','",$coupon_id)."'";
				$coupon_array = array();
				$coupon_array['coupon_allowstate'] = intval($_POST['coupon_allowstate']);
				$model_coupon->update_coupon($coupon_array,array('coupon_id_in'=>$id));
				
				// 自动发布动态
				if(intval($_POST['coupon_allowstate']) == 1){
					foreach ($coupon_id as $val){
						$this->storeAutoShare($val);
					}
				}
				showMessage(Language::get('coupon_update_success'),'index.php?act=coupon&op=apply');
			}
		}
		$condition = array();
		$condition['coupon_allowstate2'] = '1';//待审核和未通过的
		$list = $model_coupon->getCoupon($condition, $page, 'store') ;
		Tpl::output('list', $list) ;
		Tpl::output('show_page',$page->show());
		Tpl::showpage('coupon_apply.list') ;
	}
	/*
	 * 审核优惠券
	 */
	public function apply_editOp(){
		
		$model_coupon = Model('coupon');
		if ($_POST['form_submit'] == 'ok'){
			$coupon_id = intval($_POST['coupon_id']);
			if($coupon_id > 0) {
				$coupon_array = array();
				$coupon_array['coupon_allowstate'] = intval($_POST['coupon_allowstate']);
				$coupon_array['coupon_state']		= intval($_POST['coupon_state']);
				$coupon_array['coupon_recommend'] = intval($_POST['coupon_recommend']);
				$coupon_array['coupon_allowremark'] = $_POST['coupon_allowremark'];
				$model_coupon->update_coupon($coupon_array,array('coupon_id'=>$coupon_id));
				
				// 自动发布动态
				if(intval($_POST['coupon_allowstate']) == 1){
					$this->storeAutoShare($coupon_id);
				}
				showMessage(Language::get('coupon_update_success'),'index.php?act=coupon&op=apply');
			}
		}
		$coupon_id = intval($_GET['coupon_id']);
		$model_coupon = Model('coupon') ;
		$coupon_detail = $model_coupon->getOneById($coupon_id) ;
		/*
		 * 得到店铺 
		 */
		$model_store = Model('store');
		$store = $model_store->getStoreList(array('store_id'=>trim($coupon_detail['store_id']))) ;
		$coupon_detail['store_name'] = $store[0]['store_name'] ;
		/*
		 * 取得优惠券分类
		 */
		$model_coupon_class = Model('coupon_class') ;
		$coupon_class = $model_coupon_class->getCouponClass(array('class_id'=>$coupon_detail['coupon_class_id'])) ;
		Tpl::output('class_name', $coupon_class[0]['class_name']) ;
		Tpl::output('coupon',$coupon_detail) ;
		Tpl::showpage('coupon_apply.edit') ;
	}
	/*
	 * 删除优惠券
	 */
	public function delOp(){
		$lang	= Language::getLangContent();
		$id	= '';
		if(empty($_REQUEST['coupon_id'])){
			showMessage(Language::get('coupon_choose'));
		}
		if(is_array($_POST['coupon_id'])){
			$id	= "'".implode("','",$_POST['coupon_id'])."'";
		}else{
			$id	= intval($_GET['coupon_id']);
		}
		$coupon	= Model('coupon');
		$condition = array() ;
		$condition['coupon_state'] = '1';//下架的
		$condition['coupon_id_in'] = $id ;
			if($coupon->del_coupon($condition)){
				showMessage(Language::get('coupon_del_success'));
			}
		showMessage(Language::get('coupon_del_fail'));
	}
	/*
	 * 编辑优惠券
	 */
	public function editOp(){
		$id = '';
		if(empty($_REQUEST['coupon_id'])){
			showMessage(Language::get('coupon_choose'));
		}
		if(!chksubmit()){
			$id = $_REQUEST['coupon_id'] ;
			$coupon = Model('coupon') ;
			$coupon_detail = $coupon->getOneById($id) ;
			/*
			 * 得到店铺 
			 */
			$model_store = Model('store') ;
			$store = $model_store->getStoreList(array('store_id'=>trim($coupon_detail['store_id']))) ;
			$coupon_detail['store_name'] = $store[0]['store_name'] ;
			/*
			 * 取得优惠券分类
			 */
			$model_coupon_class = Model('coupon_class') ;
			$coupon_class = $model_coupon_class->getCouponClass(array('class_id'=>$coupon_detail['coupon_class_id'])) ;
			Tpl::output('class_name', $coupon_class[0]['class_name']) ;
			Tpl::output('coupon',$coupon_detail) ;
			Tpl::showpage('coupon.edit') ;
			exit ;
		}
		/**
		 * 保存
		 */
		$input	= array();
		$input['coupon_state'] = intval(trim($_POST['coupon_state']));
		if ($input['coupon_state'] == 1){
			$input['coupon_recommend'] = 0;
		}else{
			$input['coupon_recommend'] = trim($_POST['coupon_recommend']) ;
		}
		$coupon	= Model('coupon');
		$result	= $coupon->update_coupon($input,array('coupon_id'=>intval($_POST['coupon_id'])));
		if($result){
			showMessage(Language::get('coupon_update_success'),'index.php?act=coupon&op=list');
		}else{
			showMessage(Language::get('coupon_update_fail'));
		}
				
	}
	/*
	 * 模板AJAX检测函数
	 */
	public function ajaxOp(){
		$branch = trim($_GET['branch']) ;
		switch ($branch) {
			case 'check_store_name':
				$model_store = Model('store') ;
				$store = $model_store->getStoreList(array('store_name'=>trim($_GET['store_name']))) ;
				if(is_array($store)&&!empty($store)){
					echo 'true';exit;
				}else{
					echo 'false';exit;
				}
				break ;
		}
	}
	/**
	 * 推荐优惠券至首页
	 */
	public function recommendOp(){
		if (!is_array($_POST['coupon_id']) || count($_POST['coupon_id'])<=0){
			showMessage(Language::get('coupon_recommend_chooseerror'),'index.php?act=coupon&op=coupon');
		}
		$up_arr = array();
		switch ($_POST['submit_type']) {
			case 'recommend':
				$up_arr['coupon_recommend'] = 1;
				break;
//			case 'unrecommend':
//				$up_arr['coupon_recommend'] = 0;
//				break;
		}
		$coupon_model = Model('coupon');
		$condition_arr = array();
		$condition_arr['coupon_id_in'] = "'".implode("','",$_POST['coupon_id'])."'";
		$result = $coupon_model->update_coupon($up_arr,array('coupon_id_in'=>$condition_arr['coupon_id_in'],'coupon_state'=>2));
		if ($result){
			showMessage(Language::get('coupon_recommend_success'),'index.php?act=coupon&op=coupon');
		}else{
			showMessage(Language::get('coupon_recommend_fail'),'index.php?act=coupon&op=coupon');
		}
	}
	
	/**
	 * 自动发布动态
	 */
	private function storeAutoShare($coupon_id){
		/**
		 * 实例化模型
		 */
		$model = Model();
		$coupon_info = $model->table('coupon')->find($coupon_id);
		$data = array();
		$data['coupon_id']			= $coupon_info['coupon_id'];
		$data['coupon_title']		= $coupon_info['coupon_title'];
		$data['coupon_pic']			= $coupon_info['coupon_pic'];
		$data['coupon_start_date']	= $coupon_info['coupon_start_date'];
		$data['coupon_end_date']	= $coupon_info['coupon_end_date'];
		$data['coupon_price']		= $coupon_info['coupon_price'];
		$data['store_id']			= $coupon_info['store_id'];
		
		$auto_setting = $model->table('sns_s_autosetting')->find($coupon_info['store_id']);
		$auto_sign = false; // 自动发布开启标志
		if($auto_setting['sauto_coupon'] == 1){
			$auto_sign = true;
			if( CHARSET == 'GBK') {
				foreach ((array)$data as $k=>$v){
					$data[$k] = Language::getUTF8($v);
				}
			}
			$goodsdata = addslashes(json_encode($data));
			if ($auto_setting['sauto_coupontitle'] != ''){
				$title = $auto_setting['sauto_coupontitle'];
			}else{
				$auto_title = 'nc_store_auto_share_coupon'.rand(1, 5);
				$title = Language::get($auto_title);
			}
		}else{
			return false;
		}
		if($auto_sign){
			$store_info = $model->table('store')->find($coupon_info['store_id']);
			// 插入数据
			$stracelog_array = array();
			$stracelog_array['strace_storeid']	= $store_info['store_id'];
			$stracelog_array['strace_storename']= $store_info['store_name'];
			$stracelog_array['strace_storelogo']= empty($store_info['store_logo'])?'':$store_info['store_logo'];
			$stracelog_array['strace_title']	= $title;
			$stracelog_array['strace_content']	= '';
			$stracelog_array['strace_time']		= time();
			$stracelog_array['strace_type']		= 4;
			$stracelog_array['strace_goodsdata']= $goodsdata;
			$model->table('sns_s_tracelog')->insert($stracelog_array);
			return true;
		}else{
			return false;
		}
	}
}
?>