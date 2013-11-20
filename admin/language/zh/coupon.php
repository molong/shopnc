<?php
defined('InShopNC') or exit('Access Invalid!');

/**
 * 優惠券管理
 */
$lang['use_coupon']		= '使用優惠券';
$lang['coupon_name']		= '優惠券名稱';
$lang['coupon_add']		= '新增優惠券';
$lang['coupon_pic']		= '優惠券圖片';
$lang['coupon_price']		= '優惠金額';
$lang['coupon_lifetime']		= '使用期限';
$lang['coupon_state']		= '上架';
$lang['coupon_no_result']		= '沒有符合條件的記錄';
$lang['coupon_name_null']		= '優惠券名稱不能為空';
$lang['coupon_price_error']		= '優惠券價格錯誤';
$lang['coupon_start_time_null']		= '優惠券開始日期不能為空';
$lang['coupon_end_time_null']		= '優惠券結束日期不能為空';
$lang['coupon_update_success']		= '更新優惠券成功';
$lang['coupon_update_fail']		= '更新優惠券失敗';
$lang['coupon_add_success']		= '增加優惠券成功';
$lang['coupon_add_fail']		= '增加優惠券失敗';
$lang['coupon_del_success']		= '刪除成功';
$lang['coupon_del_fail']		= '刪除失敗';
$lang['coupon_time_error']		= '有效期條件錯誤';
$lang['coupon_edit']		= '修改優惠券';
$lang['coupon_class']		= '優惠券分類';
$lang['coupon_to']		= '至';
$lang['coupon_notice']		= '使用條件';
$lang['coupon_coupon_pic_notice']		= '建議上傳優惠券的圖片的比例為: 300×90';
$lang['coupon_pic_null']		= '請上傳優惠券圖片';
$lang['coupon_store_name']		= '店舖名稱';
$lang['coupon_lock']		= '優惠券是否鎖定';
$lang['coupon_lock_notice']		= '鎖定後,會員將無法操作優惠券上下架狀態';
$lang['coupon_state_notice']		= '請選擇優惠券上架與下架狀態';
$lang['coupon_store_notice']		= '優惠券的適用店舖,輸入店舖名稱';
$lang['coupon_lock_null']		= '優惠券鎖定狀態必須選擇';
$lang['coupon_class_null']		= '優惠券的分類必須選擇,如果不存在請添加分類';
$lang['coupon_store_null']		= '優惠券的店舖名稱不能為空';
$lang['coupon_store_name_null']		= '店舖不存在';
$lang['coupon_notice_null']		= '使用條件不能為空';
$lang['coupon_choose']		= '未選擇優惠券';
$lang['coupon_allow']		= '審核狀態';
$lang['coupon_allow_state']		= '待審核';
$lang['coupon_allow_yes']		= '已通過';
$lang['coupon_allow_no']		= '未通過';
$lang['coupon_allow_remark']		= '審核備註';
$lang['coupon_remark_tips']		= '填寫不通過的原因,方便賣家修改';
$lang['coupon_allow_tips']		= '通過後的才能在前台顯示';
$lang['coupon_help1']		= '上架狀態只有管理員可操作';
$lang['coupon_help2']		= '下架後的才能刪除';
$lang['coupon_help3']		= '推薦後會出現首頁和優惠券列表頁的左側，下架的優惠券推薦無效';
/**
 * 優惠券分類
 */
$lang['coupon_class_name']		= '分類名稱';
$lang['coupon_class_sort']		= '排序';
$lang['coupon_class_show']		= '分類狀態';
$lang['coupon_class_show_0']		= '不顯示';
$lang['coupon_class_show_1']		= '顯示';
$lang['coupon_class_name_notice']		= '分類名稱不能重複';
$lang['coupon_class_sort_notice']		= '數字越小越靠前,最大為255';
$lang['coupon_class_show_notice']		= '顯示時前台和會員中心可見';
$lang['coupon_class_name_null']		= '分類名稱不能為空';
$lang['coupon_class_name_error']		= '該分類名稱已經存在';
$lang['coupon_class_sort_null']		= '排序數字為0-255';
$lang['coupon_class_sort_min']		= '最小為0';
$lang['coupon_class_sort_max']		= '最大為255';
$lang['coupon_class_del']		= '未選擇要刪除的優惠券分類';
$lang['coupon_class_del_error']		= '刪除分類中的優惠券後才可刪除！';
$lang['coupon_class_success']		= '操作成功';
$lang['coupon_class_fail']		= '操作失敗';
$lang['coupon_class_null_error']		= '優惠券分類不存在';
$lang['coupon_class_help1']		= '分類中有優惠券時,顯示狀態只能為是,而且不能刪除';
$lang['coupon_class_edit_error']		= '該分類下有優惠券,顯示狀態只能為是';
/**
 * 優惠券推薦
 */
$lang['coupon_recommend_chooseerror'] = '請選擇推薦信息';
$lang['coupon_recommend_success'] = '操作成功';
$lang['coupon_recommend_fail'] = '操作失敗';

$lang['nc_store_auto_share_coupon1']	= '你參加或者不參加，實惠就在這裡！';
$lang['nc_store_auto_share_coupon2']	= '“券”方位的優惠，豐富您的生活百態';
$lang['nc_store_auto_share_coupon3']	= '“券”點你的生活，實惠無所不在';
$lang['nc_store_auto_share_coupon4']	= '券券來搞鬼，生活真優惠！';
$lang['nc_store_auto_share_coupon5']	= '“勝”券在握，笑享打折';