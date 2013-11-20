<?php
/**
 * 商品推荐管理
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
class recommendControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('recommend');
	}
	/**
	 * 推荐类型列表
	 */
	public function recommendOp(){
		$lang	= Language::getLangContent();
		$model_recommend = Model('recommend');
		/**
		 * 删除
		 */
		if ($_POST['form_submit'] == 'ok'){
			if (!empty($_POST['del_recommend_id'])){
				if (is_array($_POST['del_recommend_id'])){
					foreach ($_POST['del_recommend_id'] as $k => $v){
						$model_recommend->del(intval($v));
					}
				}
				showMessage($lang['recommend_index_del_succ']);
			}else {
				showMessage($lang['recommend_index_choose_del']);
			}
		}
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$condition['like_recommend_name'] = trim($_GET['search_recommend_name']);
		$recommend_list = $model_recommend->getRecommendList($condition,'simple',$page);
		
		Tpl::output('show_page',$page->show());
		Tpl::output('recommend_retrieval',array('best_item','clothing_item','ornament_item','cosmetic_item','sports_item','electron_item','furniture_item','food_item','gravida_item'));
		Tpl::output('recommend_list',$recommend_list);
		Tpl::output('search_recommend_name',trim($_GET['search_recommend_name']));
		Tpl::showpage('recommend.index');
	}
	
	/**
	 * 增加推荐类型
	 */
	public function recommend_addOp(){
		$lang	= Language::getLangContent();
		$model_recommend = Model('recommend');
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["recommend_name"], "require"=>"true", "message"=>$lang['recommend_add_name_null'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				
				$insert_array = array();
				$insert_array['recommend_name'] = trim($_POST['recommend_name']);
				$insert_array['recommend_desc'] = trim($_POST['recommend_desc']);
				$insert_array['recommend_code'] = time();
				$config	= '';
				$config_array = explode(',',$_POST["config_name"]);//配置参数
				if(is_array($config_array) && !empty($config_array)) {
					$config_info = array();
					foreach ($config_array as $k) {
						$config_info[$k] = trim($_POST[$k]);
					}
					$config	= serialize($config_info);
					$insert_array['recommend_config'] = $config;
				}
				
				$result = $model_recommend->add($insert_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=recommend&op=recommend_add',
							'msg'=>$lang['recommend_add_again'],
						),
						array(
							'url'=>'index.php?act=recommend&op=recommend',
							'msg'=>$lang['recommend_add_back_to_list'],
						)
					);
					showMessage($lang['recommend_add_succ'],$url);
				}else {
					showMessage($lang['recommend_add_fail']);
				}
			}
		}
		Tpl::showpage('recommend.add');
	}
	
	/**
	 * 推荐类型编辑
	 */
	public function recommend_editOp(){
		$lang	= Language::getLangContent();
		$model_recommend = Model('recommend');
		
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["recommend_name"], "require"=>"true", "message"=>$lang['recommend_add_name_null'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				
				$update_array = array();
				$update_array['recommend_id'] = intval($_POST['recommend_id']);
				$update_array['recommend_name'] = trim($_POST['recommend_name']);
				$update_array['recommend_desc'] = trim($_POST['recommend_desc']);
				$config	= '';
				$config_array = explode(',',$_POST["config_name"]);//配置参数
				if(is_array($config_array) && !empty($config_array)) {
					$config_info = array();
					foreach ($config_array as $k) {
						$config_info[$k] = trim($_POST[$k]);
					}
					$config	= serialize($config_info);
					$update_array['recommend_config'] = $config;
				}
				
				$result = $model_recommend->update($update_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=recommend&op=recommend',
							'msg'=>$lang['recommend_add_back_to_list'],
						),
						array(
							'url'=>'index.php?act=recommend&op=recommend_edit&recommend_id='.$_POST['recommend_id'],
							'msg'=>$lang['recommend_edit_again'],
						),
					);
					showMessage($lang['recommend_edit_succ'],$url);
				}else {
					showMessage($lang['recommend_edit_fail']);
				}
			}
		}
		
		$recommend_array = $model_recommend->getOneRecommend(intval($_GET['recommend_id']));
		if (empty($recommend_array)){
			showMessage($lang['wrong_argument']);
		}
		$config_array	= unserialize($recommend_array['recommend_config']);
		Tpl::output('config_array',$config_array);
		Tpl::output('recommend_array',$recommend_array);
		Tpl::showpage('recommend.edit');
	}
	
	/**
	 * 删除推荐类型
	 */
	public function recommend_delOp(){
		$lang	= Language::getLangContent();
		$model_recommend = Model('recommend');
		if (intval($_GET['del_recommend_id']) > 0){
			$model_recommend->del(intval($_GET['del_recommend_id']));
			$model_recommend->delRecommendGoods(intval($_GET['del_recommend_id']));
			unset($brand_array);
			showMessage($lang['recommend_index_del_succ'],'index.php?act=recommend&op=recommend');
		}else {
			showMessage($lang['recommend_index_choose_del'],'index.php?act=recommend&op=recommend');
		}
	}
	
	/**
	 * 查看推荐商品
	 */
	public function recommend_goodsOp(){
		$lang	= Language::getLangContent();
		$model_recommend = Model('recommend');
		/**
		 * 取消推荐
		 */
		if ($_POST['form_submit'] == 'ok'){
			if (is_array($_POST['goods_id'])){
				foreach ($_POST['goods_id'] as $k => $v){
					$model_recommend->delRecommendGoods(intval($_POST['recommend_id']),intval($v));
				}
				showMessage($lang['recommend_goods_cancel_succ']);
			}else {
				showMessage($lang['recommend_goods_choose_cancel']);
			}
		}
		/**
		 * 推荐类型列表
		 */
//		$condition['like_recommend_name'] = $_POST['search_recommend_name'];
		$recommend_list = $model_recommend->getRecommendList(array());
		
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		/**
		 * 商品列表
		 */
		$condition['recommend_id'] = intval($_GET['recommend_id']);
		$condition['order']	= 'recommend_goods.sort';
		$goods_list = $model_recommend->getRecommendGoodsList($condition,$page);
		
		Tpl::output('goods_list',$goods_list);
		Tpl::output('recommend_id',intval($_GET['recommend_id']));
		Tpl::output('recommend_list',$recommend_list);
		Tpl::output('show_page',$page->show());
		Tpl::showpage('recommend.goods');
	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['type']){
			/**
			 * 验证推荐类别名称是否有重复
			 */
			case 'check_recommend':
				$model_recommend = Model('recommend');
				$condition['recommend_name'] = trim($_GET['recommend_name']);
				$condition['no_recommend_id'] = intval($_GET['id']);
				$result = $model_recommend->getRecommendList($condition);
				if (empty($result)){
					echo 'true';exit;
				}else {
					echo 'false';exit;	
				}
				break;
			/**
			 * 商品名称
			 */
			case 'goods_name':
				$model_goods	= Model('goods');
				$update_array	= array();
				$update_array[$_GET['column']] = trim($_GET['value']);
				$model_goods->updateGoods($update_array,intval($_GET['id']));
				echo 'true';exit;
				break;
		}
		switch($_GET['branch']){
			case 'sort':
				$recommend_model	= Model('recommend');
				$param	= array();
				$param[$_GET['column']]	= trim($_GET['value']);
				$_GET['id']	= explode(',',$_GET['id']);
				if(count($_GET['id'])!=2){
					echo 'false';exit;
				}
				$param['goods_id']	= $_GET['id'][0];
				$param['recommend_id']	= $_GET['id'][1];
				$result	= $recommend_model->updateRecommendGoods($param);
				if($result!==false){
					echo 'true';exit;
				}else{
					echo 'false';exit;
				}
				break;
		}
	}
	
}