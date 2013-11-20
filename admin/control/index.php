<?php
/**
 * 默认展示页面
 *
 * 默认展示页面
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class indexControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('index');
	}
	public function indexOp(){
		/**
		 * 模板输出
		 */
		Tpl::output('admin_info',$this->getAdminInfo());
		/**
		 * 输出菜单
		 */
		$this->getNav('',$top_nav,$left_nav,$map_nav);
		Tpl::output('top_nav',$top_nav);
		Tpl::output('left_nav',$left_nav);
		Tpl::output('map_nav',$map_nav);

		/**
		 * 输出管理地图
		 */
		if(is_file(BasePath.DS.ProjectName.DS.'include'.DS.'menu.php')){
			 require(BasePath.DS.ProjectName.DS.'include'.DS.'menu.php');
		}
		
		Tpl::showpage('index','index_layout');
	}

	/**
	 * 退出
	 */
	public function logoutOp(){
		setNcCookie('sys_key','',-1);
		@header("Location: index.php");
		exit;
	}
	/**
	 * 修改密码
	 */
	public function modifypwOp(){
		if (chksubmit()){
			if (trim($_POST['new_pw']) !== trim($_POST['new_pw2'])){
				//showMessage('两次输入的密码不一致，请重新输入');				
				showMessage(Language::get('index_modifypw_repeat_error'));
			}
			$admininfo = $this->getAdminInfo();
			//查询管理员信息
			$admin_model = Model('admin');
			$admininfo = $admin_model->getOneAdmin($admininfo['id']);
			if (!is_array($admininfo) || count($admininfo)<= 0){
				showMessage(Language::get('index_modifypw_admin_error'));
			}
			//旧密码是否正确
			if ($admininfo['admin_password'] != md5(trim($_POST['old_pw']))){
				showMessage(Language::get('index_modifypw_oldpw_error'));
			}
			$new_pw = md5(trim($_POST['new_pw']));
			$result = $admin_model->updateAdmin(array('admin_password'=>$new_pw,'admin_id'=>$admininfo['admin_id']));
			if ($result){
				showMessage(Language::get('index_modifypw_success'));
			}else{
				showMessage(Language::get('index_modifypw_fail'));
			}
		}else{
			Language::read('admin');
			Tpl::showpage('admin.modifypw');
		}
	}
	/**
	 * 商品到期自动上架，更新商品开始结束时间
	 */
	public function goods_commodity_scanningOp(){		
		$model = Model();
		// 上架
		$model = Model();
		$condition = array();
		$condition['goods_state'] = 0;
		$condition['goods_starttime'] = array('lt',TIMESTAMP);
		$condition['goods_endtime'] = array('gt',TIMESTAMP);
		$model->table('goods')->where($condition)->attr('LOW_PRIORITY')->update(array('goods_show'=>1));
		// 更新商品开始结束时间
		$data['goods_starttime'] = TIMESTAMP;
		$data['goods_endtime'] =array('exp',C('product_indate')*86400+TIMESTAMP);	
		$model->table('goods')->where(array('goods_show'=>1,'goods_endtime' => array('lt',TIMESTAMP)))->attr('LOW_PRIORITY')->update($data);
	}
	/**
	 * 到期店铺自动关闭
	 */
	public function shops_shut_downOp(){
		$model_store	= Model('store');
		$model_goods	= Model('goods');
		
		$store_list	= $model_store->getStoreList(array('lt_store_end_time'=>time(),'store_state'=>'1','field'=>'store_id,member_id'));
		if(!empty($store_list) && is_array($store_list)){
			foreach ($store_list as $val){
				$model_goods->updateGoodsStoreStateByStoreId($val['store_id'],'close');
				$model_store->shoreUpdate(array('store_state'=>'0','store_id'=>$val['store_id']));
				//向店主发送通知消息
				$msg_code = 'msg_toseller_store_expired_closed_notify';
				//内容
				$param = array();
				$this->send_notice($val['member_id'],$msg_code,$param);
			}
		}
	}
}
