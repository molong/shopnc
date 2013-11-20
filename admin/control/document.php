<?php
/**
 * 系统文章管理
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
class documentControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('document');
	}
	/**
	 * 系统文章管理首页
	 */
	public function indexOp(){
		$this->documentOp();
		exit;
	}
	/**
	 * 系统文章列表
	 */
	public function documentOp(){
		$model_doc	= Model('document');
		$doc_list	= $model_doc->getList();
		Tpl::output('doc_list',$doc_list);
		Tpl::showpage('document.index');
	}
	/**
	 * 系统文章编辑
	 */
	public function editOp(){
		$lang	= Language::getLangContent();
		/**
		 * 更新
		 */
		if($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["doc_title"], "require"=>"true", "message"=>$lang['document_index_title_null']),
				array("input"=>$_POST["doc_content"], "require"=>"true", "message"=>$lang['document_index_content_null'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				
				$param	= array();
				$param['doc_id']	= intval($_POST['doc_id']);
				$param['doc_title']	= trim($_POST['doc_title']);
				$param['doc_content']= trim($_POST['doc_content']);
				$param['doc_time']	= time();
				$model_doc	= Model('document');
				
				$result	= $model_doc->update($param);
				
				if ($result){
					/**
					 * 更新图片信息ID
					 */
					$model_upload = Model('upload');
					if (is_array($_POST['file_id'])){
						foreach ($_POST['file_id'] as $k => $v){
							$v = intval($v);
							$update_array = array();
							$update_array['upload_id'] = $v;
							$update_array['item_id'] = intval($_POST['doc_id']);
							$model_upload->update($update_array);
							unset($update_array);
						}
					}
					
					$url = array(
						array(
							'url'=>'index.php?act=document&op=document',
							'msg'=>$lang['document_edit_back_to_list']
						),
						array(
							'url'=>'index.php?act=document&op=edit&doc_id='.intval($_POST['doc_id']),
							'msg'=>$lang['document_edit_again']
						),
					);
					showMessage($lang['document_edit_succ'],$url);
				}else {
					showMessage($lang['document_edit_fail']);
				}
			}
		}
		/**
		 * 编辑
		 */
		if(empty($_GET['doc_id'])){
			showMessage($lang['miss_argument']);
		}
		$model_doc	= Model('document');
		$doc	= $model_doc->getOneById(intval($_GET['doc_id']));
		
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$condition['upload_type'] = '4';
		$condition['item_id'] = $doc['doc_id'];
		$file_upload = $model_upload->getUploadList($condition);
		if (is_array($file_upload)){
			foreach ($file_upload as $k => $v){
				$file_upload[$k]['upload_path'] = SiteUrl.'/'.ATTACH_ARTICLE.'/'.$file_upload[$k]['file_name'];
			}
		}
		
		Tpl::output('PHPSESSID',session_id());
		Tpl::output('file_upload',$file_upload);		
		Tpl::output('doc',$doc);
		Tpl::showpage('document.edit');
	}
	/**
	 * 上传文件内嵌页面
	 */
	public function document_iframe_uploadOp(){
		$lang	= Language::getLangContent();
		/**
		 * 上传
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 上传图片
			 */
			$upload = new UploadFile();
			$upload->set('default_dir',ATTACH_ARTICLE);

			$result = $upload->upfile('file');
			if ($result){
				$_POST['pic'] = $upload->file_name;
			}else {
				echo "<script type='text/javascript'>alert('". $upload->error ."');history.back();</script>";
				exit;
			}
			/**
			 * 模型实例化
			 */
			$model_upload = Model('upload');
			/**
			 * 图片数据入库
			 */
			$insert_array = array();
			$insert_array['file_name'] = $_POST['pic'];
			$insert_array['upload_type'] = '4';
			$insert_array['file_size'] = $_FILES['file']['size'];
			$insert_array['upload_time'] = time();
			
			$result = $model_upload->add($insert_array);
			if ($result){
				$data = array();
				$data['file_id'] = $result;
				$data['file_name'] = $_POST['pic'];				
				/**
				 * 整理为json格式
				 */
				$output = json_encode($data);
				echo "<script type='text/javascript'>window.parent.add_uploadedfile('" . $output . "');</script>";
			}else {
				echo "<script type='text/javascript'>alert('".$lang['document_iframe_upload_fail']."');</script>";
			}
		}
		
		Tpl::output('doc_id',intval($_GET['doc_id']));
		Tpl::showpage('document.iframe_upload','blank_layout');
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 删除文章图片
			 */
			case 'del_file_upload':
				if (intval($_GET['file_id']) > 0){
					$model_upload = Model('upload');
					/**
					 * 删除图片
					 */
					$file_array = $model_upload->getOneUpload(intval($_GET['file_id']));
					@unlink(BasePath.DS.ATTACH_ARTICLE.DS.$file_array['file_name']);
					/**
					 * 删除信息
					 */
					$model_upload->del(intval($_GET['file_id']));
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
		}
	}
}