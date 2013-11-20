<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 积分礼品功能公用
 */
$lang['member_pointorder_unavailable']	 		= '系统未开启积分或者积分兑换功能';
$lang['member_pointorder_parameter_error']		= '参数错误';
$lang['member_pointorder_record_error']			= '记录信息错误';
$lang['member_pointorder_list_title']			= '兑换记录';
$lang['member_pointorder_info_title']			= '兑换详细';
$lang['member_pointorder_ordersn']				= '兑换单号';
$lang['member_pointorder_payment']				= '支付方式';
$lang['member_pointorder_orderstate']			= '状态';
$lang['member_pointorder_exchangepoints']		= '兑换积分';
$lang['member_pointorder_shippingfee']			= '运费';
$lang['member_pointorder_exchangepoints_shippingfee'] = '积分及运费';
$lang['member_pointorder_orderstate_handle']	= '状态与操作';
$lang['member_pointorder_addtime']				= '兑换时间';
$lang['member_pointorder_shipping_code']		= '物流单号';
$lang['member_pointorder_shipping_time']		= '发货时间';
$lang['member_pointorder_exnum']				= '兑换数量';
$lang['member_pointorder_gobacklist']			= '返回列表';
/**
 * 兑换信息状态
 */
$lang['member_pointorder_state_submit']				= '已提交';
$lang['member_pointorder_state_waitpay']			= '待付款';
$lang['member_pointorder_state_canceled']			= '已取消';
$lang['member_pointorder_state_paid']				= '已付款';
$lang['member_pointorder_state_confirmpay']			= '待确认';
$lang['member_pointorder_state_confirmpaid']		= '确认收款';
$lang['member_pointorder_state_waitship']			= '待发货';
$lang['member_pointorder_state_shipped']			= '已发货';
$lang['member_pointorder_state_waitreceiving']		= '待收货';
$lang['member_pointorder_state_finished']			= '已完成';
$lang['member_pointorder_state_unknown']			= '未知';
/**
 * 兑换信息列表
 */
$lang['member_pointorder_cancel_tip1']				= '取消兑换礼品信息';
$lang['member_pointorder_cancel_tip2']				= '增加积分';
$lang['member_pointorder_cancel_success']			= '取消兑换成功';
$lang['member_pointorder_cancel_fail']				= '取消兑换失败';
$lang['member_pointorder_confirmreceiving_success']	= '确认收货成功';
$lang['member_pointorder_confirmreceiving_fail']	= '确认收货失败';
$lang['member_pointorder_pay']						= '付款';
$lang['member_pointorder_confirmreceiving']			= '确认收货';
$lang['member_pointorder_confirmreceivingtip']		= '确认已经收到兑换礼品吗?';
$lang['member_pointorder_cancel_title']				= '取消兑换';
$lang['member_pointorder_cancel_confirmtip']		= '确认取消兑换信息?';
$lang['member_pointorder_viewinfo']					= '查看详细';
/**
 * 兑换信息详细
 */
$lang['member_pointorder_info_ordersimple']		= '兑换信息';
$lang['member_pointorder_info_memberinfo']		= '会员信息';
$lang['member_pointorder_info_membername']		= '会员名称';
$lang['member_pointorder_info_memberemail']		= 'Email';
$lang['member_pointorder_info_ordermessage']	= '留言';
$lang['member_pointorder_info_paymentinfo']		= '支付信息';
$lang['member_pointorder_info_paymenttime']		= '支付时间';
$lang['member_pointorder_info_paymentmessage']	= '支付留言';
$lang['member_pointorder_info_shipinfo']		= '收货人及发货信息';
$lang['member_pointorder_info_shipinfo_truename']= '收货人';
$lang['member_pointorder_info_shipinfo_areainfo']= '所在地区';
$lang['member_pointorder_info_shipinfo_zipcode']= '邮政编码';
$lang['member_pointorder_info_shipinfo_telphone']= '电话号码';
$lang['member_pointorder_info_shipinfo_mobphone']= '手机号码';
$lang['member_pointorder_info_shipinfo_address']= '详细地址';
$lang['member_pointorder_info_shipinfo_description']= '发货描述';
$lang['member_pointorder_info_prodinfo']			= '礼品信息';
$lang['member_pointorder_info_prodinfo_exnum']		= '兑换数量';

$lang['pay_bank_user']			= '汇款人姓名';
$lang['pay_bank_bank']			= '汇入银行';
$lang['pay_bank_account']		= '汇款入账号';
$lang['pay_bank_num']			= '汇款金额';
$lang['pay_bank_date']			= '汇款日期';
$lang['pay_bank_extend']		= '其它';
$lang['pay_bank_order']			= '汇款单号';
$lang['pay_bank_bank_tips']		= '（需要填写详细的支行名称，如中国银行天津分行十一经路支行）';

/**
 * 应用积分兑换
 */
$lang['member_pointorder_exchange_unavailable']	= '系统没有整合Ucenter，如有需要请与管理员联系';
$lang['member_pointorder_exchange_phpwind']	    = '系统整合phpwind UC，不支持在线兑换，如有需要请与管理员联系';
$lang['member_pointorder_exchange_discuz']	    = '系统暂不支持积分兑换到其它应用，如有需要请与管理员联系';
$lang['member_pointorder_exchange_scheme_error']= '系统目前的兑换积分方案有错，不能进行兑换，请与管理员联系';
$lang['member_pointorder_exchange_credit_error']= '您要转账或兑换的积分数量输入有误，请返回修改';
$lang['member_pointorder_exchange_password_error']= '您的登录密码错误';
$lang['member_pointorder_exchange_credit_insufficient']= '对不起，您的积分余额不足，兑换失败';
$lang['member_pointorder_exchange_fail']        = '兑换失败，请与管理员联系';
$lang['member_pointorder_exchange_succeed']     = '兑换成功';
/**
 * 应用积分兑换详细
 */
$lang['member_pointorder_exchange_info']		= '系统已开启同步积分功能!';
$lang['member_pointorder_exchange_my_credit']	= '您拥有积分';
$lang['member_pointorder_exchange_app']		    = '您可以将自己的积分兑换到本站其他的应用（比如论坛）里面!';
$lang['member_pointorder_exchange_my_password']	= '登录密码';
$lang['member_pointorder_exchange_my_password_info']	= '正确输入您的登录密码才能兑换';
$lang['member_pointorder_exchange_pay_credit']	= '支出积分';
$lang['member_pointorder_exchange_exchange_credit']	= '兑换成';
$lang['member_pointorder_exchange_exchange_ratio']	= '兑换比率';
$lang['member_pointorder_exchange_exchange']	= '兑换';
$lang['member_pointorder_exchange_credit']	    = '积分';
