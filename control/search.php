<?php
/**
 * 前台商品分类
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class searchControl extends BaseHomeControl {
	/**
	 * 商品分类列表
	 */
	public function indexOp(){
		Language::read('home_goods_class_index');
		$lang	= Language::getLangContent();

		//分页
		$page	= new Page();
		$page->setEachNum(40);
		$page->setStyle('admin');		

		$model_goods_class	= Model('goods_class');
		$keyword = trim($_GET['keyword']);
		if($keyword != ''){				
			if(C('fullindexer.open')){
				$data['goods_id_str'] = $this->full_search($keyword);
				$search_key = '';
			}else{
				$search_key = $keyword;
			}
			//显示左侧商品分类，存入goods_class_array下标
			$data['goods_class_array'] = $this->left_category($keyword);
		}elseif(is_numeric($_GET['cate_id'])){
			$data = $this->get_goods_info_by_attr();
		}else{
			//无关键词时，显示一级商品分类
			if(!($category = F('goods_class'))) $category = H('goods_class',true,'file');
			if (is_array($category) && !empty($category)){
				foreach ($category as $v) {
					if ($v['gc_parent_id'] != '0') break;
					$data['goods_class_array']['child'][] = array('gc_id'=>$v['gc_id'],'gc_name'=>$v['gc_name']);
				}
			}
		}

		//得到查询价格
		if (!empty($_GET['price'])){
			$price = explode('-',$_GET['price']);
			if (intval($price[0]) > 0 || intval($price[1]) > 0){
				$price_interval[0] = empty($price[0]) ? 0 : $price[0];
				$price_interval[1] = empty($price[1]) ? 0 : $price[1];
			}
			Tpl::output('price_interval',$price_interval);
		}

		//得到排序方式
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
		$ext_order = C('promotion_allow') ? ' xianshi_flag desc,goods_starttime desc' : ' goods_starttime desc'; 
		$order = $order ? $order.', goods_starttime desc': $ext_order;
		//成色筛选
		if(isset($_GET['form'])){
			switch (intval($_GET['form'])){
				case 1:
					$form		= $lang['goods_class_form_new'];
					$goods_form	= 1;
					break;
				case 2:
					$form		= $lang['goods_class_form_used'];
					$goods_form	= 2;
					break;
			}
			Tpl::output('form',$form);
		}

		//筛选类型
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
					$promotion = $lang['goods_class_index_groupbuy'];
                    $group_flag = 1;
					break;
			}
		}
		Tpl::output('promotion',$promotion);

		$model_goods = Model('goods');

		// 直通车
		if (C('gold_isuse') && C('ztc_isuse')){
			$fieldstr = " goods.goods_id,goods.goods_name,goods.gc_id,goods.gc_name,goods.store_id,goods.goods_image,goods.goods_store_price,
						goods.goods_click,goods.goods_state,goods.goods_commend,goods.commentnum,goods.salenum,goods.goods_goldnum,goods.goods_isztc,
						goods.goods_ztcstartdate,goods.goods_ztclastdate";
			$ztc_list = $model_goods->getGoods(array(
				'gc_id_in'=>$data['gc_id_str'],
				'goods_show'=>'1',
				'goods_isztc'=>'1',
				'goods_ztcopen'=>'1',
				'limit'=>'6',
				'order'=>rand(1,5),
			),'',$fieldstr,'goods');
			Tpl::output('ztc_list',$ztc_list);
		}
		//商品列表
		$fieldstr = " goods.goods_id,goods.goods_name,goods.gc_id,goods.gc_name,goods.store_id,goods.goods_image,goods.goods_store_price,
		goods.goods_click,goods.goods_state,goods.goods_commend,goods.commentnum,goods.salenum,goods.goods_goldnum,goods.goods_isztc,
		goods.goods_ztcstartdate,goods.goods_ztclastdate,goods.group_flag,goods.group_price,goods.xianshi_flag,goods.xianshi_discount,
		goods.city_id,goods.province_id,goods.kd_price,goods.py_price,goods.es_price,
		store.store_name,store.grade_id,store.store_domain,store.store_credit,store.praise_rate,store.store_desccredit";
		$goods_list = $model_goods->getGoods(array(
				'goods_id_in'=>$data['goods_id_str'],
				'price'=>$price_interval,
				'group_flag'=>$group_flag,
				'xianshi_flag'=>$xianshi_flag,
				'keyword'=>$search_key,
				'province_id'=>(is_numeric($_GET['area_id']) && $_GET['area_id'] > 0) ? $_GET['area_id'] : '',
				'goods_show'=>'1',
				'goods_form'=>$goods_form,
				'order'=>$order,
		),$page,$fieldstr,'store',$extend);
		Tpl::output('goods_list',$goods_list);
		Tpl::output('show_page',$page->show());

		if (is_array($goods_list)){
			//得到商品数
			$goods_count = $page->getTotalNum();
			Tpl::output('goods_count',$goods_count);
		}

		Tpl::output('goods_class_array',$data['goods_class_array']);

		//地区
		$area_url = BasePath.DS.'data'.DS.'area'.DS.'area.php';
		if (file_exists($area_url)){
			include_once($area_url);
		}
		if (strtoupper(CHARSET) == 'GBK'){
			$area_array = Language::getGBK($area_array);
		}
		Tpl::output('area_array',$area_array);

		//展示形式，默认以方格展示
		Tpl::output('display_mode',$_COOKIE['goodsDisplayMode'] ? $_COOKIE['goodsDisplayMode'] : 'squares'); 

		//SEO
		$seo_class_name = @$data['goods_class_array']['gc_name'];
		if (is_numeric($_GET['cate_id'])){
			$seo_info = $model_goods_class->getKeyWords(intval($_GET['cate_id']));
			if (empty($seo_info[1])) $seo_info[1] = C('site_name').' - '.$seo_class_name;
			Model('seo')->type($seo_info)->param(array('name'=>$seo_class_name))->show();			
		}elseif(is_scalar($_GET['keyword'])){
			Tpl::output('html_title',(empty($_GET['keyword']) ? '' : $_GET['keyword'].' - ').C('site_name').$lang['nc_common_search']);
		}

		//当前位置导航
		$nav_link_list = $model_goods_class->getGoodsClassNav(intval($_GET['cate_id']));
		Tpl::output('nav_link_list',$nav_link_list);		

		//得到自定义导航信息
		$nav_id = intval($_GET['nav_id']) ? intval($_GET['nav_id']) : 0 ;
		Tpl::output('index_sign',$nav_id);	

		$this->viewed_goods();	

		Tpl::showpage('search');
	}

	/**
	 * 商品多图ajax显示
	 */
	function ajax_goods_more_imageOp(){
		$goods_id		= intval($_GET['goods_id']);
		$goods_model	= Model('goods');
		$goods_info		= $goods_model->getOne($goods_id,'goods_image_more,store_id');
		$goods_image_more	= explode(',', $goods_info['goods_image_more']);
		if(!empty($goods_image_more) && is_array($goods_image_more)){
			$goods_image	= array();
			foreach ($goods_image_more as $val){
				if ($val != '') {
					$goods_image[]	= array('tiny'=>cthumb($val,'tiny',$goods_info['store_id']),'small'=>cthumb($val,'small',$goods_info['store_id']));
				}
			}
			if(!empty($goods_image)){
				echo json_encode($goods_image);
			}else{
				echo json_encode(false);
			}
		}else{
			echo json_encode(false);
		}
	}

	/**
	 * 显示左侧商品分类
	 *
	 */
	private function left_category($keyword = ''){
		if ($keyword != ''){
			//跟据class_tag缓存搜索出与keyword相关的分类
			$tag_list = ($tag = F('class_tag')) ? $tag : H('class_tag',true,'file');
			if(!empty($tag_list) && is_array($tag_list)){
				foreach ($tag_list as $key=>$val){
					$tag_value_array = explode(',', $val['gc_tag_value']);
					if(in_array($keyword, $tag_value_array)){
						$data['gc_name'] = $lang['goods_class_index_search_class'];
						$data['child'][$key]['gc_id'] = $val['gc_id'];
						$tag_name_array = explode('&nbsp;&gt;&nbsp;', $val['gc_tag_name']);
						$data['child'][$key]['gc_name'] = array_pop($tag_name_array);
					}
				}
			}
		}
//		else{
//			//无关键词时，显示一级商品分类
//			if(!($category = F('goods_class'))) $category = H('goods_class',true,'file');
//			if (is_array($category) && !empty($category)){
//				foreach ($category as $v) {
//					if ($v['gc_parent_id'] != '0') break;
//					$data['child'][] = array('gc_id'=>$v['gc_id'],'gc_name'=>$v['gc_name']);
//				}
//			}
//		}
		return $data;		
	}

	/**
	 * 浏览过的商品
	 *
	 */
	private function viewed_goods(){
        //取浏览过产品的cookie(最大四组)
		$viewed_goods = array();
		$cookie_i = 0;

		if(cookie('viewed_goods')){
			$string_viewed_goods = cookie('viewed_goods');
			if (get_magic_quotes_gpc()) $string_viewed_goods = stripslashes($string_viewed_goods);//去除斜杠
			$cookie_array = array_reverse(unserialize($string_viewed_goods));
			$goods_id_in	= '';
			foreach ((array)$cookie_array as $k=>$v){
				$info = explode("-", $v);
				$goods_id_in .= $info[0].',';
			}
			$goods_id_in	= rtrim($goods_id_in,',');
			$model_goods	= Model('goods');
			$viewed_list		= $model_goods->getGoods(array('goods_id_in'=>$goods_id_in),'','goods_id, goods_name, goods_store_price, goods_image, store_id','goods');
			foreach ((array)$viewed_list as $val){
				$viewed_goods[] = array(
				 "goods_id"          => $val['goods_id'],
				 "goods_name"        => $val['goods_name'],
				 "goods_image"       => $val['goods_image'],
				 "goods_store_price" => $val['goods_store_price'],
				 "store_id"        => $val['store_id']
				);
			}
		}
		Tpl::output('viewed_goods',$viewed_goods);		
	}

	/**
	 * 标识被选中的属性
	 *
	 */
	private function sign_checked(&$param,&$data){
		//被选中的规格
		if(is_array($param['spec_id']) && is_array($data['spec_array']) && !empty($data['spec_array'])){
			$checked_spec = array();
			foreach ($param['spec_id'] as $s){
				foreach ($data['spec_array'] as $k=>$d){
					if(isset($d['value'][$s])){
						$checked_spec[$k]['spec_name']		= $d['name'];
						$checked_spec[$k]['spec_value_id']	= $s;
						$checked_spec[$k]['spec_value_name']= $d['value'][$s]['name'];
					}
				}
			}
			Tpl::output('checked_spec', $checked_spec);
		}
		
		//被选中的品牌
		if(is_array($param['brand_id']) && is_array($data['brand_array']) && !empty($data['brand_array'])){
			$checked_brand = array();
			foreach ($param['brand_id'] as $s){
					if(isset($data['brand_array'][$s])){
						$checked_brand[$s]['brand_name']	= $data['brand_array'][$s]['name'];
					}
			}
			Tpl::output('checked_brand', $checked_brand);
		}

		//被选中的属性
		if(is_array($param['attr_id']) && is_array($data['attr_array']) && !empty($data['attr_array'])){
			$checked_attr = array();
			foreach ($param['attr_id'] as $s){
				foreach ($data['attr_array'] as $k=>$d){
					if(isset($d['value'][$s])){
						$checked_attr[$k]['attr_name']		= $d['name'];
						$checked_attr[$k]['attr_value_id']	= $s;
						$checked_attr[$k]['attr_value_name']= $d['value'][$s]['name'];
					}
				}
			}
			Tpl::output('checked_attr', $checked_attr);
		}		
	}

	/**
	 * 全文搜索
	 *
	 */
	private function full_search($search_txt){
		$conf = C('fullindexer');
		import('libraries.sphinx');
		$cl = new SphinxClient();
		$cl->SetServer($conf['host'], $conf['port']);
		$cl->SetConnectTimeout(1);
		$cl->SetArrayResult(true);
		$cl->SetRankingMode($conf['rankingmode']?$conf['rankingmode']:0);
		$cl->setLimits(0,$conf['querylimit']);

		$matchmode = $conf['matchmode'];
		$cl->setMatchMode($matchmode);
		$res = $cl->Query($search_txt, $conf['index_product']);
		if ($res){
			if (is_array($res['matches'])){
				foreach ($res['matches'] as $value) {
					$matchs_id[] = $value['id'];
				}
			}
		}

		return is_array($matchs_id) ? implode(',',$matchs_id) : '';
	}	

	/**
	 * 生成商品分类详细缓存
	 * 文件格式  分类id@规格id_规格id@品牌id_品牌id@属性id_属性id
	 *
	 * @param array $param 需要的参数内容
	 * @return array 数组类型的返回结果
	 */
	private function get_goods_info_by_attr(){
		//得到分类ID
		$cate_id = intval($_GET['cate_id']) ? intval($_GET['cate_id']) : 0 ;
		//得到规格id
		$spec_id = $_GET['s_id'];
		//得到品牌id
		$brand_id = $_GET['b_id'];
		//得到属性id
		$attr_id = $_GET['a_id'];
		//得到地区id
		if(intval($_GET['area_id']) > 0){
			$area_id = intval($_GET['area_id']);
		}


		//由规格型号组合取得商品ID
		$param = array();

		$param['gc_id']		= $cate_id;
		if($spec_id != ''){
			$param['spec_id']	= explode(',', $spec_id);
		}
		if($brand_id != ''){
			$param['brand_id']	= explode(',', $brand_id);
		}
		if($attr_id != ''){
			$param['attr_id']	= explode(',', $attr_id);
		}
		if($area_id > 0){
			$param['area_id']	= $area_id;
		}
		
		//生成缓存的键值
		$hash_key	= md5($cate_id.'_'.$spec_id.'_'.$brand_id.'_'.$attr_id);

		//先查找$hash_key缓存
		if ($_cache = rcache($hash_key,'search_p')) {
        	//抛出搜索属性
			Tpl::output('spec_array',$_cache['spec_array']);
			Tpl::output('brand_array',$_cache['brand_array']);
			Tpl::output('attr_array',$_cache['attr_array']);

        	//标识被选中的规格,品牌,属性
			$this->sign_checked($param,$_cache);			
			return $_cache;		
		}

		$model_goods_class	= Model('goods_class');
		$model_type			= Model('type');
        $model_goods	= Model('goods');

        // 初始化统计数据为0
        $count = 0;

        // 获取当前的分类内容
        $class_array = ($g = F('goods_class')) ? $g : H('goods_class',true,'file');
        $data = $class_array[$param['gc_id']];
        if( !empty($data) ) {
            /**
             * 获取当先分类的所有下级分类id包含当前分类
             */
            $show_goods_class = array();
            $show_goods_class['gc_id']	= $data['gc_id'];
            $show_goods_class['gc_name']= $data['gc_name'];
            if($data['child'] != ''){
            	$class_child_array = explode(',', $data['child']);
            	foreach($class_child_array as $k=>$v){
            		$show_goods_class['child'][$k]['gc_id']		= $class_array[$v]['gc_id'];
            		$show_goods_class['child'][$k]['gc_name']	= $class_array[$v]['gc_name'];
            	}
            }
            $data['goods_class_array'] = $show_goods_class;
            
            /**
             * 获取商品总数
             */
            $gc_id_str = rtrim($data['gc_id'].','.$data['child'].','.$data['childchild'],',');
            $data['gc_id_str']	= $gc_id_str;
        	$count = $model_goods_class->getGoodsCountById($gc_id_str);
       		$data['count']			= $count;            	
            /**
             * 获得商品id
             */
            $model_goods	= Model('goods');
            $need_param	= array();
        	$need_param['gc_id_in']			= $gc_id_str;
            $need_param['goods_show']		= '1';
            if(intval($param['area_id']) > 0){
            	$need_param['province_id']	= $param['area_id'];
            }
            $goods_list		= $model_goods->getGoodsForCache($need_param, 'goods_id');
            $goods_id_array	= array();
            if(is_array($goods_list) && !empty($goods_list)){
            	foreach ($goods_list as $val){
            		$goods_id_array[] = $val['goods_id'];
            	}
            }
            if($goods_id_array != ''){
            	$goods_id_str = implode(',', $goods_id_array);
            }else{
            	$goods_id_str = '';
            }

        	if($data['type_id'] != '0'){
        		
        		if(!empty($goods_id_array) && is_array($goods_id_array)){
            		/**
            		 * 如果检索(spec,brand,attr)存在添加查出该条件下的商品id;
            		 */
            		$goods_id_where_array	= array();
            		$g_sign = 'true';
            		if(isset($param['spec_id']) && !empty($param['spec_id'])){
            			foreach($param['spec_id'] as $v){
            				$related_param	= array();
            				$related_param['in_gc_id']			= $gc_id_str;
            				$related_param['sp_value_id']	= $v;
            				if($g_sign == 'false' && !empty($goods_id_where_array['param'])){
            					$related_param['in_goods_id']	= implode(',', $goods_id_where_array['param']);
            				}
            				// 没有查找到商品的情况下跳过搜索。
            				if($g_sign == 'true' || !empty($goods_id_where_array['param'])){
		            			$goods_list = $model_type->typeRelatedList('goods_spec_index', $related_param, 'goods_id');
		            			if(is_array($goods_list) && !empty($goods_list)){
		            				foreach ($goods_list as $val){
		            					if(!in_array($val['goods_id'], $goods_id_where_array) && in_array($val['goods_id'], $goods_id_array)){
		            						$goods_id_where_array['spec'][] = $val['goods_id'];
		            					}
		            				}
		            			}
            				}
            				// 商品id取差集
	            			if($g_sign == 'true'){
	            				$g_sign	= 'false';
	            				$goods_id_where_array['param']	= $goods_id_where_array['spec'];
	            			}else if(isset($goods_id_where_array['param'])){
	            				$goods_id_where_array['param']	= array_intersect($goods_id_where_array['param'], (array)$goods_id_where_array['spec']);
	            			}
	            			unset($goods_id_where_array['spec']);
            			}
            		}
            		if(isset($param['brand_id']) && !empty($param['brand_id'])){
            			foreach($param['brand_id'] as $v){
            				$related_param	= array();
            				$related_param['in_gc_id']			= $gc_id_str;
            				$related_param['brand_id']	= $v;
            				if($g_sign == 'false' && !empty($goods_id_where_array['param'])){
            					$related_param['in_goods_id']	= implode(',', $goods_id_where_array['param']);
            				}
            				// 没有查找到商品的情况下跳过搜索。
            				if($g_sign == 'true' || !empty($goods_id_where_array['param'])){
		            			$goods_list = $model_type->typeRelatedList('goods', $related_param, 'goods_id');
		            			if(is_array($goods_list) && !empty($goods_list)){
		            				foreach ($goods_list as $val){
		            					if(!in_array($val['goods_id'], $goods_id_where_array) && in_array($val['goods_id'], $goods_id_array)){
		            						$goods_id_where_array['brand'][] = $val['goods_id'];
		            					}
		            				}
		            			}
            				}
            				// 商品id取差集
	            			if($g_sign == 'true'){
	            				$g_sign	= 'false';
	            				$goods_id_where_array['param']	= $goods_id_where_array['brand'];
	            			}else if(isset($goods_id_where_array['param'])){
	            				$goods_id_where_array['param']	= array_intersect($goods_id_where_array['param'], (array)$goods_id_where_array['brand']);
	            			}
	            			unset($goods_id_where_array['brand']);
            			}
            		}
            		if(isset($param['attr_id']) && !empty($param['attr_id'])){
            			foreach($param['attr_id'] as $v){
            				$related_param	= array();
            				$related_param['in_gc_id']			= $gc_id_str;
            				$related_param['attr_value_id']	= $v;
            				if($g_sign == 'false' && !empty($goods_id_where_array['param'])){
            					$related_param['in_goods_id']	= implode(',', $goods_id_where_array['param']);
            				}
            				// 没有查找到商品的情况下跳过搜索。
            				if($g_sign == 'true' || !empty($goods_id_where_array['param'])){
		            			$goods_list = $model_type->typeRelatedList('goods_attr_index', $related_param, 'goods_id');
		            			if(is_array($goods_list) && !empty($goods_list)){
		            				foreach ($goods_list as $val){
		            					if(!in_array($val['goods_id'], $goods_id_where_array) && in_array($val['goods_id'], $goods_id_array)){
		            						$goods_id_where_array['attr'][] = $val['goods_id'];
		            					}
		            				}
		            			}
            				}
            				// 商品id取差集
	            			if($g_sign == 'true'){
	            				$g_sign	= 'false';
	            				$goods_id_where_array['param']	= $goods_id_where_array['attr'];
	            			}else if(isset($goods_id_where_array['param'])){
	            				$goods_id_where_array['param']	= array_intersect($goods_id_where_array['param'], (array)$goods_id_where_array['attr']);
	            			}
	            			unset($goods_id_where_array['attr']);
            			}
            		}
        		}
        		/**
        		 * 创造商品数量($spec_count,$brand_count,$attr_count)检索条件
        		 */
        		$related_param	= array();
        		$related_param['in_gc_id']			= $gc_id_str;
        		if($g_sign == 'false' && !empty($goods_id_where_array['param'])){
   		     		$related_param['in_goods_id']	= implode(',', $goods_id_where_array['param']);
        		}
        		$goods_sign = 'true';
            	/**
	        	 * 规格
    	    	 */
        		// 各规格值的商品数量
      		  	if($g_sign == 'false' && empty($goods_id_where_array['param'])){
      		  		$spec_count_array	= array();
      		  	}else{	// 没有查找到商品的情况下跳过搜索。
           	  		$spec_count	= $model_type->typeRelatedGroupList($related_param, 'spec');
            	 	$spec_count_array = array();
           	 		if(is_array($spec_count) && !empty($spec_count)){
            			foreach ($spec_count as $val){
            				if(!empty($goods_id_array) && is_array($goods_id_array) && in_array($val['goods_id'], $goods_id_array)){
            					$spec_count_array[$val['sp_value_id']][]	= $val['goods_id'];
            				}
            			}
          		  	}
      		  	}
        		unset($spec_count);

        		// 规格列表
        		$spec_list	= $model_type->typeRelatedJoinListForCache(array('goods_class.type_id'=>$data['type_id'], 'in_gc_id'=>$gc_id_str), 'spec','spec.sp_id, spec.sp_name, spec.sp_format, spec_value.sp_value_id, spec_value.sp_value_name, spec_value.sp_value_image');
        		$spec_array	= array();
        		if(is_array($spec_list) && !empty($spec_list)){
       	 			foreach ($spec_list as $val){
        				$spec_array[$val['sp_id']]['name']									= $val['sp_name'];
        				$spec_array[$val['sp_id']]['value'][$val['sp_value_id']]['name']	= $val['sp_value_name'];
        				if($val['sp_format'] == 'image'){
       		 				$spec_array[$val['sp_id']]['value'][$val['sp_value_id']]['image']	= $val['sp_value_image'];
        				}
        				// 计算商品数量
        				if(isset($spec_count_array[$val['sp_value_id']])){
        					$spec_array[$val['sp_id']]['value'][$val['sp_value_id']]['count']	= count($spec_count_array[$val['sp_value_id']]);
        					// 存在规格条件
        					if(isset($param['spec_id']) && in_array( $val['sp_value_id'], $param['spec_id'])){
        						if($goods_sign == 'true'){
        							$goods_sign = 'false';
      		  						$goods_id_exact_array	= array();
        							$goods_id_exact_array	= $spec_count_array[$val['sp_value_id']];
        						}else{
        							$goods_id_exact_array	= array_intersect($goods_id_exact_array, (array)$spec_count_array[$val['sp_value_id']]);
        						}
        					}
        				}else{
        					$spec_array[$val['sp_id']]['value'][$val['sp_value_id']]['count']	= '0';
        					if(isset($param['spec_id']) && in_array( $val['sp_value_id'], $param['spec_id'])){
        						$goods_sign = 'false';
        						$goods_id_exact_array	= array();
        					}
        				}
            		}
	        	}
    	    	unset($spec_list);
        		unset($spec_count_array);
        		$data['spec_array']	= $spec_array;
            	unset($spec_array);
	        	
    	    	/**
        		 * 品牌
        		 */ 	
            	// 各品牌的商品数量
            	if($g_sign == 'false' && empty($goods_id_where_array['param'])){
            		$brand_count_array	= array();
            	}else{	// 没有查找到商品的情况下跳过搜索。
	            	$brand_count	= $model_type->typeRelatedGroupList($related_param, 'brand');
    	        	$brand_count_array = array();
        	    	if(is_array($brand_count) && !empty($brand_count)){
            			foreach ($brand_count as $val){
            				if(!empty($goods_id_array) && is_array($goods_id_array) && in_array($val['goods_id'], $goods_id_array)){
            					$brand_count_array[$val['brand_id']][]	= $val['goods_id'];
            				}
            			}
	            	}
            	}
	        	unset($brand_count);
        		$brand_list	= $model_type->typeRelatedJoinListForCache(array('goods_class.type_id'=>$data['type_id'], 'brand_apply'=>'1', 'in_gc_id'=>$gc_id_str), 'brand','brand.brand_id, brand.brand_name, brand.brand_pic');
        		$brand_array = array();
            	if(is_array($brand_list) && !empty($brand_list)){
	        		foreach ($brand_list as $val){
    	    			$brand_array[$val['brand_id']]['name']	= $val['brand_name'];
        				$brand_array[$val['brand_id']]['image']	= $val['brand_pic'];
        				if(isset($brand_count_array[$val['brand_id']])){
        					$brand_array[$val['brand_id']]['count']	= count($brand_count_array[$val['brand_id']]);
        					// 存在属性条件条件
        					if(isset($param['brand_id']) && in_array( $val['brand_id'], $param['brand_id'])){
	        					if($goods_sign == 'true'){
	        						$goods_sign = 'false';
    	    						$goods_id_exact_array	= array();
        							$goods_id_exact_array	= $brand_count_array[$val['brand_id']];
        						}else{
        							$goods_id_exact_array	= array_intersect($goods_id_exact_array, (array)$brand_count_array[$val['brand_id']]);
        						}
    	    				}
        				}else{
        					$brand_array[$val['brand_id']]['count']	= '0';
        					if(isset($param['brand_id']) && in_array( $val['brand_id'], $param['brand_id'])){
        						$goods_sign = 'false';
        						$goods_id_exact_array	= array();
        					}
        				}
            		}
	        	}
    	    	unset($brand_list);
        		unset($brand_count_array);
        		$data['brand_array']	= $brand_array;
            	unset($brand_array);
	        	
    	    	/**
        		 * 属性
        		 */
            	// 各属性值的商品数量
            	if($g_sign == 'false' && empty($goods_id_where_array['param'])){
            		$attr_count_array	= array();
            	}else{	// 没有查找到商品的情况下跳过搜索。
	        	$attr_count	= $model_type->typeRelatedGroupList($related_param, 'attr');
    	    	$attr_count_array = array();
        		if(is_array($attr_count) && !empty($attr_count)){
        			foreach ($attr_count as $val){
            			if(!empty($goods_id_array) && is_array($goods_id_array) && in_array($val['goods_id'], $goods_id_array)){
        					$attr_count_array[$val['attr_value_id']][]	= $val['goods_id'];
            			}
            		}
	        	}
            	}
    	    	unset($attr_count);

        		// 属性列表
            	$attr_list	= $model_type->typeRelatedJoinListForCache(array('goods_class.type_id'=>$data['type_id'], 'attr_show'=>'1', 'in_gc_id'=>$gc_id_str), 'attr','attribute.attr_id, attribute.attr_name, attribute_value.attr_value_id, attribute_value.attr_value_name');
	        	$attr_array = array();
    	    	if(is_array($attr_list) && !empty($attr_list)){
        			foreach ($attr_list as $val){
        				$attr_array[$val['attr_id']]['name']										= $val['attr_name'];
        				$attr_array[$val['attr_id']]['value'][$val['attr_value_id']]['name']		= $val['attr_value_name'];
        				// 计算商品数量
            			if(isset($attr_count_array[$val['attr_value_id']])){
	        				$attr_array[$val['attr_id']]['value'][$val['attr_value_id']]['count']	= count($attr_count_array[$val['attr_value_id']]);
    	    				// 存在属性条件条件
	        				if(isset($param['attr_id']) && in_array( $val['attr_value_id'], $param['attr_id'])){
        						if($goods_sign == 'true'){
        							$goods_sign = 'false';
        							$goods_id_exact_array	= array();
        							$goods_id_exact_array	= $attr_count_array[$val['attr_value_id']];
        						}else{
        							$goods_id_exact_array	= array_intersect($goods_id_exact_array, (array)$attr_count_array[$val['attr_value_id']]);
            					}
        					}
        				}else{
        					$attr_array[$val['attr_id']]['value'][$val['attr_value_id']]['count']	= '0';
        					if(isset($param['attr_id']) && in_array( $val['attr_value_id'], $param['attr_id'])){
        						$goods_sign = 'false';
        						$goods_id_exact_array	= array();
        					}
            			}
	        		}
    	    	}
        	    unset($attr_list);
            	unset($attr_count_array);
	        	$data['attr_array']	= $attr_array;
    	    	unset($attr_array);
        	}

        	// 记录商品id
            if(isset($goods_id_exact_array)){
        		$data['goods_id_str'] = implode(",", array_unique($goods_id_exact_array));
        		unset($goods_id_exact_array);
        	}else{
        		$data['goods_id_str'] = $goods_id_str;
        		unset($goods_id_array);
        	}

        	//抛出搜索属性
			Tpl::output('spec_array',$data['spec_array']);
			Tpl::output('brand_array',$data['brand_array']);
			Tpl::output('attr_array',$data['attr_array']);

        	//标识被选中的规格,品牌,属性
			$this->sign_checked($param,$data);

			//缓存规格组合结果
			wcache($hash_key,$data,'search_p');

			return $data;
        }
        return false;
	}
}