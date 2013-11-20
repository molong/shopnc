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

class iswfuploadControl {
	/**
	 * 批量导入图片
	 *
	 * @param 
	 * @return 
	 */ 	
	public function import_pic_uploadOp() {
		/**
		 * 读取语言包
		 */
		Language::read('common','iswfupload');
		$lang	= Language::getLangContent('UTF-8');

		/**
		 * 检查图片是否是商品图片
		 */
		$model_upload = Model('upload');
		if($_POST['Filename'] == ''){
			echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_miss_file']));
			exit;
		}
		$upload_list	= $model_upload->getUploadList(array('file_name'=>substr($_POST['Filename'],0,strlen($_POST['Filename'])-4)));
		if(empty($upload_list) or !is_array($upload_list)){
			echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_image'].$_POST['Filename'].$lang['iswfupload_not_goods_image']));
			exit;
		}
		$upload_info	= $upload_list[0];
		if(empty($upload_info) or !is_array($upload_info)){
			echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_image'].$_POST['Filename'].$lang['iswfupload_not_goods_image']));
			exit;
		}
		if($upload_info['upload_type'] != '2'){
			echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_image'].$_POST['Filename'].$lang['iswfupload_not_goods_image']));
			exit;
		}
		if(empty($upload_info['store_id'])){
			echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_upload_pictext'].$_POST['Filename'].$lang['iswfupload_upload_noprodpic']));
			exit;
		}
		$store_id	= $upload_info['store_id'];
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload_dir = ATTACH_GOODS.DS.$store_id;
		if(!is_dir($upload_dir)){
			mkdir($upload_dir,0755);
		}
		$upload = new UploadFile();
		$upload->set('default_dir',$upload_dir.DS.$upload->getSysSetPath());
		$upload->set('max_size',C('image_max_filesize'));
		$thumb_width	= C('thumb_small_width').','.C('thumb_mid_width').','.C('thumb_max_width').','.C('thumb_tiny_width').',240';
		$thumb_height	= C('thumb_small_height').','.C('thumb_mid_height').','.C('thumb_max_height').','.C('thumb_tiny_height').',50000';

		$upload->set('thumb_width',	$thumb_width);
		$upload->set('thumb_height',$thumb_height);
		$upload->set('thumb_ext',	'_small,_mid,_max,_tiny,_240x240');	
		$upload->set('new_ext','jpg');
		/**
		 * 设置允许上传的文件类型
		 */
		$result = $upload->upfile('Filedata');
		if (!$result){
			echo json_encode(array('state'=>'false','message'=>$upload->error));
			exit;
		}
		/**
		 * 取得图像大小
		 */
		list($width, $height, $type, $attr) = getimagesize(BasePath.DS.'upload'.DS.'store'.DS.'goods'.DS.$store_id.DS.$upload->getSysSetPath().$upload->file_name);
		
		if (C('ftp_open') && C('thumb.save_type')==3){
			import('function.ftp');
			$img_path = $upload->getSysSetPath().$upload->file_name;
			if ($_url = remote_ftp(ATTACH_GOODS.DS.$store_id,$img_path,false)){
				$image_cover = $_url.'/';
			}
		}		

		/**
		 * 模型实例化
		 */
		$model_upload_album = Model('upload_album');
		/**
		 * 图片数据入库
		 */
		$image = explode('.', $_FILES["Filedata"]["name"]);
		$insert_array = array();
		$insert_array['apic_name']	= $image['0'];
		$insert_array['apic_tag']	= '';
		$insert_array['aclass_id']	= $_POST['category_id'];
		$insert_array['apic_cover']	= $img_path;
		$insert_array['apic_size']	= intval($_FILES['Filedata']['size']);
		$insert_array['apic_spec']	= $width.'x'.$height;
		$insert_array['upload_time']= time();
		$insert_array['store_id']	= $store_id;
		$result = $model_upload_album->add($insert_array);

		/**
		 * 图片数据入库
		 */
		$insert_array = array();
		$insert_array['file_name']	= $upload->getSysSetPath().$upload->file_name;
		$insert_array['file_thumb']	= $upload->getSysSetPath().$upload->thumb_image;
		$insert_array['file_wm']	= $_POST['pic_wm'];
		$insert_array['file_size']	= $_FILES['Filedata']['size'];
		$insert_array['upload_time']= time();
		foreach($upload_list as $val){
			$insert_array['upload_id']	= $val['upload_id'];
			$result = $model_upload->update($insert_array);
			if ($result){
				if($result){
					$data = array();
					$data['file_id'] = $val['upload_id'];
					$data['file_name'] = $upload->getSysSetPath().$upload->file_name;
					$data['file_path'] = $upload->getSysSetPath().$upload->file_name;
					/**
					 * 整理为json格式
					 */
					$output = json_encode($data);
					echo $output;
				}else{
					echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_update_fail']));
				exit;
				}
			}else{
				echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_upload_fail']));
				exit;
			}
		}
	}
}
?>
