<?php 
/**
 * 代金券模型 
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class voucherModel extends Model {
	private $applystate_arr;
    private $quotastate_arr;
    private $templatestate_arr;
    
	public function __construct(){
		parent::__construct();		
		//申请记录状态
		$this->applystate_arr = array('new'=>array(1,Language::get('voucher_applystate_new')),'verify'=>array(2,Language::get('voucher_applystate_verify')),'cancel'=>array(3,Language::get('voucher_applystate_cancel')));
		//套餐状态
		$this->quotastate_arr = array('activity'=>array(1,Language::get('voucher_quotastate_activity')),'cancel'=>array(2,Language::get('voucher_quotastate_cancel')),'expire'=>array(3,Language::get('voucher_quotastate_expire')));
		//代金券模板状态
		$this->templatestate_arr = array('usable'=>array(1,Language::get('voucher_templatestate_usable')),'disabled'=>array(2,Language::get('voucher_templatestate_disabled')));
		
	}
	/*
	 * 查询当前可用的套餐
	 */
	public function getCurrentQuota($store_id){
		$store_id = intval($store_id);
		if($store_id <= 0){
			return false;
		}
        $param = array();
        $param['quota_storeid'] = $store_id;
        $param['quota_starttime'] = array('lt',time());
        $param['quota_endtime'] = array('gt',time());
        $param['quota_state'] = $this->quotastate_arr['activity'][0];
        $info = $this->table('voucher_quota')->where($param)->find();
        return $info;
	}
	/*
	 * 查询新申请的套餐
	 */
	public function getNewApply($store_id){
		$store_id = intval($store_id);
		if($store_id <= 0){
			return false;
		}
		$new_apply = $this->table('voucher_apply')->where(array('apply_storeid'=>$store_id,'apply_state'=>$this->applystate_arr['new'][0]))->find();
		$newapply_flag = false;
        if(!empty($new_apply)){
        	$newapply_flag = true;
        }
        return $newapply_flag;
	}
	/**
	 * 查询可用的代金券详细信息，包括店铺信息
	 */
	public function getUsableTemplateInfo($vid){
		if (empty($vid)){
			return array();
		}
		$field = 'voucher_template.*,store.store_id,store.store_label,store.store_name,store.store_domain';
		$on = 'voucher_template.voucher_t_store_id=store.store_id';
		$voucher_info = $this->table('voucher_template,store')->field($field)->join('left')->on($on)->where(array('voucher_t_id'=>$vid,'voucher_t_state'=>$this->templatestate_arr['usable'][0],'voucher_t_end_date'=>array('gt',time())))->find();
		if (empty($voucher_info) || $voucher_info['voucher_t_total']<=$voucher_info['voucher_t_giveout']){
			$voucher_info = array();
		}
		return $voucher_info;
	}
	/*
     * 获取代金券编码
     */
    public function get_voucher_code() {
        return date('Ymd').substr(implode(NULL,array_map('ord',str_split(substr(uniqid(),7,13),1))) , -8 , 8);
    }
}