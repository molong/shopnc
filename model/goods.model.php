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

class goodsModel extends Model {
 	public function __construct(){
		parent::__construct('goods');
	}
	/**
	 * 商品数量
	 *
	 * @param	array $param 商品资料
	 */
	public function countGoods($param,$type = ''){
		if (empty($param)) {
			return false;
		}		
		$condition_str = $this->getCondition($param);
		$array	= array();
		switch ($type){
			case 'store':
				$array['table'] = 'goods,store';
				$array['join_type'] = 'LEFT JOIN';
				$array['join_on'] = array(
					'goods.store_id=store.store_id'
				);
				break;
			default :
				$array['table'] = 'goods';
				break;
		}
		$array['where'] = $condition_str;
		$array['field'] = 'count(*)';
		$goods_array	= Db::select($array);
		return $goods_array[0][0];
	}
	/**
	 * 按分类查询商品数量
	 * 
	 *  
	 */
	public function countGoodsByClass() {
		$array['table'] = 'goods';
		$array['field']	= 'count(goods_id) as count,gc_id';
		$array['group'] = 'gc_id';
		$goods_array	= Db::select($array);
		return $goods_array;
	}
	/**
	 * 查询商品库存总数
	 * 
	 * @param 	array $param
	 * @param	string $field
	 */
	public function countStorageByGoodsSpec($param, $field) {
		$array	= array();
		$array['table']		= 'goods_spec';
		$array['group']		= 'goods_id';
		$array['where']		= $this->getCondition($param);
		$array['field']		= $field;
		$goods_array		= Db::select($array);
		return $goods_array;
	}
	/**
	 * 商品保存
	 *
	 * @param	array $param 商品资料
	 */
	public function saveGoods($param) {
		if(empty($param)) {
			return false;
		}
		$goods_array	= array();
		$goods_array['goods_name']				= $param['goods_name'];
		$goods_array['gc_id']					= $param['gc_id'];
		$goods_array['gc_name']					= $param['gc_name'];
		$goods_array['store_id']				= $_SESSION['store_id'];
		$goods_array['spec_open']				= $param['spec_open'];
		$goods_array['brand_id']				= $param['brand_id'];
		$goods_array['goods_image']				= $param['goods_image'];
		$goods_array['goods_image_more']		= $param['goods_image_more'];
		$goods_array['goods_state']				= $param['goods_state'];
		$goods_array['goods_store_price']		= $param['goods_store_price'];
		$goods_array['goods_store_price_interval']= $param['goods_store_price_interval'];
		$goods_array['goods_serial']			= $param['goods_serial'];
		$goods_array['goods_show']				= $param['goods_show'];
		$goods_array['goods_state'] 			= 0;
		$goods_array['goods_commend']			= $param['goods_commend'];
		$goods_array['goods_add_time']			= time();
		$goods_array['goods_body']				= $param['goods_body'];
		$goods_array['goods_store_state']		= $param['goods_store_state'] == 1 ? 1 : '0' ;
		$goods_array['goods_keywords'] 			= $param['goods_keywords'];
		$goods_array['goods_description']		= $param['goods_description'];
		
		$goods_array['goods_transfee_charge']	= $param['goods_transfee_charge'];
		$goods_array['type_id']					= $param['type_id'];
		$goods_array['goods_spec']				= serialize($param['goods_spec']);
		$goods_array['goods_attr']				= serialize($param['goods_attr']);
		$goods_array['spec_name']				= serialize($param['spec_name']);
		
		$goods_array['goods_starttime']			= $param['goods_starttime'];
		$goods_array['goods_endtime']			= $param['goods_endtime'];
		$goods_array['goods_form']				= $param['goods_form'];
		$goods_array['py_price']				= $param['py_price'];
		$goods_array['kd_price']				= $param['kd_price'];
		$goods_array['es_price']				= $param['es_price'];
		$goods_array['transport_id']			= $param['transport_id'];

		$goods_array['city_id']					= $param['city_id'];
		$goods_array['province_id']				= $param['province_id'];
		$result	= Db::insert('goods',$goods_array);
		return $result;
	}
	/**
	 * 获取商品信息
	 *
	 *
	 */ 	
	public function getGoods($param,$page = '',$field='*',$type = 'simple',$extend = null) {
		$condition_str = $this->getCondition($param);
		$array = array();
		$array['field'] = $field;
		switch ($type){
            case 'groupbuy_goods_info':
				$array['table'] = 'goods,goods_spec';
				$array['join_type'] = empty($param['join_type'])?'LEFT JOIN':$param['join_type'];
				$array['join_on'] = array(
					'goods.goods_id=goods_spec.goods_id'
				);
				break;
            
			case 'store':
				$array['table'] = 'goods,store';
				$array['join_type'] = 'INNER JOIN';
				$array['join_on'] = array(
					'goods.store_id=store.store_id'
				);
				if (is_array($extend)){
					$array = array_merge($array,$extend);
				}
				break;
			case 'goods':
				$array['table'] = 'goods';
				if (is_array($extend)){
					$array = array_merge($array,$extend);
				}
				break;
			case 'goods_spec':
				$array['table'] = 'goods_spec';
				break;
			case 'brand':
				$array['table'] = 'goods,brand,goods_class';
				$array['field']	= '*';
				$array['join_type'] = 'LEFT JOIN';
				$array['join_on'] = array(
					'goods.brand_id=brand.brand_id',
					'goods.gc_id=goods_class.gc_id'
				);
				break;
			case 'stc':
				$array['table'] = 'goods,store_class_goods';
				$array['field'] = $field=='*' ? 'DISTINCT goods.*' : 'DISTINCT '.$field;//去掉重复信息
				$array['count'] = 'count(DISTINCT goods.goods_id)';
				$array['join_type'] = 'LEFT JOIN';
				$array['join_on'] = array(
					'goods.goods_id=store_class_goods.goods_id'
				);
				break;
			default:
				$array['table'] = 'goods,goods_spec';
				$array['join_type'] = empty($param['join_type'])?'LEFT JOIN':$param['join_type'];
				$array['join_on'] = array(
					'goods.spec_id=goods_spec.spec_id'
				);
		}
		$array['where'] = $condition_str;
		$array['order'] = $param['order'] ? $param['order'] : 'goods.goods_id desc';
		$array['limit'] = $param['limit'];
		$goods_array	= Db::select($array,$page);
		return $goods_array;
	}
	/**
	 * 商品列表(前台卖家使用)
	 *
	 *
	 */ 	
	public function listGoods($param,$page = '',$field='*') {
		if($param['stc_id'] != 0 || trim($param['stc_id_in'])) {
			$param	= $this->sublistGoods($param);
			if(empty($param)) return array();
		}
		$condition_str = $this->getCondition($param);
		$array	= array();
		$array['table']	= 'goods,goods_spec';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$array['order'] = $param['order'] ? $param['order'] : 'goods.goods_id desc';
		$array['join_type']= 'LEFT JOIN';
		$array['join_on']= array('goods.spec_id=goods_spec.spec_id');
		$array['limit'] = $param['limit'];
		$list_goods		= Db::select($array,$page);
		return $list_goods;
	}
	/**
	 * 商品列表 (缓存使用)
	 */ 	
	public function getGoodsForCache($param,$field='*') {
		$condition_str = $this->getCondition($param);
		$array	= array();
		$array['table']	= 'goods';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$array['order'] = $param['order'] ? $param['order'] : 'goods.goods_id desc';
		$array['limit']	= $param['limit'];
		$list_goods		= Db::select($array);
		return $list_goods;
	}

    /**
     * 获取店铺推荐商品列表
     **/
    public function getCommenGoods($param,$page = '',$field = '*') {
        $param['goods_commend'] = 1;
        $param['goods_state'] = 0;
        $param['goods_show'] = 1;
        $array = array();
        $array['table'] = 'goods';
        $array['where'] = $this->getCondition($param);
        $array['field'] = $field;
        $array['limit'] = $param['limit'];
        return Db::select($array,$page);
    }

	/**
	 * 店铺分类商品列表
	 *
	 *
	 */ 
	private function sublistGoods($param) {
		//得到条件语句,并获得店铺分类商品分页当前页的内容
		$condition_str = $this->getCondition($param);
		$array	= array();
		$array['table'] = 'store_class_goods,goods';
		$array['where']	= $condition_str;
		$array['field']	= 'DISTINCT goods.goods_id';
		$array['join_type']= 'INNER JOIN';
		$array['join_on']= array('store_class_goods.goods_id=goods.goods_id');
		$array['order'] = 'goods.goods_id desc';
		$sub_list_goods	= Db::select($array);
		$sub_goods_id	= '';
		if(is_array($sub_list_goods) and !empty($sub_list_goods)) {
			foreach ($sub_list_goods as $val) {
				$sub_goods_id .= $val['goods_id'].',';
			}
			$sub_goods_id	= substr($sub_goods_id,0,-1);
		}
		if($sub_goods_id == '') return '';
		//将条件传入商品列表，进行二次查询
		unset($param['stc_id']);
		unset($param['stc_id_in']);
		$param['sub_goods_id'] = $sub_goods_id;
		return $param;
	}
	/**
	 * 商品列表(管理员后台使用)
	 *
	 *
	 */ 	
	public function getGoodsList($param,$page = '',$field='*') {
		$condition_str = $this->getCondition($param);
		$array	= array();
		$array['table']	= 'goods,brand,store';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$array['order'] = $param['order'] ? $param['order'] : 'goods.goods_id desc';
		$array['join_type']= 'LEFT JOIN';
		$array['join_on']= array('goods.brand_id=brand.brand_id','goods.store_id=store.store_id');
		$array['limit'] = $param['limit'];
		$list_goods		= Db::select($array,$page);
		return $list_goods;
	}

    /**
	 * 根据编号获取单个内容
	 *
	 * @param int $groupbuy_area_id 地区ID
	 * @return array 数组类型的返回结果
	 */
	public function getOne($id,$fields = '*'){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'goods';
			$param['field'] = 'goods_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param,$fields);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 商品信息更新
	 *
	 * @param	array $param 列表条件
	 * @param	int $goods_id 商品id
	 */ 	
	public function updateGoods($param,$goods_id) {
		if(empty($param)) {
			return false;
		}
		$update		= false;
		if(is_array($goods_id))$goods_id	= implode(',',$goods_id);
		//得到条件语句
		$condition_str	= "WHERE goods_id in(".$goods_id.")";
		$update		= Db::update('goods',$param,$condition_str);
		return $update;
	}
	/**
	 * 商品信息更新
	 *
	 * @param	array $param 列表条件
	 * @param	array $condition_array 商品id
	 */ 	
	public function updateGoodsWhere($param, $condition_array) {
		if(empty($param)) {
			return false;
		}
		$update		= false;
		//得到条件语句
		$condition_str	= $this->getCondition($condition_array);
		$update		= Db::update('goods',$param,$condition_str);
		return $update;
	}
	/**
	 * 更新商品规格信息
	 *
	 * @param 
	 * @return bool 布尔类型的返回结果
	 */
	public function updateSpecGoods($condition,$param){
		$goods_id = $condition['spec_goods_id'];
		if (intval($goods_id) < 1){
			return false;
		}
		$condition_str = $this->getCondition($condition);
		$where = $condition_str;
		if (is_array($param)){
			$result = Db::update('goods_spec',$param,$where);
			return result;
		}else {
			return false;
		}
	}
	/**
	 * 商品信息更新
	 *
	 * @param	array $param 列表条件
	 * @param $goods_id 商品id
	 */ 	
	public function updateGoodsAllUser($param,$goods_id){
		if(empty($param)) {
			return false;
		}
		$update		= false;
		if(is_array($goods_id)){
			$goods_id = implode(',',$goods_id);
			$condition_str	= " WHERE goods_id in(".$goods_id.")";
		}else{
			$condition_str	= " WHERE goods_id = '$goods_id'";
		}
		//得到条件语句
		$update	= Db::update('goods',$param,$condition_str);
		if ($update){
			return true;
		}
		return false;
	}
	/**
	 * 根据店铺删除商品
	 *
	 * @param	array $param 列表条件
	 * @param	int $store_id 店铺id
	 */ 
	public function dropGoodsByStore($store_id) {
		if(empty($store_id)) {
			return false;
		}
		$where = " store_id = '". intval($store_id) ."'";
		$result = Db::delete('goods',$where);
		return $result;
	}
	/**
	 * 商品删除
	 *
	 * @param	array $param 列表条件
	 * @param	int $goods_id 商品id
	 */ 
	public function dropGoods($goods_id) {
		if(empty($goods_id)) {
			return false;
		}
		$goods_id_array	= explode(',',$goods_id);
		if(is_array($goods_id_array) and !empty($goods_id_array)) {
			foreach ($goods_id_array as $val) {
				$goods_id_one = intval($val);
				if($goods_id_one <= 0){
					continue;
				}
				$goods_array	= array();
				$goods_array	= Db::select(array('table'=>'goods','field'=>'*','where'=>"where goods_id='{$goods_id_one}'"));
				$goods_array	= $goods_array[0];
				
				/**
				 * 删除商品规格图片
				 */
				$col_img	= unserialize($goods_array['goods_col_img']);
				if(is_array($col_img) && !empty($col_img)){
					$col_img	= array_unique($col_img);
					foreach ($col_img as $v){
						@unlink(BasePath.DS.ATTACH_SPEC.DS.$goods_array['store_id'].DS.$v);
						@unlink(BasePath.DS.ATTACH_SPEC.DS.$goods_array['store_id'].DS.str_replace('_tiny', '_mid', $v));
					}
				}
				
				$del_state		= Db::delete('goods','where goods_id='.$goods_array['goods_id']);
				if($del_state) {
					$image_more	= Db::select(array('table'=>'upload','field'=>'*','where'=>' where item_id='.$goods_array['goods_id']." and upload_type in ('2','3')"));

					Db::delete('upload','where item_id='.$goods_array['goods_id']." and upload_type in ('2','3')");

					Db::delete('goods_spec','where goods_id='.$goods_array['goods_id']);
					
					Db::delete('goods_attr_index','where goods_id='.$goods_array['goods_id']);
					
					Db::delete('goods_spec_index','where goods_id='.$goods_array['goods_id']);

					Db::delete('store_class_goods','where goods_id='.$goods_array['goods_id']);
					
					Db::delete('recommend_goods','where goods_id='.$goods_array['goods_id']);
					
					Db::delete('favorites','where fav_type="goods" and fav_id='.$goods_array['goods_id']);
					
					Db::delete('p_bundling_goods','where goods_id='.$goods_array['goods_id']);
				}
			}
		}
		return true;
	}
	/**
	 * 获取已经保存的店铺商品分类列表
	 *
	 * @param	int $goods_id	商品id
	 */ 
	public function getStoreClassGoods($goods_id) {
		$class_list		= array();
		if(is_array($goods_id))$goods_id	= implode(',',$goods_id);
		$class_list		= Db::select(array('table'=>'store_class_goods','where'=>'where goods_id in ('.$goods_id.')','field'=>'*'));
		return $class_list;
	}
	/**
	 * 获取商品规格
	 *
	 * @param	int $goods_id	商品id
	 */ 
	public function getSpecGoods($goods_id) {
		$spec_array		= array();
		$spec_array		= Db::select(array('table'=>'goods_spec','where'=>"where goods_id='$goods_id'",'field'=>'*'));
		return $spec_array;
	}
	/**
	 * 获取商品规格
	 *
	 * @param	int $goods_id	商品id
	 */ 
	public function getSpecGoodsWhere($goods_id,$condition) {
		$spec_array		= array();
		$spec_array		= Db::select(array('table'=>'goods_spec','where'=>$this->getCondition($condition),'field'=>'spec_id','order'=>'spec_id'));
		return $spec_array[0];
	}
	/**
	 * 商品规格保存
	 *
	 * @param	array $spec 商品规格信息
	 * @param	array $spec_name 商品规格名称
	 * @param	int $goods_id 商品id
	 */ 
	public function saveSpecGoods($spec,$goods_id,$spec_name='') {
		if (empty($spec)) {
			return false;
		}
		$default_spec_id = '0';
		foreach ($spec as $val) {
			$insert_array	= array();
			$insert_array['goods_id']			= $goods_id;
			$insert_array['spec_name']			= serialize($spec_name);
			$insert_array['spec_goods_spec']	= serialize($val['sp_value']);
			$insert_array['spec_goods_price']	= trim($val['price']);
			$insert_array['spec_goods_storage']	= intval($val['stock']);
			$insert_array['spec_goods_serial']	= trim($val['sku']);

			$insert_id = Db::insert('goods_spec',$insert_array);
			if($default_spec_id == '0') {
				$default_spec_id = $insert_id;
			}
		}
		return $default_spec_id;
	}
	/**
	 * 商品规格中的库存更新
	 *
	 * @param	array $param 商品规格信息
	 * @param	int $spec_id 商品规格id
	 */ 
	public function updateSpecStorageGoods($param,$spec_id) {
		if(empty($param)) {
			return false;
		}
		$update		= false;
		if(is_array($spec_id))$spec_id	= implode(',',$spec_id);
		//得到条件语句
		$condition_str	= "WHERE spec_id in(".$spec_id.")";
		$update		= Db::update('goods_spec',$param,$condition_str);
		return $update;
	}
	/**
	 * 商品自己店铺分类保存
	 *
	 * @param	array $param 店铺分类
	 * @param	int $goods_id 商品id
	 */ 
	public function saveStoreClassGoods($param,$goods_id) {
		if(empty($param)) {
			return false;
		}
		if(is_array($param)){
			foreach ($param as $val) {
				if(intval($val) == 0) {
					continue;
				}
				$insert_array	= array();
				$insert_array['stc_id']	= $val;
				$insert_array['goods_id']= $goods_id;
	
				Db::insert('store_class_goods',$insert_array);
			}
		}
	}
	/**
	 * 商品规格删除
	 *
	 * @param	int $goods_id	商品id
	 */ 
	public function dropSpecGoods($goods_id) {
		if(is_array($goods_id))$goods_id	= implode(',',$goods_id);
		Db::delete('goods_spec','where goods_id in('.$goods_id.')');
	}
	/**
	 * 商品规格删除
	 *
	 * @param	array $spec_id
	 */ 
	public function dropSpecGoodsWhere($spec_id, $goods_id) {
		$where = '';
		if(is_array($spec_id))$spec_id	= implode(',',$spec_id);
		if(count($spec_id) > 0){
			$where = " and goods_id='".$goods_id."' and spec_id not in (".$spec_id.")";
		}
		Db::delete('goods_spec',$where);
	}
	/**
	 * 商品保存的店铺分类删除
	 *
	 * @param	int $goods_id	商品id
	 */ 
	public function dropStoreClassGoods($goods_id) {
		if(is_array($goods_id))$goods_id	= implode(',',$goods_id);
		Db::delete('store_class_goods','where goods_id in('.$goods_id.')');
	}
	/**
	 * 商品多图
	 *
	 * @param	array $param 列表条件
	 * @param	array $field 显示字段
	 */ 	
	public function getListImageGoods($param,$field='*') {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$array	= array();
		$array['table']		= 'upload';
		$array['where']		= $condition_str;
		$array['field']		= $field;
		$list_image			= Db::select($array);
		return $list_image;
	}
	/**
	 * 商品多图删除
	 *
	 * @param	array $param 删除条件
	 */ 
	public function dropImageGoods($param) {
		if(empty($param)) {
			return false;
		}
		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$image_info		= Db::select(array('table'=>'upload','where'=>$condition_str,'field'=>'*'));
		$state = Db::delete('upload',$condition_str);
		return $state;
	}
	/**
	 * 检查商品是否存在
	 *
	 * @param	array	$param 查询条件
	 * @param	string	$field 输出结果
	 */ 
	public function checkGoods($param,$field='*') {
		$goods_info		= array();
		//得到条件语句
		$condition_str	= $this->getCondition($param);
		$array			= array();
		$array['table']	= 'goods_spec,goods';
		$array['where']	= $condition_str;
		$array['field']	= $field;
		$array['join_type']= 'INNER JOIN';
		$array['join_on']= array('goods_spec.goods_id=goods.goods_id');
		$goods_info		= Db::select($array);
		return $goods_info[0];
	}
	/**
	 * 推荐处理
	 *
	 * @param int $id
	 * @param bool $is_rec
	 * @return bool
	 */
	public function recGroup($id,$is_rec=true){
		return Db::update('goods_group',array('recommended'=>$is_rec?'1':'0'),'where group_id in('.$id.')');
	}
	/**
	 * 根据店铺id更新商品所在店铺状态
	 *
	 * @param int $store_id
	 * @return bool
	 */
	 public function updateGoodsStoreStateByStoreId($store_id, $state = 'open'){
		if (intval($store_id) > 0){
			$state = $state == 'open' ? 1 : 0;
			return Db::update('goods',array('goods_show'=>$state),"where store_id = '$store_id'");
		} else {
			return false;
		}
	 }
	 /**
	  * 获得商品子分类的ID
	  * @param array $class_id
	  * @return string $class_string 逗号分割的分类ID及其子ID的字符串
	  */
	private function _getRecursiveClass($class_id){
		$id_array = explode(',', $class_id);//变字符串为数组，参数有可能是用逗号连接的多个编号
		$temp_list = Db::select(array('table'=>'goods_class','where'=>'gc_parent_id>0 and gc_show=1','field'=>'gc_id,gc_parent_id','order'=>'gc_parent_id asc'));
		if(is_array($temp_list) && !empty($temp_list)) {
			foreach ($temp_list as $key => $val) {
				$gc_parent_id	= $val['gc_parent_id'];
				if(in_array($gc_parent_id,$id_array)) $id_array[] = $val['gc_id'];//当父类ID在数组中时为有效子分类（'order'=>'gc_parent_id asc'，这个排序保证循环一次即可）
			}
		}
		$id_array = array_unique($id_array);//去掉重复
		return "'".implode("','",$id_array)."'";
	}
	/**
	 * 将条件数组组合为SQL语句的条件部分
	 *
	 * @param	array $condition_array
	 * @return	string
	 */
	private function getCondition($condition_array){
		$condition_sql = '';
		if ($condition_array['price'] != ''){
			if (is_array($condition_array['price'])){
				if($condition_array['price'][0] == 0 && $condition_array['price'][1] != 0){
					$condition_sql	.= " and goods.goods_store_price <= '{$condition_array['price'][1]}'";
				}
			    if($condition_array['price'][0] != 0 && $condition_array['price'][1] == 0){
					$condition_sql	.= " and goods.goods_store_price >= '{$condition_array['price'][0]}'";
				}
			    if($condition_array['price'][0] != 0 && $condition_array['price'][1] != 0){
					$condition_sql	.= " and goods.goods_store_price >= '{$condition_array['price'][0]}'";
					$condition_sql	.= " and goods.goods_store_price <= '{$condition_array['price'][1]}'";
				}			
			}else {
				$condition_sql	.= " and goods.goods_store_price = '{$condition_array['price']}'";
			}
		}
		if ($condition_array['area_id'] != '') {
			$condition_sql	.= " and `store`.area_id= '{$condition_array['area_id']}'";
		}
		if ($condition_array['goods_group.recommended'] != '') {
			$condition_sql	.= " and `goods_group`.recommended= '{$condition_array['goods_group.recommended']}'";
		}
		if ($condition_array['goods_spec.goods_id'] != '') {
			$condition_sql	.= " and `goods_spec`.goods_id= '{$condition_array['goods_spec.goods_id']}'";
		}
		if ($condition_array['group_id'] != '') {
			$condition_sql	.= " and `goods_group`.group_id= '{$condition_array['group_id']}'";
		}
		if ($condition_array['goods_image']){
			$condition_sql	.= " and `goods`.goods_image = '".$condition_array['goods_image']."'";
		}
		if ($condition_array['group_name'] != '') {
			$condition_sql	.= " and `goods_group`.group_name like '%".$condition_array['group_name']."%'";
		}
		if ($condition_array['state'] != '') {
			$condition_sql	.= ' and goods_group.state IN ('.$condition_array['state'].')';
		}
		if ($condition_array['published'] != ''){
			$condition_sql	.= ' and goods_group.published IN ('.$condition_array['published'].')';
		}
		if ($condition_array['like_store_name'] != ''){
			$condition_sql	.= " and store.store_name like '%".$condition_array['like_store_name']."%'";
		}
		if($condition_array['image_store_id'] != '') {
			$condition_sql	.= " and store_id = '{$condition_array['image_store_id']}' and item_id='{$condition_array['item_id']}' and upload_type='{$condition_array['image_type']}'";
		}
		if ($condition_array['upload_id'] != '') {
			$condition_sql	.= " and upload_id= '{$condition_array['upload_id']}'";
		}
		if ($condition_array['no_store_id'] != ''){
			$condition_sql	.= " and goods.store_id <> {$condition_array['no_store_id']} ";
		}
		if ($condition_array['lt_goods_endtime'] != ''){						// 小于结束时间
			$condition_sql	.= " and goods.goods_endtime >".$condition_array['lt_goods_endtime'];
		}
		if ($condition_array['gt_goods_endtime'] != ''){						// 大于结束时间
			$condition_sql	.= " and goods.goods_endtime <".$condition_array['gt_goods_endtime'];
		}
		if ($condition_array['gt_goods_starttime'] != ''){						// 大于开始时间
			$condition_sql	.= " and goods.goods_starttime <".$condition_array['gt_goods_starttime'];
		}
		if ($condition_array['store_id'] != '') {
			$condition_sql	.= " and goods.store_id= '{$condition_array['store_id']}'";
		}
		if ($condition_array['store_id_in'] != '') {
			$condition_sql	.= " and goods.store_id in('{$condition_array['store_id_in']}')";
		}
		if ($condition_array['goods_group.store_id'] != '') {
			$condition_sql	.= " and `goods_group`.store_id= '{$condition_array['goods_group.store_id']}'";
		}
		if($condition_array['goods_id'] != '') {
			$condition_sql	.= " and `goods`.goods_id= '{$condition_array['goods_id']}'";
		}
		if(isset($condition_array['goods_id_in'])) {
			if ($condition_array['goods_id_in'] == ''){
				$condition_sql	.= " and `goods`.goods_id in ('') ";
			}else {
				$condition_sql	.= " and `goods`.goods_id in({$condition_array['goods_id_in']})";
			}
		}
		if($condition_array['group_id'] != '') {
			$condition_sql	.= " and `goods_group`.group_id= '{$condition_array['group_id']}'";
		}
		if ($condition_array['goods_commend'] != '') {
			$condition_sql	.= " and `goods`.goods_commend= '{$condition_array['goods_commend']}'";
		}
		if ($condition_array['goods_show'] != '') {
			$condition_sql	.= " and goods.goods_show= '{$condition_array['goods_show']}'";
		}
		if ($condition_array['goods_state'] == '0' || $condition_array['goods_state'] == '1') {
			$condition_sql	.= " and goods.goods_state= '{$condition_array['goods_state']}'";
		}
		if($condition_array['stc_id'] != 0) {
			$condition_sql	.= " and store_class_goods.stc_id = '{$condition_array['stc_id']}'";
		}
		//查询多个店铺分类下的商品
		if(isset($condition_array['stc_id_in'])) {
			if ($condition_array['stc_id_in'] == ''){
				$condition_sql	.= " and store_class_goods.stc_id in ('') ";
			}else{
				$condition_sql	.= " and store_class_goods.stc_id in ({$condition_array['stc_id_in']})";
			}
		}
		//添加不等于某商品的条件
		if($condition_array['goods_id_diff'] != 0) {
			$condition_sql  .= " and `goods`.goods_id<> '{$condition_array['goods_id_diff']}'";
		}
		//用户中心商品列表，对店铺分类商品的显示
		if($condition_array['sub_goods_id'] != '') {
			$condition_sql	.= " and goods.goods_id IN (".$condition_array['sub_goods_id'].")";
		}
		if($condition_array['keyword'] != '') {
			$condition_sql	.= " and goods.goods_name LIKE '%".$condition_array['keyword']."%'";
		}
		if($condition_array['goods_name'] != '') {
			$condition_sql	.= " and goods_name LIKE '%".$condition_array['goods_name']."%'";
		}
		if($condition_array['like_group_name']!=''){
			$condition_sql	.= " and goods_group.group_name like '%".$condition_array['like_group_name']."%'";
		}
		if($condition_array['brand_id'] != '') {
			$condition_sql	.= " and goods.brand_id = '{$condition_array['brand_id']}'";
		}
		if($condition_array['gc_id'] != '') {
			$condition_sql	.= " and `goods`.gc_id IN (".$this->_getRecursiveClass($condition_array['gc_id']).")";
			//$condition_sql	.= " and `goods`.gc_id IN ({$condition_array['gc_id']})";
		}
		if(isset($condition_array['gc_id_in'])) {
			if ($condition_array['gc_id_in'] != ''){
				$condition_sql	.= " and `goods`.gc_id IN ({$condition_array['gc_id_in']})";
			}else{
				$condition_sql	.= " and `goods`.gc_id IN ('')";
			}
		}
		if ($condition_array['spec_goods_id'] != '') {
			$condition_sql	.= " and goods_spec.goods_id= '{$condition_array['spec_goods_id']}'";
		}
		if ($condition_array['in_spec_goods_id'] != '') {
			$condition_sql	.= " and goods_spec.goods_id in (".$condition_array['in_spec_goods_id'].")";
		}
		if(isset($condition_array['spec_id_in'])) {
			if ($condition_array['spec_id_in'] == ''){
				$condition_sql	.= " and goods_spec.spec_id in('')";
			}else {
				$condition_sql	.= " and goods_spec.spec_id in ({$condition_array['spec_id_in']})";
			}
		}
		if($condition_array['spec_id'] != '') {
			$condition_sql	.= " and goods_spec.spec_id= '{$condition_array['spec_id']}'";
		}
		if($condition_array['no_goods_id'] != ''){
			$condition_sql	.= " and goods.goods_id not in(".$condition_array['no_goods_id'].")";
		}
		if($condition_array['no_group_id'] != ''){
			$condition_sql	.= " and goods_group.group_id not in(".$condition_array['no_group_id'].")";
		}
		//商品库存充足
		if($condition_array['spec_storage_enough'] == 'yes'){
			$condition_sql	.= " and goods_spec.spec_goods_storage > 0";
		}
//		if($condition_array['goods_store_state'] == 'open'){
//			$condition_sql	.= " and goods.goods_store_state = 0";
//		}
		//商品是否是直通车商品
		if(isset($condition_array['goods_isztc'])){
			if ($condition_array['goods_isztc'] == 1){
				$condition_sql	.= " and goods.goods_isztc = 1 ";
			}else {
				$condition_sql	.= " and goods.goods_isztc = 0 ";
			}
		}
		//商品是否是直通车商品
		if($condition_array['goods_ztcstate']){
			$condition_sql	.= " and goods.goods_ztcstate = '{$condition_array['goods_ztcstate']}' ";
		}
		//商品参加直通车金币是否足够
		if(isset($condition_array['goods_ztcopen'])){
			//查询当前设置的直通车单价
			$ztc_dayprod = intval($GLOBALS['setting_config']['ztc_dayprod']);
			$datetime = date('Y-m-d',time());
			$datetime = strtotime($datetime);
			$condition_sql	.= " and goods.goods_isztc = 1 and goods.goods_ztcstartdate <= $datetime and (($datetime - goods.goods_ztclastdate)/(3600*24))*$ztc_dayprod <= goods_goldnum";
		}
		//直通车商品最后消费金币时间小于当前时间即$condition_array['lesstime']
		if ($condition_array['lesstime']){
			$condition_sql	.= " and goods.goods_ztclastdate < '{$condition_array['lesstime']}'";
		}
		if ($condition_array['spec_goods_spec'] != ''){
			$condition_sql	.= " and goods_spec.spec_goods_spec = '".$condition_array['spec_goods_spec']."'";
		}
		if ($condition_array['start_price'] > 0){
			$condition_sql	.= " and goods.goods_store_price > '".$condition_array['start_price']."'";
		}
		if ($condition_array['end_price'] > 0){
			$condition_sql	.= " and goods.goods_store_price < '".$condition_array['end_price']."'";
		}
        if (!empty($condition_array['group_flag'])){
            $condition_sql .= " and goods.group_flag = '".$condition_array['group_flag'] ."'";
        }
        if (!empty($condition_array['xianshi_flag'])){
            $condition_sql .= " and goods.group_flag <> 1 and goods.xianshi_flag = '".$condition_array['xianshi_flag'] ."'";
        }
        if ($condition_array['province_id'] != ''){
        	$condition_sql	.= " and province_id = '".$condition_array['province_id'] ."'";
        }
        if ($condition_array['goods_form'] != ''){
        	$condition_sql	.= " and goods_form = '".$condition_array['goods_form']."'";
        }
		if($condition_array['add_time_from'] != ''){
			$condition_sql	.= " and goods_add_time >= '".$condition_array['add_time_from']."'";
		}
		if($condition_array['add_time_to'] != ''){
			$condition_sql	.= " and goods_add_time <= '".$condition_array['add_time_to']."'";
		}
		return $condition_sql;
	}
}
