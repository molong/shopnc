<?php
/**
 * 控制台
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

class dashboardControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('dashboard');
	}
	/**
	 * 欢迎页面
	 */
	public function welcomeOp(){
		/**
		 * 管理员信息
		 */
		$model_admin = Model('admin');
		$tmp = $this->getAdminInfo();
		$condition['admin_id'] = $tmp['id'];
		$admin_info = $model_admin->infoAdmin($condition);
		$admin_info['admin_login_time'] = date('Y-m-d H:i:s',($admin_info['admin_login_time'] == '' ? time() : $admin_info['admin_login_time']));
		/**
		 * 系统信息
		 */
		require(BasePath.DS.'config.ini.php');
		if(!empty($config) && is_array($config)){
			$version = $config['version'];
			$setup_date = $config['setup_date'];
		}
		$statistics['os'] = PHP_OS;
		$statistics['web_server'] = $_SERVER['SERVER_SOFTWARE'];
		$statistics['php_version'] = PHP_VERSION;
		$statistics['sql_version'] = Db::getServerInfo();
		$statistics['shop_version'] = $version;
		$statistics['setup_date'] = substr($setup_date,0,10);
		Tpl::output('statistics',$statistics);
		Tpl::output('admin_info',$admin_info);
		Tpl::showpage('welcome');
	}
	
	/**
	 * 关于我们
	 */
	public function aboutusOp(){
		
		Tpl::showpage('aboutus');
	}
	
	/**
	 * 统计
	 */
	public function statisticsOp(){
		$statistics = array();
		/**
		 * 一周动态
		 */
		/**
		 * 本周开始时间点
		 */
		$tmp_time = mktime(0,0,0,date('m'),date('d'),date('Y'))-(date('w')==0?7:date('w')-1)*24*60*60;
		/**
		 * 新增会员数
		 */
		$param = array();
		$param['table'] = 'member';
		$param['where'] = "member_time >= '". $tmp_time ."' ";
		$statistics['week_add_member'] = $this->getCount($param);
		unset($param,$result);
		/**
		 * 新增商品数
		 */
		$param = array();
		$param['table'] = 'goods';
		$param['where'] = "goods_add_time >= '". $tmp_time ."' ";
		$statistics['week_add_product'] = $this->getCount($param);
		unset($param,$result);
		/**
		 * 新增店铺数
		 */
		$param = array();
		$param['table'] = 'store';
		$param['where'] = "store_time >= '". $tmp_time ."'";
		$statistics['week_add_store'] = $this->getCount($param);
		unset($param,$result);
		/**
		 * 店铺申请数
		 */
		$param = array();
		$param['table'] = 'store';
		$param['where'] = "store_time >= '". $tmp_time ."' and store_state = 2";
		$statistics['week_add_audit_store'] = $this->getCount($param);
		unset($param,$result);
		/**
		 * 新增订单数
		 */
		 $param = array();
		 $param['table'] = 'order';
		 $param['where'] = "add_time >= '". $tmp_time ."'";
		 $statistics['week_add_order_num'] = $this->getCount($param);
		unset($tmp_time);
		/**
		 * 统计信息
		 */
		/**
		 * 会员总数
		 */
		$param = array();
		$param['table'] = 'member';
		$statistics['member'] = $this->getCount($param);
		unset($param,$result);
		/**
		 * 商品总数
		 */
		$param = array();
		$param['table'] = 'goods';
		$statistics['goods'] = $this->getCount($param);
		unset($param,$result);
		/**
		 * 订单总数
		 */
		$param = array();
		$param['table'] = 'order';
		$statistics['order'] = $this->getCount($param);
		unset($param,$result);
		
		/**
		 * 订单总金额
		 */
		$param = array();
		$param['table'] = 'order';
		$param['field'] = 'sum(order_amount)';
		$result = Db::select($param);
		$statistics['order_amount'] = $result[0]['sum(order_amount)'] ? $result[0]['sum(order_amount)'] : 0 ;

		/**
		 * 店铺总数
		 */
		$param = array();
		$param['table'] = 'store';
		$statistics['store'] = $this->getCount($param);
		unset($param,$result);
		/**
		 * 申请总数
		 */
		$param = array();
		$param['table'] = 'store';
		$param['where'] = "store_state = 2";
		$statistics['audit_store'] = $this->getCount($param);
		unset($param,$result);
		echo json_encode($statistics);
		exit;
	}
	/**
	 * 查询数量
	 * 
	 * @param	array $condition_array
	 * @return	int
	 */
	public function getCount($param_array){
		$param = array();
		$param['field'] = 'count(*) as count';
		$param['table'] = $param_array['table'];
		$param['where']	= $param_array['where'];
		$result = Db::select($param);
		return $result[0]['count'];
	}
	
}