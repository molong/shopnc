<?php
/**
 * 会员中心--收藏功能
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class member_favoritesControl extends BaseMemberControl{
	public function __construct(){
        parent::__construct();
        Language::read('member_layout,member_member_favorites');
    }
	/**
	 * 增加商品收藏
	 */
	public function favoritesgoodsOp(){
		$fav_id = intval($_GET['fid']);
		if ($fav_id <= 0){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
			die;
		}
		$favorites_model = Model('favorites');
		//判断是否已经收藏
		$favorites_info = $favorites_model->getOneFavorites(array('fav_id'=>"$fav_id",'fav_type'=>'goods','member_id'=>"{$_SESSION['member_id']}"));
		if(!empty($favorites_info)){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_already_favorite_goods','UTF-8')));
			die;
		}
		//判断商品是否为当前会员所有
		$goods_model = Model('goods');
		$goods_info = $goods_model->getOne($fav_id);
		if ($goods_info['store_id'] == $_SESSION['store_id']){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_no_my_product','UTF-8')));
			die;
		}
		//添加收藏		
		$insert_arr = array();
		$insert_arr['member_id'] = $_SESSION['member_id'];
		$insert_arr['fav_id'] = $fav_id;
		$insert_arr['fav_type'] = 'goods';
		$insert_arr['fav_time'] = time();
		$result = $favorites_model->addFavorites($insert_arr);
		if ($result){
			//增加收藏数量
			$goods_model->updateGoodsAllUser(array('goods_collect'=>array('sign'=>'increase','value'=>'1')),$fav_id);
			echo json_encode(array('done'=>true,'msg'=>Language::get('favorite_collect_success','UTF-8')));
			die;
		}else{
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
			die;
		}
	}
	/**
	 * 增加店铺收藏
	 */
	public function favoritesstoreOp(){
		$fav_id = intval($_GET['fid']);		
		if ($fav_id <= 0){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
			die;
		}
		$favorites_model = Model('favorites');
		//判断是否已经收藏
		$favorites_info = $favorites_model->getOneFavorites(array('fav_id'=>"$fav_id",'fav_type'=>'store','member_id'=>"{$_SESSION['member_id']}"));
		if(!empty($favorites_info)){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_already_favorite_store','UTF-8')));
			die;
		}
		//判断店铺是否为当前会员所有
		if ($fav_id == $_SESSION['store_id']){
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_no_my_store','UTF-8')));
			die;
		}
		//添加收藏		
		$insert_arr = array();
		$insert_arr['member_id'] = $_SESSION['member_id'];
		$insert_arr['fav_id'] = $fav_id;
		$insert_arr['fav_type'] = 'store';
		$insert_arr['fav_time'] = time();
		$result = $favorites_model->addFavorites($insert_arr);
		if ($result){
			//增加收藏数量
			$store_model = Model('store');
			$store_model->storeUpdate(array('store_id'=>$fav_id,'store_collect'=>array('sign'=>'increase','value'=>'1')),$fav_id);
			echo json_encode(array('done'=>true,'msg'=>Language::get('favorite_collect_success','UTF-8')));
			die;
		}else{
			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
			die;
		}
	}
	
	/**
	 * 商品收藏列表
	 *
	 * @param
	 * @return
	 */
	public function fglistOp(){
		$favorites_model = Model('favorites');
		$show_type = 'favorites_goods_picshowlist';//默认为图片横向显示
		$show = $_GET['show'];
		$store_array = array('list'=>'favorites_goods_index','pic'=>'favorites_goods_picshowlist','store'=>'favorites_goods_shoplist');
		if (array_key_exists($show,$store_array)) $show_type = $store_array[$show];
		$page	= new Page();
		$page->setEachNum(20);
		$page->setStyle('admin');
		$favorites_list = $favorites_model->getFavoritesList(array('member_id'=>"{$_SESSION['member_id']}",'fav_type'=>'goods'),$page);
		if (!empty($favorites_list) && is_array($favorites_list)){
			$favorites_id = array();//收藏的商品编号
			foreach ($favorites_list as $key=>$favorites){
				$fav_id = $favorites['fav_id'];
				$favorites_id[] = $favorites['fav_id'];
				$favorites_key[$fav_id] = $key;
			}
			$goods_model = Model('goods');
			$goods_list = $goods_model->getGoods(array('goods_id_in'=>"'".implode("','",$favorites_id)."'"),'',
			'goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.goods_store_price,goods.commentnum,goods.salenum,goods.goods_collect,store.store_name,store.member_id,store.member_name,store.store_qq,store.store_ww','store');
			$store_array = array();//店铺编号
			if (!empty($goods_list) && is_array($goods_list)){
				$store_goods_list = array();//店铺为分组的商品
				foreach ($goods_list as $key=>$fav){
					$fav_id = $fav['goods_id'];
					$fav['goods_member_id'] = $fav['member_id'];
					$key = $favorites_key[$fav_id];
					$favorites_list[$key]['goods'] = $fav;
					$store_id = $fav['store_id'];
					if (!in_array($store_id,$store_array)) $store_array[] = $store_id;
					$store_goods_list[$store_id][] = $favorites_list[$key];
				}
			}
			$store_favorites = array();//店铺收藏信息
			if (!empty($store_array) && is_array($store_array)){
				$store_list = $favorites_model->getFavoritesList(array('member_id'=>"{$_SESSION['member_id']}",'fav_type'=>'store','fav_id_in'=>"'".implode("','",$store_array)."'"));
				if (!empty($store_list) && is_array($store_list)){
					foreach ($store_list as $key=>$val){
						$store_id = $val['fav_id'];
						$store_favorites[] = $store_id;
					}
				}
			}
		}
		//查询会员信息
		$this->get_member_info();
		self::profile_menu('favorites','favorites');
		Tpl::output('menu_key',"fav_goods");
		Tpl::output('favorites_list',$favorites_list);
		Tpl::output('store_favorites',$store_favorites);
		Tpl::output('store_goods_list',$store_goods_list);
		Tpl::output('show_page',$page->show());
		Tpl::output('menu_sign','collect_list');
		Tpl::showpage($show_type);
	}
	/**
	 * 店铺收藏列表
	 *
	 * @param
	 * @return
	 */
	public function fslistOp(){
		$favorites_model = Model('favorites');
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$favorites_list = $favorites_model->getFavoritesList(array('member_id'=>"{$_SESSION['member_id']}",'fav_type'=>'store'),$page);
		if (!empty($favorites_list) && is_array($favorites_list)){
			$favorites_id = array();//收藏的店铺编号
			foreach ($favorites_list as $key=>$favorites){
				$fav_id = $favorites['fav_id'];
				$favorites_id[] = $favorites['fav_id'];
				$favorites_key[$fav_id] = $key;
			}
			$store_model = Model('store');
			$store_list = $store_model->getStoreList(array('store_id_in'=>"'".implode("','",$favorites_id)."'"));
			$store_list = $store_model->getStoreInfoBasic($store_list,30);//30天内新上架的商品数
			if (!empty($store_list) && is_array($store_list)){
				foreach ($store_list as $key=>$fav){
					$fav_id = $fav['store_id'];
					$key = $favorites_key[$fav_id];
					$favorites_list[$key]['store'] = $fav;
				}
			}
		}
		//查询会员信息
		$this->get_member_info();
		self::profile_menu('favorites','favorites');
		Tpl::output('menu_key',"fav_store");
		Tpl::output('favorites_list',$favorites_list);
		Tpl::output('show_page',$page->show());		
		Tpl::output('menu_sign','collect_store');
		Tpl::showpage("favorites_store_index");
	}
	/**
	 * 删除收藏
	 *
	 * @param
	 * @return
	 */
	public function delfavoritesOp(){
		if (!$_GET['fav_id'] || !$_GET['type']){
			showDialog(Language::get('member_favorite_del_fail'),'','error');
		}
		$fav_id = $_GET['fav_id'];
		$type = $_GET['type'];
		$favorites_model = Model('favorites');
		$fav_arr = explode(',',$_GET['fav_id']);
		if (!empty($fav_arr) && is_array($fav_arr)){
			//批量删除
			$fav_str = "'".implode("','",$fav_arr)."'";
			$result = $favorites_model->delFavorites(array('fav_id_in'=>"$fav_str",'fav_type'=>"$type",'member_id'=>"{$_SESSION['member_id']}"));
			if ($result){
				//剔除删除失败的记录
				$favorites_list = $favorites_model->getFavoritesList(array('fav_id_in'=>"$fav_str",'fav_type'=>"$type",'member_id'=>"{$_SESSION['member_id']}"));
				if (!empty($favorites_list)){
					foreach ($favorites_list as $k=>$v){
						unset($fav_arr[array_search($v['fav_id'],$fav_arr)]);
					}
				}
				if (!empty($fav_arr)){
					if ($type=='goods'){
						$fav_str = "'".implode("','",$fav_arr)."'";
						//更新收藏数量
						$goods_model = Model('goods');
						$goods_model->updateGoods(array('goods_collect'=>array('sign'=>'decrease','value'=>'1')),$fav_arr);
						showDialog(Language::get('favorite_del_success'),'index.php?act=member_favorites&op=fglist&show='.$_GET['show'],'succ');
					}else {
						$fav_str = "'".implode("','",$fav_arr)."'";
						//更新收藏数量
						$store_model = Model('store');
						$store_model->updateByCondtion(array('store_collect'=>array('sign'=>'decrease','value'=>'1')),array('store_id_in'=>$fav_str));
						showDialog(Language::get('favorite_del_success'),'index.php?act=member_favorites&op=fslist','succ');
					}
				}
			}else {
				showDialog(Language::get('favorite_del_fail'),'','error');
			}
			
		}else {
			showDialog(Language::get('member_favorite_del_fail'),'','error');
		}
	}
	/**
	 * 店铺新上架的商品列表
	 *
	 * @param
	 * @return
	 */
	public function store_goodsOp(){
		$store_id = intval($_GET["store_id"]);
		if($store_id > 0) {
			$condition = array();
			$add_time_to = date("Y-m-d");//当前日期
			$add_time_from = date("Y-m-d",(strtotime($add_time_to)-60*60*24*30));//30天
			$condition['store_id'] = $store_id;
			$condition['goods_show'] = 1;
			$condition['add_time_from']	= strtotime($add_time_from);
			$condition['add_time_to']	= time();
			$condition['limit'] = 50;
			$goods_model = Model('goods');
			$goods_list = $goods_model->getGoods($condition,'','goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.goods_store_price','goods');
			Tpl::output('goods_list',$goods_list);
			Tpl::showpage('favorites_store_goods','null_layout');
		}
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_type,$menu_key='') {
		$menu_array = array(
			1=>array('menu_key'=>'fav_goods','menu_name'=>Language::get('nc_member_path_collect_list'),	'menu_url'=>'index.php?act=member_favorites&op=fglist'),
			2=>array('menu_key'=>'fav_store','menu_name'=>Language::get('nc_member_path_collect_store'), 'menu_url'=>'index.php?act=member_favorites&op=fslist')
		);
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
