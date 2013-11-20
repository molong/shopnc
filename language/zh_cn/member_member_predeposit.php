<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 预存款功能公用
 */
$lang['predeposit_no_record']	 			= '没有符合条件的记录';
$lang['predeposit_unavailable']	 			= '系统未开启预存款功能';
$lang['predeposit_parameter_error']			= '参数错误';
$lang['predeposit_record_error']			= '记录信息错误';
$lang['predeposit_userrecord_error']		= '会员信息错误';
$lang['predeposit_payment']					= '支付方式';
$lang['predeposit_addtime']					= '创建时间';
$lang['predeposit_addtime_to']				= '至';
$lang['predeposit_memberremark']			= '会员备注';
$lang['predeposit_adminremark']				= '管理员备注';
$lang['predeposit_recordstate']				= '记录状态';
$lang['predeposit_paystate']				= '支付状态';
$lang['predeposit_backlist']				= '返回列表';
$lang['predeposit_pricetype']				= '预存款类型';
$lang['predeposit_pricetype_available']		= '可用金额';
$lang['predeposit_pricetype_freeze']		= '冻结金额';
$lang['predeposit_price']					= '金额';
$lang['predeposit_payment_error']			= '支付方式错误';
/**
 * 充值功能公用
 */
$lang['predeposit_rechargesn']					= '编号';
$lang['predeposit_rechargewaitpaying']			= '等待支付';
$lang['predeposit_rechargepaysuccess']			= '支付成功';
$lang['predeposit_rechargestate_auditing']		= '审核中';
$lang['predeposit_rechargestate_completed']		= '已完成';
$lang['predeposit_rechargestate_closed']		= '已关闭';
$lang['predeposit_recharge_price']				= '充值金额';
$lang['predeposit_recharge_huikuanname']		= '汇款人姓名';
$lang['predeposit_recharge_huikuanbank']		= '汇款银行';
$lang['predeposit_recharge_huikuandate']		= '汇款日期';
$lang['predeposit_recharge_memberremark']		= '会员备注';
$lang['predeposit_recharge_success']			= '充值成功';
$lang['predeposit_recharge_fail']				= '充值失败';
$lang['predeposit_recharge_payment_error']		= '支付方式错误';
$lang['predeposit_recharge_pay']				= '支&nbsp;付';
$lang['predeposit_recharge_view']				= '查看详单';
$lang['predeposit_recharge_paydesc']			= '预存款充值订单';
$lang['predeposit_recharge_pay_offline']		= '待确认';
/**
 * 充值添加
 */
$lang['predeposit_recharge_add_paymentnull_error']			= '请选择支付方式';
$lang['predeposit_recharge_add_pricenull_error']			= '请添加充值金额';
$lang['predeposit_recharge_add_pricemin_error']				= '请添加充值金额为大于或者等于0.01的数字';
$lang['predeposit_recharge_add_huikuannamenull_error']		= '请添加汇款人姓名';
$lang['predeposit_recharge_add_huikuanbanknull_error']		= '请添加汇款银行';
$lang['predeposit_recharge_add_huikuandatenull_error']		= '请添加汇款日期';
/**
 * 充值信息删除
 */
$lang['predeposit_recharge_del_success']		= '充值信息删除成功';
$lang['predeposit_recharge_del_fail']		= '充值信息删除失败';
/**
 * 提现功能公用
 */
$lang['predeposit_cashsn']				= '编号';
$lang['predeposit_cashmanage']			= '提现管理';
$lang['predeposit_cashwaitpaying']		= '等待支付';
$lang['predeposit_cashpaysuccess']		= '支付成功';
$lang['predeposit_cashstate_auditing']	= '审核中';
$lang['predeposit_cashstate_completed']	= '已完成';
$lang['predeposit_cashstate_closed']		= '已关闭';
$lang['predeposit_cash_price']				= '提现金额';
$lang['predeposit_cash_shoukuanname']			= '收款人姓名';
$lang['predeposit_cash_shoukuanbank']			= '收款银行';
$lang['predeposit_cash_shoukuanaccount']		= '收款账号';
$lang['predeposit_cash_shoukuanaccount_tip']	= '线上方式为例如支付宝的帐号，线下方式为银行帐号';
$lang['predeposit_cash_shortprice_error']		= '预存款金额不足';
$lang['predeposit_cash_price_tip']				= '当前可用金额';

$lang['predeposit_cash_availablereducedesc']	=  '会员申请提现减少预存款金额';
$lang['predeposit_cash_freezeadddesc']	=  '会员申请提现增加冻结预存款金额';

/**
 * 提现添加
 */
$lang['predeposit_cash_add_paymentnull_error']			= '请选择支付方式';
$lang['predeposit_cash_add_shoukuannamenull_error']		= '请添加收款人姓名';
$lang['predeposit_cash_add_shoukuanbanknull_error']		= '请添加收款银行';
$lang['predeposit_cash_add_pricemin_error']				= '请添加提现金额为大于或者等于0.01的数字';
$lang['predeposit_cash_add_pricenull_error']			= '请添加提现金额';
$lang['predeposit_cash_add_shoukuanaccountnull_error']	= '请添加收款账号';
$lang['predeposit_cash_add_success']					= '提现信息添加成功';
$lang['predeposit_cash_add_fail']						= '提现信息添加失败';
/**
 * 提现信息删除
 */
$lang['predeposit_cash_del_success']	= '提现信息删除成功';
$lang['predeposit_cash_del_fail']		= '提现信息删除失败';
/**
 * 支付接口
 */
$lang['predeposit_payment_pay_fail']		= '充值信息支付失败';
$lang['predeposit_payment_pay_success']		= '充值信息支付成功';
$lang['predepositrechargedesc']	=  '会员充值增加预存款';
/**
 * 出入明细 
 */
$lang['predeposit_log_stage'] 			= '类型';
$lang['predeposit_log_stage_recharge']	= '充值';
$lang['predeposit_log_stage_cash']		= '提现';
$lang['predeposit_log_stage_order']		= '消费';
$lang['predeposit_log_stage_artificial']= '手动修改';
$lang['predeposit_log_stage_system']	= '系统';
$lang['predeposit_log_stage_income']	= '收入';
$lang['predeposit_log_desc']			= '描述';
?>