<?php
/**
 * 前台品牌分类
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
class brandControl extends BaseHomeControl {
	public function indexOp(){
		//读取语言包
		Language::read('home_brand_index');
		//分类导航
		$nav_link = array(
			0=>array(
				'title'=>Language::get('homepage'),
				'link'=>'index.php'
			),
			1=>array(
				'title'=>Language::get('brand_index_all_brand')
			)
		);
		Tpl::output('nav_link_list',$nav_link);
		//获得推荐店铺		 
		$model_store = Model('store');
		$store_r_list = $model_store->getRecommendStore(5);
		Tpl::output('store_r',$store_r_list);
		
		//获得品牌列表
		$model = Model();
		$brand_c_list = $model->table('brand')->where(array('brand_apply'=>'1'))->order('brand_sort')->select();
		//获得品牌分类下属品牌
		$brand_listnew = array();
		$brand_listother = array();
		if (!empty($brand_c_list) && is_array($brand_c_list)){
			foreach ($brand_c_list as $key=>$brand_c){
				if (!empty($brand_c['brand_class'])){
					$brand_listnew[$brand_c['brand_class']]['brand'][] = $brand_c;
					$brand_listnew[$brand_c['brand_class']]['brand_class'] += 1; 
				}else {
					$brand_listother['brand'][] = $brand_c;
					$brand_listother['brand_class'] += 1;
				}
				//推荐品牌
				if ($brand_c['brand_recommend'] == 1){
					$brand_r_list[] = $brand_c;
				}
			}
			if (!empty($brand_listother)){
				$brand_listnew['other'] = $brand_listother;
			}
		}
		Tpl::output('brand_c',$brand_listnew);
		Tpl::output('brand_r',$brand_r_list);
		Tpl::output('html_title',Language::get('brand_index_brand_list'));
		//页面输出
		Tpl::output('index_sign','brand');
		Model('seo')->type('brand')->show();
		Tpl::showpage('brand');
	}
	
	public function listOp(){
		Language::read('home_brand_index');
		$lang	= Language::getLangContent();
		/**
		 * 验证品牌
		 */
		$model_brand = Model('brand');
		$brand_id = intval($_GET['brand']);
		$brand_lise = $model_brand->getOneBrand($brand_id);
		if(!$brand_lise){
			showMessage($lang['wrong_argument'],'index.php','html','error');
		}
		
		/**
		 * 实例化模型
		 */
		$model_type			= Model('type');
		
		/**
		 * 得到查询价格
		 */
		if (!empty($_GET['price'])){
			$price = explode('-',$_GET['price']);
			if (intval($price[0]) > 0 || intval($price[1]) > 0){
				$price_interval[0] = empty($price[0]) ? 0 : $price[0];
				$price_interval[1] = empty($price[1]) ? 0 : $price[1];
			}
			Tpl::output('price_interval',$price_interval);
		}

		/**
		 * 得到排序方式
		 */
		if (!empty($_GET['key'])){
			$order_tmp = trim($_GET['key']);
			$order = '';
			switch ($order_tmp){
				case 'sales'://销量
					$order = 'salenum';
					break;
				case 'credit'://信用
					$order = 'store_credit';
					break;
				case 'price'://价格升序
					$order = 'goods_store_price';
					break;
				case 'click'://浏览量
					$order = 'goods_click';
					break;
			}
			$order .=' '.trim($_GET['order']);
		}

		
		/**
		 * 获得推荐品牌
		 */
		$brand_class = Model('brand');
		//获得列表
		$brand_r_list = $brand_class->getBrandList(array(
			'brand_recommend'=>1,
			'field'=>'brand_id,brand_name,brand_pic',
			'brand_apply'=>1,
			'limit'=>'0,10'
		));
		Tpl::output('brand_r',$brand_r_list);

		/**
		 * 成色筛选
		 */
		if(isset($_GET['form'])){
			switch (intval($_GET['form'])){
				case 1:
					$form		= $lang['brand_form_new'];
					$goods_form	= 1;
					break;
				case 2:
					$form		= $lang['brand_form_used'];
					$goods_form	= 2;
					break;
			}
			Tpl::output('form',$form);
		}
		
		/**
		 * 筛选类型
		 */
		$xianshi_flag = 0;
		$group_flag = 0;
		if (!empty($_GET['promotion'])){
			//当前选项
			$promotion = '';
			switch ($_GET['promotion']){
				case 'xianshi':
					$promotion = $lang['nc_xianshi'];
					$xianshi_flag = 1;
					break;
				case 'groupbuy':
					$promotion = $lang['brand_index_groupbuy'];
					$group_flag = 1;
					break;
			}
		}
		Tpl::output('promotion',$promotion);
		
		/**
		 * 分页信息
		 */
		$page	= new Page();
		$page->setEachNum(40);
		$page->setStyle('admin');
		
		/**
		 * 得到地区id
		 */
		if(intval($_GET['area_id']) > 0){
			$area_id = intval($_GET['area_id']);
		}

		/**
		 * 得到商品列表
		 */
		$model_goods = Model('goods');
		$ext_order = C('promotion_allow') ? 'xianshi_flag desc,goods_id desc' : 'goods_id desc'; 
		$fieldstr = " goods.goods_id,goods.goods_name,goods.gc_id,goods.gc_name,goods.store_id,goods.goods_image,goods.goods_store_price,
		goods.goods_click,goods.goods_state,goods.goods_commend,goods.commentnum,goods.salenum,goods.goods_goldnum,goods.goods_isztc,
		goods.goods_ztcstartdate,goods.goods_ztclastdate,goods.group_flag,goods.group_price,goods.xianshi_flag,goods.xianshi_discount,
		goods.city_id,goods.province_id,goods.kd_price,goods.py_price,goods.es_price,
		store.store_name,store.grade_id,store.store_domain,store.store_credit,store.praise_rate,store.store_desccredit";
		$goods_list = $model_goods->getGoods(array(
				'brand_id'=>$brand_id,
				'price'=>$price_interval,
				'group_flag'=>$group_flag,
				'xianshi_flag'=>$xianshi_flag,
				'province_id'=>$area_id,
				'goods_show'=>'1',
				'goods_form'=>$goods_form,
				'order'=>$order ? $order.','.$ext_order:$ext_order,
		),$page,$fieldstr,'store');
		// 直通车
		if (C('gold_isuse')==1 && C('ztc_isuse') == 1){
			$fieldstr = " goods.goods_id,goods.goods_name,goods.gc_id,goods.gc_name,goods.store_id,goods.goods_image,goods.goods_store_price,
			goods.goods_click,goods.goods_state,goods.goods_commend,goods.commentnum,goods.salenum,goods.goods_goldnum,goods.goods_isztc,
			goods.goods_ztcstartdate,goods.goods_ztclastdate";
			$ztc_list = $model_goods->getGoods(array(
					'brand_id'=>$brand_id,
					'goods_show'=>'1',
					'goods_isztc'=>'1',
					'goods_ztcopen'=>'1',
					'limit'=>'8',
					'order'=>rand(1,5),
			),'',$fieldstr,'goods');
			Tpl::output('ztc_list',$ztc_list);
		}
		
		/**
		 * 输出分页
		 */
		Tpl::output('show_page',$page->show());

		/**
		 * 商品展示形式
		 */
       $display_mode = $_COOKIE['goodsDisplayMode'] ? $_COOKIE['goodsDisplayMode'] : 'squares'; //默认以方格展示
		/**
		 * 整理商品列表
		 */		
		if (!empty($goods_list) && is_array($goods_list)){
			
			//获得店铺等级名称
//			$store_grade = F('store_grade');
//			foreach ($goods_list as $key=>$goods){
//				$goods_list[$key]['grade_name'] 	= $store_grade[$goods['grade_id']]['name'];
//			}

			//得到商品数
			$goods_count = $page->getTotalNum();
			Tpl::output('goods_count',$goods_count);
		}
		Tpl::output('goods_list',$goods_list);

        /**
		 * 取浏览过产品的cookie(最大四组)
		 */
		$viewed_goods = array();
		$cookie_i = 0;
		if(cookie('viewed_goods')){
			$string_viewed_goods = cookie('viewed_goods');
			if (get_magic_quotes_gpc()) $string_viewed_goods = stripslashes($string_viewed_goods);//去除斜杠
			$cookie_array = array_reverse(unserialize($string_viewed_goods));
			$goods_id_in	= '';
			foreach ($cookie_array as $k=>$v){
				$info = explode("-", $v);
				$goods_id_in .= $info[0].',';
				                	
			}
			$goods_id_in	= rtrim($goods_id_in,',');
			$viewed_list		= $model_goods->getGoods(array('goods_id_in'=>$goods_id_in),'','goods_id, goods_name, goods_store_price, goods_image, store_id','goods');
			if(!empty($viewed_list) && is_array($viewed_list)){
				foreach ($viewed_list as $val){
					$viewed_goods[] = array(
					 "goods_id"          => $val['goods_id'],
					 "goods_name"        => $val['goods_name'],
					 "goods_image"       => $val['goods_image'],
					 "goods_store_price" => $val['goods_store_price'],
				 	 "store_id"        => $val['store_id']
					);
				}
			}
		}
		
		/**
		 * 地区
		 */
		$area_url = BasePath.DS.'data'.DS.'area'.DS.'area.php';
		if (file_exists($area_url)){
			include_once($area_url);
		}
		if (strtoupper(CHARSET) == 'GBK'){
			$area_array = Language::getGBK($area_array);
		}
		Tpl::output('area_array',$area_array);
		
		/**
		 * 分类导航
		 */
		$nav_link = array(
			0=>array(
				'title'=>$lang['homepage'],
				'link'=>'index.php'
			),
			1=>array(
				'title'=>$lang['brand_index_all_brand'],
				'link'=>'index.php?act=brand'
			),
			2=>array(
				'title'=>$brand_lise['brand_name']
			)
		);
		Tpl::output('nav_link_list',$nav_link);
		/**
		 * 页面输出
		 */
		Tpl::output('display_mode',$display_mode);
		Tpl::output('viewed_goods',$viewed_goods);
//		Tpl::output('html_title',$lang['nc_brand'].'-'.$brand_lise['brand_name']);
		Tpl::output('index_sign','brand');

		Model('seo')->type('brand_list')->param(array('name'=>$brand_lise['brand_name']))->show();
		Tpl::showpage('brand_goods');
	}
}
