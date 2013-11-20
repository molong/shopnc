<?php
/**
 * 前台control父类,店铺control父类,会员control父类
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

/********************************** 前台control父类 **********************************************/

class BaseHomeControl{
	/**
	 * 构造函数
	 */
	public function __construct(){
		/**
		 * 短消息检查
		 */		
		$this->checkMessage();
		/**
		 * 购物车商品种数查询
		 */
		$this->queryCart();
		/**
		 * 读取通用、布局的语言包
		 */
		Language::read('common,home_layout');
		/**
		 * 设置模板文件夹路径
		 */
		Tpl::setDir('home');
		/**
		 * 获取导航
		 */
		Tpl::output('nav_list',($nav = F('nav'))? $nav :H('nav',true,'file'));

		/**
		 * 设置布局文件内容
		 */
		Tpl::setLayout('home_layout');
		/**
		 * 热门搜索
		 */
		Tpl::output('hot_search',@explode(',',C('hot_search')));
		/**
		 * 商品分类
		 */
		Tpl::output('show_goods_class',($nav = F('goods_class'))? $nav :H('goods_class',true,'file'));
		/**
		 * 转码
		 */
		if ($_GET['column'] && strtoupper(CHARSET) == 'GBK'){
			$_GET = Language::getGBK($_GET);
		}
		/**
		 * 系统状态检查
		 */
		if(!C('site_status')) halt(C('closed_reason'));
	}
	/**
	 * 系统通知发送函数
	 * 
	 * @param int $receiver_id 接受人编号
	 * @param string $tpl_code 模板标识码
	 * @param array $param 内容数组
	 * @param bool $flag 是否遵从系统设置
	 * @return bool
	 */
	public function send_notice($receiver_id,$tpl_code,$param,$flag = true){
		/**
		 * 获取通知内容模板
		 */
		$mail_tpl_model	= Model('mail_templates');
		$mail_tpl	= $mail_tpl_model->getOneTemplates($tpl_code);
		if(empty($mail_tpl) || $mail_tpl['mail_switch'] == 0)return false;
		/**
		 * 获取接收人信息
		 */
		$member_model	= Model('member');
		$receiver	= $member_model->infoMember(array('member_id'=>$receiver_id));
		if(empty($receiver))return false;

		/**
		 * 为通知模板的主题与内容中变量赋值
		 */
		$subject	= ncReplaceText($mail_tpl['title'],$param);
		$message	= ncReplaceText($mail_tpl['content'],$param);
		/**
		 * 根据模板里面确定的通知类型采用对应模式发送通知
		 */
		$result	= false;
		switch($mail_tpl['type']){
			case '0':
				$email	= new Email();
				$result	= true;
				if($flag and $GLOBALS['setting_config']['email_enabled'] == '1' or $flag == false){
					$result	= $email->send_sys_email($receiver['member_email'],$subject,$message);
				}
				break;
			case '1':
				$model_message = Model('message');
				$param = array(
				'member_id'=>$receiver_id,
				'to_member_name'=>$receiver['member_name'],
				'msg_content'=>$message,
				'message_type'=>1//表示系统消息
				);
				$result = $model_message->saveMessage($param);
				break;
		}
		return $result;
	}
	/**
	 * 检查短消息数量
	 *
	 * @param 
	 * @return 
	 */
	private function checkMessage() {
		if($_SESSION['member_id'] == '') return ;
		//判断cookie是否存在
		$cookie_name = 'msgnewnum'.$_SESSION['member_id'];
		if (cookie($cookie_name) != null && intval(cookie($cookie_name)) >=0){
			$countnum = intval(cookie($cookie_name));
		}else {
			$message_model = Model('message');
			$countnum = $message_model->countNewMessage($_SESSION['member_id']);
			setNcCookie($cookie_name,"$countnum",2*3600);//保存1天
		}
		Tpl::output('message_num',$countnum);
	}
	/**
	 *  查询购物车商品种类
	 *
	 * @param 
	 * @return 
	 */
	private function queryCart() {
		if (cookie('goodsnum') != null && intval(cookie('goodsnum')) >=0){
			$goodsnum = intval(cookie('goodsnum'));
		}else {
			if (cookie('cart') != ''){
				$cart_str = cookie('cart');
				if (get_magic_quotes_gpc()) $cart_str = stripslashes($cart_str);//去除斜杠
				$cookie_goods = unserialize($cart_str);
				$goodsnum = count($cookie_goods);
			}elseif ($_SESSION['member_id'] != ''){
				$goodsnum = Model()->table('cart')->where(array('member_id'=>$_SESSION['member_id']))->count();
			}else{
				$goodsnum = 0;
			}
		}
		setNcCookie('goodsnum',$goodsnum,2*3600);//保存1天
		Tpl::output('goods_num',$goodsnum);
	}
}

/********************************** 会员control父类 **********************************************/

class BaseMemberControl{
	public function __construct(){
		/**
		 * 系统状态检查
		 */	
		if($GLOBALS['setting_config']['site_status'] == '0') {
			showMessage($GLOBALS['setting_config']['closed_reason']);
			exit();
		}
		/**
		 * 读取语言包
		 */
		Language::read('common,member_layout');
		/**
		 * 转码
		 */
		if ($_GET['column'] && strtoupper(CHARSET) == 'GBK'){
			$_GET = Language::getGBK($_GET);
		}
		/**
		 * 会员验证
		 */
		$this->checkLogin();
		/**
		 * 短消息检查
		 */		
		$this->checkMessage();
		/**
		 * 购物车商品种数查询
		 */
		$this->queryCart();
		/**
		 * 设置模板文件夹路径
		 */
		Tpl::setDir('member');
		/**
		 * 设置布局文件内容
		 */
		Tpl::setLayout('member_layout');
		Tpl::output('header_menu_sign','setting');//默认选中顶部“设置”菜单
		/**
		 * 获取导航
		 */
		Tpl::output('nav_list',($nav = F('nav')) ? $nav : H('nav',true,'file'));
		/**
		 * 自动更新订单，执行一次
		 */		
		if(empty($_SESSION['order_update_time'])) $this->updateOrder();
	}
	/**
	 * 自动更新订单
	 *
	 * @param 
	 * @return 
	 */
	private function updateOrder($update_all = 0){
		if (empty($_SESSION['order_update_time']) || $update_all == 1) {//登录后未更新或者在其它页面强制更新时执行
			$model_trade	= Model('trade');
			$model_trade->updateOrderPay($_SESSION['member_id']);//更新超期未处理订单
			$model_trade->updateRefund($_SESSION['member_id']);//更新超期未处理退款
			$_SESSION['order_update_time'] = time();//记录更新时间
		}
	}
	/**
	 * 系统通知发送函数
	 * 
	 * @param int $receiver_id 接受人编号
	 * @param string $tpl_code 模板标识码
	 * @param array $param 内容数组
	 * @param bool $flag 是否遵从系统设置
	 * @return bool
	 */
	public function send_notice($receiver_id,$tpl_code,$param,$flag = true){
		/**
		 * 获取通知内容模板
		 */
		$mail_tpl_model	= Model('mail_templates');
		$mail_tpl	= $mail_tpl_model->getOneTemplates($tpl_code);
		if(empty($mail_tpl) || $mail_tpl['mail_switch'] == 0)return false;
		
		/**
		 * 获取接收人信息
		 */
		$member_model	= Model('member');
		$receiver	= $member_model->infoMember(array('member_id'=>$receiver_id));
		if(empty($receiver))return false;
		
		/**
		 * 为通知模板的主题与内容中变量赋值
		 */
		$subject	= ncReplaceText($mail_tpl['title'],$param);
		$message	= ncReplaceText($mail_tpl['content'],$param);
		/**
		 * 根据模板里面确定的通知类型采用对应模式发送通知
		 */
		$result	= false;
		switch($mail_tpl['type']){
			case '0':
				$email	= new Email();
				$result	= true;
				if($flag and $GLOBALS['setting_config']['email_enabled'] == '1' or $flag == false){
					$result	= $email->send_sys_email($receiver['member_email'],$subject,$message);
				}
				break;
			case '1':
				$model_message = Model('message');
				$param = array(
					'member_id'=>$receiver_id,
					'to_member_name'=>$receiver['member_name'],
					'msg_content'=>$message,
					'message_type'=>1//表示系统消息
				);
				$result = $model_message->saveMessage($param);
				break;
		}
		return $result;
	}
	/**
	 * 验证会员是否登录
	 *
	 * @param 
	 * @return 
	 */
	private function checkLogin(){
		if ($_SESSION['is_login'] !== '1'){
			if (trim($_GET['op']) == 'favoritesgoods' || trim($_GET['op']) == 'favoritesstore'){
				$lang = Language::getLangContent('UTF-8');
				echo json_encode(array('done'=>false,'msg'=>$lang['no_login']));
				die;
			}
			$ref_url = request_uri();
			if ($_GET['inajax']){
				showDialog('','','js',"login_dialog();",200);
			}else {
				@header("location: index.php?act=login&ref_url=".urlencode($ref_url));
			}
			exit;
		}
	}
	/**
	 * 检查短消息数量
	 *
	 * @param 
	 * @return 
	 */
	private function checkMessage() {
		if($_SESSION['member_id'] == '') return ;
		//判断cookie是否存在
		$cookie_name = 'msgnewnum'.$_SESSION['member_id'];
		if (cookie($cookie_name) != null && intval(cookie($cookie_name)) >=0){
			$countnum = intval(cookie($cookie_name));
		}else {
			$message_model = Model('message');
			$countnum = $message_model->countNewMessage($_SESSION['member_id']);
			setNcCookie($cookie_name,"$countnum",2*3600);//保存2小时
		}
		Tpl::output('message_num',$countnum);
	}
	/**
	 * 检查店铺名称是否存在
	 *
	 * @param 
	 * @return 
	 */
	public function checknameinner() {
		/**
		 * 实例化卖家模型
		 */
		$model_store	= Model('store');

		$store_name	= trim($_GET['store_name']);
		$store_info	= $model_store->shopStore(array('store_name'=>$store_name));
		if($store_info['store_name'] != ''&&$store_info['member_id'] != $_SESSION['member_id']) {			
			return false;
		} else {			
			return true;
		}
	}
	/**
	 * 买家的左侧上部的头像和订单数量
	 *
	 * @param 
	 * @return 
	 */
	public function get_member_info() {		
		//生成缓存的键值
		$hash_key = $_SESSION['member_id'];
		//写入缓存的数据
		$cachekey_arr = array('member_name','store_id','member_avatar','member_qq','member_email','member_ww','member_goldnum','member_points',
							'available_predeposit','member_snsvisitnum','credit_arr','order_nopay','order_noreceiving','order_noeval','fan_count');
		//先查找$hash_key缓存
//		if ($_cache = rcache($hash_key,'member')){
		if (false){
			foreach ($_cache as $k=>$v){
				$member_info[$k] = $v;
			}
		} else {
			$model = Model('my_order');
			$member_info = $model->table('member')->where(array('member_id'=>$_SESSION['member_id']))->find();
			$member_info['credit_arr'] = getCreditArr(intval($member_info['member_credit']));//信用度
			$member_info['order_nopay'] = $model->myOrderCount(array('buyer_id'=>"{$_SESSION['member_id']}",'order_state' => 'order_pay'));//待付款
			$member_info['order_noreceiving'] = $model->myOrderCount(array('buyer_id'=>"{$_SESSION['member_id']}",'order_state' => 'order_shipping'));//待确认收货
			$member_info['order_noeval'] = $model->myOrderCount(array('buyer_id'=>"{$_SESSION['member_id']}",'order_evalbuyer_able' => '1'));//待评价
			//粉丝数
			/*$fan_count = $model->table('sns_friend')->where(array('friend_tomid'=>$this->master_id))->count();
			$fan_count = $fan_count > 0?$fan_count:0;
			$member_info['fan_count'] = $fan_count;*/
			wcache($hash_key,$member_info,'member');
		}
		Tpl::output('member_info',$member_info);
		Tpl::output('header_menu_sign','snsindex');//默认选中顶部“买家首页”菜单
	}
	/**
	 *  查询购物车商品种类
	 *
	 * @param 
	 * @return 
	 */
	private function queryCart() {
		if (cookie('goodsnum') != null && intval(cookie('goodsnum')) >=0){
			$goodsnum = intval(cookie('goodsnum'));
		}else {
			if (cookie('cart') != ''){
				$cart_str = cookie('cart');
				if (get_magic_quotes_gpc()) $cart_str = stripslashes($cart_str);//去除斜杠
				$cookie_goods = unserialize($cart_str);
				$goodsnum = count($cookie_goods);
			}elseif ($_SESSION['member_id'] != ''){
				$goodsnum = Model()->table('cart')->where(array('member_id'=>$_SESSION['member_id']))->count();
			}else{
				$goodsnum = 0;
			}
		}
		setNcCookie('goodsnum',$goodsnum,2*3600);//保存1天
		Tpl::output('goods_num',$goodsnum);
	}
}

/********************************** 会员(卖家)control父类 **********************************************/

class BaseMemberStoreControl extends BaseMemberControl{
	/**
	 * 店铺详细信息
	 */
	public $store_info;
	
	public function __construct(){
		parent::__construct();
		if (!$_SESSION['store_id']){
			@header("Location: index.php?act=member_snsindex&op=nostoreindex");
			exit;
		}

		$model_store	= Model('store');
		$this->store_info = $store_info	= $model_store->shopStore(array('store_id'=>$_SESSION['store_id']));
		Tpl::output('store_info', $this->store_info);
		if ($store_info['store_center_quicklink'] != ''){
			$quick_link = @unserialize($store_info['store_center_quicklink']);
			Tpl::output('quick_link',$quick_link);
		}
		/**
		 * 读取语言包
		 */
		Language::read('member_store_index');

		/**
		 * 设置布局文件内容
		 */
		Tpl::setLayout('member_store_layout');
	}
	/**
	 * 自动发布店铺动态
	 * 
	 * @param array $data 相关数据
	 * @param string $type 类型 'new','coupon','xianshi','mansong','bundling','groupbuy'
	 * 所需字段
	 * new		goods表				goods_id,store_id,goods_name,goods_image,goods_store_price,goods_transfee_charge,py_price
	 * xianshi	p_xianshi_goods表	goods_id,goods_name,goods_store_price,discount,goods_image,store_id
	 * mansong	p_mansong表			mansong_name,start_time,end_time,store_id
	 * bundling	p_bundling表			bl_id,bl_name,bl_img,bl_discount_price,bl_freight_choose,bl_freight,store_id
	 * groupbuy	goods_group表		group_id,group_name,goods_id,goods_price,groupbuy_price,group_pic,rebate,start_time,end_time
	 * coupon在后台发布
	 */ 
	
	public function storeAutoShare($data, $type){
		$param = array(3=>'new',4=>'coupon',5=>'xianshi',6=>'mansong',7=>'bundling',8=>'groupbuy');
		$param_flip = array_flip($param);
		if(!in_array($type, $param) || empty($data)){
			return false;
		}
		
		$model = Model();
		$auto_setting = $model->table('sns_s_autosetting')->find($_SESSION['store_id']);
		$auto_sign = false; // 自动发布开启标志

		if($auto_setting['sauto_'.$type] == 1){
			$auto_sign = true;
			if( CHARSET == 'GBK') {
				foreach ((array)$data as $k=>$v){
					$data[$k] = Language::getUTF8($v);
				}
			}
			$goodsdata = addslashes(json_encode($data));
			if ($auto_setting['sauto_'.$type.'title'] != ''){
				$title = $auto_setting['sauto_'.$type.'title'];
			}else{
				$auto_title = 'nc_store_auto_share_'.$type.rand(1, 5);
				$title = Language::get($auto_title);
			}
		}
		if($auto_sign){
			// 插入数据
			$stracelog_array = array();
			$stracelog_array['strace_storeid']	= $this->store_info['store_id'];
			$stracelog_array['strace_storename']= $this->store_info['store_name'];
			$stracelog_array['strace_storelogo']= empty($this->store_info['store_logo'])?'':$this->store_info['store_logo'];
			$stracelog_array['strace_title']	= $title;
			$stracelog_array['strace_content']	= '';
			$stracelog_array['strace_time']		= time();
			$stracelog_array['strace_type']		= $param_flip[$type];
			$stracelog_array['strace_goodsdata']= $goodsdata;
			$model->table('sns_s_tracelog')->insert($stracelog_array);
			return true;
		}else{
			return false;
		}
	}
}

/********************************** SNS control父类 **********************************************/

class BaseSNSControl {
	protected $relation = 0;//浏览者与主人的关系：0 表示游客 1 表示一般普通会员 2表示朋友 3表示自己4表示已关注主人
	protected $master_id = 0; //主人编号
	const MAX_RECORDNUM = 20;//允许插入新记录的最大条数
	protected $member_info;
	/**
	 * 构造函数
	 */
	public function __construct(){
		/**
		 * 设置模板文件夹路径
		 */
		Tpl::setDir('sns');
		/**
		 * 设置布局文件内容
		 */
		Tpl::setLayout('sns_layout');
		/**
		 * 读取布局的语言包文件
		 */
		Language::read('common,sns_layout');
		/**
		 * 获取导航
		 */
		Tpl::output('nav_list',($nav = F('nav'))? $nav :H('nav',true,'file'));	
		
		/**
		 * 检查短消息数量
		 */
		$this->checkMessage();
		/**
		 * 购物车商品种数查询
		 */
		$this->queryCart();

		/**
		 * 验证会员及与主人关系
		 */
		$this->check_relation();
		
		/**
		 * 查询会员信息
		 */
		$this->member_info = $this->get_member_info();
		
		/**
		 * 添加访问记录
		 */
		$this->add_visit();
		
		/**
		 * 我的关注
		 */
		$this->my_attention();
		
		/**
		 * 获取设置
		 */
		$this->get_setting();
		
		//允许插入新记录的最大条数
		Tpl::output('max_recordnum',self::MAX_RECORDNUM);
	}
	/**
	 * 检查短消息数量
	 *
	 * @param 
	 * @return 
	 */
	private function checkMessage() {
		if($_SESSION['member_id'] == '') return ;
		//判断cookie是否存在
		$cookie_name = 'msgnewnum'.$_SESSION['member_id'];
		if (cookie($cookie_name) != null && intval(cookie($cookie_name)) >=0){
			$countnum = intval(cookie($cookie_name));
		}else {
			$message_model = Model('message');
			$countnum = $message_model->countNewMessage($_SESSION['member_id']);
			setNcCookie($cookie_name,"$countnum",2*3600);//保存1天
		}
		Tpl::output('message_num',$countnum);
	}
	/**
	 * 格式化时间
	 * @param string $time时间戳
	 */
	protected function formatDate($time){
		$handle_date = @date('Y-m-d',$time);//需要格式化的时间
		$reference_date = @date('Y-m-d',time());//参照时间
		$handle_date_time = strtotime($handle_date);//需要格式化的时间戳
		$reference_date_time = strtotime($reference_date);//参照时间戳
		if ($reference_date_time == $handle_date_time){
			$timetext = @date('H:i',$time);//今天访问的显示具体的时间点
		}elseif (($reference_date_time-$handle_date_time)==60*60*24){
			$timetext = Language::get('sns_yesterday');
		}elseif ($reference_date_time-$handle_date_time==60*60*48){
			$timetext = Language::get('sns_beforeyesterday');
		}else {
			$month_text = Language::get('nc_month');
			$day_text = Language::get('nc_day');
			$timetext = @date("m{$month_text}d{$day_text}",$time);
		}
		return $timetext;
	}
	/**
	 * 会员信息
	 *
	 * @param
	 * @return
	 */
	public function get_member_info() {
		//生成缓存的键值
		$hash_key  = $this->master_id;
		if($hash_key <= 0){
			showMessage('参数错误', '', '', 'error');
		}
		//写入缓存的数据
		$cachekey_arr = array('member_name','store_id','member_avatar','member_qq','member_email','member_ww','member_goldnum','member_points',
				'available_predeposit','member_snsvisitnum','credit_arr','fan_count','attention_count');
		//先查找$hash_key缓存
		if ($_cache = rcache($hash_key,'sns_member')){
			foreach ($_cache as $k=>$v){
				$member_info[$k] = $v;
			}
		} else {
			$model = Model();
			$member_info = $model->table('member')->where(array('member_id'=>$this->master_id))->find();
			$member_info['credit_arr'] = getCreditArr(intval($member_info['member_credit']));//信用度
			//粉丝数
			$fan_count = $model->table('sns_friend')->where(array('friend_tomid'=>$this->master_id))->count();
			$member_info['fan_count'] = $fan_count;
			//关注数
			$attention_count = $model->table('sns_friend')->where(array('friend_frommid'=>$this->master_id))->count();
			$member_info['attention_count'] = $attention_count;
			//兴趣标签
			$mtag_list = $model->table('sns_membertag,sns_mtagmember')->field('mtag_name')->on('sns_membertag.mtag_id = sns_mtagmember.mtag_id')->join('inner')->where(array('sns_mtagmember.member_id'=>$this->master_id))->select();
			$tagname_array = array();
			if(!empty($mtag_list)){
				foreach ($mtag_list as $val){
					$tagname_array[] = $val['mtag_name'];
				}
			}
			$member_info['tagname'] = $tagname_array;
			
			wcache($hash_key,$member_info,'sns_member');
		}
		Tpl::output('member_info',$member_info);
		return $member_info;
	}
	/**
	 * 访客信息
	 */
	protected function get_visitor(){
		$model = Model();
		//查询谁来看过我
		$visitme_list = $model->table('sns_visitor')->where(array('v_ownermid'=>$this->master_id))->limit(9)->order('v_addtime desc')->select();
		if (!empty($visitme_list)){
			foreach ($visitme_list as $k=>$v){
				$v['adddate_text'] = $this->formatDate($v['v_addtime']);
				$v['addtime_text'] = @date('H:i',$v['v_addtime']);
				$visitme_list[$k] = $v;
			}
		}
		Tpl::output('visitme_list',$visitme_list);
		if($this->relation == 3){	// 主人自己才有我访问过的人
			//查询我访问过的人
			$visitother_list = $model->table('sns_visitor')->where(array('v_mid'=>$this->master_id))->limit(9)->order('v_addtime desc')->select();
			if (!empty($visitother_list)){
				foreach ($visitother_list as $k=>$v){
					$v['adddate_text'] = $this->formatDate($v['v_addtime']);
					$visitother_list[$k] = $v;
				}
			}
			Tpl::output('visitother_list',$visitother_list);
		}
	}
	/**
	 * 验证会员及主人关系
	 */
	private function check_relation(){
		$model = Model();
		//验证主人会员编号
		$this->master_id = intval($_GET['mid']);
		if ($this->master_id <= 0){
			if ($_SESSION['is_login'] == 1){
				$this->master_id = $_SESSION['member_id'];
			}else {
				@header("location: index.php?act=login&ref_url=".urlencode('index.php?act=member_snshome'));
			}
		}
		Tpl::output('master_id', $this->master_id);
		
		//查询会员信息
		$this->member_info = $this->get_member_info();
		
		$model = Model();
		
		//判断浏览者与主人的关系
		if ($_SESSION['is_login'] == '1'){
			if ($this->master_id == $_SESSION['member_id']){//主人自己
				$this->relation = 3;
			}else{
				$this->relation = 1;
				//查询好友表
				$friend_arr = $model->table('sns_friend')->where(array('friend_frommid'=>$_SESSION['member_id'],'friend_tomid'=>$this->master_id))->find();
				if (!empty($friend_arr) && $friend_arr['friend_followstate'] == 2){
					$this->relation = 2;
				}elseif($friend_arr['friend_followstate'] == 1){
					$this->relation = 4;
				}
			}
		}
		Tpl::output('relation',$this->relation);
	}
	/**
	 * 增加访问记录
	 */
	private function add_visit(){
		$model = Model();
		//记录访客
		if ($_SESSION['is_login'] == '1' && $this->relation != 3){
			//访客为会员且不是空间主人则添加访客记录
			$visitor_info = $model->table('member')->find($_SESSION['member_id']);
			if (!empty($visitor_info)){
				//查询访客记录是否存在
				$existevisitor_info = $model->table('sns_visitor')->where(array('v_ownermid'=>$this->master_id, 'v_mid'=>$visitor_info['member_id']))->find();
				if (!empty($existevisitor_info)){//访问记录存在则更新访问时间
					$update_arr = array();
					$update_arr['v_addtime'] = time();
					$model->table('sns_visitor')->update(array('v_id'=>$existevisitor_info['v_id'], 'v_addtime'=>time()));
				}else {//添加新访问记录
					$insert_arr = array();
					$insert_arr['v_mid']			= $visitor_info['member_id'];
					$insert_arr['v_mname']			= $visitor_info['member_name'];
					$insert_arr['v_mavatar']		= $visitor_info['member_avatar'];
					$insert_arr['v_ownermid']		= $this->member_info['member_id'];
					$insert_arr['v_ownermname']		= $this->member_info['member_name'];
					$insert_arr['v_ownermavatar']	= $this->member_info['member_avatar'];
					$insert_arr['v_addtime']		= time();
					$model->table('sns_visitor')->insert($insert_arr);
				}
			}
		}
		
		//增加主人访问次数
		$cookie_str = cookie('visitor');
		$cookie_arr = array();
		$is_increase = false;
		if (empty($cookie_str)){
			//cookie不存在则直接增加访问次数
			$is_increase = true;
		}else{
			//cookie存在但是为空则直接增加访问次数
			$cookie_arr = explode('_',$cookie_str);
			if(!in_array($this->master_id,$cookie_arr)){
				$is_increase = true;
			}
		}
		if ($is_increase == true){
			//增加访问次数
			$model->table('member')->update(array('member_id'=>$this->master_id, 'member_snsvisitnum'=>array('exp', 'member_snsvisitnum+1')));
			//设置cookie，24小时之内不再累加
			$cookie_arr[] = $this->master_id;
			setNcCookie('visitor',implode('_',$cookie_arr),24*3600);//保存24小时
		}
	}
	/**
	 * 我的关注
	 */
	private function my_attention(){
		if(intval($_SESSION['member_id']) >0){
			$my_attention = Model()->table('sns_friend')->where(array('friend_frommid'=>$_SESSION['member_id']))->order('friend_addtime desc')->limit(4)->select();
			Tpl::output('my_attention', $my_attention);
		}
	}
	/**
	 * 获取设置信息
	 */
	private function get_setting(){
		$m_setting = Model()->table('sns_setting')->find($this->master_id);
		Tpl::output('skin_style', (!empty($m_setting['setting_skin'])?$m_setting['setting_skin']:'skin_01'));
	}
	/**
	 *  查询购物车商品种类
	 *
	 * @param 
	 * @return 
	 */
	private function queryCart() {
		if (cookie('goodsnum') != null && intval(cookie('goodsnum')) >=0){
			$goodsnum = intval(cookie('goodsnum'));
		}else {
			if (cookie('cart') != ''){
				$cart_str = cookie('cart');
				if (get_magic_quotes_gpc()) $cart_str = stripslashes($cart_str);//去除斜杠
				$cookie_goods = unserialize($cart_str);
				$goodsnum = count($cookie_goods);
			}elseif ($_SESSION['member_id'] != ''){
				$goodsnum = Model()->table('cart')->where(array('member_id'=>$_SESSION['member_id']))->count();
			}else{
				$goodsnum = 0;
			}
		}
		setNcCookie('goodsnum',$goodsnum,2*3600);//保存1天
		Tpl::output('goods_num',$goodsnum);
	}
}

/********************************** 店铺 control父类 **********************************************/

class BaseStoreControl{
	/**
	 * 构造函数
	 */
	public function __construct(){
		/**
		 * 读取布局的语言包文件
		 */
		Language::read('common,store_layout');
		/**
		 * 系统状态检查
		 */	
		if(C('site_status') == '0') {
			showMessage(C('closed_reason'));
			exit();
		}
		/**
		 * 设置模板文件夹路径
		 */
		Tpl::setDir('store');
		/**
		 * 获取导航
		 */
		Tpl::output('nav_list',($g = F('nav')) ? $g : H('nav',true,'file'));
		/**
		 * 设置布局文件内容
		 */
		Tpl::setLayout('store_layout');
		/**
		 * 短消息检查
		 */
		$this->checkMessage();
		/**
		 * 购物车商品种数查询
		 */
		$this->queryCart();
	}
	/**
	 * 系统通知发送函数
	 * 
	 * @param int $receiver_id 接受人编号
	 * @param string $tpl_code 模板标识码
	 * @param array $param 内容数组
	 * @param bool $flag 是否遵从系统设置
	 * @return bool
	 */
	public function send_notice($receiver_id,$tpl_code,$param,$flag = true){
		/**
		 * 获取通知内容模板
		 */
		$mail_tpl_model	= Model('mail_templates');
		$mail_tpl	= $mail_tpl_model->getOneTemplates($tpl_code);
		if(empty($mail_tpl) || $mail_tpl['mail_switch'] == 0)return false;
		
		/**
		 * 获取接收人信息
		 */
		$member_model	= Model('member');
		$receiver	= $member_model->infoMember(array('member_id'=>$receiver_id));
		if(empty($receiver))return false;
		
		/**
		 * 为通知模板的主题与内容中变量赋值
		 */
		$subject	= ncReplaceText($mail_tpl['title'],$param);
		$message	= ncReplaceText($mail_tpl['content'],$param);
		/**
		 * 根据模板里面确定的通知类型采用对应模式发送通知
		 */
		$result	= false;
		switch($mail_tpl['type']){
			case '0':
				$email	= new Email();
				$result	= true;
				if($flag and $GLOBALS['setting_config']['email_enabled'] == '1' or $flag == false){
					$result	= $email->send_sys_email($receiver['member_email'],$subject,$message);
				}
				break;
			case '1':
				$model_message = Model('message');
				$param = array(
					'member_id'=>$receiver_id,
					'to_member_name'=>$receiver['member_name'],
					'msg_content'=>$message,
					'message_type'=>1//表示系统消息
				);				
				$result = $model_message->saveMessage($param);
				break;
		}
		return $result;
	}
	/**
	 * 检查短消息数量
	 *
	 * @param 
	 * @return 
	 */
	private function checkMessage() {
		if($_SESSION['member_id'] == '') return ;
		//判断cookie是否存在
		$cookie_name = 'msgnewnum'.$_SESSION['member_id'];
		if (cookie($cookie_name) != null && intval(cookie($cookie_name)) >=0){
			$countnum = intval(cookie($cookie_name));
		}else {
			$message_model = Model('message');
			$countnum = $message_model->countNewMessage($_SESSION['member_id']);
			setNcCookie($cookie_name,"$countnum",2*3600);//2小时
		}
		Tpl::output('message_num',$countnum);
	}
	/**
	 * 检查店铺开启状态
	 *
	 * @param int $store_id 店铺编号
	 * @param string $msg 警告信息
	 */
	protected function getStoreInfo($store_id){
		$lang	= Language::getLangContent();
		$model_store	= Model('store');
        $store_info = array();
        if(intval($store_id) > 0) {
            $store_info	= $model_store->shopStore(array('store_id'=>$store_id));
        } else {
            showMessage($lang['nc_store_close'], '', '', 'error');
        }
		if($store_info['store_state'] == '0' || (intval($store_info['store_end_time']) != 0 && $store_info['store_end_time'] <= time())){
            showMessage($lang['nc_store_close'], '', '', 'error');
		}
        $store_info = $model_store->getStoreInfoDetail($store_info);
        Tpl::output('store_info',$store_info);
		Tpl::output('hot_sales',$store_info['hot_sales']);
		Tpl::output('hot_collect',$store_info['hot_collect']);
		Tpl::output('goods_class_list',$store_info['goods_class_list']);
		Tpl::output('page_title',$store_info['store_name']);
		if($store_info['store_theme'] == 'style8'){
			$theme_model = Model('store_theme');
			$condition = array();
			$condition['style_id'] = $store_info['store_theme'];
			$condition['store_id'] = $id;
			$theme_list = $theme_model->getList($condition);
			Tpl::output('theme',$theme_list[0]);
		}
		return $store_info;
	}

	/**
	 * 查询店铺动态评价
	 * @param int $store_id 店铺编号
	 */
	public function show_storeeval($store_id){
		if ($store_id<=0){
			return array();
		}
		$evaluate_model = Model("evaluate");
		$storestat_list = $evaluate_model->getOneStoreEvalStat($store_id);
		for ($i=1;$i<4;$i++){
			$storestat_list[$i]['evalstat_fivenum_rate'] = @round($storestat_list[$i]['evalstat_fivenum']/$storestat_list[$i]['evalstat_timesnum']*100,2);
			$storestat_list[$i]['evalstat_fournum_rate'] = @round($storestat_list[$i]['evalstat_fournum']/$storestat_list[$i]['evalstat_timesnum']*100,2);
			$storestat_list[$i]['evalstat_threenum_rate'] = @round($storestat_list[$i]['evalstat_threenum']/$storestat_list[$i]['evalstat_timesnum']*100,2);
			$storestat_list[$i]['evalstat_twonum_rate'] = @round($storestat_list[$i]['evalstat_twonum']/$storestat_list[$i]['evalstat_timesnum']*100,2);
			$storestat_list[$i]['evalstat_onenum_rate'] = @round($storestat_list[$i]['evalstat_onenum']/$storestat_list[$i]['evalstat_timesnum']*100,2);
			$storestat_list[$i]['evalstat_average'] = $storestat_list[$i]['evalstat_average']>0?$storestat_list[$i]['evalstat_average']:0;
		}
		Tpl::output('storestat_list',$storestat_list);
	}
	/**
	 *  查询购物车商品种类
	 *
	 * @param 
	 * @return 
	 */
	private function queryCart() {
		if (cookie('goodsnum') != null && intval(cookie('goodsnum')) >=0){
			$goodsnum = intval(cookie('goodsnum'));
		}else {
			if (cookie('cart') != ''){
				$cart_str = cookie('cart');
				if (get_magic_quotes_gpc()) $cart_str = stripslashes($cart_str);//去除斜杠
				$cookie_goods = unserialize($cart_str);
				$goodsnum = count($cookie_goods);
			}elseif ($_SESSION['member_id'] != ''){
				$goodsnum = Model()->table('cart')->where(array('member_id'=>$_SESSION['member_id']))->count();
			}else{
				$goodsnum = 0;
			}
		}
		setNcCookie('goodsnum',$goodsnum,2*3600);//保存1天
		Tpl::output('goods_num',$goodsnum);
	}
}
