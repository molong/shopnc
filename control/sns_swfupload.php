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

class sns_swfuploadControl extends BaseHomeControl {
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
		Language::read('sns_home');
		$lang	= Language::getLangContent();
		$member_id	= intval($_POST['mid']);
		$class_id	= intval($_POST['category_id']);
		if ($member_id <= 0 && $class_id <= 0){
			echo json_encode(array('state'=>'false','message'=>Language::get('sns_upload_pic_fail')));
			exit;
		}
		
		$model = Model();
		// 验证图片数量
		$count = $model->table('sns_albumpic')->where(array('member_id'=>$member_id))->count();
		if(C('malbum_max_sum') != 0 && $count >= C('malbum_max_sum')){
			echo json_encode(array('state'=>'false','message'=>Language::get('sns_upload_img_max_num_error')));
			exit;
		}
		
		/**
		 * 上传图片
		 */
		$upload = new UploadFile();
		$upload_dir = ATTACH_MALBUM.DS.$member_id.DS;

		$upload->set('default_dir',$upload_dir.$upload->getSysSetPath());
		$thumb_width	= '240,1024';
		$thumb_height	= '2048,1024';

		$upload->set('max_size',C('image_max_filesize'));
		$upload->set('thumb_width',	$thumb_width);
		$upload->set('thumb_height',$thumb_height);
		$upload->set('fprefix',$member_id);
		$upload->set('thumb_ext',	'_240x240,_max');	
		$result = $upload->upfile('Filedata');
		if (!$result){
			echo json_encode(array('state'=>'false','message'=>Language::get('sns_upload_pic_fail')));
			exit;
		}
		
		$img_path 		= $upload->getSysSetPath().$upload->file_name;
		list($width, $height, $type, $attr) = getimagesize(BasePath.DS.ATTACH_MALBUM.DS.$member_id.DS.$img_path);
		
// 		if (C('ftp_open') && C('thumb.save_type')==3){
// 			import('function.ftp');
// 			if (remote_ftp(ATTACH_GOODS.DS.$sid,$img_path)){
// 				echo json_encode(array('state'=>'false','message'=>$lang['iswfupload_upload_pic_fail']));
// 				exit;
// 			}
// 		}


		$image = explode('.', $_FILES["Filedata"]["name"]);
		
		
		if(strtoupper(CHARSET) == 'GBK'){
			$image['0'] = Language::getGBK($image['0']);
		}
		$insert = array();
		$insert['ap_name']		= $image['0'];
		$insert['ac_id']		= $class_id;
		$insert['ap_cover']		= $img_path;
		$insert['ap_size']		= intval($_FILES['Filedata']['size']);
		$insert['ap_spec']		= $width.'x'.$height;
		$insert['upload_time']	= time();
		$insert['member_id']	= $member_id;
		$result = $model->table('sns_albumpic')->insert($insert);

		$data = array();
		$data['file_id']	= $result;
		$data['file_name']	= $img_path;
		$data['file_path']	= $img_path;
		$data['state']		= 'true';
		/**
		 * 整理为json格式
		 */
		$output = json_encode($data);
		echo $output;
		
	}
}
?>