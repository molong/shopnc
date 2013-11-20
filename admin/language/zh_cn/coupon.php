<?php
defined('InShopNC') or exit('Access Invalid!');

/**
 * 优惠券管理
 */
$lang['use_coupon']		= '使用优惠券';
$lang['coupon_name']		= '优惠券名称';
$lang['coupon_add']		= '新增优惠券';
$lang['coupon_pic']		= '优惠券图片';
$lang['coupon_price']		= '优惠金额';
$lang['coupon_lifetime']		= '使用期限';
$lang['coupon_state']		= '上架';
$lang['coupon_no_result']		= '没有符合条件的记录';
$lang['coupon_name_null']		= '优惠券名称不能为空';
$lang['coupon_price_error']		= '优惠券价格错误';
$lang['coupon_start_time_null']		= '优惠券开始日期不能为空';
$lang['coupon_end_time_null']		= '优惠券结束日期不能为空';
$lang['coupon_update_success']		= '更新优惠券成功';
$lang['coupon_update_fail']		= '更新优惠券失败';
$lang['coupon_add_success']		= '增加优惠券成功';
$lang['coupon_add_fail']		= '增加优惠券失败';
$lang['coupon_del_success']		= '删除成功';
$lang['coupon_del_fail']		= '删除失败';
$lang['coupon_time_error']		= '有效期条件错误';
$lang['coupon_edit']		= '修改优惠券';
$lang['coupon_class']		= '优惠券分类';
$lang['coupon_to']		= '至';
$lang['coupon_notice']		= '使用条件';
$lang['coupon_coupon_pic_notice']		= '建议上传优惠券的图片的比例为: 300×90';
$lang['coupon_pic_null']		= '请上传优惠券图片';
$lang['coupon_store_name']		= '店铺名称';
$lang['coupon_lock']		= '优惠券是否锁定';
$lang['coupon_lock_notice']		= '锁定后,会员将无法操作优惠券上下架状态';
$lang['coupon_state_notice']		= '请选择优惠券上架与下架状态';
$lang['coupon_store_notice']		= '优惠券的适用店铺,输入店铺名称';
$lang['coupon_lock_null']		= '优惠券锁定状态必须选择';
$lang['coupon_class_null']		= '优惠券的分类必须选择,如果不存在请添加分类';
$lang['coupon_store_null']		= '优惠券的店铺名称不能为空';
$lang['coupon_store_name_null']		= '店铺不存在';
$lang['coupon_notice_null']		= '使用条件不能为空';
$lang['coupon_choose']		= '未选择优惠券';
$lang['coupon_allow']		= '审核状态';
$lang['coupon_allow_state']		= '待审核';
$lang['coupon_allow_yes']		= '已通过';
$lang['coupon_allow_no']		= '未通过';
$lang['coupon_allow_remark']		= '审核备注';
$lang['coupon_remark_tips']		= '填写不通过的原因,方便卖家修改';
$lang['coupon_allow_tips']		= '通过后的才能在前台显示';
$lang['coupon_help1']		= '上架状态只有管理员可操作';
$lang['coupon_help2']		= '下架后的才能删除';
$lang['coupon_help3']		= '推荐后会出现首页和优惠券列表页的左侧，下架的优惠券推荐无效';
/**
 * 优惠券分类
 */
$lang['coupon_class_name']		= '分类名称';
$lang['coupon_class_sort']		= '排序';
$lang['coupon_class_show']		= '分类状态';
$lang['coupon_class_show_0']		= '不显示';
$lang['coupon_class_show_1']		= '显示';
$lang['coupon_class_name_notice']		= '分类名称不能重复';
$lang['coupon_class_sort_notice']		= '数字越小越靠前,最大为255';
$lang['coupon_class_show_notice']		= '显示时前台和会员中心可见';
$lang['coupon_class_name_null']		= '分类名称不能为空';
$lang['coupon_class_name_error']		= '该分类名称已经存在';
$lang['coupon_class_sort_null']		= '排序数字为0-255';
$lang['coupon_class_sort_min']		= '最小为0';
$lang['coupon_class_sort_max']		= '最大为255';
$lang['coupon_class_del']		= '未选择要删除的优惠券分类';
$lang['coupon_class_del_error']		= '删除分类中的优惠券后才可删除！';
$lang['coupon_class_success']		= '操作成功';
$lang['coupon_class_fail']		= '操作失败';
$lang['coupon_class_null_error']		= '优惠券分类不存在';
$lang['coupon_class_help1']		= '分类中有优惠券时,显示状态只能为是,而且不能删除';
$lang['coupon_class_edit_error']		= '该分类下有优惠券,显示状态只能为是';
/**
 * 优惠券推荐
 */
$lang['coupon_recommend_chooseerror'] = '请选择推荐信息';
$lang['coupon_recommend_success'] = '操作成功';
$lang['coupon_recommend_fail'] = '操作失败';

$lang['nc_store_auto_share_coupon1']	= '你参加或者不参加，实惠就在这里！';
$lang['nc_store_auto_share_coupon2']	= '“券”方位的优惠，丰富您的生活百态';
$lang['nc_store_auto_share_coupon3']	= '“券”点你的生活，实惠无所不在';
$lang['nc_store_auto_share_coupon4']	= '券券来搞鬼，生活真优惠！';
$lang['nc_store_auto_share_coupon5']	= '“胜”券在握，笑享打折';