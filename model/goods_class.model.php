<?php
/**
 * 商品类别模型
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

class goods_classModel extends Model{
	public function __construct(){
		parent::__construct('goods_class');
	}
	/**
	 * 类别列表
	 *
	 * @param array $condition 检索条件
	 * @return array 数组结构的返回结果
	 */
	public function getClassList($condition ,$field='*'){
		$condition_str = $this->_condition($condition);
		$param = array();
		$param['table'] = 'goods_class';
		$param['field'] = $field;
		$param['where'] = $condition_str;
		$param['order'] = $condition['order'] ? $condition['order'] : 'gc_parent_id asc,gc_sort asc,gc_id asc';
		$result = Db::select($param);

		return $result;
	}

	/**
	 * 构造检索条件
	 *
	 * @param int $id 记录ID
	 * @return string 字符串类型的返回结果
	 */
	private function _condition($condition){
		$condition_str = '';

		if (!is_null($condition['gc_parent_id'])){
			$condition_str .= " and gc_parent_id = '". intval($condition['gc_parent_id']) ."'";
		}
		if (!is_null($condition['no_gc_id'])){
			$condition_str .= " and gc_id != '". intval($condition['no_gc_id']) ."'";
		}
		if ($condition['in_gc_id'] != ''){
			$condition_str .= " and gc_id in (". $condition['in_gc_id'] .")";
		}
		if ($condition['gc_name'] != ''){
			$condition_str .= " and gc_name = '". $condition['gc_name'] ."'";
		}
		if ($condition['gc_show'] != '') {
			$condition_str .= " and gc_show= '{$condition['gc_show']}'";
		}
		if (isset($condition['un_type_name'])) {
			$condition_str .= " and type_name <> ''";
		}
		if ($condition['un_type_id'] != '') {
			$condition_str .= " and type_id <> '". $condition['un_type_id'] ."'";
		}
		if ($condition['in_type_id'] != '') {
			$condition_str .= " and type_id in (".$condition['in_type_id'].")";
		}

		return $condition_str;
	}

	/**
	 * 取单个分类的内容
	 *
	 * @param int $id 分类ID
	 * @return array 数组类型的返回结果
	 */
	public function getOneGoodsClass($id){
		if (intval($id) > 0){
			$param = array();
			$param['table'] = 'goods_class';
			$param['field'] = 'gc_id';
			$param['value'] = intval($id);
			$result = Db::getRow($param);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 新增
	 *
	 * @param array $param 参数内容
	 * @return bool 布尔类型的返回结果
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
			$result = Db::insert('goods_class',$tmp);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function goodsClassUpdate($param){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$where = " gc_id = '". $param['gc_id'] ."'";
			$result = Db::update('goods_class',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 更新信息
	 *
	 * @param array $param 更新数据
	 * @return bool 布尔类型的返回结果
	 */
	public function updateWhere($param, $condition){
		if (empty($param)){
			return false;
		}
		if (is_array($param)){
			$tmp = array();
			foreach ($param as $k => $v){
				$tmp[$k] = $v;
			}
			$where = $this->_condition($condition);
			$result = Db::update('goods_class',$tmp,$where);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 删除分类
	 *
	 * @param int $id 记录ID
	 * @return bool 布尔类型的返回结果
	 */
	public function del($id){
		if (intval($id) > 0){
			$where = " gc_id = '". intval($id) ."'";
			$result = Db::delete('goods_class',$where);
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 取分类列表，最多为三级
	 *
	 * @param int $show_deep 显示深度
	 * @param array $condition 检索条件
	 * @return array 数组类型的返回结果
	 */
	public function getTreeClassList($show_deep='3',$condition=array()){
		$class_list = $this->getClassList($condition);
		$goods_class = array();//分类数组
		if(is_array($class_list) && !empty($class_list)) {
			$show_deep = intval($show_deep);
			if ($show_deep == 1){//只显示第一级时用循环给分类加上深度deep号码
				foreach ($class_list as $val) {
					if($val['gc_parent_id'] == 0) {
						$val['deep'] = 1;
						$goods_class[] = $val;
					} else {
						break;//父类编号不为0时退出循环
					}
				}
			} else {//显示第二和三级时用递归
				$goods_class = $this->_getTreeClassList($show_deep,$class_list);
			}
		}
		return $goods_class;
	}

	/**
	 * 递归 整理分类
	 *
	 * @param int $show_deep 显示深度
	 * @param array $class_list 类别内容集合
	 * @param int $deep 深度
	 * @param int $parent_id 父类编号
	 * @param int $i 上次循环编号
	 * @return array $show_class 返回数组形式的查询结果
	 */
	private function _getTreeClassList($show_deep,$class_list,$deep=1,$parent_id=0,$i=0){
		static $show_class = array();//树状的平行数组
		if(is_array($class_list) && !empty($class_list)) {
			$size = count($class_list);
			if($i == 0) $show_class = array();//从0开始时清空数组，防止多次调用后出现重复
			for ($i;$i < $size;$i++) {//$i为上次循环到的分类编号，避免重新从第一条开始
				$val = $class_list[$i];
				$gc_id = $val['gc_id'];
				$gc_parent_id	= $val['gc_parent_id'];
				if($gc_parent_id == $parent_id) {
					$val['deep'] = $deep;
					$show_class[] = $val;
					if($deep < $show_deep && $deep < 3) {//本次深度小于显示深度时执行，避免取出的数据无用
						$this->_getTreeClassList($show_deep,$class_list,$deep+1,$gc_id,$i+1);
					}
				}
				if($gc_parent_id > $parent_id) break;//当前分类的父编号大于本次递归的时退出循环
			}
		}
		return $show_class;
	}

	/**
	 * 取指定分类ID下的所有子类
	 *
	 * @param int/array $parent_id 父ID 可以单一可以为数组
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function getChildClass($parent_id,$gc_show=''){
		$condition = array('order'=>'gc_parent_id asc,gc_sort asc,gc_id asc');
		if ($gc_show != '') {//分类是否显示
			$condition['gc_show'] = intval($gc_show);
		}
		$all_class = $this->getClassList($condition);
		if (is_array($all_class)){
			if (!is_array($parent_id)){
				$parent_id = array($parent_id);
			}
			$result = array();
			foreach ($all_class as $k => $v){
				$gc_id	= $v['gc_id'];//返回的结果包括父类
				$gc_parent_id	= $v['gc_parent_id'];
				if (in_array($gc_id,$parent_id) || in_array($gc_parent_id,$parent_id)){
					$parent_id[] = $v['gc_id'];
					$result[] = $v;
				}
			}
			return $result;
		}else {
			return false;
		}
	}

	/**
	 * 取指定分类ID的导航链接
	 *
	 * @param int $id 父类ID/子类ID
	 * @return array $nav_link 返回数组形式类别导航连接
	 */
	public function getGoodsClassNav($id = 0){
		if (intval($id) > 0){
			$data = ($g = H('goods_class')) ? $g : H('goods_class',true);

			//当前分类不加超链接
			$nav_link[] = array('title'=>$data[$id]['gc_name']);
			
			//最多循环4层
			for($i=1;$i<5;$i++){
				if ($data[$id]['gc_parent_id'] == '0') break;
				$id = $data[$id]['gc_parent_id'];
				$nav_link[] = array(
					'title'=>$data[$id]['gc_name'],
					'link'=>ncUrl(array('act'=>'search','cate_id'=>$data[$id]['gc_id'])));
			}
			
			//加上 首页 商品分类导航
			$nav_link[] = array('title'=>Language::get('goods_class_index_goods_class'),'link'=>ncUrl(array('act'=>'category')));
			$nav_link[] = array('title'=>Language::get('homepage'),'link'=>SiteUrl.'/index.php');


		}else{
			//加上 首页 商品分类导航
			$nav_link[] = array('title'=>Language::get('goods_class_index_search_results'));
			$nav_link[] = array('title'=>Language::get('homepage'),'link'=>SiteUrl.'/index.php');
		}
		krsort($nav_link);
		return $nav_link;
	}

	/**
	 * 取指定分类ID的所有父级分类,供分类TAG使用
	 *
	 * @param int $id 父类ID/子类ID
	 * @return array $nav_link 返回数组形式类别导航连接
	 */
	public function getGoodsClassLineForTag($id = 0){
		if (intval($id) > 0){
			$gc_line = array();
			/**
			 * 取当前类别信息
			 */
			$class = self::getOneGoodsClass(intval($id));
			/**
			 * 是否是子类
			 */
			if ($class['gc_parent_id'] != 0){
				$parent_1 = self::getOneGoodsClass($class['gc_parent_id']);
				if ($parent_1['gc_parent_id'] != 0){
					$parent_2 = self::getOneGoodsClass($parent_1['gc_parent_id']);
					$gc_line['gc_id']		= $parent_2['gc_id'];
					$gc_line['type_id']		= $parent_2['type_id'];
					$gc_line['gc_id_1']		= $parent_2['gc_id'];
					$gc_line['gc_tag_name']	= trim($parent_2['gc_name']).'&nbsp;&gt;&nbsp;';
					$gc_line['gc_tag_value']= trim($parent_2['gc_name']).',';
				}
				$gc_line['gc_id']		= $parent_1['gc_id'];
				$gc_line['type_id']		= $parent_1['type_id'];
				if(!isset($gc_line['gc_id_1'])){
					$gc_line['gc_id_1']	= $parent_1['gc_id'];
				}else{
					$gc_line['gc_id_2']	= $parent_1['gc_id'];
				}
				$gc_line['gc_tag_name']	.= trim($parent_1['gc_name']).'&nbsp;&gt;&nbsp;';
				$gc_line['gc_tag_value'].= trim($parent_1['gc_name']).',';
			}
			$gc_line['gc_id']		= $class['gc_id'];
			$gc_line['type_id']		= $class['type_id'];
			if(!isset($gc_line['gc_id_1'])){
				$gc_line['gc_id_1']	= $class['gc_id'];
			}else if(!isset($gc_line['gc_id_2'])){
				$gc_line['gc_id_2']	= $class['gc_id'];
			}else{
				$gc_line['gc_id_3']	= $class['gc_id'];
			}
			$gc_line['gc_tag_name']	.= trim($class['gc_name']).'&nbsp;&gt;&nbsp;';
			$gc_line['gc_tag_value'].= trim($class['gc_name']).',';
		}
		$gc_line['gc_tag_name']		= trim($gc_line['gc_tag_name'],'&nbsp;&gt;&nbsp;');
		$gc_line['gc_tag_value']	= trim($gc_line['gc_tag_value'],',');
		return $gc_line;
	}

    /**
     * 商品数
     *
     */
    public function getGoodsCountById($gc_id) {
        $goods_model = Model('goods');
        $count = $goods_model->countGoods(array(
                'gc_id' => $gc_id,
//                'goods_state' => 0,
                'goods_show' => 1,
            ));
        return $count;
    }
	/**
     * 分类下商品总数
     *
     */
    public function getClassGoodsCount($gc_id) {
        $goods_model = Model('goods');
        $count = $goods_model->countGoods(array(
                'gc_id_in' => $gc_id,
                'goods_state' => 0,
                'goods_show' => 1,
        		'goods_store_state'=>'open'
            ));
        return $count;
    }

    /**
     * 取得分类关键词，方便SEO
     *
     */
	public function getKeyWords($gc_id = null){
		if (is_null($gc_id)) return false;
		$keywrods = ($seo_info = H('goods_class_seo')) ? $seo_info : H('goods_class_seo',true);
		$seo_title = $keywrods[$gc_id]['title'];
		$seo_key = '';
		$seo_desc = '';
		if ($gc_id > 0){
			if (isset($keywrods[$gc_id])){
				$seo_key .= $keywrods[$gc_id]['key'].',';
				$seo_desc .= $keywrods[$gc_id]['desc'].',';
			}
			$goods_class = ($g = H('goods_class')) ? $g : H('goods_class',true);
			if(($gc_id = $goods_class[$gc_id]['gc_parent_id']) > 0){
				if (isset($keywrods[$gc_id])){
					$seo_key .= $keywrods[$gc_id]['key'].',';
					$seo_desc .= $keywrods[$gc_id]['desc'].',';
				}
			}
			if(($gc_id = $goods_class[$gc_id]['gc_parent_id']) > 0){
				if (isset($keywrods[$gc_id])){
					$seo_key .= $keywrods[$gc_id]['key'].',';
					$seo_desc .= $keywrods[$gc_id]['desc'].',';
				}
			}
		}
		return array(1=>$seo_title,2=>trim($seo_key,','),3=>trim($seo_desc,','));
	}

}