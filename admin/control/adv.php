<?php
/**
 * 广告管理
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

class advControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('adv');
	}
	/**
	 * 更新广告缓存
	 */
	public function adv_cache_refreshOp(){
		$lang = Language::getLangContent();
		$time     = time();
		$adv      = Model('adv');
		//清空广告缓存文件夹
		$dirName= BasePath.DS.'cache'.DS.'adv';
		$handle = opendir($dirName);
        while(($file = readdir($handle)) !== false){
           if($file != '.' && $file != '..' && $file != '.svn'){
           	    $file = BasePath.DS.'cache'.DS.'adv'.DS.$file;
                unlink($file);
           }
        }
        closedir($handle);
		//更新广告缓存
		$adv_info = $adv->getList(array());
		$ap_array = array();
		foreach ($adv_info as $k=>$v){
			$ap_array[$v['ap_id']][] = $v;
			if($v['adv_end_date'] > $time && $v['is_allow'] == '1'){
				$adv->makeAdvCache($v);
			}else{
				$adv->deladcache($v['adv_id'], "adv");
			}
		}
		//更新广告位缓存
		$ap_info  = $adv->getApList();
		foreach ($ap_info as $k=>$v){
			$adv->makeApCache($v,$ap_array[$v['ap_id']]);
		}
		$url = array(
						array(
							'url'=>'index.php?act=adv&op=adv',
							'msg'=>$lang['goback_adv_manage'],
						),
					);
		showMessage($lang['adv_cache_refresh_done'],$url);
	}
	/**
	 * 广告审核
	 */
	public function adv_checkOp(){
		$lang = Language::getLangContent();
		$adv  = Model('adv');
		//申请广告详情展示
		if($_GET['do'] == 'check'){
			$lang = Language::getLangContent();
		    $adv  = Model('adv');
		    $condition['adv_id'] = intval($_GET['adv_id']);
		    $adv_list = $adv->getList($condition);
		    $adv_list = $adv_list[0];
		    $ap_info  = $adv->getApList();
		    foreach ($ap_info as $ap_k => $ap_v){
				 	if($adv_list['ap_id'] == $ap_v['ap_id']){
				 		$ap_info = $ap_v;
				 		break;
				 	}
		    }
		    Tpl::output('adv_list',$adv_list);
		    Tpl::output('ap_info',$ap_info);
			Tpl::showpage('adv_check_view');
		}
		//保存广告的审核结果
		if ($_GET['savecheck'] == 'yes'){//通过
			$param['is_allow'] = '1';
			$getadvinfo['adv_id'] = intval($_GET['adv_id']);
			$advinfo = $adv->getList($getadvinfo);
			$advinfo = $advinfo['0'];
			if($advinfo['buy_style'] == 'change'){
			$cache_file = BasePath.DS.'cache'.DS.'adv_change'.DS.'adv_'.intval($_GET['adv_id']).'.change.php';
		    include $cache_file;
		    $param['adv_content'] = $content;
		    unlink($cache_file);
			}
			$param['adv_id']   = intval($_GET['adv_id']);
			$result = $adv->update($param);
			//生成广告缓存更新或生成相应广告位缓存
			$adv->makeAdvCache(intval($_GET['adv_id']));
			$adv->makeApCache(intval($_GET['ap_id']));
		    if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=adv&op=adv_check',
							'msg'=>$lang['goback_to_adv_check'],
						),
					);
					showMessage($lang['adv_check_ok'],$url);
				}else {
					showMessage($lang['adv_check_failed']);
				}
		}
		if($_GET['savecheck'] == 'no'){//不通过
			$getadvinfo['adv_id'] = intval($_GET['adv_id']);
			$advinfo = $adv->getList($getadvinfo);
			$advinfo = $advinfo['0'];
			if($advinfo['buy_style'] == 'change'){
				$param['is_allow'] = '1';
			    $param['adv_id']   = intval($_GET['adv_id']);
			    $result = $adv->update($param);
			    $cache_file = BasePath.DS.'cache'.DS.'adv_change'.DS.'adv_'.intval($_GET['adv_id']).'.change.php';
			    unlink($cache_file);
				$result2 = true;
				$result3 = true;
			}else{
			$param['is_allow'] = '2';
			$param['adv_id']   = intval($_GET['adv_id']);
			$result = $adv->update($param);
			//查询会员现有金币数
		    $member_model = Model('member');
		    $member_array = $member_model->infoMember(array('member_name'=>$advinfo['member_name']));
		    //修改用户金币信息
		    $goldpay = $advinfo['goldpay'];
		    $newmember_goldnum = intval($member_array['member_goldnum']) + $goldpay;
		    $newmember_goldnumcount = intval($member_array['member_goldnumcount']) + $goldpay;
		    $result2 = $member_model->updateMember(array('member_goldnum'=>$newmember_goldnum,'member_goldnumcount'=>$newmember_goldnumcount),$member_array['member_id']);
		    //添加金币日志
		    $goldlog_model  = Model('gold_log');
		    $insert_goldlog = array();
		    $insert_goldlog['glog_memberid']   = $member_array['member_id'];
		    $insert_goldlog['glog_membername'] = $member_array['member_name'];
		    $insert_goldlog['glog_storeid']    = $member_array['store_id'];
		    $insert_goldlog['glog_storename']  = $member_array['store_name'];
		    $insert_goldlog['glog_adminid']    = 0;
		    $insert_goldlog['glog_adminname']  = '';
		    $insert_goldlog['glog_goldnum']    = $goldpay;
		    $insert_goldlog['glog_method']     = 1;
		    $insert_goldlog['glog_addtime']    = time();
		    $insert_goldlog['glog_desc']       = $lang['return_goldpay'];
		    $insert_goldlog['glog_stage']      = 'adv_buy';
		    $result3 = $goldlog_model->add($insert_goldlog);
			}
		    if ($result&&$result2&&$result3){
					$url = array(
						array(
							'url'=>'index.php?act=adv&op=adv_check',
							'msg'=>$lang['goback_to_adv_check'],
						),
					);
					showMessage($lang['adv_check_ok'],$url);
				}else {
					showMessage($lang['adv_check_failed']);
				}
		}
       /**
		 * 分页
		 */
		$page	 = new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		/**
		 * 查询条件
		 */
        $condition = array();
		$condition['is_allow'] = '0';
		switch ($_GET['style']){
			case 'buy':
				$condition['buy_style'] = 'buy';
				break;
			case 'order':
				$condition['buy_style'] = 'order';
				break;
			case 'change':
				$condition['buy_style'] = 'change';
				break;
			case 'noallow':
				$condition['is_allow'] = '2';
				break;
		}
		$limit     = '';
		$orderby   = '';
		if($_GET['search_name'] != ''){
			$condition['adv_title'] = trim($_GET['search_name']);
		}
		if($_GET['add_time_from'] != ''){
			$condition['add_time_from'] = $this->getunixtime(trim($_GET['add_time_from']));
		}
	    if($_GET['add_time_to'] != ''){
			$condition['add_time_to'] = $this->getunixtime(trim($_GET['add_time_to']));
		}
        $adv_info = $adv->getList($condition,$page,$limit,$orderby);
		$ap_info  = $adv->getApList();
		Tpl::output('adv_info',$adv_info);
		Tpl::output('ap_info',$ap_info);
		Tpl::output('page',$page->show());
		Tpl::showpage('adv_check.index');
	}
	/**
	 * 
	 * 管理员添加广告
	 */
	public function adv_addOp(){
		if(!chksubmit()){
			$lang = Language::getLangContent();
		    $adv  = Model('adv');
		    /**
		     * 取广告位信息
		     */
		    $ap_list = $adv->getApList();
		    Tpl::output('ap_list',$ap_list);
		    Tpl::showpage('adv_add');
		}else{
			$lang = Language::getLangContent();
			$adv  = Model('adv');
		    $upload		= new UploadFile();
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$validate_arr = array();
			$validate_arr[] = array("input"=>$_POST["adv_name"], "require"=>"true", "message"=>$lang['adv_can_not_null']);
			$validate_arr[] = array("input"=>$_POST["aptype_hidden"], "require"=>"true", "message"=>$lang['must_select_ap']);
			$validate_arr[] = array("input"=>$_POST["ap_id"], "require"=>"true", "message"=>$lang['must_select_ap']);
			$validate_arr[] = array("input"=>$_POST["adv_start_time"], "require"=>"true", "message"=>$lang['must_select_start_time']);
			$validate_arr[] = array("input"=>$_POST["adv_end_time"], "require"=>"true", "message"=>$lang['must_select_end_time']);
			if ($_POST["aptype_hidden"] == '1'){
				//文字广告
				$validate_arr[] = array("input"=>$_POST["adv_word"], "require"=>"true", "message"=>$lang['textadv_null_error']);
			}elseif ($_POST["aptype_hidden"] == '2'){
				//幻灯片广告
				$validate_arr[] = array("input"=>$_FILES['adv_slide_pic']['name'], "require"=>"true", "message"=>$lang['slideadv_null_error']);
				$validate_arr[] = array("input"=>$_POST["adv_slide_sort"], "require"=>"true", "message"=>$lang['slideadv_sortnull_error']);
			}elseif ($_POST["aptype_hidden"] == '3'){
				//flash广告
				$validate_arr[] = array("input"=>$_FILES['flash_swf']['name'], "require"=>"true", "message"=>$lang['flashadv_null_error']);
			}else {
				//图片广告
				$validate_arr[] = array("input"=>$_FILES['adv_pic']['name'], "require"=>"true", "message"=>$lang['picadv_null_error']);
			}
			$obj_validate->validateparam = $validate_arr;
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$insert_array['adv_title']       = trim($_POST['adv_name']);
				$insert_array['ap_id']  		 = intval($_POST['ap_id']);
				$insert_array['adv_start_date']  = $this->getunixtime($_POST['adv_start_time']);
				$insert_array['adv_end_date']    = $this->getunixtime($_POST['adv_end_time']);
				$insert_array['is_allow']        = '1';
				/**
				 * 建立文字广告信息的入库数组
				 */
				//判断页面编码确定汉字所占字节数
			    switch (CHARSET){
				   case 'UTF-8':
					  $charrate = 3;
					  break;
				   case 'GBK':
					  $charrate = 2;
					  break;
			    }
				//图片广告
				if($_POST['aptype_hidden'] == '0'){
					$upload->set('default_dir',ATTACH_ADV);
					$result	= $upload->upfile('adv_pic');
					if (!$result){
						showMessage($upload->error,'','','error');
					}
					$ac = array(
					'adv_pic'     =>$upload->file_name,
					'adv_pic_url' =>trim($_POST['adv_pic_url'])
					);
					$ac = serialize($ac);
					$insert_array['adv_content'] = $ac;
				}
				//文字广告
				if($_POST['aptype_hidden'] == '1'){
					if(strlen($_POST['adv_word'])>($_POST['adv_word_len']*$charrate)){
						$error = $lang['wordadv_toolong'];
						showMessage($error);die;
					}
					$ac = array(
					'adv_word'    =>trim($_POST['adv_word']),
					'adv_word_url'=>trim($_POST['adv_word_url'])
					);
					$ac = serialize($ac);
					$insert_array['adv_content'] = $ac;
				}
				//建立幻灯片广告信息的入库数组
				if($_POST['aptype_hidden'] == '2'){
					$upload->set('default_dir',ATTACH_ADV);
					$upload->upfile('adv_slide_pic');
					$ac = array(
					'adv_slide_pic'  =>$upload->file_name,
					'adv_slide_url'  =>trim($_POST['adv_slide_url'])
					);
					$ac = serialize($ac);
					$insert_array['adv_content'] = $ac;
					$insert_array['slide_sort']  = trim($_POST['adv_slide_sort']);
				}
				//建立Flash广告信息的入库数组
				if($_POST['aptype_hidden'] == '3'){
					$upload->set('default_dir',ATTACH_ADV);
					$upload->upfile('flash_swf');
					$ac = array(
					'flash_swf'  =>$upload->file_name,
					'flash_url'  =>trim($_POST['flash_url'])
					);
					$ac = serialize($ac);
					$insert_array['adv_content'] = $ac;
				}
				//广告信息入库
				$result = $adv->adv_add($insert_array);
				//更新相应广告位所拥有的广告数量
				$condition['ap_id'] = intval($_POST['ap_id']);
				$ap_list = $adv->getApList($condition);
				$ap_list = $ap_list['0'];
				$adv_num = $ap_list['adv_num'];
				$param['ap_id']   = intval($_POST['ap_id']);
				$param['adv_num'] = $adv_num+1;
				$result2 = $adv->ap_update($param);
				//生成广告的缓存及更新相应广告位的缓存
				$adv_info = $adv->getList(array(),"","","adv_id desc");
				$adv_info = $adv_info['0'];
				$adv->makeAdvCache($adv_info['adv_id']);
				$adv->makeApCache(intval($_POST['ap_id']));
			    if ($result&&$result2){
//					$url = array(
//						array(
//							'url'=>'index.php?act=adv&op=adv',
//							'msg'=>$lang['goback_adv_manage'],
//						),
//						array(
//							'url'=>'index.php?act=adv&op=adv_add',
//							'msg'=>$lang['resume_adv_add'],
//						),
//					);
					showMessage($lang['adv_add_succ'],'index.php?act=adv&op=adv');
				}else {
					showMessage($lang['adv_add_fail']);
				}
		}
	  }
	}
	/**
	 * 
	 * 管理广告位
	 */
	public function ap_manageOp(){
		$lang = Language::getLangContent();
		$adv  = Model('adv');
		/**
		 * 修改广告位使用状态
		 */
		if($_GET['do'] == 'stat_change'){
			if($_GET['stat'] == '1'){
				$param['is_use'] = '0';
			}else{
				$param['is_use'] = '1';
			}
				$where  = "where ap_id = ".intval($_GET['ap_id']);
				$result = Db::update("adv_position",$param,$where);
				//更新广告位缓存
				$adv->makeApCache(intval($_GET['ap_id']));
			if (!$result){
					$url = array(
						array(
							'url'=>'index.php?act=adv&op=adv',
							'msg'=>$lang['goback_adv_manage'],
						),
						array(
							'url'=>'index.php?act=adv&op=ap_manage',
							'msg'=>$lang['goback_ap_manage'],
						),
					);
					showMessage($lang['ap_stat_edit_fail'],$url);die;
				}
		}
		/**
		 * 删除一个广告位
		 */
		if($_GET['do'] == 'del'){
			$result  = $adv->ap_del(intval($_GET['ap_id']));
		    if (!$result){
					$url = array(
						array(
							'url'=>'index.php?act=adv&op=adv',
							'msg'=>$lang['goback_adv_manage'],
						),
						array(
							'url'=>'index.php?act=adv&op=ap_manage',
							'msg'=>$lang['goback_ap_manage'],
						),
					);
					showMessage($lang['ap_del_fail'],$url);die;
				}else{
					showMessage($lang['ap_del_succ'],$url);die;
				}
		}
		/**
		 * 多选删除广告位
		 */
	    if ($_POST['form_submit'] == 'ok'){
			if (!empty($_POST['del_id'])){
				$in_array_id=implode(',',$_POST['del_id']);
				$where  = "where ap_id in (".$in_array_id.")";
			    Db::delete("adv_position",$where);
			}
			$url = array(
						array(
							'url'=>trim($_POST['ref_url']),
							'msg'=>$lang['goback_ap_manage'],
						)
					);
			showMessage($lang['ap_del_succ'],$url);
		}
		/**
		 * 显示广告位管理界面
		 */
		$condition = array();
		$orderby   = '';
		if($_GET['search_name'] != ''){
			$condition['ap_name'] = trim($_GET['search_name']);
		}
		if($_GET['order'] == 'clicknum'){
			$orderby = 'click_num desc';
		}
		/**
		 * 分页
		 */
		$page	 = new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$ap_list  = $adv->getApList($condition,$page,$orderby);
		$adv_list = $adv->getList();
		$click_list = $adv->getClickList();
 		Tpl::output('ap_list',$ap_list);
 		Tpl::output('adv_list',$adv_list);
 		Tpl::output('click_list',$click_list);
 		Tpl::output('page',$page->show());
		Tpl::showpage('ap_manage');
	}
	/**
	 * js代码调用
	 */
	public function ap_copyOp(){
		Tpl::showpage('ap_copy', 'null_layout');
	}
	/**
	 * 
	 * 修改广告位
	 */
	public function ap_editOp(){
		if(!chksubmit()){
		     $lang = Language::getLangContent();
		     $adv  = Model('adv');
		     $condition['ap_id'] = intval($_GET['ap_id']);
		     $ap_list = $adv->getApList($condition);
			 Tpl::output('ref_url',getReferer());
		     Tpl::output('ap_list',$ap_list);
		     Tpl::showpage('ap_edit');
		}else{
			$lang = Language::getLangContent();
			$adv  = Model('adv');
		    $upload		= new UploadFile();
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			if($_POST['ap_class'] == '1'){
				$obj_validate->validateparam = array(
			    array("input"=>$_POST["ap_name"], "require"=>"true", "message"=>$lang['ap_can_not_null']),
//				array("input"=>$_POST["ap_price"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_price_must_num']),
				array("input"=>$_POST["ap_width"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_width_must_num']),
			    );
			}else{
				$obj_validate->validateparam = array(
			    array("input"=>$_POST["ap_name"], "require"=>"true", "message"=>$lang['ap_can_not_null']),
//				array("input"=>$_POST["ap_price"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_price_must_num']),
				array("input"=>$_POST["ap_width"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_width_must_num']),
				array("input"=>$_POST["ap_height"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_height_must_num']),
			    );
			}
			
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$param['ap_id']      = intval($_GET['ap_id']);
				$param['ap_name']    = trim($_POST["ap_name"]);
				$param['ap_intro']   = trim($_POST["ap_intro"]);
//				$param['ap_price']   = intval(trim($_POST["ap_price"]));
				$param['ap_width']   = intval(trim($_POST["ap_width"]));
				$param['ap_height']  = intval(trim($_POST["ap_height"]));
				if($_POST["ap_display"] != ''){
					$param['ap_display'] = intval($_POST["ap_display"]);
				}
				if($_POST["is_use"] != ''){
					$param['is_use']     = intval($_POST["is_use"]);
				}
			    if($_FILES['default_pic']['name'] != ''){
			    	$upload->set('default_dir',ATTACH_ADV);
					$result = $upload->upfile('default_pic');
			    	if (!$result){
						showMessage($upload->error,'','','error');
					}					
					$param['default_content'] = $upload->file_name;
				}
				if($_POST['default_word'] != ''){
					$param['default_content'] = trim($_POST['default_word']);
				}
				$result = $adv->ap_update($param);
				//重新生成广告位缓存
				$adv->makeApCache(intval($_GET['ap_id']));
			    if ($result){
//					$url = array(
//						array(
//							'url'=>'index.php?act=adv&op=adv',
//							'msg'=>$lang['goback_adv_manage'],
//						),
//						array(
//							'url'=>trim($_POST['ref_url']),
//							'msg'=>$lang['goback_ap_manage'],
//						),
//					);
					showMessage($lang['ap_change_succ'],$_POST['ref_url']);
				}else {
					showMessage($lang['ap_change_fail']	,$url);
				}
			}
		}
	}
	/**
	 * 
	 * 新增广告位
	 */
	public function ap_addOp(){
		if($_POST['form_submit'] != 'ok'){
			$lang = Language::getLangContent();
		    Tpl::showpage('ap_add');
		}else{
			$lang = Language::getLangContent();
			$adv  = Model('adv');
		    $upload		= new UploadFile();
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			if($_POST['ap_class'] == '1'){
				$obj_validate->validateparam = array(
			    array("input"=>$_POST["ap_name"], "require"=>"true", "message"=>$lang['ap_can_not_null']),
//				array("input"=>$_POST["ap_price"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_price_must_num']),
				array("input"=>$_POST["ap_width_word"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_wordwidth_must_num']),
				array("input"=>$_POST["default_word"], "require"=>"true", "message"=>$lang['default_word_can_not_null']),
			);
			}else{
				$obj_validate->validateparam = array(
			    array("input"=>$_POST["ap_name"], "require"=>"true", "message"=>$lang['ap_can_not_null']),
//				array("input"=>$_POST["ap_price"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_price_must_num']),
				array("input"=>$_POST["ap_width_media"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_width_must_num']),
				array("input"=>$_POST["ap_height"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['ap_height_must_num']),
				array("input"=>$_FILES["default_pic"], "require"=>"true", "message"=>$lang['default_pic_can_not_null']),
			);
			}
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$insert_array['ap_name']    = trim($_POST['ap_name']);
				$insert_array['ap_intro']   = trim($_POST['ap_intro']);
				$insert_array['ap_class']   = intval($_POST['ap_class']);
				$insert_array['ap_display'] = intval($_POST['ap_display']);
				$insert_array['is_use']     = intval($_POST['is_use']);
				if($_POST['ap_width_media'] != ''){
					$insert_array['ap_width']  = intval(trim($_POST['ap_width_media']));
				}
			    if($_POST['ap_width_word'] != ''){
					$insert_array['ap_width']  = intval(trim($_POST['ap_width_word']));
				}
				if($_POST['default_word'] != ''){
					$insert_array['default_content'] = trim($_POST['default_word']);
				}
				if($_FILES['default_pic']['name'] != ''){
					$upload->set('default_dir',ATTACH_ADV);
					$result = $upload->upfile('default_pic');
					if (!$result){
						showMessage($upload->error,'','','error');
					}
					$insert_array['default_content'] = $upload->file_name;
				}
				$insert_array['ap_height'] = intval(trim($_POST['ap_height']));
//				$insert_array['ap_price']  = intval(trim($_POST['ap_price']));
			    $result  = $adv->ap_add($insert_array);
			    //生成广告位缓存
			    $ap_info = $adv->getApList("","","ap_id desc");
			    $ap_info = $ap_info['0'];
			    $ap_id   = $ap_info['ap_id'];
			    $adv->makeApCache($ap_id);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=adv&op=ap_manage',
							'msg'=>$lang['goback_ap_manage'],
						),
						array(
							'url'=>'index.php?act=adv&op=ap_add',
							'msg'=>$lang['resume_ap_add'],
						),
					);
					showMessage($lang['ap_add_succ'],$url,'html','succ',1,4000);
				}else {
					showMessage($lang['ap_add_fail']);
				}
			}
		}
	}
	/**
	 * 
	 * 广告管理
	 */
	public function advOp(){
		$lang = Language::getLangContent();
		$adv  = Model('adv');
		if ($_POST['form_submit'] == 'ok'){
			if (is_array($_POST['del_id']) && !empty($_POST['del_id'])){
				$in_array_id = "'".implode("','", $_POST['del_id'])."'";
				$where  = "where adv_id in (".$in_array_id.")";
			    Db::delete("adv",$where);
			}
			$url = array(
						array(
							'url'=>getReferer(),
							'msg'=>$lang['goback_adv_manage'],
						)
					);
			showMessage($lang['adv_del_succ'],$url);
		}
		/**
		 * 分页
		 */
		$page	 = new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$condition = array();
		$condition['is_allow'] = '1';
		$limit     = '';
		$orderby   = '';
		if($_GET['overtime'] == '1'){
			$condition['adv_end_date'] = 'over';
		}
		if($_GET['overtime'] == '0'){
			$condition['adv_end_date'] = 'notover';
		}
		if($_GET['search_name'] != ''){
			$condition['adv_title'] = trim($_GET['search_name']);
		}
		if($_GET['add_time_from'] != ''){
			$condition['add_time_from'] = $this->getunixtime(trim($_GET['add_time_from']));
		}
	    if($_GET['add_time_to'] != ''){
			$condition['add_time_to'] = $this->getunixtime(trim($_GET['add_time_to']));
		}
		if($_GET['order'] == 'clicknum'){
			$orderby = 'click_num desc';
		}
		$adv_info = $adv->getList($condition,$page,$limit,$orderby);
		$ap_info  = $adv->getApList();
		$click_info = $adv->getClickList();
		
		Tpl::output('adv_info',$adv_info);
		Tpl::output('ap_info',$ap_info);
		Tpl::output('click_info',$click_info);
		Tpl::output('page',$page->show());
		Tpl::showpage('adv.index');
	}
	/**
	 * 
	 * 修改广告
	 */
    public function adv_editOp(){
    	if($_POST['form_submit'] != 'ok'){
    		 $lang = Language::getLangContent();
		     $adv  = Model('adv');
		     $condition['adv_id'] = intval($_GET['adv_id']);
		     $adv_list = $adv->getList($condition);
		     $ap_info  = $adv->getApList();
			 Tpl::output('ref_url',getReferer());
		     Tpl::output('adv_list',$adv_list);
		     Tpl::output('ap_info',$ap_info);
		     Tpl::showpage('adv.edit');
    	}else{
    		$lang = Language::getLangContent();
    	    $adv  = Model('adv');
		    $upload		= new UploadFile();
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
			    array("input"=>$_POST["adv_name"], "require"=>"true", "message"=>$lang['ap_can_not_null']),
				array("input"=>$_POST["adv_start_date"], "require"=>"true","message"=>$lang['must_select_start_time']),
				array("input"=>$_POST["adv_end_date"], "require"=>"true", "message"=>$lang['must_select_end_time'])
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$param['adv_id']         = intval($_GET['adv_id']);
				$param['adv_title']      = trim($_POST['adv_name']);
				$param['adv_start_date'] = $this->getunixtime(trim($_POST['adv_start_date']));
				$param['adv_end_date']   = $this->getunixtime(trim($_POST['adv_end_date']));
				/**
				  * 建立图片广告信息的入库数组
				  */
				if($_POST['mark'] == '0'){
				if($_FILES['adv_pic']['name'] != ''){
				  	$upload->set('default_dir',ATTACH_ADV);
					$result	= $upload->upfile('adv_pic');
					if (!$result){
						showMessage($upload->error,'','','error');
					}
					$ac = array(
					'adv_pic'     =>$upload->file_name,
					'adv_pic_url' =>trim($_POST['adv_pic_url'])
					);
					$ac = serialize($ac);
					$param['adv_content'] = $ac;
				}else{
					$ac = array(
					'adv_pic'     =>trim($_POST['pic_ori']),
					'adv_pic_url' =>trim($_POST['adv_pic_url'])
					);
					$ac = serialize($ac);
					$param['adv_content'] = $ac;
				}
				}
			   /**
				 * 建立文字广告信息的入库数组
				 */
				if($_POST['mark'] == '1'){
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
						$error = $lang['wordadv_toolong'];
						showMessage($error);die;
				}
					$ac = array(
					'adv_word'    =>trim($_POST['adv_word']),
					'adv_word_url'=>trim($_POST['adv_word_url'])
					);
					$ac = serialize($ac);
					$param['adv_content'] = $ac;
				}
			   /**
                 * 建立幻灯片广告信息的入库数组
				 */
				if($_POST['mark'] == '2'){
			     if($_FILES['adv_slide_pic']['name'] != ''){
			     	$upload->set('default_dir',ATTACH_ADV);
					$result	= $upload->upfile('adv_slide_pic');
					$ac = array(
					'adv_slide_pic'  =>$upload->file_name,
					'adv_slide_url'  =>trim($_POST['adv_slide_url'])
					);
					$ac = serialize($ac);
					$param['adv_content'] = $ac;
					$param['slide_sort']  = trim($_POST['adv_slide_sort']);
				 }else{
				 	$ac = array(
					'adv_slide_pic'  =>trim($_POST['pic_ori']),
					'adv_slide_url'  =>trim($_POST['adv_slide_url'])
					);
					$ac = serialize($ac);
					$param['adv_content'] = $ac;
					$param['slide_sort']  = trim($_POST['adv_slide_sort']);
				 }
				}
				/**
				 * 建立Flash广告信息的入库数组
				 */
				if($_POST['mark'] == '3'){
				if($_FILES['flash_swf']['name'] != ''){
					$upload->set('default_dir',ATTACH_ADV);
					$result	= $upload->upfile('flash_swf');
					$ac = array(
					'flash_swf'  =>$upload->file_name,
					'flash_url'  =>trim($_POST['flash_url'])
					);
					$ac = serialize($ac);
					$param['adv_content'] = $ac;
				 }else{
				 	$ac = array(
					'flash_swf'  =>trim($_POST['flash_ori']),
					'flash_url'  =>trim($_POST['flash_url'])
					);
					$ac = serialize($ac);
					$param['adv_content'] = $ac;
				 }
				}
				$result = $adv->update($param);
				//更新广告缓存和广告位缓存
				$adv->makeAdvCache(intval($_GET['adv_id']));
				$condition['adv_id'] = intval($_GET['adv_id']);
    	        $adv_info = $adv->getList($condition);
    	        $adv_info = $adv_info['0'];
    	        $adv->makeApCache($adv_info['ap_id']);
			    if ($result){
					$url = array(
						array(
							'url'=>trim($_POST['ref_url']),
							'msg'=>$lang['goback_ap_manage'],
						)
					);
					showMessage($lang['adv_change_succ'],$url);
				}else {
					showMessage($lang['adv_change_fail'],$url);
				}
			}
    	}
    }
    /**
     * 
     * 删除广告
     */
    public function adv_delOp(){
    	$lang = Language::getLangContent();
    	$adv  = Model('adv');
       /**
		 * 删除一个广告
		 */
    	    //更新广告位缓存信息
    	    $condition['adv_id'] = intval($_GET['adv_id']);
    	    $adv_info = $adv->getList($condition);
    	    $adv_info = $adv_info['0'];
			$result  = $adv->adv_del(intval($_GET['adv_id']));
			$adv->makeApCache($adv_info['ap_id']);
		    if (!$result){
					$url = array(
						array(
							'url'=>'index.php?act=adv&op=adv',
							'msg'=>$lang['goback_adv_manage'],
						),
						array(
							'url'=>'index.php?act=adv&op=ap_manage',
							'msg'=>$lang['goback_ap_manage'],
						),
					);
					showMessage($lang['adv_del_fail'],$url);die;
				}else{
					showMessage($lang['adv_del_succ'],$url);die;
				}
		 /**
		  * 多选删除多个广告
		  */
	if ($_POST['form_submit'] == 'ok'){
		
        if($_POST['del_id'] != ''){
			foreach ($_POST['del_id'] as $k=>$v){
				$v = intval($v);
				//更新广告位缓存信息
	    	    $condition['adv_id'] = $v;
	    	    $adv_info = $adv->getList($condition);
	    	    $adv_info = $adv_info['0'];  	    
				$adv->adv_del($v);
				$adv->makeApCache($adv_info['ap_id']);
			}
			$url = array(
						array(
							'url'=>'index.php?act=adv&op=adv',
							'msg'=>$lang['goback_adv_manage'],
						)
					);
			showMessage($lang['adv_del_succ'],$url);
		}
	}
    }
    /**
     * 
     * Flex广告点击率图
     */
    public function click_chartOp(){
    	$lang = Language::getLangContent();
    	$adv  = Model('adv');
    	if(!empty($_POST['formsubmit'])&&$_POST['formsubmit'] == 'ok'){
    		$adv_id = $_POST['adv_id'];
    		$year   = $_POST['year'];
    	}else{
    		$adv_id = $_GET['adv_id'];
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
    		$msg = $lang['adv_chart_nothing_left'].$year.$lang['adv_chart_nothing_right'];
    		showMessage($msg);die;
    	}
    	/**
    	 * 生成广告点击率信息的xml
    	 */
    	$adv->makexml("resource",$click_info);
    	$param['adv_id'] = $_GET['adv_id'];
		$adv_list = $adv->getList($param);
		$adv_list = $adv_list['0'];
    	Tpl::output('year',$year);
    	Tpl::output('adv_title',$adv_list['adv_title']);
    	Tpl::output('adv_id',$_GET['adv_id']);
    	Tpl::showpage('adv_click_chart');
    }
    /**
     * 
     * 获取UNIX时间戳
     */
	public function getunixtime($time){
		$array     = explode("-", $time);
		$unix_time = mktime(0,0,0,$array[1],$array[2],$array[0]);
		return $unix_time;
	}
	/**
	 *
	 * ajaxOp
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			case 'is_use':
			$adv=Model('adv');
			$param[trim($_GET['column'])]=intval($_GET['value']);
			$param['ap_id']=intval($_GET['id']);
			$adv->ap_update($param);
			echo 'true';exit;
			break;
		}
	}
}