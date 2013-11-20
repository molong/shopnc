<?php
/**
 * 卖家管理
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
class storeModel extends Model {
    public function __construct(){
        parent::__construct('store');
    }
    /**
     * 创建店铺
     *
     * @param	array $param	条件数组
     */	
    public function createStore($param) {
        if(empty($param)) {
            return false;
        }
        $shop_array		= array();
        $shop_array['grade_id']		= intval($param['grade_id']);
        $shop_array['store_owner_card']	= trim($param['store_owner_card']);
        $shop_array['store_name']	= trim($param['store_name']);
        $shop_array['member_id']	= $_SESSION['member_id'];
        $shop_array['member_name']	= $_SESSION['member_name'];
        $shop_array['sc_id']		= intval($param['sc_id']);
        $shop_array['area_id']		= trim($param['area_id']);
        $shop_array['area_info']	= trim($param['area_info']);
        $shop_array['store_address']= trim($param['store_address']);
        $shop_array['store_zip']	= trim($param['store_zip']);
        $shop_array['store_tel']	= trim($param['store_tel']);
        $shop_array['store_zy']		= trim($param['store_zy']);
        $shop_array['name_auth']	= intval($param['name_auth']);
        $shop_array['store_auth']	= intval($param['store_auth']);
        $shop_array['store_image']	= trim($param['store_image']);
        $shop_array['store_image1']	= trim($param['store_image1']);
        $shop_array['store_state']	= intval($param['store_state']);
        $shop_array['store_time']	= time();

        $result	= Db::insert('store',$shop_array);
        if ($result) {
            Db::update('member',array('store_id'=>$result),"WHERE member_id='{$_SESSION['member_id']}'");
            return $result;
        } else {
            return false;
        }
    }
    /**
     * 设置店铺
     *
     * @param	array $param	条件数组
     */	
    public function setStore($param) {
        if (empty($param)){
            return false;
        }

        $tmp = array(
            'store_name'=>$param['store_name'],
            'area_id'=>$param['area_id'],
            'area_info'=>$param['area_info'],
            'store_address'=>$param['store_address'],
            'store_label'=>empty($param['store_label'])?$param['store_old_label']:$param['store_label'],
            'store_banner'=>empty($param['store_banner'])?$param['store_old_banner']:$param['store_banner'],
            'store_logo'=>empty($param['store_logo'])?$param['store_old_logo']:$param['store_logo'],
            'store_tel'=>$param['store_tel'],
            'store_qq'=>$param['store_qq'],
            'store_ww'=>$param['store_ww'],
            'store_zy'=>$param['store_zy'],
            'description'=>$param['description'],
            'store_domain'=>$param['store_domain'],
            'store_keywords'=>$param['seo_keywords'],
            'store_description'=>$param['seo_description']
        );
        if (!empty($param['store_theme'])){
            $tmp['store_theme'] = $param['store_theme'];
        }
        if (empty($tmp['store_domain'])) unset($tmp['store_domain']);
        $where = " store_id = '". $param['store_id'] ."'";
        $result = Db::update('store',$tmp,$where);
        return $result;
    }
    /**
     * 获取店铺信息
     *
     * @param	array $param 店铺条件
     * @param	string $field 显示字段
     * @return	array 数组格式的返回结果
     */
    public function shopStore($param,$field='*') {
        if(empty($param)) {
            return false;
        }
        //得到条件语句
        $condition_str	= $this->getCondition($param);
        $param	= array();
        $param['table']	= 'store';
        $param['where']	= $condition_str;
        $param['field']	= $field;
        $param['limit'] = 1;
        $store_info	= Db::select($param);
        return $store_info[0];
    }
    /**
     * 获取店铺信息总数
     *
     * @param	array $param 店铺条件
     * @param	string $field 显示字段
     * @return	array 数组格式的返回结果
     */	
    public function countStore($param){
        $condition_str = $this->getCondition($param);
        $array	= array();
        $array['table']	= 'store';
        $array['where'] = $condition_str;
        $array['field'] = 'count(store_id)';
        $goods_array	= Db::select($array);
        return $goods_array[0][0];
    }
    /**
     * 将条件数组组合为SQL语句的条件部分
     *
     * @param	array $conditon_array
     * @return	string
     */
    private function getCondition($conditon_array){
        $condition_sql = '';

        if($conditon_array['store_recommend'] != '') {
            $condition_sql	.= " and `store`.store_recommend = '{$conditon_array['store_recommend']}'";
        }
        if($conditon_array['store_state'] != '') {
            $condition_sql	.= " and `store`.store_state = '{$conditon_array['store_state']}'";
        }
        if($conditon_array['friend_list'] != '') {
            $condition_sql	.= " and `store`.member_name IN (".$conditon_array['friend_list'].")";
        }
        if($conditon_array['store_name'] != '') {
            $condition_sql	.= " and `store`.store_name='".$conditon_array['store_name']."'";
        }
        if($conditon_array['store_id'] != '') {
            $condition_sql	.= " and `store`.store_id='{$conditon_array['store_id']}'";
        }
        if($conditon_array['member_id'] != '') {
            $condition_sql	.= " and `store`.member_id='{$conditon_array['member_id']}'";
        }
        if($conditon_array['store_id_in'] != ''){
            $condition_sql	.= " and `store`.store_id in (".$conditon_array['store_id_in'].")";
        }
        if($conditon_array['like_owner_and_name'] != '') {
            $condition_sql	.= " and member_name like '%".$conditon_array['like_owner_and_name']."%'";
        }
        if($conditon_array['like_store_name'] != '') {
            $condition_sql	.= " and `store`.store_name like '%".$conditon_array['like_store_name']."%'";
        }
        if($conditon_array['grade_id'] != '') {
            $condition_sql	.= " and `store`.grade_id='".$conditon_array['grade_id']."'";
        }
        if(isset($conditon_array['grade_id_in'])) {
            if ($conditon_array['grade_id_in'] == ''){
                $condition_sql	.= " and `store`.grade_id in ('')";
            } else {
                $condition_sql	.= " and `store`.grade_id in ({$conditon_array['grade_id_in']})";
            }
        }
        if($conditon_array['area_id'] != '') {
            $condition_sql	.= " and `store`.area_id = '".$conditon_array['area_id']."'";
        }
        if($conditon_array['in_area_id'] != '') {
            $condition_sql	.= " and `store`.area_id in (".$conditon_array['in_area_id'].")";
        }
        if($conditon_array['sc_id'] != '') {
            $condition_sql	.= " and `store`.sc_id = '".$conditon_array['sc_id']."'";
        }
        if(isset($conditon_array['sc_id_in'])) {
            if ($conditon_array['sc_id_in'] == ''){
                $condition_sql	.= " and `store`.sc_id in ('') ";
            }else {
                $condition_sql	.= " and `store`.sc_id in({$conditon_array['sc_id_in']})";
            }
        }
        if($conditon_array['store_domain'] != '') {
            $condition_sql	.= " and `store`.store_domain = '".$conditon_array['store_domain']."'";
        }
        if ($conditon_array['lt_store_end_time'] != ''){
            $condition_sql	.= " and (`store`.store_end_time > 0 and `store`.store_end_time<'".$conditon_array['lt_store_end_time']."')";
        }
        if($conditon_array['like_store_domain'] != '') {
            $condition_sql	.= " and `store`.store_domain like '%".$conditon_array['like_store_domain']."%'";
        }
        if($conditon_array['store_domain_not_null'] != '') {
            $condition_sql	.= " and `store`.store_domain <> ''";
        }
        return $condition_sql;
    }

    /**
     * 店铺列表
     *
     * @param array $condition 检索条件
     * @param obj 分页对象
     * @return array 数组形式的返回结果
     */
    public function getStoreList($condition,$page = '',$type = 'simple'){
        $condition_str = $this->getCondition($condition);
        $param = array();
        $param['where'] = $condition_str;
        switch ($type){
        case 'store_class':
            $param['table'] = 'store,store_class';
            $param['join_type']= 'INNER JOIN';
            $param['join_on']= array('store.sc_id = store_class.sc_id');
            break;
        default:
            $param['table'] = 'store';
            break;
        }
        $param['field'] = $condition['field'];
        $param['order'] = $condition['order'] ? $condition['order'] : 'store.store_id desc';
        $param['group'] = $condition['group'];
        $param['limit'] = $condition['limit'];
        $result = Db::select($param,$page);
        return $result;
    }

    /**
     * 新增
     *
     * @param array $param 参数
     * @return array $rs_row 返回数组形式的查询结果
     */
    public function add($param){
        if (empty($param)){
            return false;
        }
        if (is_array($param)){
            $tmp = array();
            foreach ($param as $k => $v){
                $tmp[$k] = $v;
            }
            $result = Db::insert('store',$tmp);
            return $result;
        }else {
            return false;
        }
    }
    /**
     * 更新
     *
     * @param array $param 参数
     * @return array $rs_row 返回数组形式的查询结果
     */
    public function storeUpdate($param){
        if (empty($param)){
            return false;
        }
        if (is_array($param)){
            $tmp = array();
            foreach ($param as $k => $v){
                $tmp[$k] = $v;
            }
            $where = " store_id = '". $param['store_id'] ."'";
            $result = Db::update('store',$tmp,$where);
            return $result;
        }else {
            return false;
        }
    }
    /**
     * 根据条件更新
     *
     * @param array $param 参数
     * @return array $rs_row 返回数组形式的查询结果
     */
    public function updateByCondtion($param,$condition){
        if (empty($param)){
            return false;
        }
        $condition_str = $this->getCondition($condition);
        return Db::update('store',$param,$condition_str);
    }
    /**
     * 删除店铺
     *
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function del($id){
        if (intval($id) > 0){
            $store_array = $this->shopStore(array('store_id'=>intval($id)));
            /**
             * 删除店铺相关图片
             */
            @unlink(BasePath.DS.ATTACH_AUTH.DS.$store_array['store_image']);
            @unlink(BasePath.DS.ATTACH_AUTH.DS.$store_array['store_image1']);
            @unlink(BasePath.DS.ATTACH_STORE.DS.$store_array['store_label']);
            @unlink(BasePath.DS.ATTACH_STORE.DS.$store_array['store_banner']);
            @unlink(BasePath.DS.ATTACH_STORE.DS.$store_array['store_logo']);
            if($store_array['store_code'] != 'default_qrcode.png')
                @unlink(BasePath.DS.ATTACH_STORE.DS.$store_array['store_code']);
            if($store_array['store_slide'] != ''){
                foreach(explode(',', $store_array['store_slide']) as $val){
                    @unlink(BasePath.DS.ATTACH_SLIDE.DS.$val);
                }
            }
            $where = " store_id = '". intval($id) ."'";
            $result = Db::delete('store',$where);
            return $result;
        }else {
            return false;
        }
    }

    /**
     * 根据编号获取单个内容
     *
     * @param int
     * @return array 数组类型的返回结果
     */
    public function getOne($id){
        if (intval($id) > 0){
            $param = array();
            $param['table'] = 'store'; 
            $param['field'] = 'store_id';
            $param['value'] = intval($id);
            $result = Db::getRow($param);
            return $result;
        }else {
            return FALSE;
        }
    }

    /**
     * 删除用户收藏店铺
     *
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function favorites_store_del($id){
        if (intval($id) > 0){
            $where = " fav_type='store' and fav_id = '".intval($id)."' ";
           $result = Db::delete('favorites',$where);
            return $result;
        }else {
            return false;
        }
    }	

    /**
     * 获取商品销售排行
     *
     * @param int $goods_num 显示的商品排行数目
     * @return array	商品信息
     */
    public function getOrderGoodsRank($goods_num,$id,$type='') {
        $array		= array();
        $array['table'] = 'goods';
        $array['field']	= 'goods.goods_id,goods.store_id,goods.goods_name,goods.goods_store_price,goods.goods_image,goods.salenum,goods.goods_collect';
        $array['where']	= ' where goods.goods_show = 1 and goods.store_id='.$id;//上架,商品状态(非禁售),商品所在店铺状态(0正常,1关闭),售出数量
        $array['order'] = ' salenum DESC';
        if($type == 'collect'){
            $array['order'] = ' goods_collect desc';
        }else{
            $array['order']	= ' salenum desc';
        }
        $array['limit'] = $goods_num;
        $goods_rank		= Db::select($array);

        return $goods_rank;
    }

	/**
	 * 获取推荐店铺信息
	 *
	 * @param int $count 店铺数量
	 * @return array	店铺数组信息
	 */	
    public function getRecommendStore($count = 3) {
        $condition = array();
        $condition['store_recommend'] = 1;
        $condition['store_state'] = 1;
        return $this->getCacheStore($count,'store',$condition,'store_id desc');
    }

	/**
	 * 获取收藏店铺信息
	 *
	 * @param int $count 店铺数量
	 * @return array	店铺数组信息
	 */	
    public function getFavoritesStore($count = 3) {
        $condition = array();
        $condition['store_collect'] = array('gt',0);
        $condition['store_state'] = 1;
        return $this->getCacheStore($count,'favorites_store',$condition,$order = 'store_collect desc');
    }

	/**
	 * 获取最新店铺信息
	 *
	 * @param int $count 店铺数量
	 * @return array	店铺数组信息
	 */	
    public function getNewStore($count = 3) {
        $condition = array();
        $condition['store_state'] = 1;
        return $this->getCacheStore($count,'new_store',$condition,'store_id desc');
    }


	/**
	 * 获取缓存店铺信息
	 *
	 * @param int $count 推荐店铺数目
	 * @return array	店铺数组信息
	 */	
	public function getCacheStore($count = 3,$cache_name,$condition,$order) {
        $list = F($cache_name,'','cache/index');
        if (!$list){
            $field = 'store_id,store_name,member_name,store_domain,store_credit,store_logo';
            $list = $this->field($field)->where($condition)->order($order)->limit(5)->select();
            if(!empty($list)) {
                foreach ($list as $key=>$value) {
                    $value['store_logo'] = getStoreLogo($value['store_logo']);
                    $value['credit_arr'] = getCreditArr($value['store_credit']);
                    $list[$key] = $value;
                }
                $list = $this->getGoodsCountByStoreArray($list);
            }
            F($cache_name,$list,'cache/index');
        }
        if(count($list) <= $count) {
            return $list;
        } else {
            return array_slice($list,0,$count);
        }
    }

    /**
     * 获取店铺商品数 
     *
     * @param array $store_array 店铺数组
     * @return array $store_array 包含商品数goods_count的店铺数组 
     */
    public function getGoodsCountByStoreArray($store_array) {
        $store_array_new = array();
        $model = Model();
        $no_cache_store = '';
        foreach ($store_array as $value) {
            $goods_count = rcache($value['store_id'],'store_goods_count');
            if($goods_count !== FALSE) {
                //有缓存的直接赋值
                $value['goods_count'] = $goods_count;
            } else {
                //没有缓存记录store_id，统计从数据库读取
                $no_cache_store .= $value['store_id'].',';
                $value['goods_count'] = '0';
            }
            $store_array_new[$value['store_id']] = $value;
        }
        if(!empty($no_cache_store)) {
            //从数据库读取店铺商品数赋值并缓存
            $no_cache_store = rtrim($no_cache_store,',');
            $condition = array();
            $condition['goods_show'] = '1';
            $condition['store_id'] = array('in',$no_cache_store);
            $goods_count_array = $model->table('goods')->field('store_id,count(*) as goods_count')->where($condition)->group('store_id')->select();
            if (!empty($goods_count_array)){
                foreach ($goods_count_array as $value){
                    $store_array_new[$value['store_id']]['goods_count'] = $value['goods_count'];
                    wcache($value['store_id'],$value['goods_count'],'store_goods_count');
                }
            }
        }
        return $store_array_new;
    }

    /**
     * 获得店铺标志、信用、商品数量、店铺评分等信息
     * 
     * @param	array $param 店铺数组
     * @return	array 数组格式的返回结果
     */
    public function getStoreInfoBasic($list,$day = 0){
        $list_new = array();
        if (!empty($list) && is_array($list)){
            foreach ($list as $key=>$value) {
                if(!empty($value)) {
                    $value['store_logo'] = getStoreLogo($value['store_logo']);
                    $value['credit_arr'] = getCreditArr($value['store_credit']);
                    $value['store_desccredit_rate'] = @round($value['store_desccredit']/5*100,2);
                    $value['store_servicecredit_rate'] = @round($value['store_servicecredit']/5*100,2);
                    $value['store_deliverycredit_rate'] = @round($value['store_deliverycredit']/5*100,2);
                    if(!empty($value['store_presales'])) $value['store_presales'] = unserialize($value['store_presales']);
                    if(!empty($value['store_aftersales'])) $value['store_aftersales'] = unserialize($value['store_aftersales']);
                    $list_new[$value['store_id']] = $value;
                    $list_new[$value['store_id']]['goods_count'] = 0;
                }
            }
            //全部商品数直接读取缓存
            if($day > 0) {
                $store_id_string = implode(',',array_keys($list_new)); 
                //指定天数直接查询数据库
                $condition = array();
                $condition['goods_show'] = '1';
                $condition['store_id'] = array('in',$store_id_string);
                $condition['goods_add_time'] = array('gt',strtotime("-{$day} day"));
                $model = Model();
                $goods_count_array = $model->table('goods')->field('store_id,count(*) as goods_count')->where($condition)->group('store_id')->select();
                if (!empty($goods_count_array)){
                    foreach ($goods_count_array as $value){
                            $list_new[$value['store_id']]['goods_count'] = $value['goods_count'];
                    }
                }
            } else {
                $list_new = $this->getGoodsCountByStoreArray($list_new);
            }
        }
        return $list_new;
    }

    /**
     * 获取店铺列表页附加信息
     *
     * @param array $store_array 店铺数组
     * @return array $store_array 包含近期销量和8个推荐商品的店铺数组 
     */
    public function getStoreSearchList($store_array) {
        $store_array_new = array();
        if(!empty($store_array)){
            $model = Model();
            $no_cache_store = array();
            foreach ($store_array as $value) {
                $store_search_info = rcache($value['store_id'],'store_search_info');
                if($store_search_info !== FALSE) {
                    $store_array_new[$value['store_id']] = $store_search_info;
                } else {
                    $no_cache_store[$value['store_id']] = $value;
                }
            }
            if(!empty($no_cache_store)) {
                //获取店铺商品数
                $no_cache_store = $this->getStoreInfoBasic($no_cache_store);
                //获取店铺近期销量
                $no_cache_store = $this->getGoodsCountJq($no_cache_store);
                //获取店铺推荐商品
                $no_cache_store = $this->getGoodsListBySales($no_cache_store);
                //写入缓存
                foreach ($no_cache_store as $value) {
                    wcache($value['store_id'],$value,'store_search_info');
                }
                $store_array_new = array_merge($store_array_new,$no_cache_store);
            }
        }
        return $store_array_new;
    }

    //获取近期销量
    private function getGoodsCountJq($store_array) {
        $model = Model();
        $order_count_array = $model->table('order')->field('store_id,count(*) as order_count')->where(array('store_id'=>array('in',implode(',',array_keys($store_array))),'add_time'=>array('gt',TIMESTAMP-3600*24*90)))->group('store_id')->select();
        foreach ((array)$order_count_array as $value) {
            $store_array[$value['store_id']]['num_sales_jq'] = $value['order_count'];
        }
        return $store_array;
    }

    //获取店铺8个销量最高商品
    private function getGoodsListBySales($store_array) {
        $model = Model();
        $field = 'goods_id,store_id,goods_name,goods_image,goods_store_price,salenum';
        foreach ($store_array as $value) {
            $store_array[$value['store_id']]['search_list_goods'] = $model->table('goods')->field($field)->where(array('store_id'=>$value['store_id'],'goods_show'=>1))->order('salenum desc')->limit(8)->select();
        }
        return $store_array;
    }

    /**
     * 获取店铺详细页店铺详细信息 
     *
     * @param array $store_array 店铺数组
     * @return array $store_array 包含商品数goods_count的店铺数组 
     */
    public function getStoreInfoDetail($store_info) {
        $store_info_detail = rcache($store_info['store_id'],'store_detail_info');
        if($store_info_detail === FALSE) {

            $model = Model();

            //获取店铺基本信息
            $store_info_detail_array = $this->getStoreInfoBasic(array($store_info));
            $store_info_detail = $store_info_detail_array[$store_info['store_id']];

            //得到店铺等级信息
            $store_grade_info = $model->table('store_grade')->where(array('sg_id'=>$store_info['grade_id']))->find();
            $store_info_detail['grade_name'] = $store_grade_info['sg_name'];
            $store_info_detail['grade_goodslimit'] = $store_grade_info['sg_goods_limit'];

            //处理地区信息
            $area_array	= array();
            $area_array = explode("\t",$store_info["area_info"]);
            $map_city	= Language::get('member_map_city');
            $city	= '';
            if(strpos($area_array[0], $map_city) !== false){
                $city	= $area_array[0];
            }else {
                $city	= $area_array[1];
            }
            $store_info_detail['city'] = $city;

            //查询店铺地图信息
            $map_info = $model->table('map')->where(array('store_id'=>$store_info['store_id'],'map_api'=>'baidu'))->order('map_id desc')->find();
            $store_info_detail['map'] = array('point_lng'=>$map_info['point_lng'],'point_lat'=>$map_info['point_lat']);

            //得到店铺导航信息
            $store_navigation_list = $model->table('store_navigation')->where(array('sn_store_id'=>$store_info['store_id'],'sn_if_show'=>1))->order('sn_sort')->select();
            if (!empty($store_navigation_list)){
                foreach ($store_navigation_list as $k=>$v){
                    unset($v['sn_content']);
                    $store_info_detail['nav'][] = $v;
                }
            }

            //商品销售排行
            $hot_sales	= $this->getOrderGoodsRank(5,$store_info['store_id']);
            $store_info_detail['hot_sales'] = $hot_sales;

            //商品收藏排行
            $hot_collect	= $this->getOrderGoodsRank(5,$store_info['store_id'],'collect');
            $store_info_detail['hot_collect'] = $hot_collect; 

            //得到商品分类信息
            $goodsclass_model = Model('my_goods_class');
            $goods_class_list = $goodsclass_model->getShowTreeList($store_info['store_id']);
            $store_info_detail['goods_class_list'] = $goods_class_list;

            wcache($store_info['store_id'],$store_info_detail,'store_detail_info');
        }
        return $store_info_detail;
    }
}
