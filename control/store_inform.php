<?php
/**
 * 代金券
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
class store_informControl extends BaseMemberStoreControl{
	
	public function __construct() {
	
		parent::__construct() ;
		/**
		 * 读取语言包
		 */
		Language::read('member_layout,member_inform');

	}
    	
	/*
	 * 默认显示代金券模版列表
	 */
	public function indexOp() {

        $this->inform_listOp() ;
    }

	/*
	 * 获取举报列表 
	 */
    public function inform_listOp() {

		/*
		 * 生成分页
		 */
		$page = new Page() ;
		$page->setEachNum(10);
		$page->setStyle('admin') ;	
        
        /*
		 * 得到该店被举报禁售的列表
		 */		
		$model_inform = Model('inform') ;
        $condition = array();
        $condition['inform_state'] = 2;
        $condition['inform_store_id'] = $_SESSION['store_id'];
        $condition['inform_handle_type'] = 3;
        $condition['order']        = 'inform_id desc';
		$list = $model_inform->getInform($condition, $page) ;
        $this->profile_menu('inform_list');
        Tpl::output('list', $list) ;
        Tpl::output('show_page', $page->show()) ;
		Tpl::output('menu_sign','store_inform');
		Tpl::output('menu_sign_url','index.php?act=store_inform');
		Tpl::output('menu_sign1','store_inform');
        Tpl::showpage('store_inform.list');
    }

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @param array 	$array		附加菜单
	 * @return 
	 */
	private function profile_menu($menu_key='') {
		$menu_array = array(
			1=>array('menu_key'=>'inform_list','menu_name'=>Language::get('nc_store_inform'),'menu_url'=>'index.php?act=store_inform&op=inform_list'),
		);
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
    }	

}
