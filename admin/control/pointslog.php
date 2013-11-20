<?php
/**
 * 积分日志管理
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class pointslogControl extends SystemControl{
	const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();
		Language::read('points');
	}
	/**
	 * 积分日志列表
	 */
	public function pointslogOp(){
		$condition_arr = array();
		$condition_arr['pl_membername_like'] = trim($_GET['mname']);
		$condition_arr['pl_adminname_like'] = trim($_GET['aname']);
		if ($_GET['stage']){
			$condition_arr['pl_stage'] = trim($_GET['stage']);
		}
		$condition_arr['saddtime'] = strtotime($_GET['stime']);
		$condition_arr['eaddtime'] = strtotime($_GET['etime']);
        if($condition_arr['eaddtime'] > 0) {
            $condition_arr['eaddtime'] += 86400;
        }
		$condition_arr['pl_desc_like'] = trim($_GET['description']);
		//分页
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		//查询积分日志列表
		$points_model = Model('points');
		$list_log = $points_model->getPointsLogList($condition_arr,$page,'*','');
		//信息输出
		Tpl::output('show_page',$page->show());
		Tpl::output('list_log',$list_log);
		Tpl::showpage('pointslog');
	}

	/**
	 * 积分日志列表导出
	 */
	public function export_step1Op(){
		$condition_arr = array();
		$condition_arr['pl_membername_like'] = trim($_GET['mname']);
		$condition_arr['pl_adminname_like'] = trim($_GET['aname']);
		if ($_GET['stage']){
			$condition_arr['pl_stage'] = trim($_GET['stage']);
		}
		$condition_arr['saddtime'] = strtotime($_GET['stime']);
		$condition_arr['eaddtime'] = strtotime($_GET['etime']);
        if($condition_arr['eaddtime'] > 0) {
            $condition_arr['eaddtime'] += 86400;
        }
		$condition_arr['pl_desc_like'] = trim($_GET['description']);
		$page	= new Page();
		$page->setEachNum(self::EXPORT_SIZE);
		$points_model = Model('points');
		$list_log = $points_model->getPointsLogList($condition_arr,$page,'*','');
		if (!is_numeric($_GET['curpage'])){		
			$count = $page->getTotalNum();
			$array = array();
			if ($count > self::EXPORT_SIZE ){	//显示下载链接
				$page = ceil($count/self::EXPORT_SIZE);
				for ($i=1;$i<=$page;$i++){
					$limit1 = ($i-1)*self::EXPORT_SIZE + 1;
					$limit2 = $i*self::EXPORT_SIZE > $count ? $count : $i*self::EXPORT_SIZE;
					$array[$i] = $limit1.' ~ '.$limit2 ;
				}
				Tpl::output('list',$array);
				Tpl::output('download_lang',Language::get('admin_points_log_title'));
				Tpl::output('murl','index.php?act=pointslog&op=pointslog');				
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createExcel($list_log);
			}
		}else{	//下载
			$this->createExcel($list_log);
		}
	}

	/**
	 * 生成excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		Language::read('export');
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pi_member'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pi_system'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pi_point'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pi_time'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pi_jd'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_pi_ms'));
		$state_cn = array(Language::get('admin_points_stage_regist'),Language::get('admin_points_stage_login'),Language::get('admin_points_stage_comments'),Language::get('admin_points_stage_order'),Language::get('admin_points_stage_system'),Language::get('admin_points_stage_pointorder'),Language::get('admin_points_stage_app'));
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['pl_membername']);
			$tmp[] = array('data'=>$v['pl_adminname']);
			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['pl_points']));
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['pl_addtime']));
			$tmp[] = array('data'=>str_replace(array('regist','login','comments','order','system','pointorder','app'),$state_cn,$v['pl_stage']));
			$tmp[] = array('data'=>$v['pl_desc']);

			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_pi_jfmx'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_pi_jfmx'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}
