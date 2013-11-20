<?php
/**
 * 商品栏目管理
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
class ztc_classControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('ztc,setting');
		
		//如果是执行开启直通车操作，直接返回
		if ($_GET['ztc_open'] == 1) return true;
		
		/**
		 * 判断系统是否开启直通车和金币功能
		 */
		if (C('gold_isuse')!= 1 || C('ztc_isuse') != 1){
			$url = array(
				array(
					'url'=>'index.php?act=dashboard&op=welcome',
					'msg'=>Language::get('close'),
				),	
				array(
					'url'=>'index.php?act=ztc_class&op=ztc_setting&ztc_open=1',
					'msg'=>Language::get('open'),
				),
			);
			showMessage(Language::get('admin_ztc_unavailable'),$url,'html','succ',1,6000);
		}
	}
	/**
	 * 直通车设置
	 */
	public function ztc_settingOp(){
		/**
		 * 读取语言包
		 */
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_setting = Model('setting');
		/**
		 * 保存信息
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["ztc_isuse"], "require"=>"true","message"=>$lang['ztc_isuse_check']),
				array("input"=>$_POST["ztc_dayprod"], "require"=>"true", "validator"=>"Number", "message"=>$lang['ztc_dayprod_isnum'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/**
				 * 修改直通车配置信息时先更新商品表中直通车金币数，防止更新滞后引起的金币扣除错误
				 */
				//更新商品表中直通车金币信息，并记录日志
				Language::read('ztc');
				$ztc_model = Model('ztc');
				$ztc_model->updateZtcGoods(Language::get('admin_ztc_glist_glog_desc'));

				/*
				 * 构造更新数据数组
				 */
				$update_array = array();
				$update_array['ztc_isuse'] = trim($_POST['ztc_isuse']);
				$update_array['ztc_dayprod'] = trim($_POST['ztc_dayprod']);

				$result = $model_setting->updateSetting($update_array);
				if ($result === true){
					showMessage($lang['edit_ztc_set_ok']);
				}else {
					showMessage($lang['edit_ztc_set_fail']);
				}
			}
		}
		
		//自动开启直通车
		if ($_GET['ztc_open'] == 1){
			$update_array = array();
			$update_array['ztc_isuse'] = 1;
			$update_array['gold_isuse'] = 1;
			$model_setting->updateSetting($update_array);	
		}
		
		/**
		 * 读取设置内容 $list_setting
		 */
		$list_setting = $model_setting->getListSetting();
		/**
		 * 模板输出
		 */
		Tpl::output('list_setting',$list_setting);
		Tpl::showpage('setting.ztc_setting');
	}	
	/**
	 * 直通车申请列表
	 */
	public function ztc_classOp(){
		//条件
		$condition_arr = array();
		$sgoodsname = trim($_GET['zg_name']);
		if ($sgoodsname){
			$condition_arr['ztc_goodsname'] = $sgoodsname;			
		}
		unset($sgoodsname);
		if ($_GET['zg_state']){
			$condition_arr['ztc_state'] = intval($_GET['zg_state'])-1;			
		}
		if ($_GET['zg_paystate']){
			$condition_arr['ztc_paystate'] = intval($_GET['zg_paystate'])-1;			
		}
		if ($_GET['zg_type']){
			$condition_arr['ztc_type'] = intval($_GET['zg_type'])-1;			
		}
		$smembername = trim($_GET['zg_membername']);
		if ($smembername){
			$condition_arr['ztc_membername'] = $smembername;			
		}
		unset($smembername);
		$sstorename = trim($_GET['zg_storename']);
		if ($sstorename){
			$condition_arr['ztc_storename'] = $sstorename;			
		}
		unset($sstorename);
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		//查询直通车列表
		$ztc_model = Model('ztc');
		$ztc_list = $ztc_model->getZtcList($condition_arr,$page);
		//信息输出
		Tpl::output('ztc_list',$ztc_list);
		Tpl::output('page',$page->show());
		Tpl::showpage('ztc_class.list');
	}
	/**
	 * 删除直通车申请记录
	 */
	public function drop_ztcOp(){
		$z_id = intval($_GET['z_id']);
		if (!$z_id){
			showMessage(Language::get('admin_ztc_parameter_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		$ztc_model = Model('ztc');
		//查询申请记录是否存在
		$ztc_info = $ztc_model->getZtcInfo(array('ztc_id'=>$z_id));
		if (!is_array($ztc_info) || count($ztc_info)<=0){
			showMessage(Language::get('admin_ztc_record_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		if ($ztc_info['ztc_state'] != 0){
			//showMessage('记录信息已经过后台审核操作，不可删除','index.php?act=ztc_class&op=ztc_class');
			showMessage(Language::get('admin_ztc_drop_reviewed_error'),'index.php?act=ztc_class&op=ztc_class');
		}else {
			if ($ztc_info['ztc_paystate'] != 0){
				//showMessage('记录信息已经支付，请先取消支付，再删除','index.php?act=ztc_class&op=ztc_class');
				showMessage(Language::get('admin_ztc_drop_paid_error'),'index.php?act=ztc_class&op=ztc_class');
			}
		}		
		$result = $ztc_model->dropZtcById($z_id);
		if($result) {
			showMessage(Language::get('admin_ztc_drop_success'),'index.php?act=ztc_class&op=ztc_class');
		} else {
			showMessage(Language::get('admin_ztc_drop_fail'),'index.php?act=ztc_class&op=ztc_class');
		}
	}
	/**
	 * 删除直通车申请记录
	 */
	public function dropall_ztcOp(){
		$z_id = $_POST['z_id'];
		if (!$z_id){
			showMessage(Language::get('admin_ztc_parameter_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		$z_id = "'".implode("','",$z_id)."'";
		$ztc_model = Model('ztc');
		//查询申请记录是否存在
		$ztc_list = $ztc_model->getZtcList(array('ztc_id_in'=>$z_id));
		if (!is_array($ztc_list) || count($ztc_list)<=0){
			showMessage(Language::get('admin_ztc_record_error'),'index.php?act=ztc_class&op=ztc_class');
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
			showMessage(Language::get('admin_ztc_drop_success'),'index.php?act=ztc_class&op=ztc_class');
		} else {
			showMessage(Language::get('admin_ztc_drop_fail'),'index.php?act=ztc_class&op=ztc_class');
		}
	}
	/**
	 * 编辑直通车申请记录
	 */
	public function edit_ztcOp(){
		$z_id = intval($_GET['z_id']);
		if (!$z_id){
			showMessage(Language::get('admin_ztc_parameter_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		$ztc_model = Model('ztc');
		//查询申请记录是否存在
		$ztc_info = $ztc_model->getZtcInfo(array('ztc_id'=>$z_id));
		if (!is_array($ztc_info) || count($ztc_info)<=0){
			showMessage(Language::get('admin_ztc_record_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		//申请信息未支付，不可编辑
		if ($ztc_info['ztc_paystate'] == 0){
			//showMessage('记录信息未支付，不可再编辑','index.php?act=ztc_class&op=ztc_class');
			showMessage(Language::get('admin_ztc_edit_paid_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		//申请信息已经过审核操作，不可编辑
		if ($ztc_info['ztc_state'] != 0){
			//showMessage('记录信息已经过后台审核操作，不可再编辑','index.php?act=ztc_class&op=ztc_class');
			showMessage(Language::get('admin_ztc_edit_reviewed_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		//充值记录，不可编辑
		if ($ztc_info['ztc_type'] != 0){
			//showMessage('充值记录，不可编辑','index.php?act=ztc_class&op=ztc_class');
			showMessage(Language::get('admin_ztc_edit_recharge_unedit_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 信息验证
			 */
			$starttime = strtotime($_POST['ztc_stime']);
			$datetime = date('Y-m-d',time());
			$datetime = strtotime($datetime);
			$obj_validate = new Validate();
			$validate_arr = array();
			$validate_arr[] = array("input"=>$starttime,"require"=>"true","validator"=>"Compare","operator"=>' >= ','to'=>$datetime,"message"=>Language::get('admin_ztc_edit_starttime_error'));
			$obj_validate -> validateparam = $validate_arr;
			$error = $obj_validate->validate();			
			if ($error != ''){
				showMessage($error);
			}
			$ztc_model = Model('ztc');
			
			//查询商品信息
			$goods_model = Model('goods');
			$goods_info = $goods_model->checkGoods(array('goods_id'=>$ztc_info['ztc_goodsid']));			
			if (!is_array($goods_info) || count($goods_info)<=0){
				showMessage(Language::get('admin_ztc_goodsrecord_error'));
			}
			//通过审核操作
			if ($_POST['ztc_state'] == 1){
				//验证商品是否为直通车商品
				if ($goods_info['goods_isztc'] == 1){
					//showMessage("该记录商品已经是直通车商品，请查看直通车商品记录");
					showMessage(Language::get('admin_ztc_edit_goodsztc_exist_error'));
				}
			}
			//修改直通车申请
			$ztc_array	= array();
			$ztc_array['ztc_startdate']	= strtotime($_POST['ztc_stime']);
			$ztc_array['ztc_state']	= $_POST['ztc_state'];
			$result = $ztc_model->updateZtcOne($ztc_array,array('ztc_id'=>$z_id));
			if($result) {
				//通过审核操作
				if ($_POST['ztc_state'] == 1){
					//修改商品表直通车信息
					$newgoods_goldnum = intval($goods_info['goods_goldnum']) + intval($ztc_info['ztc_gold']);
					$g_up_arr = array();
					$g_up_arr['goods_goldnum'] = $newgoods_goldnum;
					$g_up_arr['goods_isztc'] = 1;
					$g_up_arr['goods_ztcstartdate'] = strtotime($_POST['ztc_stime']);
					$g_up_arr['goods_ztclastdate'] = $g_up_arr['goods_ztcstartdate']-3600*24;//初始化扣除金币时间为开始时间减去一天
					$g_up_result = $goods_model->updateGoodsAllUser($g_up_arr,$ztc_info['ztc_goodsid']);
					unset($g_up_arr);
					
					//记录直通车商品金币日志
					if ($g_up_result){
						//记录直通车消费日志
						$ztcgoldlog_model = Model('ztc_glodlog');
						$logarr = array();
						$logarr['glog_goodsid'] = $ztc_info['ztc_goodsid'];
						$logarr['glog_goodsname'] = $ztc_info['ztc_goodsname'];
						$logarr['glog_memberid'] = $ztc_info['ztc_memberid'];
						$logarr['glog_membername'] = $ztc_info['ztc_membername'];
						$logarr['glog_storeid'] = $ztc_info['ztc_storeid'];
						$logarr['glog_storename'] = $ztc_info['ztc_storename'];
						$logarr['glog_type'] = 1;//增加
						$logarr['glog_goldnum'] = intval($ztc_info['ztc_gold']);
						$logarr['glog_addtime'] = time();
						//$logarr['glog_desc'] = '直通车商品增加消耗金币数';
						$logarr['glog_desc'] = Language::get('admin_ztc_ztclog_addgold');
						$ztcgoldlog_model->addlog($logarr);
						unset($logarr);
					}
				}
				//通过审核失败操作
				if ($_POST['ztc_state'] == 2){
					//返还会员账户金币，修改用户金币信息
					$member_model = Model('member');
					$member_array = $member_model->infoMember(array('member_id'=>$ztc_info['ztc_memberid']));
					$newmember_goldnum = intval($member_array['member_goldnum']) + intval($ztc_info['ztc_gold']);
					$newmember_goldnumminus = intval($member_array['member_goldnumminus']) - intval($ztc_info['ztc_gold']);
					$member_model->updateMember(array('member_goldnum'=>$newmember_goldnum,'member_goldnumminus'=>$newmember_goldnumminus),$ztc_info['ztc_memberid']);
					
					//添加金币日志
					$goldlog_model = Model('gold_log');
					$insert_goldlog = array();
					$insert_goldlog['glog_memberid'] = $ztc_info['ztc_memberid'];
					$insert_goldlog['glog_membername'] = $ztc_info['ztc_membername'];
					$insert_goldlog['glog_storeid'] = $ztc_info['ztc_storeid'];;
					$insert_goldlog['glog_storename'] = $ztc_info['ztc_storename'];
					$admininfo = $this->getAdminInfo();
					$insert_goldlog['glog_adminid'] = $admininfo['id'];
					$insert_goldlog['glog_adminname'] = $admininfo['name'];
					$insert_goldlog['glog_goldnum'] = $ztc_info['ztc_gold'];
					$insert_goldlog['glog_method'] = 1;//增加
					$insert_goldlog['glog_addtime'] = time();
					//$insert_goldlog['glog_desc'] = '申请参加直通车失败返还金币';
					$insert_goldlog['glog_desc'] = Language::get('admin_ztc_edit_goldlog_addgold');
					$insert_goldlog['glog_stage'] = 'ztc';
					$goldlog_model->add($insert_goldlog);
				}
				showMessage(Language::get('admin_ztc_edit_success'),'index.php?act=ztc_class&op=ztc_class');
			} else {
				showMessage(Language::get('admin_ztc_edit_fail'),'index.php?act=ztc_class&op=ztc_class');
			}
		} else {
			Tpl::output('ztc_info',$ztc_info);
			Tpl::output('nowdate',date('Y-m-d',time()));
			Tpl::showpage('ztc_class.form');
		}
	}
	/**
	 * 编辑直通车申请记录
	 */
	public function info_ztcOp(){
		$z_id = intval($_GET['z_id']);
		if (!$z_id){
			showMessage(Language::get('admin_ztc_parameter_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		$ztc_model = Model('ztc');
		//查询申请记录是否存在
		$ztc_info = $ztc_model->getZtcInfo(array('ztc_id'=>$z_id));
		if (!is_array($ztc_info) || count($ztc_info)<=0){
			showMessage(Language::get('admin_ztc_record_error'),'index.php?act=ztc_class&op=ztc_class');
		}
		Tpl::output('ztc_info',$ztc_info);
		Tpl::showpage('ztc_class.info');
	}
	/**
	 * 直通车商品列表
	 */
	public function ztc_glistOp(){
		//更新商品表中直通车金币信息，并记录日志
		$ztc_model = Model('ztc');
		$ztc_model->updateZtcGoods(Language::get('admin_ztc_glist_glog_desc'));
		
		$condition_arr = array();
		$state		= array('goods_open'=>array('goods_show'=>1),'goods_close'=>array('goods_show'=>'0'),'goods_commend'=>array('goods_commend'=>1),'goods_ban'=>array('goods_state'=>'0'));
		$condition_arr = $state[trim($_GET['goods_type'])];
		$condition_arr['goods_isztc'] 	= '1';
		$condition_arr['keyword']		= trim($_GET['zg_name']);
		$condition_arr['like_store_name'] = trim($_GET['zg_sname']); //店铺名称
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		//查询直通车列表
		$condition_arr['order'] = ' goods_goldnum ';
		$goods_model = Model('goods');
		$list_goods	= $goods_model->getGoods($condition_arr,$page,'*','store');
		//信息输出
		Tpl::output('show_page',$page->show());
		Tpl::output('list_goods',$list_goods);
		Tpl::showpage('ztc_class.goodlist');
	}
	/**
	 * 直通车金币日志列表
	 */
	public function ztc_glogOp(){
		$condition_arr = array();
		$condition_arr['glog_goodsname'] = trim($_GET['zg_name']);
		$condition_arr['glog_storename'] = trim($_GET['zg_sname']);
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
		Tpl::output('show_page',$page->show());
		Tpl::output('list_log',$list_log);
		Tpl::showpage('ztc_class.glog');
	}
	/**
	 * 更新单条直通车商品状态
	 */
	public function ztc_gstateOp(){
		$type_array = array('open','close');
		if (!$_POST['gid'] || !in_array($_POST['type'],$type_array)){
			showMessage(Language::get('admin_ztc_parameter_error'),'index.php?act=ztc_class&op=ztc_glist');
		}
		if (count($_POST['gid'])<=0){
			//showMessage('请选择更新的商品信息','index.php?act=ztc_class&op=ztc_glist');
			showMessage(Language::get('admin_ztc_gstate_choose_error'),'index.php?act=ztc_class&op=ztc_glist');
		}
		$id = $_POST['gid'];		
		//查询商品信息
		$goods_model = Model('goods');
		$condition_arr = array();
		$condition_arr['goods_id_in'] = "'".implode("','",$id)."'";
		$goods_list	= $goods_model->getGoods($condition_arr,'','*','goods');
		if (!is_array($goods_list) || count($goods_list)<=0){
			showMessage(Language::get('admin_ztc_goodsrecord_error'),'index.php?act=ztc_class&op=ztc_glist');
		}
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
		//更新记录不存在，则不再更新
		if (!is_array($id_new) || count($id_new)<=0){
			showMessage(Language::get('admin_ztc_gstate_success'),'index.php?act=ztc_class&op=ztc_glist');
		}
		$up_arr = array();
		if ($ztcstate == 2){
			//中止商品直通车时，更新商品表中直通车金币信息，并记录日志
			$ztc_model = Model('ztc');
			$ztc_model->updateZtcGoods(Language::get('admin_ztc_glist_glog_desc'),'',$id_new);
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
		if ($result) {
			showMessage(Language::get('admin_ztc_gstate_success'),'index.php?act=ztc_class&op=ztc_glist');
		} else {
			showMessage(Language::get('admin_ztc_gstate_fail'),'index.php?act=ztc_class&op=ztc_glist');
		}
	}
}
