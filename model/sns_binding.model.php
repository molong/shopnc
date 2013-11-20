<?php
/**
 * 站外分享绑定
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class sns_bindingModel extends Model{
	public function __construct(){
		parent::__construct('member');
	}
	/**
	 * 获得可显示的绑定接口数组
	 */
	public function getUsableApp($member_id){
		if (empty($member_id)){
			return false;
		}
		$app_arr = $this->getApps();
		$app_arrnew = array();
		//判断系统是否开启站外分享功能
		foreach ($app_arr as $k=>$v){
			if (C('share_'.$k.'_isuse') == 1){
				$v['isbind'] = false;
				$app_arrnew[$k] = $v;
			}
		}
		//查询该用户的绑定信息
		$bind_list = $this->table('sns_binding')->where(array('snsbind_memberid'=>$member_id))->select();
		if (!empty($bind_list)){
			foreach ($bind_list as $k=>$v){
				if (intval($v['snsbind_updatetime'])+intval($v['snsbind_expiresin']) > time()){
					$app_arrnew[$v['snsbind_appsign']] = array_merge($app_arrnew[$v['snsbind_appsign']],$v);
					$app_arrnew[$v['snsbind_appsign']]['isbind'] = true;
				}
			}
		}
		return $app_arrnew;
	}
	/**
	 * 获得某用户已经绑定某接口详细信息
	 */
	public function getUsableOneApp($member_id,$appkey){
		$bind_info = array();
		if (empty($member_id) || empty($appkey)){
			return $bind_info;
		}
		$app_arr = $this->getApps();
		$appkey_arr = array_keys($app_arr);
		if (!in_array($appkey,$appkey_arr)){
			return $bind_info;
		}
		//查询该用户是否已经绑定
		$where_arr = array();
		$where_arr['snsbind_memberid'] = $member_id;
		$where_arr['snsbind_appsign'] = $app_key;
		$bind_info = $this->table('sns_binding')->where($where_arr)->find();
		
		if (intval($bind_info['snsbind_updatetime'])+intval($bind_info['snsbind_expiresin']) <= time()){
			$bind_info = array();
		}
		return $bind_info;
	}
	/**
	 * 分享接口数组
	 */
	public function getApps(){
		$app_arr = array();
		$app_arr['qqzone'] = array('name'=>Language::get('nc_shareset_qqzone'),'url'=>"http://qzone.qq.com",'applyurl'=>'http://connect.qq.com');
		$app_arr['qqweibo'] = array('name'=>Language::get('nc_shareset_qqweibo'),'url'=>"http://t.qq.com",'applyurl'=>'http://dev.open.t.qq.com/developer');
		$app_arr['sinaweibo'] = array('name'=>Language::get('nc_shareset_sinaweibo'),'url'=>"http://www.weibo.com",'applyurl'=>'http://open.weibo.com/developers');
		$app_arr['renren'] = array('name'=>Language::get('nc_shareset_renren'),'url'=>"http://www.renren.com",'applyurl'=>'http://dev.renren.com/app');
		return $app_arr;
	}
	/**
	 * qqweibo用图片URL发表带图片的微博
	 */
	public function addQQWeiboPic($bindinfo,$params){
		$_SESSION['qqweibo']['t_access_token'] = $bindinfo['snsbind_accesstoken'];
		$_SESSION['qqweibo']['t_openid'] = $bindinfo['snsbind_openid'];
		include_once(BasePath.DS.'api'.DS.'snsapi'.DS.'qqweibo'.DS.'tencent.php');
	    $params_qqweibo['content'] = $params['title'].$params['comment'].$params['url'];
	    $params_qqweibo['pic_url'] = $params['images'];
	    Tencent::api('t/add_pic_url', $params_qqweibo, 'POST');
	}
	/**
	 * qqzone发布一条动态
	 */
	public function addQQZoneFeed($bindinfo,$params){
		$_SESSION['qqzone']['access_token'] = $bindinfo['snsbind_accesstoken'];
		$_SESSION['qqzone']['appid'] = C('share_qqzone_appid');
		$_SESSION['qqzone']['openid'] = $bindinfo['snsbind_openid'];
		include_once(BasePath.DS.'api'.DS.'snsapi'.DS.'qqzone'.DS.'share'.DS.'add_share.php');
	    add_share($params);
	}
	/**
	 * sinaweibo上传图片并发布一条新微博
	 */
	public function addSinaWeiboUpload($bindinfo,$params){
		include_once(BasePath.DS.'api'.DS.'snsapi'.DS.'sinaweibo'.DS.'config.php');
		include_once(BasePath.DS.'api'.DS.'snsapi'.DS.'sinaweibo'.DS.'saetv2.ex.class.php');
		$c = new SaeTClientV2( C('share_sinaweibo_appid') , C('share_sinaweibo_appkey') , $bindinfo['snsbind_accesstoken']);
		$c->upload($params['title'].$params['comment'].$params['url'],$params['images']);
	}
	/**
	 * renren发布一条新鲜事
	 */
	public function addRenrenFeed($bindinfo,$params){
		include_once(BasePath.DS.'api'.DS.'snsapi'.DS.'renren'.DS.'class'.DS.'RenrenRestApiService.class.php');
		$params_renren = array();
		$params_renren['access_token'] = $bindinfo['snsbind_accesstoken'];
		$params_renren['name'] = $params['title'];
		$params_renren['description'] = $params['comment'];
		$params_renren['url'] = $params['url'];
		$params_renren['image'] = $params['images'];
		$renren_obj = new RenrenRestApiService;
		$renren_obj->rr_post_fopen('feed.publishFeed', $params_renren);
	}
}