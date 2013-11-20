<?php
/**
 * 会员管理
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

class memberControl extends SystemControl{
	const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();
		Language::read('member');
	}
	/**
	 * 会员管理
	 */
	public function memberOp(){
		$lang	= Language::getLangContent();
		$model_member = Model('member');
		/**
		 * 删除
		 */
		if (chksubmit()){
			/**
			 * 判断是否是管理员，如果是，则不能删除
			 */
			$model_admin = Model('admin');
			$admin_list = $model_admin->getAdminList($condition,$page);
			if (is_array($admin_list)){
				foreach ($admin_list as $k => $v){
					if (@in_array($v['member_id'],$_POST['del_id'])){
						showMessage($lang['member_index_is_admin']);
					}
				}
			}
			/**
			 * 删除
			 */
			if (!empty($_POST['del_id'])){
				if($GLOBALS['setting_config']['ucenter_status'] == '1') {
					$model_ucenter = Model('ucenter');
				}
				if (is_array($_POST['del_id'])){
					foreach ($_POST['del_id'] as $k => $v){
						$v = intval($v);
						$rs = true;//$model_member->del($v);
						if ($rs){
							//删除该会员商品,店铺
							//获得该会员店铺信息
							$member = $model_member->infoMember(array(
								'member_id'=>$v
							));
							$model_store = Model('store');
							$model_goods = Model('goods');
							$model_order = Model('order');
							//删除店铺					
							$model_store->del($member['store_id']);
							//删除商品
							$model_goods->dropGoodsByStore($member['store_id']);
							//删除用户
							$model_member->del($v);
						}

						if($GLOBALS['setting_config']['ucenter_status'] == '1') {//不删除UC中的会员防止失误
							//$model_ucenter->userDelete($v);
						}
					}
				}
				showMessage($lang['member_index_del_succ']);
			}else {
				showMessage($lang['member_index_choose_del']);
			}
		}
		/**
		 * 检索条件
		 */
		switch ($_GET['search_field_name']){
			case 'member_name':
				$condition['like_member_name'] = trim($_GET['search_field_value']);
				break;
			case 'member_email':
				$condition['like_member_email'] = trim($_GET['search_field_value']);
				break;
			case 'member_truename':
				$condition['like_member_truename'] = trim($_GET['search_field_value']);
				break;
		}
		switch ($_GET['search_state']){
			case 'no_informallow':
				$condition['inform_allow'] = '2';
				break;
			case 'no_isbuy':
				$condition['is_buy'] = '0';
				break;
			case 'no_isallowtalk':
				$condition['is_allowtalk'] = '0';
				break;
			case 'no_memberstate':
				$condition['member_state'] = '0';
				break;
		}
		/**
		 * 排序
		 */
		$condition['order'] = trim($_GET['search_sort']);
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$member_list = $model_member->getMemberList($condition,$page);
		/**
		 * 整理会员信息
		 */
		if (is_array($member_list)){
			foreach ($member_list as $k=> $v){
				$member_list[$k]['member_time'] = $v['member_time']?date('Y-m-d H:i:s',$v['member_time']):'';
				$member_list[$k]['member_login_time'] = $v['member_login_time']?date('Y-m-d H:i:s',$v['member_login_time']):'';
			}
		}

		Tpl::output('search_sort',trim($_GET['search_sort']));
		Tpl::output('search_field_name',trim($_GET['search_field_name']));
		Tpl::output('search_field_value',trim($_GET['search_field_value']));
		Tpl::output('member_list',$member_list);
		Tpl::output('page',$page->show());
		Tpl::showpage('member.index');
	}

	/**
	 * 会员修改
	 */
	public function member_editOp(){
		$lang	= Language::getLangContent();
		$model_member = Model('member');
		/**
		 * 保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["member_email"], "require"=>"true", 'validator'=>'Email', "message"=>$lang['member_edit_valid_email']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/**
				 * 上传图片
				 */
				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_AVATAR);
				/**
				 * 上传头像
				 */
				if (!empty($_FILES['member_avatar']['name'])){
					$result = $upload->upfile('member_avatar');
					if ($result){
						$_POST['member_avatar'] = $upload->file_name;
					}else {
						showMessage($upload->error,'','','error');
					}
				}

				$update_array = array();
				$update_array['member_id']			= intval($_POST['member_id']);
				if (!empty($_POST['member_passwd'])){
					$update_array['member_passwd'] = md5($_POST['member_passwd']);
				}
				$update_array['member_email']		= trim($_POST['member_email']);
				$update_array['member_truename']	= trim($_POST['member_truename']);
				$update_array['member_sex'] 		= trim($_POST['member_sex']);
				$update_array['member_qq'] 			= trim($_POST['member_qq']);
				$update_array['member_ww']			= trim($_POST['member_ww']);
				$update_array['inform_allow'] 		= trim($_POST['inform_allow']);
				$update_array['is_buy'] 			= trim($_POST['isbuy']);
				$update_array['is_allowtalk'] 		= trim($_POST['allowtalk']);
				$update_array['member_state'] 		= trim($_POST['memberstate']);
				if (!empty($_POST['member_avatar'])){
					$update_array['member_avatar'] = $_POST['member_avatar'];
				}
				$result = $model_member->updateMember($update_array,intval($_POST['member_id']));
				if ($result){
					/**
					 * 删除旧图片
					 */
					if (!empty($_POST['member_avatar']) && !empty($_POST['old_member_avatar'])){
						@unlink(BasePath.DS.ATTACH_AVATAR.DS.$_POST['old_member_avatar']);
					}
					$url = array(
					array(
					'url'=>'index.php?act=member&op=member',
					'msg'=>$lang['member_edit_back_to_list'],
					),
					array(
					'url'=>'index.php?act=member&op=member_edit&member_id='.intval($_POST['member_id']),
					'msg'=>$lang['member_edit_again'],
					),
					);
					if($GLOBALS['setting_config']['ucenter_status'] == '1') {
						/**
						* Ucenter处理
						*/
						$model_ucenter = Model('ucenter');
						if (!empty($_POST['member_passwd'])){
							$array_uc=array('login_name'=>trim($_POST['member_name']),'password'=>trim($_POST['member_passwd']),'email'=>trim($_POST['member_email']));
						}else {
							$array_uc=array('login_name'=>trim($_POST['member_name']),'email'=>trim($_POST['member_email']));
						}
						$model_ucenter->userEdit($array_uc);
					}

					showMessage($lang['member_edit_succ'],$url);
				}else {
					showMessage($lang['member_edit_fail']);
				}
			}
		}
		$condition['member_id'] = intval($_GET['member_id']);
		$member_array = $model_member->infoMember($condition);

		Tpl::output('member_array',$member_array);
		Tpl::showpage('member.edit');
	}

	/**
	 * 新增会员
	 */
	public function member_addOp(){
		$lang	= Language::getLangContent();
		$model_member = Model('member');
		/**
		 * 保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["member_email"], "require"=>"true", 'validator'=>'Email', "message"=>$lang['member_edit_valid_email']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/**
				 * 上传头像
				 */
				if (!empty($_FILES['member_avatar']['name'])){
					/**
					 * 上传图片
					 */
					$upload = new UploadFile();
					$upload->set('default_dir',ATTACH_AVATAR);
					$result = $upload->upfile('member_avatar');
					if ($result){
						$_POST['member_avatar'] = $upload->file_name;
					}else {
						showMessage($upload->error,'','','error');
					}
				}
				$insert_array = array();

				if($GLOBALS['setting_config']['ucenter_status'] == '1') {
					/**
					* Ucenter处理
					*/
					$model_ucenter = Model('ucenter');
					$uid = $model_ucenter->addUser(trim($_POST['member_name']),trim($_POST['member_passwd']),trim($_POST['member_email']));
					$insert_array['member_id']		= $uid;
				}

				$insert_array['member_name']	= trim($_POST['member_name']);
				$insert_array['member_passwd']	= trim($_POST['member_passwd']);
				$insert_array['member_email']	= trim($_POST['member_email']);
				$insert_array['member_truename']= trim($_POST['member_truename']);
				$insert_array['member_sex'] 	= trim($_POST['member_sex']);
				$insert_array['member_qq'] 		= trim($_POST['member_qq']);
				$insert_array['member_ww']			= trim($_POST['member_ww']);
                //默认允许举报商品
                $insert_array['inform_allow'] 	= '1';
				if (!empty($_POST['member_avatar'])){
					$insert_array['member_avatar'] = trim($_POST['member_avatar']);
				}

				$result = $model_member->addMember($insert_array);
				if ($result){
					$url = array(
					array(
					'url'=>'index.php?act=member&op=member',
					'msg'=>$lang['member_add_back_to_list'],
					),
					array(
					'url'=>'index.php?act=member&op=member_add',
					'msg'=>$lang['member_add_again'],
					),
					);
					showMessage($lang['member_add_succ'],$url);
				}else {
					showMessage($lang['member_add_fail']);
				}
			}
		}
		Tpl::showpage('member.add');
	}

	/**
	 * 删除会员
	 */
	public function member_delOp(){
		$lang	= Language::getLangContent();
		if (!empty($_GET['member_id'])){
			$model_member = Model('member');
			$condition['member_id'] = intval($_GET['member_id']);
			$member_array = $model_member->infoMember($condition);
			$rs = $model_member->del(intval($_GET['member_id']));
			if ($rs){
				//删除该会员商品,店铺
				//获得该会员店铺信息
				$model_store = Model('store');
				$model_goods = Model('goods');
				$model_order = Model('order');
				//删除店铺					
				$model_store->del($member_array['store_id']);
				//删除商品
				$model_goods->dropGoodsByStore($member_array['store_id']);
			}

			if($GLOBALS['setting_config']['ucenter_status'] == '1') {
				/**
				* Ucenter处理
				*/
				$model_ucenter = Model('ucenter');//不删除UC中的会员防止失误
				//$model_ucenter->userDelete($_GET['member_id']);
			}

			showMessage($lang['member_index_del_succ']);
		}else {
			showMessage($lang['member_index_choose_del']);
		}
	}

	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 验证会员是否重复
			 */
			case 'check_user_name':
				$model_member = Model('member');
				$condition['member_name']	= trim($_GET['member_name']);
				$condition['no_member_id']	= intval($_GET['member_id']);
				$list = $model_member->infoMember($condition);
				if (empty($list)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
				/**
			 * 验证邮件是否重复
			 */
			case 'check_email':
				$model_member = Model('member');
				$condition['member_email'] = trim($_GET['member_email']);
				$condition['no_member_id'] = intval($_GET['member_id']);
				$list = $model_member->infoMember($condition);
				if (empty($list)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
		}
	}

	/**
	 * 导出会员到Excel
	 */
	public function export_step1Op(){
		$lang	= Language::getLangContent();
		$model_member = Model('member');
		switch ($_GET['search_field_name']){
			case 'member_name':
				$condition['like_member_name'] = trim($_GET['search_field_value']);
				break;
			case 'member_email':
				$condition['like_member_email'] = trim($_GET['search_field_value']);
				break;
			case 'member_truename':
				$condition['like_member_truename'] = trim($_GET['search_field_value']);
				break;
		}
		switch ($_GET['search_state']){
			case 'no_informallow':
				$condition['inform_allow'] = '2';
				break;
			case 'no_isbuy':
				$condition['is_buy'] = '0';
				break;
			case 'no_isallowtalk':
				$condition['is_allowtalk'] = '0';
				break;
			case 'no_memberstate':
				$condition['member_state'] = '0';
				break;
		}
		$condition['order'] = trim($_GET['search_sort']);
		$page	= new Page();
		$page->setEachNum(self::EXPORT_SIZE);
		$member_list = $model_member->getMemberList($condition,$page);
		if (is_array($member_list)){
			foreach ($member_list as $k=> $v){
				$member_list[$k]['member_time'] = $v['member_time']?date('Y-m-d H:i:s',$v['member_time']):'';
				$member_list[$k]['member_login_time'] = $v['member_login_time']?date('Y-m-d H:i:s',$v['member_login_time']):'';
			}
		}
		if (!is_numeric($_GET['curpage'])){		
			$count = $page->getTotalNum();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('download_lang',Language::get('member_index_manage'));
				Tpl::output('murl','index.php?act=member&op=member');				
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createExcel($member_list);
			}
		}else{	//下载
			$this->createExcel($member_list);
		}
	}

	/**
	 * 生成excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_member'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_name'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_jf'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_yck'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_jbs'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'Email');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_sex'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'QQ');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_ww'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_dcs'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_rtime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_ltime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_mb_storeid'));
		$state_cn = array(Language::get('admin_points_stage_regist'),Language::get('admin_points_stage_login'),Language::get('admin_points_stage_comments'),Language::get('admin_points_stage_order'),Language::get('admin_points_stage_system'),Language::get('admin_points_stage_pointorder'),Language::get('admin_points_stage_app'));
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['member_name']);
			$tmp[] = array('data'=>$v['member_truename']);
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['pl_points']));
			$tmp[] = array('data'=>Language::get('member_index_available').':'.$v['available_predeposit'].Language::get('member_index_frozen').':'.$v['freeze_predeposit']);
			$tmp[] = array('data'=>$v['member_goldnum']);
			$tmp[] = array('data'=>$v['member_email']);
			$tmp[] = array('data'=>str_replace(array(1,2,0,3),array(L('exp_mb_nan'),L('exp_mb_nv'),'',''),$v['member_sex']));
			$tmp[] = array('data'=>$v['member_qq']);
			$tmp[] = array('data'=>$v['member_ww']);
			$tmp[] = array('data'=>$v['member_login_num']);
			$tmp[] = array('data'=>$v['member_time']);
			$tmp[] = array('data'=>$v['member_login_time']);
			$tmp[] = array('data'=>$v['store_id']);

			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_member'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_member'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}