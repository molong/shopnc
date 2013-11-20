<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 直通车功能公用
 */
$lang['admin_ztc_unavailable']	 		= '系统开启直通车功能，是否自动开启';
$lang['admin_ztc_parameter_error']		= '参数错误';
$lang['admin_ztc_record_error']			= '记录信息错误';
$lang['admin_ztc_userrecord_error']		= '用户信息错误';
$lang['admin_ztc_goodsrecord_error']	= '商品信息错误';
$lang['admin_ztc_ztclog_addgold']		= '直通车商品增加消耗金币数';

$lang['admin_ztc_goldunit']				= '枚';
$lang['admin_ztc_list_title']			= '申请列表';
$lang['admin_ztc_goodslist_title']		= '商品列表';
$lang['admin_ztc_loglist_title']		= '金币日志';

$lang['admin_ztc_goodsname']			= '商品名称';
$lang['admin_ztc_list_number']			= '序号';
$lang['admin_ztc_auditstate']			= '审核状态';
$lang['admin_ztc_auditing']				= '等待审核';
$lang['admin_ztc_auditpass']			= '通过审核';
$lang['admin_ztc_auditnopass']			= '审核失败';
$lang['admin_ztc_paystate']				= '支付状态';
$lang['admin_ztc_waitpaying']			= '等待支付';
$lang['admin_ztc_paysuccess']			= '支付成功';
$lang['admin_ztc_applytype']			= '申请类型';
$lang['admin_ztc_applyrecord']			= '申请记录';
$lang['admin_ztc_rechargerecord']		= '充值记录';
$lang['admin_ztc_membername']			= '会员名称';
$lang['admin_ztc_storename']			= '店铺名称';
$lang['admin_ztc_searchtext']			= '查询';
$lang['admin_ztc_starttime']			= '开始时间';
$lang['admin_ztc_state']				= '状态';
$lang['admin_ztc_null']					= '无';
$lang['admin_ztc_addtime']				= '添加时间';
$lang['admin_ztc_addtime_to']			= '至';
$lang['admin_ztc_index_backlist']		= '返回列表';
$lang['admin_ztc_index_help1']			= '当网站开启直通车功能后，店主可以使用金币申请直通车';
/**
 * 删除操作
 */
$lang['admin_ztc_drop_reviewed_error']	= '记录信息已经过后台审核操作，不可删除';
$lang['admin_ztc_drop_paid_error']		= '记录信息已经支付，请先取消支付，再删除';
$lang['admin_ztc_drop_success']			= '申请记录删除成功';
$lang['admin_ztc_drop_fail']			= '申请记录删除失败';
/**
 * 编辑操作
 */
$lang['admin_ztc_edit_paid_error']	      	  = '记录信息未支付，不可编辑';
$lang['admin_ztc_edit_reviewed_error']	      = '记录信息已经过后台审核操作，不可再编辑';
$lang['admin_ztc_edit_recharge_unedit_error'] = '充值记录，不可编辑';
$lang['admin_ztc_edit_starttime_error']		  = '直通车开始时间必须大于等于当前时间';
$lang['admin_ztc_edit_goodsztc_exist_error']  = '该记录商品已经是直通车商品，请查看直通车商品记录';
$lang['admin_ztc_edit_goldlog_addgold']  	  = '申请参加直通车失败返还金币';
$lang['admin_ztc_edit_success']				  = "申请记录编辑成功";
$lang['admin_ztc_edit_fail']				  = "申请记录编辑失败";
$lang['admin_ztc_edit_costgold']			  = "消耗金币";
$lang['admin_ztc_edit_remark']				  = '备注信息';
/**
 * 申请列表
 */
$lang['admin_ztc_list_no_record']			= '没有符合条件的直通车申请记录';
$lang['admin_ztc_list_gold']				= '消耗金币(枚)';
$lang['admin_ztc_list_paysucc_auditing']	= '已经支付,待审核';
/**
 * 直通车金币日志列表
 */
$lang['admin_ztc_glog_recordtype']			= "类型";
$lang['admin_ztc_glog_recordtype_add']		= "增加";
$lang['admin_ztc_glog_recordtype_reduce']	= "减少";
$lang['admin_ztc_glog_list_goldnum']		= "金币数量(枚)";
$lang['admin_ztc_glog_list_desc']			= "描述";
/**
 * 商品列表
 */
$lang['admin_ztc_glist_glog_desc']		= "参与直通车,商品消耗金币";
$lang['admin_ztc_glist_goodsshow']		= "上架";
$lang['admin_ztc_glist_goodsunshow']	= "下架";
$lang['admin_ztc_glist_goodsshow_yes']	= "已上架";
$lang['admin_ztc_glist_goodsshow_no']	= "未上架";
$lang['admin_ztc_glist_goodsrecommend']	= "推荐";
$lang['admin_ztc_glist_goodslock']		= "违规下架";
$lang['admin_ztc_glist_goodslock_yes']	= "未违规";
$lang['admin_ztc_glist_goodslock_no']	= "违规已下架";
$lang['admin_ztc_glist_goodsclass']		= "商品分类";
$lang['admin_ztc_glist_goldresidue']	= "剩余金币(枚)";
$lang['admin_ztc_glist_goodsclick']		= "浏览数";
$lang['admin_ztc_gstate_choose_error']	= "请选择更新的商品信息";
$lang['admin_ztc_gstate_success']		= "更新成功";
$lang['admin_ztc_gstate_fail']			= "更新失败";
$lang['admin_ztc_gstate_ztc']			= "直通车";
$lang['admin_ztc_gstate_ztcstate_open']	= "开启";
$lang['admin_ztc_gstate_ztcstate_close']= "中止";
?>