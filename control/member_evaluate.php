<?php
/**
 * 会员中心——买家评价
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class member_evaluateControl extends BaseMemberControl{
	public function __construct(){
        parent::__construct() ;
        Language::read('member_layout,member_evaluate');
        Tpl::output('pj_act','member_evaluate');		
    }
    /**
	  * 订单添加评价
	  */
    public function addOp(){
		$order_id = intval($_GET['order_id']);
		if (!$order_id){
			showMessage(Language::get('wrong_argument'),'index.php?act=member&op=order','html','error');
		}
		//获取订单信息
		$order_model = Model('order');
		//订单为'已收货'状态，并且未评论
		$order_info = $order_model->getOrderById($order_id,'simple',array('buyer_id'=>"{$_SESSION['member_id']}",'evaluation_status'=>'0','order_state'=>'order_finish','refund_state'=>'able_evaluate'));
    	//1.交易成功超过十五天双方都未评价时评价关闭2.一方评价后超过十五天评价结束
		$order_info['able_evaluate'] = true;
		if ($order_info['evalseller_status'] == 0 && (intval($order_info['finnshed_time'])+60*60*24*15)<time()){
			$order_info['able_evaluate'] = false;
		}elseif ($order_info['evalseller_status'] == 1 && (intval($order_info['evalseller_time'])+60*60*24*15)<time()) {
			$order_info['able_evaluate'] = false;
		}
		if (empty($order_info) || !$order_info['able_evaluate']){
			showMessage(Language::get('member_evaluation_order_notexists'),'index.php?act=member&op=order','html','error');
		}
		//查询店铺信息
		$store_model = Model('store');
        $store_info = $store_model->shopStore(array('store_id'=>"{$order_info['store_id']}"));
        if(empty($store_info)){
        	showMessage(Language::get('member_evaluation_store_notexists'),'index.php?act=member&op=order','html','error');
        }
        //获取订单商品
        $ordergoods_model = Model('order_goods');
		$order_goodstmp = $ordergoods_model->getOrderGoodsList(array('order_id'=>"$order_id"));
		if(empty($order_goodstmp)){
			showMessage(Language::get('member_evaluation_order_notexists'),'index.php?act=member&op=order','html','error');
		}
		foreach ($order_goodstmp as $key=>$goods){
			$goods['goods_image'] = cthumb($goods['goods_image'],'tiny',$store_info['store_id']);
			$order_goods[$goods['rec_id']] = $goods;
		}
		unset($ordergoods_model);
		unset($order_goodstmp);
		//判断是否为页面
		if (!$_POST){
			$store_info['credit_arr'] = getCreditArr(intval($store_info['store_credit']));
			//不显示左菜单
			Tpl::output('left_show','order_view');
			Tpl::output('order_info',$order_info);
			Tpl::output('order_goods',$order_goods);
			Tpl::output('store_info',$store_info);
			Tpl::output('menu_sign','evaluateadd');
			Tpl::showpage('member_order.evaluation');
		}else {
			//验证是否进行了评价（评价其中一项就可以）
			$is_goodslegal = false;//默认为商品未评价
			if(!empty($_POST['goods'])){
				foreach ($_POST['goods'] as $k=>$v){
					if (intval($v['points'])>0){
						$is_goodslegal = true;
					}
				}
			}
			if ($is_goodslegal == false && empty($_POST['store'])){
				showMessage(Language::get('member_evaluation_evaluation_not_null'),'index.php?act=member&op=order','html','error');
			}
			$evaluate_model = Model('evaluate');
			//处理商品评价
			if ($is_goodslegal == true){				
				//根据订单评价状态判断互评状态(如果订单卖家已评价买家，则互评状态为2否则为1)
				if ($order_info['evalseller_status'] == 1){
					$bothstate = 2;
					$goodsevallist = $evaluate_model->getGoodsEvalList(array('geval_orderid'=>"$order_id",'geval_tomemberid'=>"{$_SESSION['member_id']}"));
					if (!empty($goodsevallist)){
						foreach ($goodsevallist as $k=>$v){
							$goodsevallist_new[$v['geval_ordergoodsid']] = $v;
						}
					}
				}else {
					$bothstate = 1;
				}				
				foreach ($_POST['goods'] as $k=>$v){
					if (intval($v['points'])>0 && !empty($order_goods[$k])){//判断该商品是否点击了评论
						$insert_arr = array();
						$insert_arr['geval_orderid'] = $order_id;
						$insert_arr['geval_orderno'] = $order_info['order_sn'];
						$insert_arr['geval_ordergoodsid'] = $k;
						$insert_arr['geval_goodsid'] = $order_goods[$k]['goods_id'];
						$insert_arr['geval_goodsname'] = $order_goods[$k]['goods_name'];
						$insert_arr['geval_specinfo'] = $order_goods[$k]['spec_info'];
						$insert_arr['geval_goodsprice'] = $order_goods[$k]['goods_price'];
						//计算店铺信用
						switch (intval($v['points'])){
							case 1://好评
								$insert_arr['geval_scores'] = 1;
								break;
							case 3://差评
								$insert_arr['geval_scores'] = -1;
								break;
							default:
								$insert_arr['geval_scores'] = 0;
								break;
						}
						$insert_arr['geval_content'] = trim($v['comment']);
						$insert_arr['geval_isanonymous'] = $v['anony'] == 1?1:0;
						$insert_arr['geval_addtime'] = time();
						$insert_arr['geval_storeid'] = $store_info['store_id'];
						$insert_arr['geval_storename'] = $store_info['store_name'];
						$insert_arr['geval_frommemberid'] = $_SESSION['member_id'];
						$insert_arr['geval_frommembername'] = $_SESSION['member_name'];
						$insert_arr['geval_tomemberid'] = $store_info['member_id'];
						$insert_arr['geval_tomembername'] = $store_info['member_name'];
						$insert_arr['geval_bothstate'] = $bothstate;
						if ($bothstate == 1){
							$showtime = time()+60*60*24*15;//单方评价15天后全网显示
						}else {
							if ($goodsevallist_new[$k]['geval_scores'] == 1 && $insert_arr['geval_scores'] == 1){//双方评价都为好评立即全网显示
								$showtime = time();
							}else {
								$showtime = time()+60*60*24*2;//双方评价存在差评和中评的，2天（作为协商期）后全网显示
							}
						}
						$insert_arr['geval_showtime'] = $showtime;
						$insert_arr['geval_type'] = 1;
						$evaluate_model->addGoodsEval($insert_arr);
						//如果互评为2则更新对方的评价信息的互评状态和显示时间
						if ($bothstate == 2){
							$evaluate_model->editGoodsEval(array('geval_bothstate'=>'2','geval_showtime'=>"$showtime"),array('geval_orderid'=>"$order_id",'geval_ordergoodsid'=>$k,'geval_tomemberid'=>"{$_SESSION['member_id']}"));
						}
						unset($insert_arr);
					}
				}
			}
			//添加店铺评价
			if (!empty($_POST['store'])){
				foreach ($_POST['store'] as $k=>$v){
					$insert_arr = array();
					$insert_arr['seval_orderid'] = $order_id;
					$insert_arr['seval_orderno'] = $order_info['order_sn'];
					switch ($k){
						case 'matchpoint':
							$insert_arr['seval_type'] = 1;		
							break;
						case 'servicepoint':
							$insert_arr['seval_type'] = 2;
							break;
						case 'shippingspeed':
							$insert_arr['seval_type'] = 3;
							break;							
					}
					$insert_arr['seval_scores'] = intval($v);
					$insert_arr['seval_addtime'] = time();
					$insert_arr['seval_storeid'] = $store_info['store_id'];
					$insert_arr['seval_storename'] = $store_info['store_name'];
					$insert_arr['seval_memberid'] = $_SESSION['member_id'];
					$insert_arr['seval_membername'] = $_SESSION['member_name'];
					$evaluate_model->addStoreEval($insert_arr);
					unset($insert_arr);
				}
			}
			//更新订单信息并记录订单日志
			$state = $order_model->updateOrder(array('evaluation_status'=>1,'evaluation_time'=>time()),$order_id);
			if ($state){
				$orderlog_arr = array();
				$orderlog_arr['order_id']		= $order_id;
				$orderlog_arr['order_state']	= Language::get('member_order_finished').','.Language::get('member_order_evaluated');//已评价
	       		$orderlog_arr['change_state']	= '';
				$orderlog_arr['state_info']		= '';
				$orderlog_arr['log_time']		= time();
				$orderlog_arr['operator']		= $_SESSION['member_name'];
				$order_model->addOrderLog($orderlog_arr);
				unset($orderlog_arr);
			}
			//添加会员积分
			if ($GLOBALS['setting_config']['points_isuse'] == 1){
				$points_model = Model('points');
				$points_model->savePointsLog('comments',array('pl_memberid'=>$_SESSION['member_id'],'pl_membername'=>$_SESSION['member_name']),true);
			}
			showMessage(Language::get('member_evaluation_evaluat_success'),'index.php?act=member&op=order');
		}
	}
	/**
	 * 评价列表
	 */
	public function listOp(){
		$store_id = intval($_SESSION['store_id']);
		$evaluate_model = Model('evaluate');
		if ($store_id > 0){
			//查询店铺信息
			$store_model = Model('store');
			$store_info = $store_model->getOne($store_id);
			$store_info['credit_arr'] = getCreditArr(intval($store_info['store_credit']));
			//查询店铺动态评分统计信息
			$storestat_list = $evaluate_model->getOneStoreEvalStat($store_id);			
			//查询商品评分统计信息
			$goodsstat_list = $evaluate_model->goodsEvalStatList(array('statstoreid'=>"{$store_id}"));
			Tpl::output('store_info',$store_info);
			Tpl::output('storestat_list',$storestat_list);
			Tpl::output('goodsstat_list',$goodsstat_list);
		}
		//查询商品评价列表
		$condition = array();
		//评价等级
		if($_GET['evalscore']){
			switch($_GET['evalscore']){
				case 1:
					$condition['geval_scores'] = '1';
					break;
				case 2:
					$condition['geval_scores'] = '0';
					break;
				case 3:
					$condition['geval_scores'] = '-1';
					break;
			}
		}
		//评价是否有内容
		if($_GET['havecontent']){
			switch($_GET['havecontent']){
				case 1:
					$condition['havecontent'] = 'yes';
					break;
				case 2:
					$condition['havecontent'] = 'no';
					break;
			}
		}
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		if ($_GET['type'] == 'toothers'){
			$condition['geval_frommemberid'] = "{$_SESSION['member_id']}";
			$goodsevallist = $evaluate_model->getGoodsEvalList($condition,$page,'*','store');
		}elseif ($_GET['type'] == 'fromseller'){//来自卖家的评价
			$condition['geval_tomemberid'] = "{$_SESSION['member_id']}";
			$condition['geval_type'] = "2";
			$goodsevallist = $evaluate_model->getGoodsEvalList($condition,$page,'*','store');
		}else {//来自买家的评价
			if (empty($_SESSION['store_id'])){
				$condition['geval_storeid'] = "0";
			}else {
				$condition['geval_storeid'] = "{$_SESSION['store_id']}";
			}
			$condition['geval_type'] = "1";
			$goodsevallist = $evaluate_model->getGoodsEvalList($condition,$page,'*','member');
		}
		if (!empty($goodsevallist)){
			foreach ($goodsevallist as $k=>$v){
				switch ($v['geval_scores']){
					case 1:
						$v['geval_scoressign'] = 'good';
						break;
					case -1:
						$v['geval_scoressign'] = 'bad';
						break;
					default:
						$v['geval_scoressign'] = 'normal';
						break;
				}
				//处理评论内容的显示
				if ($v['geval_content'] == '' || $v['geval_state'] == '1'){
					$v['geval_content'] = Language::get('member_evaluation_defaultcontent_'.$v['geval_scoressign']);
				}
				//处理买家信用
				if ($_GET['type'] == 'toothers' || $_GET['type'] == 'fromseller'){
					$v['credit_arr'] = getCreditArr(intval($v['store_credit']));
				}else{
					$v['credit_arr'] = getCreditArr(intval($v['member_credit']));
				}
				//显示匿名
				$v['geval_frommembername'] = $v['geval_isanonymous'] == 1?str_cut($v['geval_frommembername'],2).'***':$v['geval_frommembername'];
				//判断是否能修改（评价人可在全网显示之前进行评价修改）
				$v['able_edit'] = $v['geval_showtime']<time()?false:true;
				//判断是否可以解释，评价解释期为对方作出评价的30天
				$v['able_explain'] = $v['geval_addtime']+3600*24*30<time()?false:true;
				$goodsevallist[$k] = $v;
			}
		}
		Tpl::output('goodsevallist',$goodsevallist);
		Tpl::output('show_page',$page->show());
		//查询会员信息
		$this->get_member_info();
		Tpl::output('menu_sign','evaluatemanage');
		Tpl::output('menu_sign_url','index.php?act=member_evaluate&op=list');
		Tpl::showpage('evaluation.index');
	}
	/**
	 * 修改为好评
	 */
	public function editgoodOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showMessage(Language::get('wrong_argument'),'index.php?act=member_evaluate&op=list&type=toothers','html','error');
		}
		$evaluate_model = Model('evaluate');
		//查询评价信息
		$info = $evaluate_model->getGoodsEvalInfo(array('geval_id'=>"$id",'geval_frommemberid'=>"{$_SESSION['member_id']}"));
		if (empty($info) || $info['geval_scores'] == 1 && $info['geval_showtime']<time()){
			showMessage(Language::get('no_record'),'index.php?act=member_evaluate&op=list&type=toothers','html','error');
		}
		if ($_POST['form_submit'] == 'ok'){
			//更新评论信息
			$update = array();
			$update['geval_scores'] = 1;
			$update['geval_content'] = $_POST['content'];
			$update['geval_explain'] = '';//修改为好评后删除解释信息
			$state = $evaluate_model->editGoodsEval($update,array('geval_id'=>"$id"));
			if ($state){
				showMessage(Language::get('member_evaluation_edit_success'),'index.php?act=member_evaluate&op=list&type=toothers','html');
			}else {
				showMessage(Language::get('member_evaluation_edit_fail'),'index.php?act=member_evaluate&op=list&type=toothers','html','error');
			}
		}else {
			//查询会员信息
			$this->get_member_info();
			Tpl::output('menu_sign','evaluatemanage');
			Tpl::output('info',$info);
			Tpl::showpage('member_evaluation_edit1');	
		}
	}
	/**
	 * 修改为匿名评价
	 */
	public function editanonyOp(){
		$id = intval($_GET['id']);
		$evaluate_model = Model('evaluate');
		//更新评论信息
		$update = array();
		$update['geval_isanonymous'] = 1;
		$state = $evaluate_model->editGoodsEval($update,array('geval_id'=>"$id",'geval_frommemberid'=>"{$_SESSION['member_id']}"));
		if ($state){
			showMessage(Language::get('member_evaluation_edit_success'),'index.php?act=member_evaluate&op=list&type=toothers','html');
		}else {
			showMessage(Language::get('member_evaluation_edit_fail'),'index.php?act=member_evaluate&op=list&type=toothers','html','error');
		}
	}
	/**
	 * 删除评价
	 */
	public function delOp(){
		$id = intval($_GET['id']);
		$evaluate_model = Model('evaluate');
		//查询评价信息
		$info = $evaluate_model->getGoodsEvalInfo(array('geval_id'=>"$id",'geval_frommemberid'=>"{$_SESSION['member_id']}"));
		if (empty($info) || $info['geval_scores'] == 1  && $info['geval_showtime']<time()){
			showDialog(Language::get('no_record'),'index.php?act=member_evaluate&op=list&type=toothers','error');
		}
		$state = $evaluate_model->delGoodsEval(array('geval_id_del'=>"$id"));
		if ($state){
			showDialog(Language::get('member_evaluation_delsuccess'),'index.php?act=member_evaluate&op=list&type=toothers','succ');
		}else {
			showDialog(Language::get('member_evaluation_delfail'),'','error');
		}
	}
	/**
	 * 解释来自买家的评价
	 */
	public function explainOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showMessage(Language::get('wrong_argument'),'index.php?act=member_evaluate&op=list','html','error');
		}
		$evaluate_model = Model('evaluate');
		//查询评价信息
		$info = $evaluate_model->getGoodsEvalInfo(array('geval_id'=>"$id",'geval_tomemberid'=>"{$_SESSION['member_id']}"));
		if (empty($info) || $info['geval_scores'] == 1 && $info['geval_addtime']+3600*24*30<time()){
			showMessage(Language::get('no_record'),'index.php?act=member_evaluate&op=list','html','error');
		}
		if ($_POST['form_submit'] == 'ok'){
			//验证信息
			$obj_validate = new Validate();
			$validate_arr[] = array("input"=>$_POST["content"],"require"=>"true","message"=>Language::get('member_evaluation_explain_nullerror'));
			$obj_validate -> validateparam = $validate_arr;
			$error = $obj_validate->validate();			
			if ($error != ''){
				showMessage($error,'','html','error');
			}
			//更新评论信息
			$update = array();
			$update['geval_explain'] = $_POST['content'];
			$state = $evaluate_model->editGoodsEval($update,array('geval_id'=>"$id"));
			if ($state){
				showMessage(Language::get('member_evaluation_explain_success'),'index.php?act=member_evaluate&op=list','html');
			}else {
				showMessage(Language::get('member_evaluation_explain_fail'),'index.php?act=member_evaluate&op=list','html','error');
			}
		}else {
			switch ($info['geval_scores']){
				case 1:
					$info['geval_scoressign'] = 'good';
					break;
				case -1:
					$info['geval_scoressign'] = 'bad';
					break;
				default:
					$info['geval_scoressign'] = 'normal';
					break;
			}
			//查询会员信息
			$this->get_member_info();
			Tpl::output('menu_sign','evaluatemanage');
			Tpl::output('info',$info);
			Tpl::showpage('member_evaluation_edit2');	
		}
	}
}