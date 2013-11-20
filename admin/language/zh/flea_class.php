<?php
defined('InShopNC') or exit('Access Invalid!');
	
$lang['flea_class']							   = '閒置分類';
$lang['flea_class_help1']					   = '當用戶添加閒置閒置信息時選擇閒置分類，用戶可根據分類查詢閒置列表';
$lang['flea_class_help2']					   = '點擊分類名前“+”符號，顯示當前分類的下級分類';
$lang['flea_class_index_tips']                 = '頁首分類名稱可修改為"顯示為XXX"，若不填則顯示原分類名稱';
$lang['flea_isuse_off_tips']                   = '系統未開啟閒置市場功能';

$lang['flea_class_setting_ok']                 = '設置成功'; 
$lang['flea_class_setting_error']              = '設置失敗'; 
$lang['flea_index_class_setting']              = '首頁分類設置';
$lang['flea_index_class_setting_info']         = '設置信息';
$lang['flea_index_class_setting_digital']      = '數碼';
$lang['flea_index_class_setting_beauty']       = '裝扮';
$lang['flea_index_class_setting_home']         = '居家';
$lang['flea_index_class_setting_interest']     = '興趣';
$lang['flea_index_class_setting_baby']         = '母嬰';
$lang['flea_index_class_setting_as']           = '顯示為';
/**
* index
*/
$lang['goods_class_index_del_succ']            = '刪除分類成功';
$lang['goods_class_index_choose_del']          = '請選擇要刪除的內容';
$lang['goods_class_index_choose_edit']         = '請選擇要編輯的內容';
$lang['goods_class_index_in_homepage']         = '首頁內';
$lang['goods_class_index_display']             = '顯示';
$lang['goods_class_index_hide']                = '隱藏';
$lang['goods_class_index_succ']                = '成功';
$lang['goods_class_index_choose_in_homepage']  = '請選擇首頁內要';
$lang['goods_class_index_content']             = '的內容!';
$lang['goods_class_index_class']               = '商品分類';
$lang['goods_class_index_export']              = '導出';
$lang['goods_class_index_import']              = '導入';
$lang['goods_class_index_name']                = '分類名稱';
$lang['goods_class_index_display_in_homepage'] = '首頁顯示';
$lang['goods_class_index_ensure_del']          = '刪除該分類將會同時刪除該分類的所有下級分類，您確定要刪除嗎';
$lang['goods_class_index_display_tip']         = '首頁預設只顯示到二級分類';
/**
* 批量編輯
*/
$lang['goods_class_batch_edit_succ']           = '批量編輯成功';
$lang['goods_class_batch_edit_wrong_content']  = '批量修改內容不正確';
$lang['goods_class_batch_edit_batch']          = '批量編輯';
$lang['goods_class_batch_edit_keep']           = '保持不變';
$lang['goods_class_batch_edit_again']          = '重新編輯該分類';
$lang['goods_class_batch_edit_ok']             = '編輯分類成功。';
$lang['goods_class_batch_edit_fail']           = '編輯分類失敗。';
$lang['goods_class_batch_edit_paramerror']     = '參數非法';
/**
* 添加分類
*/
$lang['goods_class_add_name_null']             = '分類名稱不能為空';
$lang['goods_class_add_sort_int']              = '分類排序僅能為數字';
$lang['goods_class_add_back_to_list']          = '返回分類列表';
$lang['goods_class_add_again']                 = '繼續新增分類';
$lang['goods_class_add_succ']                  = '新增分類成功';
$lang['goods_class_add_fail']                  = '新增分類失敗';
$lang['goods_class_add_name_exists']           = '該分類名稱已經存在了，請您換一個';
$lang['goods_class_add_sup_class']             = '上級分類';
$lang['goods_class_add_sup_class_notice']	= '如果選擇上級分類，那麼新增的分類則為被選擇上級分類的子分類';
$lang['goods_class_add_update_sort']           = '更新排序';
$lang['goods_class_add_display_tip']           = '新增的分類名稱是否顯示';
/**
* 分類導入
*/
$lang['goods_class_import_succ']               = '導入成功';
$lang['goods_class_import_csv_null']           = '導入的csv檔案不能為空';
$lang['goods_class_import_data']               = '導入數據';
$lang['goods_class_import_choose_file']        = '請選擇檔案';
$lang['goods_class_import_file_tip']           = '如果導入速度較慢，建議您把檔案拆分為幾個小檔案，然後分別導入';
$lang['goods_class_import_choose_code']        = '請選擇檔案編碼';
$lang['goods_class_import_code_tip']           = '如果檔案較大，建議您先把檔案轉換為 utf-8 編碼，這樣可以避免轉換編碼時耗費時間';
$lang['goods_class_import_file_type']          = '檔案格式';
$lang['goods_class_import_first_class']        = '一級分類';
$lang['goods_class_import_second_class']       = '二級分類';
$lang['goods_class_import_third_class']        = '三級分類';
$lang['goods_class_import_example_download']   = '例子檔案下載';
$lang['goods_class_import_example_tip']        = '點擊下載導入例子檔案';
$lang['goods_class_import_import']             = '導入';
/**
* 分類導出
*/
$lang['goods_class_export_data']               = '導出數據';
$lang['goods_class_export_if_trans']           = '導出您的商品分類數據';
$lang['goods_class_export_trans_tip']          = '';
$lang['goods_class_export_export']             = '導出';
$lang['goods_class_export_help1']				= '導出內容為商品分類信息的.csv檔案';