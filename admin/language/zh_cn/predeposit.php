<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 预存款功能公用
 */
$lang['admin_predeposit_no_record']	 		= '没有符合条件的记录';
$lang['admin_predeposit_unavailable']	 	= '系统未开启预存款功能';
$lang['admin_predeposit_parameter_error']	= '参数错误';
$lang['admin_predeposit_record_error']		= '记录信息错误';
$lang['admin_predeposit_userrecord_error']	= '会员信息错误';
$lang['admin_predeposit_membername']			= '会员名称';
$lang['admin_predeposit_payment']				= '支付方式';
$lang['admin_predeposit_addtime']				= '创建时间';
$lang['admin_predeposit_addtime_to']			= '至';
$lang['admin_predeposit_screen']				= '筛选条件';
$lang['admin_predeposit_paystate']				= '支付状态';
$lang['admin_predeposit_recordstate']			= '记录状态';
$lang['admin_predeposit_backlist']				= '返回列表';
$lang['admin_predeposit_adminname']				= '管理员名称';
$lang['admin_predeposit_adminremark']			= '管理员备注';
$lang['admin_predeposit_memberremark']			= '会员备注';
$lang['admin_predeposit_remark']				= '备注';
$lang['admin_predeposit_shortprice_error']		= '预存款金额不足，请查看用户预存款信息';
$lang['admin_predeposit_pricetype']				= '预存款类型';
$lang['admin_predeposit_pricetype_available']	= '可用金额';
$lang['admin_predeposit_pricetype_freeze']		= '冻结金额';
$lang['admin_predeposit_price']					= '金额';
$lang['admin_predeposit_sn']					= '编号';
$lang['admin_predeposit_payment_error'] 		= '支付方式错误';
/**
 * 充值功能公用
 */
$lang['admin_predeposit_rechargelist']				= '充值管理';
$lang['admin_predeposit_rechargewaitpaying']		= '等待支付';
$lang['admin_predeposit_rechargepaysuccess']		= '支付成功';
$lang['admin_predeposit_rechargestate_auditing']	= '审核中';
$lang['admin_predeposit_rechargestate_completed']	= '已完成';
$lang['admin_predeposit_rechargestate_closed']		= '已关闭';
$lang['admin_predeposit_recharge_onlinecode']		= '线上交易流水号';
$lang['admin_predeposit_recharge_price']			= '充值金额';
$lang['admin_predeposit_recharge_huikuanname']		= '汇款人姓名';
$lang['admin_predeposit_recharge_huikuanbank']		= '汇款银行';
$lang['admin_predeposit_recharge_huikuandate']		= '汇款日期';
$lang['admin_predeposit_recharge_memberremark']		= '会员备注';
$lang['admin_predeposit_recharge_help1']			= '你可以点击“编辑”选项进行预存款充值审核';
$lang['admin_predeposit_recharge_help2']			= '点击“查看”选项可以查看存款充值的详细信息';
$lang['admin_predeposit_recharge_searchtitle']			= '条件筛选';
/**
 * 充值信息编辑
 */
$lang['admin_predeposit_recharge_edit_logdesc']		= '会员充值支付状态修改减少预存款';
$lang['admin_predeposit_recharge_edit_success']		= '充值信息修改成功';
$lang['admin_predeposit_recharge_edit_fail']		= '充值信息修改失败';
$lang['admin_predeposit_recharge_notice']		= '仅管理员可见';
/**
 * 充值信息删除
 */
$lang['admin_predeposit_recharge_del_success']		= '充值信息删除成功';
$lang['admin_predeposit_recharge_del_fail']		= '充值信息删除失败';
/**
 * 提现功能公用
 */
$lang['admin_predeposit_cashmanage']			= '提现管理';
$lang['admin_predeposit_cashwaitpaying']		= '等待支付';
$lang['admin_predeposit_cashpaysuccess']		= '支付成功';
$lang['admin_predeposit_cashstate_auditing']	= '审核中';
$lang['admin_predeposit_cashstate_completed']	= '已完成';
$lang['admin_predeposit_cashstate_closed']		= '已关闭';
$lang['admin_predeposit_cash_price']			= '提现金额';
$lang['admin_predeposit_cash_shoukuanname']			= '收款人姓名';
$lang['admin_predeposit_cash_shoukuanbank']			= '收款银行';
$lang['admin_predeposit_cash_shoukuanaccount']		= '收款账号';
$lang['admin_predeposit_cash_remark_tip1']			= '仅管理员可见';
$lang['admin_predeposit_cash_remark_tip2']			= '备注信息将在预存款明细相关页显示，会员和管理员都可见';
$lang['admin_predeposit_cash_help1']			= '你可以点击编辑选项进行提现审核';
$lang['admin_predeposit_cash_help2']			= '点击查看选项可以查看提现的详细信息';
/**
 * 提现信息删除
 */
$lang['admin_predeposit_cash_del_success']	= '提现信息删除成功';
$lang['admin_predeposit_cash_del_fail']		= '提现信息删除失败';
/**
 * 提现信息编辑
 */
$lang['admin_predeposit_cash_edit_addfreezelogdesc']		= '会员提现记录支付成功增加冻结预存款金额';
$lang['admin_predeposit_cash_edit_reducefreezelogdesc']	= '会员提现记录状态修改为等待支付减少冻结预存款金额';
$lang['admin_predeposit_cash_edit_success']		= '提现信息修改成功';
$lang['admin_predeposit_cash_edit_fail']		= '提现信息修改失败';
/**
 * 手动修改
 */
$lang['admin_predeposit_artificial'] 	= '手动修改';
$lang['admin_predeposit_artificial_membername_error'] 	= '会员信息错误，请重新填写会员名';
$lang['admin_predeposit_artificial_membernamenull_error'] 	= '请输入会员名称';
$lang['admin_predeposit_artificial_pricenull_error'] 		= '请添加金额';
$lang['admin_predeposit_artificial_pricemin_error'] 		= '金额必须大于0';
$lang['admin_predeposit_artificial_shortprice_error']		= '金额不足,会员当前可用金额为';
$lang['admin_predeposit_artificial_shortfreezeprice_error']	= '金额不足,会员当前冻结金额为';
$lang['admin_predeposit_artificial_success']				= '修改会员预存款成功';
$lang['admin_predeposit_artificial_fail']					= '修改会员预存款失败';
$lang['admin_predeposit_artificial_operatetype']			= '增减类型';
$lang['admin_predeposit_artificial_operatetype_add']		= '增加';
$lang['admin_predeposit_artificial_operatetype_reduce']		= '减少';
$lang['admin_predeposit_artificial_member_tip_1']			= '会员';
$lang['admin_predeposit_artificial_member_tip_2']			= ', 当前可用预存款为';
$lang['admin_predeposit_artificial_member_tip_3']			= ',  冻结预存款为';
$lang['admin_predeposit_artificial_notice']					= '你可以选择修改可用金额或冻结金额';
/**
 * 出入明细 
 */
$lang['admin_predeposit_log_stage'] 	= '类型';
$lang['admin_predeposit_log_stage_recharge']	= '充值';
$lang['admin_predeposit_log_stage_cash']		= '提现';
$lang['admin_predeposit_log_stage_order']		= '消费';
$lang['admin_predeposit_log_stage_artificial']	= '手动修改';
$lang['admin_predeposit_log_stage_system']		= '系统';
$lang['admin_predeposit_log_desc']		= '描述';
$lang['admin_predeposit_log_help1']		= '预存款明细，展示了被操作人员（会员）、操作人员（管理员）、操作金额（“-”表示减少，无符号表示增加）、操作时间（添加时间）等信息';
?>