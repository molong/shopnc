<?php
/**
 * 会员中心——应用积分兑换信息
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.4
 */
defined('InShopNC') or exit('Access Invalid!');

class member_pointsexchangeControl extends BaseMemberControl{
	public function __construct() {
		parent::__construct();
		/**
		 * 读取语言包
		 */
		Language::read('member_pointorder');
		/**
		 * 判断系统是否开启积分和积分兑换功能
		 */
		if ($GLOBALS['setting_config']['points_isuse'] != 1 || $GLOBALS['setting_config']['pointprod_isuse'] != 1){
			showMessage(Language::get('member_pointorder_unavailable'),'index.php?act=member_snsindex','html','error');
		}
	}
	public function indexOp() {
        if($GLOBALS['setting_config']['ucenter_status'] != '1') {
            showMessage(Language::get('member_pointorder_exchange_unavailable'));
        }
        if($GLOBALS['setting_config']['ucenter_type'] != 'phpwind'){
		    @include(BasePath.'/uc_client/data/cache/creditsettings.php');
		    if (empty($_CACHE['creditsettings'])){
		        showMessage(Language::get('member_pointorder_exchange_discuz'));
		    }
        }

		/**
		 * 取出当前积分
		 */
		$model_member	= Model('member');
		$member_info	= $model_member->infoMember(array('member_id'=>$_SESSION['member_id']),'member_points');
		Tpl::output('member_points',$member_info['member_points']);

		if ($_POST['form_submit'] == 'ok'){
            if($GLOBALS['setting_config']['ucenter_type'] == 'phpwind'){
                showMessage(Language::get('member_pointorder_exchange_phpwind'));
            }
			$net_amount = $to_credits = 0;
			$to_credits = $_POST['to_credits'];
			$out_exchange = strpos($to_credits, '|') === FALSE ? TRUE : FALSE;
			if($out_exchange && !$_CACHE['creditsettings'][$to_credits]['ratio']) {
				showmessage(Language::get('member_pointorder_exchange_scheme_error'));
			}
			$amount = intval($_POST['amount']);
			if($amount <= 0) {
				showmessage(Language::get('member_pointorder_exchange_credit_error'));
			}

			$model_ucenter = Model('ucenter');
			$uc_result = $model_ucenter->userLogin($_SESSION['member_name'],trim($_POST['password']));
			list($tmp['uid']) = $uc_result;
			if($tmp['uid']<0) {
				showmessage(Language::get('member_pointorder_exchange_password_error'));
			} elseif($member_info['member_points']-$amount < 0) {
				showmessage(Language::get('member_pointorder_exchange_credit_insufficient'));
			}
			$net_amount = floor($amount * 1/$_CACHE['creditsettings'][$to_credits]['ratio']);

			list($to_appid, $to_credit) = explode('|', $to_credits);
			$uc_result = $model_ucenter->userCreditExchange($_SESSION['member_id'], $_CACHE['creditsettings'][$to_credits]['creditsrc'], $to_credit, $to_appid, $net_amount);
			if(!$uc_result) {
				showmessage(Language::get('member_pointorder_exchange_fail'));
			}
			$model_member->updateMember(array('member_points'=>array('sign'=>'decrease','value'=>$amount)),$_SESSION['member_id']);
			/**
			 * 记录日志
			 */
			$points_model = Model('points');
			$value_array = array();
			$value_array['pl_memberid'] = $_SESSION['member_id'];
			$value_array['pl_membername'] = $_SESSION['member_name'];
			$value_array['pl_points'] = '-'.$amount;
			$value_array['pl_addtime'] = time();
			$value_array['pl_desc'] = Language::get('pointsappdesc').'('.$_CACHE['creditsettings'][$to_credits]['title'].')';
			$value_array['pl_stage'] = 'app';
			$points_model->addPointsLog($value_array);
			showmessage(Language::get('member_pointorder_exchange_succeed'));exit;
		}
		//查询会员信息
		$this->get_member_info();	
		//信息输出
		self::profile_menu('points_exchange');
		Tpl::output('creditsettings',$_CACHE['creditsettings']);
        Tpl::output('ucenter_type',$GLOBALS['setting_config']['ucenter_type']);
		Tpl::output('menu_sign','points_exchange');
		Tpl::showpage('member_pointsexchange');
	}
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @param array 	$array		附加菜单
	 * @return 
	 */
	private function profile_menu($menu_key='',$array=array()) {
		Language::read('member_layout');
		$lang	= Language::getLangContent();
		$menu_array		= array();
		$menu_array = array(
			1=>array('menu_key'=>'points_exchange',	'menu_name'=>$lang['nc_member_path_points_exchange'],	'menu_url'=>'index.php?act=member_pointsexchange'),
		);
		if(!empty($array)) {
			$menu_array[] = $array;
		}
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}
}
?>