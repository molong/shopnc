<?php
/**
 * 微商城公共方法
 *
 * 公共方法
 *
 * @package    function
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net/
 * @link       http://www.shopnc.net/
 * @author	   ShopNC Team
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

function getMicroshopDefaultImage() {
	return ATTACH_COMMON.DS.C('default_goods_image').'_small'.get_image_type(C('default_goods_image'));
}

function getPersonalImageUrl($personal_info,$type=''){ 
    $ext_array = array('list','tiny');
    $personal_image_array = array();
    $personal_image_list = explode(',',$personal_info['commend_image']);
    if(!empty($personal_image_list)){
        if(is_array($personal_image_list)) {
            foreach ($personal_image_list as $value) {
                if(!empty($type) && in_array($type,$ext_array)) {
                    $file_name = explode(".",$value);
                    $ext = end($file_name);
                    $value .= '_'.$type.'.'.$ext;
                }
                $personal_image_array[] = MICROSHOP_IMG_URL.DS.ATTACH_MICROSHOP.DS.$personal_info['commend_member_id'].DS.$value;
            }
        } else {
                if(!empty($type) && in_array($type,$ext_array)) {
                    $file_name = explode(".",$personal_info['commend_image']);
                    $ext = end($file_name);
                    $personal_info['commend_image'].= '_'.$type.'.'.$ext;
                }
            $personal_image_array[] = MICROSHOP_IMG_URL.DS.ATTACH_MICROSHOP.DS.$personal_info['commend_member_id'].DS.$personal_info['commend_image'];
        }
    } else {
        $personal_image_array[] = getMicroshopDefaultImage();
    }
    return $personal_image_array;
}

function getRefUrl() {
    return urlencode('http://'.$_SERVER['HTTP_HOST'].request_uri());
}
