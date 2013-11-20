<?php
/**
 * 用户中心-组合销售
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
class store_promotion_bundlingControl extends BaseMemberStoreControl {

    public function __construct() {

        parent::__construct() ;

        /**
         * 读取语言包
         */
        Language::read('member_layout,member_store_promotion_bundling');
        //检查是否开启
        if (intval(C('gold_isuse')) !== 1 || intval(C('promotion_allow')) !== 1){
            showMessage(Language::get('promotion_unavailable'),'index.php?act=store','','error');
        }

    }

    public function indexOp() {
        $this->bundling_listOp();
    }

    /**
     * 发布的活动列表
     */
    public function bundling_listOp() {
        $model = Model();
		
        // 检查是否已购买套餐
        $bundling_quota	= $this->bundlingQuotaCheck();
		Tpl::output('bundling_quota_flag', $bundling_quota);
		
		if($bundling_quota){
			// 计算已经发布活动、剩余活动数量
			$count = $model->table('p_bundling')->where('store_id='.$_SESSION['store_id'])->count();
			$bundling_published		= intval($count);
			$bundling_surplus	= intval(C('promotion_bundling_sum')) - $bundling_published;
			
			
			// 查询活动
			$where = 'store_id='.$_SESSION['store_id'];	// 查询条件。
			if($_GET['bundling_name'] != ''){
				$where .= ' and bl_name like "%'.trim($_GET['bundling_name']).'%"';
				Tpl::output('bundling_name', trim($_GET['bundling_name']));
			}
			if(is_numeric($_GET['state'])){
				$where .= ' and bl_state ='.$_GET['state'];
				Tpl::output('state', $_GET['state']);
			}
			$bundling_count = $model->table('p_bundling')->where($where)->count();
			$bundling_list = $model->table('p_bundling,p_bundling_goods')->field('count(p_bundling_goods.bl_id) as count,p_bundling.*')
									->join('left')->on('p_bundling.bl_id=p_bundling_goods.bl_id')->group('bl_id')
									->where($where)->order('p_bundling.bl_id desc')->page(10, $bundling_count)->select();
			if(is_array($bundling_list)){
				foreach ($bundling_list as $key=>$val){
					$a = explode(',', $val['bl_img_more']);
					$bundling_list[$key]['img'] = cthumb($a[0],'tiny',$_SESSION['store_id']);
				}
			}
			$page = $model->showpage(2);
			Tpl::output('show_page',$page);
			Tpl::output('list', $bundling_list);
			
			
			Tpl::output('bundling_quota', $bundling_quota);
			Tpl::output('bundling_published', $bundling_published);
			Tpl::output('bundling_surplus', $bundling_surplus);
			$this->bundlingState();
		}
		$this->profile_menu('bundling_list', 'bundling_list');
        Tpl::showpage('store_promotion_bundling.list');

    }

    /**
     * 套餐购买
     */
	public function bundling_quota_addOp() {
		if(chksubmit()){
			$quantity = intval($_POST['bundling_quota_quantity']);				// 购买数量（月）
			$glod_quantity	= $quantity*intval(C('promotion_bundling_price'));	// 扣除金币
			if($quantity <= 0 || $quantity > 12){
				showDialog(Language::get('bundling_quota_price_fail'),'index.php?act=store_promotion_bundling&op=bundling_quota_add','','error');
			}
			// 实例化模型
			$model	= Model();
			
			// 验证金币数量
			$member_info = $model->table('member')->field('member_goldnum')->find($_SESSION['member_id']);
			if(intval($member_info['member_goldnum']) < $glod_quantity ){
				showDialog(Language::get('bundling_gold_not_enough'));
			}
			
			$data = array();
			$data['store_id']			= $_SESSION['store_id'];
			$data['store_name']			= $_SESSION['store_name'];
			$data['member_id']			= $_SESSION['member_id'];
			$data['member_name']		= $_SESSION['member_name'];
			$data['bl_quota_month']		= $quantity;
			$data['bl_quota_starttime']	= time();
			$data['bl_quota_endtime']	= time()+60*60*24*30*$quantity;
			$data['bl_quota_state']		= 1;
			$data['bl_pay_gold']		= $quantity*intval(C('promotion_bundling_price'));
			
			$return = $model->table('p_bundling_quota')->insert($data);
			if($return){
				$update_array = array();
				$update_array['member_id']				= $_SESSION['member_id'];
				$update_array['member_goldnum']			= array('exp','member_goldnum-'.$glod_quantity);
				$update_array['member_goldnumminus']	= array('exp','member_goldnumminus+'.$glod_quantity);
				$result = $model->table('member')->update($update_array);
				
				//写入金币日志
				$param = array();
				$param['glog_memberid']		= $_SESSION['member_id'];
				$param['glog_membername']	= $_SESSION['member_name'];
				$param['glog_storeid']		= $_SESSION['store_id'];
				$param['glog_storename']	= $_SESSION['store_name'];
				$param['glog_adminid']		= '0';
				$param['glog_adminname']	= '';
				$param['glog_goldnum']		= $glod_quantity;
				$param['glog_method']		= 2;
				$param['glog_addtime']		= time();
				$param['glog_desc']			= sprintf(Language::get('bundling_quota_success_glog_desc'),$quantity,intval(C('promotion_bundling_price')),$glod_quantity);
				$param['glog_stage']		= 'bundling';
				$model->table('gold_log')->insert($param);
				
				// 发送站内信
				$param = array();
				$param['buy_month']			= $quantity;
				$param['bundling_price']	= C('promotion_bundling_price');
				$param['pay_gold']			= $quantity*intval(C('promotion_bundling_price'));
				self::send_notice($_SESSION['member_id'], 'msg_toseller_bundling_gold_consume_notify', $param);
				
				showDialog(Language::get('bundling_quota_price_succ'), 'index.php?act=store_promotion_bundling&op=bundling_list', 'succ');
			}else{
				showDialog(Language::get('bundling_quota_price_fail'), 'index.php?act=store_promotion_bundling&op=bundling_quota_add');
			}
		}
        //输出导航
        self::profile_menu('bundling_quota_add', 'bundling_quota_add');
        Tpl::showpage('store_promotion_bundling_quota.add');
    }
    
    /**
     * 套餐活动添加
     */
    public function bundling_addOp(){
    	/**
    	 * 实例化模型
    	 */
		$model	= Model();
		
		// 验证是否购买
		if(!$this->bundlingQuotaCheck()){
			showMessage(Language::get('bundling_quota_current_error'),'','','error');
		}
		
		// 验证套餐数量
		if(intval(C('promotion_bundling_sum')) != 0 && !isset($_REQUEST['bundling_id'])){
			$count = $model->table('p_bundling')->where('store_id='.$_SESSION['store_id'])->count();
			if(intval(C('promotion_bundling_sum')) <= intval($count)) showMessage(Language::get('bundling_add_fail_quantity_beyond'), '', '', 'error');
		}
		
    	if(chksubmit()){
    		
    		// 插入套餐
    		$data	= array();
    		if(isset($_POST['bundling_id'])) $data['bl_id'] = intval($_POST['bundling_id']);
    		$data['bl_name']			= $_POST['bundling_name'];
    		$data['store_id']			= $_SESSION['store_id'];
    		$data['store_name']			= $_SESSION['store_name'];
    		$data['bl_img_more']		= empty($_POST['image_path'])?'':implode(',', array_filter($_POST['image_path']));
    		$data['bl_discount_price']	= $_POST['discount_price'];
    		$data['bl_freight_choose']	= $_POST['bundling_freight_choose'];
    		$data['bl_freight']			= $_POST['bundling_freight'];
    		$data['bl_desc']			= $_POST['bundling_desc'];
    		$data['bl_state']			= intval($_POST['state']);
    		$return	= $model->table('p_bundling')->insert($data, true);
    		if(!$return) showDialog(Language::get('nc_common_op_fail'), '', '', 'error');
    		if(!isset($_POST['bundling_id'])){
    			// 自动发布动态
    			// bl_id,bl_name,image_path,bl_discount_price,bl_freight_choose,bl_freight,store_id
    			$data_array = array();
    			$data_array['bl_id']				= $return;
    			$data_array['bl_name']				= $data['bl_name'];
    			$data_array['bl_img']				= empty($_POST['image_path'])?'':$_POST['image_path'][0];
    			$data_array['bl_discount_price']	= $data['bl_discount_price'];
    			$data_array['bl_freight_choose']	= $data['bl_freight_choose'];
    			$data_array['bl_freight']			= $data['bl_freight'];
    			$data_array['store_id']				= $_SESSION['store_id'];
    			$this->storeAutoShare($data_array, 'bundling');
    		}
			
    		// 插入套餐商品
    		$data_goods	= array();
    		
    		$model->table('p_bundling_goods')->where('bl_id='.intval($_POST['bundling_id']))->delete();
    		if(!empty($_POST['goods']) && is_array($_POST['goods'])){
    			foreach($_POST['goods'] as $key=>$val){
    				if(isset($val['bundling_goods_id'])) {
    					$data_goods[$key]['bl_goods_id'] = intval($val['bundling_goods_id']);
    				}else{
    					$data_goods[$key]['bl_goods_id'] = null;
    				}
    				$data_goods[$key]['bl_id']		= isset($_POST['bundling_id'])?intval($_POST['bundling_id']):$return;
    				$data_goods[$key]['goods_id']	= intval($val['goods_id']);
    				$data_goods[$key]['goods_name']	= trim($val['goods_name']);
    			}
    		}
    		$data_goods = array_values($data_goods);
    		// 插入数据
    		$return = $model->table('p_bundling_goods')->insertAll($data_goods);

    		showDialog(Language::get('nc_common_op_succ'), 'index.php?act=store_promotion_bundling&op=bundling_list', 'succ');
    	}
		$store_info		= $model->table('store')->find($_SESSION['store_id']);
    	$store_grade	= $model->table('store_grade')->find($store_info['grade_id']);
    	//编辑器多媒体功能
    	$editor_multimedia = false;
    	$sg_fun = @explode('|',$store_grade['sg_function']);
    	if(!empty($sg_fun) && is_array($sg_fun)){
    		foreach($sg_fun as $fun){
    			if ($fun == 'editor_multimedia'){
    				$editor_multimedia = true;
    			}
    		}
    	}
		Tpl::output('editor_multimedia',$editor_multimedia);
		
		if (intval($_GET['bundling_id']) > 0){
			$bundling_info	= $model->table('p_bundling')->find(intval($_GET['bundling_id']));
			
			// 验证是否属于自己的组合套餐
			if($bundling_info['store_id'] != $_SESSION['store_id']){
				showMessage(Language::get('wrong_argument'), 'index.php?act=store_promotion_bundling&op=bundling_list', '', 'error');
			}
			
			
			$b_goods_list	= $model->table('p_bundling_goods,goods')
									->field('p_bundling_goods.bl_goods_id, p_bundling_goods.goods_id, p_bundling_goods.goods_name, goods.goods_image, goods.goods_store_price, goods.goods_show')
									->join('inner')->on('p_bundling_goods.goods_id=goods.goods_id')
									->where('bl_id='.intval($_GET['bundling_id']))->select();
			$bundling_info['bl_img_more']	= empty($bundling_info['bl_img_more'])?'':explode(',', $bundling_info['bl_img_more']);
			Tpl::output('bundling_info', $bundling_info);
			Tpl::output('b_goods_list', $b_goods_list);
			// 输出导航
			self::profile_menu('bundling_edit', 'bundling_edit');
		}else{
	    	// 输出导航
	    	self::profile_menu('bundling_add', 'bundling_add');
		}
    	Tpl::showpage('store_promotion_bundling.add');
    }
    
    /**
     * 套餐活动添加商品
     */
    public function bundling_add_goodsOp(){
    	/**
    	 * 实例化模型
    	 */
    	$model = Model('goods');
    	$model_store_class = Model('my_goods_class');
    	
    	// where条件
    	$where = 'store_id='.$_SESSION['store_id'].' and goods_show=1';
    	if(intval($_GET['stc_id']) > 0){
    		$stc_id = intval($_GET['stc_id']);
    		if ($stc_id){
    			$stc_id_arr = $model_store_class->getChildAndSelfClass($stc_id,'1');
    			if (is_array($stc_id_arr) && count($stc_id_arr)>0){
    				$where .= ' and store_class_goods.stc_id in ('.implode(',',$stc_id_arr).')';
    			}else{
    				$where .= ' and store_class_goods.stc_id = '.$stc_id_arr;
    			}
    		}
    		Tpl::output('stc_id', $stc_id);
    	}
    	if($_GET['keyword'] != ''){
    		$where .= ' and goods_name like \'%'.trim($_GET['keyword']).'%\'';
    		Tpl::output('b_search_keyword', trim($_GET['keyword']));
    	}
    	
    	if(intval($_GET['stc_id']) > 0){
    		$goods_list = $model->table('goods,store_class_goods')->field('DISTINCT goods.goods_id, goods.goods_name, goods.goods_image, goods.goods_store_price, goods.goods_serial')->join('left')->on('goods.goods_id=store_class_goods.goods_id')->where($where)->order('goods.goods_id desc')->page(5)->select();
    	}else{
    		$goods_list = $model->table('goods')->field('goods_id, goods_name, goods_image, goods_store_price, goods_serial')->where($where)->order('goods_id desc')->page(5)->select();
       	}
       	
    	if(!empty($goods_list) && is_array($goods_list)){
    		$goods_id_array	= array();
    		foreach($goods_list as $val){
    			$goods_id_array[]	= $val['goods_id'];
    		}
    		$goods_storage = $model->table('goods_spec')->field('sum(spec_goods_storage) as sum, goods_id')->where('goods_id in ('.implode(',', $goods_id_array).')')->group('goods_id')->select();
    		$storage_array = array();
    		foreach ($goods_storage as $val){
    			$storage_array[$val['goods_id']] = $val['sum'];
    		}
    		Tpl::output('storage_array', $storage_array);
    	}
    	$page = $model->showpage(2);
    	Tpl::output('show_page',$page);
    	Tpl::output('goods_list', $goods_list);
    	
    	/**
    	 * 商品分类
    	 */
    	$store_goods_class	= $model_store_class->getClassTree(array('store_id'=>$_SESSION['store_id'],'stc_state'=>'1'));
    	Tpl::output('store_goods_class',$store_goods_class);
    	
    	Tpl::showpage('store_promotion_bundling.add_goods', 'null_layout');
    	 
    }
    
    /**
     * 购买列表
     */
    public function bundling_purchase_historyOp(){
    	$model = Model('p_bundling_quota');
    	$quota_list = $model->where('store_id='.$_SESSION['store_id'])->order('bl_quota_id desc')->page(10)->select();
    	
    	Tpl::output('quota_list', $quota_list);
    	$page = $model->showpage(2);
    	Tpl::output('show_page',$page);
    	
    	self::profile_menu('bundling_list', 'bundling_purchase_history');
    	Tpl::showpage('store_promotion_bundling.history');
    }
    
    /**
     * 删除组合销售活动
     */
    public function drop_bundlingOp(){
    	/**
    	 * 参数验证
    	 */
    	$bl_id = trim($_GET['bundling_id']);
    	if(empty($bl_id)) {
    		showdialog(Language::get('miss_argument'),'','error');
    	}
    	/**
    	 * 验证组合销售是否属于店铺
    	 */
    	//统计输入数量
    	$bl_id_array	= explode(',',$bl_id);
    	$input_bl_count	= count($bl_id_array);
    	// 实例化模型
    	$model = Model();
    	$verify_count = $model->table('p_bundling')->where('bl_id in('.implode(',', $bl_id_array).') and store_id='.$_SESSION['store_id'])->count();
    	//判断输入和确认是否一致
    	if($input_bl_count !== intval($verify_count)) {
    		showdialog(Language::get('para_error'),'','html','error');
    	}
    	$state = $model->table('p_bundling')->where('bl_id in('.implode(',', $bl_id_array).')')->delete();
    	$model->table('p_bundling_goods')->where('bl_id in('.implode(',', $bl_id_array).')')->delete();
    	if($state) {
    		showDialog(Language::get('bundling_delete_success'),'reload','succ');
    	} else {
    		showDialog(Language::get('bundling_delete_fail'),'','error');
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
    	$menu_array	= array();
    	$menu_array	= array(
    		1=>array('menu_key'=>'bundling_list','menu_name'=>Language::get('bundling_list'),'menu_url'=>'index.php?act=store_promotion_bundling&op=bundling_list'),
    		2=>array('menu_key'=>'bundling_purchase_history','menu_name'=>Language::get('bundling_purchase_history'),'menu_url'=>'index.php?act=store_promotion_bundling&op=bundling_purchase_history'),
    		3=>array('menu_key'=>'bundling_quota_add','menu_name'=>Language::get('bundling_quota_add'),'menu_url'=>'index.php?act=store_promotion_bundling&op=bundling_quota_add'),
    		4=>array('menu_key'=>'bundling_add','menu_name'=>Language::get('bundling_add'),'menu_url'=>'index.php?act=store_promotion_bundling&op=bundling_add'),
    		5=>array('menu_key'=>'bundling_edit','menu_name'=>Language::get('bundling_edit'),'menu_url'=>'index.php?act=store_promotion_bundling&op=bundling_edit'),
		);
    	switch ($menu_type) {
    		case 'bundling_list':
    		case 'bundling_quota_list':
    			unset($menu_array[3]);
    			unset($menu_array[4]);
    			unset($menu_array[5]);
    			break;
    		case 'bundling_quota_add':
    			unset($menu_array[4]);
    			unset($menu_array[5]);
    			break;
    		case 'bundling_add':
    			unset($menu_array[3]);
    			unset($menu_array[5]);
    			break;
    		case 'bundling_edit':
    			unset($menu_array[3]);
    			unset($menu_array[4]);
    			break;
    	}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
		Tpl::output('menu_sign','bundling');
		Tpl::output('menu_sign_url','index.php?act=store_promotion_bundling');
		Tpl::output('menu_sign1',$menu_key);
    }
	// 状态数组
    private function bundlingState(){
    	$state_array = array(0=>Language::get('bundling_status_0') , 1=>Language::get('bundling_status_1'));
    	Tpl::output('state_array', $state_array);
    }
    // 验证是否购买
    private function bundlingQuotaCheck(){
    	$bundling_quota			= Model()->table('p_bundling_quota')->where('store_id='.$_SESSION['store_id'].' and bl_quota_starttime<'.time().' and bl_quota_endtime>'.time().' and bl_quota_state=1')->find();
    	return empty($bundling_quota)?false:$bundling_quota;
    }
}
