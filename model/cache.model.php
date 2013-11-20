<?php
/**
 * 缓存操作
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
class cacheModel extends Model {
	
	public function __construct(){
		parent::__construct();
	}

	public function call($method){
		$method = '_'.strtolower($method);
		if (method_exists($this,$method)){
			return $this->$method();
		}else{
			return false;
		}
	}

	/**
	 * 基本设置
	 *
	 * @return array
	 */
	private function _setting(){
		$list =$this->table('setting')->where(true)->select();
		$array = array();
		foreach ((array)$list as $v) {
			$array[$v['name']] = $v['value'];
		}
		unset($list);
		return $array;
	}

	/**
	 * 商品分类
	 *
	 * @return array
	 */
	private function _goods_class(){

		$fields = 'gc_id,gc_name,store_id,type_id,gc_parent_id,gc_sort,gc_show';
	    $result = $this->table('goods_class')->field($fields)->where('gc_show=1')->order('gc_parent_id asc, gc_sort asc')->limit(10000)->select();
	    if (!is_array($result)) return null;

		//下一级孩子ID
		$child = array();
		//所有下级的孩子ID
		$childchild = array();
		$result_copy = $result;	//循环用到
		foreach ($result as $k=>$v) {
			//删除当前下标，少循环一次
			unset($result_copy[$k]);

			//取儿子ID
			$tmp = array();
			foreach ($result_copy as $key=>$value) {
				if ($value['gc_parent_id'] == $v['gc_id']){
					$tmp[] = $value['gc_id'];
				}
			}

			$child[$v['gc_id']] = $tmp;
			//取所有孙子ID
			$tmp = array();
			$this->get_child($result_copy,$v['gc_id'],$tmp);
			$childchild[$v['gc_id']] = $tmp;
			if (is_array($childchild[$v['gc_id']])){
				foreach ($childchild[$v['gc_id']] as $key=>$value) {
					//去除掉儿子级ID，只留孙子级ID
					if (in_array($value,$child[$v['gc_id']])) unset($childchild[$v['gc_id']][$key]);
				}
			}
			unset($tmp);
		}
		/**
		 * 生成文件
		 */
		$array = array();
		if (is_array($result)){
			foreach ((array)$result as $k => $v){
				$v['child'] = implode(',',$child[$v['gc_id']]);
				$v['childchild'] = implode(',',$childchild[$v['gc_id']]);
				$array[$v['gc_id']] = $v;
			}
		}
		return $array;	
	}

	/**
	 * 商品分类SEO
	 *
	 * @return array
	 */
	private function _goods_class_seo(){

		$list = $this->table('goods_class')->field('gc_id,gc_title,gc_keywords,gc_description')->where(array('gc_keywords'=>array('neq','')))->limit(2000)->select();
		if (!is_array($list)) return null;
		$array = array();
		foreach ($list as $k=>$v) {
			if ($v['gc_title'] != '' || $v['gc_keywords'] != '' || $v['gc_description'] != ''){
				if ($v['gc_name'] != ''){
					$array[$v['gc_id']]['name'] = $v['gc_name'];
				}
				if ($v['gc_title'] != ''){
					$array[$v['gc_id']]['title'] = $v['gc_title'];
				}
				if ($v['gc_keywords'] != ''){
					$array[$v['gc_id']]['key'] = $v['gc_keywords'];
				}
				if ($v['gc_description'] != ''){
					$array[$v['gc_id']]['desc'] = $v['gc_description'];
				}
			}
		}
		return $array;
	}
	
	/**
	 * 商城主要频道SEO
	 *
	 * @return array
	 */
	private function _seo(){
		$list =$this->table('seo')->where(true)->select();
		if (!is_array($list)) return null;
		$array = array();
		foreach ($list as $key=>$value){
			$array[$value['type']] = $value;
		}
		return $array;
	}
	
	/**
	 * 友情连接
	 *
	 * @return array
	 */
	private function _link(){
		$list = $this->table('link')->where(true)->order('link_sort')->select();
		if (!is_array($list)) return null;
		foreach ($list as $key=>$value){
			if($value['link_pic'] != ''){
				$list[$key]['link_pic']  = ATTACH_LINK.DS.$value['link_pic'];	
			}
		}
		return $list;
	}
	
	/**
	 * 快递公司
	 *
	 * @return array
	 */
	private function _express(){
	    $fields = 'id,e_name,e_code,e_letter,e_order,e_url';
		$list = $this->table('express')->field($fields)->order('e_order,e_letter')->where(array('e_state'=>1))->select();
		if (!is_array($list)) return null;
		$array = array();
		foreach ($list as $k=>$v) {
			$array[$v['id']] = $v;
		}
		return $array;
	}

	/**
	 * 自定义导航
	 *
	 * @return array
	 */
	private function _nav(){
		$list = $this->table('navigation')->order('nav_sort')->select();
		if (!is_array($list)) return null;
		return $list;
	}
	
	/**
	 * 团购地区、分类、价格区间
	 *
	 * @return array
	 */
	private function _groupbuy(){
		$area = $this->table('groupbuy_area')->where('area_parent_id=0')->order('area_sort')->select();
		if (!is_array($area)) $area = array();

		$category = $this->table('groupbuy_class')->where('class_parent_id=0')->order('sort')->select();
		if (!is_array($category)) $category = array();

		$price = $this->table('groupbuy_price_range')->order('range_start')->select();
		if (!is_array($price)) $price = array();

		return array('area'=>$area,'category'=>$category,'price'=>$price);
	}
	
	/**
	 * 商品TAG
	 *
	 * @return array
	 */
	private function _class_tag(){
		$field = 'gc_tag_id,gc_tag_name,gc_tag_value,gc_id,type_id';
		$list = $this->table('goods_class_tag')->field($field)->where(true)->select();
		if (!is_array($list)) return null;
		return $list;
	}
	
	/**
	 * 店铺分类
	 *
	 * @return array
	 */
	private function _store_class(){
		$list = $this->table('store_class')->where(true)->order('sc_parent_id,sc_sort')->select();
		$tmp = array();
		if (is_array($list)){
			foreach ($list as $key => $value) {
				$tmp[$value['sc_id']]['sc_name'] = $value['sc_name'];
				$tmp[$value['sc_id']]['sc_parent_id'] = $value['sc_parent_id'];
				foreach ($list as $k => $v) {
					if ($v['sc_parent_id'] == $value['sc_id']){
						$tmp[$value['sc_id']]['child'][] = $v['sc_id'];
					}
				}
				unset($list[$key]);
			}
		}
		return $tmp;
	}

	/**
	 * 店铺等级
	 *
	 * @return array
	 */
	private function _store_grade(){
		$list =$this->table('store_grade')->where(true)->select();
		$array = array();
		foreach ((array)$list as $v) {
			$array[$v['sg_id']] = $v;
		}
		unset($list);
		return $array;
	}
	


	/**
	 * 递归取某个分类下的所有子类ID组成的字符串,以逗号隔开
	 *
	 * @param string $goodsclass 商品分类
	 * @param int $gc_id	待查找子类的ID
	 * @param string $child 存放被查出来的子类ID
	 */
	private function get_child(&$goodsclass,$gc_id,&$child){
		foreach ($goodsclass as $k=>$v) {
			if ($v['gc_parent_id'] == $gc_id){
				$child[] = $v['gc_id'];
				$this->get_child($goodsclass,$v['gc_id'],$child);
			}
		}
	}
}