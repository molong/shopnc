<?php
/**
 * 商品评价
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class evaluateControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('evaluate');
		$storeeval_op = array('evalstore_list');
		$op = $_GET['op']?$_GET['op']:$_POST['op'];
		if (in_array($op,$storeeval_op)){
			//评价类型数组
			$evalstore_type = array(1=>Language::get('admin_evalstore_type_1'),2=>Language::get('admin_evalstore_type_2'),3=>Language::get('admin_evalstore_type_3'));
			Tpl::output('evalstore_type',$evalstore_type);
		}else {
			//评价状态数组
			$evaluate_state = array(0=>Language::get('admin_evaluate_state_common'),1=>Language::get('admin_evaluate_state_hidden'));
			Tpl::output('evaluate_state',$evaluate_state);
			//评价等级
			$evaluate_grade = array('1'=>Language::get('admin_evaluate_grade_good'),'0'=>Language::get('admin_evaluate_grade_normal'),'-1'=>Language::get('admin_evaluate_grade_bad'));
			Tpl::output('evaluate_grade',$evaluate_grade);
			//评价等级默认评语
			$evaluate_defaulttext = array('1'=>Language::get('admin_evaluate_defaultcontent_good'),'0'=>Language::get('admin_evaluate_defaultcontent_normal'),'-1'=>Language::get('admin_evaluate_defaultcontent_bad'));
			Tpl::output('evaluate_defaulttext',$evaluate_defaulttext);
		}
	}
	public function indexOp(){
		$this->evalgoods_listOp();
	}
	/**
	 * 商品来自买家的评价列表
	 */
	public function evalgoods_listOp(){
		$condition = array();
		$condition['geval_type'] = '1';
		//评价状态
		if ($_GET['state'] != ''){
			$condition['geval_state'] = "{$_GET['state']}";
		}
		//评价等级
		if ($_GET['grade'] != ''){
			$condition['geval_scores'] = "{$_GET['grade']}";
		}
		//商品名称
		if ($_GET['goods_name'] != ''){
			$condition['geval_goodsname'] = $_GET['goods_name'];
		}
		//店铺名称
		if ($_GET['store_name'] != ''){
			$condition['geval_storename'] = $_GET['store_name'];
		}
		//添加时间开始
		if ($_GET['stime'] != ''){
			$condition['geval_addtime_gt'] = strtotime($_GET['stime']);
		}
		//添加时间结束
		if ($_GET['etime'] != ''){
			$condition['geval_addtime_lt'] = strtotime($_GET['etime']);
		}
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$evaluate_model = Model('evaluate');
		$evalgoods_list	= $evaluate_model->getGoodsEvalList($condition,$page);
		Tpl::output('show_page',$page->show());
		Tpl::output('evalgoods_list',$evalgoods_list);
		Tpl::showpage('evalgoods.index');
	}
	/**
	 * 商品来自买家的评价详细
	 */
	public function evalgoods_infoOp(){
		$url = 'index.php?act=evaluate';
		if($_GET['type'] == 'seller'){
			$url = 'index.php?act=evaluate&op=evalseller_list';
		}
		$id = intval($_GET['id']);
		if ($id <= 0){
			$id = intval($_POST['id']);
		}
		if ($id <= 0){
			showMessage(Language::get('wrong_argument'),$url,'','error');
		}
		//查询评论详细信息
		$evaluate_model = Model('evaluate');
		if ($_POST['form_submit'] =='ok'){
			$evaluation_state = intval($_POST['state']);
			$evaluation_state !='0' &&  $evaluation_state !='1'? showMessage(Language::get('wrong_argument'),"index.php?act=evaluate&op=evalgoods_info&id={$id}",'','error'):'';
			//更新评价信息
			$update_arr = array();
			$update_arr['geval_state'] = "$evaluation_state";
			$update_arr['geval_remark'] = trim($_POST['admin_remark']);
			$result = $evaluate_model->editGoodsEval($update_arr,array('geval_id'=>"$id"));
			if ($result){
				showMessage(Language::get('admin_evaluate_edit_success'),$url);
			}else {
				showMessage(Language::get('admin_evaluate_edit_fail'),$url,'','error');
			}
		}else {
			$info = $evaluate_model->getGoodsEvalInfo(array('geval_id'=>"$id"));
			if (empty($info)){
				showMessage(Language::get('admin_evaluate_recorderror'),$url,'','error');
			}
			Tpl::output('info',$info);
			Tpl::showpage('evalgoods.info');
		}
	}
	/**
	 * 删除商品评价
	 */
	public function evalgoods_delOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showMessage(Language::get('wrong_argument'),'','','error');
		}
		$evaluate_model = Model('evaluate');
		//查询评价信息
		$info = $evaluate_model->getGoodsEvalInfo(array('geval_id'=>"$id"));
		if (empty($info)){
			showMessage(Language::get('admin_evaluate_recorderror'),'','','error');
		}
		$result = $evaluate_model->delGoodsEval(array('geval_id_del'=>"$id"));
		if ($result){
			showMessage(Language::get('admin_evaluate_drop_success'),'','','error');
		}else {
			showMessage(Language::get('admin_evaluate_drop_fail'),'','','error');
		}
	}
	/**
	 * 删除商品评价解释信息
	 */
	public function delexplainOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			echo 0; die;
		}
		$evaluate_model = Model('evaluate');
		$result = $evaluate_model->editGoodsEval(array('geval_explain'=>''),array('geval_id'=>"$id"));
		if ($result){
			echo 1; die;
		}else {
			echo 0; die;
		}
	}
	/**
	 * 店铺动态评价列表
	 */
	public function evalstore_listOp(){
		$condition = array();
		//店铺名称
		if ($_GET['store_name'] != ''){
			$condition['seval_storename'] = "{$_GET['store_name']}";
		}
		//评价人
		if ($_GET['from_name'] != ''){
			$condition['seval_membername'] = "{$_GET['from_name']}";
		}
		//评价分数
		if ($_GET['grade'] != ''){
			$condition['seval_scores'] = "{$_GET['grade']}";
		}
		//添加时间开始
		if ($_GET['stime'] != ''){
			$condition['seval_addtime_gt'] = strtotime($_GET['stime']);
		}
		//添加时间结束
		if ($_GET['etime'] != ''){
			$condition['seval_addtime_lt'] = strtotime($_GET['etime']);
		}
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$evaluate_model = Model('evaluate');
		$evalstore_list	= $evaluate_model->getStoreEvalList($condition,$page);
		Tpl::output('show_page',$page->show());
		Tpl::output('evalstore_list',$evalstore_list);
		Tpl::showpage('evalstore.index');
	}
	/**
	 * 删除店铺评价
	 */
	public function evalstore_delOp(){
		$id = intval($_GET['id']);
		if ($id <= 0){
			showMessage(Language::get('wrong_argument'),'index.php?act=evaluate','','error');
		}
		$evaluate_model = Model('evaluate');
		//查询评价信息
		$info = $evaluate_model->getStoreEvalInfo(array('seval_id'=>"$id"));
		if (empty($info)){
			showMessage(Language::get('admin_evaluate_recorderror'),'','','error');
		}
		$result = $evaluate_model->delStoreEval(array('seval_id_del'=>"$id"));
		if ($result){
			showMessage(Language::get('admin_evaluate_drop_success'),'','','error');
		}else {
			showMessage(Language::get('admin_evaluate_drop_fail'),'','','error');
		}
	}
	/**
	 * 商品来自卖家的评价列表
	 */
	public function evalseller_listOp(){
		$condition = array();
		$condition['geval_type'] = '2';
		//评价状态
		if ($_GET['state'] != ''){
			$condition['geval_state'] = "{$_GET['state']}";
		}
		//评价等级
		if ($_GET['grade'] != ''){
			$condition['geval_scores'] = "{$_GET['grade']}";
		}
		//商品名称
		if ($_GET['goods_name'] != ''){
			$condition['geval_goodsname'] = $_GET['goods_name'];
		}
		//被评价人
		if ($_GET['to_name'] != ''){
			$condition['geval_tomembername'] = $_GET['to_name'];
		}
		//添加时间开始
		if ($_GET['stime'] != ''){
			$condition['geval_addtime_gt'] = strtotime($_GET['stime']);
		}
		//添加时间结束
		if ($_GET['etime'] != ''){
			$condition['geval_addtime_lt'] = strtotime($_GET['etime']);
		}
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$evaluate_model = Model('evaluate');
		$evalgoods_list	= $evaluate_model->getGoodsEvalList($condition,$page);
		Tpl::output('show_page',$page->show());
		Tpl::output('evalgoods_list',$evalgoods_list);
		Tpl::showpage('evalseller.index');
	}
}