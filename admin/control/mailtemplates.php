<?php
/**
 * 邮件模板
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
class mailtemplatesControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('mailtemplates');
	}
	/**
	 * 邮件模板 列表
	 *
	 * @param 
	 * @return 
	 */
	public function mailtemplatesOp(){
		$model_templates = Model('mail_templates');
		$condition['type'] = '0';
		$templates_list = $model_templates->getTemplatesList($condition);
		Tpl::output('templates_list',$templates_list);
		Tpl::showpage('mail_templates.index');
	}
	
	/**
	 * 编辑邮件模板
	 *
	 * @param 
	 * @return 
	 */
	public function mailtemplates_editOp(){
		$lang	= Language::getLangContent();
		$model_templates = Model('mail_templates');
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["code"], "require"=>"true", "message"=>$lang['mailtemplates_edit_no_null']),
				array("input"=>$_POST["title"], "require"=>"true", "message"=>$lang['mailtemplates_edit_title_null']),
				array("input"=>$_POST["content"], "require"=>"true", "message"=>$lang['mailtemplates_edit_content_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$update_array = array();
				$update_array['code'] = trim($_POST["code"]);
				$update_array['title'] = trim($_POST["title"]);
				$update_array['content'] = trim($_POST["content"]);
				$result = $model_templates->update($update_array);
				if ($result === true){
					showMessage($lang['mailtemplates_edit_succ'],'index.php?act=mailtemplates&op=mailtemplates');
				}else {
					showMessage($lang['mailtemplates_edit_fail']);
				}
			}
		}
		if (empty($_GET['code'])){
			showMessage($lang['mailtemplates_edit_code_null']);
		}
		$templates_array = $model_templates->getOneTemplates(trim($_GET['code']));
		Tpl::output('templates_array',$templates_array);
		Tpl::showpage('mail_templates.edit');
	}
	
	/**
	 * 短信模板 列表
	 *
	 * @param 
	 * @return 
	 */
	public function msgtemplatesOp(){
		$model_templates = Model('mail_templates');
		$condition['type'] = '1';
		$templates_list = $model_templates->getTemplatesList($condition);
		Tpl::output('templates_list',$templates_list);
		Tpl::showpage('msg_templates.index');
	}
	
	/**
	 * 编辑邮件模板
	 *
	 * @param 
	 * @return 
	 */
	public function msgtemplates_editOp(){
		$lang	= Language::getLangContent();
		$model_templates = Model('mail_templates');
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["code"], "require"=>"true", "message"=>$lang['mailtemplates_msg_edit_no_null']),
				array("input"=>$_POST["content"], "require"=>"true", "message"=>$lang['mailtemplates_msg_edit_content_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$update_array = array();
				$update_array['code'] = trim($_POST["code"]);
				$update_array['content'] = trim($_POST["content"]);
				$result = $model_templates->update($update_array);
				if ($result === true){
					showMessage($lang['mailtemplates_edit_succ'],'index.php?act=mailtemplates&op=msgtemplates');
				}else {
					showMessage($lang['mailtemplates_edit_fail']);
				}
			}
		}
		if (empty($_GET['code'])){
			showMessage($lang['mailtemplates_edit_code_null']);
		}
		$templates_array = $model_templates->getOneTemplates(trim($_GET['code']));
		Tpl::output('templates_array',$templates_array);
		Tpl::showpage('msg_templates.edit');
	}
	
	public function ajaxOp(){
		$lang	= Language::getLangContent();
		$model_templates = Model('mail_templates');
		if ($_POST['form_submit'] == 'ok'){
			if($_POST['submit_type'] == 'mail_switchON' || $_POST['submit_type'] == 'mail_switchOFF'){
				if (is_array($_POST['del_id'])){
					$param	= array();
					$param['mail_switch'] = $_POST['submit_type'] == 'mail_switchON'?'1':'0';
					foreach ($_POST['del_id'] as $k=>$v){
						$param['code'] = $v;
						$model_templates->update($param);
					}
					showMessage($lang['mailtemplates_index_succ']);
				}else {
					showMessage($lang['mailtemplates_index_fail']);
				}
			}	
		}
		if ($_GET['branch'] == "mail_switch"){
			$update_array = array();
			$update_array['code'] = trim($_GET['id']);
			$update_array[$_GET['column']] = trim($_GET['value']);
			$model_templates->update($update_array);
			echo 'true';
			exit;
		}
	}
}