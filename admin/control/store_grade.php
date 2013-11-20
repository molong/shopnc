<?php
/**
 * 店铺等级管理
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

class store_gradeControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('store_grade,store');
	}
	/**
	 * 店铺等级
	 */
	public function store_gradeOp(){
		/**
		 * 读取语言包
		 */
		$lang	= Language::getLangContent();

		$model_grade = Model('store_grade');
		/**
		 * 删除
		 */
		if ($_POST['form_submit'] == 'ok'){
			if (!empty($_POST['check_sg_id'])){
				if (is_array($_POST['check_sg_id'])){
					$model_store = Model('store');
					foreach ($_POST['check_sg_id'] as $k => $v){
						/**
						 * 该店铺等级下的所有店铺会自动改为默认等级
						 */
						$v = intval($v);
						/*$store_list = $model_store->getStoreList(array(
							'grade_id'=>$v
						));
						if(!empty($store_list) && is_array($store_list)){
							foreach($store_list as $store){
								$model_store->storeUpdate(array(
									'store_id'=>$store['store_id'],
									'grade_id'=>1
								));
							}
						}
						unset($store_list);*/
						//判断是否默认等级，默认等级不能删除
						if ($v == 1){
							//showMessage('默认等级不能删除 ','index.php?act=store_grade&op=store_grade');
							showMessage($lang['default_store_grade_no_del'],'index.php?act=store_grade&op=store_grade');
						}
						//判断该等级下是否存在店铺，存在的话不能删除
						if ($this->isable_delGrade($v)){
							$model_grade->del($v);
						}
					}
				}
				H('store_grade',true);
				showMessage($lang['del_store_grade_ok']);
			}else {
				showMessage($lang['sel_del_store_grade']);
			}
		}
		$condition['like_sg_name'] = trim($_POST['like_sg_name']);
		$condition['order'] = 'sg_sort';
		
		$grade_list = $model_grade->getGradeList($condition);
		
		Tpl::output('like_sg_name',trim($_POST['like_sg_name']));
		Tpl::output('grade_list',$grade_list);
		Tpl::showpage('store_grade.index');
	}
	
	/**
	 * 新增等级
	 */
	public function store_grade_addOp(){
		/**
		 * 读取语言包
		 */
		$lang	= Language::getLangContent();

		$model_grade = Model('store_grade');
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["sg_name"], "require"=>"true", "message"=>$lang['store_grade_name_no_null']),
				array("input"=>$_POST["sg_price"], "require"=>"true", "message"=>$lang['charges_standard_no_null']),
				array("input"=>$_POST["sg_goods_limit"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['allow_pubilsh_product_num_only_lnteger']),
				array("input"=>$_POST["sg_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['sort_only_lnteger']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				//验证等级名称
				if (!$this->checkGradeName(array('sg_name'=>trim($_POST['sg_name'])))){
					showMessage($lang['now_store_grade_name_is_there']);
				}
				//验证级别是否存在
				if (!$this->checkGradeSort(array('sg_sort'=>trim($_POST['sg_sort'])))){
					//showMessage('级别已经存在，请添加其他级别');
					showMessage($lang['add_gradesortexist']);
				}
				$insert_array = array();
				$insert_array['sg_name'] = trim($_POST['sg_name']);
				$insert_array['sg_goods_limit'] = trim($_POST['sg_goods_limit']);
				$insert_array['sg_space_limit'] = '100';
				$insert_array['sg_function'] = $_POST['sg_function']?implode('|',$_POST['sg_function']):'';
				$insert_array['sg_price'] = trim($_POST['sg_price']);
				$insert_array['sg_confirm'] = trim($_POST['sg_confirm']);
				$insert_array['sg_description'] = trim($_POST['sg_description']);
				$insert_array['sg_sort'] = trim($_POST['sg_sort']);
				$insert_array['sg_template'] = 'default';
				
				$result = $model_grade->add($insert_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=store_grade&op=store_grade_add',
							'msg'=>$lang['continue_add_store_grade'],
						),
						array(
							'url'=>'index.php?act=store_grade&op=store_grade',
							'msg'=>$lang['back_store_grade_list'],
						)
					);
					H('store_grade',true);
					showMessage($lang['add_store_grade_ok'],$url);
				}else {
					showMessage($lang['add_store_grade_fail']);
				}
			}
		}
		Tpl::showpage('store_grade.add');
	}
	
	/**
	 * 等级编辑
	 */
	public function store_grade_editOp(){
		/**
		 * 读取语言包
		 */
		$lang	= Language::getLangContent();

		$model_grade = Model('store_grade');
		if (chksubmit()){
			if (!$_POST['sg_id']){
				showMessage($lang['grade_parameter_error'],'index.php?act=store_grade&op=store_grade');
			}
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["sg_name"], "require"=>"true", "message"=>$lang['store_grade_name_no_null']),
				array("input"=>$_POST["sg_price"], "require"=>"true", "message"=>$lang['charges_standard_no_null']),
				array("input"=>$_POST["sg_goods_limit"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['allow_pubilsh_product_num_only_lnteger']),
				array("input"=>$_POST["sg_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['sort_only_lnteger']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				//如果是默认等级则级别为0
				if ($_POST['sg_id'] == 1){
					$_POST['sg_sort'] = 0;
				}
				//验证等级名称
				if (!$this->checkGradeName(array('sg_name'=>trim($_POST['sg_name']),'sg_id'=>intval($_POST['sg_id'])))){
					showMessage($lang['now_store_grade_name_is_there'],'index.php?act=store_grade&op=store_grade_edit&sg_id='.intval($_POST['sg_id']));
				}
				//验证级别是否存在
				if (!$this->checkGradeSort(array('sg_sort'=>trim($_POST['sg_sort']),'sg_id'=>intval($_POST['sg_id'])))){
					showMessage($lang['add_gradesortexist'],'index.php?act=store_grade&op=store_grade_edit&sg_id='.intval($_POST['sg_id']));
				}
				$update_array = array();
				$update_array['sg_id'] = intval($_POST['sg_id']);
				$update_array['sg_name'] = trim($_POST['sg_name']);
				$update_array['sg_goods_limit'] = trim($_POST['sg_goods_limit']);
				$update_array['sg_album_limit'] = trim($_POST['sg_album_limit']);
				$update_array['sg_function'] = $_POST['sg_function']?implode('|',$_POST['sg_function']):'';
				$update_array['sg_price'] = trim($_POST['sg_price']);
				$update_array['sg_confirm'] = trim($_POST['sg_confirm']);
				$update_array['sg_description'] = trim($_POST['sg_description']);
				$update_array['sg_sort'] = trim($_POST['sg_sort']);
				
				$result = $model_grade->update($update_array);
				if ($result){
					H('store_grade',true,'file');
					showMessage($lang['update_store_grade_ok']);
				}else {
					showMessage($lang['update_store_grade_fail']);
				}
			}
		}
		
		$grade_array = $model_grade->getOneGrade(intval($_GET['sg_id']));
		if (empty($grade_array)){
			showMessage($lang['illegal_parameter']);
		}
		/**
		 * 附加功能
		 */
		$grade_array['sg_function'] = explode('|',$grade_array['sg_function']);
		
		Tpl::output('grade_array',$grade_array);
		Tpl::showpage('store_grade.edit');
	}
	
	/**
	 * 删除等级
	 */
	public function store_grade_delOp(){
		/**
		 * 读取语言包
		 */
		$lang	= Language::getLangContent();
		$model_grade = Model('store_grade');
		if (intval($_GET['sg_id']) > 0){
			//判断是否默认等级，默认等级不能删除
			if ($_GET['sg_id'] == 1){
				//showMessage('默认等级不能删除 ','index.php?act=store_grade&op=store_grade');
				showMessage($lang['default_store_grade_no_del'],'index.php?act=store_grade&op=store_grade');
			}
			//判断该等级下是否存在店铺，存在的话不能删除
			if (!$this->isable_delGrade(intval($_GET['sg_id']))){
				showMessage($lang['del_gradehavestore'],'index.php?act=store_grade&op=store_grade');
			}
			/**
			 * 删除分类
			 */
			$model_grade->del(intval($_GET['sg_id']));
			H('store_grade',true);
			showMessage($lang['del_store_grade_ok'],'index.php?act=store_grade&op=store_grade');
		}else {
			showMessage($lang['del_store_grade_fail'],'index.php?act=store_grade&op=store_grade');
		}
	}
	
	/**
	 * 等级：设置可选模板
	 */
	public function store_grade_templatesOp(){
		/**
		 * 读取语言包
		 */
		$lang	= Language::getLangContent();

		$model_grade = Model('store_grade');
		
		if ($_POST['form_submit'] == 'ok'){
			$update_array = array();
			$update_array['sg_id'] = $_POST['sg_id'];
			if (!in_array('default',$_POST['template'])){
				$_POST['template'][] = 'default';
			}
			$update_array['sg_template'] = $_POST['template']?implode('|',$_POST['template']):'';
			$update_array['sg_template_number'] = count($_POST['template']);
			
			$result = $model_grade->update($update_array);
			if ($result){
				$url = array(
					array(
						'url'=>'index.php?act=store_grade&op=store_grade',
						'msg'=>$lang['back_store_grade_list'],
					),
				);
				showMessage($lang['set_store_grade_ok'],$url);
			}else {
				showMessage($lang['set_store_grade_fail']);
			}
		}
		/**
		 * 主题配置信息
		 */
		$style_data = array();
		$style_configurl = BASE_TPL_PATH.DS.'store'.DS.'style'.DS."styleconfig.php";
		if (file_exists($style_configurl)){
			include_once($style_configurl);
			if (strtoupper(CHARSET) == 'GBK'){
				$style_data = Language::getGBK($style_data);
			}
			$dir_list = array_keys($style_data);
		}
		/**
		 * 等级信息
		 */
		$grade_array = $model_grade->getOneGrade(intval($_GET['sg_id']));
		if (empty($grade_array)){
			showMessage($lang['illegal_parameter']);
		}
		$grade_array['sg_template'] = explode('|',$grade_array['sg_template']);
		
		Tpl::output('dir_list',$dir_list);
		Tpl::output('grade_array',$grade_array);
		Tpl::showpage('store_grade_template.edit');
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 店铺等级：验证是否有重复的名称
			 */
			case 'check_grade_name':
				if ($this->checkGradeName($_GET)){
					echo 'true'; exit;
				}else{
					echo 'false'; exit;
				}
				break;
			case 'check_grade_sort':
				if ($this->checkGradeSort($_GET)){
					echo 'true'; exit;
				}else{
					echo 'false'; exit;
				}
				break;
		}	
	}
	/**
	 * 查询店铺等级名称是否存在
	 */
	private function checkGradeName($param){
		$model_grade = Model('store_grade');
		$condition['sg_name'] = $param['sg_name'];
		$condition['no_sg_id'] = $param['sg_id'];
		$list = $model_grade->getGradeList($condition);
		if (empty($list)){
			return true;
		}else {
			return false;
		}
	}
	/**
	 * 查询店铺等级是否存在
	 */
	private function checkGradeSort($param){
		$model_grade = Model('store_grade');
		$condition = array();
		$condition['sg_sort'] = "{$param['sg_sort']}";
		$condition['no_sg_id'] = '';
		if ($param['sg_id']){
			$condition['no_sg_id'] = "{$param['sg_id']}";
		}
		$list = array();
		$list = $model_grade->getGradeList($condition);
		if (is_array($list) && count($list)>0){
			return false;
		}else{
			return true;
		}
	}
	/**
	 * 判断店铺等级是否能删除
	 */
	public function isable_delGrade($sg_id){
		//判断该等级下是否存在店铺，存在的话不能删除
		$model_store = Model('store');
		$count = $model_store->countStore(array('grade_id'=>$sg_id));
		if ($count>0){
			return false;
		}
		return true; 
	}
	/**
	 * 等级申请日志
	 */
	public function store_grade_logOp(){
		$condition = array();
		if (trim($_GET['storename'])){
			$condition['gl_shopname_like'] = trim($_GET['storename']);
		}
		if (trim($_GET['membername'])){
			$condition['gl_membername_like'] = trim($_GET['membername']);
		}
		if (trim($_GET['gradename'])){
			$condition['gl_sgname_like'] = trim($_GET['gradename']);
		}
		if ($_GET['allowstate']){
			$condition['gl_allowstate'] = intval($_GET['allowstate'])-1;			
		}
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$model_gradelog = Model('store_gradelog');
		$condition['order'] = ' gl_allowstate asc,gl_id desc ';
		$log_list = $model_gradelog->getLogList($condition,$page);
		Tpl::output('log_list',$log_list);
		Tpl::output('page',$page->show());
		Tpl::showpage('store_grade.log');
	}
	/**
	 * 编辑申请日志
	 */
	public function sg_logeditOp(){
		if (!$_GET['id']){
			showMessage(Language::get('grade_parameter_error'),'index.php?act=store_grade&op=store_grade_log');
		}
		//查询日志记录
		$model_gradelog = Model('store_gradelog');
		$log_info = $model_gradelog->getLogInfo(array('gl_id'=>intval($_GET['id'])),$page);
		if (!is_array($log_info) || count($log_info)<=0){
			//showMessage('信息错误','index.php?act=store_grade&op=store_grade_log');
			showMessage(Language::get('record_error'),'index.php?act=store_grade&op=store_grade_log');
		}
		if ($_POST['form_submit'] == 'ok'){
			//验证是否已经经过审核操作，已经过审核操作则直接提示成功
			if ($log_info['gl_allowstate'] >0 ){
				showMessage(Language::get('grade_edit_success'),'index.php?act=store_grade&op=store_grade_log');
			}
			//查询申请的等级级别是否更改过，更改过则提示
			$model_grade = Model('store_grade');
			$grade_info = $model_grade->getOneGrade($log_info['gl_sgid']);
			if (!is_array($grade_info) || count($grade_info)<=0){
				//showMessage('等级信息错误，请查看店铺等级信息','index.php?act=store_grade&op=store_grade');
				showMessage(Language::get('grade_edit_gradeerror'),'index.php?act=store_grade&op=store_grade');
			}
			if ($grade_info['sg_sort'] != $log_info['gl_sgsort']){
				//showMessage('等级信息级别更改过，请查看店铺等级信息','index.php?act=store_grade&op=store_grade');
				showMessage(Language::get('grade_edit_grade_same_error'),'index.php?act=store_grade&op=store_grade');
			}
			//查询店铺信息
			$store_info	= $model_grade->getGradeShopList(array('store_id'=>$log_info['gl_shopid']));
			if (!is_array($store_info) || count($store_info)<=0 ){
				showMessage(Language::get('grade_edit_grade_store_error'),'index.php?act=store_grade&op=store_grade_log');
			}
			if ($log_info['gl_sgsort'] <= $store_info[0]['sg_sort']){
				//showMessage('升级级别应高于店铺当前级别,请核实申请信息');
				showMessage(Language::get('grade_edit_grade_sort_error'));
			}
			//更新日志信息
			$up_arr = array();
			$up_arr['gl_allowstate'] = trim($_POST['gl_state']);
			$admininfo = $this->getAdminInfo();
			$up_arr['gl_allowadminid'] = $admininfo['id'];
			$up_arr['gl_allowadminname'] = $admininfo['name'];
			$up_arr['gl_allowremark'] = trim($_POST['remark']);
			$result = $model_gradelog->updateLogOne($up_arr,array('gl_id'=>$log_info['gl_id']));
			if ($result){
				if ($up_arr['gl_allowstate'] == 1){
					//更新店铺表等级信息
					$model_store	= Model('store');
					$array	= array();
					$array['grade_id']		= $log_info['gl_sgid'];
					$array['store_id']		= $log_info['gl_shopid'];
					$update_state	= $model_store->storeUpdate($array);
				}
				showMessage(Language::get('grade_edit_success'),'index.php?act=store_grade&op=store_grade_log');
			}else{
				showMessage(Language::get('grade_edit_fail'),'index.php?act=store_grade&op=store_grade_log');
			}
		}
		Tpl::output('log_info',$log_info);
		Tpl::showpage('store_grade.logedit');
	}
	/**
	 * 删除申请日志
	 */
	public function sg_logdelOp(){
		$gl_id = $_POST['check_gl_id'];
		if (!$gl_id){
			//showMessage('请选择操作记录','index.php?act=store_grade&op=store_grade_log');
			showMessage(Language::get('grade_del_please_choose_error'),'index.php?act=store_grade&op=store_grade_log');
		}
		$gl_id = "'".implode("','",$gl_id)."'";
		$model_gradelog = Model('store_gradelog');
		//查询申请记录是否存在
		$log_list = $model_gradelog->getLogList(array('gl_id_in'=>$gl_id,'gl_allowstate'=>'0'));
		/*if (!is_array($log_list) || count($log_list)<=0){
			showMessage(Language::get('record_error'),'index.php?act=store_grade&op=store_grade_log');
		}*/
		$gl_idnew = array();
		if (is_array($log_list) && count($log_list)>0){
			foreach ($log_list as $k=>$v){
				$gl_idnew[] = $v['gl_id'];
			}
		}
		$result = true;
		if (is_array($gl_idnew) && count($gl_idnew)>0){
			$result = $model_gradelog->dropLogById($gl_idnew);
		}
		
		if($result) {
			showMessage(Language::get('grade_del_success'),'index.php?act=store_grade&op=store_grade_log');
		} else {
			showMessage(Language::get('grade_del_fail'),'index.php?act=store_grade&op=store_grade_log');
		}
	}
}