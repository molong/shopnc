<?php
/**
 * 页面模块
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
class web_configModel extends Model{
	/**
	 * 读取模块内容记录
	 *
	 * @param
	 * @return array 数组格式的返回结果
	 */
	public function getCodeRow($code_id,$web_id){
		$param = array();
		$param['code_id']	= $code_id;
		$param['web_id']	= $web_id;
		$result	= $this->table('web_code')->where($param)->find();
		return $result;
	}
	
	/**
	 * 读取模块内容记录列表
	 *
	 * @param 
	 * @return array 数组格式的返回结果
	 */
	public function getCodeList($condition = array()){
		$param = array();
		$param['web_id'] = array('in',$condition['web_id']);
		$result = $this->table('web_code')->where($param)->order('web_id')->select();
		return $result;
	}
	
	/**
	 * 更新模块内容信息
	 *
	 * @param 
	 * @return bool 布尔类型的返回结果
	 */
	public function updateCode($condition,$data){
		$code_id = $condition['code_id'];
		if (intval($code_id) < 1){
			return false;
		}
		if (is_array($data)){
			$result = $this->table('web_code')->where($condition)->update($data);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 读取广告位记录列表
	 *
	 * @param 
	 * @return array 数组格式的返回结果
	 */
	public function getAdvList($type = 'adv'){
		$condition = array();
		$condition['act'] = array(
			'ap_class' => '0',//图片
			'is_use' => '1',//启用
			'ap_width' => '208',//宽度
			'ap_height' => '128'//高度
			);
		$condition['adv'] = array(
			'ap_class' => '0',//图片
			'is_use' => '1',//启用
			'ap_width' => '220',//宽度
			'ap_height' => '100'//高度
			);
		
		$result = $this->table('adv_position')->where($condition[$type])->order('ap_id')->select();
		return $result;
	}
	/**
	 * 读取记录列表
	 *
	 * @param 
	 * @return array 数组格式的返回结果
	 */
	public function getWebList($condition = array(),$page = ''){
		$result = $this->table('web')->where($condition)->order('web_sort')->select();
		return $result;
	}
	
	/**
	 * 更新模块信息
	 *
	 * @param 
	 * @return bool 布尔类型的返回结果
	 */
	public function updateWeb($condition,$data){
		$web_id = $condition['web_id'];
		if (intval($web_id) < 1){
			return false;
		}
		if (is_array($data)){
			$result = $this->table('web')->where($condition)->update($data);
			return $result;
		}else {
			return false;
		}
	}
	
	/**
	 * 更新模块html信息
	 *
	 */
	public function updateWebHtml($web_id = 1,$style_name = 'orange'){
		$web_html = '';
		$code_list = $this->getCodeList(array('web_id'=>"$web_id"));
		if(!empty($code_list) && is_array($code_list)) {
			Language::read('web_config,home_index_index');
			$lang = Language::getLangContent();
			$output = array();
			$output['style_name'] = $style_name;	
			foreach ($code_list as $key => $val) {
				$var_name = $val["var_name"];
				$code_info = $val["code_info"];
				$code_type = $val["code_type"];
				$val['code_info'] = $this->get_array($code_info,$code_type);
				$output['code_'.$var_name] = $val;	
			}
			$style_file = BasePath.DS.'resource'.DS.'web_config'.DS."default.php";
			if (file_exists($style_file)) {        
				ob_start();
        include $style_file;        
        $web_html = ob_get_contents();
        ob_end_clean();
			}
			$web_array = array();
			$web_array['web_html'] = addslashes($web_html);
			$web_array['update_time'] = time();
			$this->updateWeb(array('web_id'=>$web_id),$web_array);
		}
		return $web_html;
	}
	/**
	 * 模块html信息
	 *
	 */
	public function getWebHtml($web_page = 'index',$update_all = 0){
		$web_html = '';
		$web_list = $this->getWebList(array('web_show'=>1,'web_page'=>$web_page));
		if(!empty($web_list) && is_array($web_list)) {
			foreach($web_list as $k => $v){
				if ($update_all == 1 || empty($v['web_html'])) {//强制更新或内容为空时查询数据库
					$web_html .= $this->updateWebHtml($v['web_id'],$v['style_name']);
				}else {
					$web_html .= $v['web_html'];
				}
			}
		}
		return $web_html;
	}
	/**
	 * 主题样式名称
	 *
	 */
	public function getStyleList($style_id = 'index'){
		$style_data = array(
			'red' => Language::get('web_config_style_red'),
			'pink' => Language::get('web_config_style_pink'),
			'orange' => Language::get('web_config_style_orange'),
			'green' => Language::get('web_config_style_green'),
			'blue' => Language::get('web_config_style_blue'),
			'purple' => Language::get('web_config_style_purple'),
			'brown' => Language::get('web_config_style_brown'),
			'gray' => Language::get('web_config_style_gray')
			);
		$result['index']	= $style_data;
		return $result[$style_id];
	}
	
	/**
	 * 转换字符串
	 */
	public function get_array($code_info,$code_type){
		$data = '';
		switch ($code_type) {
	    case "array":
	    	if(is_string($code_info)) $code_info = unserialize($code_info);
	    	if(!is_array($code_info)) $code_info = array();
	    	$data = $code_info;
	      break;
	    case "html":
	    	if(!is_string($code_info)) $code_info = '';
	    	$data = $code_info;
	    	break;
	    default:
	    	$data = '';
		}
		return $data;
	}
	
	/**
	 * 转换数组
	 */
	public function get_str($code_info,$code_type){
		$str = '';
		switch ($code_type) {
	    case "array":
	    	if(!is_array($code_info)) $code_info = array();
	    	$code_info = $this->stripslashes_deep($code_info);
	    	$str = serialize($code_info);
	    	$str = addslashes($str);
	      break;
	    case "html":
	    	if(!is_string($code_info)) $code_info = '';
	    	$str = $code_info;
	    	break;
	    default:
	    	$str = '';
		}
		return $str;
	}
	/**
	 * 递归去斜线
	 */
	public function stripslashes_deep($value){
	    $value = is_array($value) ? array_map(array($this,'stripslashes_deep'), $value) : stripslashes($value);
	    return $value;
	}
	
}