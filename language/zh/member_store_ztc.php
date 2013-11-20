<?php
defined('InShopNC') or exit('Access Invalid!');
/**
 * 開店
 */
$lang['store_ztc_list_auditing_tip']	 		= '您的店舖正在審核過程中，審核通過直通車管理功能才能使用！';
/**
 * 直通車功能公用
 */
$lang['store_ztc_no_record']	 		= '沒有符合條件的記錄';
$lang['store_ztc_unavailable']	 		= '系統未開啟金幣或者直通車功能';
$lang['store_ztc_parameter_error']		= '參數錯誤';
$lang['store_ztc_record_error']			= '記錄信息錯誤';
$lang['store_ztc_userrecord_error']		= '用戶信息錯誤';
$lang['store_ztc_goodsrecord_error']	= '商品信息錯誤';
$lang['store_ztc_goldunit']				= '枚';
$lang['store_ztc_goodsname']			= '商品名稱';
$lang['store_ztc_auditstate']			= '審核狀態';
$lang['store_ztc_auditing']				= '等待審核';
$lang['store_ztc_auditpass']			= '通過審核';
$lang['store_ztc_auditnopass']			= '審核失敗';
$lang['store_ztc_paystate']				= '支付狀態';
$lang['store_ztc_waitpaying']			= '等待支付';
$lang['store_ztc_paysuccess']			= '支付成功';
$lang['store_ztc_applytype']			= '申請類型';
$lang['store_ztc_applyrecord']			= '申請記錄';
$lang['store_ztc_rechargerecord']		= '充值記錄';
$lang['store_ztc_list_number']			= '序號';
$lang['store_ztc_starttime']			= '開始時間';
$lang['store_ztc_state']				= '商品狀態';
$lang['store_ztc_addtime']				= "添加時間";
$lang['admin_ztc_addtime_to']			= '至';
$lang['store_ztc_goldlog_minusgold']	= '申請參加直通車扣除金幣';
$lang['store_ztc_ztclog_addgold']		= '直通車商品增加消耗金幣數';
$lang['store_ztc_operate_yourself_error']	= '您只能修改自己的直通車申請信息';
$lang['store_ztc_index_backlist']		= '返回列表';
/**
 * 申請列表
 */
$lang['store_ztc_list_gold']			= '消耗金幣(枚)';
$lang['store_ztc_index_list_paysucc_auditing']	= '已經支付,待審核';
$lang['store_ztc_index_list_click_cancelpay']	= '點擊取消支付';
$lang['store_ztc_index_list_click_pay']			= '點擊支付';
$lang['store_ztc_index_list_startnow']			= '即刻開始';
$lang['store_ztc_index_edit_content']			= '編輯內容';
/**
 * 添加申請
 */
$lang['store_ztc_add_choose_goods']			= '選擇商品';
$lang['store_ztc_add_loading_goodslist']	= '正在加載商品列表';
$lang['store_ztc_add_no_goods']				= '沒有找到相關商品';
$lang['store_ztc_add_goods_searchtip']		= '提示：搜索只顯示最新的50條數據<br>如果結果中沒有您需要的信息<br>請輸入商品詳細名稱進行搜索';
$lang['store_ztc_add_storegoodsclass']		= '本店分類';
$lang['store_ztc_add_search_up']			= '請先從上面搜索';
$lang['store_ztc_add_applytype_new']		= '直通車申請';
$lang['store_ztc_add_applytype_recharge']	= '直通車充值';
$lang['store_ztc_add_usegold']				= '消耗金幣';
$lang['store_ztc_add_havegold_text']		= '您當前擁有金幣';
$lang['store_ztc_add_remark']				= '備&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注';
$lang['store_ztc_add_paygold']				= '金幣支付';
$lang['store_ztc_add_paygold_later']		= '稍後支付';
$lang['store_ztc_add_paygold_now']			= '立即支付';
$lang['store_ztc_add_search_goodserror']	= '商品信息錯誤';
$lang['store_ztc_add_audittype_nullerror']	= '請選擇申請類型';
$lang['store_ztc_add_goldnum_nullerror']	= '消耗金幣數不能為空';
$lang['store_ztc_add_goldnum_minerror']		= '消耗金幣數必須大於1';
$lang['store_ztc_add_goldnum_maxerror']		= '金幣不足';
$lang['store_ztc_add_remarkerror']			= '備註長度應小於100';
$lang['store_ztc_add_goldnum_error']		= '消耗金幣數必須大於1，並且剩餘金幣充足';
$lang['store_ztc_add_starttime_error']		= '直通車開始時間必須大於當前時間';
$lang['store_ztc_add_recharge_goodserror']	= "只有直通車商品才能進行'直通車充值'操作，否則請您選擇申請類型為'直通車申請'";
$lang['store_ztc_add_newaudit_goodserror']	= "只有非直通車商品才能申請新加入直通車，否則請您選擇申請類型為'直通車充值'，對當前直通車進行充值";
$lang['store_ztc_add_newaudit_recordexist']	= "該商品已經存在申請參加直通車的記錄，您不可重複申請";
$lang['store_ztc_add_success']				= '直通車申請信息添加成功';
/**
 * 支付操作
 */
$lang['store_ztc_pay_reviewed_error']	= '記錄信息已經過後台審核操作，不可再支付';
$lang['store_ztc_goldlog_addgold']		= '撤銷參加直通車的確認支付添加金幣';
$lang['store_ztc_pay_update_success']	= '支付狀態更新成功';
$lang['store_ztc_pay_goldnum_maxerror']		= '金幣不足,請充值';
/**
 * 刪除操作
 */
$lang['store_ztc_drop_reviewed_error']	= '記錄信息已經過後台審核操作，不可刪除';
$lang['store_ztc_drop_paid_error']		= '記錄信息已經支付，請先取消支付，再刪除';
$lang['store_ztc_drop_success']			= '申請記錄刪除成功';
$lang['store_ztc_drop_fail']			= '申請記錄刪除失敗';
/**
 * 編輯操作
 */
$lang['store_ztc_edit_reviewed_error']	= '記錄信息已經過後台審核操作，不可再編輯';
$lang['store_ztc_edit_paid_error']		= '記錄信息已經支付，請先取消支付，再編輯';
$lang['store_ztc_edit_recharge_goods_error']= "只有直通車商品才能進行'直通車充值'操作，否則請您選擇申請類型為'直通車申請'";
$lang['store_ztc_edit_new_goods_error']		= "只有非直通車商品才能申請新加入直通車，否則請您選擇申請類型為'直通車充值'，對當前直通車進行充值";
$lang['store_ztc_edit_new_goodsexist_error']= "該商品已經存在申請參加直通車的記錄，您不可重複申請";
$lang['store_ztc_edit_success']				= "申請記錄編輯成功";
$lang['store_ztc_edit_fail']				= "申請記錄編輯失敗";
/**
 * 商品列表
 */
$lang['store_ztc_glist_glog_desc']		= "參與直通車,商品消耗金幣";
$lang['store_ztc_glist_goodsshow']		= "上架";
$lang['store_ztc_glist_goodsunshow']	= "下架";
$lang['store_ztc_glist_goodsrecommend']	= "推薦";
$lang['store_ztc_glist_goodslock']		= "禁售";
$lang['store_ztc_glist_goodsclass']		= "商品分類";
$lang['store_ztc_glist_goldresidue']	= "剩餘金幣(枚)";
$lang['store_ztc_gstate_ztc']			= "直通車";
$lang['store_ztc_gstate_ztcstate_open']	= "開啟";
$lang['store_ztc_gstate_ztcstate_close']= "中止";
/**
 * 直通車金幣日誌列表
 */
$lang['store_ztc_glog_recordtype']			= "增減類型";
$lang['store_ztc_glog_recordtype_add']		= "增加";
$lang['store_ztc_glog_recordtype_reduce']	= "減少";
$lang['store_ztc_glog_list_goldnum']		= "金幣數量(枚)";
$lang['store_ztc_glog_list_desc']			= "描述";
?>