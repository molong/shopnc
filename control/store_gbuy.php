<?php
/**
 * 金币购买
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

class store_gbuyControl extends BaseMemberStoreControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_store_gbuy');
		
		$gold_isuse	= $GLOBALS['setting_config']['gold_isuse'];
		if($gold_isuse != '1') {
			showMessage(Language::get('store_gbuy_gold_isuse'),'index.php?act=store','html','error');
		}
	}
	/**
	 * 金币购买支付
	 *
	 */
	public function paymentOp(){
		/**
		 * 实例化金币购买模型
		 */
		$model_gbuy	= Model('gold_buy');
		/**
		 * 支付方式列表
		 */
		$payment_list = $this->getPayment(1);//可用的支付方式
		/**
		 * 保存信息
		 */
		if (chksubmit()){
			$gbuy_id = intval($_POST["gbuy_id"]);
			$payment_code = $_POST["gbuy_check_type"];
			$condition = array();
			$condition['gbuy_id'] = $gbuy_id;
			$condition['gbuy_ispay'] = '0';
			$condition['gbuy_mid'] = $_SESSION['member_id'];
			$gold_buy = array();
			$gold_buy['gbuy_check_type'] = $payment_code;
			$gold_buy['gbuy_user_remark'] = $_POST["gbuy_user_remark"];
			$state = $model_gbuy->update($condition,$gold_buy);
			if($payment_code != 'offline' && $state) {
				switch ($payment_code){
					case 'predeposit':
						//跳转到支付接口页面预存款支付
						@header("Location: index.php?act=gold_payment&op=predeposit_pay&gbuy_id=$gbuy_id");
						exit;
						break;
					default://进入在线支付方式的处理
						break;
				}
				//使用在线支付时跳转到对应的网站
				$payment_info = array();
				foreach ($payment_list as $k => $v){//选出当前使用的支付方式
					if ($payment_code == $v['payment_code']){
						$payment_info = $v;
						$payment_info['payment_config'] = unserialize($v['payment_config']);
						break;
					}
				}
				$gbuy_list = $model_gbuy->getList($condition);//取支付金额
				$gold_buy = $gbuy_list[0];
				$order_info = array();
				$order_info['order_sn'] = $gbuy_id;
				$order_info['order_amount'] = $gold_buy['gbuy_price'];
				$order_info['modeltype']		= '1';//表示是金币支付功能调用支付接口
				/**
				 * 建立接口模型的实例对象
				 * 获得支付的url或者表单 数据
				 */
				$inc_file = BasePath.DS.'api'.DS.'gold_payment'.DS.$payment_code.DS.$payment_code.'.php';
				
				require_once($inc_file);
				$payment_api = new $payment_code($payment_info,$order_info);
				if($payment_code == 'chinabank') {
					$payment_api->submit();
					exit;
				} else {
					@header("Location: ".$payment_api->get_payurl());
					exit;
				}
			} else {
				showMessage(Language::get('store_gbuy_edit_success'),'index.php?act=store_gbuy');
			}
		}
		$gbuy_id = intval($_GET["gbuy_id"]);
		if($gbuy_id > 0) {
			$condition = array();
			$condition['gbuy_id'] = $gbuy_id;
			$condition['gbuy_ispay'] = '0';
			$condition['gbuy_mid'] = $_SESSION['member_id'];
			$gbuy_list = $model_gbuy->getList($condition);
			Tpl::output('gold_buy',$gbuy_list[0]);
			//查询会员信息
			$member_model = Model('member');
			$member_info = $member_model->infoMember(array('member_id'=> $_SESSION['member_id']),'member_id,available_predeposit');
			Tpl::output('member_info',$member_info);
		}
		Tpl::output('payment_list',$payment_list);
		Tpl::showpage('store_gbuy_payment','null_layout');//跳转到选择支付页
	}
	/**
	 * 金币购买
	 *
	 */
	public function addOp(){
		/**
		 * 实例化金币购买模型
		 */
		$model_gbuy	= Model('gold_buy');
		
		$gold_rmbratio	= $GLOBALS['setting_config']['gold_rmbratio'];//兑换比例:人民币1元兑换n个金币
		/**
		 * 保存信息
		 */
		if (chksubmit()){
			$gbuy_price = intval($_POST["gbuy_price"]);
			$gbuy_num = $gold_rmbratio*$gbuy_price;
			$gold_buy = array();
			$gold_buy['gbuy_num'] = $gbuy_num;//购买金币数量
			$gold_buy['gbuy_price'] = $gbuy_price;//购买所花费的金额
			$gold_buy['gbuy_addtime'] = time();	
			$gold_buy['gbuy_mid'] = $_SESSION['member_id'];
			$gold_buy['gbuy_membername'] = $_SESSION['member_name'];
			$gold_buy['gbuy_storeid'] = $_SESSION['store_id'];
			$gold_buy['gbuy_storename'] = $_SESSION['store_name'];
			$gold_buy['gbuy_ispay'] = '0';//未支付状态
			$gold_buy['gbuy_check_type'] = '';//默认为空
			$state = $model_gbuy->add($gold_buy);
			if($state) {
				showDialog(Language::get('nc_common_save_succ'),'index.php?act=store_gbuy','succ',empty($_GET['inajax'])?'':'CUR_DIALOG.close();');
			} else {
				showDialog(Language::get('nc_common_save_fail'));//添加购买金币失败
			}
		}
		Tpl::output('gold_rmbratio',$gold_rmbratio);
		Tpl::showpage('store_gbuy_add','null_layout');
	}
	/**
	 * 删除金币购买记录
	 *
	 */
	public function delOp(){
		$gbuy_id = intval($_GET["gbuy_id"]);
		if($gbuy_id > 0) {
			/**
			 * 实例化金币购买模型
			 */
			$model_gbuy	= Model('gold_buy');
			$condition = array();
			$condition['gbuy_mid'] = $_SESSION['member_id'];
			$condition['gbuy_id'] = $gbuy_id;
			$condition['gbuy_ispay'] = '0';//未支付状态(支付完成的记录不能删除)
			$model_gbuy->del($condition);
		}
		showDialog(Language::get('nc_common_del_succ'),'index.php?act=store_gbuy','succ');
	}
	/**
	 * 金币购买记录列表页
	 *
	 */
	public function indexOp(){
		//查询会员现有金币数
		$member_model = Model('member');
		$member_array = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));
		/**
		 * 实例化金币购买模型
		 */
		$model_gbuy	= Model('gold_buy');
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$payment_array = $this->getPayment_name();//支付方式列表
		/**
		 * 查询购买记录
		 */
		$condition = array();
		$condition['gbuy_mid'] = $_SESSION['member_id'];
		
		if(trim($_GET['add_time_from']) != ''){
			$add_time_from	= strtotime(trim($_GET['add_time_from']));
			if($add_time_from !== false){
				$condition['add_time_from']	= $add_time_from;
			}
		}
		if(trim($_GET['add_time_to']) != ''){
			$add_time_to	= strtotime(trim($_GET['add_time_to']));
			if($add_time_to !== false){
				$condition['add_time_to']	= $add_time_to+86400;
			}
		}
		$gbuy_list = $model_gbuy->getList($condition,$page);
		Tpl::output('last_num',count($gbuy_list)-1);
		Tpl::output('member_goldnum',$member_array['member_goldnum']);
		Tpl::output('gbuy_list',$gbuy_list);
		Tpl::output('payment_array',$payment_array);
		Tpl::output('show_page',$page->show());
		self::profile_menu('gold_buy','gold_buy');
		Tpl::output('menu_sign','store_gbuy');
		Tpl::output('menu_sign_url','index.php?act=store_gbuy');
		Tpl::output('menu_sign1','gold_buy');
		Tpl::showpage('store_gbuy');
	}
	/**
	 * 金币日志列表页
	 *
	 */
	public function gold_logOp(){
		$condition	= array();
		$condition['glog_memberid'] = $_SESSION['member_id'];
		if(trim($_GET['add_time_from']) != ''){
			$add_time_from	= strtotime(trim($_GET['add_time_from']));
			if($add_time_from !== false){
				$condition['add_time_from']	= $add_time_from;
			}
		}
		if(trim($_GET['add_time_to']) != ''){
			$add_time_to	= strtotime(trim($_GET['add_time_to']));
			if($add_time_to !== false){
				$condition['add_time_to']	= $add_time_to+86400;
			}
		}
		if(trim($_GET['method']) != ''){
			$condition['glog_method']	= $_GET['method'];
		}
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$model_log	= Model('gold_log');
		$glog_list	= $model_log->getList($condition,$page);
		
		Tpl::output('last_num',count($glog_list)-1);
		Tpl::output('glog_list',$glog_list);
		Tpl::output('show_page',$page->show());
		Tpl::output('search',$_GET);
		self::profile_menu('gold_buy','gold_log');
		Tpl::output('menu_sign','store_gbuy');
		Tpl::output('menu_sign_url','index.php?act=store_gbuy');
		Tpl::output('menu_sign1','gold_log');
		Tpl::showpage('gold_log');
	}
	/**
	 * 得到支付方式列表
	 *
	 * @return
	 */
	private function getPayment($payment_state = '') {
		/**
		 * 实例化支付方式模型
		 */
		$model_payment = Model('gold_payment');
		/**
		 * 支付方式列表
		 */
		$condition = array();
		if($payment_state > 0) $condition['payment_state'] = '1';//可用的支付方式
		$payment_list = $model_payment->getList($condition);

		return $payment_list;
	}
	/**
	 * 得到支付方式名称数组
	 *
	 * @return
	 */
	private function getPayment_name() {
		$payment_list = $this->getPayment();//支付方式列表
		$payment_array = array();
		foreach ($payment_list as $k => $v){
			$payment_code = $v['payment_code'];
			$payment_array[$payment_code] = $v['payment_name'];
		}
		return $payment_array;
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array	= array();
		switch ($menu_type) {
			case 'gold_buy':
				$menu_array	= array(
					1=>array('menu_key'=>'gold_buy','menu_name'=>Language::get('nc_member_path_gold_buy'),	'menu_url'=>'index.php?act=store_gbuy'),
					2=>array('menu_key'=>'gold_log','menu_name'=>Language::get('nc_member_path_gold_log'),	'menu_url'=>'index.php?act=store_gbuy&op=gold_log')
				);
				break;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
