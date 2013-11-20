<?php
/**
 * 会员后台 - 团购管理
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

class store_groupbuyControl extends BaseMemberStoreControl {

    //定义常量
    const STATE_ALL =  0;
    const STATE_VERIFY =  1;
    const STATE_CANCEL =  2;
    const STATE_PROGRESS =  3;
    const STATE_VERIFY_FAIL =  4;
    const STATE_CLOSE =  5;
    const TEMPLATE_STATE_ACTIVE = 1;
    const TEMPLATE_STATE_UNACTIVE = 2;

    public function __construct() {
        parent::__construct();

        //读取语言包
        Language::read('member_groupbuy');
        //检查团购功能是否开启
        if (intval($GLOBALS['setting_config']['groupbuy_allow']) !== 1){
            showMessage(Language::get('groupbuy_unavailable'),'index.php?act=store','','error');
        }
    }
    /**
     * 默认显示团购列表
     **/
    public function indexOp() {
        $this->groupbuy_listOp();
    }

    /**
     * 团购列表
     **/
    public function groupbuy_listOp() {

        //分页
        $page	= new Page();
        $page->setEachNum(10);
        $page->setStyle('admin');

        $model_groupbuy = Model('goods_group');
        $param = array();
        $param['store_id'] = $_SESSION['store_id'];
        $param['state'] = intval($_GET['groupbuy_state']);
        $param['group_name'] = trim($_GET['group_name']);
        $param['order'] = 'template_id desc,state asc';
        $group_list = $model_groupbuy->getList($param,$page);

        //输出分页
        Tpl::output('show_page',$page->show());

        //输出团购状态列表
        $this->get_groupbuy_state_list();

        //输出导航
        self::profile_menu('store_groupbuy');
        Tpl::output('group',$group_list);
        Tpl::output('menu_key','groupbuy');
        Tpl::output('menu_sign','groupbuy_manage');
        Tpl::showpage('store_groupbuy');

    }

    /**
     * 获取团购状态列表
     **/
    private function get_groupbuy_state_list() {

        $state_list = array(
            self::STATE_ALL=>Language::get('groupbuy_state_all'),
            self::STATE_VERIFY=>Language::get('groupbuy_state_verify'),
            self::STATE_PROGRESS=>Language::get('groupbuy_state_progress'),
            self::STATE_VERIFY_FAIL=>Language::get('groupbuy_state_fail'),
            self::STATE_CLOSE=>Language::get('groupbuy_state_close')
        );
        Tpl::output('state_list',$state_list);
    }

    /**
     * 添加团购页面
     **/
    public function groupbuy_addOp() {

        //获取可以申请的团购活动列表
        if($template_list = $this->get_groupbuy_template_list()){
        	Tpl::output('template_list',$template_list);
        }else{
        	showMessage(Language::get('groupbuy_none'),'','','error',1,3000);
        }
        $_cache = ($h = F('groupbuy')) ? $h : H('groupbuy',true,'file');
        Tpl::output('class_list',$_cache['category']);
        Tpl::output('area_list',$_cache['area']);
        self::profile_menu('store_groupbuy','add');
        Tpl::output('menu_key','add');
        Tpl::output('menu_sign','groupbuy_manage');
        Tpl::output('menu_sign_url','index.php?act=store_groupbuy');
        Tpl::output('menu_sign1','new_group');
        Tpl::showpage('store_groupbuy.add');

    }

    /**
     * 获取可用的团购活动列表
     **/
    private function get_groupbuy_template_list() {
        $model_groupbuy_template = Model('groupbuy_template');
        $param = array();
        $param['less_than_join_end_time'] = time();
        $param['state'] = self::TEMPLATE_STATE_ACTIVE;
        $template_list = $model_groupbuy_template->getList($param);
        return empty($template_list) ? false : $template_list;
    }

    /**
     * 团购保存
     **/
    public function groupbuy_saveOp() {

        //获取提交的数据
        $group_id = intval($_POST['group_id']);

        //获取模版信息
        $template_id = intval($_POST['input_groupbuy_template']);
        $model_groupbuy_template = Model('groupbuy_template');
        $template_info = $model_groupbuy_template->getOne($template_id);
        if(empty($template_info) || intval($template_info['state']) !== self::TEMPLATE_STATE_ACTIVE) {
        	showDialog(Language::get('param_error'));
        }
        $goods_id = intval($_POST['input_goods_id']);
        if(empty($goods_id)) {
            showDialog(Language::get('param_error'));
        }

        //实例化团购模型
        $model_goods_group = Model('goods_group');

        //验证团购商品是否已经在本期发布
        if(empty($group_id)) {
            $param = array();
            $param['goods_id'] = $goods_id;
            $param['template_id'] = $template_id;
            if($model_goods_group->isExist($param)) {
                showDialog(Language::get('group_goods_is_exist'));
            }
        }

        $param = array();
        $param['group_name'] = trim($_POST['input_group_name']);
        $param['template_id'] = $template_id;
        $param['template_name'] = $template_info['template_name'];
        $param['start_time'] = $template_info['start_time'];
        $param['end_time'] = $template_info['end_time'];
        $param['group_help'] = trim($_POST['input_group_help']);
        $param['groupbuy_price'] = floatval($_POST['input_groupbuy_price']); 
        $param['virtual_quantity'] = intval($_POST['input_virtual_quantity']);
        $param['sale_quantity'] = intval($_POST['input_sale_quantity']);
        $param['max_num'] = intval($_POST['input_max_num']);
        $param['group_intro'] = trim($_POST['input_group_intro']);
        $param['class_id'] = intval($_POST['input_class_id']);
        $param['area_id'] = intval($_POST['input_area_id']);
        $group_pic = $this->upload_pic('input_group_pic');

        $goods_info = $this->get_goods_info($goods_id);
        if(empty($goods_info)) {
            showDialog(Language::get('param_error'));
        }
        if($goods_info['store_id'] != $_SESSION['store_id']) {
            showDialog(Language::get('param_error'));
        }

        //更新商品表团购价格
        $model_goods = Model('goods');
        $model_goods->updateGoods(array('group_price'=>$param['groupbuy_price']),$goods_id);

        $param['goods_id'] = $goods_info['goods_id'];
        $param['goods_name'] = $goods_info['goods_name'];
        $param['goods_price'] = $goods_info['goods_store_price'];
        $param['rebate'] = $param['groupbuy_price'] / floatval($goods_info['goods_store_price']) * 10;
        $param['state'] = self::STATE_VERIFY;
        //验证提交的数据
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array("input"=>$param['group_name'], "require"=>"true","message"=>Language::get('group_name_error')),
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            showValidateError($error);
        }

        if(empty($group_id)) {
            //新发布
            if(empty($group_pic)) {
                showDialog(Language::get('group_pic_error'));
            }
            $param['group_pic'] = $group_pic;
            $param['recommended'] = 0;
            $param['store_id'] = $_SESSION['store_id'];
            $param['store_name'] = $_SESSION['store_name'];

            //保存
            $result = $model_goods_group->save($param);
            if($result) {
            	// 自动发布动态
            	// group_id,group_name,goods_id,goods_price,groupbuy_price,group_pic,rebate,start_time,end_time
            	$data_array = array();
            	$data_array['group_id']			= $result;
            	$data_array['group_name']		= $param['group_name'];
            	$data_array['goods_id']			= $param['goods_id'];
            	$data_array['goods_price']		= $param['goods_price'];
            	$data_array['groupbuy_price']	= $param['groupbuy_price'];
            	$data_array['group_pic']		= $param['group_pic'];
            	$data_array['rebate']			= $param['rebate'];
        		$data_array['start_time']		= $template_info['start_time'];
        		$data_array['end_time']			= $template_info['end_time'];
            	$this->storeAutoShare($data_array, 'groupbuy');
            	
                showDialog(Language::get('groupbuy_add_success'),'index.php?act=store_groupbuy','succ');
            }else {
                showDialog(Language::get('groupbuy_add_fail'),'index.php?act=store_groupbuy');
            }
        }else {
            //编辑
            if(!empty($group_pic)) {
                $param['group_pic'] = $group_pic;
            }
            $group_info = $model_goods_group->getOne($group_id);
            if(empty($group_info)) {
                showDialog(Language::get('param_error'));
            }
            $group_state = intval($group_info['state']);
            if($group_state !== self::STATE_VERIFY && $group_state !== self::STATE_VERIFY_FAIL) {
                showDialog(Language::get('param_error'),'');
            }
            if(intval($group_info['store_id']) !== intval($_SESSION['store_id'])) {
                showDialog(Language::get('param_error'));
            }
            if($model_goods_group->update($param,array('group_id'=>$group_id))) {
                showDialog(Language::get('groupbuy_edit_success'),'index.php?act=store_groupbuy','succ');
            }else {
                showDialog(Language::get('groupbuy_edit_fail'));
            }
        }
    }

    /**
     * 上传图片
     **/
    private function upload_pic($pic) {
        $pic_name = '';
        $upload = new UploadFile();
        $uploaddir = ATTACH_PATH.DS.'groupbuy'.DS;
        $upload->set('default_dir',$uploaddir);
        $upload->set('thumb_width',	'480,296,168');
		$upload->set('thumb_height','480,296,168');
		$upload->set('thumb_ext',	'_max,_mid,_small');
        if (!empty($_FILES[$pic]['name'])){

            $result = $upload->upfile($pic);
            if ($result){
                $pic_name = $upload->thumb_image;
            }
            else {
                showMessage($upload->error,'','','error');
            }
        }
        return $pic_name;
    }

    /**
     * 获取商品信息
     **/
    private function get_goods_info($goods_id) {
        $model_goods = Model('goods');
        $param = array();
        $param['goods_id'] = $goods_id;
        $param['goods_state'] = 0;
        $goods_list = $model_goods->getGoods($param,'','*','groupbuy_goods_info');
        $goods_storage = 0;
        foreach($goods_list as $goods) {
            $goods_storage += $goods['spec_goods_storage'];
        }
        $goods_info = $goods_list[0];
        $goods_info['goods_storage'] = $goods_storage;
        return $goods_info;
    }

    /**
     * 团购删除
     **/
    public function groupbuy_dropOp() {

        $group_id = intval($_GET['group_id']);
        if(empty($group_id)) {
            showDialog(Language::get('param_error'));
        }
        $model_group = Model('goods_group');
        $group_info = $model_group->getOne($group_id);
        if(empty($group_info)) {
            showDialog(Language::get('param_error'));
        }
        $group_state = intval($group_info['state']);
        if($group_state !== self::STATE_VERIFY && $group_state !== self::STATE_VERIFY_FAIL) {
            showDialog(Language::get('param_error'));
        }
        if(intval($group_info['store_id']) !== intval($_SESSION['store_id'])) {
            showDialog(Language::get('param_error'));
        }
        if($model_group->drop(array('group_id'=>$group_id))) {
            showDialog(Language::get('nc_common_del_succ'),'index.php?act=store_groupbuy','succ');
        }else {
            showDialog(Language::get('nc_common_del_fail'));
        }
    }

    /**
     * 团购编辑页面
     **/
    public function groupbuy_editOp() {
        $group_id = intval($_GET['group_id']);
        if(empty($group_id)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $model_group = Model('goods_group');
        $group_info = $model_group->getOne($group_id);
        if(empty($group_info)) {
            showMessage(Language::get('param_error'),'','','error');
        }
        $group_state = intval($group_info['state']);
        if($group_state !== self::STATE_VERIFY && $group_state !== self::STATE_VERIFY_FAIL) {
            showMessage(Language::get('param_error'),'','','error');
        }

        //获取可以申请的团购活动列表
        if($template_list = $this->get_groupbuy_template_list()){
        	Tpl::output('template_list',$template_list);
        }
		$_cache = ($h = F('groupbuy')) ? $h : H('groupbuy',true,'file');
        Tpl::output('class_list',$_cache['category']);
        Tpl::output('area_list',$_cache['area']);
        /**
         * 头部导航
         */
        self::profile_menu('store_groupbuy','edit');
        Tpl::output('group_info',$group_info);
        Tpl::output('menu_key','edit');
        Tpl::output('menu_sign','groupbuy_manage');
        Tpl::output('menu_sign_url','index.php?act=store_groupbuy');
        Tpl::output('menu_sign1','new_group');
        Tpl::showpage('store_groupbuy.add');

    }
    /**
     * 选择商品
     */
    public function get_select_goodsOp(){
        /**
         * 获取本店分类
         */
        $select_string = '';
        //得到本店商品分类
        $stc_class = Model('store_goods_class');
        $stc_tree = $stc_class->getStcTreeList($_SESSION['store_id']);
        if(!empty($stc_tree) && is_array($stc_tree)){
            foreach($stc_tree as $stc){
                $select_string .= '<option value="'.$stc['stc_id'].'">'.$stc['stc_name'].'</option>';
            }
        }
        Tpl::output('select_string',$select_string);

        Tpl::output('title',Language::get('groupbuy_index_choose_goods'));
        Tpl::showpage('store_groupbuy.select','null_layout');
    }
    /**
     * 搜索商品
     */
    public function getSelectGoodsListOp(){
        //得到商品列表
        $goods_class = Model('goods');
        //得到搜索条件
        $stc_id = intval($_GET['stc_id']);
        $goods_name = trim($_GET['stc_goods_name']);
        //获得商品列表
        $condition_array = array();
        $condition_array['keyword'] = $goods_name;
        $condition_array['store_id'] = $_SESSION['store_id'];
        //查询分类下的子分类
        if ($stc_id){
            $model_store_class = Model('my_goods_class');
            $stc_id_arr = $model_store_class->getChildAndSelfClass($stc_id);
            if (is_array($stc_id_arr) && count($stc_id_arr)>0){
                $condition_array['stc_id_in'] = implode(',',$stc_id_arr);
            }else{
                $condition_array['stc_id'] = $stc_id_arr;
            }
        }
        $condition_array['group'] = '`goods`.goods_id';
        $condition_array['limit'] = 50;
        $condition_array['order'] = 'goods.goods_id desc';
        $goods_list = $goods_class->getGoods($condition_array,'','`goods`.goods_id,`goods`.goods_name','stc');
        //处理返回字符串
        if (is_array($goods_list)){
            $data = array(
                'done'=>1,
                'length'=>count($goods_list),
                'retval'=>$goods_list
            );
            $data['retval']['length'] = count($goods_list);
        }else {
            $data = array(
                'done'=>1,
                'retval'=>array(
                    'length'=>0
                )
            );
        }
        /**
         * 转码
         */
        if (strtoupper(CHARSET) == 'GBK'){
            $data = Language::getUTF8($data);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
        }
        echo json_encode($data);
    }
    /**
     * 得到商品详细信息
     */
    public function getGoodsInfoOp(){
        /**
         * 读取语言包
         */
        if (intval($_GET['goods_id']) > 0){
            //获取商品id
            $goods_id = intval($_GET['goods_id']);
            //实例化模型
            $goods_class = Model('goods');
            //获取商品详细信息
            $goods_info = $this->get_goods_info($goods_id); 
            //处理返回字符串
            $data = array(
                'done'=>1,
                'retval'=>$goods_info
            );
        }else {
            $data = array(
                'done'=>0
            );
        }

        /**
         * 转码
         */
        if (strtoupper(CHARSET) == 'GBK'){
            $data = Language::getUTF8($data);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
        }
        echo json_encode($data);
    }
    /**
     * 用户中心右边，小导航
     *
     * @param string	$menu_type	导航类型
     * @param string 	$menu_key	当前导航的menu_key
     * @param array 	$array		附加菜单
     * @return 
     */
    private function profile_menu($menu_type,$menu_key='',$array=array()) {
        /**
         * 读取语言包
         */
        Language::read('member_layout');
        $lang	= Language::getLangContent();
        $menu_array		= array();
        switch ($menu_type) {
        case 'store_groupbuy':
            $menu_array	= array(
                1=>array('menu_key'=>'groupbuy','menu_name'=>$lang['nc_member_path_group_list'],'menu_url'=>'index.php?act=store_groupbuy')
            );
            if (!empty($menu_key)){
                switch ($menu_key){
                case 'add':
                    $menu_array[] = array('menu_key'=>'add','menu_name'=>$lang['nc_member_path_new_group'],'menu_url'=>'index.php?act=store_groupbuy&groupbuy_add');
                    break;
                case 'edit':
                    $menu_array[] = array('menu_key'=>'edit','menu_name'=>$lang['nc_member_path_edit_group'],'menu_url'=>'index.php?act=store_groupbuy');
                    break;
                case 'cancel':
                    $menu_array[] = array('menu_key'=>'cancel','menu_name'=>$lang['nc_member_path_cancel_group']);
                    break;
                case 'help':
                    $menu_array[] = array('menu_key'=>'help','menu_name'=>$lang['nc_member_path_group_intro']);
                    break;
                case 'sold':
                    $menu_array[] = array('menu_key'=>'sold','menu_name'=>$lang['groupbuy_index_order_num']);
                    break;
                }
            }
            break;
        }
        if(!empty($array)) {
            $menu_array[] = $array;
        }
        Tpl::output('member_menu',$menu_array);
        Tpl::output('menu_key',$menu_key);
    }
}
