<?php
/**
 * 会员店铺
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

class show_storeControl extends BaseStoreControl {
	public function __construct(){
		parent::__construct();
	}
	public function indexOp(){
		//读取语言包
		Language::read('store_show_store_index');
		//实例化模型
		$store_navigation_partner_class = Model('store_navigation_partner');
		$goods_class = Model('goods');
		//获得店铺ID		 
		$store_id = intval($_GET['id']);
		if ($store_id <= 0){
			showMessage(Language::get('show_store_index_store_not_exists'),'','html','error');
		}
		//检查店铺状态
		$store_info = $this->getStoreInfo($store_id);

		//得到友情链接信息
		$store_partner_list = $store_navigation_partner_class->getPartnerList(array('sp_store_id'=>$store_info['store_id']));
		Tpl::output('store_partner_list',$store_partner_list);
		//显示店铺动态评价
		//$this->show_storeeval($store_info['store_id']);
		//判断是否为导航页面
		if (!empty($_GET['article']) && intval(trim($_GET['article']))>0){
			$store_navigation_info = $store_navigation_partner_class->getOneNavigation(intval($_GET['article']));
			if (!empty($store_navigation_info) && is_array($store_navigation_info)){
				Tpl::output('store_navigation_info',$store_navigation_info);
				Tpl::output('page',$store_navigation_info['sn_id']);
				Tpl::showpage('article');
			}
		}
		//得到12个推荐商品列表
		$recommended_goods_list = $goods_class->getGoods(array(
			'store_id'=>$store_info['store_id'],
			'goods_show'=>1,
			'goods_commend'=>1,
			'order'=>'`goods`.goods_starttime desc',
			'limit'=>'0,12'
		),'','goods.*','goods',array('index'=>'store_id'));
		if (!empty($recommended_goods_list) && is_array($recommended_goods_list)){	
			foreach ($recommended_goods_list as $key=>$value){
				$recommended_goods_list[$key]['goods_price'] = ncPriceFormat($value['goods_price']);
			}
		}
		//得到最新12个商品列表
		$new_goods_list = $goods_class->getGoods(array(
			'store_id'=>$store_info['store_id'],
			'goods_show'=>1,
			'order'=>'`goods`.goods_starttime desc',
			'limit'=>'0,12'
		),'','goods.*','goods',array('index'=>'store_id'));
		if (!empty($new_goods_list) && is_array($new_goods_list)){
			foreach ($new_goods_list as $key=>$value){
				$new_goods_list[$key]['goods_price'] = ncPriceFormat($value['goods_price']);
			}
		}
		Tpl::output('new_goods_list',$new_goods_list);

		$theme_model = Model('store_theme');
		$state = $theme_model->getShowStyle($store_info['store_theme']);
		if ($state == 1){
			$condition = array();
			$condition['style_id'] = $store_info['store_theme'];
			$condition['store_id'] = $store_id;
			$theme_list = $theme_model->getList($condition);
			Tpl::output('theme',$theme_list[0]);
			$style_js = '';
			$style_configurl = BASE_TPL_PATH.DS.'store'.DS.'style'.DS.$store_info['store_theme'].DS."style_config.php";
			if (file_exists($style_configurl) && !empty($theme_list[0]["theme_info"])){
				include_once($style_configurl);
				Tpl::output('style_js',$style_js);
			}
		}

		//幻灯片图片
		if($store_info['store_slide'] != '' && $store_info['store_slide'] != ',,,,'){
			Tpl::output('store_slide', explode(',', $store_info['store_slide']));
			Tpl::output('store_slide_url', explode(',', $store_info['store_slide_url']));
		}
		Tpl::output('page','index');
		Tpl::output('recommended_goods_list',$recommended_goods_list);
		
		//得到店铺页面seo信息
		$seo_param = array();
		$seo_param['shopname'] = $store_info['store_name'];
		$seo_param['key']  = $store_info['store_keywords'];
		$seo_param['description'] = $store_info['store_description'];
		Model('seo')->type('shop')->param($seo_param)->show();
		Tpl::showpage('index');
	}
	public function creditOp(){
		//读取语言包
		Language::read('store_show_store_index');
		$id = intval($_GET['id']);
		if ($id <= 0){
			showMessage(Language::get('show_store_index_id_null'),'','html','error');
		}			
		//检查店铺状态
		$store_info = $this->getStoreInfo($id);

		//查询店铺动态评价
		$this->show_storeeval($id);
		//查询商品评分统计信息
		$evaluate_model = Model("evaluate");
		$goodsstat_list = $evaluate_model->goodsEvalStatList(array('statstoreid'=>"{$id}"));
		Tpl::output('goodsstat_list',$goodsstat_list);
		Tpl::output('page','credit');
		$seo_param = array();
		$seo_param['shopname'] = $store_info['store_name'];
		$seo_param['key']  = $store_info['store_keywords'];
		$seo_param['description'] = $store_info['store_description'];		
		Model('seo')->type('shop')->param($seo_param)->show();
		Tpl::output('html_title',$store_info['store_name'].' - '.Language::get('nc_credit'));
		Tpl::showpage('credit');
	}
	/**
	 * 商品评论
	 */
	public function commentsOp() {
		//读取语言包
		Language::read('store_show_store_index');
		$store_id = intval($_GET['id']);
		$result = true;//信息是否出现错误的结果，false将不继续执行代码
		if ($store_id <= 0){
			$result = false;
		}
		if ($result){
			//评价等级默认评语
			$evaluate_defaulttext = array('1'=>Language::get('nc_credit_defaultcontent_good'),'0'=>Language::get('nc_credit_defaultcontent_normal'),'-1'=>Language::get('nc_credit_defaultcontent_bad'));			
			$condition = array();
			//评价等级
			if($_GET['evalscore']){
				switch($_GET['evalscore']){
					case 1:
						$condition['geval_scores'] = '1';
						break;
					case 2:
						$condition['geval_scores'] = '0';
						break;
					case 3:
						$condition['geval_scores'] = '-1';
						break;
				}
			}
			//评价是否有内容
			$condition['geval_storeid'] = "{$store_id}";
			$condition['geval_type'] = "1";
			$condition['geval_showtime_lt'] = time();//全网显示
			//查询商品评分信息
			$page	= new Page();
			$page->setEachNum(10);
			$page->setStyle('admin');
			$evaluate_model = Model("evaluate");
			$goodsevallist = $evaluate_model->getGoodsEvalList($condition,$page,'*','member');
			if (!empty($goodsevallist)){
				foreach ($goodsevallist as $k=>$v){
					//处理评论内容的显示
					if ($v['geval_content'] == '' || $v['geval_state'] == '1'){
						$v['geval_content'] = $evaluate_defaulttext[$v['geval_scores']];
					}
					switch ($v['geval_scores']){
						case 1:
							$v['geval_scoressign'] = 'good';
							break;
						case 0:
							$v['geval_scoressign'] = 'normal';
							break;
						case -1:
							$v['geval_scoressign'] = 'bad';
							break;
					}
					//显示匿名
					$v['geval_frommembername'] = $v['geval_isanonymous'] == 1?Language::get('show_store_credit_anonymousbuyer_title').str_cut($v['geval_frommembername'],2).'***':Language::get('show_store_credit_buyer').Language::get('nc_colon').$v['geval_frommembername'];
					//买家信用
					$v['credit_arr'] = getCreditArr(intval($v['member_credit']));
					$goodsevallist[$k] = $v;
				}
			}
			Tpl::output('goodsevallist',$goodsevallist);
			Tpl::output('show_page',$page->show());
		}
		Tpl::showpage('credit_comments','null_layout');
	}
	public function store_infoOp(){
		/**
		 * 读取语言包
		 */
		Language::read('store_show_store_index');
		/**
		 * 得到店铺ID
		 */
		$id = empty($_GET['id']) ? 0 : intval($_GET['id']);

		/**
		 * 获取店铺详细信息 
		 */
		$store_info = $this->getStoreInfo($id);

		/*
		 * 显示店铺动态评价
		 */
		//$this->show_storeeval($store_info['store_id']);
		/**
		 * 查询会员信息
		 */
		$member_model	= Model('member');
		$member_info	= $member_model->infoMember(array('member_id'=>$store_info['member_id']),'member_time,member_old_login_time,member_email,member_credit');
		$member_info['credit_arr'] = getCreditArr($member_info['member_credit']);
		Tpl::output('member_info', $member_info);
		Tpl::output('page','map');
		Tpl::output('html_title',$store_info['store_name'].' - '.Language::get('nc_store_info'));
		Tpl::showpage('store_info');
	}
	
	/**
	 * 全部商品
	 */
	public function goods_allOp(){
		/**
		 * 读取语言包
		 */
		Language::read('store_show_store_index');
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$store_navigation_partner_class = Model('store_navigation_partner');
		$goods_class = Model('goods');
		/**
		 * 获得店铺ID
		 */
		$store_id = intval($_GET['id']);
		if ($store_id == 0){
			showMessage($lang['show_store_index_store_not_exists'],'','html','error');
		}

        //获取店铺详细信息
		$store_info = $this->getStoreInfo($store_id);

		/**
		 * 得到店铺页面seo信息
		 */
		$seo_keywords    = $store_info['store_keywords'];
		$seo_description = $store_info['store_description'];
		Tpl::output('seo_keywords',$seo_keywords);
		Tpl::output('seo_description',$seo_description);
		/**
		 * 得到友情链接信息
		 */
		$store_partner_list = $store_navigation_partner_class->getPartnerList(array('sp_store_id'=>$store_info['store_id']));
		Tpl::output('store_partner_list',$store_partner_list);
		/**
		 * 分页信息
		 */
		$page	= new Page();
		$page->setEachNum(24);
		$page->setStyle('admin');
		$conditionArr = array();
		$conditionArr['store_id']		= $store_info['store_id'];
		$conditionArr['goods_state']	= 0;
		$conditionArr['goods_show']		= 1;
		$conditionArr['keyword']		= trim($_GET['keyword']);
		$conditionArr['start_price']	= floatval($_GET['start_price']);
		$conditionArr['end_price']		= floatval($_GET['end_price']);
		if(trim($_GET['order'] != 'asc'))	$_GET['order']	= 'desc';
		// 排序
		switch (trim($_GET['key'])){
			case 'price':
				$conditionArr['order'] = 'goods.goods_store_price '.$_GET['order'];
				break;
			case 'sale':
				$conditionArr['order'] = 'goods.salenum '.$_GET['order'];
				break;
			case 'click':
				$conditionArr['order'] = 'goods.goods_click '.$_GET['order'];
				break;
			case 'collect':
				$conditionArr['order'] = 'goods.goods_collect '.$_GET['order'];
				break;
			case 'new':
				$conditionArr['order'] = 'goods.goods_starttime '.$_GET['order'];
				break;
			default:
				$conditionArr['order'] = 'goods.goods_starttime desc';
				break;
		}
		//查询分类下的子分类
		if ($_GET['stc_id']){
			$model_store_class = Model('my_goods_class');
			$stc_id_arr = $model_store_class->getChildAndSelfClass(intval($_GET['stc_id']),'1');
			if (is_array($stc_id_arr) && count($stc_id_arr)>0){
				$conditionArr['stc_id_in'] = implode(',',$stc_id_arr);
			}else{
				$conditionArr['stc_id'] = $stc_id_arr;
			}
			$recommended_goods_list = $goods_class->getGoods($conditionArr,$page,'goods.*','stc');
		}else {
			$recommended_goods_list = $goods_class->getGoods($conditionArr,$page,'goods.*','goods');
		}
		if (!empty($recommended_goods_list) && is_array($recommended_goods_list)){
			foreach ($recommended_goods_list as $key=>$value){
				/**
				 * 格式化价格显示
				 */
				$recommended_goods_list[$key]['goods_price'] = ncPriceFormat($value['goods_price']);
				/**
				 * 图片链接
				 */
			}
		}
		//查询店铺动态评价
		$this->show_storeeval($store_id);
		//输出分页
		Tpl::output('show_page',$page->show());
		$stc_class = Model('store_goods_class');
		$stc_info = $stc_class->getOneById(intval($_GET['stc_id']));
		Tpl::output('stc_name',$stc_info['stc_name']);
		Tpl::output('page','index');
		Tpl::output('recommended_goods_list',$recommended_goods_list);
		Tpl::showpage('goods_list');
	}
	/**
	 * ajax 店铺流量统计入库
	 */
	public function ajax_flowstat_recordOp(){
		if($_GET['id'] != '' && $_SESSION['store_id'] != $_GET['id']){
			//确定统计分表名称
			$flow_tableid = 0;
			$len = strlen(strval(intval($_GET['id'])));
			$last_num = substr(strval(intval($_GET['id'])), $len-1,1);
			switch ($last_num){
				case 1:
					$flow_tableid = 1;
					break;
				case 2:
					$flow_tableid = 1;
					break;
				case 3:
					$flow_tableid = 2;
					break;
				case 4:
					$flow_tableid = 2;
					break;
				case 5:
					$flow_tableid = 3;
					break;
				case 6:
					$flow_tableid = 3;
					break;
				case 7:
					$flow_tableid = 4;
					break;
				case 8:
					$flow_tableid = 4;
					break;
				case 9:
					$flow_tableid = 5;
					break;
				case 0:
					$flow_tableid = 5;
					break;
			}
			$flow_tablename = 'flowstat_'.$flow_tableid; 
			//判断是否存在当日数据信息
			$date = date('Ymd',time());
			$model = Model();
			$stat_model = Model('statistics');
			if($_GET['act_param'] == 'show_store' && ($_GET['op_param'] == 'index' || $_GET['op_param'] == 'credit' || $_GET['op_param'] == 'store_info')){
				$flow_date_array = $model->table($flow_tablename)->where(array('date'=>$date,'store_id'=>intval($_GET['id'])))->find();
			}else if($_GET['act_param'] == 'goods' && $_GET['op_param'] == 'index'){
				$flow_date_array = $model->table($flow_tablename)->where(array('date'=>$date,'goods_id'=>intval($_GET['goods_id'])))->find();
				$flow_date_array_sub = $model->table($flow_tablename)->where(array('date'=>$date,'store_id'=>intval($_GET['id'])))->find();
			}
			//向数据库写入访问量数据
			$update_param = array();
			$update_param['table'] = $flow_tablename;
			$update_param['field'] = 'clicknum';
			$update_param['value'] = 1;
			if(is_array($flow_date_array) && !empty($flow_date_array)){//已经存在数据则更新
				if($_GET['act_param'] == 'show_store' && ($_GET['op_param'] == 'index' || $_GET['op_param'] == 'credit' || $_GET['op_param'] == 'store_info')){
					$update_param['where'] = "WHERE date = '".$date."' AND store_id = '".intval($_GET['id'])."' AND goods_id = '0'";
					$stat_model->updatestat($update_param);
				}else if($_GET['act_param'] == 'goods' && $_GET['op_param'] == 'index'){
					$update_param['where'] = "WHERE date = '".$date."' AND goods_id = '".intval($_GET['goods_id'])."'";
					$stat_model->updatestat($update_param);
					$update_param['where'] = "WHERE date = '".$date."' AND store_id = '".intval($_GET['id'])."' AND goods_id = '0'";
					$stat_model->updatestat($update_param);
				}
			}else{//未存在数据则插入一行访问量数据
				if($_GET['act_param'] == 'show_store' && ($_GET['op_param'] == 'index' || $_GET['op_param'] == 'credit' || $_GET['op_param'] == 'store_info')){
					$model->table($flow_tablename)->insert(array('date'=>$date,'clicknum'=>1,'store_id'=>intval($_GET['id']),'type'=>'sum','goods_id'=>0));
				}else if($_GET['act_param'] == 'goods' && $_GET['op_param'] == 'index'){
					if(is_array($flow_date_array_sub) && !empty($flow_date_array_sub)){//已经有店铺数据则只插入一行并更新店铺访问数据
						$model->table($flow_tablename)->insert(array('date'=>$date,'clicknum'=>1,'store_id'=>intval($_GET['id']),'type'=>'goods','goods_id'=>intval($_GET['goods_id'])));
						$update_param['where'] = "WHERE date = '".$date."' AND store_id = '".intval($_GET['id'])."' AND goods_id = '0'";
						$stat_model->updatestat($update_param);
					}else{//没有店铺访问数据的则建立两行访问数据
						$model->table($flow_tablename)->insert(array('date'=>$date,'clicknum'=>1,'store_id'=>intval($_GET['id']),'type'=>'sum','goods_id'=>0));
						$model->table($flow_tablename)->insert(array('date'=>$date,'clicknum'=>1,'store_id'=>intval($_GET['id']),'type'=>'goods','goods_id'=>intval($_GET['goods_id'])));
					}
				}
			}
		}
		echo json_encode(array('done'=>true,'msg'=>'done'));
	}
}
?>
