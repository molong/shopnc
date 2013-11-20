<?php
/**
 * SNS动态
 * 
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class sns_straceControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('snstrace,sns_strace');
	}
	/**
	 * 动态列表
	 */
	public function stracelistOp(){
		// where条件
		$where = array();
		if($_POST['search_sname'] != ''){
			$where['strace_storename']	= array('like','%'.trim($_POST['search_sname']).'%');
		}
		if($_POST['search_scontent'] != ''){
			$where['strace_content']	= array('like','%'.trim($_POST['strace_content']).'%');
		}
		if($_POST['search_type'] != ''){
			$where['strace_type']		= trim($_POST['search_type']);
		}
		if($_POST['search_stime'] != ''){
			$where['strace_time']		= array('egt',strtotime($_POST['search_stime']));
		}
		if($_POST['search_etime'] != ''){
			$where['strace_time']		= array('elt',strtotime($_POST['search_etime']));
		}
		// 实例化模型
		$model = Model();
		$strace_list = $model->table('sns_s_tracelog')->where($where)->order('strace_id desc')->page(10)->select();
		if(!empty($strace_list) && is_array($strace_list)){
			foreach ($strace_list as $key=>$val){
				if($val['strace_content'] == ''){
					$data = json_decode($val['strace_goodsdata'],true);
					if( CHARSET == 'GBK') {
						foreach ((array)$data as $k=>$v){
							$data[$k] = Language::getGBK($v);
						}
					}
					$content = $this->spellingStyle($val['strace_type'], $data);
					$strace_list[$key]['strace_content'] = str_replace("%siteurl%", SiteUrl.DS, $content);
				}
			}
		}
		Tpl::output('show_page', $model->showpage(2));
		Tpl::output('strace_list', $strace_list);
		Tpl::showpage('sns_strace.index');
	}
	/**
	 * 删除动态
	 */
	public function strace_delOp(){
		// 验证参数
		if(empty($_POST['st_id']) && !is_array($_POST['st_id'])){
			showMessage(Language::get('wrong_argument'), '', '', 'error');
		}
		$st_id = $_POST['st_id'];
		// 实例化模型
		$model = Model();
		// 删除动态
		$rs = $model->table('sns_s_tracelog')->where(array('strace_id'=>array('in',$st_id)))->delete();
		if($rs){
			// 删除评论
			$model->table('sns_s_comment')->where(array('strace_id'=>array('in',$st_id)))->delete();
			showMessage(Language::get('nc_common_del_succ'));
		}else{
			showMessage(Language::get('nc_common_del_fail'),'','','error');
		}
	}
	/**
	 * 编辑动态
	 */
	public function strace_editOp(){
		// 验证参数
		if(empty($_POST['st_id']) && !is_array($_POST['st_id'])){
			showMessage(Language::get('wrong_argument'), '', '', 'error');
		}
		// where条件
		$update = array();
		$update['strace_id']	= array('in', $_POST['st_id']);
		// update条件
		$update['strace_state']	= 1;
		if($_GET['type'] == 'hide'){
			$update['strace_state'] = 0;
		}
		// 实例化模型
		$model = Model();
		$rs = $model->table('sns_s_tracelog')->update($update);
		if($rs){
			showMessage(Language::get('nc_common_op_succ'));
		}else{
			showMessage(Language::get('nc_common_op_fail'),'','','error');
		}
	}
	/**
	 * 评论列表
	 */
	public function scomm_listOp(){
		// where 条件
		$where = array();
		$st_id = intval($_GET['st_id']);
		if($st_id > 0){
			$where['strace_id'] = $st_id;
		}
		if($_POST['search_uname'] != ''){
			$where['scomm_membername']	= array('like','%'.trim($_POST['search_uname']).'%');
		}
		if($_POST['search_content'] != ''){
			$where['scomm_content']		= array('like','%'.trim($_POST['search_content']).'%');
		}
		if($_POST['search_state'] != ''){
			$where['scomm_state']		= intval($_POST['search_state']);
		}
		if($_POST['search_stime'] != ''){
			$where['scomm_time']		= array('egt',strtotime($_POST['search_stime']));
		}
		if($_POST['search_etime'] != ''){
			$where['scomm_time']		= array('elt',strtotime($_POST['search_etime']));
		}
		$model = Model();
		$scomm_list = $model->table('sns_s_comment')->where($where)->order('scomm_id desc')->page(20)->select();
		Tpl::output('show_page', $model->showpage(2));
		Tpl::output('scomm_list', $scomm_list);
		Tpl::showpage('sns_scomment.index');
	}
	/**
	 * 删除评论
	 */
	public function scomm_delOp(){
		if(isset($_GET['sc_id'])){
			$sc_id = $_GET['sc_id'];
		}
		if(isset($_POST['sc_id']) && is_array($_POST['sc_id'])){
			$sc_id = $_POST['sc_id'];
		}
		if(!isset($sc_id)){
			showMessage(Language::get('wrong_argument'), '', '', 'error');
		}
		
		// 实例化模型
		$model = Model();
		$rs = $model->table('sns_s_comment')->where(array('scomm_id'=>array('in',$sc_id)))->delete();
		if($rs){
			showMessage(Language::get('nc_common_op_succ'));
		}else{
			showMessage(Language::get('nc_common_del_fail'),'','','error');
		}
	}
	/**
	 * 评论编辑
	 */
	public function scomm_editOp(){
		if(isset($_POST['sc_id']) && is_array($_POST['sc_id'])){
			$sc_id = $_POST['sc_id'];
		}else{
			showMessage(Language::get('wrong_argument'));
		}
		
		$scomm_state	= 1;
		if($_GET['type'] == 'hide'){
			$scomm_state = 0;
		}
		// 实例化模型
		$model = Model();
		$rs = $model->table('sns_s_comment')->where(array('scomm_id'=>array('in',$sc_id)))->update(array('scomm_state'=>$scomm_state));
		if($rs){
			showMessage(Language::get('nc_common_op_succ'));
		}else{
			showMessage(Language::get('nc_common_del_fail'),'','','error');
		}
	}
	/**
	 * 拼写个类型样式
	 * @param string $type 动态类型
	 * @param array  $data 相关数据
	 */
	private function spellingStyle($type,$data){
		//1'relay',2'normal',3'new',4'coupon',5'xianshi',6'mansong',7'bundling',8'groupbuy',9'recommend',10'hotsell'
		$rs = '';
		switch ($type){
			case '2':
				break;
			case '3':
				$rs = "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\"><img src=\"".cthumb($data['goods_image'],'small',$data['store_id'])."\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$data['goods_name']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><i class=\"desc-type desc-type-new\">".Language::get('store_sns_new_selease')."</i><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\">".$data['goods_name']."</a></dt>
							<dd>".Language::get('sns_sharegoods_price').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['goods_store_price'])."</dd>
							<dd>".($data['goods_transfee_charge'] == '1'?Language::get('store_sns_free_shipping'):Language::get('sns_sharegoods_freight').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['py_price']))."</dd>
	                  		<dd nctype=\"collectbtn_".$data['goods_id']."\"><a href=\"javascript:void(0);\" onclick=\"javascript:collect_goods('".$data['goods_id']."','succ','collectbtn_".$data['goods_id']."');\">".Language::get('sns_sharegoods_collect')."</a></dd>
	                  	</dl>
	                  </div>
	             </div>";
				break;
			case '4':
				$rs = "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'coupon_store', 'op'=>'detail','coupon_id'=>$data['coupon_id'],'id'=>$data['store_id']), 'coupon_info')."\"><img src=\"".$data['coupon_pic']."\" onerror=\"this.src='".SiteUrl.'/templates/'.TPL_NAME."/images/default_coupon_image.png'\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$data['coupon_title']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><i class=\"desc-type desc-type-coupon\">".Language::get('store_sns_coupon')."</i><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'coupon_store', 'op'=>'detail','coupon_id'=>$data['coupon_id'],'id'=>$data['store_id']), 'coupon_info')."\">".$data['coupon_title']."</a></dt>
							<dd>".Language::get('store_sns_coupon_price').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['coupon_price'])."</dd>
							<dd>".Language::get('store_sns_start-stop_time').Language::get('nc_colon').date('Y-m-d H:i', $data['coupon_start_date'])."~".date('Y-m-d H:i', $data['coupon_end_date'])."</dd>
	                  	</dl>
	                  </div>
	             </div>";
				break;
			case '5':
				$rs = "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\"><img src=\"".cthumb($data['goods_image'],'small',$data['store_id'])."\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$data['goods_name']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><i class=\"desc-type desc-type-xianshi\">".Language::get('store_sns_xianshi')."</i><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\">".$data['goods_name']."</a></dt>
							<dd>".Language::get('sns_sharegoods_price').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['goods_store_price'])."</dd>
							<dd>".Language::get('store_sns_formerprice').Language::get('nc_colon').Language::get('currency').ncPriceFormat(intval($data['goods_store_price'])*intval($data['discount'])*0.1)."</dd>
	                  		<dd nctype=\"collectbtn_".$data['goods_id']."\"><a href=\"javascript:void(0);\" onclick=\"javascript:collect_goods('".$data['goods_id']."','succ','collectbtn_".$data['goods_id']."');\">".Language::get('sns_sharegoods_collect')."</a></dd>
	                  	</dl>
	                  </div>
	             </div>";
				break;
			case '6':
				$rs = "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'show_store','id'=>$data['store_id']), 'store')."\"><img src=\"".SiteUrl.'/templates/'.TPL_NAME."/images/mjs-pic.gif\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$data['ansong_name']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><i class=\"desc-type desc-type-mansong\">".Language::get('store_sns_mansong')."</i><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'show_store','id'=>$data['store_id']), 'store')."\">".$data['mansong_name']."</a></dt>
							<dd>".Language::get('store_sns_start-stop_time').Language::get('nc_colon').date('Y-m-d H:i', $data['start_time'])."~".date('Y-m-d H:i', $data['end_time'])."</dd>
	                  	</dl>
	                  </div>
	             </div>";
				break;
			case '7':
				$rs = "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'bundling', 'bundling_id'=>$data['bl_id'] ,'id'=>$data['store_id']), 'bungling')."\"><img src=\"".cthumb($data['bl_img'],'small',$data['store_id'])."\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$data['bl_name']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><i class=\"desc-type desc-type-bundling\">".Language::get('store_sns_bundling')."</i><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'bundling', 'bundling_id'=>$data['bl_id'] ,'id'=>$data['store_id']), 'bungling')."\">".$data['bl_name']."</a></dt>
							<dd>".Language::get('store_sns_bundling_price').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['bl_discount_price'])."</dd>
							<dd>".(($data['bl_freight_choose']==1)?Language::get('store_sns_free_shipping'):Language::get('sns_sharegoods_freight').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['bl_freight']))."</dd>
						</dl>
	                  </div>
	             </div>";
				break;
			case '8':
				$rs = "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\"><img src=\"".gthumb($data['group_pic'],'small',$data['store_id'])."\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$data['group_name']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><i class=\"desc-type desc-type-groupbuy\">".Language::get('store_sns_gronpbuy')."</i><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\">".$data['group_name']."</a></dt>
							<dd>".Language::get('store_sns_goodsprice').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['goods_price'])."</dd>
							<dd>".Language::get('store_sns_groupprice').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['groupbuy_price'])."</dd>
							<dd>".Language::get('store_sns_start-stop_time').Language::get('nc_colon').date('Y-m-d H:i', $data['start_time'])."~".date('Y-m-d H:i', $data['end_time'])."</dd>
						</dl>
					</div>
				</div>";
				break;
			case '9':
				$rs = "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\"><img src=\"".thumb($data,'small')."\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$data['goods_name']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><i class=\"desc-type desc-type-recommend\">".Language::get('store_sns_store_recommend')."</i><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\">".$data['goods_name']."</a></dt>
							<dd>".Language::get('sns_sharegoods_price').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['goods_store_price'])."</dd>
							<dd>".Language::get('sns_sharegoods_freight').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['py_price'])."</dd>
	                  		<dd nctype=\"collectbtn_{$data['goods_id']}\"><a href=\"javascript:void(0);\" onclick=\"javascript:collect_goods('".$data['goods_id']."','succ','collectbtn_".$data['goods_id']."');\">".Language::get('sns_sharegoods_collect')."</a></dd>
	                  	</dl>
	                  </div>
	             </div>";
				break;
			case '10':
				$rs = "<div class=\"fd-media\">
					<div class=\"goodsimg\"><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\"><img src=\"".thumb($data,'small')."\" onload=\"javascript:DrawImage(this,120,120);\" alt=\"{$data['goods_name']}\"></a></div>
					<div class=\"goodsinfo\">
						<dl>
							<dt><i class=\"desc-type desc-type-hotsell\">".Language::get('store_sns_hotsell')."</i><a target=\"_blank\" href=\"%siteurl%".ncUrl(array('act'=>'goods','goods_id'=>$data['goods_id']), 'goods')."\">{$data['goods_name']}</a></dt>
							<dd>".Language::get('sns_sharegoods_price').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['goods_store_price'])."</dd>
							<dd>".Language::get('sns_sharegoods_freight').Language::get('nc_colon').Language::get('currency').ncPriceFormat($data['py_price'])."</dd>
	                  		<dd nctype=\"collectbtn_{$data['goods_id']}\"><a href=\"javascript:void(0);\" onclick=\"javascript:collect_goods('{$data['goods_id']}','succ','collectbtn_{$data['goods_id']}');\">".Language::get('sns_sharegoods_collect')."</a></dd>
	                  	</dl>
	                  </div>
	             </div>";
				break;
		}
		return $rs;
	}
}
?>