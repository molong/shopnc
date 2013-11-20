<?php
/**
 * 用户中心广告管理及购买
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

class store_advControl extends BaseMemberStoreControl {
	public function __construct(){
		parent::__construct();
		Language::read('member_store_adv');
	}
    /**
	 * 店铺广告管理
	 */
    public function adv_manageOp(){
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$adv    = Model('adv');
		$condition['member_id'] = $_SESSION['member_id'];
		$orderby='';
        if($_GET['order'] == 'clicknum'){
			$orderby = 'click_num desc';
		}
		$list	= $adv->getList($condition,$page,'',$orderby);
		$ap_list= $adv->getApList();
		/**
		 * 页面输出
		 */
		Tpl::output('list',$list);
		Tpl::output('ap_list',$ap_list);
		Tpl::output('show_page',$page->show());
		self::profile_menu('adv','adv');
		Tpl::output('menu_sign','adv');
		Tpl::output('menu_sign_url','index.php?act=store_adv&op=adv_manage');
		Tpl::output('menu_sign1','adv');
		Tpl::showpage('store_adv');
	}
	/**
	 * 店铺广告修改
	 */
	public function adv_editOp(){
		if(!empty($_POST['formsubmit'])||$_POST['formsubmit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			    array("input"=>$_POST["adv_title"], "require"=>"true", "message"=>Language::get('advtitle_can_not_null')),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error,'','html','error');
			}else {
		        $upload = new UploadFile();
				$param['adv_id']    = intval($_POST['adv_id']);
				$param['adv_title'] = $_POST['adv_title'];
				switch ($_POST['ap_class']){
					case '0'://图片广告
						if($_FILES['adv_pic']['name'] == ''){
							$filename = $_POST['pic_ori'];
						}else{
							$upload->set('default_dir',ATTACH_ADV);
							$result	= $upload->upfile('adv_pic');
							$filename = $upload->file_name;
						}
						if(!$result){
							showMessage($upload->error,'','','error');
						}
						$ac = array(
					    'adv_pic'     =>$filename,
					    'adv_pic_url' =>$_POST['adv_pic_url']
					    );
					    $ac = serialize($ac);
					    $change_content = $ac;
						break;
					case '1'://文字广告
				//判断页面编码确定汉字所占字节数
		        switch (CHARSET){
			       case 'UTF-8':
				        $charrate = 3;
				        break;
			       case 'GBK':
				        $charrate = 2;
				        break;
		        }
				if(strlen($_POST['adv_word'])>($_POST['adv_word_len']*$charrate)){
						$error = Language::get('wordadv_info_too_long');
						showMessage($error,'','html','error');die;
				}
						$ac = array(
					    'adv_word'    =>$_POST['adv_word'],
					    'adv_word_url'=>$_POST['adv_word_url']
					    );
					    $ac = serialize($ac);
					    $change_content = $ac;
						break;
					case '2'://幻灯片广告
						if($_FILES['adv_slide_pic']['name'] == ''){
							$filename = $_POST['slide_ori'];
						}else{
							$upload->set('default_dir',ATTACH_ADV);
							$result	= $upload->upfile('adv_slide_pic');
							$filename = $upload->file_name;
						}
						if(!$result){
							showMessage($upload->error,'','','error');
						}
						$ac = array(
					    'adv_slide_pic'     =>$filename,
					    'adv_slide_url' =>$_POST['adv_slide_url']
					    );
					    $ac = serialize($ac);
					    $change_content = $ac;
						break;
					case '3'://Flash广告
						if($_FILES['flash_swf'] == ''){
							$filename = $_POST['flash_ori'];
						}else{
							$upload->set('default_dir',ATTACH_ADV);
							$result	= $upload->upfile('flash_swf');
							$filename = $upload->file_name;
						}
						if(!$result){
							showMessage($upload->error,'','','error');
						}
						$ac = array(
					    'flash_swf' =>$filename,
					    'flash_url' =>$_POST['flash_url']
					    );
					    $ac = serialize($ac);
					    $change_content = $ac;
						break;
				}
				$this->makeadvchangefile(intval($_POST['adv_id']), $change_content);
				$param['is_allow']  = '0';
				$param['buy_style'] = 'change';
				$adv    = Model('adv');
				$result = $adv->update($param);
				if ($result) {
					showMessage(Language::get('adv_info_change_succ'),'index.php?act=store_adv&op=adv_manage');
				}else{
					showMessage(Language::get('adv_info_change_failed'),'index.php?act=store_adv&op=adv_manage','html','error');
				}
			}
		}else{
		$adv    = Model('adv');
		$condition['adv_id'] = intval($_GET['adv_id']);
		$adv_info = $adv->getList($condition);
		$adv_info = $adv_info['0'];
		$param['ap_id'] = $adv_info['ap_id'];
		$ap_info  = $adv->getApList($param);
		$ap_info  = $ap_info['0'];
		/**
		 * 页面输出
		 */
		Tpl::output('adv_info',$adv_info);
		Tpl::output('ap_info',$ap_info);
		self::profile_menu('adv_edit','adv_edit');
		Tpl::output('menu_sign','adv');
		Tpl::output('menu_sign_url','index.php?act=store_adv&op=adv_manage');
		Tpl::output('menu_sign1','adv_edit');
		Tpl::showpage('store_adv_edit');
		}
	}
	/**
	 * 删除广告
	 */
	public function adv_delOp(){
		$adv = Model('adv');
		/**
		 * 删除一条广告
		 */
		if(intval($_GET['adv_id']) != ''){
			//更新广告位缓存信息
    	    $condition['adv_id'] = intval($_GET['adv_id']);
    	    $adv_info = $adv->getList($condition);
    	    $adv_info = $adv_info['0'];
    	    $goldpay  = $adv_info['goldpay'];
			$result  = $adv->adv_del(intval($_GET['adv_id']));
			$adv->makeApCache($adv_info['ap_id']);
			$cache_file = BasePath.DS.'cache'.DS.'adv_change'.DS.'adv_'.intval($_GET['adv_id']).'.change.php';
			if(file_exists($cache_file)){
				unlink($cache_file);
			}
			if($adv_info['buy_style'] != 'change' && $adv_info['is_allow'] != '2'){
			/**
			 * 退回金币
			 */
			//查询会员现有金币数
		    $member_model = Model('member');
		    $member_array = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));		    
			//修改用户金币信息
		    $newmember_goldnum = intval($member_array['member_goldnum']) + $goldpay;
			$newmember_goldnumcount = intval($member_array['member_goldnumcount']) + $goldpay;
			$result2 = $member_model->updateMember(array('member_goldnum'=>$newmember_goldnum,'member_goldnumcount'=>$newmember_goldnumcount),$_SESSION['member_id']);
			//添加金币日志
			$goldlog_model  = Model('gold_log');
			$insert_goldlog = array();
			$insert_goldlog['glog_memberid']   = $_SESSION['member_id'];
			$insert_goldlog['glog_membername'] = $_SESSION['member_name'];
			$insert_goldlog['glog_storeid']    = $_SESSION['store_id'];
			$insert_goldlog['glog_storename']  = $_SESSION['store_name'];
			$insert_goldlog['glog_adminid']    = 0;
			$insert_goldlog['glog_adminname']  = '';
			$insert_goldlog['glog_goldnum']    = $goldpay;
			$insert_goldlog['glog_method']     = 1;
			$insert_goldlog['glog_addtime']    = time();
			$insert_goldlog['glog_desc']       = Language::get('adv_self_del_return_gold');
			$insert_goldlog['glog_stage']      = 'adv_buy';
			$goldlog_model->add($insert_goldlog);
			}	
			if($result){
				showMessage(Language::get('adv_del_succ'),'index.php?act=store_adv&op=adv_manage');
			}else{
				showMessage(Language::get('adv_del_failed'),'index.php?act=store_adv&op=adv_manage','html','error');
			}
		}
		
	}
	/**
	 * 购买广告
	 */
	public function adv_buyOp(){
		$adv    = Model('adv');
	    /**
		 * 判断系统是否开启金币功能
		 */
		if (C('gold_isuse') != 1){
			showMessage(Language::get('sys_gold_not_use'),'index.php?act=store_adv&op=adv_manage','html','error');
		}
	   /**
	     * 购买填表
	     */
		if($_GET['do'] != ''){
			$condition['ap_id'] = $_GET['ap_id'];
			$ap_info = $adv->getApList($condition);
			
		    //查询会员现有金币数
		    $member_model = Model('member');
		    $member_array = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));
		    if($member_array['member_goldnum'] <= 0 ){
			     showMessage(Language::get('sorry_you_have_no_gold'),'','html','error');
		    }
			if($_GET['do'] == 'order'){
				Tpl::output('ordertime',$_GET['ordertime']);
			}
	   	    self::profile_menu('adv_buy_add','adv_buy_add');
	   	    Tpl::output('style',$_GET['do']);
	   	    Tpl::output('ap_info',$ap_info['0']);
	   	    Tpl::output('member_array',$member_array);
	   	    Tpl::output('menu_sign','adv');
		    Tpl::output('menu_sign_url','index.php?act=store_adv&op=adv_manage');
		    Tpl::output('menu_sign1','adv_buy');
		    Tpl::showpage('store_adv_buy_add');
		}
		
		//当前会员已经购买的广告列表
		$condition = array();
		$condition['member_id']=$_SESSION['member_id'];
		$condition['field']='ap_id';
		$buy_list=$adv->getList($condition);
		$buy_array = array();
		if(!empty($buy_list) && is_array($buy_list)){
			foreach($buy_list as $val)
				$buy_array[]=$val['ap_id'];
		}
		$condition = array();
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$condition['is_use'] = '1';
		if(!empty($buy_array) && is_array($buy_array)) $condition['adv_buy_id'] = "'".implode("','",$buy_array)."'";
		$ap_info  = $adv->getApList($condition,$page);
		$condition = array();
		$condition['is_allow'] = '1';
		$adv_info = $adv->getList($condition,"","","adv_end_date desc");
	    
		
		/**
		 * 页面输出
		 */
		self::profile_menu('adv','adv_buy');
		Tpl::output('ap_info',$ap_info);
		Tpl::output('adv_info',$adv_info);
		Tpl::output('menu_sign','adv');
		Tpl::output('menu_sign_url','index.php?act=store_adv&op=adv_manage');
		Tpl::output('menu_sign1','adv_buy');
		Tpl::output('show_page',$page->show());
		Tpl::showpage('store_adv_buy');
	}
	/**
	 * 保存广告购买信息
	 */
	public function adv_buy_saveOp(){
		/**
		 * 验证
		 */
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
			    array("input"=>$_POST["adv_title"], "require"=>"true", "message"=>Language::get('advtitle_can_not_null')),
			    array("input"=>$_POST["adv_start_date"], "require"=>"true", "message"=>Language::get('adv_start_date_cannot_null')),
			    array("input"=>$_POST["buy_month"], "require"=>"true", 'validator'=>'Number',"message"=>Language::get('buymonth_must_num')),
			);
		$error = $obj_validate->validate();
		if ($error != ''){
			showValidateError($error);
		}else {
		/**
		 * 将广告信息入库
		 */
		$adv = Model('adv');
		$upload = new UploadFile();
		$goldpay = intval($_POST['ap_price']*$_POST['buy_month']);
		//查询会员现有金币数
		$member_model = Model('member');
		$member_array = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));
		if($member_array['member_goldnum'] < $goldpay ){
			showDialog(Language::get('sorry_you_have_no_gold'),'index.php?act=store_adv&op=adv_manage');
		}
		if(intval($_POST['buy_month']) == '0'){
			showDialog(Language::get('buymonth_must_num_can_not_0'),'index.php?act=store_adv&op=adv_manage');
		}
		//判断页面编码确定汉字所占字节数
		switch (CHARSET){
			case 'UTF-8':
				$charrate = 3;
				break;
			case 'GBK':
				$charrate = 2;
				break;
		}
		$param['ap_id']          = $_POST['ap_id'];
		$param['adv_title']      = $_POST['adv_title'];
        if(intval($_POST['adv_order_flag']) === 1) {
	        $adv_last_end_date = $adv->getLastDateById($param['ap_id']);
            $param['adv_start_date'] =  $adv_last_end_date;
        }
        else {
            $param['adv_start_date'] = $this->getunixtime($_POST['adv_start_date']);
        }
		$param['adv_end_date']   = $param['adv_start_date']+$_POST['buy_month']*2592000;//基本购买周期为一个月，一个月按30天计算，30天=2592000秒
		$param['member_id']      = $_SESSION['member_id'];
		$param['member_name']    = $member_array['member_name'];
		$param['buy_style']      = $_POST['style'];
		$param['goldpay']        = $goldpay;
		switch ($_POST['advclass']){
			case '0':
		        if($_FILES['adv_pic']['name'] == '' ){
					showDialog(Language::get('please_upload_pic'),'');
				}
				$upload->set('default_dir',ATTACH_ADV);
				$result	= $upload->upfile('adv_pic');
				if(!$result){
					showDialog($upload->error);
				}
				$ac = array(
					'adv_pic'     =>$upload->file_name,
					'adv_pic_url' =>$_POST['adv_pic_url']
					);
				$ac = serialize($ac);
				$param['adv_content'] = $ac;
				break;
			case '1':
				if(strlen($_POST['adv_word'])>($_POST['word_len_limit']*$charrate)){
						$error = Language::get('wordadv_info_too_long');
						showDialog($error);
				}
				$ac = array(
					'adv_word'    =>$_POST['adv_word'],
					'adv_word_url'=>$_POST['adv_word_url']
				);
				$ac = serialize($ac);
				$param['adv_content'] = $ac;
				break;
			case '2':
				if($_FILES['adv_slide_pic']['name'] == '' ){
					showDialog(Language::get('please_upload_pic'));
				}
				$upload->set('default_dir',ATTACH_ADV);	
				$result	= $upload->upfile('adv_slide_pic');
				if(!$result){
					showDialog($upload->error);
				}
				$ac = array(
					'adv_slide_pic'  =>$upload->file_name,
					'adv_slide_url'  =>$_POST['adv_slide_url']
					);
				$ac = serialize($ac);
				$param['adv_content'] = $ac;
				break;
			case '3':
				if($_FILES['flash_swf']['name'] == '' ){
					showDialog(Language::get('please_upload_swf'));
				}
				$upload->set('default_dir',ATTACH_ADV);
				$result	= $upload->upfile('flash_swf');
				if(!$result){
					showDialog($upload->error);
				}
				$ac = array(
					'flash_swf'  =>$upload->file_name,
					'flash_url'  =>$_POST['flash_url']
					);
				$ac = serialize($ac);
				$param['adv_content'] = $ac;
				break;
		}
		$result = $adv->adv_add($param);
		//修改用户金币信息
		$newmember_goldnum = intval($member_array['member_goldnum']) - $goldpay;
		$newmember_goldnumminus = intval($member_array['member_goldnumminus']) + $goldpay;
		$result2 = $member_model->updateMember(array('member_goldnum'=>$newmember_goldnum,'member_goldnumminus'=>$newmember_goldnumminus),$_SESSION['member_id']);
		//添加金币日志
		$goldlog_model  = Model('gold_log');
		$insert_goldlog = array();
		$insert_goldlog['glog_memberid']   = $_SESSION['member_id'];
		$insert_goldlog['glog_membername'] = $_SESSION['member_name'];
		$insert_goldlog['glog_storeid']    = $_SESSION['store_id'];
		$insert_goldlog['glog_storename']  = $_SESSION['store_name'];
		$insert_goldlog['glog_adminid']    = 0;
		$insert_goldlog['glog_adminname']  = '';
		$insert_goldlog['glog_goldnum']    = $goldpay;
		$insert_goldlog['glog_method']     = 2;
		$insert_goldlog['glog_addtime']    = time();
		$insert_goldlog['glog_desc']       = Language::get('buy_webinner_adv');
		$insert_goldlog['glog_stage']      = 'adv_buy';
		$result3 = $goldlog_model->add($insert_goldlog);
		
		if($result&&$result2&&$result3){
			showDialog(Language::get('adv_buy_succ'),'index.php?act=store_adv&op=adv_manage','succ');
		}else{
			showDialog(Language::get('adv_buy_failed'),'index.php?act=store_adv&op=adv_manage');
		}
	  }			
	}
	/**
	 * Flex广告统计图
	 */
	public function adv_click_chartOp(){
		$adv  = Model('adv');
    	if(!empty($_POST['formsubmit'])&&$_POST['formsubmit'] == 'ok'){
    		$adv_id = intval($_POST['adv_id']);
    		$year   = $_POST['year'];
    	}else{
    		$adv_id = intval($_GET['adv_id']);
    	    $date   = date('Y-m-d',time());
    	    $date   = explode('-', $date);
    	    $year   = $date['0'];
    	}
    	/**
    	 * 获取广告点击率数据
    	 */
    	$condition['adv_id']     = $adv_id;
    	$condition['click_year'] = $year;
    	$click_info = $adv->getclickinfo($condition);
    	if(empty($click_info)){
    		$msg = Language::get('adv_click_chart_nothing_left').$year.Language::get('adv_click_chart_nothing_right');
    		showMessage($msg,'','html','error');die;
    	}
    	/**
    	 * 生成广告点击率信息的xml
    	 */
    	$adv->makexml("resource",$click_info);
    	$param['adv_id'] = intval($_GET['adv_id']);
		$adv_list = $adv->getList($param);
		$adv_list = $adv_list['0'];
		/**
		 * 页面输出
		 */
		self::profile_menu('adv_click','adv_click');
    	Tpl::output('year',$year);
    	Tpl::output('adv_title',$adv_list['adv_title']);
    	Tpl::output('adv_id',intval($_GET['adv_id']));
    	Tpl::output('menu_sign','adv');
		Tpl::output('menu_sign_url','index.php?act=store_adv&op=adv_manage');
		Tpl::output('menu_sign1','adv_click');
		Tpl::showpage('store_adv_click');
	}
	/**
	 * 广告续期
	 */
	public function adv_addtimeOp(){
	    /**
		 * 判断系统是否开启金币功能
		 */
		if ($GLOBALS['setting_config']['gold_isuse'] != 1){
			showMessage(Language::get('sys_gold_not_use2'),'index.php?act=store_adv&op=adv_manage','html','error');
		}
		$adv  = Model('adv');
		if(!empty($_POST['formsubmit'])&&$_POST['formsubmit'] == 'ok'){
			$adv_id = intval($_POST['adv_id']);
	    /**
		 * 验证
		 */
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
			    array("input"=>$_POST["buy_month"], "require"=>"Number", "message"=>Language::get('adv_buymonth_must_num')),
			);
		$error = $obj_validate->validate();
		if ($error != ''){
			showMessage($error,'','html','error');
		}else {
		$goldpay = intval($_POST['ap_price']*$_POST['buy_month']);
		//查询会员现有金币数
		$member_model = Model('member');
		$member_array = $member_model->infoMember(array('member_id'=>$_SESSION['member_id']));
	    if($member_array['member_goldnum'] < $goldpay ){
		     showMessage(Language::get('sorry_you_have_no_gold'),'','html','error');
	    }
		//修改用户金币信息
		$newmember_goldnum = intval($member_array['member_goldnum']) - $goldpay;
		$newmember_goldnumminus = intval($member_array['member_goldnumminus']) + $goldpay;
		$result = $member_model->updateMember(array('member_goldnum'=>$newmember_goldnum,'member_goldnumminus'=>$newmember_goldnumminus),$_SESSION['member_id']);
		//添加金币日志
		$goldlog_model  = Model('gold_log');
		$insert_goldlog = array();
		$insert_goldlog['glog_memberid']   = $_SESSION['member_id'];
		$insert_goldlog['glog_membername'] = $_SESSION['member_name'];
		$insert_goldlog['glog_storeid']    = $_SESSION['store_id'];
		$insert_goldlog['glog_storename']  = $_SESSION['store_name'];
		$insert_goldlog['glog_adminid']    = 0;
		$insert_goldlog['glog_adminname']  = '';
		$insert_goldlog['glog_goldnum']    = $goldpay;
		$insert_goldlog['glog_method']     = 2;
		$insert_goldlog['glog_addtime']    = time();
		$insert_goldlog['glog_desc']       = Language::get('add_adv_time');
		$insert_goldlog['glog_stage']      = 'adv_buy';
		$result2 = $goldlog_model->add($insert_goldlog);
		//修改广告信息
		$param['adv_id']       = $adv_id;
		$param['adv_end_date'] = $_POST['overtime']+$_POST['buy_month']*2592000;
		$result3 = $adv->update($param);
		//更新广告缓存
		$adv->makeAdvCache($adv_id);
		$param['adv_id'] = intval($_GET['adv_id']);
		$adv_list = $adv->getList($param);
		$adv_list = $adv_list['0'];
		$adv->makeApCache($adv_list['ap_id']);
		if($result&&$result2&&$result3){
			showMessage(Language::get('add_adv_time_succ'),'index.php?act=store_adv&op=adv_manage');
		}else{
			showMessage(Language::get('add_adv_time_failed'),'index.php?act=store_adv&op=adv_manage','html','error');
		}
		}
		}
		$param['adv_id'] = intval($_GET['adv_id']);
		$adv_list = $adv->getList($param);
		$adv_list = $adv_list['0'];
		$condition['ap_id'] = $adv_list['ap_id'];
		$ap_list  = $adv->getApList($condition);
		$ap_list  = $ap_list['0'];
		/**
		 * 页面输出
		 */
		self::profile_menu('adv_addtime','adv_addtime');
		Tpl::output('adv_list',$adv_list);
		Tpl::output('ap_list',$ap_list);
		Tpl::output('menu_sign','adv');
		Tpl::output('menu_sign_url','index.php?act=store_adv&op=adv_manage');
		Tpl::output('menu_sign1','adv_buy');
		Tpl::showpage('store_adv_addtime');
	}	
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return 
	 */
	private function profile_menu($menu_type,$menu_key='') {
		Language::read('member_layout');
		$lang	= Language::getLangContent();
		$menu_array		= array();
		switch ($menu_type) {
		    case 'adv':
				$menu_array = array(
				1=>array('menu_key'=>'adv','menu_name'=>Language::get('nc_member_path_adv'),'menu_url'=>'index.php?act=store_adv&op=adv_manage'),
				2=>array('menu_key'=>'adv_buy','menu_name'=>Language::get('nc_member_path_adv_buy'),'menu_url'=>'index.php?act=store_adv&op=adv_buy')
				);
				break;
			case 'adv_edit':
				$menu_array = array(
				1=>array('menu_key'=>'adv','menu_name'=>Language::get('nc_member_path_adv'),'menu_url'=>'index.php?act=store_adv&op=adv_manage'),
				2=>array('menu_key'=>'adv_buy','menu_name'=>Language::get('nc_member_path_adv_buy'),'menu_url'=>'index.php?act=store_adv&op=adv_buy'),
				3=>array('menu_key'=>'adv_edit','menu_name'=>Language::get('nc_member_path_adv_edit'),'menu_url'=>'javascript:;')
				);
				break;
			case 'adv_buy_add':
				$menu_array = array(
				1=>array('menu_key'=>'adv','menu_name'=>Language::get('nc_member_path_adv'),'menu_url'=>'index.php?act=store_adv&op=adv_manage'),
				2=>array('menu_key'=>'adv_buy','menu_name'=>Language::get('nc_member_path_adv_buy'),'menu_url'=>'index.php?act=store_adv&op=adv_buy'),
				3=>array('menu_key'=>'adv_buy_add','menu_name'=>Language::get('nc_member_path_adv_buy_add'),'menu_url'=>'javascript:;')
				);
				break;
			case 'adv_click':
				$menu_array = array(
				1=>array('menu_key'=>'adv','menu_name'=>Language::get('nc_member_path_adv'),'menu_url'=>'index.php?act=store_adv&op=adv_manage'),
				2=>array('menu_key'=>'adv_buy','menu_name'=>Language::get('nc_member_path_adv_buy'),'menu_url'=>'index.php?act=store_adv&op=adv_buy'),
				3=>array('menu_key'=>'adv_click','menu_name'=>Language::get('adv_click_chart'),'menu_url'=>'javascript:;')
				);
				break;
			case 'adv_addtime':
				$menu_array = array(
				1=>array('menu_key'=>'adv','menu_name'=>Language::get('nc_member_path_adv'),'menu_url'=>'index.php?act=store_adv&op=adv_manage'),
				2=>array('menu_key'=>'adv_buy','menu_name'=>Language::get('nc_member_path_adv_buy'),'menu_url'=>'index.php?act=store_adv&op=adv_buy'),
				3=>array('menu_key'=>'adv_addtime','menu_name'=>Language::get('add_adv_time_s'),'menu_url'=>'javascript:;')
				);
				break;			
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
    public function getunixtime($time){
		$array     = explode("-", $time);
		$unix_time = mktime(0,0,0,$array[1],$array[2],$array[0]);
		return $unix_time;
	}
	/**
	 * 生成广告修改时存储修改内容的临时文件
	 */
	public function makeadvchangefile($adv_id,$content){
		/**
	     * 生成文件
		 */
		$tmp .= "<?php \r\n";
		$tmp .= "defined('InShopNC') or exit('Access Invalid!'); \r\n";
		$tmp .= '$adv_id = '.$adv_id.";\r\n";
		$tmp .= '$content = '."'".$content."'".";\r\n";
		//临时文件存放位置及文件名
		$cache_file = BasePath.DS.'cache'.DS.'adv_change'.DS.'adv_'.$adv_id.'.change.php';
		$fp = @fopen($cache_file,'wb+');
		@fwrite($fp,$tmp);
		@fclose($fp);
		return true;
	}
}
