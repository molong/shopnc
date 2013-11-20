<?php
/**
 * 商品管理
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
class store_goodsControl extends BaseMemberStoreControl {
	public function __construct() {

		parent::__construct();
		/**
		 * 读取语言包
		 */
		Language::read('member_store_goods_index');
		$lang	= Language::getLangContent();
		/**
		 * 店铺当前等级及店铺信息
		 */
		$model_grade	= Model('store_grade');
		$store_grade	= $model_grade->getGradeShopList(array('store_id'=>"{$_SESSION['store_id']}"));
		if(intval($store_grade[0]['store_state']) == 2) {//卖家店铺是否审核的判断
			showMessage($lang['store_auditing_tip'],'index.php?act=store','html','error');
		}
	}
	public function indexOp(){
		$this->goods_listOp();
	}
	/**
	 * 出售中的商品列表
	 *
	 * @param 
	 * @return 
	 */
	public function goods_listOp() {
		/**
		 * 实例化店铺商品模型
		 */
		$model_store_goods	= Model('goods');
		/**
		 * 商品分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');

		$list_goods	= array();
		$search_array	= array();
		$search_array['goods_show']		= '1';
		$search_array['store_id']		= $_SESSION['store_id'];
		$search_array['keyword']		= trim($_GET['keyword']);
		
		//查询分类下的子分类
		$stc_id = intval($_GET['stc_id']);
		if ($stc_id){
			$model_store_class = Model('my_goods_class');
			$stc_id_arr = $model_store_class->getChildAndSelfClass($stc_id,'1');
			if (is_array($stc_id_arr) && count($stc_id_arr)>0){
				$search_array['stc_id_in'] = implode(',',$stc_id_arr);
			}else{
				$search_array['stc_id'] = $stc_id_arr;
			}
		}
		$search_array['order']		.= 'goods.goods_id desc';
		//商品列表，区分总列表和根据店铺分类进行商品列表
		$list_goods	= $model_store_goods->getGoods($search_array,$page,'*','stc');
		if(is_array($list_goods) and !empty($list_goods)) {
			$goods_id_str = '';
			foreach ($list_goods as $key => $val) {
				$goods_id_str .= "'".$val['goods_id']."',";
			}
			$goods_id_str	= rtrim($goods_id_str, ',');
			$goods_storage	= $model_store_goods->countStorageByGoodsSpec(array('in_spec_goods_id'=>$goods_id_str), 'sum(spec_goods_storage) as sum,goods_id');
			$storage_array	= array();
			foreach ($goods_storage as $val) {
				$storage_array[$val['goods_id']]	= $val['sum'];
			}
		}

		Tpl::output('show_page',$page->show());
		Tpl::output('list_goods',$list_goods);
		Tpl::output('storage_array', $storage_array);

		/**
		 * 实例化店铺商品分类模型
		 */		
		$model_store_class	= Model('my_goods_class');
		$store_goods_class	= $model_store_class->getClassTree(array('store_id'=>$_SESSION['store_id'],'stc_state'=>'1'));
		Tpl::output('store_goods_class',$store_goods_class);

		self::profile_menu('goods','goods_list');
		Tpl::output('menu_sign','goods_selling');
		Tpl::showpage('store_goods_list');
	}
	/**
	 * 仓库中的商品列表
	 *
	 * @param 
	 * @return 
	 */
	public function goods_storageOp() {

		/**
		 * 实例化店铺商品模型
		 */
		$model_store_goods	= Model('goods');
		/**
		 * 商品分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');

		$list_goods	= array();
		$search_array	= array();
		if($_GET['type'] == 'state'){
			$search_array['goods_state']	= '1';
			self::profile_menu('goods_storage','goods_state');
		}else{
			$search_array['goods_state']	= '0';
			$search_array['goods_show']		= '0';
			self::profile_menu('goods_storage','goods_storage');
		}
		$search_array['store_id']		= $_SESSION['store_id'];
		$search_array['keyword']		= trim($_GET['keyword']);
		
		//查询分类下的子分类
		$stc_id = intval($_GET['stc_id']);
		if ($stc_id){
			$model_store_class = Model('my_goods_class');
			$stc_id_arr = $model_store_class->getChildAndSelfClass($stc_id,'1');
			if (is_array($stc_id_arr) && count($stc_id_arr)>0){
				$search_array['stc_id_in'] = implode(',',$stc_id_arr);
			}else{
				$search_array['stc_id'] = $stc_id_arr;
			}
		}
		$search_array['order']		.= 'goods.goods_id desc';
		//商品列表，区分总列表和根据店铺分类进行商品列表
		$list_goods	= $model_store_goods->getGoods($search_array,$page,'*','stc');
		if(is_array($list_goods) and !empty($list_goods)) {
			$goods_id_str = '';
			foreach ($list_goods as $key => $val) {
				$goods_id_str .= "'".$val['goods_id']."',";
			}
			$goods_id_str	= rtrim($goods_id_str, ',');
			$goods_storage	= $model_store_goods->countStorageByGoodsSpec(array('in_spec_goods_id'=>$goods_id_str), 'sum(spec_goods_storage) as sum,goods_id');
			$storage_array	= array();
			foreach ($goods_storage as $val) {
				$storage_array[$val['goods_id']]	= $val['sum'];
			}
		}
		
		Tpl::output('show_page',$page->show());
		Tpl::output('list_goods',$list_goods);
		Tpl::output('storage_array', $storage_array);

		/**
		 * 实例化店铺商品分类模型
		 */		
		$model_store_class	= Model('my_goods_class');
		$store_goods_class	= $model_store_class->getClassTree(array('store_id'=>$_SESSION['store_id'],'stc_state'=>'1'));
		Tpl::output('store_goods_class',$store_goods_class);

		if($_GET['type'] == 'state'){
			Tpl::output('menu_sign', 'goods_state');
		}else{
			Tpl::output('menu_sign','goods_storage');
		}
		Tpl::showpage('store_goods_storage');
	}
	/**
	 * ajax显示商品库存 显示
	 */
	public function goods_stock_listOp() {
		$lang	= Language::getLangContent();
		$model_goods	= Model('goods');
		/**
		 * 验证商品是否存在
		 * 
		 */
		$goods_id	= intval($_GET['goods_id']);
		$stock_sum	= intval($_GET['stock_sum']);
		if($goods_id <1){
			return false;
		}
		$goods_info		= $model_goods->getGoods(array('goods_id'=>$goods_id, 'store_id'=>$_SESSION['store_id']), '', '*', 'goods');
		if(!is_array($goods_info) || empty($goods_info)){
			return false;
		}
		$stock_count= $model_goods->getGoods(array('goods_spec.goods_id'=>$goods_id, 'order'=>'spec_id asc'), '', 'count(spec_id) as count', 'goods_spec');
		$stock_list	= $model_goods->getGoods(array('goods_spec.goods_id'=>$goods_id, 'order'=>'spec_goods_storage asc', 'limit'=>'10'), '', 'spec_id,spec_goods_spec,spec_goods_storage', 'goods_spec');
		// 整理
		$stock_array	= array();
		$stock_part_sum	= 0;
		foreach ($stock_list as $k => $val){
			$stock_array[$k]['spec_id']				= $val['spec_id'];
			$stock_array[$k]['spec_goods_storage']	= $val['spec_goods_storage'];
			$stock_array[$k]['spec_goods_spec']		= '';
			foreach (unserialize($val['spec_goods_spec']) as $v){
				$stock_array[$k]['spec_goods_spec']	.= $v.'/';
			}
			$stock_array[$k]['spec_goods_spec']		= rtrim($stock_array[$k]['spec_goods_spec'], '/');
			$stock_part_sum							+= intval($val['spec_goods_storage']);
		}
		Tpl::output('goods_id', $goods_id);
		Tpl::output('stock_sum', $stock_sum);
		Tpl::output('surplus_sum', $stock_sum-$stock_part_sum);
		Tpl::output('stock_count', $stock_count['0']['count']);
		Tpl::output('stock_array', $stock_array);
		Tpl::showpage('store_goods_stock_list','null_layout');
	}
	/**
	 * ajax修改商品库存 保存
	 */
	public function goods_stock_ajax_saveOp() {
		$goods_id	= intval($_POST['goods_id']);
		$arr		= rtrim($_POST['name'], ';');
		$arr		= explode(';', $arr);
		
		$model_goods = Model('goods');
		$stock_array= array();		
		if(is_array($arr) && !empty($arr)){
			foreach ($arr as $val){
				list($spec_id, $stock) = explode(':', $val);
				// 更新库存
				$model_goods->updateSpecGoods(array('spec_goods_id'=>$goods_id,'spec_id'=>$spec_id), array('spec_goods_storage'=>$stock));
			}
		}
	}
	/**
	 * ajax显示商品价格 显示
	 */
	public function goods_price_listOp() {
		$lang	= Language::getLangContent();
		$model_goods	= Model('goods');
		/**
		 * 验证商品是否存在
		 *
		 */
		$goods_id	= intval($_GET['goods_id']);
		if($goods_id <1){
			return false;
		}
		$goods_info		= $model_goods->getGoods(array('goods_id'=>$goods_id, 'store_id'=>$_SESSION['store_id']), '', '*', 'goods');
		if(!is_array($goods_info) || empty($goods_info)){
			return false;
		}
		$price_count= $model_goods->getGoods(array('goods_spec.goods_id'=>$goods_id, 'order'=>'spec_id asc'), '', 'count(spec_id) as count', 'goods_spec');
		$price_list	= $model_goods->getGoods(array('goods_spec.goods_id'=>$goods_id, 'order'=>'spec_id asc', 'limit'=>'10'), '', 'spec_id,spec_goods_spec,spec_goods_price', 'goods_spec');
		// 整理
		$price_array	= array();
		foreach ($price_list as $k => $val){
			$price_array[$k]['spec_id']				= $val['spec_id'];
			$price_array[$k]['spec_goods_price']	= $val['spec_goods_price'];
			$price_array[$k]['spec_goods_spec']		= '';
			foreach (unserialize($val['spec_goods_spec']) as $v){
				$price_array[$k]['spec_goods_spec']	.= $v.'/';
			}
			$price_array[$k]['spec_goods_spec']		= rtrim($price_array[$k]['spec_goods_spec'], '/');
		}
		Tpl::output('goods_id', $goods_id);
		Tpl::output('price_count', $price_count['0']['count']);
		Tpl::output('price_array', $price_array);
		Tpl::showpage('store_goods_price_list','null_layout');
	}
	/**
	 * ajax修改商品价格 保存
	 */
	public function goods_price_ajax_saveOp() {
		$goods_id	= intval($_POST['goods_id']);
		$arr		= rtrim($_POST['name'], ';');
		$arr		= explode(';', $arr);
	
		$model_goods = Model('goods');
		$stock_array= array();
		if(is_array($arr) && !empty($arr)){
			foreach ($arr as $val){
				list($spec_id, $price) = explode(':', $val);
				// 更新价格
				$model_goods->updateSpecGoods(array('spec_goods_id'=>$goods_id,'spec_id'=>$spec_id), array('spec_goods_price'=>$price));
			}
			
			// 更新价格区间
			$price_list	= $model_goods->getGoods(array('goods_spec.goods_id'=>$goods_id, 'order'=>'spec_id asc'), '', 'spec_goods_price', 'goods_spec');
			$min = 10000000;$max = 0;
			if(is_array($price_list) && !empty($price_list)){
				foreach ($price_list as $val){
					if(intval($min) > intval($val['spec_goods_price']))	$min = $val['spec_goods_price'];
					if(intval($max) < intval($val['spec_goods_price']))	$max = $val['spec_goods_price'];
				}
			}
			$model_goods->updateGoods(array('goods_store_price_interval'=> $min .' - '. $max, 'goods_store_price'=>$min), $goods_id);
		}
	}
	/**
	 * 添加商品
	 */
	public function add_goodsOp() {
		$lang	= Language::getLangContent();
		/**
		 * 重新设置布局文件内容
		 */
		Tpl::setLayout('member_goods_marketing_layout');

		if (!C('payment')){
	   		//取得平台支付方式
			$model_payment = Model('gold_payment');
			//支付方式列表
			$condition = array();
			$condition['payment_state'] = '1';//可用的支付方式
			$payment_list = $model_payment->getList($condition);
			if (!$payment_list){
				showMessage($lang['store_goods_index_no_pay_type'],'index.php?act=store_goods&op=goods_list','html','error');
			}
		}else{
			//取得店铺支付方式
			$model_payment 	= Model('payment');
			$check_payment	= $model_payment->checkStorePayment();
			if(!$check_payment) {
				redirect('index.php?act=store&op=payment');
			}
		}

		/**
		 * 实例化店铺商品模型
		 */
		$model_store_goods	= Model('goods');
		$goods_num=$model_store_goods->countGoods(array('store_id'=>$_SESSION['store_id']));
		/**
		 * 商品数,空间使用，使用期限判断
		 */
		$model_store	= Model('store');
		$store_info		= $model_store->shopStore(array('store_id'=>$_SESSION['store_id']));
		$model_store_grade	= Model('store_grade');
		$store_grade	= $model_store_grade->getOneGrade($store_info['grade_id']);
		//编辑器多媒体功能
		$editor_multimedia = false;
		$sg_fun = @explode('|',$store_grade['sg_function']);
		if(!empty($sg_fun) && is_array($sg_fun)){
			foreach($sg_fun as $fun){
				if ($fun == 'editor_multimedia'){
					$editor_multimedia = true;
				}
			}
		}
		Tpl::output('editor_multimedia',$editor_multimedia);
		/*商品数判断*/
		if(intval($store_grade['sg_goods_limit']) != 0) {
			if($goods_num >= $store_grade['sg_goods_limit']) {
				showMessage($lang['store_goods_index_goods_limit'].$store_grade['sg_goods_limit'].$lang['store_goods_index_goods_limit1'],'index.php?act=store_goods&op=goods_list','html','error');
			}
		}
		/*使用期限判断*/
		if(intval($store_info['store_end_time']) != 0) {
			if(time() >= $store_info['store_end_time']) {
				showMessage($lang['store_goods_index_time_limit'],'index.php?act=store_goods&op=goods_list','html','error');
			}
		}
		if( $_GET['step'] == 'one' ){
			/**
			 * 实例化商品分类模型
			 */
			$model_class	= Model('goods_class');
			$param_array	= array();
			$param_array['gc_parent_id']	= '0';
			$param_array['gc_show']	= '1';
			$goods_class	= $model_class->getClassList($param_array);
			
			/**
			 * 实例化常用商品分类模型
			 */
			$model_staple	= Model('goods_class_staple');
			$param_array	= array();
			$param_array['store_id']	= $_SESSION['store_id'];
			$staple_array	= $model_staple->getStapleList($param_array);
			
			Tpl::output('staple_array', $staple_array);
			Tpl::output('goods_class', $goods_class);
			Tpl::output('menu_sign', 'add_goods_step1');
			Tpl::showpage('store_goods_add_step1');
		}else if ($_GET['step'] == 'two'){
			/**
			 * 实例化商品分类模型、商品分类TAG模型、类型模型
			 */
			$model_class		= Model('goods_class');
			$model_class_tag	= Model('goods_class_tag');

			//验证商品分类是否存在
			$gc_child_list		= $model_class->getClassList(array('gc_parent_id'=>intval($_GET['class_id'])));
			if($gc_child_list){
				showMessage($lang['store_goods_index_again_choose_category'], '', '', 'error');
			}
			$goods_class		= $model_class->getGoodsClassLineForTag(intval($_GET['class_id']));
			if(!$goods_class){
				showMessage($lang['store_goods_index_again_choose_category'], '', '', 'error');
			}
			Tpl::output('goods_class',$goods_class);
			
			//将分类保存到用户常用分类常用
			$model_staple = Model('goods_class_staple');
			$param_array = array();
			$param_array['staple_name']	= $goods_class['gc_tag_name'];
			$param_array['gc_id']		= $goods_class['gc_id'];
			$param_array['type_id']		= $goods_class['type_id'];
			$param_array['store_id']	= $_SESSION['store_id'];
			$param_array['staple_id']	= $model_staple->getStapleOne($param_array, 'staple_id');
			if(!$param_array['staple_id']){
				if(intval($model_staple->countStaple($_SESSION['store_id'])) < 20){
					unset($param_array['staple_id']);
					$param_array['staple_id']	= $model_staple->addStaple($param_array);
				}
			}
			//获取类型相关数据
			if($goods_class['type_id'] != '0'){
				$model_type	= Model('type');
				$spec_list 	= $model_type->typeRelatedJoinList(array('type_id'=>$goods_class['type_id']), 'spec', 'spec.sp_id as sp_id, spec.sp_name as sp_name, spec.sp_format as sp_format, spec_value.sp_value_id as sp_value_id, spec_value.sp_value_name as sp_value_name, spec_value.sp_value_image as sp_value_image');
				$attr_list	= $model_type->typeRelatedJoinList(array('type_id'=>$goods_class['type_id']), 'attr', 'attribute.attr_id as attr_id, attribute.attr_name as attr_name, attribute_value.attr_value_id as attr_value_id, attribute_value.attr_value_name as attr_value_name');
				$brand_list	= $model_type->typeRelatedJoinList(array('type_id'=>$goods_class['type_id'],'brand_apply'=>1), 'brand', 'brand.brand_id as brand_id,brand.brand_name as brand_name');
				
				//整理数组
				$spec_json	= array();
				if(is_array($spec_list) && !empty($spec_list)){
					$array		= array();
					foreach ($spec_list as $val){
						$a	= array();
						$a['sp_value_id']	= $val['sp_value_id'];
						$a['sp_value_name']	= $val['sp_value_name'];
						$a['sp_value_image']= $val['sp_value_image'];
						
						$array[$val['sp_id']]['sp_name']	= $val['sp_name'];
						$array[$val['sp_id']]['sp_format']	= $val['sp_format'];
						$array[$val['sp_id']]['value'][]	= $a;
						
						
						$spec_json[$val['sp_id']][$val['sp_value_id']]['sp_value_name']	= $val['sp_value_name'];
						$spec_json[$val['sp_id']][$val['sp_value_id']]['sp_value_image']= $val['sp_value_image'];
						$spec_json[$val['sp_id']][$val['sp_value_id']]['sp_format']		= $val['sp_format'];
					}
					$spec_list = $array;
				}
				if(is_array($attr_list) && !empty($attr_list)){
					$array = array();
						foreach ($attr_list as $val){
						$a	= array();
						$a['attr_value_id']		= $val['attr_value_id'];
						$a['attr_value_name']	= $val['attr_value_name'];
						
						$array[$val['attr_id']]['attr_name']	= $val['attr_name'];
						$array[$val['attr_id']]['value'][]		= $a;
					}
					$attr_list = $array;
				}
				
				Tpl::output('sign_i', count($spec_json));

				Tpl::output('spec_list', $spec_list);
				Tpl::output('attr_list', $attr_list);
				Tpl::output('brand_list',$brand_list);
			}
			
			// 为关联类型时，查找全部品牌
			if($brand_list == ''){
				$model_brand	= Model('brand');
				$condition		= array('brand_apply'=>1);
				$brand_list		= $model_brand->getBrandList($condition);
				Tpl::output('brand_list',$brand_list);
			}
			
			/**
			 * 实例化店铺商品分类模型
			 */
			$model_store_class	= Model('my_goods_class');

			$store_goods_class	= $model_store_class->getClassTree(array('store_id'=>$_SESSION['store_id'],'stc_state'=>'1'));
			Tpl::output('store_goods_class',$store_goods_class);
			

			/**
			 * 小时分钟显示
			 */
			$hour_array		= array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
			Tpl::output('hour_array',$hour_array);
			$minute_array	= array('05','10','15','20','25','30','35','40','45','50','55');
			Tpl::output('minute_array',$minute_array);
			
			Tpl::output('item_id','');
			Tpl::output('menu_sign','add_goods_stpe2');
			Tpl::showpage('store_goods_add_step2');
		}
	}
	/**
	 * 编辑商品页面
	 */
	public function edit_goodsOp() {
		/**
		 * 实例化商品分类模型
		 */
		$model_class		= Model('goods_class');
		//验证商品分类是否存在
		if(intval($_GET['class_id']) >0 && intval($_GET['t_id']) >=0){
			$goods_class		= $model_class->getGoodsClassLineForTag(intval($_GET['class_id']));
			if(!$goods_class){
				showMessage($lang['store_goods_index_again_choose_category'], '', '', 'error');
			}
			Tpl::output('goods_class',$goods_class);
		}
		
		Tpl::setLayout('member_goods_marketing_layout');
		$lang	= Language::getLangContent();
		/**
		 * 实例化店铺商品模型
		 */
		$model_store_goods	= Model('goods');
		$goods_array		= $model_store_goods->getGoods(array('goods_id'=>intval($_GET['goods_id'])),'','goods.*');
        //检查商品是否属于当前店铺
        if(intval($goods_array[0]['store_id']) !== intval($_SESSION['store_id'])) {
            showMessage(Language::get('para_error'),'','html','error');
        }

        $goods_array[0]['goods_col_img']	= unserialize($goods_array[0]['goods_col_img']);

		if ($goods_array[0]['transport_id']>0){
			//运费模板名称
			$model_transport = Model('transport');
			$transport = $model_transport->getRow($goods_array[0]['transport_id']);
			$goods_array[0]['transport_title'] = $transport['title'];	
		}
		
		/* 商品多图与2.0兼容 start */
		if($goods_array[0]['goods_image_more'] == ''){
			$goods_image		= $model_store_goods->getListImageGoods(array(
					'image_store_id'=>$_SESSION['store_id'],
					'item_id'=>$goods_array[0]['goods_id'],
					'image_type'=>2
			));
			if(is_array($goods_image) and !empty($goods_image)) {
				$goods_image_more = array();
				foreach ($goods_image as $key => $val) {
					$goods_image_more[]	= str_replace('_small', '_tiny', $val['file_thumb']);
				}
				$goods_array[0]['goods_image_more']	= $goods_image_more;
			}
		}else{
			$goods_array[0]['goods_image_more']	= explode(',', $goods_array[0]['goods_image_more']);
		}
		/* 商品多图与2.0兼容 end */
  
		Tpl::output('goods',$goods_array[0]);
		Tpl::output('goods_id',$goods_array[0]['goods_id']);
		
		/**
		 * 实例化商品分类模型、商品分类TAG模型、类型模型
		 */
		$model_class_tag	= Model('goods_class_tag');

		//验证商品分类是否存在
		if(empty($goods_class) || !is_array($goods_class)){
			$goods_class		= $model_class->getGoodsClassLineForTag($goods_array[0]['gc_id']);
			if(!$goods_class){
				showMessage($lang['store_goods_index_again_choose_category'], '', '', 'error');
			}
			Tpl::output('goods_class',$goods_class);
		}
		/**
		 * 获取类型相关数据
		 */
		if($goods_class['type_id'] != '0'){
			$model_type	= Model('type');
			$spec_list 	= $model_type->typeRelatedJoinList(array('type_id'=>$goods_class['type_id']), 'spec', 'spec.sp_id as sp_id, spec.sp_name as sp_name, spec.sp_format as sp_format, spec_value.sp_value_id as sp_value_id, spec_value.sp_value_name as sp_value_name, spec_value.sp_value_image as sp_value_image');
			$attr_list	= $model_type->typeRelatedJoinList(array('type_id'=>$goods_class['type_id']), 'attr', 'attribute.attr_id as attr_id, attribute.attr_name as attr_name, attribute_value.attr_value_id as attr_value_id, attribute_value.attr_value_name as attr_value_name');
			$brand_list	= $model_type->typeRelatedJoinList(array('type_id'=>$goods_class['type_id'],'brand_apply'=>1), 'brand', 'brand.brand_id as brand_id,brand.brand_name as brand_name');
			Tpl::output('brand_list',$brand_list);
			
			//整理数组
			$spec_json	= array();
			if(is_array($spec_list) && !empty($spec_list)){
				$array		= array();
				foreach ($spec_list as $val){
					$a	= array();
					$a['sp_value_id']	= $val['sp_value_id'];
					$a['sp_value_name']	= $val['sp_value_name'];
					$a['sp_value_image']= $val['sp_value_image'];
					
					$array[$val['sp_id']]['sp_name']	= $val['sp_name'];
					$array[$val['sp_id']]['sp_format']	= $val['sp_format'];
					$array[$val['sp_id']]['value'][]	= $a;
					
					
					$spec_json[$val['sp_id']][$val['sp_value_id']]['sp_value_name']	= $val['sp_value_name'];
					$spec_json[$val['sp_id']][$val['sp_value_id']]['sp_value_image']= $val['sp_value_image'];
					$spec_json[$val['sp_id']][$val['sp_value_id']]['sp_format']		= $val['sp_format'];
				}
				$spec_list = $array;
			}
			if(is_array($attr_list) && !empty($attr_list)){
				$array = array();
					foreach ($attr_list as $val){
					$a	= array();
					$a['attr_value_id']		= $val['attr_value_id'];
					$a['attr_value_name']	= $val['attr_value_name'];
					
					$array[$val['attr_id']]['attr_name']	= $val['attr_name'];
					$array[$val['attr_id']]['value'][]		= $a;
				}
				$attr_list = $array;
			}
			
			if(is_array($spec_json) && !empty($spec_json)){
				$i = '0';
				foreach ($spec_json as $val){
					// 转码
					if (strtoupper(CHARSET) == 'GBK'){
						$val = Language::getUTF8($val);
					}
					Tpl::output('spec_json_'.$i, json_encode($val));
					$i++;
				}
				Tpl::output('sign_i', $i);
			}
			
			//Tpl::output('spec_json', json_encode($spec_json));
			Tpl::output('spec_list', $spec_list);
			Tpl::output('attr_list', $attr_list);
		}
		
		// 为关联类型时，查找全部品牌
		if($brand_list == ''){
			$model_brand	= Model('brand');
			$condition		= array('brand_apply'=>1);
			$brand_list		= $model_brand->getBrandList($condition);
			Tpl::output('brand_list',$brand_list);
		}
		
		/**
		 * 取得已选择了哪些商品的规格
		 */
		$model_type		= Model('type');
		$spec_checked	= $model_type->typeRelatedList('goods_spec_index', array('goods_id'=>intval($goods_array[0]['goods_id'])), 'sp_value_id,sp_value_name');
		$attr_checked_l	= $model_type->typeRelatedList('goods_attr_index', array('goods_id'=>intval($goods_array[0]['goods_id'])), 'attr_value_id');
		if(is_array($attr_checked_l) && !empty($attr_checked_l)){
			$attr_checked = array();
			foreach ($attr_checked_l as $val){
				$attr_checked[] = $val['attr_value_id'];
			}
		}
		Tpl::output('attr_checked', $attr_checked);
		Tpl::output('spec_checked', $spec_checked);

		/**
		 * 取得商品规格的输入值
		 */
		$spec_value	= $model_type->typeRelatedList('goods_spec', array('goods_id'=>intval($goods_array[0]['goods_id'])));
		$sp_value = array();
		if(is_array($spec_value) && !empty($spec_value)){
		foreach ($spec_value as $k=>$v) {
			preg_match_all("/i:(\d+)/s",$v['spec_goods_spec'],$matchs);
			$id = str_replace(',','',implode(',',$matchs[1]));
			$sp_value['i_'.$id.'|price'] = $v['spec_goods_price'];
			$sp_value['i_'.$id.'|stock'] = $v['spec_goods_storage'];
			$sp_value['i_'.$id.'|sku'] = $v['spec_goods_serial'];
		}
		}
		Tpl::output('sp_value', $sp_value);

		/**
		 * 实例化店铺商品分类模型
		 */
		$model_store_class	= Model('my_goods_class');
		//$store_goods_class	= $model_store_class->getTreeClassList(array('store_id'=>$_SESSION['store_id']),2);
		$store_goods_class	= $model_store_class->getClassTree(array('store_id'=>$_SESSION['store_id'],'stc_state'=>'1'));
		Tpl::output('store_goods_class',$store_goods_class);
		$store_class_goods	= $model_store_goods->getStoreClassGoods($goods_array[0]['goods_id']);
		Tpl::output('store_class_goods',$store_class_goods);

		$model_store_grade	= Model('store_grade');
		$store_grade	= $model_store_grade->getOneGrade($_SESSION['grade_id']);
		//编辑器多媒体功能
		$editor_multimedia = false;
		$sg_fun = @explode('|',$store_grade['sg_function']);
		if(!empty($sg_fun) && is_array($sg_fun)){
			foreach($sg_fun as $fun){
				if ($fun == 'editor_multimedia'){
					$editor_multimedia = true;
				}
			}
		}
		Tpl::output('editor_multimedia',$editor_multimedia);

		/**
		 * 商品规格
		 */

		$spec_array		= $model_store_goods->getSpecGoods($goods_array[0]['goods_id']);
		if(is_array($spec_array) and $goods_array[0]['spec_open'] == 1) {
			$spec	= array();
			foreach ($spec_array as $key => $val) {
				$spec[$key]['spec_id'] = $val['spec_id'];
				$spec[$key]['goods_id'] = $val['goods_id'];
				$spec[$key]['spec_1'] = $val['spec_name_1'];
				$spec[$key]['spec_2'] = $val['spec_name_2'];
				$spec[$key]['color_rgb'] = $val['spec_goods_color'];
				$spec[$key]['price'] = $val['spec_goods_price'];
				$spec[$key]['stock'] = $val['spec_goods_storage'];
				$spec[$key]['sku'] = $val['spec_goods_serial'];
			}
		}
		$spec_num	= 0;
		if(($goods_array[0]['spec_name_1'] !='' or $goods_array[0]['spec_name_2'] !='') and $goods_array[0]['spec_open'] == 1) {
			$spec_num = 1;
		} elseif ($goods_array[0]['spec_name_1'] !='' and $goods_array[0]['spec_name_2'] !=''  and $goods_array[0]['spec_open'] == 1) {
			$spec_num = 2;
		} else {
			$spec_num = 0;
			Tpl::output('goods_storage',$spec_array[0]['spec_goods_storage']);
		}
		Tpl::output('spec_num',$spec_num);//有没有启用规格
		$spec_json	= array('spec_qty'=>$spec_num,'spec_name_1'=>($goods_array[0]['spec_name_1']=='' ? $lang['store_goods_index_color'] : $goods_array[0]['spec_name_1']),
								'spec_name_2'=>($goods_array[0]['spec_name_2']=='' ? 		$lang['store_goods_index_spec'] : $goods_array[0]['spec_name_2']),
								'specs'=>$spec);
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$spec_json = Language::getUTF8($spec_json);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		}
		$spec_json	= json_encode($spec_json);
		Tpl::output('spec_json',$spec_json);
		
		/**
		 * 小时分钟显示
		 */
		$hour_array		= array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
		Tpl::output('hour_array',$hour_array);
		$minute_array	= array('05','10','15','20','25','30','35','40','45','50','55');
		Tpl::output('minute_array',$minute_array);

		Tpl::output('item_id',$goods_array[0]['goods_id']);
		Tpl::output('menu_sign','add_goods_stpe2');
		Tpl::showpage('store_goods_add_step2');
	}
	/**
	 * 保存商品
	 */
	public function save_goodsOp() {
		$lang	= Language::getLangContent();
		
		if (chksubmit()){
			/**
			 * 验证表单
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["goods_name"],"require"=>"true","message"=>$lang['store_goods_index_goods_name_null']),
			array("input"=>$_POST["goods_price"],"require"=>"true","validator"=>"Double","message"=>$lang['store_goods_index_goods_price_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($lang['error'].$error,'','html','error');
			}
			/**
		 	 * 实例化店铺商品模型
			 */
			$model_store_goods	= Model('goods');

			$goods_array	= array();
			$goods_array['goods_name']				= $_POST['goods_name'];
			$goods_array['gc_id']					= $_POST['cate_id'];
			$goods_array['gc_name']					= $_POST['cate_name'];
			$goods_array['brand_id']				= $_POST['brand_id'];
			$goods_array['spec_open']				= '1';
			$goods_array['goods_store_price']		= $_POST['goods_store_price'];
			$goods_array['goods_store_price_interval']= $_POST['goods_store_price_interval'];		// 商品价格区间
			$goods_array['goods_serial']			= $_POST['goods_serial'];
			$goods_array['goods_commend']			= $_POST['goods_commend'];
			$goods_array['goods_body']				= $_POST['goods_body'];
			$goods_array['goods_keywords']			= $_POST['seo_keywords'];
			$goods_array['goods_description']		= $_POST['seo_description'];
			
			$goods_array['transport_id']			= ($_POST['isApplyPostage'] == '0') ? '0' : intval($_POST['transport_id']);	//运费模板
			$goods_array['py_price']				= intval($_POST['py_price']);
			$goods_array['kd_price']				= intval($_POST['kd_price']);
			$goods_array['es_price']				= intval($_POST['es_price']);
			
			$goods_array['city_id']					= intval($_POST['city_id']);
			$goods_array['province_id']				= intval($_POST['province_id']);
			
			$goods_array['goods_image']				= str_replace('_tiny', '_small', $_POST['image_path'][0]);
			$goods_array['goods_image_more']		= implode(',',$_POST['image_path']);
			
			$goods_array['goods_transfee_charge']	= $_POST['goods_transfee_charge'];
			$goods_array['type_id']					= $_POST['type_id'];
			if (is_array($_POST['spec'])) {
				$goods_array['goods_spec']			= $_POST['sp_val'];
			}else{
				$goods_array['goods_spec']			= null;
			}
			$goods_array['goods_attr']				= $_POST['attr'];
			$goods_array['spec_name']				= $_POST['sp_name'];
			$goods_array['goods_form']				= $_POST['goods_form'];
			switch ($_POST['goods_show']){
				case 0:
					$goods_array['goods_show']		= 0;
					$goods_array['goods_starttime']	= time()-14*86400;
					$goods_array['goods_endtime']	= time()-7*86400;
					break;
				case 1:
					$goods_array['goods_show']		= 1;
					$goods_array['goods_starttime']	= time();
					$goods_array['goods_endtime']	= time()+C('product_indate')*86400;
					break;
				case 2:
					$goods_array['goods_show']		= 0;
					$goods_array['goods_starttime']	= strtotime($_POST['starttime']) + intval($_POST['starttime_H'])*3600 + intval($_POST['starttime_i'])*60;
					$goods_array['goods_endtime']	= strtotime($_POST['starttime']) + intval($_POST['starttime_H'])*3600 + intval($_POST['starttime_i'])*60 + C('product_indate')*86400;
					if($goods_array['goods_starttime'] <= time() && time() < $goods_array['goods_endtime'] ){
						$goods_array['goods_show']		= 1;
					}
					break;
			}
			
			/**
			 * 关闭状态下发布商品默认不可搜索到
			 */
			$model_store = Model('store');
			$store_info = $model_store->shopStore(array(
				'store_id'=>$_SESSION['store_id']
			));
			if ($store_info['store_state'] == 0){
				$goods_array['goods_store_state'] = 1;
			}
			unset($store_info);
			$state = $model_store_goods->saveGoods($goods_array);
			if($state) {

				/**
		 		 * 商品规格
		 		 */
				$update_array = array();
				if (is_array($_POST['spec'])) {
					$spec_array				= $_POST['spec'];
				} else {
					$spec_array[0]['price']	= $goods_array['goods_store_price'];
					$spec_array[0]['stock']	= $_POST['goods_storage'];
					$spec_array[0]['sku']	= $goods_array['goods_serial'];
					
					$update_array['spec_open'] = '0';
				}
				$spec_id = $model_store_goods->saveSpecGoods($spec_array,$state,$_POST['sp_name']);
				$update_array['spec_id']	= $spec_id;

		 		// 修改商品				
				$model_store_goods->updateGoods($update_array, $state);

				$model_type = Model('type');
				/**
				 * 商品与规格对应
				 */
				$sa_array = array();
				$sa_array['goods_id'] 	= $state;
				$sa_array['gc_id']		= $_POST['cate_id'];
				$sa_array['type_id']	= $_POST['type_id'];
				if(is_array($_POST['sp_val'])){
					$sa_array['value']		= $_POST['sp_val'];
					$model_type->typeGoodsRelatedAdd($sa_array, 'goods_spec_index', 'spec');
				}
				
				/**
				 * 商品与属性对应
				 */
				if(is_array($_POST['attr'])){
					$sa_array['value']		= $_POST['attr'];
					$model_type->typeGoodsRelatedAdd($sa_array, 'goods_attr_index');
				}
				
				/**
		 		 * 店铺商品分类
		 		 */
				if(is_array($_POST['sgcate_id'])) {
					//去除重复选择的项
					$new_sgcate_id = $_POST['sgcate_id'];
					$new_sgcate_id = array_unique($new_sgcate_id);
					$model_store_goods->saveStoreClassGoods($new_sgcate_id,$state);
				}
				
				/**
				 * 颜色图片上传
				 */
				if(is_array($_POST['sp_val']['1'])){
					$col_img_array	= array();
					foreach($_POST['sp_val']['1'] as $k=>$v){
						if(!empty($_FILES[$v]['name'])){
							$upload = new UploadFile();
							$upload->set('ifremove', true);
							$upload->set('default_dir',ATTACH_SPEC.DS.$_SESSION['store_id'].DS.$upload->getSysSetPath());
							$upload->set('max_size',C('image_max_filesize'));
							$thumb_width	= '30,'.C('thumb_mid_width');
							$thumb_height	= '30,'.C('thumb_mid_height');
					
							$upload->set('thumb_width',	$thumb_width);
							$upload->set('thumb_height',$thumb_height);
							$upload->set('thumb_ext',	'_tiny,_mid');	
							
							$result = $upload->upfile($v);
							if($result){
								$img_path	= $upload->getSysSetPath().$upload->thumb_image;
								$col_img_array[$v]  =  $col_img_array[$k]  =  $img_path;
							}
						}
					}
					// 更新商品信息
					if(!empty($col_img_array)){
						$model_store_goods->updateGoods(array('goods_col_img'=>serialize($col_img_array)),$state);
					}
				}

				// 自动发布动态
				// goods_id,store_id,goods_name,goods_image,goods_store_price,goods_transfee_charge,py_price
				$data_array = array();
				$data_array['goods_id']				= $state;
				$data_array['store_id']				= $_SESSION['store_id'];
				$data_array['goods_name']			= $goods_array['goods_name'];
				$data_array['goods_image']			= $goods_array['goods_image'];
				$data_array['goods_store_price']	= $goods_array['goods_store_price'];
				$data_array['goods_transfee_charge']= $goods_array['goods_transfee_charge'];
				$data_array['py_price']				= $goods_array['py_price'];
				$this->storeAutoShare($data_array, 'new');
				
				@header("Location: index.php?act=store_goods&op=add_goods_step3&gid=".$state);
				exit;
			} else {
				showMessage($lang['store_goods_index_goods_add_fail'],'index.php?act=store_goods&op=goods_list','html','error');
			}
		}
	}
	/**
	 * 商品发布第三步
	 */
	public function add_goods_step3Op(){
		/**
		 * 重新设置布局文件内容
		 */
		Tpl::setLayout('member_goods_marketing_layout');
		Tpl::output('goods_id',$_GET['gid']);
		Tpl::output('menu_sign', 'add_goods_step3');
		Tpl::showpage('store_goods_add_step3');
	}
	/**
	 * 编辑商品保存
	 */
	public function edit_save_goodsOp() {
		$lang	= Language::getLangContent();
		$goods_id	= intval($_POST['goods_id']);
		if (chksubmit() &&  $goods_id!= 0){
			/**
			 * 验证表单
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["goods_name"],"require"=>"true","message"=>$lang['store_goods_index_goods_name_null']),
				array("input"=>$_POST["goods_price"],"require"=>"true","validator"=>"Double","message"=>$lang['store_goods_index_goods_price_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($lang['error'].$error,'','html','error');
			}
			/**
		 	 * 实例化店铺商品模型
			 */
			$model_store_goods	= Model('goods');
            //检查商品是否属于当前店铺
            $para = array();
            $para['store_id'] = $_SESSION['store_id'];
            $para['goods_id'] = $goods_id;
            $verify_count = $model_store_goods->countGoods($para);
            if(intval($verify_count) !== 1) {
                showMessage(Language::get('para_error'),'','html','error');
            }

			$goods_array			= array();
			$goods_array['goods_name']				= $_POST['goods_name'];
			$goods_array['brand_id']				= $_POST['brand_id'];
			$goods_array['spec_open']				= 1;
			$goods_array['goods_store_price']		= $_POST['goods_store_price'];
			$goods_array['goods_store_price_interval']= $_POST['goods_store_price_interval'];
			$goods_array['goods_serial']			= $_POST['goods_serial'];
			$goods_array['goods_state']				= '0';
			$goods_array['goods_commend']			= $_POST['goods_commend'];
			$goods_array['goods_add_time']			= time();
			$goods_array['goods_body']				= $_POST['goods_body'];
			$goods_array['goods_keywords']			= $_POST['seo_keywords'];
			$goods_array['goods_description']		= $_POST['seo_description'];

			$goods_array['city_id']					= $_POST['city_id'];
			$goods_array['province_id']				= $_POST['province_id'];			

			$goods_array['goods_image']				= str_replace('_tiny', '_small', $_POST['image_path'][0]);
			$goods_array['goods_image_more']		= implode(',',$_POST['image_path']);
			
			$goods_array['goods_transfee_charge']	= $_POST['goods_transfee_charge'];
			$goods_array['type_id']					= $_POST['type_id'];
			if (is_array($_POST['spec'])) {
				$goods_array['goods_spec']			= serialize($_POST['sp_val']);			//开启规格时
			}else{
				$goods_array['goods_spec']			= serialize(null);						//未开启规格时
			}
			$goods_array['goods_attr']				= serialize($_POST['attr']);
			$goods_array['spec_name']				= serialize($_POST['sp_name']);
			

			//如果卖家承担运费，和运费模板相关值都为0
			if ($_POST['goods_transfee_charge']==1){
				$goods_array['transport_id'] = $goods_array['py_price'] = $goods_array['kd_price'] = $goods_array['es_price'] = '0';
			}elseif($_POST['isApplyPostage'] == '0'){
				//如果不使用运费模板
				$goods_array['transport_id']			= '0';
				$goods_array['py_price']				= intval($_POST['py_price']);
				$goods_array['kd_price']				= intval($_POST['kd_price']);
				$goods_array['es_price']				= intval($_POST['es_price']);
			}else{
				//如果使用运费模板
				$goods_array['transport_id']			= intval($_POST['transport_id']);
				$model_transport = Model('transport');
				$condition = array();
				$condition['transport_id'] 	= array(intval($_POST['transport_id']));
				$condition['is_default'] 	= 1; 
				$trans_list = $model_transport->getExtendList($condition);
				if (!empty($trans_list) && is_array($trans_list)){
					foreach ($trans_list as $k=>$v) {
						if ($v['type'] == 'py') $goods_array['py_price'] 	= $v['sprice']; 
						if ($v['type'] == 'kd') $goods_array['kd_price'] 	= $v['sprice']; 
						if ($v['type'] == 'es') $goods_array['es_price'] 	= $v['sprice']; 
					}
					//如果运费模板里没有的运费方式，价格置0
					if(!isset($goods_array['py_price'])) $goods_array['py_price'] = 0;
					if(!isset($goods_array['kd_price'])) $goods_array['kd_price'] = 0;
					if(!isset($goods_array['es_price'])) $goods_array['es_price'] = 0;
				}
			}

			if (intval($_POST['cate_id']) != 0) {
				$goods_array['gc_id']			= $_POST['cate_id'];
				$goods_array['gc_name']			= $_POST['cate_name'];
			}

			$goods_array['goods_form']				= $_POST['goods_form'];
			switch ($_POST['goods_show']){
				case 0:
					$goods_array['goods_show']		= 0;
					$goods_array['goods_starttime']	= time()-14*86400;
					$goods_array['goods_endtime']	= time()-7*86400;
					$goods_array['goods_commend']	= 0;
					break;
				case 1:
					$goods_array['goods_show']		= 1;
					$goods_array['goods_starttime']	= time();
					$goods_array['goods_endtime']	= time()+C('product_indate')*86400;
					break;
				case 2:
					$goods_array['goods_show']		= 0;
					$goods_array['goods_starttime']	= strtotime($_POST['starttime']) + intval($_POST['starttime_H'])*3600 + intval($_POST['starttime_i'])*60;
					$goods_array['goods_endtime']	= strtotime($_POST['starttime']) + intval($_POST['starttime_H'])*3600 + intval($_POST['starttime_i'])*60 + C('product_indate')*86400;
					if($goods_array['goods_starttime'] <= time() && time()  < $goods_array['goods_endtime'] ){
						$goods_array['goods_show']		= 1;
					}else{
						$goods_array['goods_commend']	= 0;
					}
					break;
			}			
			$state = $model_store_goods->updateGoods($goods_array,$goods_id);
			if($state) {
				/**
				 * 清除原有规格数据
				 */
				$model_type = Model('type');
				$model_type->delType('goods_spec_index',array('goods_id'=>$goods_id));
				$model_type->delType('goods_attr_index',array('goods_id'=>$goods_id));

				/**
		 		 * 更新商品规格
		 		 */	
				$update_array = array();
				if (is_array($_POST['spec'])) {
					$spec_id_array		= array();
					foreach ($_POST['spec'] as $val){
						$spec_id = $model_store_goods->getSpecGoodsWhere($goods_id, array('spec_goods_spec'=>serialize($val['sp_value']), 'spec_goods_id'=>$goods_id));
						if($spec_id){
							$param = array();
							$param['goods_id']				= $goods_id;
							$param['spec_name']				= serialize($_POST['sp_name']);
							$param['spec_goods_spec']		= serialize($val['sp_value']);
							$param['spec_goods_price']		= ncPriceFormat($val['price']);
							$param['spec_goods_storage']	= intval($val['stock']);
							$param['spec_goods_serial']		= trim($val['sku']);
							$model_store_goods->updateSpecGoods(array('spec_id'=>$spec_id['spec_id'], 'spec_goods_id'=>$goods_id),$param);
							$spec_id_array[]	= $spec_id['spec_id'];
						}else{
							$insert_array						= array();
							$insert_array[0]['spec_name']		= serialize($_POST['sp_name']);
							$insert_array[0]['sp_value']		= $val['sp_value'];
							$insert_array[0]['price']			= ncPriceFormat($val['price']);
							$insert_array[0]['stock']			= intval($val['stock']);
							$insert_array[0]['sku']				= trim($val['sku']);
							$insert_id = $model_store_goods->saveSpecGoods($insert_array,$goods_id,$_POST['sp_name']);
							$spec_id_array[]	= strval($insert_id);
						}
					}
					$model_store_goods->dropSpecGoodsWhere($spec_id_array, $goods_id);			// 清理规格
					$update_array['spec_id']	= $spec_id_array[0];
					$model_store_goods->updateGoods($update_array, $goods_id);
				} else {
					//获得商品规格id
					$goods_list = $model_store_goods->getGoods(array('goods_id'=>$goods_id), '', 'spec_id', 'goods');
					$spec_array['goods_id']				= $goods_id;
					$spec_array['spec_name']			= '';
					$spec_array['spec_goods_price']		= $goods_array['goods_store_price'];
					$spec_array['spec_goods_storage']	= $_POST['goods_storage'];
					$spec_array['spec_goods_serial']	= $goods_array['goods_serial'];
					
					$update_array['spec_open'] = '0';
					
					$model_store_goods->updateSpecStorageGoods($spec_array,$goods_list[0]['spec_id']);
					$model_store_goods->dropSpecGoodsWhere($goods_list[0]['spec_id'], $goods_id);			// 清理规格
					$model_store_goods->updateGoods($update_array, $goods_id);
				}
				
				$model_type = Model('type');
				/**
				 * 商品与规格对应
				 */
				$sa_array = array();
				$sa_array['goods_id'] 	= $goods_id;
				$sa_array['gc_id']		= $_POST['cate_id'];
				$sa_array['type_id']	= $_POST['type_id'];
				if(is_array($_POST['sp_val'])){
					$sa_array['value']		= $_POST['sp_val'];
					$model_type->typeGoodsRelatedAdd($sa_array, 'goods_spec_index', 'spec');
				}
				
				/**
				 * 商品与属性对应
				 */
				if(is_array($_POST['attr'])){
					$sa_array['value']		= $_POST['attr'];
					$model_type->typeGoodsRelatedAdd($sa_array, 'goods_attr_index');
				}
				
				/**
		 		 * 店铺商品分类
		 		 */
				if(is_array($_POST['sgcate_id']) and !empty($_POST['sgcate_id'])) {
					$model_store_goods->dropStoreClassGoods($goods_id);
					//去除重复选择的项
					$new_sgcate_id = $_POST['sgcate_id'];
					$new_sgcate_id = array_unique($new_sgcate_id);
					$model_store_goods->saveStoreClassGoods($new_sgcate_id,$goods_id);
				}
				/**
		 		 * 商品封面图片修改
		 		 */
				if(!empty($_POST['goods_file_id'][0])) {
					$image_info	= $model_store_goods->getListImageGoods(array('upload_id'=>intval($_POST['goods_file_id'][0])));
					$goods_image	= $image_info[0]['file_thumb'];
					$model_store_goods->updateGoods(array('goods_image'=>$goods_image),$goods_id);
				}

				/**
				 * 颜色图片上传
				 */ 
				if(is_array($_POST['sp_val']['1'])){
					$col_img_array	= array();
					foreach($_POST['sp_val']['1'] as $k=>$v){
						if(!empty($_FILES[$v]['name'])){		// 上传新图片时
							// 删除颜色图片 
							@unlink(ATTACH_SPEC.DS.$_SESSION['store_id'].DS.$_POST['goods_col_img'][$k]);
							@unlink(ATTACH_SPEC.DS.$_SESSION['store_id'].DS.str_replace('_tiny', '_mid', $_POST['goods_col_img'][$k]));
							
							$upload = new UploadFile();
							$upload->set('ifremove', true);
							$upload->set('default_dir',ATTACH_SPEC.DS.$_SESSION['store_id'].DS.$upload->getSysSetPath());
							$upload->set('max_size',C('image_max_filesize'));
							$thumb_width	= '30,'.C('thumb_mid_width');
							$thumb_height	= '30,'.C('thumb_mid_height');
					
							$upload->set('thumb_width',	$thumb_width);
							$upload->set('thumb_height',$thumb_height);
							$upload->set('thumb_ext',	'_tiny,_mid');	
								
							$result = $upload->upfile($v);
							if($result){
								$img_path	= $upload->getSysSetPath().$upload->thumb_image;
								$col_img_array[$v]  =  $col_img_array[$k]  =  $img_path;
							}
						}else if (isset($_POST['goods_col_img'][$k])){	// 使用原有图片
							$col_img_array[$v]  =  $col_img_array[$k]  =  $_POST['goods_col_img'][$k];
						}
					}
					
					// 删除无用图片
					$col_keys	= array_keys($_POST['sp_val']['1']);
					if(is_array($_POST['goods_col_img'])){
						foreach($_POST['goods_col_img'] as $k=>$v){
							if(!in_array($k, $col_keys) && $v != ''){
								@unlink(ATTACH_SPEC.DS.$_SESSION['store_id'].DS.$v);
								@unlink(ATTACH_SPEC.DS.$_SESSION['store_id'].DS.str_replace('_tiny', '_mid', $v));
							}
						}
					}
					
					// 更新商品颜色图片信息
					if(!empty($col_img_array)){
						$model_store_goods->updateGoods(array('goods_col_img'=>serialize($col_img_array)),$goods_id);
					}
				}
				$evaluate_model = Model('evaluate');
				$evaluate_model->updateGoodsStat($goods_id);//统计商品评论更新
				redirect(ncUrl(array('act'=>'goods','goods_id'=>$goods_id), 'goods'));
//				showMessage($lang['store_goods_index_goods_edit_success'],ncUrl(array('act'=>'goods','goods_id'=>$goods_id), 'goods'));
			} else {
				showMessage($lang['store_goods_index_goods_edit_fail'],'','html','error');
			}
		}
	}
	/**
	 * 删除商品
	 */	
	public function drop_goodsOp() {
		$lang	= Language::getLangContent();
		/**
		 * 实例化店铺商品模型
		 */
		$model_store_goods	= Model('goods');

		/**
		 * 检查商品是否属于店铺
		 */
        $goods_id = trim($_GET['goods_id']);
        if(empty($goods_id)) {
            showdialog(Language::get('para_error'),'','error');
        }
        //统计输入数量
        $goods_id_array = explode(',',$goods_id);
        $input_goods_count = count($goods_id_array);
        //统计确认的数量
        $para = array();
        $para['store_id'] = $_SESSION['store_id'];
        $para['goods_id_in'] = $goods_id;
        $verify_count = intval($model_store_goods->countGoods($para));
        //判断输入和确认是否一致
        if($input_goods_count !== $verify_count) {
            showMessage(Language::get('para_error'),'','html','error');
        }

		$state	= $model_store_goods->dropGoods($goods_id);
		if($state) {
			showDialog($lang['store_goods_index_goods_del_success'],'reload','succ');
		} else {
			showDialog($lang['store_goods_index_goods_del_fail'],'','error');
		}
	}
	/**
	 * 商品下架
	 */	
	public function goods_unshowOp() {
		$lang	= Language::getLangContent();
		/**
		 * 实例化店铺商品模型
		 */
		$model_store_goods	= Model('goods');

		/**
		 * 检查商品是否属于店铺
		 */
        $goods_id = trim($_GET['goods_id']);
        if(empty($goods_id)) {
            showDialog(Language::get('para_error'),'','error');
        }
        //统计输入数量
        $goods_id_array = explode(',',$goods_id);
        $input_goods_count = count($goods_id_array);
        //统计确认的数量
        $para = array();
        $para['store_id'] = $_SESSION['store_id'];
        $para['goods_id_in'] = $goods_id;
        $verify_count = intval($model_store_goods->countGoods($para));
        //判断输入和确认是否一致
        if($input_goods_count !== $verify_count) {
            showDialog(Language::get('para_error'),'','html','error');
        }

		$state	= $model_store_goods->updateGoods(array('goods_show'=>'0','goods_starttime'=>(time()-2*86400),'goods_endtime'=>(time()-86400)), $goods_id);
		if($state) {
			showdialog($lang['store_goods_index_goods_unshow_success'],'index.php?act=store_goods&op=goods_list','succ');
		} else {
			showdialog($lang['store_goods_index_goods_unshow_fail'],'','error');
		}
	}
	/**
	 * 商品上架
	 */
	public function goods_showOp(){
		$lang	= Language::getLangContent();
		/**
		 * 实例化店铺商品模型
		 */
		$model = Model();
		
		$goods_id = intval($_GET['goods_id']);
		if($goods_id <= 0) {
            showMessage(Language::get('para_error'),'','html','error');
        }
        $model->table('goods')->where(array('goods_id'=>$goods_id,'store_id'=>$_SESSION['store_id']));
        $state =$model->update(array('goods_show'=>'1','goods_starttime'=>time(),'goods_endtime'=>(time()+86400*C('product_indate'))));
		if($state) {
			showdialog($lang['store_goods_index_goods_show_success'],'reload','succ');
		} else {
			showdialog($lang['store_goods_index_goods_show_fail'],'','','error');
		}
	}
	/**
	 * 商品批量上架
	 */
	public function goods_show_batchOp(){
		$lang	= Language::getLangContent();
		$goods_id = explode(',', $_GET['goods_id']);
		if(empty($goods_id)) {
            showMessage(Language::get('para_error'),'','html','error');
        }
		$model = Model();
		$update = array();
		$update['goods_show']		= 1;
		$update['goods_starttime']	= time();
		$update['goods_endtime']	= time()+86400*C('product_indate');
		$where	= array();
		$where['goods_id']	= array('in',$goods_id);
		$where['member_id']	= $_SESSION['member_id'];
		$state = $model->table('goods')->where($where)->update($update);
		if($state) {
			showdialog($lang['store_goods_index_goods_show_success'],'reload','succ');
		} else {
			showdialog($lang['store_goods_index_goods_show_fail'],'','','error');
		}
	}
	/**
	 * 品牌列表
	 */	
	public function brand_listOp() {
		/**
		 * 实例化店铺品牌
		 */
		$model_brand	= Model('brand');
		$condition['like_brand_name']	= $_GET['brand_name'];
		$condition['storeid_equal']			= "{$_SESSION['store_id']}";
		/**
		 * 商品分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');

		$brand_list		= $model_brand->getBrandList($condition,$page);
		Tpl::output('brand_list',$brand_list);
		Tpl::output('show_page',$page->show());

		self::profile_menu('brand_list','brand_list');
		Tpl::output('menu_sign','brand_list');
		Tpl::showpage('store_brand_list');
	}
	/**
	 * 品牌添加页面
	 */	
	public function brand_addOp() {
		$lang	= Language::getLangContent();
		$model_brand = Model('brand');
		if($_GET['brand_id'] != '') {
			$brand_array = $model_brand->getOneBrand($_GET['brand_id']);
			if (empty($brand_array) || $brand_array['store_id'] != $_SESSION['store_id']){
				showMessage($lang['wrong_argument'],'','html','error');
			}
			Tpl::output('brand_array',$brand_array);
		}

		Tpl::showpage('store_brand_add','null_layout');
	}
	/**
	 * 品牌保存
	 */	
	public function brand_saveOp() {
		$lang	= Language::getLangContent();
		$model_brand = Model('brand');
		if (chksubmit()) {
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["brand_name"], "require"=>"true", "message"=>$lang['store_goods_brand_name_null'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showValidateError($error);
			}else {
				/**
				 * 上传图片
				 */
				if (!empty($_FILES['brand_pic']['name'])){
					$upload = new UploadFile();
					$upload->set('default_dir',ATTACH_BRAND);
					$upload->set('thumb_width',	150);
					$upload->set('thumb_height',50);
					$upload->set('thumb_ext',	'_small');
					$upload->set('ifremove',	true);
					$result = $upload->upfile('brand_pic');				
					if ($result){
						$_POST['brand_pic'] = $upload->thumb_image;
					}else {
						showDialog($upload->error);
					}
				}
				$insert_array = array();
				$insert_array['brand_name']		= $_POST['brand_name'];
				$insert_array['brand_class']	= $_POST['brand_class'];
				$insert_array['brand_pic']		= $_POST['brand_pic'];
				$insert_array['brand_apply']	= 0;
				$insert_array['store_id']		= $_SESSION['store_id'];

				$result = $model_brand->add($insert_array);
				if ($result){
					showDialog($lang['store_goods_brand_apply_success'],'index.php?act=store_goods&op=brand_list','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
				}else {
					showDialog($lang['nc_common_save_fail']);
				}
			}
		}
	}
	/**
	 * 品牌修改
	 */	
	public function brand_editOp() {
		$lang	= Language::getLangContent();
		$model_brand = Model('brand');
		if ($_POST['form_submit'] == 'ok' and intval($_POST['brand_id']) != 0) {
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			array("input"=>$_POST["brand_name"], "require"=>"true", "message"=>$lang['store_goods_brand_name_null'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showValidateError($error);
			}else {
				/**
				 * 上传图片
				 */
				if (!empty($_FILES['brand_pic']['name'])){
					$upload = new UploadFile();
					$upload->set('default_dir',ATTACH_BRAND);
					$upload->set('thumb_width',	150);
					$upload->set('thumb_height',50);
					$upload->set('thumb_ext',	'_small');
					$upload->set('ifremove',	true);
					$result = $upload->upfile('brand_pic');

					if ($result){
						$_POST['brand_pic'] = $upload->thumb_image;
					}else {
						showDialog($upload->error);
					}
				}

				$update_array = array();
				$update_array['brand_id'] = $_POST['brand_id'];
				$update_array['brand_name'] = $_POST['brand_name'];
				$update_array['brand_class'] = $_POST['brand_class'];
				if (!empty($_POST['brand_pic'])){
					$update_array['brand_pic'] = $_POST['brand_pic'];
				}

				$result = $model_brand->update($update_array);
				if ($result){
					/**
					 * 删除老图片
					 */
					if (!empty($_POST['brand_pic'])){
						@unlink(BasePath.DS.ATTACH_BRAND.DS.$_POST['old_brand_pic']);
					}
					showDialog($lang['nc_common_save_succ'],'index.php?act=store_goods&op=brand_list','succ',empty($_GET['inajax']) ?'':'CUR_DIALOG.close();');
				}else {
					showDialog($lang['nc_common_save_fail']);
				}
			}
		} else {
			showDialog($lang['nc_common_save_fail']);
		}
	}
	/**
	 * 品牌删除
	 */	
	public function drop_brandOp() {
		$model_brand	= Model('brand');
		$brand_id		= intval($_GET['brand_id']);
		if ($brand_id > 0){
			$brand_list = $model_brand->getBrandList(array('brand_id'=>$brand_id,'brand_apply'=>'0'));
			$brand_array = $brand_list[0];
			if (empty($brand_array) || $brand_array['store_id'] != $_SESSION['store_id']){
				showDialog(Language::get('nc_common_del_fail'));
			}
			if (!empty($brand_array['brand_pic'])){
				@unlink(BasePath.DS.ATTACH_BRAND.DS.$brand_array['brand_pic']);
			}
			/**
			 * 删除分类
			 */
			$model_brand->del($brand_id);
			unset($brand_array);
			showDialog(Language::get('nc_common_del_succ'),'index.php?act=store_goods&op=brand_list','succ');
		}else {
			showDialog(Language::get('nc_common_del_fail'));
		}
	}
	/**
	 * 判断当前分类是否为最后一级分类
	 */
	public function check_classOp() {
		if($_GET['required'] == 'false' and $_GET['cate_id'] == '0'){
			echo 'true';
			exit;
		}
		/**
		 * 实例化商品分类模型
		 */
		$model_class		= Model('goods_class');;
		$sub_class			= $model_class->getClassList(array('gc_parent_id'=>intval($_GET['cate_id']),'gc_show'=>1));
		if(is_array($sub_class)) {
			echo 'false';
		} else {
			echo 'true';
		}
	}
	/**
	 * 上传图片
	 */
	public function image_uploadOp() {
		//判断图片数量是否超限
		$model = Model();
		$store_grade = ($setting = F('store_grade')) ? $setting : H('store_grade',true,'file');
		$grade_id = $model->table('store')->getfby_store_id($_SESSION['store_id'],'grade_id');
		$album_limit = $store_grade[$grade_id]['sg_album_limit'];
		$album_count = $model->table('album_pic')->where(array('store_id'=>$_SESSION['store_id']))->count();
		if ($album_count >= $album_limit){
			$error = Language::get('store_goods_album_climit');
			if (strtoupper(CHARSET) == 'GBK') $error = Language::getUTF8($error);
			exit(json_encode(array('error'=>$error)));
		}

		$lang	= Language::getLangContent();

		$class_info = Model('album_class')->where(array('store_id'=>$_SESSION['store_id'],'is_default'=>1))->find();
		/**
	 	 * 上传图片
	 	 */
		$upload = new UploadFile();
		
		$upload->set('default_dir',ATTACH_GOODS.DS.$_SESSION['store_id'].DS.$upload->getSysSetPath());
		$upload->set('max_size',C('image_max_filesize'));
		$thumb_width	= C('thumb_tiny_width').','.C('thumb_small_width').','.C('thumb_mid_width').','.C('thumb_max_width').',240';
		$thumb_height	= C('thumb_tiny_height').','.C('thumb_small_height').','.C('thumb_mid_height').','.C('thumb_max_height').',1024';

		$upload->set('thumb_width',	$thumb_width);
		$upload->set('thumb_height',$thumb_height);
		$upload->set('thumb_ext',	'_tiny,_small,_mid,_max,_240x240');	
		$upload->set('fprefix',$_SESSION['store_id']);
		$upload->set('allow_type', array('gif','jpg','jpeg','png'));
		$result = $upload->upfile($_POST['id']);
		if (!$result){
			if (strtoupper(CHARSET) == 'GBK'){
				$upload->error = Language::getUTF8($upload->error);
			}
			$output	= array();
			$output['error']	= $upload->error;
			$output = json_encode($output);
			exit($output);
		}

		$img_path = $upload->getSysSetPath().$upload->file_name;
	
		/**
		 * 取得图像大小
		 */
		list($width, $height, $type, $attr) = getimagesize(BasePath.'/upload/store/goods/'.$_SESSION['store_id'].DS.$img_path);

		/**
		 * 存入相册
		 */
		$model_upload_album = Model('upload_album');
		$image = explode('.', $_FILES[$_POST['id']]["name"]);
		$insert_array = array();
		$insert_array['apic_name']	= $image['0'];
		$insert_array['apic_tag']	= '';
		$insert_array['aclass_id']	= $class_info['aclass_id'];
		$insert_array['apic_cover']	= $img_path;
		$insert_array['apic_size']	= intval($_FILES[$_POST['id']]['size']);
		$insert_array['apic_spec']	= $width.'x'.$height;
		$insert_array['upload_time']= time();
		$insert_array['store_id']	= $_SESSION['store_id'];
		$result1 = $model_upload_album->add($insert_array);

		$data = array();
		$data['file_name']	= $upload->getSysSetPath().$upload->thumb_image;
		$data['image_cover']= SiteUrl.DS.ATTACH_GOODS.DS.$_SESSION['store_id'].'/';

		if (C('ftp_open') && C('thumb.save_type')==3){
			import('function.ftp');
			if ($_url = remote_ftp(ATTACH_GOODS.DS.$_SESSION['store_id'],$img_path)){
				$data['image_cover'] = $_url.'/';
			}
		}

		/**
		 * 整理为json格式
		 */
		$output = json_encode($data);
		echo  $output;die;
	}
	/**
	 * 删除商品多图
	 */
	public function drop_imageOp() {
		$lang	= Language::getLangContent();
		if(empty($_GET['id'])) {
			echo 'false';
		}
		/**
		 * 实例化店铺商品模型
		 */
		$model_store_goods	= Model('goods');
		$drop_stata			= $model_store_goods->dropImageGoods(array('upload_id'=>intval($_GET['id'])));
		if($drop_stata) {
			echo json_encode(array('done'=>'true'));
		} else {
			echo json_encode(array('done'=>'false','msg'=>$lang['store_goods_upload_del_fail']));
		}
	}
	/**
	 * 批量上传图片页面
	 */
	public function image_swuploadOp() {
		Tpl::output('act',		trim($_GET['upload_type']));
		Tpl::output('instance',	$_GET['instance']);
		Tpl::output('id',		$_GET['id']);
		Tpl::output('belong',	$_GET['belong']);

		Tpl::showpage('image','null_layout');
	}
	/**
	 * ajax修改指定商品
	 *
	 */
	public function edit_goods_ajaxOp(){
		$lang	= Language::getLangContent();
		$rzt	= array();
		$rzt['done']	= true;
		if(!is_numeric($_GET['id'])){
			$rzt['done']	= false;
			$rzt['msg']		= $lang['miss_argument'];
		} elseif($_GET['value']	== ''){
			$rzt['done']	= false;
			$rzt['msg']		= $lang['miss_argument'];
		} elseif($_GET['column'] == ''){
			$rzt['done']	= false;
			$rzt['msg']		= $lang['miss_argument'];
		} else {
			$input	= array();
			switch($_GET['column']){
				case 'goods_name':
					break;
				case 'goods_store_price':
					if(!preg_match("/^\d+(\.\d{0,2})?$/",$_GET['value'])){
						$rzt['done']	= false;
						$rzt['msg']		= $lang['wrong_argument'];
					}
					break;
				case 'spec_goods_storage':
					if(!preg_match("/^\d+$/",$_GET['value'])){
						$rzt['done']	= false;
						$rzt['msg']		= $lang['wrong_argument'];
					}
					break;
				case 'goods_show':
					if(!in_array($_GET['value'],array('0','1'))){
						$rzt['done']	= false;
						$rzt['msg']		= "<script>history.go(0);</script>";
					}
					break;
				case 'goods_commend':
					if(!in_array($_GET['value'],array('0','1'))){
						$rzt['done']	= false;
						$rzt['msg']		= $lang['invalid_request'];
					}
					break;
				default:
					$rzt['done']	= false;
					$rzt['msg']		= $lang['wrong_argument'];
			}
			if($rzt['done']){
				$input	= array();
				$input[$_GET['column']]	= $_GET['value'];
				$model_class	= Model('goods');
				$result1	= $result	= true;
				if($_GET['column']!='spec_goods_storage'){
					$result	= $model_class->updateGoods($input,$_GET['id']);
				}
				if(in_array($_GET['column'],array('spec_goods_storage','goods_store_price'))){
					$goods_spec	= $model_class->getSpecGoods($_GET['id']);
					if(!empty($goods_spec) && is_array($goods_spec)){
						$goods_spec	= $goods_spec[0];
						$input	= array();
						switch($_GET['column']){
							case 'spec_goods_storage':
								$input['spec_goods_storage']	= $_GET['value'];
								break;
							case 'goods_store_price':
								$input['spec_goods_price']	= $_GET['value'];
								break;
						}
						$result1 = $model_class->updateSpecStorageGoods($input,$goods_spec['spec_id']);
					}else{
						$rzt['done']	= false;
						$rzt['msg']		= $lang['store_goods_ajax_find_none_spec'];
						$result1	= false;
					}
				}
				if($result and $result1){
					$goods_info	= $model_class->getGoods(array('goods_id'=>$_GET['id']));
					switch($_GET['column']){
						case 'goods_name':
							$rzt['retval']	= $goods_info[0]['goods_name'];
							break;
						case 'goods_store_price':
							$rzt['retval']	= $goods_info[0]['goods_store_price'];
							break;
						case 'spec_goods_storage':
							$rzt['retval']	= $goods_info[0]['spec_goods_storage'];
							break;
					}
				}else{
					$rzt['done']	= false;
					$rzt['msg']	= $lang['store_goods_ajax_update_fail'];
				}
			}
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$rzt['msg']		= Language::getUTF8($rzt['msg']);
			$rzt['retval']	= Language::getUTF8($rzt['retval']);
		}
		echo json_encode($rzt);
	}
	/**
	 * ajax获取商品分类的子级数据
	 *
	 */
	public function ajax_goods_classOp(){
		if(empty($_GET['gc_id']) or $_GET['gc_id'] == '0')exit;
		$gc	= Model('goods_class');
		$list	= $gc->getClassList(array('gc_parent_id'=>intval($_GET['gc_id']),'gc_show'=>1));
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$list = Language::getUTF8($list);
		}
		echo json_encode($list);
	}
	/**
	 * ajax商品分类搜索
	 */
	public function ajax_class_searchOp() {
		/**
		 * 获取分类TAG缓存
		 */
		$class_tag_array = ($tag = F('class_tag')) ? $tag : H('class_tag',true,'file');

		if(!isset($_GET['value'])){
			echo 'false';die;
		}

		$json_array = array();
		if(is_array($class_tag_array)){
			foreach ($class_tag_array as $v){
				$tag_name_array	= explode(',', $v['gc_tag_value']);
				$rs = preg_match('/'.trim($_GET['value']).'/i',$v['gc_tag_value']);
				if($rs != ''){
					if(CHARSET == 'GBK') $v = Language::getUTF8($v);
					$json_array[] = $v;
				}
			}
		}
		
		if(!empty($json_array)){
			echo json_encode($json_array);die;
		}
		echo 'false';die;
	}
	/**
	 * ajax添加/删除常用分类
	 */
	public function ajax_staple_controlOp() {
		Language::read('member_store_goods_index');
		$class_id = intval($_GET['class_id']);
		if($class_id < 1){
			echo json_encode(array('done'=>false,'msg'=>Language::get('wrong_argument')));die;
		}
		/**
		 * 实例化模型
		 */
		$model_staple = Model('goods_class_staple');
		
		//添加常用分类
		if($_GET['column'] == 'add') {
			$count = $model_staple->countStaple($_SESSION['store_id']);
			if($count >= '20'){
				echo json_encode(array('done'=>false,'msg'=>Language::get('store_goods_step1_max_20')));die;
			}
			$staple_array = $this->getTagByCache($class_id);
			$staple_array['done'] = true;
			// 转码
			if (strtoupper(CHARSET) == 'GBK'){
				$staple_array = Language::getUTF8($staple_array);
			}
			$staple_array['msg'] = Language::get('store_goods_step1_ajax_add_class');
			echo json_encode($staple_array);die;
		//删除常用分类
		}else if($_GET['column'] == 'del') {
			$result = $model_staple->delStaple($class_id, $_SESSION['store_id']);
			if($result){
				echo json_encode(array('done'=>true));die;
			}else{
				echo json_encode(array('done'=>false, 'msg'=>''));die;
			}
		}
	}
	/**
	 * ajax选择常用商品分类
	 */
	public function ajax_show_commOp(){
		list($gc_id, $staple_id, $type_id) = explode('|', $_GET['name']);
		
		/**
		 * 查询相应的商品分类id
		 */ 
		$model_tag	= Model('goods_class_tag');
		$tag_list	= $model_tag->getTagList(array('gc_id'=>intval($gc_id), 'type_id'=>intval($type_id)), '', 'gc_id_1,gc_id_2,gc_id_3');
		if(empty($tag_list) || !is_array($tag_list)){
			echo json_encode(array('done'=>false, 'msg'=>''));die;
		}
		
		$list_array				= array();
		$list_array['done']		= true;
		$list_array['one']		= '';
		$list_array['two']		= '';
		$list_array['three']	= '';
		
		$gc_id_1	= intval($tag_list['0']['gc_id_1']);
		$gc_id_2	= intval($tag_list['0']['gc_id_2']);
		$gc_id_3	= intval($tag_list['0']['gc_id_3']);
		
		/**
		 * 查询同级分类列表
		 */ 
		$model_goods_class	= Model('goods_class');
		// 1级
		if($gc_id_1 >0){
			$class_list			= $model_goods_class->getClassList(array('gc_parent_id'=>'0'), 'gc_id,gc_name,type_id');
			if(empty($class_list) || !is_array($class_list)){
				echo json_encode(array('done'=>false, 'msg'=>''));die;
			}
			foreach ($class_list as $val){
				if($val['gc_id'] == $gc_id_1){
					$list_array['one']	.= '<li class="" onclick="selClass(this);" id="'.$val['gc_id'].'|1|'.$val['type_id'].'"> <a class="classDivClick" href="javascript:void(0)"><span class="has_leaf">'.$val['gc_name'].'</span></a> </li>';
				}else{
					$list_array['one']	.= '<li class="" onclick="selClass(this);" id="'.$val['gc_id'].'|1|'.$val['type_id'].'"> <a class="" href="javascript:void(0)"><span class="has_leaf">'.$val['gc_name'].'</span></a> </li>';
				}
			}
		}
		// 2级
		if($gc_id_2 >0){
			$class_list			= $model_goods_class->getClassList(array('gc_parent_id'=>$gc_id_1), 'gc_id,gc_name,type_id');
			if(empty($class_list) || !is_array($class_list)){
				echo json_encode(array('done'=>false, 'msg'=>''));die;
			}
			foreach ($class_list as $val){
				if($val['gc_id'] == $gc_id_2){
					$list_array['two']	.= '<li class="" onclick="selClass(this);" id="'.$val['gc_id'].'|2|'.$val['type_id'].'"> <a class="classDivClick" href="javascript:void(0)"><span class="has_leaf">'.$val['gc_name'].'</span></a> </li>';
				}else{
					$list_array['two']	.= '<li class="" onclick="selClass(this);" id="'.$val['gc_id'].'|2|'.$val['type_id'].'"> <a class="" href="javascript:void(0)"><span class="has_leaf">'.$val['gc_name'].'</span></a> </li>';
				}
			}
		}
		// 3级
		if($gc_id_3 >0){
			$class_list			= $model_goods_class->getClassList(array('gc_parent_id'=>$gc_id_2), 'gc_id,gc_name,type_id');
			if(empty($class_list) || !is_array($class_list)){
				echo json_encode(array('done'=>false, 'msg'=>''));die;
			}
			foreach ($class_list as $val){
				if($val['gc_id'] == $gc_id_3){
					$list_array['three']	.= '<li class="" onclick="selClass(this);" id="'.$val['gc_id'].'|3|'.$val['type_id'].'"> <a class="classDivClick" href="javascript:void(0)"><span class="has_leaf">'.$val['gc_name'].'</span></a> </li>';
				}else{
					$list_array['three']	.= '<li class="" onclick="selClass(this);" id="'.$val['gc_id'].'|3|'.$val['type_id'].'"> <a class="" href="javascript:void(0)"><span class="has_leaf">'.$val['gc_name'].'</span></a> </li>';
				}
			}
		}
		// 转码
		if (strtoupper(CHARSET) == 'GBK'){
			$list_array = Language::getUTF8($list_array);
		}
		echo json_encode($list_array);die;
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @param array 	$array		附加菜单
	 * @return 
	 */
	private function profile_menu($menu_type,$menu_key='',$array=array()) {
		Language::read('member_layout');
		$lang	= Language::getLangContent();
		$menu_array		= array();
		switch ($menu_type) {
			case 'goods':
				$menu_array	= array(
				1=>array('menu_key'=>'goods_list',	'menu_name'=>$lang['nc_member_path_goods_selling'],			'menu_url'=>'index.php?act=store_goods&op=goods_list'));
				break;
			case 'goods_storage':
				$menu_array	= array(
				1=>array('menu_key'=>'goods_storage',	'menu_name'=>$lang['nc_member_path_goods_storage'],		'menu_url'=>'index.php?act=store_goods&op=goods_storage'),
				2=>array('menu_key'=>'goods_state',	'menu_name'=>$lang['nc_member_path_goods_state'],			'menu_url'=>'index.php?act=store_goods&op=goods_storage&type=state'));
				break;
			case 'import_taobao':
				$menu_array = array(
				1=>array('menu_key'=>'import_taobao','menu_name'=>$lang['nc_member_path_taobao_import'],		'menu_url'=>'index.php?act=store_goods&op=taobao_import'));
				break;
			case 'brand_list':
				$menu_array = array(
				1=>array('menu_key'=>'brand_list',	'menu_name'=>$lang['nc_member_path_brand_list'],			'menu_url'=>'index.php?act=store_goods&op=brand_list'));
				break;
		}
		if(!empty($array)) {
			$menu_array[] = $array;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
	/**
	 * 淘宝助理导入
	 *
	 */
	public function taobao_importOp(){
		$lang 	= Language::getLangContent();
		if(!$_POST){
			/**
			 * 获取商品分类
			 */
			$gc	= Model('goods_class');
			$gc_list	= $gc->getClassList(array('gc_parent_id'=>'0','gc_show'=>1));
			Tpl::output('gc_list',$gc_list);
			
			/**
			 * 获取店铺商品分类
			 */
			$model_store_class	= Model('my_goods_class');
			$store_goods_class	= $model_store_class->getClassTree(array('store_id'=>$_SESSION['store_id'],'stc_state'=>'1'));
			Tpl::output('store_goods_class',$store_goods_class);
			
			if($_GET['step'] != ''){
				Tpl::output('step',$_GET['step']);
			}else{
				Tpl::output('step','1');
			}
		}else{
			$file	= $_FILES['csv'];
			/**
			 * 上传文件存在判断
			 */
			if(empty($file['name'])){
				showMessage($lang['store_goods_import_choose_file'],'','html','error');
			}
			/**
			 * 文件来源判定
			 */
			if(!is_uploaded_file($file['tmp_name'])){
				showMessage($lang['store_goods_import_unknown_file'],'','html','error');
			}
			/**
			 * 文件类型判定
			 */
			$file_name_array	= explode('.',$file['name']);
			if($file_name_array[count($file_name_array)-1] != 'csv'){
				showMessage($lang['store_goods_import_wrong_type'].$file_name_array[count($file_name_array)-1],'','html','error');
			}
			/**
			 * 文件大小判定
			 */
			if($file['size'] > intval(ini_get('upload_max_filesize'))*1024*1024){
				showMessage($lang['store_goods_import_size_limit'],'','html','error');
			}
			/**
			 * 商品分类判定
			 */
			if(empty($_POST['gc_id'])){
				showMessage($lang['store_goods_import_wrong_class'],'','html','error');
			}
			$gc	= Model('goods_class');
			$gc_row	= $gc->getGoodsClassLineForTag($_POST['gc_id']);
			if(!is_array($gc_row) or count($gc_row) == 0){
				showMessage($lang['store_goods_import_wrong_class1'],'','html','error');
			}
			$gc_sub_list	=	$gc->getClassList(array('gc_parent_id'=>intval($_POST['gc_id']),'gc_show'=>1));
			if(is_array($gc_sub_list) and count($gc_sub_list) > 0){
				showMessage($lang['store_goods_import_wrong_class2'],'','html','error');
			}
			/**
			 * 店铺商品分类判定
			 */
			$stc_ids	= array();
			$stc	= Model('store_goods_class');
			if(is_array($_POST['stc_id']) and count($_POST['stc_id']) > 0){
				foreach ($_POST['stc_id'] as $stc_id) {
					if(!in_array($stc_id,$stc_ids)){
						$stc_row	= $stc->getOneById($stc_id);
						if(is_array($stc_row) and count($stc_row) > 0){
							$stc_ids[]	= $stc_id;
						}
					}
				}
			}
			/**
			 * 上传文件的字符编码转换
			 */
			$csv_string	= unicodeToUtf8(file_get_contents($file['tmp_name']));
			
			/* 兼容淘宝助理5 start */
			$csv_array = explode("\tsyncStatus", $csv_string, 2);
			if(count($csv_array) == 2){
				$csv_string	= $csv_array[1];
			}
			/* 兼容淘宝助理5 end */
			
			/**
			 * 将文件转换为二维数组形式的商品数据
			 */
			$records	= $this->parse_taobao_csv($csv_string);
			if($records === false){
			showMessage($lang['store_goods_import_wrong_column'],'','html','error');
			}
			
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$records = Language::getGBK($records);
			}
			$model_store_goods	= Model('goods');
			$goods_num=$model_store_goods->countGoods(array('store_id'=>$_SESSION['store_id']));
			/**
			 * 商品数,空间使用，使用期限判断
			 */
			$model_store	= Model('store');
			$store_info		= $model_store->shopStore(array('store_id'=>$_SESSION['store_id']));
			$model_store_grade	= Model('store_grade');
			$store_grade	= $model_store_grade->getOneGrade($store_info['grade_id']);
			/*商品数判断*/
			$remain_num	= -1;
			if(intval($store_grade['sg_goods_limit']) != 0) {
				if($goods_num >= $store_grade['sg_goods_limit']) {
					showMessage($lang['store_goods_index_goods_limit'].$store_grade['sg_goods_limit'].$lang['store_goods_index_goods_limit1'],'index.php?act=store_goods&op=goods_list','html','error');
				}
				$remain_num	= $store_grade['sg_goods_limit']-$goods_num;
			}
			/*使用期限判断*/
			if(intval($store_info['store_end_time']) != 0) {
				if(time() >= $store_info['store_end_time']) {
					showMessage($lang['store_goods_index_time_limit'],'index.php?act=store_goods&op=goods_list','html','error');
				}
			}
			/**
			 * 循环添加数据
			 */
			if(is_array($records) and count($records) > 0){
				foreach($records as $k=>$record){
					if($remain_num>0 and $k>=$remain_num){
						showMessage($lang['store_goods_index_goods_limit'].$store_grade['sg_goods_limit'].$lang['store_goods_index_goods_limit1'].$lang['store_goods_import_end'].(count($records)-$remain_num).$lang['store_goods_import_products_no_import'],'index.php?act=store_goods&op=taobao_import&step=2','html','error');
					}
					$pic_array	= $this->get_goods_image($record['goods_image']);
					if(empty($record['goods_name']))continue;
					$param	= array();
					$param['goods_name']			= $record['goods_name'];
					$param['gc_id']					= intval($_POST['gc_id']);
					$param['gc_name']				= $gc_row['gc_tag_name'];
					$param['store_id']				= $_SESSION['store_id'];
					$param['goods_image']			= $pic_array['goods_image'][0];
					$param['goods_store_price']		= $record['goods_store_price'];
					$param['goods_show']			= '1';
					$param['goods_commend']			= $record['goods_commend'];
					$param['goods_add_time']		= time();
					$param['goods_body']			= $record['goods_body'];
					$param['py_price']				= $record['py_price'];
					$param['es_price']				= $record['es_price'];
					$param['kd_price']				= $record['kd_price'];
					$param['goods_form']			= '1';
					$param['goods_starttime']		= time();
					$param['goods_endtime']			= time()+C('product_indate')*86400;
					$param['goods_transfee_charge']	= $record['goods_transfee_charge'];
					$param['city_id']				= intval($_POST['city_id']);
					$param['province_id']			= intval($_POST['province_id']);
					
					$goods_id	= $model_store_goods->saveGoods($param);
					$goods_id_str.=",".$goods_id;
					if($goods_id){
						/**
						 * 添加商品的店铺分类表
						 */
						if(!empty($stc_ids)){
							$model_store_goods->saveStoreClassGoods($stc_ids,$goods_id);
						}
						/**
						 * 添加规格表
						 */
						if(true){
							$spec_array		= array();
							$spec_array[0]['price']	= $record['goods_store_price'];
							$spec_array[0]['stock']	= $record['spec_goods_storage'];
							$spec_id = $model_store_goods->saveSpecGoods($spec_array,$goods_id);
							/**
							 * 修改商品
							 */
							$model_store_goods->updateGoods(array('spec_id'=>$spec_id),$goods_id);
						}
						/**
						 * 商品多图的添加
						 */
						if(!empty($pic_array['goods_image']) && is_array($pic_array['goods_image'])){
							$model_upload	= Model('upload');
							foreach ($pic_array['goods_image'] as $pic) {
								if($pic	== '')continue;
								$param	= array();
								$param['file_name']	= $pic;
								$param['file_thumb']= $pic;
								$param['store_id']	= $_SESSION['store_id'];
								$param['upload_type']	= '2';
								$param['upload_time']	= time();
								$param['item_id']	= $goods_id;
								$model_upload->add($param);
							}
						}
					}else{
						//						导入商品中的错误处理
					}
				}
				if($goods_id_str!=""){
					Tpl::output('goods_id_str',substr($goods_id_str,1,strlen($goods_id_str)));
				}
			}
			Tpl::output('step','2');
		}
		
		/**
		 * 相册分类
		 */
		$model_album = Model('album');
		$param = array();
		$param['album_aclass.store_id']	= $_SESSION['store_id'];
		$aclass_info = $model_album->getClassList($param);
		Tpl::output('aclass_info',$aclass_info);
		
		
		Tpl::output('PHPSESSID',session_id());
		self::profile_menu('import_taobao','import_taobao');
		Tpl::output('menu_sign','taobao_import');
		Tpl::showpage('store_goods_import');
	}
	/**
	 * 分割图片字符串
	 *
	 * @param string $pic_string 图片字符串
	 * @return array 数组格式的返回内容
	 */
	private function get_goods_image($pic_string){
		if($pic_string == ''){
			return false;
		}
		$pic_array = explode(';',$pic_string);
		if(!empty($pic_array) && is_array($pic_array)){
			$array	= array();
			$goods_image	= array();
			$multi_image	= array();
			$i=0;
			foreach($pic_array as $v){
				if($v != ''){
					$line = explode(':',$v);//[0] 文件名tbi [2] 排序
					$goods_image[] = $line[0];
				}
			}
			$array['goods_image']	= $goods_image;
			return $array;
		}else{
			return false;
		}
	}
	/**
	 * 淘宝数据字段名
	 *
	 * @return array
	 */
	private function taobao_fields()
	{
		return array(
		'goods_name'		=> '宝贝名称',
		'cid'				=> '宝贝类目',
		'goods_form'		=> '新旧程度',
		'goods_store_price'	=> '宝贝价格',
		'spec_goods_storage'=> '宝贝数量',
		'goods_indate'		=> '有效期',
		'goods_transfee_charge'=>'运费承担',
		'py_price'			=>'平邮',
		'es_price'			=>'EMS',
		'kd_price'			=>'快递',
		//'goods_show'		=> '放入仓库',
		'goods_commend'		=> '橱窗推荐',
		'goods_body'		=> '宝贝描述',
		'goods_image'		=> '新图片'
		);
		/*return array(
		'goods_name'		=> Language::get('store_goods_import_goodsname'),
		'cid'				=> Language::get('store_goods_import_goodscid'),
		'goods_store_price'	=> Language::get('store_goods_import_goodsprice'),
		'spec_goods_storage'=> Language::get('store_goods_import_goodsnum'),
		//'goods_show'		=> '放入仓库',
		'goods_commend'		=> Language::get('store_goods_import_goodstuijian'),
		'goods_body'		=> Language::get('store_goods_import_goodsdesc'),
		'goods_image'		=> Language::get('store_goods_import_goodspic'),
		'sale_attr'			=> Language::get('store_goods_import_goodsproperties')
		);*/
	}

	/**
	 * 每个字段所在CSV中的列序号，从0开始算 
	 *
	 * @param array $title_arr
	 * @param array $import_fields
	 * @return array
	 */
	private function taobao_fields_cols($title_arr, $import_fields)
	{
		$fields_cols = array();
		foreach ($import_fields as $k => $field)
		{
			$pos = array_search($field, $title_arr);
			if ($pos !== false)
			{
				$fields_cols[$k] = $pos;
			}
		}
		return $fields_cols;
	}

	/**
	 * 解析淘宝助理CSV数据
	 *
	 * @param string $csv_string
	 * @return string
	 */
	private function parse_taobao_csv($csv_string)
	{
		/* 定义CSV文件中几个标识性的字符的ascii码值 */
		define('ORD_SPACE', 32); // 空格
		define('ORD_QUOTE', 34); // 双引号
		define('ORD_TAB',    9); // 制表符
		define('ORD_N',     10); // 换行\n
		define('ORD_R',     13); // 换行\r

		/* 字段信息 */
		$import_fields = $this->taobao_fields(); // 需要导入的字段在CSV中显示的名称
		$fields_cols = array(); // 每个字段所在CSV中的列序号，从0开始算
		$csv_col_num = 0; // csv文件总列数

		$pos = 0; // 当前的字符偏移量
		$status = 0; // 0标题未开始 1标题已开始
		$title_pos = 0; // 标题开始位置
		$records = array(); // 记录集
		$field = 0; // 字段号
		$start_pos = 0; // 字段开始位置
		$field_status = 0; // 0未开始 1双引号字段开始 2无双引号字段开始
		$line =0; // 数据行号
		while($pos < strlen($csv_string))
		{
			$t = ord($csv_string[$pos]); // 每个UTF-8字符第一个字节单元的ascii码
			$next = ord($csv_string[$pos + 1]);
			$next2 = ord($csv_string[$pos + 2]);
			$next3 = ord($csv_string[$pos + 3]);

			if ($status == 0 && !in_array($t, array(ORD_SPACE, ORD_TAB, ORD_N, ORD_R)))
			{
				$status = 1;
				$title_pos = $pos;
			}
			
			if ($status == 1)
			{
				if ($field_status == 0 && $t== ORD_N)
				{
					static $flag = null;
					if ($flag === null)
					{
						$title_str = substr($csv_string, $title_pos, $pos - $title_pos);
						$title_arr = explode("\t", trim($title_str));
						$fields_cols = $this->taobao_fields_cols($title_arr, $import_fields);
						
						if (count($fields_cols) != count($import_fields))
						{
							return false;
						}
						$csv_col_num = count($title_arr); // csv总列数
						$flag = 1;
					}

					if ($next == ORD_QUOTE)
					{
						$field_status = 1; // 引号数据单元开始
						$start_pos = $pos = $pos + 2; // 数据单元开始位置(相对\n偏移+2)
					}
					else
					{
						$field_status = 2; // 无引号数据单元开始
						$start_pos = $pos = $pos + 1; // 数据单元开始位置(相对\n偏移+1)
					}
					continue;
				}

				if($field_status == 1 && $t == ORD_QUOTE && in_array($next, array(ORD_N, ORD_R, ORD_TAB))) // 引号+换行 或 引号+\t
				{
					$records[$line][$field] = addslashes(substr($csv_string, $start_pos, $pos - $start_pos));
					$field++;
					if ($field == $csv_col_num)
					{
						$line++;
						$field = 0;
						$field_status = 0;
						continue;
					}
					if (($next == ORD_N && $next2 == ORD_QUOTE) || ($next == ORD_TAB && $next2 == ORD_QUOTE) || ($next == ORD_R && $next2 == ORD_QUOTE))
					{
						$field_status = 1;
						$start_pos = $pos = $pos + 3;
						continue;
					}
					if (($next == ORD_N && $next2 != ORD_QUOTE) || ($next == ORD_TAB && $next2 != ORD_QUOTE) || ($next == ORD_R && $next2 != ORD_QUOTE))
					{
						$field_status = 2;
						$start_pos = $pos = $pos + 2;
						continue;
					}
					if ($next == ORD_R && $next2 == ORD_N && $next3 == ORD_QUOTE)
					{
						$field_status = 1;
						$start_pos = $pos = $pos + 4;
						continue;
					}
					if ($next == ORD_R && $next2 == ORD_N && $next3 != ORD_QUOTE)
					{
						$field_status = 2;
						$start_pos = $pos = $pos + 3;
						continue;
					}
				}

				if($field_status == 2 && in_array($t, array(ORD_N, ORD_R, ORD_TAB))) // 换行 或 \t
				{
					$records[$line][$field] = addslashes(substr($csv_string, $start_pos, $pos - $start_pos));
					$field++;
					if ($field == $csv_col_num)
					{
						$line++;
						$field = 0;
						$field_status = 0;
						continue;
					}
					if (($t == ORD_N && $next == ORD_QUOTE) || ($t == ORD_TAB && $next == ORD_QUOTE) || ($t == ORD_R && $next == ORD_QUOTE))
					{
						$field_status = 1;
						$start_pos = $pos = $pos + 2;
						continue;
					}
					if (($t == ORD_N && $next != ORD_QUOTE) || ($t == ORD_TAB && $next != ORD_QUOTE) || ($t == ORD_R && $next != ORD_QUOTE))
					{
						$field_status = 2;
						$start_pos = $pos = $pos + 1;
						continue;
					}
					if ($t == ORD_R && $next == ORD_N && $next2 == ORD_QUOTE)
					{
						$field_status = 1;
						$start_pos = $pos = $pos + 3;
						continue;
					}
					if ($t == ORD_R && $next == ORD_N && $next2 != ORD_QUOTE)
					{
						$field_status = 2;
						$start_pos = $pos = $pos + 2;
						continue;
					}
				}
			}

			if($t > 0 && $t <= 127) {
				$pos++;
			} elseif(192 <= $t && $t <= 223) {
				$pos += 2;
			} elseif(224 <= $t && $t <= 239) {
				$pos += 3;
			} elseif(240 <= $t && $t <= 247) {
				$pos += 4;
			} elseif(248 <= $t && $t <= 251) {
				$pos += 5;
			} elseif($t == 252 || $t == 253) {
				$pos += 6;
			} else {
				$pos++;
			}	
		}
		$return = array();
		foreach ($records as $key => $record)
		{
			foreach ($record as $k => $col)
			{
				$col = trim($col); // 去掉数据两端的空格
				/* 对字段数据进行分别处理 */
				switch ($k)
				{
					case $fields_cols['goods_body']		: $return[$key]['goods_body'] = str_replace(array("\\\"\\\"", "\"\""), array("\\\"", "\""), $col); break;
					case $fields_cols['goods_image']	: $return[$key]['goods_image'] = trim($col,'"');break;
					//case $fields_cols['goods_show']		: $return[$key]['goods_show'] = $col == 1 ? 0 : 1; break;
					case $fields_cols['goods_name']		: $return[$key]['goods_name'] = $col; break;
					case $fields_cols['spec_goods_storage']	: $return[$key]['spec_goods_storage'] = $col; break;
					case $fields_cols['goods_store_price']: $return[$key]['goods_store_price'] = $col; break;
					case $fields_cols['goods_commend']	: $return[$key]['goods_commend'] = $col; break;
					case $fields_cols['sale_attr']		: $return[$key]['sale_attr'] = $col; break;
					case $fields_cols['goods_form']	: $return[$key]['goods_form'] = $col; break;
					case $fields_cols['goods_transfee_charge']		: $return[$key]['goods_transfee_charge'] = $col; break;
					case $fields_cols['py_price']	: $return[$key]['py_price'] = $col; break;
					case $fields_cols['es_price']		: $return[$key]['es_price'] = $col; break;
					case $fields_cols['kd_price']		: $return[$key]['kd_price'] = $col; break;
					case $fields_cols['kd_price']		: $return[$key]['kd_price'] = $col; break;
//					case $fields_cols['goods_indate']	: $return[$key]['goods_indate'] = $col; break;
				}
			}
		}
		return $return;
	}
	/**
	 * 整理数据
	 *
	 */
	public function date_packOp(){
		Language::read('member_store_goods_index');
		$lang	= Language::getLangContent();
		if(trim($_GET['goods_id_str'])==''){
			showMessage($lang['store_goods_pack_wrong1'],'','','error');
		}else{
			$upload_model=Model('upload');
			$gid_arr=explode(',',trim($_GET['goods_id_str']));
			if(is_array($gid_arr) && !empty($gid_arr)){
				$path=ATTACH_GOODS.DS.$_SESSION['store_id'].DS;
				foreach($gid_arr as $v1){
					$upload_list=$upload_model->getUploadList(array('item_id'=>$v1),'upload_id,file_name,file_thumb');
					
					$goods_image_more	= array();		// 商品多图
					$goods_image		= '';			// 商品默认图
					foreach($upload_list as $v2){
						// 最多五张图片，否则跳出循环
						if(count($goods_image_more) == 5) break;
						if(file_exists($path.str_replace('_small', '_tiny', $v2['file_thumb']))){
							$goods_image_more[] = str_replace('_small', '_tiny', $v2['file_thumb']);
							if($goods_image == '') $goods_image = $v2['file_thumb'];
						}else{
							$upload_model->dropUploadById($v2['upload_id']);
						}
					}
					$goods_image_more = implode(',', $goods_image_more);
					//验证商品内容图片是否存在
					//如果不存在则使用upload的第一张图作为商品内容图
					//如果upload中也不存在则图片内容改为为空
					$goods_model=Model('goods');
					$goods_model->updateGoods(array('goods_image'=>$goods_image,'goods_image_more'=>$goods_image_more),$v1);
					$upload_model->delByWhere(array('item_id'=>$v1,'upload_type'=>$_SESSION['store_id']));
				}
				showMessage($lang['store_goods_pack_success'],'index.php?act=store_goods');
			}else{
				showMessage($lang['store_goods_pack_wrong2'],'','','error');
			}
		}
	}
	/**
	 * 根据分类id获取TAG
	 * 
	 * @param int $class_id
	 * @return array
	 */
	private function getTagByCache($class_id){
		/**
		 * 实例化模型
		 */
		$model_staple = Model('goods_class_staple');
		/**
		 * 获取分类TAG缓存
		 */
		$class_tag_array = ($tag = F('class_tag')) ? $tag : H('class_tag',true,'file');
		if(!empty($class_tag_array) && is_array($class_tag_array)){
			foreach ($class_tag_array as $v){
				if($v['gc_id'] == $class_id){
					$param_array = array();
					$param_array['staple_name']	= $v['gc_tag_name'];
					$param_array['gc_id']		= $v['gc_id'];
					$param_array['type_id']		= $v['type_id'];
					$param_array['store_id']	= $_SESSION['store_id'];
					$param_array['staple_id']	= $model_staple->addStaple($param_array);
					return $param_array;
				}
			}
		}
		
		//如果缓存中不存在，添加商品分类TAG，并保存到常用分类
		/**
		 * 实例化模型
		 */
		$model_class		= Model('goods_class');
		$model_class_tag	= Model('goods_class_tag');
		$gc_list = $model_class->getGoodsClassLineForTag($class_id);
		$return = $model_class_tag->addOneTag($gc_list);
		
		//添加常用分类
		$param_array = array();
		$param_array['staple_name']	= $gc_list['gc_tag_name'];
		$param_array['gc_id']		= $gc_list['gc_id'];
		$param_array['type_id']		= $gc_list['type_id'];
		$param_array['store_id']	= $_SESSION['store_id'];
		$param_array['staple_id']	= $model_staple->addStaple($param_array);
		return $param_array;
	}
}
