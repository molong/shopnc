<?php
/**
 * 直通车管理
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class store_ztcControl extends BaseMemberStoreControl {
	public function __construct() {
		parent::__construct();
		/**
		 * 读取语言包
		 */
		Language::read('member_store_ztc');
		/**
		 * 判断系统是否开启直通车和金币功能
		 */
		if ($GLOBALS['setting_config']['gold_isuse'] != 1 || $GLOBALS['setting_config']['ztc_isuse'] != 1){
			showMessage(Language::get('store_ztc_unavailable'),'index.php?act=store','html','error');
		}
	}
	public function indexOp(){
		$this->ztc_listOp();
	}
	/**
	 * 卖家商品列表
	 *
	 * @param 
	 * @return 
	 */
	public function ztc_listOp() {
		//条件
		$condition_arr = array();
		$condition_arr['ztc_memberid'] = $_SESSION['member_id'];
		$s_goodsname = trim($_GET['zg_name']);
		if ($s_goodsname){
			$condition_arr['ztc_goodsname'] = $s_goodsname;			
		}
		if ($_GET['zg_state']){
			$condition_arr['ztc_state'] = intval($_GET['zg_state'])-1;			
		}
		if ($_GET['zg_paystate']){
			$condition_arr['ztc_paystate'] = intval($_GET['zg_paystate'])-1;			
		}
		if ($_GET['zg_type']){
			$condition_arr['ztc_type'] = intval($_GET['zg_type'])-1;			
		}
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		//查询直通车列表
		$ztc_model = Model('ztc');
		$ztc_list = $ztc_model->getZtcList($condition_arr,$page);
		if(!empty($ztc_list) && is_array($ztc_list)){//整理数组方便页面图片显示调用
			foreach($ztc_list  as $key => $val){
				$val['goods_image'] = $val['ztc_goodsimage'];
				$val['goods_id'] = $val['ztc_goodsid'];
				$val['store_id'] = $val['ztc_storeid'];
				$ztc_list[$key] = $val;
			}
		}
		//信息输出
		self::profile_menu('ztc_list');
		Tpl::output('show_page',$page->show());
		Tpl::output('ztc_list',$ztc_list);
		Tpl::output('menu_sign','store_ztc');
		Tpl::output('menu_sign_url','index.php?act=store_ztc&op=ztc_list');
		Tpl::output('menu_sign1','ztc_list');
		Tpl::showpage('store_ztc.index');
	}
	/**
	 * 添加商品
	 */
	public function ztc_addOp() {
		//查询会员现有金币数
		$member_model = Model('member');
		$member_array = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));
		
		if (chksubmit()){
			$starttime = strtotime($_POST['ztc_stime']);
			$obj_validate = new Validate();
			$validate_arr[] = array("input"=>$_POST["goods_id"], "require"=>"true",'validator'=>'Compare',"operator"=>' > ','to'=>1,"message"=>Language::get('store_ztc_add_search_goodserror')); 
			$validate_arr[] = array("input"=>$_POST["ztc_type"], "require"=>"true","message"=>Language::get('store_ztc_add_audittype_nullerror'));
			$validate_arr[] = array("input"=>$_POST["ztc_goldnum"],"require"=>"true",'validator'=>'Range','min'=>1,'max'=>$member_array['member_goldnum'],"message"=>Language::get('store_ztc_add_goldnum_error'));
			$validate_arr[] = array("input"=>$_POST["ztc_remark"],"validator"=>"Length","max"=>100,"message"=>Language::get('store_ztc_add_remarkerror'));
			if (!$_POST['ztc_type'] == 1){//申请新纪录,验证开始时间是否正确
				$validate_arr[] = array("input"=>$starttime,"require"=>"true","validator"=>"Compare","operator"=>' > ','to'=>time(),"message"=>Language::get('store_ztc_add_starttime_error'));
			}
			$obj_validate -> validateparam = $validate_arr;
			$error = $obj_validate->validate();			
			if ($error != ''){
				showValidateError($error);
			}
			$goods_id = intval($_POST['goods_id']);
			//查询商品信息
			$goods_model = Model('goods');
			$goods_info = $goods_model->checkGoods(array('goods_id'=>$goods_id));	
			if (!is_array($goods_info) || count($goods_info)<=0){
				showDialog(Language::get('store_ztc_add_search_goodserror'));
			}
			//判断直通车商品是否已经存在
			$ztc_model = Model('ztc');
			if ($_POST['ztc_type'] == 1){//充值类型
				//计算所需要金币数
				$ztc_dayprod = intval($GLOBALS['setting_config']['ztc_dayprod']);
				$datetime = date('Y-m-d',time());
				$datetime = strtotime($datetime);
				$goldall = ((($datetime - $goods_info['goods_ztclastdate'])/(3600*24)))*intval($ztc_dayprod);
				//验证商品是否为直通车商品
				if ($goods_info['goods_isztc'] == 0 || !($goods_info['goods_isztc'] == 1 && $goods_info['goods_goldnum'] >= $goldall)){
					showDialog(Language::get('store_ztc_add_recharge_goodserror'));
				}
			}else{//申请新纪录
				//验证商品是否为直通车商品
				if ($goods_info['goods_isztc'] == 1){
					showDialog(Language::get('store_ztc_add_newaudit_goodserror'));
				}
				//判断该商品是否已经申请了直通车并且未通过审核
				$ztc_info = $ztc_model->getZtcInfo(array('ztc_goodsid'=>$goods_id,'ztc_state'=>0,'ztc_type'=>0));
				if (is_array($ztc_info) && count($ztc_info)>0){
					showDialog(Language::get('store_ztc_add_newaudit_recordexist'));
				}
			}
			//添加直通车申请
			$ztc_array	= array();
			$ztc_array['ztc_goodsid']	= intval($_POST['goods_id']);
			$ztc_array['ztc_goodsname']	= $goods_info['goods_name'];
			$ztc_array['ztc_goodsimage']= $goods_info['goods_image'];
			$ztc_array['ztc_memberid']	= $_SESSION['member_id'];
			$ztc_array['ztc_membername']= $_SESSION['member_name'];
			$ztc_array['ztc_storeid']	= $_SESSION['store_id'];
			$ztc_array['ztc_storename']	= $_SESSION['store_name'];
			$ztc_array['ztc_gold']		= $_POST['ztc_goldnum'];
			$ztc_array['ztc_remark']	= $_POST['ztc_remark'];
			$ztc_array['ztc_startdate']	= strtotime($_POST['ztc_stime']);
			$ztc_array['ztc_addtime']	= time();//添加时间
			//如果用户选择充值并且立即支付则将直通车申请记录的状态自动通过审核
			if ($_POST['ztc_type'] == 1 && $_POST['ztc_paystate'] == 1){
				$ztc_array['ztc_state']	= 1;
			}else{
				$ztc_array['ztc_state']	= 0;
			}
			$ztc_array['ztc_paystate']	= $_POST['ztc_paystate'];			
			$ztc_array['ztc_type']	= $_POST['ztc_type'];
			
			$result = $ztc_model->addZtcGoods($ztc_array);
			if ($result){
				//如果用户选择了立即支付，则扣除金币并添加日志
				if ($ztc_array['ztc_paystate'] == 1){
					//修改用户金币信息
					$newmember_goldnum = intval($member_array['member_goldnum']) - intval($_POST['ztc_goldnum']);
					$newmember_goldnumminus = intval($member_array['member_goldnumminus']) + intval($_POST['ztc_goldnum']);
					$member_model->updateMember(array('member_goldnum'=>$newmember_goldnum,'member_goldnumminus'=>$newmember_goldnumminus),$_SESSION['member_id']);
					//添加金币日志
					$goldlog_model = Model('gold_log');
					$insert_goldlog = array();
					$insert_goldlog['glog_memberid'] = $_SESSION['member_id'];
					$insert_goldlog['glog_membername'] = $_SESSION['member_name'];
					$insert_goldlog['glog_storeid'] = $_SESSION['store_id'];
					$insert_goldlog['glog_storename'] = $_SESSION['store_name'];
					$insert_goldlog['glog_adminid'] = 0;
					$insert_goldlog['glog_adminname'] = '';
					$insert_goldlog['glog_goldnum'] = $_POST['ztc_goldnum'];
					$insert_goldlog['glog_method'] = 2;
					$insert_goldlog['glog_addtime'] = time();
					$insert_goldlog['glog_desc'] = Language::get('store_ztc_goldlog_minusgold');
					$insert_goldlog['glog_stage'] = 'ztc';
					$goldlog_model->add($insert_goldlog);
					//如果申请类型为充值则立即修改商品表直通车信息
					if ($ztc_array['ztc_type'] == 1){
						$newgoods_goldnum = intval($goods_info['goods_goldnum']) + intval($_POST['ztc_goldnum']);
						$g_up_result = $goods_model->updateGoodsAllUser(array('goods_goldnum'=>$newgoods_goldnum),$goods_id);
						//记录直通车商品金币日志
						if ($g_up_result){
							//记录直通车消费日志
							$ztcgoldlog_model = Model('ztc_glodlog');
							$logarr = array();
							$logarr['glog_goodsid'] = $goods_id;
							$logarr['glog_goodsname'] = $goods_info['goods_name'];
							$logarr['glog_memberid'] = $_SESSION['member_id'];
							$logarr['glog_membername'] = $_SESSION['member_name'];
							$logarr['glog_storeid'] = $_SESSION['store_id'];
							$logarr['glog_storename'] = $_SESSION['store_name'];
							$logarr['glog_type'] = 1;//增加
							$logarr['glog_goldnum'] = intval($_POST['ztc_goldnum']);
							$logarr['glog_addtime'] = time();
							$logarr['glog_desc'] = Language::get('store_ztc_ztclog_addgold');
							$ztcgoldlog_model->addlog($logarr);
						}
					}
				}
				showDialog(Language::get('store_ztc_add_success'),'index.php?act=store_ztc&op=ztc_list','succ');
			}else{
				showDialog(Language::get('store_ztc_add_fail'));
			}
		}else {
			Tpl::output('member_array',$member_array);
			Tpl::output('nowdate',date('Y-m-d',time()));
			self::profile_menu('ztc_add');
			Tpl::output('menu_sign','store_ztc');
			Tpl::output('menu_sign_url','index.php?act=store_ztc&op=ztc_add');
			Tpl::output('menu_sign1','ztc_add');
			Tpl::showpage('store_ztc.form');
		}
	}
	/**
	 * 选择商品
	 */
	public function getselectgoodsOp(){
		/**
		 * 读取语言包
		 */
		Language::read('member_store_ztc');
		$lang	= Language::getLangContent();
		/**
		 * 获取本店分类
		 */
		$select_string = '';
		//得到本店商品分类
		$stc_class = Model('store_goods_class');
		$stc_tree = $stc_class->getStcTreeList($_SESSION['store_id']);
		if(!empty($stc_tree) && is_array($stc_tree)){
			foreach($stc_tree as $stc){
				$select_string .= '<option value="'.$stc['stc_id'].'">'.$stc['stc_name'].'</option>';
			}
		}
		//判断直通车申请类型
		$t = intval($_GET['t']);
		if (!in_array($t,array(0,1))){
			$t = 0;
		}
		Tpl::output('select_string',$select_string);
		Tpl::output('title',$lang['store_ztc_add_choose_goods']);
		Tpl::output('ztc_type',$t);
		Tpl::showpage('store_ztc.sgoods','null_layout');
	}
	/**
	 * 搜索商品
	 */
	public function getselectgoodslistOp(){
		//得到商品列表
		$goods_class = Model('goods');
		//得到搜索条件
		$stc_id = intval($_GET['stc_id']);
		$goods_name = trim($_GET['stc_goods_name']);
		//获得商品列表
		$condition_array = array();
		//$condition_array['stc_id'] = $stc_id;//本店铺商品类别编号
		$condition_array['keyword'] = $goods_name;
		$condition_array['store_id'] = $_SESSION['store_id'];
		//判断直通车申请类型
		$t = intval($_GET['t']);
		if (!in_array($t,array(0,1))){
			$t = 0;
		}
		if ($t == 1){//充值
			$condition_array['goods_isztc'] = 1;
		}else {//申请新直通车
			$condition_array['goods_isztc'] = 0;
		}
		//查询分类下的子分类
		if ($stc_id){
			$model_store_class = Model('my_goods_class');
			$stc_id_arr = $model_store_class->getChildAndSelfClass($stc_id);
			if (is_array($stc_id_arr) && count($stc_id_arr)>0){
				$condition_array['stc_id_in'] = implode(',',$stc_id_arr);
			}else{
				$condition_array['stc_id'] = $stc_id_arr;
			}
		}
		$condition_array['limit'] = 50;
		$condition_array['order'] = 'goods.goods_id desc';
		//$condition_array['order'] = 'goods.goods_id';
		$goods_list = $goods_class->getGoods($condition_array,'','`goods`.goods_id,`goods`.goods_name','stc');
		
		//处理返回字符串
		if (is_array($goods_list)){
			$data = array(
				'done'=>1,
				'length'=>count($goods_list),
				'retval'=>$goods_list
			);
		}else {
			$data = array(
				'done'=>1,
				'length'=>0,
				'retval'=>array()
			);
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$data = Language::getUTF8($data);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		}
		echo json_encode($data);
	}
	/**
	 * 直通车申请记录支付
	 * 
	 */
	public function ztc_payOp(){
		$zid = intval($_GET['zid']);
		if ($zid <= 0){
			showMessage(Language::get('store_ztc_parameter_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}
		//查询申请信息
		$ztc_model = Model('ztc');
		$ztc_info = $ztc_model->getZtcInfo(array('ztc_id'=>$zid));
		if (!is_array($ztc_info) && count($ztc_info)<=0){
			showMessage(Language::get('store_ztc_record_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}
		//查询会员现有金币数
		$member_model = Model('member');
		$member_array = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));
		if (!is_array($member_array) || count($member_array)<=0){
			showMessage(Language::get('store_ztc_userrecord_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}
		//验证会员只能修改自己的信息
		if ($ztc_info['ztc_memberid'] != $_SESSION['member_id']){
			showMessage(Language::get('store_ztc_operate_yourself_error'),'index.php?act=store_ztc&op=ztc_list','html','error');			
		}
		//已经经过后台审核操作的记录则不可再支付
		if ($ztc_info['ztc_state'] != 0){
			showMessage(Language::get('store_ztc_pay_reviewed_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}
		//查询商品信息
		$goods_model = Model('goods');
		$goods_info = $goods_model->checkGoods(array('goods_id'=>$ztc_info['ztc_goodsid']));			
		if (!is_array($goods_info) || count($goods_info)<=0){
			showMessage(Language::get('store_ztc_goodsrecord_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}
		
		//修改信息支付状态
		$up_ztcArr = array();
		$up_ztcArr['ztc_paystate'] = 1;
		if ($ztc_info['ztc_paystate'] == 1){
			$up_ztcArr['ztc_paystate'] = 0;//由已经支付状态，修改为未支付状态
		}else {
			$up_ztcArr['ztc_paystate'] = 1;//由未支付状态，修改为已经支付状态
			//判断金币是否足够
			if (intval($member_array['member_goldnum'])< intval($ztc_info['ztc_gold'])){
				showMessage(Language::get('store_ztc_pay_goldnum_maxerror'),'index.php?act=store_ztc&op=ztc_list','html','error');
			}
		}
		//记录类型为充值并且确认支付则系统自动通过审核
		if ($ztc_info['ztc_type'] == 1 && $up_ztcArr['ztc_paystate'] == 1){
			$up_ztcArr['ztc_state'] = 1;
		}
		$result = $ztc_model->updateZtcOne($up_ztcArr,array('ztc_id'=>$zid));
		if ($result){
			//修改用户金币信息
			if ($up_ztcArr['ztc_paystate'] == 1){
				//修改用户金币信息
				$newmember_goldnum = intval($member_array['member_goldnum']) - intval($ztc_info['ztc_gold']);
				$newmember_goldnumminus = intval($member_array['member_goldnumminus']) + intval($ztc_info['ztc_gold']);
				$member_model->updateMember(array('member_goldnum'=>$newmember_goldnum,'member_goldnumminus'=>$newmember_goldnumminus),$_SESSION['member_id']);
				//添加金币日志
				$goldlog_model = Model('gold_log');
				$insert_goldlog = array();
				$insert_goldlog['glog_memberid'] = $_SESSION['member_id'];
				$insert_goldlog['glog_membername'] = $_SESSION['member_name'];
				$insert_goldlog['glog_storeid'] = $_SESSION['store_id'];
				$insert_goldlog['glog_storename'] = $_SESSION['store_name'];
				$insert_goldlog['glog_adminid'] = 0;
				$insert_goldlog['glog_adminname'] = '';
				$insert_goldlog['glog_goldnum'] = intval($ztc_info['ztc_gold']);
				$insert_goldlog['glog_method'] = 2;
				$insert_goldlog['glog_addtime'] = time();
				$insert_goldlog['glog_desc'] = Language::get('store_ztc_goldlog_minusgold');
				$insert_goldlog['glog_stage'] = 'ztc';
				$goldlog_model->add($insert_goldlog);
				//如果申请类型为充值则立即修改商品表直通车信息
				if ($ztc_info['ztc_type'] == 1){
					$newgoods_goldnum = intval($goods_info['goods_goldnum']) + intval($ztc_info['ztc_gold']);
					$g_up_result = $goods_model->updateGoodsAllUser(array('goods_goldnum'=>$newgoods_goldnum),$ztc_info['ztc_goodsid']);
					//记录直通车商品金币日志
					if ($g_up_result){
						//记录直通车消费日志
						$ztcgoldlog_model = Model('ztc_glodlog');
						$logarr = array();
						$logarr['glog_goodsid'] = $ztc_info['ztc_goodsid'];
						$logarr['glog_goodsname'] = $ztc_info['ztc_goodsname'];
						$logarr['glog_memberid'] = $_SESSION['member_id'];
						$logarr['glog_membername'] = $_SESSION['member_name'];
						$logarr['glog_storeid'] = $_SESSION['store_id'];
						$logarr['glog_storename'] = $_SESSION['store_name'];
						$logarr['glog_type'] = 1;//增加
						$logarr['glog_goldnum'] = intval($ztc_info['ztc_gold']);
						$logarr['glog_addtime'] = time();
						$logarr['glog_desc'] = Language::get('store_ztc_ztclog_addgold');
						$ztcgoldlog_model->addlog($logarr);
					}
				}
			}else {
				//修改用户金币信息
				$newmember_goldnum = intval($member_array['member_goldnum']) + intval($ztc_info['ztc_gold']);
				$newmember_goldnumminus = intval($member_array['member_goldnumminus']) - intval($ztc_info['ztc_gold']);
				$member_model->updateMember(array('member_goldnum'=>$newmember_goldnum,'member_goldnumminus'=>$newmember_goldnumminus),$_SESSION['member_id']);
				//添加金币日志
				$goldlog_model = Model('gold_log');
				$insert_goldlog = array();
				$insert_goldlog['glog_memberid'] = $_SESSION['member_id'];
				$insert_goldlog['glog_membername'] = $_SESSION['member_name'];
				$insert_goldlog['glog_storeid'] = $_SESSION['store_id'];
				$insert_goldlog['glog_storename'] = $_SESSION['store_name'];
				$insert_goldlog['glog_adminid'] = 0;
				$insert_goldlog['glog_adminname'] = '';				
				$insert_goldlog['glog_goldnum'] = intval($ztc_info['ztc_gold']);
				$insert_goldlog['glog_method'] = 1;
				$insert_goldlog['glog_addtime'] = time();
				//$insert_goldlog['glog_desc'] = '撤销参加直通车的确认支付添加金币';
				$insert_goldlog['glog_desc'] = Language::get('store_ztc_goldlog_addgold');
				$insert_goldlog['glog_stage'] = 'ztc';
				$goldlog_model->add($insert_goldlog);
			}
			showMessage(Language::get('store_ztc_pay_update_success'),'index.php?act=store_ztc&op=ztc_list');
		}
	}
	/**
	 * 删除直通车申请记录
	 */
	public function drop_ztcOp(){
		$z_id = intval($_GET['z_id']);
		if (!$z_id){
			showDialog(Language::get('store_ztc_parameter_error'));
		}
		$ztc_model = Model('ztc');
		//查询申请记录是否存在
		$ztc_info = $ztc_model->getZtcInfo(array('ztc_id'=>$z_id,'ztc_memberid'=>$_SESSION['member_id']));
		if (!is_array($ztc_info) || count($ztc_info)<=0){
			showDialog(Language::get('store_ztc_record_error'));
		}
		if ($ztc_info['ztc_state'] != 0){
			showDialog(Language::get('store_ztc_drop_reviewed_error'));
		}else {
			if ($ztc_info['ztc_paystate'] != 0){
				showDialog(Language::get('store_ztc_drop_paid_error'));
			}
		}
		$result = $ztc_model->dropZtcById($z_id);
		if($result) {
			showDialog(Language::get('store_ztc_drop_success'),'index.php?act=store_ztc&op=ztc_list');			
		} else {
			showDialog(Language::get('store_ztc_drop_fail'));
		}
	}
	/**
	 * 删除直通车申请记录
	 */
	public function dropall_ztcOp(){
		$z_id = $_GET['z_id'];
		$z_id = explode(',',$z_id);
		if (!$z_id || !is_array($z_id) || count($z_id)<=0){
			showDialog(Language::get('store_ztc_parameter_error'));
		}
		$z_id = "'".implode("','",$z_id)."'";
		$ztc_model = Model('ztc');
		//查询申请记录是否存在
		$ztc_list = $ztc_model->getZtcList(array('ztc_id_in'=>$z_id,'ztc_memberid'=>$_SESSION['member_id']));
		if (!is_array($ztc_list) || count($ztc_list)<=0){
			showDialog(Language::get('store_ztc_record_error'));
		}
		$z_idnew = array();
		foreach ($ztc_list as $k=>$v){
			if ($v['ztc_state'] == 0 && $v['ztc_paystate'] == 0){
				$z_idnew[] = $v['ztc_id'];
			}
		}
		$result = true;
		if (is_array($z_idnew) && count($z_idnew)>0){
			$z_id = "'".implode("','",$z_idnew)."'";
			$result = $ztc_model->dropZtcByCondition(array('ztc_id_in_del'=>$z_id));
		}
		if($result) {
			showDialog(Language::get('store_ztc_drop_success'),'index.php?act=store_ztc&op=ztc_list');
		} else {
			showDialog(Language::get('store_ztc_drop_fail'));
		}
	}
	/**
	 * 编辑直通车申请记录
	 */
	public function edit_ztcOp(){
		$z_id = intval($_GET['z_id']);
		if (!$z_id){
			showMessage(Language::get('store_ztc_parameter_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}
		$ztc_model = Model('ztc');
		//查询申请记录是否存在
		$ztc_info = $ztc_model->getZtcInfo(array('ztc_id'=>$z_id,'ztc_memberid'=>$_SESSION['member_id']));
		if (!is_array($ztc_info) || count($ztc_info)<=0){
			showMessage(Language::get('store_ztc_record_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}
		//申请信息已经过审核操作，不可编辑
		if ($ztc_info['ztc_state'] != 0){
			showMessage(Language::get('store_ztc_edit_reviewed_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}else {
			if ($ztc_info['ztc_paystate'] != 0){
				showMessage(Language::get('store_ztc_edit_paid_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
			}
		}
		//查询会员现有金币数
		$member_model = Model('member');
		$member_array = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));
		
		if (chksubmit()){
			/**
			 * 信息验证
			 */
			$starttime = strtotime($_POST['ztc_stime']);
			$obj_validate = new Validate();
			$validate_arr[] = array("input"=>$_POST["goods_id"], "require"=>"true",'validator'=>'Compare',"operator"=>' > ','to'=>1,"message"=>Language::get('store_ztc_add_search_goodserror')); 
			$validate_arr[] = array("input"=>$_POST["ztc_goldnum"],"require"=>"true",'validator'=>'Range','min'=>1,'max'=>$member_array['member_goldnum'],"message"=>Language::get('store_ztc_add_goldnum_error'));
			$validate_arr[] = array("input"=>$_POST["ztc_remark"],"validator"=>"Length","max"=>100,"message"=>Language::get('store_ztc_add_remarkerror'));
			if (!$ztc_info['ztc_type'] == 1){//申请新纪录,验证开始时间是否正确
				$validate_arr[] = array("input"=>$starttime, "validator"=>"Compare","operator"=>' > ','to'=>time(),"message"=>Language::get('store_ztc_add_starttime_error'));
			}
			$obj_validate -> validateparam = $validate_arr;
			$error = $obj_validate->validate();			
			if ($error != ''){
				showValidateError($error);
			}
			$goods_id = intval($_POST['goods_id']);
			//查询商品信息
			$goods_model = Model('goods');
			$goods_info = $goods_model->checkGoods(array('goods_id'=>$goods_id));			
			if (!is_array($goods_info) || count($goods_info)<=0){
				showDialog($lang['store_ztc_edit_search_goodserror']);
			}
			//判断直通车商品是否已经存在
			$ztc_model = Model('ztc');
			if ($ztc_info['ztc_type'] == 1){//充值类型
				//计算所需要金币数
				$ztc_dayprod = intval($GLOBALS['setting_config']['ztc_dayprod']);
				$datetime = date('Y-m-d',time());
				$datetime = strtotime($datetime);
				$goldall = ((($datetime - $goods_info['goods_ztclastdate'])/(3600*24)))*intval($ztc_dayprod);
				//验证商品是否为直通车商品
				if ($goods_info['goods_isztc'] == 0 || !($goods_info['goods_isztc'] == 1 && $goods_info['goods_goldnum'] >= $goldall)){
					showDialog(Language::get('store_ztc_edit_recharge_goods_error'));
				}
			}else{//申请新纪录
				//验证商品是否为直通车商品
				if ($goods_info['goods_isztc'] == 1){
					showDialog(Language::get('store_ztc_edit_new_goods_error'));
				}
				//判断该商品是否已经申请了直通车并且未通过审核
				$ztc_checkinfo = $ztc_model->getZtcInfo(array('ztc_goodsid'=>$goods_id,'ztc_state'=>0,'ztc_type'=>0));
				if ($ztc_checkinfo['ztc_id'] != $z_id && is_array($ztc_checkinfo) && count($ztc_checkinfo)>0){
					showDialog(Language::get('store_ztc_edit_new_goodsexist_error'));
				}
			}
			//修改直通车申请
			$ztc_array	= array();
			$ztc_array['ztc_goodsid']	= intval($_POST['goods_id']);
			$ztc_array['ztc_goodsname']	= $goods_info['goods_name'];
			$ztc_array['ztc_goodsimage']= $goods_info['goods_image'];
			$ztc_array['ztc_gold']		= $_POST['ztc_goldnum'];
			$ztc_array['ztc_remark']	= $_POST['ztc_remark'];
			$ztc_array['ztc_startdate']	= strtotime($_POST['ztc_stime']);
			$result = $ztc_model->updateZtcOne($ztc_array,array('ztc_id'=>$z_id));
			if($result) {
				showDialog(Language::get('store_ztc_edit_success'),'index.php?act=store_ztc&op=ztc_list','succ');
			} else {
				showDialog(Language::get('store_ztc_edit_fail'),'index.php?act=store_ztc&op=ztc_list');
			}
		} else {
			Tpl::output('member_array',$member_array);
			Tpl::output('ztc_info',$ztc_info);
			Tpl::output('nowdate',date('Y-m-d',time()));
			self::profile_menu('edit_ztc');
			Tpl::output('menu_sign','store_ztc');
			Tpl::output('menu_sign_url','index.php?act=store_ztc&op=edit_ztc');
			Tpl::output('menu_sign1','ztc_list');
			Tpl::showpage('store_ztc.editform');
		}
	}
	/**
	 * 编辑直通车申请记录
	 */
	public function info_ztcOp(){
		$z_id = intval($_GET['z_id']);
		if (!$z_id){
			showMessage(Language::get('store_ztc_parameter_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}
		$ztc_model = Model('ztc');
		//查询申请记录是否存在
		$ztc_info = $ztc_model->getZtcInfo(array('ztc_id'=>$z_id,'ztc_memberid'=>$_SESSION['member_id']));
		if (!is_array($ztc_info) || count($ztc_info)<=0){
			showMessage(Language::get('store_ztc_record_error'),'index.php?act=store_ztc&op=ztc_list','html','error');
		}

		Tpl::output('ztc_info',$ztc_info);
		self::profile_menu('ztc_list');
		Tpl::output('menu_sign','store_ztc');
		Tpl::output('menu_sign1','ztc_list');
		Tpl::showpage('store_ztc.info');
	}
	/**
	 * 直通车商品列表
	 */
	public function ztc_glistOp(){
		//更新商品表中直通车金币信息，并记录日志
		$ztc_model = Model('ztc');
		$ztc_model->updateZtcGoods(Language::get('store_ztc_glist_glog_desc'),$_SESSION['store_id']);
		
		$condition_arr = array();
		$state		= array('goods_open'=>array('goods_show'=>1),'goods_close'=>array('goods_show'=>'0'),'goods_commend'=>array('goods_commend'=>1),'goods_ban'=>array('goods_state'=>'0'));
		$condition_arr = $state[trim($_GET['goods_type'])];
		
		$condition_arr['store_id'] 		= $_SESSION['store_id'];
		$condition_arr['goods_isztc'] 	= '1';
		$condition_arr['keyword']		= trim($_GET['keyword']);
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		//查询直通车列表
		$condition_arr['order'] = ' goods_goldnum ';
		$goods_model = Model('goods');
		$list_goods	= $goods_model->getGoods($condition_arr,$page,'*','goods');
		//信息输出
		self::profile_menu('ztc_glist');
		Tpl::output('show_page',$page->show());
		Tpl::output('list_goods',$list_goods);
		Tpl::output('menu_sign','store_ztc');
		Tpl::output('menu_sign_url','index.php?act=store_ztc&op=ztc_glist');
		Tpl::output('menu_sign1','ztc_glist');
		Tpl::showpage('store_ztc.goodlist');
	}
	/**
	 * 直通车金币日志列表
	 */
	public function ztc_glogOp(){
		$condition_arr = array();
		$condition_arr['glog_storeid'] = "{$_SESSION['store_id']}";
		$condition_arr['glog_goodsname'] = trim($_GET['zg_name']);
		if ($_GET['zg_type']){
			$condition_arr['glog_type'] = $_GET['zg_type'];
		}
		$condition_arr['saddtime'] = strtotime($_GET['zg_stime']);
		$condition_arr['eaddtime'] = strtotime($_GET['zg_etime']);
        if($condition_arr['eaddtime'] > 0) {
            $condition_arr['eaddtime'] += 86400;
        }
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		//查询直通车列表
		$ztcgoldlog_model = Model('ztc_glodlog');
		$list_log = $ztcgoldlog_model->getLogList($condition_arr,$page,'*','');
		//信息输出
		self::profile_menu('ztc_glog');
		Tpl::output('show_page',$page->show());
		Tpl::output('list_log',$list_log);
		Tpl::output('menu_sign','store_ztc');
		Tpl::output('menu_sign_url','index.php?act=store_ztc&op=ztc_glog');
		Tpl::output('menu_sign1','ztc_glog');
		Tpl::showpage('store_ztc.glog');
	}
	/**
	 * 更新单条直通车商品状态
	 */
	public function ztc_gstateOp(){
		$id = 0;
		if (intval($_POST['gid']) > 0) $id = intval($_POST['gid']);		
		//查询商品信息
		$goods_model = Model('goods');
		$condition_arr = array();
		$condition_arr['goods_id_in'] = $id;
		$condition_arr['store_id'] 		= $_SESSION['store_id'];
		$goods_list	= $goods_model->getGoods($condition_arr,'','*','goods');
		if(!empty($goods_list) && is_array($goods_list)) {
			//判断是开启还是关闭
			$ztcstate= 2;
			if ($_POST['type'] == 'open'){
				$ztcstate= 1;
			}
			$id_new = array();
			foreach ($goods_list as $v){
				//判断如果商品直通车状态已经更新过了，则不再重复更新
				if ($v['goods_ztcstate'] != $ztcstate){
					$id_new[] = $v['goods_id'];
				}
			}
			//更新记录存在
			if (is_array($id_new)){
				$up_arr = array();
				if ($ztcstate == 2){
					//中止商品直通车时，更新商品表中直通车金币信息，并记录日志
					$ztc_model = Model('ztc');
					$ztc_model->updateZtcGoods(Language::get('store_ztc_glist_glog_desc'),$_SESSION['store_id'],$id_new);
					//更新商品表的直通车状态
					$up_arr['goods_ztcstate'] = 2;
				}else {
					//开启直通车时，更新商品表的直通车状态及最后扣除金币时间为当前时间
					$up_arr['goods_ztcstate'] = 1;
					$datetime = date('Y-m-d',time());
					$datetime = strtotime($datetime);
					$up_arr['goods_ztclastdate'] = $datetime;
				}
				$result = $goods_model->updateGoodsAllUser($up_arr,$id_new);
			}
		}
		if ($result) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @param array 	$array		附加菜单
	 * @return 
	 */
	private function profile_menu($menu_key='',$array=array()) {
		Language::read('member_layout');
		$lang	= Language::getLangContent();
		$menu_array		= array();
		$menu_array = array(
			1=>array('menu_key'=>'ztc_list',	'menu_name'=>$lang['nc_member_path_ztc_list'],	'menu_url'=>'index.php?act=store_ztc&op=ztc_list'),
//			2=>array('menu_key'=>'ztc_add',		'menu_name'=>$lang['nc_member_path_ztc_add'],	'menu_url'=>'index.php?act=store_ztc&op=ztc_add'),
			2=>array('menu_key'=>'ztc_glist',	'menu_name'=>$lang['nc_member_path_ztc_glist'],	'menu_url'=>'index.php?act=store_ztc&op=ztc_glist'),
			3=>array('menu_key'=>'ztc_glog',	'menu_name'=>$lang['nc_member_path_ztc_glog'],	'menu_url'=>'index.php?act=store_ztc&op=ztc_glog'),
		);
		if ($_GET['op'] == 'ztc_add'){
			$menu_array = array_merge($menu_array,array(4=>array('menu_key'=>'ztc_add',		'menu_name'=>$lang['nc_member_path_ztc_add'],	'menu_url'=>'index.php?act=store_ztc&op=ztc_add')));
		}elseif ($_GET['op'] == 'edit_ztc'){
			$menu_array = array_merge($menu_array,array(4=>array('menu_key'=>'edit_ztc',		'menu_name'=>$lang['store_ztc_index_edit_content'],	'menu_url'=>'index.php?act=store_ztc&op=edit_ztc&z_id='.intval($_GET['z_id']))));
		}

		if(!empty($array)) {
			$menu_array[] = $array;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
