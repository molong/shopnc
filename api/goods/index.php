<?php
/**
 * 商品调用文件(外站或由管理员手动添加到模板页面调用)
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
require_once(dirname(__FILE__).'/../api_global.php'); 

class goods extends APIControl {
	/**
	 * 配置信息
	 */
	public $config = array();
	
	public function __construct(){
		parent::__construct();
		$this->readLanguage('common,home_index_index');
		$this->setHeader();
		$config = array();
		$config['recommend_id'] = '1';
		$config['css_class'] = 'showcase';
		$config['limit'] = '10';
		$config['width'] = '160';
		$config['height'] = '160';
		$this->config = $config;
	}
	
	/**
	 * 商品详细页地址
	 */
	public function href($goods_id,$store_id){
		return SiteUrl.'/index.php?act=goods&goods_id='.$goods_id;
	}
	
	/**
	 * 拼接数据
	 */
	public function html($goods_list,$config){
		$goods_html = '<div class="'.$config['css_class'].'" id="'.$config['css_class'].'_'.$config['recommend_id'].'">';
		$goods_html .= '<ul class="goods">';
		foreach($goods_list as $val) {
			$val = $this->getGoodsImage($val);
			$goods_html .= '<li class="c1"><dl><dt><div class="pic">';
			$goods_html .= '<a href="'.$this->href($val['goods_id'],$val['store_id']);
			$goods_html .= '" target="_blank">';
			$goods_html .= '<img src="'.$val['goods_image'].'" width="'.$config['width'].'" height="'.$config['height'].'" alt="'.$val['goods_name'];
			$goods_html .= '"/></a></div>';
			$goods_html .= '<div class="name"><a href="'.$this->href($val['goods_id'],$val['store_id']).'" title="'.$val['goods_name'].'" target="_blank">'.$val['goods_name'];
			$goods_html .= '</a></div></dt>';
			$goods_html .= '<dd class="price">'.$this->getLanguage('index_index_store_goods_price').': <span>'.$this->getLanguage('currency').$val['goods_store_price'];
			$goods_html .= '</span></dd></dl>';
			$goods_html .= '</li>';
		}
		$goods_html .= '</ul>';
		$goods_html .= '</div>';
		return $goods_html;
	}
	
	/**
	 * 输出商品数据
	 */
	public function js(){
		$g_id	= intval($_GET['id']);
		if ($g_id > 0){
			$model_recommend	= $this->getModel('recommend');
			$recommend_array = $model_recommend->getOneRecommend($g_id);
			if (!empty($recommend_array)){
				$recommend_config = array();
				$recommend_config	= unserialize($recommend_array['recommend_config']);
				if (empty($recommend_array['recommend_config']) || empty($recommend_config)) $recommend_config = $this->config;
				$recommend_config['recommend_id'] = $g_id;
				$goods_html = '';
				$condition = array();
				$condition['recommend_id'] = $g_id;
				$condition['goods_show'] = '1';//上架:1是,0否
				$condition['goods_state'] = '0';//禁售:1是,0否
				$condition['goods_store_state'] = '0';//店铺状态:1关闭,0正常
				$condition['limit']	= $recommend_config['limit'];
				$goods_list = $model_recommend->getGoodsList($condition);//查询最新的价格信息(如果使用缓存则可能出现不正确情况)
				if (!empty($goods_list)) $goods_html = $this->html($goods_list,$recommend_config);
				echo 'document.write(\''.$goods_html.'\');';
				exit;
			}
		}
	}
}

$goods = new goods();
$goods->js();
?>