<?php
defined('InShopNC') or exit('Access Invalid!');

$lang['para_error'] = '参数错误';
$lang['bundling_gold']				= '金币';
$lang['bundling_start_time']		= '开始时间';
$lang['bundling_end_time']			= '结束时间';
$lang['bundling_add']				= '添加活动';
$lang['bundling_edit']				= '编辑组合';
$lang['bundling_name']				= '活动名称';
$lang['bundling_status']			= '活动状态';
$lang['bundling_status_all']		= '全部状态';
$lang['bundling_status_0']			= '关闭';
$lang['bundling_status_1']			= '开启';
$lang['bundling_published']			= '已发布活动活动次数';
$lang['bundling_surplus']			= '剩余可发布活动数量';
$lang['bundling_gold_not_enough']	= '金币不足，购买失败。';
$lang['bundling_add_fail_quantity_beyond']	= '剩余可发布数量不足，不能在添加组合销售活动';
$lang['promotion_unavailable']		= '商品促销功能尚未开启';
$lang['bundling_list']				= '活动列表';
$lang['bundling_purchase_history']	= '购买套餐记录';
$lang['bundling_quota_add']			= '购买套餐';
$lang['bundling_quota_current_error']	= '您还没有购买套餐，或该促销活动已经关闭。<br />请先购买套餐，在查看活动列表。';
$lang['bundling_list_null']				= '您还没有添加活动。';
$lang['bundling_delete_success']		= '活动删除成功。';
$lang['bundling_delete_fail']			= '活动删除失败。';

/**
 * 购买活动
 */
$lang['bundling_quota_add_quantity']	= '套餐购买数量';
$lang['bundling_price_explain1']		= '购买单位为月(30天)，一次最多购买12个月，购买后立即生效，即可发布组合销售活动。';
$lang['bundling_price_explain2']		= '每月您需要支付%d金币。';
$lang['bundling_quota_price_fail']		= '参数错误，购买失败。';
$lang['bundling_quota_price_succ']		= '购买成功。';
$lang['bundling_quota_quantity_error']	= '不能为空，且必须为1~12之间的整数';
$lang['bundling_quota_add_confirm']		= '确认购买?您总共需要支付';
$lang['bundling_quota_success_glog_desc']= '购买组合销售活动%d个月，单价%d金币，总共花费%d金币';

/**
 * 添加活动
 */
$lang['bundling_add_explain1']				= '您只能发布%d个组合销售活动；每个活动最多可以添加%d个商品。';
$lang['bundling_add_explain2']				= '每个活动最多可以添加%d个商品。';
$lang['bundling_add_goods_explain']			= '搭配销售的商品名称可<br/>自定义编辑，上下拖移<br/>商品列可自定义显示排<br/>序；编辑、删除、排序<br/>等操作提交后生效。';
$lang['bundling_goods']						= '搭配商品';
$lang['bundling_show_name']					= '显示名称';
$lang['bundling_cost_price']				= '原价';
$lang['bundling_cost_price_note']			= '&nbsp;(已添加搭配商品的默认价格总计)';
$lang['bundling_operate']					= '操作';
$lang['bundling_goods_add']					= '添加商品';
$lang['bundling_add_price']					= '组合销售价格';
$lang['bundling_add_price_title']			= '自定义组合销售商品的优惠价格总计';
$lang['bundling_add_img']					= '活动图片';
$lang['bundling_add_pic_list_tip']			= '该图组用于组合详情页<br/>可由相册选择图片代替<br/>默认产品图；左右拖移<br/>图片可更改显示排序。';
$lang['bundling_add_form_album']			= '从相册选择图片';
$lang['bundling_add_freight_method']		= '运费承担';
$lang['bundling_add_freight_method_seller']	= '卖家承担运费';
$lang['bundling_add_freight_method_buyer']	= '买家承担运费（快递）';
$lang['bundling_add_desc']					= '活动描述';
$lang['bundling_add_form_album_to_desc']	= '插入相册图片';
$lang['bundling_add_name_error']			= '请填写活动名称';
$lang['bundling_add_goods_error']			= '请选择商品';
$lang['bundling_add_price_error_null']		= '请填写活动价格';
$lang['bundling_add_price_error_not_num']	= '价格只能为数字';
$lang['bundling_add_not_add_img']			= '不能在继续添加图片。';
$lang['bundling_add_goods_show_note']		= '下架商品在店铺页面不显示，请重新上架或选择其他商品';

/**
 * 添加套餐商品
 */
$lang['bundling_goods_store_class']			= '店铺分类';
$lang['bundling_goods_name']				= '商品名称';
$lang['bundling_goods_code']				= '货号';
$lang['bundling_goods_price']				= '价格';
$lang['bundling_goods_storage']				= '库存';
$lang['bundling_goods_storage_not_enough']	= '库存不足，不能添加商品。';
$lang['bundling_goods_add_bundling']		= '添加搭配';
$lang['bundling_goods_add_bundling_exit']	= '取消搭配';
$lang['bundling_goods_add_enough_prompt']	= '您已经添加了%d个，不能在继续添加商品。';
$lang['bundling_goods_remove']				= '移除';

/**
 * 购买记录
 */
$lang['bundling_history_quantity']			= '购买数量（月）';
$lang['bundling_history_consumption_gold']	= '消费金币';

/**
 * 活动列表
 */
$lang['bundling_list_goods_count']			= '商品数量';