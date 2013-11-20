<?php
/**
 * 默认展示页面
 *
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
define('MYSQL_RESULT_TYPE',1);
class indexControl extends BaseHomeControl{
	//首页
	public function indexOp(){
		Language::read('home_index_index');
		Tpl::output('index_sign','index');

        //推荐店铺
        $model_store = Model('store');
		$r_store = $model_store->getRecommendStore(3);
		Tpl::output('show_recommend_store',$r_store);

        //收藏店铺
		$f_store = $model_store->getFavoritesStore(3);
		Tpl::output('show_favorites_store',$f_store);
        
        //最近加盟店铺
		$n_store = $model_store->getNewStore(3);
		Tpl::output('show_new_store',$n_store);

		$xianshi_item = $this->_promotion();//限时折扣
		Tpl::output('xianshi_item',$xianshi_item);
		$list = $this->_product();//推荐商品
		Tpl::output('recommend_best_item',$list);
		
		$model_web_config = Model('web_config');
		$web_html = $model_web_config->getWebHtml('index');//板块信息
		Tpl::output('web_html',$web_html);

		//友情链接
		Tpl::output('show_flink',($link = F('link')) ? $link : H('link',true,'file'));

		//团购专区
		Language::read('member_groupbuy');
        $param = array();
        $param['recommended'] = 1;
        $param['state'] = 3;
        $param['in_progress'] = time();
        $param['limit'] = 1;
		$model_group = Model('goods_group');
        $group_list = $model_group->getList($param);
		Tpl::output('group_list',$group_list[0]);
        Tpl::output('count_down',$group_list[0]['end_time'] - time());

		//会员信息
		if($_SESSION['is_login'] == '1'){
			$member_model	= Model('member');
			$member_info	= $member_model->infoMember(array('member_id'=>$_SESSION['member_id']),'member_name,member_points,available_predeposit,member_avatar');
			Tpl::output('member_info',$member_info);
		}
		
		//文章输出
		$list = $this->_article();

		Model('seo')->type('index')->show();

		Tpl::showpage('index');
	}

	//文章输出
	private function _article() {

		if (file_exists(BasePath.'/cache/index/article.php')){
			include(BasePath.'/cache/index/article.php');
			Tpl::output('show_article',$show_article);
			Tpl::output('article_list',$article_list);
			return ;		
		}
		$model_article_class	= Model('article_class');
		$model_article	= Model('article');
		$show_article = array();//商城公告
		$article_list	= array();//下方文章
		$notice_class	= array('notice','store','about');
		$code_array	= array('member','store','payment','sold','service','about');
		$notice_limit	= 5;
		$faq_limit	= 5;

		$class_condition	= array();
		$class_condition['home_index'] = 'home_index';
		$class_condition['order'] = 'ac_sort asc';
		$article_class	= $model_article_class->getClassList($class_condition);
		$class_list	= array();
		if(!empty($article_class) && is_array($article_class)){
			foreach ($article_class as $key => $val){
				$ac_code = $val['ac_code'];
				$ac_id = $val['ac_id'];
				$val['list']	= array();//文章
				$class_list[$ac_id]	= $val;
			}
		}
		
		$condition	= array();
		$condition['article_show'] = '1';
		$condition['home_index'] = 'home_index';
		$condition['field'] = 'article.article_id,article.ac_id,article.article_url,article.article_title,article.article_time,article_class.ac_name,article_class.ac_parent_id';
		$condition['order'] = 'article_sort desc,article_time desc';
		$condition['limit'] = '300';
		$article_array	= $model_article->getJoinList($condition);
		if(!empty($article_array) && is_array($article_array)){
			foreach ($article_array as $key => $val){
				$ac_id = $val['ac_id'];
				$ac_parent_id = $val['ac_parent_id'];
				if($ac_parent_id == 0) {//顶级分类
					$class_list[$ac_id]['list'][] = $val;
				} else {
					$class_list[$ac_parent_id]['list'][] = $val;
				}
			}
		}
		if(!empty($class_list) && is_array($class_list)){
			foreach ($class_list as $key => $val){
				$ac_code = $val['ac_code'];
				if(in_array($ac_code,$notice_class)) {
					$list = $val['list'];
					array_splice($list, $notice_limit);
					$val['list'] = $list;
					$show_article[$ac_code] = $val;
				}
				if (in_array($ac_code,$code_array)){
					$list = $val['list'];
					$val['class']['ac_name']	= $val['ac_name'];
					array_splice($list, $faq_limit);
					$val['list'] = $list;
					$article_list[] = $val;
				}
			}
		}
		$string = "<?php\n\$show_article=".var_export($show_article,true).";\n";
		$string .= "\$article_list=".var_export($article_list,true).";\n?>";
		file_put_contents(BasePath.'/cache/index/article.php',compress_code($string));

		Tpl::output('show_article',$show_article);
		Tpl::output('article_list',$article_list);
	}
	
	//限时折扣
	private function _promotion(){
		$cache_file = BasePath.DS.'cache'.DS.'index'.DS.'promotion.php';
		if (!file_exists($cache_file) || filemtime($cache_file) <= (time()-SESSION_EXPIRE)){//文件不存在或过期时重新生成
			$limit	= 4;//显示个数
			$field = 'p_xianshi.xianshi_name,p_xianshi.store_id,p_xianshi.store_name,'.
			'p_xianshi_goods.goods_id,p_xianshi_goods.goods_name,p_xianshi_goods.goods_image,p_xianshi_goods.goods_store_price,p_xianshi_goods.discount';
			$promotion_time = time();
			//查询条件为：已经开始--lt、没有结束--gt、活动状态正常--2、商品状态可用--1
			$condition	= array(
				'start_time'=>array('lt',$promotion_time),
				'end_time'=>array('gt',$promotion_time),
				'p_xianshi.state'=>'2',
				'p_xianshi_goods.state'=>'1'
			);
			$model = Model();
			$list = $model->table('p_xianshi_goods,p_xianshi')->field($field)->on('p_xianshi_goods.xianshi_id=p_xianshi.xianshi_id')->where($condition)->order(rand(1,5))->limit($limit)->select();//防止出现全是一个店铺的使用随机排序
			F('promotion',$list,'cache/index');
		} else {
			$list = F('promotion','','cache/index');
		}
		return $list;
	}

	//推荐商品
	private function _product(){
		if (!$list = F('product','','cache/index')){
			//推荐商品
			$recommend_limit	= 4;//显示个数
			$model_recommend	= Model('recommend');
			$condition	= array(
				'goods_show'=>'1',
				'recommend_id'=>'1',
				'limit'=>$recommend_limit,
				'field'	=> 'recommend_goods.recommend_id,goods.goods_id,goods.store_id,goods.goods_name,goods.goods_image,goods.goods_store_price'
			);
			$list	= $model_recommend->getGoodsList($condition);
		}
		F('product',$list,'cache/index');
		return $list;
	}

	//json输出商品分类
	public function josn_classOp() {
		/**
		 * 实例化商品分类模型
		 */
		$model_class		= Model('goods_class');
		$goods_class		= $model_class->getClassList(array('gc_parent_id'=>intval($_GET['gc_id']),'gc_show'=>1,'order'=>'gc_parent_id asc,gc_sort asc,gc_id asc'));
		$array				= array();
		if(is_array($goods_class) and count($goods_class)>0) {
			foreach ($goods_class as $val) {
				$array[$val['gc_id']] = array('gc_id'=>$val['gc_id'],'gc_name'=>htmlspecialchars($val['gc_name']),'gc_parent_id'=>$val['gc_parent_id'],'gc_sort'=>$val['gc_sort']);
			}
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$array = Language::getUTF8(array_values($array));//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		} else {
			$array = array_values($array);
		}
		echo json_encode($array);
	}

	//闲置物品地区json输出
	public function flea_areaOp() {
		if(intval($_GET['check']) > 0) {
			$_GET['area_id'] = $_GET['region_id'];
		}
		if(intval($_GET['area_id']) == 0) {
			return ;
		}
		$model_area	= Model('flea_area');
		$area_array			= $model_area->getListArea(array('flea_area_parent_id'=>intval($_GET['area_id'])),'flea_area_sort desc');
		$array	= array();
		if(is_array($area_array) and count($area_array)>0) {
			foreach ($area_array as $val) {
				$array[$val['flea_area_id']] = array('flea_area_id'=>$val['flea_area_id'],'flea_area_name'=>htmlspecialchars($val['flea_area_name']),'flea_area_parent_id'=>$val['flea_area_parent_id'],'flea_area_sort'=>$val['flea_area_sort']);
			}
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$array = Language::getUTF8(array_values($array));//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
			} else {
				$array = array_values($array);
			}
		}
		if(intval($_GET['check']) > 0) {//判断当前地区是否为最后一级
			if(!empty($array) && is_array($array)) {
				echo 'false';
			} else {
				echo 'true';
			}
		} else {
			echo json_encode($array);
		}
	}

	//json输出闲置物品分类
	public function josn_flea_classOp() {
		/**
		 * 实例化商品分类模型
		 */
		$model_class		= Model('flea_class');
		$goods_class		= $model_class->getClassList(array('gc_parent_id'=>intval($_GET['gc_id'])));
		$array				= array();
		if(is_array($goods_class) and count($goods_class)>0) {
			foreach ($goods_class as $val) {
				$array[$val['gc_id']] = array('gc_id'=>$val['gc_id'],'gc_name'=>htmlspecialchars($val['gc_name']),'gc_parent_id'=>$val['gc_parent_id'],'gc_sort'=>$val['gc_sort']);
			}
		}
		/**
		 * 转码
		 */
		if (strtoupper(CHARSET) == 'GBK'){
			$array = Language::getUTF8(array_values($array));//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
		} else {
			$array = array_values($array);
		}
		echo json_encode($array);
	}

	//判断是否登录
	public function loginOp(){
		echo ($_SESSION['is_login'] == '1')? '1':'0';
	}
}
