<?php
/**
 * 图片批量上传
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

class swfupload2Control extends BaseHomeControl {
	/**
	 * 上传图片
	 *
	 * @param 
	 * @return 
	 */ 	
	public function swfuploadOp() {
		/**
		 * 读取语言包
		 */
		Language::read('iswfupload');
		$lang	= Language::getLangContent();
		if (isset($_POST["PHPSESSID"])) {
			session_id($_POST["PHPSESSID"]);
		}
		$sid = intval($_POST['sid']);
		if (!empty($_POST['category_id']) && !empty($_POST['sid'])){
			$category_id 	= intval($_POST['category_id']);
			$store_id		= $sid;
		}else {
			echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_upload_pic_fail']));
			exit;
		}
		//判断图片数量是否超限
		$model = Model();
		$store_grade = ($setting = F('store_grade')) ? $setting : H('store_grade',true,'file');
		$grade_id = $model->table('store')->getfby_store_id($store_id,'grade_id');
		$album_limit = $store_grade[$grade_id]['sg_album_limit'];
		$album_count = $model->table('album_pic')->where(array('store_id'=>$store_id))->count();
		if ($album_count >= $album_limit){
			//目前并不出该提示，而是提示上传0张图片
			$error = Language::get('store_goods_album_climit');
			if (strtoupper(CHARSET) == 'GBK') $error = Language::getUTF8($error);
			exit(json_encode(array('state'=>'false','message'=>$error)));
		}

		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload_dir = ATTACH_GOODS.DS.$store_id.DS;

		$upload->set('default_dir',$upload_dir.$upload->getSysSetPath());
		if (trim($_GET['instance'])=='goods_image') {
			$thumb_width	= C('thumb_small_width').','.C('thumb_mid_width').','.C('thumb_max_width').','.C('thumb_tiny_width').',240';
			$thumb_height	= C('thumb_small_height').','.C('thumb_mid_height').','.C('thumb_max_height').','.C('thumb_tiny_height').',1024';

			$upload->set('max_size',C('image_max_filesize'));
			$upload->set('thumb_width',	$thumb_width);
			$upload->set('thumb_height',$thumb_height);
			$upload->set('fprefix',$sid);
			$upload->set('thumb_ext',	'_small,_mid,_max,_tiny,_240x240');	
		}
		$result = $upload->upfile('Filedata');
		if ($result){
				$_POST['pic'] 		= $upload->getSysSetPath().$upload->file_name;
				$_POST['pic_thumb'] = $upload->getSysSetPath().$upload->thumb_image;
		}else {
			//目前并不出该提示
			echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_upload_pic_fail']));
			exit;
		}
		
		$img_path = $_POST['pic'];
		list($width, $height, $type, $attr) = getimagesize(BasePath.DS.'upload'.DS.'store'.DS.'goods'.DS.$store_id.DS.$img_path);
		
		if (C('ftp_open') && C('thumb.save_type')==3){
			import('function.ftp');
			if (!remote_ftp(ATTACH_GOODS.DS.$sid,$img_path)){
				echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_upload_pic_fail']));
				exit;
			}
		}

		$model_upload_album = Model('upload_album');

		$image = explode('.', $_FILES["Filedata"]["name"]);
		if(strtoupper(CHARSET) == 'GBK'){
			$image['0'] = Language::getGBK($image['0']);
		}
		$insert_array = array();
		$insert_array['apic_name']	= $image['0'];
		$insert_array['apic_tag']	= '';
		$insert_array['aclass_id']	= $category_id;
		$insert_array['apic_cover']	= $img_path;
		$insert_array['apic_size']	= intval($_FILES['Filedata']['size']);
		$insert_array['apic_spec']	= $width.'x'.$height;
		$insert_array['upload_time']= time();
		$insert_array['store_id']	= $store_id;
		$result = $model_upload_album->add($insert_array);

		$data = array();
		$data['file_id'] = $result;
		$data['file_name'] = $_POST['pic'];
		$data['file_path'] = $_POST['pic'];
		$data['instance'] = $_GET['instance'];
		$data['state'] = 'true';
		/**
		 * 整理为json格式
		 */
		$output = json_encode($data);
		echo $output;
		
	}
}
?>