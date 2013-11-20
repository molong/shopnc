<?php
/**
 * 文件的简短描述
 *
 * 文件的详细描述
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
// 图片上传session传递
if (isset($_POST["PHPSESSID"])) {
	session_id($_POST["PHPSESSID"]);
}else {
	exit();
}
class swfuploadControl{
	/**
	 * 文章图片上传
	 */
	public function article_pic_uploadOp(){
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_ARTICLE);
		$result = $upload->upfile('Filedata');
		if ($result){
			$_POST['pic'] = $upload->file_name;
		}else {
			echo 'error';exit;
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
		$insert_array['upload_type'] = '1';
		$insert_array['file_size'] = $_FILES['Filedata']['size'];
		$insert_array['upload_time'] = time();
		$insert_array['item_id'] = intval($_POST['item_id']);
		$result = $model_upload->add($insert_array);
		if ($result){
			$data = array();
			$data['file_id'] = $result;
			$data['file_name'] = $_POST['pic'];
			$data['file_path'] = $_POST['pic'];
			/**
			 * 整理为json格式
			 */
			$output = json_encode($data);
			echo $output;
		}
		
	}
	/**
	 * 系统文章图片上传
	 */
	public function document_pic_uploadOp(){
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_ARTICLE);

		$result = $upload->upfile('Filedata');
		if ($result){
			$_POST['pic'] = $upload->file_name;
		}else {
			echo 'error';exit;
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
		$insert_array['file_size'] = $_FILES['Filedata']['size'];
		$insert_array['item_id'] = intval($_POST['item_id']);
		$insert_array['upload_time'] = time();
		$result = $model_upload->add($insert_array);
		if ($result){
			$data = array();
			$data['file_id'] = $result;
			$data['file_name'] = $_POST['pic'];
			$data['file_path'] = $_POST['pic'];
			/**
			 * 整理为json格式
			 */
			$output = json_encode($data);
			echo $output;
		}
		
	}
	/**
	 * 积分礼品上传
	 */
	public function pointprod_pic_uploadOp(){
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_POINTPROD);

		$result = $upload->upfile('Filedata');
		if ($result){
			$_POST['pic'] = $upload->file_name;
		}else {
			echo 'error';exit;
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
		$insert_array['upload_type'] = '6';
		$insert_array['file_size'] = $_FILES['Filedata']['size'];
		$insert_array['upload_time'] = time();
		$insert_array['item_id'] = intval($_POST['item_id']);
		$result = $model_upload->add($insert_array);
		if ($result){
			$data = array();
			$data['file_id'] = $result;
			$data['file_name'] = $_POST['pic'];
			$data['file_path'] = $_POST['pic'];
			/**
			 * 整理为json格式
			 */
			$output = json_encode($data);
			echo $output;
		}
	}
}
