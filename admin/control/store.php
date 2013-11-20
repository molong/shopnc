<?php
/**
 * 店铺管理界面
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class storeControl extends SystemControl{
	const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();
		Language::read('store');
	}
	/**
	 * 店铺
	 */
	public function storeOp(){
		/**
		 * 读取语言包
		 */
		$lang = Language::getLangContent();

		$model_store = Model('store');

		/**
		 * 检索条件
		 */
		if(trim($_GET['owner_and_name']) != ''){
			$condition['member_name']	= array('like', '%'.trim($_GET['owner_and_name']).'%');
			Tpl::output('owner_and_name',trim($_GET['owner_and_name']));
		}
		if(trim($_GET['store_name']) != ''){
			$condition['store_name']	= array('like', '%'.trim($_GET['store_name']).'%');
			Tpl::output('store_name',trim($_GET['store_name']));
		}
		if(intval($_GET['grade_id']) > 0){
			$condition['grade_id']		= intval($_GET['grade_id']);
			Tpl::output('grade_id',intval($_GET['grade_id']));
		}
		$condition['store_state']		= array('in', array('0','1'));
		
		/**
		 * 店铺列表
		 */
		$store_list = $model_store->where($condition)->order('store_sort asc')->page(10)->select();
		/**
		 * 需要用到的缓存或者数据内容
		 */
		/**
		 * 店铺等级
		 */
		$model_grade = Model('store_grade');
		$grade_list = $model_grade->getGradeList($condition);
		if (!empty($grade_list)){
			$search_grade_list = array();
			foreach ($grade_list as $k => $v){
				$search_grade_list[$v['sg_id']] = $v['sg_name'];
			}
		}
		/**
		 * 整理内容
		 */
		if(!empty($store_list)){
			foreach ($store_list as $k => $v){
				/**
				 * 店铺等级
				 */
				$store_list[$k]['grade_name'] = $search_grade_list[$v['grade_id']];
				/**
				 * 店铺状态
				 */
				$store_list[$k]['state'] = ($v['store_state'] == 1)?$lang['open']:$lang['close'];
				/**
				 * 结束时间
				 */
				$store_list[$k]['store_end_time'] = $v['store_end_time']?date('Y-m-d',$v['store_end_time']):$lang['no_limit'];
			}
		}

		Tpl::output('grade_list',$grade_list);
		Tpl::output('store_list',$store_list);
		Tpl::output('page',$model_store->showpage('2'));
		Tpl::showpage('store.index');
	}

	/**
	 * 新增店铺
	 */
	public function store_addOp(){
		/**
		 * 读取语言包
		 */
		$lang = Language::getLangContent();

		$model_store = Model('store');
		if (chksubmit()){
			/**
			 * 添加第一步 验证会员是否存在
			 */
			if ($_POST['step'] == 'one'){
				/**
				 * 验证
				 */
				$obj_validate = new Validate();
				$obj_validate->setValidate(array("input"=>$_POST["member_name"], "require"=>"true", "message"=>$lang['user_name_no_null']));
				if ($_POST['need_password'] == 1){
					$obj_validate->setValidate(array("input"=>$_POST["member_passwd"], "require"=>"true", "message"=>$lang['pwd_no_null']));
				}
				$error = $obj_validate->validate();
				if ($error != ''){
					showMessage($error);
				}else {
					$model_member = Model('member');
					$condition['member_name'] = trim($_POST['member_name']);
					$member_array = $model_member->infoMember($condition);
					/**
					 * 判断该会员是否已经拥有店铺
					 */
					if ($member_array['store_id'] > 0){
						showMessage($lang['user_open_store']);
					}

					if (empty($member_array)){
						showMessage($lang['user_no_exist']);
					}
					if ($_POST['need_password'] == 1){
						if ($member_array['member_passwd'] !== md5($_POST['member_passwd'])){
							showMessage($lang['pwd_fail']);
						}
					}
					/**
					 * 店铺等级
					 */
					$model_grade = Model('store_grade');
					$grade_list = $model_grade->getGradeList($condition);
					/**
					 * 店铺分类
					 */
					$model_store_class = Model('store_class');
					$parent_list = $model_store_class->getTreeClassList(2);
					if (is_array($parent_list)){
						foreach ($parent_list as $k => $v){
							$parent_list[$k]['sc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['sc_name'];
						}
					}
					Tpl::output('class_list',$parent_list);
					Tpl::output('grade_list',$grade_list);
					Tpl::output('member_array',$member_array);
					Tpl::showpage('store.add_two');
				}
			}
			/**
			 * 添加第二步 添加
			 */
			if ($_POST['step'] == 'two'){
				/**
				 * 验证
				 */
				$obj_validate = new Validate();
				$obj_validate->validateparam = array(
				array("input"=>$_POST["store_name"], "require"=>"true", "message"=>$lang['please_input_store_name_p']),
				);
				$error = $obj_validate->validate();
				if ($error != ''){
					showMessage($error);
				}else {
					/**
					 * 取店铺等级的审核
					 */
					$model_grade = Model('store_grade');
					$grade_array = $model_grade->getOneGrade(intval($_POST['grade_id']));
					if (empty($grade_array)){
						showMessage($lang['please_input_store_level']);
					}
					/**
					 * 结束时间
					 */
					if(trim($_POST['end_time']) != '') {
						$time = strtotime($_POST['end_time']);
					}
					$insert_array = array();
					$insert_array['member_name'] = trim($_POST['member_name']);
					$insert_array['member_id'] = intval($_POST['member_id']);
					$insert_array['store_owner_card'] = trim($_POST['store_owner_card']);
					$insert_array['store_name'] = trim($_POST['store_name']);
					$insert_array['sc_id'] = intval($_POST['sc_id']);
					$insert_array['area_id'] = intval($_POST['area_id']);
					$insert_array['area_info'] = trim($_POST['area_info']);
					$insert_array['store_address'] = trim($_POST['store_address']);
					$insert_array['store_zip'] = trim($_POST['store_zip']);
					$insert_array['store_tel'] = trim($_POST['store_tel']);
					$insert_array['grade_id'] = intval($_POST['grade_id']);
					$insert_array['store_end_time'] = $time;
					$insert_array['store_time']	= time();
					$insert_array['store_state'] = trim($_POST['store_state']);
					if ($_POST['store_state'] == '0'){
						$insert_array['store_close_info'] = $_POST['store_close_info'];
						$insert_array['store_recommend'] = 0;
					}else{
						$insert_array['store_recommend'] = trim($_POST['store_recommend']);
					}
					$insert_array['name_auth'] = trim($_POST['name_auth']);
					$insert_array['store_auth'] = trim($_POST['store_auth']);
					$insert_array['store_sort'] = intval($_POST['store_sort']);

					$store_info	= $model_store->shopStore(array('store_name'=>$insert_array['store_name']));
					if($store_info['store_id'] > 0) {//检查店铺名称是否存在
						showMessage($lang['store_name_exists']);
					}
					$result = $model_store->add($insert_array);
					if ($result){
						/**
						 * 更新会员表 store_id 字段
						 */
						$model_member = Model('member');
						$update_array = array();
						$update_array['store_id'] = $result;
						$model_member->updateMember($update_array,intval($_POST['member_id']));
						
						// 生成店铺二维码
						require_once(BasePath.DS.'resource'.DS.'phpqrcode'.DS.'index.php');
						$PhpQRCode	= new PhpQRCode();
						$PhpQRCode->set('date',SiteUrl.DS.ncUrl(array('act'=>'show_store','id'=>$result), 'store'));
						$PhpQRCode->set('pngTempDir',BasePath.DS.ATTACH_STORE.DS);
						$model_store->storeUpdate(array('store_code'=>$PhpQRCode->init(),'store_id'=>$result));
						
						// 添加相册默认
						$album_model = Model('album');
						$album_arr = array();
						$album_arr['aclass_name'] = Language::get('store_save_defaultalbumclass_name');
						$album_arr['store_id'] = $result;
						$album_arr['aclass_des'] = '';
						$album_arr['aclass_sort'] = '255';
						$album_arr['aclass_cover'] = '';
						$album_arr['upload_time'] = time();
						$album_arr['is_default'] = '1';
						$album_model->addClass($album_arr);

						$url = array(
						array(
						'url'=>'index.php?act=store&op=store',
						'msg'=>$lang['back_store_list'],
						),
						array(
						'url'=>'index.php?act=store&op=store_add',
						'msg'=>$lang['countinue_add_store'],
						),
						);
						showMessage($lang['add_store_ok'],$url);
					}else {
						showMessage($lang['add_fail_fail']);
					}
				}
			}
		}
		Tpl::showpage('store.add_one');
	}

	/**
	 * 店铺编辑
	 */
	public function store_editOp(){
		/**
		 * 读取语言包
		 */
		$lang = Language::getLangContent();

		$model_store = Model('store');
		/**
		 * 保存
		 */
		if (chksubmit()){
			/**
			 * 取店铺等级的审核
			 */
			$model_grade = Model('store_grade');
			$grade_array = $model_grade->getOneGrade(intval($_POST['grade_id']));
			if (empty($grade_array)){
				showMessage($lang['please_input_store_level']);
			}
			/**
			 * 结束时间
			 */
			$time	= '';
			if(trim($_POST['end_time']) != ''){
				$time = strtotime($_POST['end_time']);
			}
			$update_array = array();
			$update_array['store_id'] = intval($_POST['store_id']);
			$update_array['store_owner_card'] = trim($_POST['store_owner_card']);
			$update_array['store_name'] = trim($_POST['store_name']);
			$update_array['sc_id'] = intval($_POST['sc_id']);
			$update_array['area_id'] = intval($_POST['area_id']);
			$update_array['area_info'] = trim($_POST['area_info']);
			$update_array['store_address'] = trim($_POST['store_address']);
			$update_array['store_zip'] = trim($_POST['store_zip']);
			$update_array['store_tel'] = trim($_POST['store_tel']);
			$update_array['grade_id'] = intval($_POST['grade_id']);
			$update_array['store_end_time'] = $time;
			$update_array['store_state'] = intval($_POST['store_state']);
			$store_info	= $model_store->shopStore(array('store_name'=>$update_array['store_name']));
			if($store_info['store_id'] > 0 && $store_info['store_id'] != $update_array['store_id']) {//检查店铺名称是否存在
				showMessage($lang['store_name_exists']);
			}
			if ($_POST['store_state'] == '0'){
				/**
				 * 根据店铺状态修改该店铺所有商品状态
				 */
				$model_goods = Model('goods');
				$model_goods->updateGoodsStoreStateByStoreId($update_array['store_id'], 'close');
				$update_array['store_close_info'] = trim($_POST['store_close_info']);
				$update_array['store_recommend'] = 0;
			}else {
				/**
				 * 店铺开启后商品不在自动上架，需要手动操作
				 */
				$update_array['store_close_info'] = '';
				$update_array['store_recommend'] = intval($_POST['store_recommend']);
			}
			$update_array['name_auth'] = intval($_POST['name_auth']);
			$update_array['store_auth'] = intval($_POST['store_auth']);
			$update_array['store_sort'] = intval($_POST['store_sort']);
			$result = $model_store->storeUpdate($update_array);
			if ($result){
				//站内短信息通知
				if ($_POST['store_state'] == 0){
					//获取店铺信息
					$store_info = $model_store->shopStore(array(
						'store_id'=>$_POST['store_id']
					));
					//管理员关闭店铺
					//向店主发送关闭通知消息
					$msg_code = 'msg_toseller_store_closed_notify';
					//内容
					$param = array('reason'=>$_POST['store_close_info']);
					self::send_notice($store_info['member_id'],$msg_code,$param);
				}
				$url = array(
				array(
				'url'=>'index.php?act=store&op=store',
				'msg'=>$lang['back_store_list'],
				),
				array(
				'url'=>'index.php?act=store&op=store_edit&store_id='.intval($_POST['store_id']),
				'msg'=>$lang['countinue_add_store'],
				),
				);
				showMessage($lang['update_store_ok'],$url);
			}else {
				showMessage($lang['update_fail_fail']);
			}
		}
		/**
		 * 取店铺信息
		 */
		$condition['store_id'] = intval($_GET['store_id']);
		$store_array = $model_store->shopStore($condition);
		if (empty($store_array)){
			showMessage($lang['store_no_exist']);
		}
		/**
		 * 整理店铺内容
		 */
		$store_array['store_end_time'] = $store_array['store_end_time']?date('Y-m-d',$store_array['store_end_time']):'';
		/**
		 * 店铺分类
		 */
		$model_store_class = Model('store_class');
		$parent_list = $model_store_class->getTreeClassList(2);
		if (is_array($parent_list)){
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['sc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['sc_name'];
			}
		}
		/**
		 * 店铺等级
		 */
		$model_grade = Model('store_grade');
		$grade_list = $model_grade->getGradeList();
		Tpl::output('grade_list',$grade_list);
		Tpl::output('class_list',$parent_list);
		Tpl::output('store_array',$store_array);
		Tpl::showpage('store.edit');
	}

	/**
	 * 店铺 待审核列表
	 */
	public function store_auditOp(){
		/**
		 * 读取语言包
		 */
		$lang = Language::getLangContent();
		
		$model_store = Model('store');
		/**
		 * 拒绝
		 */
		if ($_GET['type'] == 'del'){
			$model_member = Model('member');
			$v = intval($_GET['id']);
			if ($v > 0){
				/**
				 * 店铺信息
				 */
				$condition['store_id'] = $v;
				$store_array = $model_store->shopStore($condition);
				$model_store->del($v);
				/**
				 * 更新会员店铺ID
				 */
				$result = $model_member->updateMember(array('store_id'=>0),$store_array['member_id']);
				if ($result){
					//向店主发送通知消息
					$msg_code = 'msg_toseller_store_refused_notify';
					//内容
					$param = array(
						'reason'=>$lang['store_no_meet']
					);
					self::send_notice($store_array['member_id'],$msg_code,$param);
				}
			}	
			showMessage($lang['operation_ok']);
		}
		/**
		 * 通过
		 */
		if ($_POST['form_submit'] == 'ok'){
			if (!empty($_POST['del_id'])){
				/**
				 * 通过
				 */
				if ($_POST['type'] == 'ok'){
					foreach ($_POST['del_id'] as $k => $v){
						$v = intval($v);
						$update_array = array();
						$update_array['store_id'] = $v;
						$update_array['store_state'] = 1;
						$result = $model_store->storeUpdate($update_array);
						if ($result){
							$store_info = $model_store->shopStore(array(
								'store_id'=>$v
							));
							//向店主发送通知消息
							$msg_code = 'msg_toseller_store_passed_notify';
							//内容
							$param = array();
							self::send_notice($store_info['member_id'],$msg_code,$param);
						}
					}
					unset($model_store);
				}
				showMessage($lang['operation_ok']);
			}else {
				showMessage($lang['please_sel_store']);
			}
		}
		if(trim($_GET['onwer_and_name']) != ''){
			$condition['member_name']	= array('like','%'.trim($_GET['owner_and_name']).'%');
		}
		if(trim($_GET['store_name']) != ''){
			$condition['store_name']	= array('like','%'.trim($_GET['store_name']).'%');
		}
		if(intval($_GET['grade_id']) > 0){
			$condition['grade_id']		= intval($_GET['grade_id']);
		}
		/**
		 * 店铺列表
		 */
		$condition['store_state'] = 2;
		$store_list = $model_store->where($condition)->page(10)->select();
		/**
		 * 需要用到的缓存或者数据内容
		 */
		/**
		 * 店铺等级
		 */
		$model_grade = Model('store_grade');
		$grade_list = $model_grade->getGradeList($condition);
		if (!empty($grade_list)){
			$search_grade_list = array();
			foreach ($grade_list as $k => $v){
				$search_grade_list[$v['sg_id']] = $v['sg_name'];
			}
		}
		/**
		 * 整理内容
		 */
		if(!empty($store_list)){
			foreach ($store_list as $k => $v){
				/**
				 * 店铺等级
				 */
				$store_list[$k]['grade_name'] = $search_grade_list[$v['grade_id']];
				/**
				 * 店铺状态
				 */
				$store_list[$k]['state'] = ($v['store_state'] == 1)?$lang['open']:$lang['close'];
				/**
				 * 结束时间
				 */
				$store_list[$k]['store_end_time'] = $v['store_end_time']?date('Y-m-d',$v['store_end_time']):$lang['no_limit'];
			}
		}

		Tpl::output('grade_list',$grade_list);
		Tpl::output('store_list',$store_list);
		Tpl::output('page',$model_store->showpage('2'));
		Tpl::showpage('store.audit');
	}
	
	/**
	 * 审核详细页
	 */
	public function store_auditinfoOp(){
		/**
		 * 读取语言包
		 */
		$lang = Language::getLangContent();
	
		$model_store = Model('store');
		/**
		 * 保存
		 */
		if (chksubmit()){
			/**
			 * 取店铺等级的审核
			 */
			$model_grade = Model('store_grade');
			$grade_array = $model_grade->getOneGrade(intval($_POST['grade_id']));
			if (empty($grade_array)){
				showMessage($lang['please_input_store_level']);
			}
			/**
			 * 结束时间
			 */
			$time	= '';
			if(trim($_POST['end_time']) != ''){
				$time = strtotime($_POST['end_time']);
			}
			$update_array = array();
			$update_array['store_id'] = intval($_POST['store_id']);
			$update_array['store_owner_card'] = trim($_POST['store_owner_card']);
			$update_array['store_name'] = trim($_POST['store_name']);
			$update_array['sc_id'] = intval($_POST['sc_id']);
			$update_array['area_id'] = intval($_POST['area_id']);
			$update_array['area_info'] = trim($_POST['area_info']);
			$update_array['store_address'] = trim($_POST['store_address']);
			$update_array['store_zip'] = trim($_POST['store_zip']);
			$update_array['store_tel'] = trim($_POST['store_tel']);
			$update_array['grade_id'] = intval($_POST['grade_id']);
			$update_array['store_end_time'] = $time;
			$update_array['store_state'] = intval($_POST['store_state']);
			$store_info	= $model_store->shopStore(array('store_name'=>$update_array['store_name']));
			if($store_info['store_id'] > 0 && $store_info['store_id'] != $update_array['store_id']) {//检查店铺名称是否存在
				showMessage($lang['store_name_exists']);
			}
			if (intval($_POST['store_state']) == 0){
				/**
				 * 根据店铺状态修改该店铺所有商品状态
				 */
				$model_goods = Model('goods');
				$model_goods->updateGoodsStoreStateByStoreId($update_array['store_id'], 'close');
				$update_array['store_close_info'] = trim($_POST['store_close_info']);
				$update_array['store_recommend'] = 0;
			}else {
				/**
				 * 店铺开启后商品不在自动上架，需要手动操作
				 */
				$update_array['store_close_info'] = '';
				$update_array['store_recommend'] = intval($_POST['store_recommend']);
			}
			$update_array['name_auth'] = intval($_POST['name_auth']);
			$update_array['store_auth'] = intval($_POST['store_auth']);
			$update_array['store_sort'] = intval($_POST['store_sort']);
			$result = $model_store->storeUpdate($update_array);
			if ($result){
				//站内短信息通知
				if ($_POST['store_state'] == 0){
					//获取店铺信息
					$store_info = $model_store->shopStore(array(
							'store_id'=>$_POST['store_id']
					));
					//管理员关闭店铺
					//向店主发送关闭通知消息
					$msg_code = 'msg_toseller_store_closed_notify';
					//内容
					$param = array('reason'=>$_POST['store_close_info']);
					self::send_notice($store_info['member_id'],$msg_code,$param);
				}
				$url = array(
						array(
								'url'=>'index.php?act=store&op=store',
								'msg'=>$lang['back_store_list'],
						),
						array(
								'url'=>'index.php?act=store&op=store_edit&store_id='.intval($_POST['store_id']),
								'msg'=>$lang['countinue_add_store'],
						),
				);
				showMessage($lang['update_store_ok'],$url);
			}else {
				showMessage($lang['update_fail_fail']);
			}
		}
		/**
		 * 取店铺信息
		 */
		$condition['store_id'] = intval($_GET['store_id']);
		$store_array = $model_store->shopStore($condition);
		if (empty($store_array)){
			showMessage($lang['store_no_exist']);
		}
		/**
		 * 整理店铺内容
		 */
		$store_array['store_end_time'] = $store_array['store_end_time']?date('Y-m-d',$store_array['store_end_time']):'';
		/**
		 * 店铺分类
		 */
		$model_store_class = Model('store_class');
		$parent_list = $model_store_class->getTreeClassList(2);
		if (is_array($parent_list)){
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['sc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['sc_name'];
			}
		}
		/**
		 * 店铺等级
		 */
		$model_grade = Model('store_grade');
		$grade_list = $model_grade->getGradeList();
		Tpl::output('grade_list',$grade_list);
		Tpl::output('class_list',$parent_list);
		Tpl::output('store_array',$store_array);
		Tpl::showpage('store.auditinfo');
	}
	

	/**
	 * 店铺删除
	 */
	public function store_delOp(){
		/**
		 * 读取语言包
		 */
		$lang = Language::getLangContent();
		
		if (intval($_GET['store_id']) > 0){
			$model_store = Model('store');
			$model_goods = Model('goods');
			$model_member = Model('member');
			$model_album = Model('album');

			/**
			 * 店铺信息
			 */
			$condition['store_id'] = intval($_GET['store_id']);
			$store_array = $model_store->shopStore($condition);
			/**
			 * 更新会员店铺ID
			 */
			$update_array = array();
			$update_array['store_id'] = 0;
			$model_member->updateMember($update_array,$store_array['member_id']);
			/**
			 * 删除店铺，商品
			 */
			//删除店铺
			$model_store->del(intval($_GET['store_id']));
			//删除商品
			$model_goods->dropGoodsByStore(intval($_GET['store_id']));
			/**
			 * 删除用户收藏店铺
			 */
			$model_store->favorites_store_del(intval($_GET['store_id']));
			/**
			 * 删除图片空间
			 */
			$model_album->delAlbum($_GET['store_id']);
			
			//向店主发送通知消息
			$msg_code = 'msg_toseller_store_droped_notify';
			//内容
			$param = array();
			self::send_notice($store_array['member_id'],$msg_code,$param);
			showMessage($lang['del_store_ok']);
		}else {
			showMessage($lang['please_sel_del_store']);
		}
	}

	/**
	 * 批量编辑
	 */
	public function store_batch_editOp(){
		/**
		 * 读取语言包
		 */
		$lang = Language::getLangContent();
		
		$model_store = Model('store');
		/**
		 * 通过，拒绝
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->setValidate(array("input"=>$_POST["id"], "require"=>"true", "message"=>$lang['please_sel_edit_store']));
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$id_array = explode('|',$_POST['id']);
				if (empty($id_array)){
					showMessage($lang['please_sel_edit_store'],'index.php?act=store&op=store');
				}
				$update_array = array();
				if (!empty($_POST['area_id'])){
					$update_array['area_id'] = intval($_POST['area_id']);
					$update_array['area_info'] = trim($_POST['area_info']);
				}
				if (!empty($_POST['grade_id'])){
					$update_array['grade_id'] = intval($_POST['grade_id']);
				}
				if ($_POST['certification'] == 1){
					$update_array['name_auth'] = intval($_POST['name_auth']);
					$update_array['store_auth'] = intval($_POST['store_auth']);
				}
				if ($_POST['store_recommend'] >= 0){
					$update_array['store_recommend'] = intval($_POST['store_recommend']);
				}
				if (!empty($_POST['store_sort'])){
					$update_array['store_sort'] = intval($_POST['store_sort']);
				}
				if (is_array($id_array)){
					foreach ($id_array as $k => $v){
						$update_array['store_id'] = $v;
						$model_store->storeUpdate($update_array);
					}
				}
				showMessage($lang['store_batch_del_ok'],'index.php?act=store&op=store');
			}
		}
		if (empty($_GET['id'])){
			showMessage($lang['please_sel_edit_store']);
		}
		/**
		 * 店铺等级
		 */
		$model_grade = Model('store_grade');
		$grade_list = $model_grade->getGradeList();
		Tpl::output('grade_list',$grade_list);
		Tpl::output('id',$_GET['id']);
		Tpl::showpage('store.batch_edit');
	}
	/**
	 * 批量通过认证
	 */
	public function store_batch_authOp(){
		/**
		 * 验证
		 */
		$obj_validate = new Validate();
		$obj_validate->setValidate(array("input"=>$_GET["id"], "require"=>"true", "message"=>Language::get('please_sel_pass_auth_store')));
		$error = $obj_validate->validate();
		if ($error != ''){
			showMessage($error);
		}else {
			$id_array = explode('|',$_GET['id']);
			if (empty($id_array)){
				showMessage(Language::get('please_sel_pass_auth_store'),'index.php?act=store&op=store_auth');
			}
			$update = array();
			$update['store_id']		= array('in',$id_array);
			$update['store_auth']	= 1;
			$update['name_auth']	= 1;
			Model()->table('store')->update($update);
			showMessage(Language::get('nc_common_op_succ'),'index.php?act=store&op=store_auth');
		}
	}
	/**
	 * 二级域名设置
	 *
	 * @param
	 * @return
	 */
	public function store_domain_settingOp(){
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
		if (chksubmit()){
			$update_array = array();
			$update_array['enabled_subdomain'] = intval($_POST['enabled_subdomain']);
			$update_array['subdomain_suffix'] = trim($_POST['subdomain_suffix']);
			$update_array['subdomain_reserved'] = trim($_POST['subdomain_reserved']);
			$update_array['subdomain_length'] = trim($_POST['subdomain_length']);
			$update_array['subdomain_edit'] = intval($_POST['subdomain_edit']);
			$update_array['subdomain_times'] = intval($_POST['subdomain_times']);
			$subdomain_length = explode('-',$update_array['subdomain_length']);
			$subdomain_length[0] = intval($subdomain_length[0]);
			$subdomain_length[1] = intval($subdomain_length[1]);
			if ($subdomain_length[0] < 1 || $subdomain_length[0] >= $subdomain_length[1]){//域名长度
				$update_array['subdomain_length'] = '3-12';
			}
			$result = $model_setting->updateSetting($update_array);
			if ($result === true){
				showMessage($lang['nc_common_save_succ']);
			}else {
				showMessage($lang['nc_common_save_fail']);
			}
		}
		/**
		 * 读取设置内容 $list_setting
		 */
		$list_setting = $model_setting->getListSetting();
		/**
		 * 模板输出
		 */
		Tpl::output('list_setting',$list_setting);
		Tpl::showpage('store_domain.setting');
	}

	/**
	 * 店铺二级域名列表
	 */
	public function store_domain_listOp(){
		/**
		 * 读取语言包
		 */
		$lang = Language::getLangContent();
		/**
		 * 店铺列表
		 */
		$condition = array();
		$condition['store_state']	= array('neq', 2);
		if(trim($_GET['store_name']) != ''){
			$condition['store_name']	= array('like', '%'.trim($_GET['store_name']).'%');
		}
		if(trim($_GET['store_domain']) != ''){
			$condition['store_domain']	= array(array('neq', ''), array('like', '%'.trim($_GET['store_domain']).'%'), 'and');
		}else{
			$condition['store_domain']	= array('neq', '');
		}
		$model_store = Model('store');
		$store_list = $model_store->where($condition)->order('store_sort asc')->page(10)->select();
		
		if(!empty($store_list)){
			foreach ($store_list as $k => $v){
				/**
				 * 店铺状态
				 */
				$store_list[$k]['state'] = ($v['store_state'] == 1)?$lang['open']:$lang['close'];
			}
		}
		Tpl::output('store_list',$store_list);
		Tpl::output('page',$model_store->showpage('2'));
		Tpl::showpage('store_domain.index');
	}

	/**
	 * 二级域名编辑
	 */
	public function store_domain_editOp(){
		
		/**
		 * 取店铺信息
		 */
		$condition = array();
		$condition['store_id'] = intval($_GET['store_id']);
		$model_store = Model('store');
		$store_array = $model_store->shopStore($condition);
		
		$setting_config = $GLOBALS['setting_config'];
		$subdomain_times = intval($setting_config['subdomain_times']);//系统设置二级域名可修改次数
		$subdomain_length = explode('-',$setting_config['subdomain_length']);
		$subdomain_length[0] = intval($subdomain_length[0]);
		$subdomain_length[1] = intval($subdomain_length[1]);
		if ($subdomain_length[0] < 1 || $subdomain_length[0] >= $subdomain_length[1]){//域名长度
			$subdomain_length[0] = 3;
			$subdomain_length[1] = 12;
		}
		Tpl::output('subdomain_length',$subdomain_length);
		/**
		 * 保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			$store_domain_times = intval($_POST['store_domain_times']);//店铺已修改次数
			$store_domain = trim($_POST['store_domain']);
			$store_id = intval($_POST['store_id']);
			$store_domain = strtolower($store_domain);
			$param = array();
			$param['store_id'] = $store_id;
			$param['store_domain_times'] = $store_domain_times;
			$param['store_domain'] = '';
			if (!empty($store_domain)){
				$store_domain_count = strlen($store_domain);
				if ($store_domain_count < $subdomain_length[0] || $store_domain_count > $subdomain_length[1]){
					showMessage(Language::get('store_domain_length_error').': '.$setting_config['subdomain_length']);
				}
				if (!preg_match('/^[\w-]+$/i',$store_domain)){//判断域名是否正确
					showMessage(Language::get('store_domain_invalid'));
				}
				$store_info = $model_store->shopStore(array(
					'store_domain'=>$store_domain
				));
				//二级域名存在,则提示错误
				if (!empty($store_info) && ($store_id != $store_info['store_id'])){
					showMessage(Language::get('store_domain_exists'));
				}
				//判断二级域名是否为系统禁止
				$subdomain_reserved = @explode(',',$setting_config['subdomain_reserved']);
				if(!empty($subdomain_reserved) && is_array($subdomain_reserved)){
						if (in_array($store_domain,$subdomain_reserved)){
							showMessage(Language::get('store_domain_sys'));
						}
				}
				$param['store_domain'] = $store_domain;//所有验证通过后更新
			}
			$model_store->storeUpdate($param);
			showMessage(Language::get('store_domain_edit_success'),'index.php?act=store&op=store_domain');//保存成功
		}
		Tpl::output('store_array',$store_array);
		Tpl::showpage('store_domain.edit');
	}
	/**
	 * 删除认证文件
	 */
	public function del_authOp(){
		if(intval($_GET['store_id'])===''||trim($_GET['key'])=='')return false;
		$model_store=Model('store');
		$get_store=$model_store->shopStore(array('store_id'=>intval($_GET['store_id'])));
		$path=BasePath.DS.ATTACH_AUTH.DS.$get_store[$_GET['key']];
		if(@!unlink($path)&&file_exists($path))return false;
		$result=$model_store->storeUpdate(array('store_id'=>intval($_GET['store_id']),$_GET['key']=>''));
		if(!$result)return false;
		echo 'true';
	}
	/**
	 * 认证
	 */
	public function store_authOp(){
		$model = Model();
		$where['store_auth|name_auth'] = 2;
		$where['store_state'] = 1;
		$store_list	= $model->table('store')->field('store_id,store_name,store_auth,name_auth,member_id,member_name,store_image,store_image1,store_end_time')
						->where($where)->order('store_sort asc')->select();
		
		/**
		 * 整理内容
		 */
		if(!empty($store_list)){
			foreach ($store_list as $k => $v){
				/**
				 * 结束时间
				 */
				$store_list[$k]['store_end_time'] = $v['store_end_time']?date('Y-m-d',$v['store_end_time']):Language::get('no_limit');
				/**
				 * 店铺认证
				 */
				$store_list[$k]['store_authS'] = $this->authSystem($v['store_auth']);
				/**
				 * 店主认证
				 */
				$store_list[$k]['name_authS'] = $this->authSystem($v['name_auth']);
			}
		}
		Tpl::output('store_list', $store_list);
		Tpl::showpage('store.auth');
	}
	/**
	 * 认证状态
	 */
	private function authSystem($val){
		switch (intval($val)){
			case 0:
				return Language::get('store_auth_fail');
				break;
			case 1:
				return Language::get('store_auth_succeed');
				break;
			case 2:
				return Language::get('store_verify_ing');
				break;
		}
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 店铺排序
			 */
			case 'store_sort':
				$model_store = Model('store');
				$update_array['store_id'] = intval($_GET['id']);
				$update_array[$_GET['column']] = trim($_GET['value']);
				$model_store->storeUpdate($update_array);
				echo 'true';exit;
				break;
				/**
			 * 店铺推荐
			 */
			case 'store_recommend':
				$model_store = Model('store');
				$update_array['store_id'] = intval($_GET['id']);
				$update_array[$_GET['column']] = trim($_GET['value']);
				$model_store->storeUpdate($update_array);
				echo 'true';exit;
				break;
		}
	}
	/**
	 * 店铺
	 */
	public function export_step1Op(){
		$lang = Language::getLangContent();
		$model = Model('store');
		if(trim($_GET['owner_and_name']) != ''){
			$condition['member_name']	= array('like', '%'.trim($_GET['owner_and_name']).'%');
			Tpl::output('owner_and_name',trim($_GET['owner_and_name']));
		}
		if(trim($_GET['store_name']) != ''){
			$condition['store_name']	= array('like', '%'.trim($_GET['store_name']).'%');
			Tpl::output('store_name',trim($_GET['store_name']));
		}
		if(intval($_GET['grade_id']) > 0){
			$condition['grade_id']		= intval($_GET['grade_id']);
			Tpl::output('grade_id',intval($_GET['grade_id']));
		}
		$condition['store_state']		= array('in', array('0','1'));

//		$store_list = $model_store->where($condition)->order('store_sort asc')->page(10)->select();



		if (!is_numeric($_GET['curpage'])){		
			$count = $model->where($condition)->count();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('download_lang',Language::get('store'));
				Tpl::output('murl','index.php?act=store&op=store');
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$data = $model->where($condition)->order('store_sort asc')->limit(self::EXPORT_SIZE)->select();
				$this->createExcel($data);
			}
		}else{	//下载
			$limit1 = ($_GET['curpage']-1) * self::EXPORT_SIZE;
			$limit2 = self::EXPORT_SIZE;
			$data = $model->where($condition)->order('store_sort asc')->limit("{$limit1},{$limit2}")->select();
			$this->createExcel($data);
		}
	}

	/**
	 * 生成excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		$lang = Language::getLangContent();
		Language::read('export');
		$model_grade = Model('store_grade');
		$grade_list = $model_grade->getGradeList();
		if (!empty($grade_list)){
			$search_grade_list = array();
			foreach ($grade_list as $k => $v){
				$search_grade_list[$v['sg_id']] = $v['sg_name'];
			}
		}
		//整理内容
		if(!empty($data)){
			foreach ($data as $k => $v){
				/**
				 * 店铺等级
				 */
				$data[$k]['grade_name'] = $search_grade_list[$v['grade_id']];
				/**
				 * 店铺状态
				 */
				$data[$k]['state'] = ($v['store_state'] == 1)?$lang['open']:$lang['close'];
				/**
				 * 结束时间
				 */
				$data[$k]['store_end_time'] = $v['store_end_time']?date('Y-m-d',$v['store_end_time']):$lang['no_limit'];
			}
		}

		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_store'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_st_name'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_st_sarea'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_st_grade'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_st_adtime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_st_yxq'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_st_state'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_st_xarea'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_st_post'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_st_tel'));
		$state_cn = array(Language::get('admin_points_stage_regist'),Language::get('admin_points_stage_login'),Language::get('admin_points_stage_comments'),Language::get('admin_points_stage_order'),Language::get('admin_points_stage_system'),Language::get('admin_points_stage_pointorder'),Language::get('admin_points_stage_app'));
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['store_name']);
			$tmp[] = array('data'=>$v['member_name']);
			$tmp[] = array('data'=>$v['area_info']);
			$tmp[] = array('data'=>$v['grade_name']);
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['store_time']));
			$tmp[] = array('data'=>$v['store_end_time']);
			$tmp[] = array('data'=>str_replace(array(1,2,0),array(L('exp_st_kq'),L('exp_st_shz'),L('exp_st_close')),$v['store_state']));
			$tmp[] = array('data'=>$v['store_address']);
			$tmp[] = array('data'=>$v['store_zip']);
			$tmp[] = array('data'=>$v['store_tel']);

			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_store'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_store'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}
