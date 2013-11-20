<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 直通車功能公用
 */
$lang['admin_ztc_unavailable']	 		= '系統開啟直通車功能，是否自動開啟';
$lang['admin_ztc_parameter_error']		= '參數錯誤';
$lang['admin_ztc_record_error']			= '記錄信息錯誤';
$lang['admin_ztc_userrecord_error']		= '用戶信息錯誤';
$lang['admin_ztc_goodsrecord_error']	= '商品信息錯誤';
$lang['admin_ztc_ztclog_addgold']		= '直通車商品增加消耗金幣數';

$lang['admin_ztc_goldunit']				= '枚';
$lang['admin_ztc_list_title']			= '申請列表';
$lang['admin_ztc_goodslist_title']		= '商品列表';
$lang['admin_ztc_loglist_title']		= '金幣日誌';

$lang['admin_ztc_goodsname']			= '商品名稱';
$lang['admin_ztc_list_number']			= '序號';
$lang['admin_ztc_auditstate']			= '審核狀態';
$lang['admin_ztc_auditing']				= '等待審核';
$lang['admin_ztc_auditpass']			= '通過審核';
$lang['admin_ztc_auditnopass']			= '審核失敗';
$lang['admin_ztc_paystate']				= '支付狀態';
$lang['admin_ztc_waitpaying']			= '等待支付';
$lang['admin_ztc_paysuccess']			= '支付成功';
$lang['admin_ztc_applytype']			= '申請類型';
$lang['admin_ztc_applyrecord']			= '申請記錄';
$lang['admin_ztc_rechargerecord']		= '充值記錄';
$lang['admin_ztc_membername']			= '會員名稱';
$lang['admin_ztc_storename']			= '店舖名稱';
$lang['admin_ztc_searchtext']			= '查詢';
$lang['admin_ztc_starttime']			= '開始時間';
$lang['admin_ztc_state']				= '狀態';
$lang['admin_ztc_null']					= '無';
$lang['admin_ztc_addtime']				= '添加時間';
$lang['admin_ztc_addtime_to']			= '至';
$lang['admin_ztc_index_backlist']		= '返回列表';
$lang['admin_ztc_index_help1']			= '當網站開啟直通車功能後，店主可以使用金幣申請直通車';
/**
 * 刪除操作
 */
$lang['admin_ztc_drop_reviewed_error']	= '記錄信息已經過後台審核操作，不可刪除';
$lang['admin_ztc_drop_paid_error']		= '記錄信息已經支付，請先取消支付，再刪除';
$lang['admin_ztc_drop_success']			= '申請記錄刪除成功';
$lang['admin_ztc_drop_fail']			= '申請記錄刪除失敗';
/**
 * 編輯操作
 */
$lang['admin_ztc_edit_paid_error']	      	  = '記錄信息未支付，不可編輯';
$lang['admin_ztc_edit_reviewed_error']	      = '記錄信息已經過後台審核操作，不可再編輯';
$lang['admin_ztc_edit_recharge_unedit_error'] = '充值記錄，不可編輯';
$lang['admin_ztc_edit_starttime_error']		  = '直通車開始時間必須大於等於當前時間';
$lang['admin_ztc_edit_goodsztc_exist_error']  = '該記錄商品已經是直通車商品，請查看直通車商品記錄';
$lang['admin_ztc_edit_goldlog_addgold']  	  = '申請參加直通車失敗返還金幣';
$lang['admin_ztc_edit_success']				  = "申請記錄編輯成功";
$lang['admin_ztc_edit_fail']				  = "申請記錄編輯失敗";
$lang['admin_ztc_edit_costgold']			  = "消耗金幣";
$lang['admin_ztc_edit_remark']				  = '備註信息';
/**
 * 申請列表
 */
$lang['admin_ztc_list_no_record']			= '沒有符合條件的直通車申請記錄';
$lang['admin_ztc_list_gold']				= '消耗金幣(枚)';
$lang['admin_ztc_list_paysucc_auditing']	= '已經支付,待審核';
/**
 * 直通車金幣日誌列表
 */
$lang['admin_ztc_glog_recordtype']			= "類型";
$lang['admin_ztc_glog_recordtype_add']		= "增加";
$lang['admin_ztc_glog_recordtype_reduce']	= "減少";
$lang['admin_ztc_glog_list_goldnum']		= "金幣數量(枚)";
$lang['admin_ztc_glog_list_desc']			= "描述";
/**
 * 商品列表
 */
$lang['admin_ztc_glist_glog_desc']		= "參與直通車,商品消耗金幣";
$lang['admin_ztc_glist_goodsshow']		= "上架";
$lang['admin_ztc_glist_goodsunshow']	= "下架";
$lang['admin_ztc_glist_goodsshow_yes']	= "已上架";
$lang['admin_ztc_glist_goodsshow_no']	= "未上架";
$lang['admin_ztc_glist_goodsrecommend']	= "推薦";
$lang['admin_ztc_glist_goodslock']		= "違規下架";
$lang['admin_ztc_glist_goodslock_yes']	= "未違規";
$lang['admin_ztc_glist_goodslock_no']	= "違規已下架";
$lang['admin_ztc_glist_goodsclass']		= "商品分類";
$lang['admin_ztc_glist_goldresidue']	= "剩餘金幣(枚)";
$lang['admin_ztc_glist_goodsclick']		= "瀏覽數";
$lang['admin_ztc_gstate_choose_error']	= "請選擇更新的商品信息";
$lang['admin_ztc_gstate_success']		= "更新成功";
$lang['admin_ztc_gstate_fail']			= "更新失敗";
$lang['admin_ztc_gstate_ztc']			= "直通車";
$lang['admin_ztc_gstate_ztcstate_open']	= "開啟";
$lang['admin_ztc_gstate_ztcstate_close']= "中止";
?>