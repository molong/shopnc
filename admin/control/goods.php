<?php
/**
 * 商品栏目管理
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
class goodsControl extends SystemControl{
	const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();
		Language::read('goods');
	}
	/**
	 * 商品管理
	 */
	public function goodsOp(){
		$lang	= Language::getLangContent();
		$model_goods = Model('goods');
		/**
		 * 推荐，编辑，删除
		 */
		if (chksubmit()){
			switch ($_POST['type']){
				/**
				 * 推荐
				 */
				case 'recommend':
					if (!empty($_POST['del_id'])){
						@header("Location: index.php?act=goods&op=goods_recommend&goods_id=".implode(',',$_POST['del_id']));
						exit;
					}else {
						showMessage($lang['goods_index_choose_recommend']);
					}
					break;
				/**
				 * 编辑
				 */
				case 'edit':
					if (!empty($_POST['del_id'])){
						/**
						 * 判断是否为禁售商品
						 */
						if ($_POST['goods_state'] == '0'){
							@header("Location: index.php?act=goods&op=goods_edit&goods_id=".implode(',',$_POST['del_id']).'&goods_state=0');
						}else {
							@header("Location: index.php?act=goods&op=goods_edit&goods_id=".implode(',',$_POST['del_id']));
						}
						exit;
					}else {
						showMessage($lang['goods_index_choose_edit']);
					}
					exit;
					break;
				/**
				 * 删除
				 */
				case 'del':
					if (!empty($_POST['del_id'])){
						if(!empty($_POST['del_id']) && is_array($_POST['del_id'])){
							foreach($_POST['del_id'] as $goods_id){
								//获取商品名称
								$goods_id = intval($goods_id);
								$goods_info = $model_goods->getGoods(array(
									'goods_id'=>$goods_id
								));
								$msg_code = 'msg_toseller_goods_droped_notify';
								//内容
								$param = array(
									'goods_name'=>$goods_info[0]['goods_name'],
									'reason'=>$lang['goods_index_goods_vialotion']
								);
								$model_store = Model('store');
								$store_info = $model_store->shopStore(array(
									'store_id'=>$goods_info[0]['store_id']
								));
								self::send_notice($store_info['member_id'],$msg_code,$param);
							}
						}
						$model_goods->dropGoods(implode(',',$_POST['del_id']));
						showMessage($lang['goods_index_del_succ']);
					}else {
						showMessage($lang['goods_index_choose_del']);
					}
					break;
					default:
						showMessage($lang['goods_index_argument_invalid']);
			}
		}
		
		/**
		 * 查询条件
		 */
		$condition['keyword'] = trim($_GET['search_goods_name']);
		$condition['like_store_name'] = trim($_GET['search_store_name']); //店铺名称
		$condition['brand_id'] = intval($_GET['search_brand_id']);
		$condition['gc_id'] = intval($_GET['cate_id']);
		if ($_GET['search_show'] == '0' || $_GET['search_show'] == '1') {//上架:1是,0否
			$condition['goods_show'] = $_GET['search_show'];
		}
		if ($_GET['search_lock'] == '0' || $_GET['search_lock'] == '1') {//禁售:1是,0否
			$condition['goods_state'] = $_GET['search_lock'];
		}
		/**
		 * 判断是否为禁售商品链接
		 */
		if ($_GET['goods_state'] == '1') $condition['goods_state'] = '1';
		
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$goods_list = $model_goods->getGoodsList($condition,$page);
		/**
		 * 商品分类
		 */
		$model_class = Model('goods_class');
		$goods_class = $model_class->getTreeClassList(1);
		/**
		 * 品牌
		 */
		$model_brand = Model('brand');
		$condition = array();
		$condition['brand_apply'] = '1';
		$brand_list = $model_brand->getBrandList($condition);
		
		Tpl::output('search',$_GET);
		Tpl::output('goods_class',$goods_class);
		Tpl::output('goods_list',$goods_list);
		Tpl::output('brand_list',$brand_list);
		Tpl::output('page',$page->show());
		
		
		if ($_GET['goods_state'] == '1'){
			Tpl::showpage('goods.close');
		}else {
			Tpl::showpage('goods.index');
		}
	}

	/**
	 * 商品 推荐操作
	 */
	public function goods_recommendOp(){
		$lang	= Language::getLangContent();
		$model_recommend = Model('recommend');
		$model_goods = Model('goods');
		/**
		 * 保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["recommend_id"], "require"=>"true", "message"=>$lang['goods_recommend_choose_type']),
				array("input"=>$_POST["goods_id"], "require"=>"true", "message"=>$lang['goods_recommend_goods_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$tmp = explode(',',$_POST['goods_id']);
				if (is_array($tmp)){
					foreach ($tmp as $k => $v){
						$count	= $model_recommend->getCount(array('recommend_id'=>$_POST["recommend_id"],'goods_id'=>$v));
						if($count<=0){
							$insert_array = array();
							$insert_array['recommend_id'] = $_POST["recommend_id"];
							$insert_array['goods_id'] = $v;
							$model_recommend->addRecommendGoods($insert_array);
							unset($insert_array);
						}
					}
				}
				showMessage($lang['goods_recommend_succ'],'index.php?act=goods&op=goods');
			}
		}
		if (empty($_GET['goods_id'])){
			showMessage($lang['goods_recommend_choose_goods']);
		}
		/**
		 * 推荐列表
		 */
		$recommend_list = $model_recommend->getRecommendList($condition);
		if (empty($recommend_list)){
			showMessage($lang['goods_recommend_type_null'],'index.php?act=recommend&op=recommend_add');
		}
		Tpl::output('recommend_list',$recommend_list);
		Tpl::output('goods_id',$_GET['goods_id']);
		Tpl::showpage('goods.recommend');
	}
	
	/**
	 * 商品编辑操作
	 */
	public function goods_editOp(){
		$lang	= Language::getLangContent();
		/**
		 * 保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			if (empty($_POST['goods_id'])){
				showMessage($lang['goods_edit_goods_null']);
			}
			$model_goods = Model('goods');
			$tmp = explode(',',$_POST['goods_id']);
			if (is_array($tmp)){
				$update_array = array();
				/**
				 * 商品分类
				 */
				if (!empty($_POST['cate_id'])){
					$update_array['gc_id'] = $_POST['cate_id'];
					$update_array['gc_name'] = $_POST['cate_name'];
				}
				/**
				 * 商品品牌
				 */
				if (!empty($_POST['brand_id'])){
					$update_array['brand_id'] = $_POST['brand_id'];
				}
				/**
				 * 商品禁售状态
				 */
				if ($_POST['set_goods_state'] >= 0){
					$update_array['goods_state'] = $_POST['set_goods_state'];
					$update_array['goods_close_reason'] = '';
          //如果违规，商品下架
          if ($_POST['set_goods_state'] == 1){
						$update_array['goods_close_reason'] = $_POST['goods_close_reason'];
	          $update_array['goods_show'] = '0';
          }
				}
				/**
				 * 更新状态
				 */
				if (!empty($update_array)){
					foreach ($tmp as $k => $v){
						$model_goods->updateGoods($update_array,$v);
					}
				}
			}
			/**
			 * 禁售商品页面链接
			 */
			if ($_POST['goods_state'] == '0'){
				showMessage($lang['goods_edit_batch_succ'], 'index.php?act=goods&op=goods&goods_state=0');

			}else {
				showMessage($lang['goods_edit_batch_succ'], 'index.php?act=goods&op=goods');
			}
		}
		if (empty($_GET['goods_id'])){
			showMessage($lang['goods_edit_goods_null']);
		}
		/**
		 * 商品分类
		 */
		$model_class = Model('goods_class');
		$goods_class = $model_class->getTreeClassList(1);
		/**
		 * 品牌
		 */
		$model_brand = Model('brand');
		$condition['brand_apply'] = '1';
		$brand_list = $model_brand->getBrandList($condition);
		
		Tpl::output('goods_class',$goods_class);
		Tpl::output('brand_list',$brand_list);
		Tpl::output('goods_id',$_GET['goods_id']);
		/**
		 * 是否为禁售商品的标识
		 */
		Tpl::output('goods_state',$_GET['goods_state']);
		Tpl::showpage('goods.edit');
	}
	
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 商品名称
			 */
			case 'goods_name':
				$model_goods = Model('goods');
				$update_array = array();
				$update_array[$_GET['column']] = trim($_GET['value']);
				$model_goods->updateGoods($update_array,intval($_GET['id']));
				echo 'true';exit;
				break;
			/**
			 * 商品上架
			 */
			case 'goods_show':
				$model_goods = Model('goods');
				$update_array = array();
				$update_array[$_GET['column']] = trim($_GET['value']);
				$model_goods->updateGoods($update_array,intval($_GET['id']));
				echo 'true';exit;
				break;
			/**
			 * 商品禁售 也就是状态关闭
			 */
			case 'goods_state':
				$model_goods = Model('goods');
				$update_array = array();
                $update_array[$_GET['column']] = trim($_GET['value']);
                //如果违规，商品下架
                if ($_GET['value'] == 1){
                	$update_array['goods_show'] = '0';
                }
				$model_goods->updateGoods($update_array,intval($_GET['id']));
				echo 'true';exit;
				break;
		}
	}

	/**
	 * 商品导出
	 */
	public function export_step1Op(){
		$model_goods = Model('goods');

		$condition['keyword'] = trim($_GET['search_goods_name']);
		$condition['like_store_name'] = trim($_GET['search_store_name']); //店铺名称
		$condition['brand_id'] = intval($_GET['search_brand_id']);
		$condition['gc_id'] = intval($_GET['cate_id']);
		if ($_GET['search_show'] == '0' || $_GET['search_show'] == '1') {//上架:1是,0否
			$condition['goods_show'] = $_GET['search_show'];
		}
		if ($_GET['search_lock'] == '0' || $_GET['search_lock'] == '1') {//禁售:1是,0否
			$condition['goods_state'] = $_GET['search_lock'];
		}
		/**
		 * 判断是否为禁售商品链接
		 */
		if ($_GET['goods_state'] == '1') $condition['goods_state'] = '1';

		$page	= new Page();
		$page->setEachNum(self::EXPORT_SIZE);
		$goods_list = $model_goods->getGoodsList($condition,$page);
		if (!is_numeric($_GET['curpage'])){		
			$count = $page->getTotalNum();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('download_lang',Language::get('goods_index_goods'));
				Tpl::output('murl','index.php?act=goods&op=goods');				
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createExcel($goods_list);
			}
		}else{	//下载
			$this->createExcel($goods_list);
		}
	}

	/**
	 * 生成excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_product'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pr_brand'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pr_cate'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pr_price'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pr_serial'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pr_state'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pr_type'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pr_addtime'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pr_store'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pr_storeid'));

		foreach ((array)$data as $k=>$v){
			if ($v['goods_state'] ==1) $v['goods_show'] = L('exp_pr_wgxj');
			$tmp = array();
			$tmp[] = array('data'=>$v['goods_name']);
			$tmp[] = array('data'=>$v['brand_name']);
			$tmp[] = array('data'=>str_replace('&gt;','',$v['gc_name']));
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['goods_store_price']));
			$tmp[] = array('data'=>$v['goods_serial']);
			$tmp[] = array('data'=>str_replace(array(1,0),array(L('exp_pr_sj'),L('exp_pr_xj')),$v['goods_show']));
			$tmp[] = array('data'=>str_replace(array(1,2),array(L('exp_pr_new'),L('exp_pr_old')),$v['goods_form']));
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['goods_add_time']));
			$tmp[] = array('data'=>$v['store_name']);
			$tmp[] = array('data'=>$v['store_id']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_product'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_product'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}
