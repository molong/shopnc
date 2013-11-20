<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 开店
 */
$lang['store_ztc_list_auditing_tip']	 		= '您的店铺正在审核过程中，审核通过直通车管理功能才能使用！';
/**
 * 直通车功能公用
 */
$lang['store_ztc_no_record']	 		= '没有符合条件的记录';
$lang['store_ztc_unavailable']	 		= '系统未开启金币或者直通车功能';
$lang['store_ztc_parameter_error']		= '参数错误';
$lang['store_ztc_record_error']			= '记录信息错误';
$lang['store_ztc_userrecord_error']		= '用户信息错误';
$lang['store_ztc_goodsrecord_error']	= '商品信息错误';
$lang['store_ztc_goldunit']				= '枚';
$lang['store_ztc_goodsname']			= '商品名称';
$lang['store_ztc_auditstate']			= '审核状态';
$lang['store_ztc_auditing']				= '等待审核';
$lang['store_ztc_auditpass']			= '通过审核';
$lang['store_ztc_auditnopass']			= '审核失败';
$lang['store_ztc_paystate']				= '支付状态';
$lang['store_ztc_waitpaying']			= '等待支付';
$lang['store_ztc_paysuccess']			= '支付成功';
$lang['store_ztc_applytype']			= '申请类型';
$lang['store_ztc_applyrecord']			= '申请记录';
$lang['store_ztc_rechargerecord']		= '充值记录';
$lang['store_ztc_list_number']			= '序号';
$lang['store_ztc_starttime']			= '开始时间';
$lang['store_ztc_state']				= '商品状态';
$lang['store_ztc_addtime']				= "添加时间";
$lang['admin_ztc_addtime_to']			= '至';
$lang['store_ztc_goldlog_minusgold']	= '申请参加直通车扣除金币';
$lang['store_ztc_ztclog_addgold']		= '直通车商品增加消耗金币数';
$lang['store_ztc_operate_yourself_error']	= '您只能修改自己的直通车申请信息';
$lang['store_ztc_index_backlist']		= '返回列表';
/**
 * 申请列表
 */
$lang['store_ztc_list_gold']			= '消耗金币(枚)';
$lang['store_ztc_index_list_paysucc_auditing']	= '已经支付,待审核';
$lang['store_ztc_index_list_click_cancelpay']	= '点击取消支付';
$lang['store_ztc_index_list_click_pay']			= '点击支付';
$lang['store_ztc_index_list_startnow']			= '即刻开始';
$lang['store_ztc_index_edit_content']			= '编辑内容';
/**
 * 添加申请
 */
$lang['store_ztc_add_choose_goods']			= '选择商品';
$lang['store_ztc_add_loading_goodslist']	= '正在加载商品列表';
$lang['store_ztc_add_no_goods']				= '没有找到相关商品';
$lang['store_ztc_add_goods_searchtip']		= '提示：搜索只显示最新的50条数据<br>如果结果中没有您需要的信息<br>请输入商品详细名称进行搜索';
$lang['store_ztc_add_storegoodsclass']		= '本店分类';
$lang['store_ztc_add_search_up']			= '请先从上面搜索';
$lang['store_ztc_add_applytype_new']		= '直通车申请';
$lang['store_ztc_add_applytype_recharge']	= '直通车充值';
$lang['store_ztc_add_usegold']				= '消耗金币';
$lang['store_ztc_add_havegold_text']		= '您当前拥有金币';
$lang['store_ztc_add_remark']				= '备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注';
$lang['store_ztc_add_paygold']				= '金币支付';
$lang['store_ztc_add_paygold_later']		= '稍后支付';
$lang['store_ztc_add_paygold_now']			= '立即支付';
$lang['store_ztc_add_search_goodserror']	= '商品信息错误';
$lang['store_ztc_add_audittype_nullerror']	= '请选择申请类型';
$lang['store_ztc_add_goldnum_nullerror']	= '消耗金币数不能为空';
$lang['store_ztc_add_goldnum_minerror']		= '消耗金币数必须大于1';
$lang['store_ztc_add_goldnum_maxerror']		= '金币不足';
$lang['store_ztc_add_remarkerror']			= '备注长度应小于100';
$lang['store_ztc_add_goldnum_error']		= '消耗金币数必须大于1，并且剩余金币充足';
$lang['store_ztc_add_starttime_error']		= '直通车开始时间必须大于当前时间';
$lang['store_ztc_add_recharge_goodserror']	= "只有直通车商品才能进行'直通车充值'操作，否则请您选择申请类型为'直通车申请'";
$lang['store_ztc_add_newaudit_goodserror']	= "只有非直通车商品才能申请新加入直通车，否则请您选择申请类型为'直通车充值'，对当前直通车进行充值";
$lang['store_ztc_add_newaudit_recordexist']	= "该商品已经存在申请参加直通车的记录，您不可重复申请";
$lang['store_ztc_add_success']				= '直通车申请信息添加成功';
/**
 * 支付操作
 */
$lang['store_ztc_pay_reviewed_error']	= '记录信息已经过后台审核操作，不可再支付';
$lang['store_ztc_goldlog_addgold']		= '撤销参加直通车的确认支付添加金币';
$lang['store_ztc_pay_update_success']	= '支付状态更新成功';
$lang['store_ztc_pay_goldnum_maxerror']		= '金币不足,请充值';
/**
 * 删除操作
 */
$lang['store_ztc_drop_reviewed_error']	= '记录信息已经过后台审核操作，不可删除';
$lang['store_ztc_drop_paid_error']		= '记录信息已经支付，请先取消支付，再删除';
$lang['store_ztc_drop_success']			= '申请记录删除成功';
$lang['store_ztc_drop_fail']			= '申请记录删除失败';
/**
 * 编辑操作
 */
$lang['store_ztc_edit_reviewed_error']	= '记录信息已经过后台审核操作，不可再编辑';
$lang['store_ztc_edit_paid_error']		= '记录信息已经支付，请先取消支付，再编辑';
$lang['store_ztc_edit_recharge_goods_error']= "只有直通车商品才能进行'直通车充值'操作，否则请您选择申请类型为'直通车申请'";
$lang['store_ztc_edit_new_goods_error']		= "只有非直通车商品才能申请新加入直通车，否则请您选择申请类型为'直通车充值'，对当前直通车进行充值";
$lang['store_ztc_edit_new_goodsexist_error']= "该商品已经存在申请参加直通车的记录，您不可重复申请";
$lang['store_ztc_edit_success']				= "申请记录编辑成功";
$lang['store_ztc_edit_fail']				= "申请记录编辑失败";
/**
 * 商品列表
 */
$lang['store_ztc_glist_glog_desc']		= "参与直通车,商品消耗金币";
$lang['store_ztc_glist_goodsshow']		= "上架";
$lang['store_ztc_glist_goodsunshow']	= "下架";
$lang['store_ztc_glist_goodsrecommend']	= "推荐";
$lang['store_ztc_glist_goodslock']		= "禁售";
$lang['store_ztc_glist_goodsclass']		= "商品分类";
$lang['store_ztc_glist_goldresidue']	= "剩余金币(枚)";
$lang['store_ztc_gstate_ztc']			= "直通车";
$lang['store_ztc_gstate_ztcstate_open']	= "开启";
$lang['store_ztc_gstate_ztcstate_close']= "中止";
/**
 * 直通车金币日志列表
 */
$lang['store_ztc_glog_recordtype']			= "增减类型";
$lang['store_ztc_glog_recordtype_add']		= "增加";
$lang['store_ztc_glog_recordtype_reduce']	= "减少";
$lang['store_ztc_glog_list_goldnum']		= "金币数量(枚)";
$lang['store_ztc_glog_list_desc']			= "描述";
?>