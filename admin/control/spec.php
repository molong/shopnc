<?php
/**
 * 规格栏目管理
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class specControl extends SystemControl {
	const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();
		Language::read('spec');
	}
	/**
	 * 规格管理
	 */
	public function specOp(){
		$lang	= Language::getLangContent();
		/**
		 * 规格模型
		 */
		$model_spec = Model('spec');
		
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		/**
		 * 规格列表
		 */
		$spec_list	= $model_spec->specList(array('order'=>'sp_sort asc'), $page);
		
		Tpl::output('spec_list',$spec_list);
		Tpl::output('page',$page->show());
		Tpl::showpage('spec.index');
	}
	/**
	 * 添加规格
	 */
	public function spec_addOp(){
		$lang	= Language::getLangContent();
		/**
		 * 规格模型
		 */
		$model_spec = Model('spec');
		if ($_POST['form_submit'] == 'ok'){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["s_name"], "require"=>"true", "message"=>$lang['spec_add_name_no_null']),
				array("input"=>$_POST["s_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['spec_add_sort_no_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$spec = array();
				$spec['sp_name']		= trim($_POST['s_name']);
				$spec['sp_format']		= $_POST['s_dtype'];
				$spec['sp_sort']		= trim($_POST['s_sort']);
				$spec['sp_value']		= '';
				$spec_val = array();
				$spec_val	= $_POST['s_value'];
				
				$return = $model_spec->apecAdd($spec, $spec_val, $_FILES);
				if($return) {
					$url = array(
						array(
							'url'=>'index.php?act=spec&op=spec_add',
							'msg'=>$lang['spec_index_continue_to_dd']
						),
						array(
							'url'=>'index.php?act=spec&op=spec',
							'msg'=>$lang['spec_index_return_type_list']
						)
					);
					showMessage($lang['spec_index_add_succ'], $url);
				}else {
					showMessage($lang['spec_index_add_fail']);
				}
			}
		}
		
		Tpl::showpage('spec.add');
	}
	/**
	 * 编辑规格
	 */
	public function spec_editOp(){
		if(empty($_GET['sp_id'])){
			showMessage($lang['wrong_argument']);
		}
		$lang	= Language::getLangContent();
		/**
		 * 规格模型
		 */
		$model_spec = Model('spec');
		
		/**
		 * 编辑保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["s_name"], "require"=>"true", "message"=>$lang['spec_add_name_no_null']),
				array("input"=>$_POST["s_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['spec_add_sort_no_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/**
				 * 更新规格值表
				 */
				$string_value	= '';
				$spec_val		= $_POST['s_value'];
				if(is_array($spec_val) && !empty($spec_val)){

				$upload = new UploadFile();
				$upload->set('default_dir',ATTACH_SPEC);
				$upload->set('ifremove', true);
				$upload->set('thumb_width',	'16');
				$upload->set('thumb_height','16');
				$upload->set('thumb_ext',	'_small');
				
					// 要删除的规格值id
					$del_array	= array();
					if(!empty($_POST['s_del'])){
						$_POST['off_shelf'] = '1';		// 商品做违规下架处理
						$del_array	= $_POST['s_del'];
					}
								
					foreach ($spec_val as $k=>$val){
						$upload->set('file_name','');
						$val['name']	= trim($val['name']);
						$val['sort']	= intval($val['sort']);
						if($val['name'] == '') $_POST['off_shelf'] = '1';		// 商品做违规下架处理
						
						
						if(isset($val['form_submit']) && $val['form_submit'] == 'ok' && !in_array($k, $del_array)){		//原有规格已修改
							
							if($_POST['s_dtype'] == 'text'){								//文字模式
								
								/**
								 * 判断原有图片是否存在，如存在删除
								 */
								if(isset($val['image']) && $val['image'] != ''){
									/**
									 * 删除图片
									 */
									@unlink(BasePath.DS.ATTACH_SPEC.DS.$val['image']);
								}
								
								$val['image'] = '';
							}else if($_POST['s_dtype'] == 'image'){						//图片模式
								/**
								 * 图片上传
								 */
								if(!empty($_FILES['s_value_'.$k]['name'])){
									
									if(isset($val['image']) && $val['image'] != ''){
										/**
										 * 删除图片
										 */
										@unlink(BasePath.DS.ATTACH_SPEC.DS.$val['image']);
									}

									$upload->error = '';
									$result = $upload->upfile('s_value_'.$k);
									if (!$result){
										showMessage($upload->error,'','','error');
									}else{
										$val['image'] = $upload->thumb_image;
									}
								}
							}
							/**
							 * 更新规格值
							 */
							$return = $model_spec->specUpdate(
								array('sp_value_name'=>$val['name'], 'sp_value_image'=>$val['image'], 'sp_value_sort'=>$val['sort']),
								array('sp_value_id'=>$k, 'sp_id'=>intval($_POST['sp_id'])),
								'spec_value'
							);
							if(!$return){
								showMessage($lang['spec_index_update_fail']);
							}
							
							$string_value	.= $val['name'].',';
							
						}else if(isset($val['form_submit']) && $val['form_submit'] == ''  && !in_array($k, $del_array)){	//原有规格未修改	
							
							if($_POST['s_dtype'] == 'text'){								//文字模式
								
								/**
								 * 判断原有图片是否存在，如存在删除
								 */
								if(isset($val['image']) && $val['image'] != ''){
									/**
									 * 删除图片
									 */
									@unlink(BasePath.DS.ATTACH_SPEC.DS.$val['image']);
									
									/**
									 * 更新规格值
									 */
									$return = $model_spec->specUpdate(
										array('sp_value_image'=>''),
										array('sp_value_id'=>$k, 'sp_id'=>intval($_POST['sp_id'])),
										'spec_value'
									);
									if(!$return){
										showMessage($lang['spec_index_update_fail']);
									}
								}
								
								$val['image'] = '';
							}
							
							$string_value	.= $val['name'].',';
							
						}else if(!in_array($k, $del_array)){																//新添加规格值
							/**
							 * 图片上传
							 */
							$val['image'] = '';
							if($_POST['s_dtype'] == 'image'){								//图片模式
								/**
								 * 图片上传
								 */
								if(!empty($_FILES['s_value_'.$k]['name'])){
									$upload = new UploadFile();
									$upload->set('ifremove', true);
									$upload->set('default_dir',ATTACH_SPEC);
									$upload->set('thumb_width',	'16');
									$upload->set('thumb_height','16');
									$upload->set('thumb_ext',	'_small');
									$upload->upfile('s_value_'.$k);
									$val['image'] = $upload->thumb_image;
								}
							}
							
							/**
							 * 新增规格值
							 */
							$val_add	= array();
							$val_add['sp_value_name']	= trim($val['name']);
							$val_add['sp_id']			= intval($_POST['s_id']);
							$val_add['sp_value_image']	= $val['image'];
							$val_add['sp_value_sort']	= trim($val['sort']);
							
							$return = $model_spec->specValueAdd($val_add);
							unset($val_add);
							
							if(!$return){
								showMessage($lang['spec_index_update_fail']);
							}
							
							$string_value	.= $val['name'].',';
						}
					}
					
					// 删除规格值表
					if(!empty($_POST['s_del'])){
						$del_id	= '"'.implode('","', $_POST['s_del']).'"';
						$model_spec->delSpec('spec_value', array('in_sp_value_id'=> $del_id));
						foreach($_POST['s_del'] as $val){
							if(!empty($_POST['s_value'][$val]['image'])){
								/**
								 * 删除图片
								 */
								@unlink(BasePath.DS.ATTACH_SPEC.DS.$_POST['s_value'][$val]['image']);
							}
						}
					}
				}
			
				/**
				 * 更新规格表
				 */
				$param		= array();
				$param['sp_name']		= trim($_POST['s_name']);
				$param['sp_format']		= $_POST['s_dtype'];
				$param['sp_value']		= rtrim($string_value,',');
				$param['sp_sort']		= intval($_POST['s_sort']);
				
				/**
				 * 商品禁售
				 */
				if($_POST['off_shelf'] == '1'){
					$this->offTheShelfProducts(intval($_POST['s_id']));
				}
				
				$return = $model_spec->specUpdate($param, array('sp_id'=>intval($_POST['s_id'])), 'spec');
				if($return){
					$url = array(
						array(
							'url'=>'index.php?act=spec&op=spec',
							'msg'=>$lang['spec_index_return_type_list']
						)
					);
					showMessage($lang['spec_index_update_succ'], $url);
				}else{
					showMessage($lang['spec_index_update_fail']);
				}
			}
		}
		
		
		/**
		 * 规格列表
		 */
		$spec_list	= $model_spec->specList(array('sp_id'=>intval($_GET['sp_id'])));
		if(!$spec_list){
			showMessage($lang['wrong_argument']);
		}
		$sp_value	= $model_spec->specValueList(array('sp_id'=>intval($_GET['sp_id']),'order'=>'sp_value_sort asc'));
		
		Tpl::output('sp_value',$sp_value);
		Tpl::output('sp_list',$spec_list['0']);
		Tpl::showpage('spec.edit');
	}
	/**
	 * 删除规格
	 */
	public function spec_delOp(){
		$lang	= Language::getLangContent();
		if(empty($_GET['del_id'])) {
			showMessage($lang['wrong_argument']);
		}
		/**
		 * 规格模型
		 */
		$model_spec = Model('spec');
		
		if(is_array($_GET['del_id'])){
			$id = "'".implode("','", $_GET['del_id'])."'";
		}else{
			$id = intval($_GET['del_id']);
		}
		/**
		 * 规格列表
		 */
		$spec_list	= $model_spec->specList(array('in_sp_id'=>$id));
		
		if(is_array($spec_list) && !empty($spec_list)){
			foreach ($spec_list as $val){
				if($val['sp_format'] == 'image'){
					/**
					 * 删除规格图片
					 */
					$sp_value_list = $model_spec->specValueList(array('in_sp_id'=>$id));
					if(is_array($sp_value_list) && !empty($sp_value_list)){
						foreach ($sp_value_list as $val){
							@unlink(BasePath.DS.ATTACH_SPEC.DS.$val['sp_value_image']);
						}
					}
				}
			}
			
			/**
			 * 删除类型与规格关联表
			 */
			$return = $model_spec->delSpec('type_spec', array('in_sp_id'=>$id));
			if(!$return){
				showMessage($lang['spec_index_del_fail']);
			}
			
			/**
			 * 删除规格值表
			 */
			$return = $model_spec->delSpec('spec_value',array('in_sp_id'=>$id));
			if(!$return){
				showMessage($lang['spec_index_del_fail']);
			}
			
			/**
			 * 删除规格表
			 */
			$return = $model_spec->delSpec('spec',array('in_sp_id'=>$id));
			if(!$return){
				showMessage($lang['spec_index_del_fail']);
			}
			
			/**
			 * 商品禁售
			 */
			$this->offTheShelfProducts($id);
			
			showMessage($lang['spec_index_del_succ']);
			
		}else{
			showMessage($lang['wrong_argument']);
		}
			

	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		/**
		 * 规格模型
		 */
		$model_spec = Model('spec');
		
		switch ($_GET['branch']){
			case 'sort':
			case 'name':
				$return = $model_spec->specUpdate(
					array($_GET['column']=>trim($_GET['value'])),
					array('sp_id'=>intval($_GET['id'])),
					'spec'
				);
				if($return){
					echo 'true';exit;
				}else{
					echo 'false';exit;
				}
				break;
		}
	}
	
	/**
	 * 商品下架
	 */
	private function offTheShelfProducts($s_id){
		$lang	= Language::getLangContent();
		$model_type = Model('type');
		if(is_array($s_id)) $s_id = implode(',', $s_id);
		$goods_id_list = $model_type->typeRelatedList('goods_spec_index', array('in_sp_id'=>$s_id), 'goods_id');
		if(is_array($goods_id_list) && !empty($goods_id_list)){
			$goods_id_array = array();
			foreach($goods_id_list as $val){
				$goods_id_array[] = $val['goods_id'];
			}
			$model_goods = Model('goods');
			$model_goods->updateGoods(array('goods_state'=>'1','goods_show'=>'0', 'goods_close_reason'=>$lang['spec_edit_spec_goods_close_reason']), $goods_id_array);
		}
	}

	/**
	 * 规格导出
	 */
	public function export_step1Op(){
		$model_spec = Model('spec');
		$page	= new Page();
		$page->setEachNum(self::EXPORT_SIZE);
		$spec_list	= $model_spec->specList(array('order'=>'sp_sort asc'), $page);
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
				Tpl::output('download_lang',Language::get('nc_spec_manage'));
				Tpl::output('murl','index.php?act=spec&op=spec');				
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createExcel($spec_list);
			}
		}else{	//下载
			$this->createExcel($spec_list);
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
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_spec'));
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_sp_content'));

		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['sp_name']);
			$tmp[] = array('data'=>$v['sp_value']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_spec'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_spec'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}