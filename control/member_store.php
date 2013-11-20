<?php
/**
 * 开店
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

class member_storeControl extends BaseMemberControl {
	public function __construct() {
		parent::__construct();
		Language::read('member_store_index');
	}
	public function indexOp(){
		$this->createOp();
	}
	/**
	 * 申请店铺页面
	 * @param 
	 * @return 
	 */
	public function createOp() {
		//读取语言包
		Language::read('home_layout');
		if($GLOBALS['setting_config']['store_allow'] == '0') {
			showMessage(Language::get('store_create_right_closed'),'index.php?act=member_snsindex','html','error');
		}
		if($_SESSION['store_id'] != '') {
			showMessage(Language::get('store_create_created'),'index.php?act=member_snsindex','html','error');
		}

		Tpl::setLayout('member_goods_marketing_layout');
		/**
		 * 实例化店铺等级模型
		 */
		$model_grade	= Model('store_grade');

		if(intval($_GET['grade_id']) != 0) {
//			$store_grade = $model_grade->getOneGrade(intval($_GET['grade_id']));
			$store_grade = ($setting = F('store_grade')) ? $setting : H('store_grade',true,'file');
			$store_grade = $store_grade[intval($_GET['grade_id'])];			
			if(empty($store_grade)) {
				showMessage(Language::get('store_create_grade_not_exists'),'','html','error');
			}
			/**
		 * 实例化商铺类别模型
		 */
			$model_store	= Model('store_class');
			$parent_list = $model_store->getTreeClassList(2);
			if (!empty($parent_list) && is_array($parent_list)){
				foreach ($parent_list as $k => $v){
					$parent_list[$k]['sc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['sc_name'];
				}
			}
			Tpl::output('parent_list',$parent_list);
			Tpl::showpage('seller_step2');
		}

//		$grade_list	= $model_grade->getGradeList();
		$grade_list = ($setting = F('store_grade')) ? $setting : H('store_grade',true,'file');
		//附加功能
		if(!empty($grade_list) && is_array($grade_list)){
			foreach($grade_list as $key=>$grade){
				$sg_function = explode('|',$grade['sg_function']);
				if (!empty($sg_function[0]) && is_array($sg_function)){
					foreach ($sg_function as $key1=>$value){
						if ($value == 'editor_multimedia'){
							$grade_list[$key]['function_str'] .= Language::get('store_create_store_editor_multimedia').'   ';
						}
					}
				}else {
					$grade_list[$key]['function_str'] = Language::get('store_create_store_null');
				}
			}
		}
		Tpl::output('grade_list',$grade_list);

		Tpl::showpage('seller_step1');
	}
	/**
	 * 保存店铺信息
	 *
	 * @param 
	 * @return 
	 */	
	public function saveOp() {
		if($_SESSION['store_id'] != '') {
			showDialog(Language::get('store_create_created'),'index.php?act=member_snsindex','error');
		}
		/**
		 * 实例化店铺等级模型
		 */
//		$model_grade	= Model('store_grade');
//		$store_grade = $model_grade->getOneGrade(intval($_POST['grade_id']));
		$store_grade = ($setting = F('store_grade')) ? $setting : H('store_grade',true,'file');
		$store_grade = $store_grade[intval($_POST['grade_id'])];
		if(empty($store_grade)) {
			showDialog(Language::get('store_create_grade_not_exists'),'','error');
		}
		/**
		 * 实例化店铺模型
		 */
		$model_store	= Model('store');
		/**
		 * 保存店铺信息
		 */
		if (chksubmit()){
			//判断是否有重名店铺
			$_GET['store_name'] = $_POST["store_name"];
			if(!$this->checknameinner()){
				showDialog(Language::get('store_create_store_name_exists'),'','error');
			}
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["store_name"],"require"=>"true","message"=>Language::get('store_save_store_name_null')),
			array("input"=>$_POST["sc_id"],"require"=>"true","validator"=>"Number","message"=>Language::get('store_save_store_class_null')),
			array("input"=>$_POST["area_id"],"require"=>"true","validator"=>"Number","message"=>Language::get('store_save_area_null')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showDialog(Language::get('error').$error,'','error');
			}
			$shop_array		= array();
			$shop_array['grade_id']		= $_POST['grade_id'];
			$shop_array['store_owner_card']= $_POST['store_owner_card'];
			$shop_array['store_name']	= $_POST['store_name'];
			$shop_array['sc_id']		= $_POST['sc_id'];
			$shop_array['area_id']		= $_POST['area_id'];
			$shop_array['area_info']	= $_POST['area_info'];
			$shop_array['store_address']= $_POST['store_address'];
			$shop_array['store_zip']	= $_POST['store_zip'];
			$shop_array['store_tel']	= $_POST['store_tel'];
			$shop_array['store_zy']		= $_POST['store_zy'];
			$shop_array['store_state']	= ($store_grade['sg_confirm'] == 1 ? 2 : 1 );

			$upload = new UploadFile();
			$upload->set('default_dir',ATTACH_AUTH);

			if($_FILES['image']['name'] != '') {
				$result = $upload->upfile('image');
				if ($result){
					$shop_array['store_image'] 	= $upload->file_name;
					$shop_array['name_auth']	= '2';
                    $upload->file_name = '';
				}else {
					showdialog($upload->error,'','error');
				}
			}
			if($_FILES['image1']['name'] != '') {
				$result1 = $upload->upfile('image1');
				if ($result1){
					$shop_array['store_image1'] = $upload->file_name;
					$shop_array['store_auth']	= '2';
				}else {
					showdialog($upload->error,'','error');
				}
			}
			$state	= $model_store->createStore($shop_array);
			if($state) {
				$_SESSION['is_seller'] = 1;
				$_SESSION['store_id'] = $state;
                $_SESSION['store_name'] = $shop_array['store_name'];
                $_SESSION['grade_id'] = $shop_array['grade_id'];
                
                // 生成店铺二维码
                require_once(BasePath.DS.'resource'.DS.'phpqrcode'.DS.'index.php');
                $PhpQRCode	= new PhpQRCode();
                $PhpQRCode->set('date',SiteUrl.DS.ncUrl(array('act'=>'show_store','id'=>$state), 'store'));
                $PhpQRCode->set('pngTempDir',ATTACH_STORE.DS);
                $model_store->storeUpdate(array('store_code'=>$PhpQRCode->init(),'store_id'=>$state));
                
				// 添加相册默认
				$album_model = Model('album');
				$album_arr = array();
				$album_arr['aclass_name'] = Language::get('store_save_defaultalbumclass_name');
				$album_arr['store_id'] = $state;
				$album_arr['aclass_des'] = '';
				$album_arr['aclass_sort'] = '255';
				$album_arr['aclass_cover'] = '';
				$album_arr['upload_time'] = time();
				$album_arr['is_default'] = '1';
				$album_model->addClass($album_arr);
	
				$model = Model();
				//插入店铺扩展表
				$model->table('store_extend')->insert(array('store_id'=>$state));
				$msg = Language::get('store_save_create_success').($store_grade['sg_confirm'] == 1 ? Language::get('store_save_waiting_for_review') : ''); 
				showDialog($msg,'index.php?act=store','succ');
			} else {
				showDialog(Language::get('store_save_create_fail'),'','error');
			}
		}
	}
	/**
	 * 检查店铺名称是否存在
	 *
	 * @param 
	 * @return 
	 */
	public function checknameOp() {
		if(!$this->checknameinner()) {
			echo 'false';
		} else {
			echo 'true';
		}
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
	 * 卖家升级店铺等级
	 *
	 * @param string	
	 * @param string 	
	 * @return 
	 */
	public function update_gradeOp() {
		//读取语言包
		Language::read('home_layout');
		/**
		 * 查询店铺等级申请信息
		 */
		
		if(!$_SESSION['store_id']) {
			showMessage(Language::get('store_create_created'),'index.php?act=member_snsindex','html','error');
		}

		Tpl::setLayout('member_goods_marketing_layout');		
		
		$model_store_gradelog = Model('store_gradelog');
		$gradelog = $model_store_gradelog->getLogInfo(array('gl_shopid'=>$_SESSION['store_id'],'gl_allowstate'=>'0','order'=>' gl_id desc '));
		if (is_array($gradelog) && count($gradelog)>0){
			//showMessage('店铺等级升级申请已经提交，正在审核中，请耐心等待','index.php?act=store&op=store_setting');
			showMessage(Language::get('store_upgrade_exist_error'),'index.php?act=store&op=store_setting','html','error');
		}
		$grade_id	= intval($_GET['grade_id']);
		/**
		 * 实例化店铺等级模型
		 */
		$model_grade	= Model('store_grade');
		$model_store	= Model('store');
		
		//查询店铺信息
		//$store_info = $model_store->shopStore(array('store_id'=>$_SESSION['store_id']));
		$store_info	= $model_grade->getGradeShopList(array('store_id'=>$_SESSION['store_id']));
		
		if (!is_array($store_info) || count($store_info)<=0 ){
			showMessage(Language::get('store_upgrade_store_error'),'index.php?act=member_snsindex','html','error');
		}
		
		if($grade_id != 0) {
//			$store_grade = $model_grade->getOneGrade(intval($_GET['grade_id']));
			$store_grade = ($setting = F('store_grade')) ? $setting : H('store_grade',true,'file');
			$store_grade = $store_grade[intval($_GET['grade_id'])];
			if(empty($store_grade)) {
				showMessage(Language::get('store_create_grade_not_exists'),'','html','error');
				exit();
			}
			if ($store_grade['sg_sort'] <= $store_info[0]['sg_sort']){
				//showMessage('等级错误,升级级别应高于当前级别');
				showMessage(Language::get('store_upgrade_gradesort_error'),'','html','error');
				exit();
			}
			/**
		 	* 实例化店铺模型
		 	*/
			/*$array	= array();
			$array['grade_id']		= $grade_id;
			$array['store_audit']	= $store_grade['sg_confirm'] == 1 ? 0 : 1 ;
			$array['store_id']		= $_SESSION['store_id'];
			$update_state	= $model_store->storeUpdate($array);*/
			//添加申请信息
			$gl_insertarr = array();
			$gl_insertarr['gl_shopid'] = $_SESSION['store_id'];
			$gl_insertarr['gl_shopname'] = $_SESSION['store_name'];
			$gl_insertarr['gl_memberid'] = $_SESSION['member_id'];
			$gl_insertarr['gl_membername'] = $_SESSION['member_name'];
			$gl_insertarr['gl_sgid'] = $store_grade['sg_id'];
			$gl_insertarr['gl_sgname'] = $store_grade['sg_name'];
			$gl_insertarr['gl_sgconfirm'] = $store_grade['sg_confirm'];
			$gl_insertarr['gl_sgsort'] = $store_grade['sg_sort'];
			$gl_insertarr['gl_addtime'] = time();
			$gl_insertarr['gl_allowstate'] = $store_grade['sg_confirm'] == 1? 0 : 1;
			$gl_insertarr['gl_allowadminid'] = 0;
			$gl_insertarr['gl_allowadminname'] = $store_grade['sg_confirm'] == 1? '' : 'system';
			$model_gradelog = Model('store_gradelog');
			$log_result = $model_gradelog->addLog($gl_insertarr);
			//添加成功
			if ($log_result){
				//判断是否为自动通过审核 0表示不需要审核则修改店铺等级信息
				$update_state = true;
				if ($store_grade['sg_confirm'] == '0'){
					$array	= array();
					$array['grade_id']		= $store_grade['sg_id'];
					$array['store_id']		= $_SESSION['store_id'];
					$update_state	= $model_store->storeUpdate($array);
				}
				if ($update_state) {
					showMessage(Language::get('store_upgrade_submit'),'index.php?act=store&op=store_setting');
				}else {
					showMessage(Language::get('store_upgrade_submit_fail'),'index.php?act=store&op=update_grade','html','error');
				}
			}else {
					showMessage(Language::get('store_upgrade_submit_fail'),'index.php?act=store&op=update_grade','html','error');
			}
			exit();
		}
		$grade_list	= $model_grade->getGradeList(array('order'=>' sg_sort '));
	    //附加功能
		if(!empty($grade_list) && is_array($grade_list)){
			foreach($grade_list as $key=>$grade){
				$sg_function = explode('|',$grade['sg_function']);
				if (!empty($sg_function[0]) && is_array($sg_function)){
					foreach ($sg_function as $key1=>$value){
						if ($value == 'editor_multimedia'){
							$grade_list[$key]['function_str'] .= Language::get('store_create_store_editor_multimedia').'   ';
						}elseif ($value == 'groupbuy'){
							$grade_list[$key]['function_str'] .= Language::get('store_create_store_groupbuy').'   ';
						}
					}
				}else {
					$grade_list[$key]['function_str'] = Language::get('store_create_store_null');
				}
			}
		}
		Tpl::output('grade_list',$grade_list);
		/**
		 * 店铺当前等级及店铺信息
		 */
		//$store_grade	= $model_grade->getGradeShopList(array('store_id'=>$_SESSION['store_id']));
		//Tpl::output('store_grade',$store_grade[0]);
		Tpl::output('store_info',$store_info[0]);
		Tpl::showpage('store_update_grade');
	}
}
