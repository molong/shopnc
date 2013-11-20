<?php
/**
 * 类型栏目管理
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
class typeControl extends SystemControl {
	const EXPORT_SIZE = 5000;
	public function __construct(){
		parent::__construct();
		Language::read('type');
	}
	/**
	 * 类型管理
	 */
	public function typeOp(){
		/**
		 * 类型模型
		 */
		$model_type = Model('type');
		
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$type_list	= $model_type->typeList(array('order'=>'type_sort asc'),$page);
		
		Tpl::output('type_list',$type_list);
		Tpl::output('page',$page->show());
		Tpl::showpage('type.index');
	}
	/**
	 * 添加类型
	 */
	public function type_addOp(){
		$lang	= Language::getLangContent();
		/**
		 * 类型模型
		 */
		$model_type = Model('type');
		
		/**
		 * 添加保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["t_mane"], "require"=>"true", "message"=>$lang['type_add_name_no_null']),
				array("input"=>$_POST["t_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['type_add_sort_no_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}
			
			/**
			 * 添加类型
			 */
			$type_array = array();
			$type_array['type_name']	= trim($_POST['t_mane']);
			$type_array['type_sort']	= trim($_POST['t_sort']);
			$type_id = $model_type->typeAdd('type',$type_array);
			
			
			if(!$type_id){
				showMessage($lang['type_index_add_fail']);
			}
			
			/**
			 * 添加类型与品牌对应
			 */
			if(!empty($_POST['brand_id'])){
				$brand_array	= $_POST['brand_id'];
				$return = $model_type->typeRelatedAdd('type_brand', $brand_array, $type_id);
				if(!$return){
					showMessage($lang['type_index_related_fail']);
				}
			}
			/**
			 * 添加类型与规格对应
			 */
			if(!empty($_POST['spec_id'])){
				$spec_array		= $_POST['spec_id'];
				$return = $model_type->typeRelatedAdd('type_spec', $spec_array, $type_id);
				if(!$return){
					showMessage($lang['type_index_related_fail']);
				}
			}
			/**
			 * 添加类型属性
			 */
			if(!empty($_POST['at_value'])){
				$attribute_array		= $_POST['at_value'];
				foreach ($attribute_array as $v){
					if($v['value'] != ''){
						// 转码  防止GBK下用中文逗号截取不正确
						$comma = '，';
						if (strtoupper(CHARSET) == 'GBK'){
							$comma = Language::getGBK($comma);
						}
						$v['value'] = str_replace($comma,',',$v['value']);
						$attr_val	= explode(',', $v['value']);
						/**
						 * 添加属性
						 */
						$attr_array = array();
						$attr_array['attr_name']	= $v['name'];
						$attr_array['attr_value']	= $v['value'];
						$attr_array['type_id']		= $type_id;
						$attr_array['attr_sort']	= $v['sort'];
						$attr_array['attr_show']	= $v['show'];
						$attr_id	= $model_type->typeAdd('attribute',$attr_array);
						if(!$attr_id){
							showMessage($lang['type_index_related_fail']);
						}
						
						/**
						 * 添加属性值
						 */
						
						$return = $model_type->typeRelatedAdd('attribute_value', $attr_val, $attr_id ,"(attr_id, attr_value_name)");
						
						if(!$return){
							showMessage($lang['type_index_related_fail']);
						}
					}
				}
			}
			$url = array(
				array(
					'url'=>'index.php?act=type&op=type_add',
					'msg'=>$lang['type_index_continue_to_dd']
				),
				array(
					'url'=>'index.php?act=type&op=type',
					'msg'=>$lang['type_index_return_type_list']
				)
			);
			showMessage($lang['type_index_add_succ'],$url);
			
		}
		
		/**
		 * 品牌列表
		 */
		$model_brand	= Model('brand');
		$brand_list		= $model_brand->getBrandList(array('brand_apply'=>'1','order'=>'brand_class asc,brand_sort asc'));
		$b_list = array();
		if(is_array($brand_list) && !empty($brand_list)){
			foreach($brand_list as $k=>$val){
				$b_list[$val['brand_class']][$k][brand_id] = $val['brand_id'];
				$b_list[$val['brand_class']][$k][brand_name] = $val['brand_name'];
			}
		}
		/**
		 * 规格列表
		 */
		$model_spec		= Model('spec');
		$spec_list		= $model_spec->specList(array('order'=>'sp_sort asc'), '', 'sp_id,sp_name,sp_value');
		
		Tpl::output('spec_list', $spec_list);
		Tpl::output('brand_list', $b_list);
		Tpl::showpage('type.add');
	}
	
	/**
	 * 编辑类型
	 */
	public function type_editOp(){
		$lang	= Language::getLangContent();
		if(empty($_GET['t_id'])){
			showMessage($lang['wrong_argument']);
		}
		
		/**
		 * 属性模型
		 */
		$model_type = Model('type');
		
		/**
		 * 编辑保存
		 */
		if ($_POST['form_submit'] == 'ok'){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["t_mane"], "require"=>"true", "message"=>$lang['type_add_name_no_null']),
				array("input"=>$_POST["t_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['type_add_sort_no_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}
			
			/**
			 * 更新属性关联表信息
			 */
			$type_id = intval($_POST['t_id']);
			
			//品牌
			if($_POST['brand']['form_submit'] == 'ok'){
				$model_type->delType('type_brand', array('type_id'=>$type_id));
				
				if(!empty($_POST['brand_id'])){
					$brand_array	= $_POST['brand_id'];
					$return = $model_type->typeRelatedAdd('type_brand', $brand_array, $type_id);
					if(!$return){
						showMessage($lang['type_index_related_fail']);
					}
				}
				
			}
			
			//规格
			if($_POST['spec']['form_submit'] == 'ok'){
				$model_type->delType('type_spec', array('type_id'=>$type_id));
				
				if(!empty($_POST['spec_id'])){
					$spec_array		= $_POST['spec_id'];
					$return = $model_type->typeRelatedAdd('type_spec', $spec_array, $type_id);
					if(!$return){
						showMessage($lang['type_index_related_fail']);
					}
				}
			}
			
			//属性
			// 转码  防止GBK下用中文逗号截取不正确
			$comma = '，';
			if (strtoupper(CHARSET) == 'GBK'){
				$comma = Language::getGBK($comma);
			}
						
			if(is_array($_POST['at_value']) && !empty($_POST['at_value'])){
				$attribute_array		= $_POST['at_value'];
				foreach ($attribute_array as $v){
					
					// 要删除的属性id
					$del_array	= array();
					if(!empty($_POST['a_del'])){
						$del_array	= $_POST['a_del'];
					}
					
					$v['value'] = str_replace($comma,',',$v['value']);						//把属性值中的中文逗号替换成英文逗号
					
					if(isset($v['form_submit']) && $v['form_submit'] == 'ok' && !in_array($v['a_id'], $del_array)){				//原属性已修改
						/**
						 * 属性
						 */
						$attr_array = array();
						$attr_array['attr_name']	= $v['name'];
						$attr_array['attr_value']	= $v['value'];
						$attr_array['type_id']		= $type_id;
						$attr_array['attr_sort']	= $v['sort'];
						$attr_array['attr_show']	= $v['show'];
						$return	= $model_type->typeUpdate($attr_array, array('type_id'=>$type_id, 'attr_id'=>intval($v['a_id'])), 'attribute');
						if(!$return){
							showMessage($lang['type_index_related_fail']);
						}
					}else if (!isset($v['form_submit'])){									//新增属性
						/**
						 * 属性
						 */
						$attr_array = array();
						$attr_array['attr_name']	= $v['name'];
						$attr_array['attr_value']	= $v['value'];
						$attr_array['type_id']		= $type_id;
						$attr_array['attr_sort']	= $v['sort'];
						$attr_array['attr_show']	= $v['show'];
						$attr_id	= $model_type->typeAdd('attribute',$attr_array);
						if(!$attr_id){
							showMessage($lang['type_index_related_fail']);
						}
						
						/**
						 * 属性值
						 */
						$attr_val	= explode(',', $v['value']);
						
						$return = $model_type->typeRelatedAdd('attribute_value', $attr_val, $attr_id ,"(attr_id, attr_value_name)");
						
						if(!$return){
							showMessage($lang['type_index_related_fail']);
						}
					}
				}
				
				// 删除属性
				if(!empty($_POST['a_del'])){
					$del_id	= '"'.implode('","', $_POST['a_del']).'"';
					$model_type->delType('attribute_value', array('in_attr_id'=>$del_id));	//删除属性值
					$model_type->delType('attribute', array('in_attr_id'=>$del_id));	//删除属性
				}
				
			}
			
						
			/**
			 * 下架商品
			 */
			if($_POST['off_shelf'] == '1'){
				$this->offTheShelfProductsForType($type_id);
			}
			
			/**
			 * 更新属性信息
			 */
			$type_array = array();
			$type_array['type_name']	= trim($_POST['t_mane']);
			$type_array['type_sort']	= trim($_POST['t_sort']);
			$return = $model_type->typeUpdate($type_array, array('type_id'=>$type_id), 'type');
			if($return){
				$url = array(
					array(
						'url'=>'index.php?act=type&op=type',
						'msg'=>$lang['type_index_return_type_list']
					)
				);
				showMessage($lang['type_index_update_succ'],$url);
			}else{
				showMessage($lang['type_index_update_fail']);
			}

		}
		
		/**
		 * 属性列表
		 */
		$type_info = $model_type->typeList(array('type_id'=>intval($_GET['t_id'])));
		if(!type_info){
			showMessage($lang['wrong_argument']);
		}
		Tpl::output('type_info', $type_info['0']);
		
		/**
		 * 品牌
		 */
		$model_brand	= Model('brand');
		$brand_list		= $model_brand->getBrandList(array('brand_apply'=>'1','order'=>'brand_class asc,brand_sort asc'));
		$b_list = array();
		if(is_array($brand_list) && !empty($brand_list)){
			foreach($brand_list as $k=>$val){
				$b_list[$val['brand_class']][$k][brand_id] = $val['brand_id'];
				$b_list[$val['brand_class']][$k][brand_name] = $val['brand_name'];
			}
		}
		unset($brand_list);
		//类型与品牌关联列表
		$brand_related	= $model_type->typeRelatedList('type_brand', array('type_id'=>intval($_GET['t_id'])), 'brand_id');
		$b_related = array();
		if(is_array($brand_related) && !empty($brand_related)){
			foreach($brand_related as $val){
				$b_related[] = $val['brand_id'];
			}
		}
		unset($brand_related);
		Tpl::output('brang_related', $b_related);
		Tpl::output('brand_list', $b_list);
		
		/**
		 * 规格
		 */
		//规格表
		$model_spec		= Model('spec');
		$spec_list		= $model_spec->specList(array('order'=>'sp_sort asc'), '', 'sp_id,sp_name,sp_value');
		//规格关联列表
		$spec_related	= $model_type->typeRelatedList('type_spec', array('type_id'=>intval($_GET['t_id'])), 'sp_id');
		$sp_related = array();
		if(is_array($spec_related) && !empty($spec_related)){
			foreach($spec_related as $val){
				$sp_related[] = $val['sp_id'];
			}
		}
		unset($spec_related);
		Tpl::output('spec_related', $sp_related);
		Tpl::output('spec_list', $spec_list);
		
		/**
		 * 属性
		 */
		$attr_list	= $model_type->typeRelatedList('attribute', array('type_id'=>intval($_GET['t_id']), 'order'=>'attr_sort asc'));
		Tpl::output('attr_list', $attr_list);
		
		Tpl::showpage('type.edit');
	}
	
	/**
	 * 编辑属性
	 */
	public function attr_editOp(){
		$lang		= Language::getLangContent();
		
		/**
		 * 实例化模型
		 */
		$model	= Model();
		
		if($_POST['form_submit']){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
					array("input"=>$_POST["attr_name"], "require"=>"true", "message"=>$lang['type_edit_type_attr_name_no_null']),
					array("input"=>$_POST["attr_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['type_edit_type_attr_sort_no_null']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				/**
				 * 更新属性值表
				 */
				$attr_value		= $_POST['attr_value'];
				$string_value	= '';
				
				// 要删除的规格值id
				$del_array	= array();
				if(!empty($_POST['attr_del'])){
					$del_array	= $_POST['attr_del'];
				}
				
				if(!empty($attr_value) && is_array($attr_value)){
					foreach ($attr_value as $key=>$val){
						if(isset($val['form_submit']) && $val['form_submit'] == 'ok' && !in_array(intval($key), $del_array)){		// 属性已修改
							
							$data = array();
							$data['attr_value_id']	= intval($key);
							$data['attr_value_name']= $val['name'];
							$data['attr_value_sort']= intval($val['sort']);
							
							$model->table('attribute_value')->update($data);
							
							$string_value	.= $val['name'].',';
						}else if(isset($val['form_submit']) && $val['form_submit'] == '' && !in_array(intval($key), $del_array)){	// 属性未修改
							
							$string_value	.= $val['name'].',';
							
						}else if(!isset($val['form_submit'])){
							
							$data = array();
							$data['attr_value_name']= $val['name'];
							$data['attr_id']		= intval($_POST['attr_id']);
							$data['attr_value_sort']= intval($val['sort']);
							
							$model->table('attribute_value')->insert($data);
							
							$string_value	.= $val['name'].',';
						}
					}
					
					// 删除属性
					$model->table('attribute_value')->delete(implode(',', $del_array));
				}
				
				/**
				 * 更新属性
				 */
				$data = array();
				$data['attr_id']	= intval($_POST['attr_id']);
				$data['attr_name']	= $_POST['attr_name'];
				$data['attr_value']	= rtrim($string_value, ',');
				$data['attr_show']	= intval($_POST['attr_show']);
				$data['attr_sort']	= intval($_POST['attr_sort']);
				$return = $model->table('attribute')->update($data);
				
				/**
				 * 商品禁售
				 */
				if($_POST['off_shelf'] == '1'){
					$this->offTheShelfProductsForAttr(intval($_POST['attr_id']));
				}
				
				if($return){
					showMessage($lang['type_edit_type_attr_edit_succ'],'index.php?act=type&op=type');
				}else{
					showMessage($lang['type_edit_type_attr_edit_fail'],'','','error');
				}
			}
		}
		
		$attr_id	= intval($_GET['attr_id']);
		if($attr_id == 0){
			showMessage($lang['wrong_argument']);
		}
		$attr_info	= $model->table('attribute')->where('attr_id='.$attr_id)->find();
		Tpl::output('attr_info', $attr_info);
		
		$attr_value_list = $model->table('attribute_value')->where('attr_id='.$attr_id)->order('attr_value_sort asc, attr_value_id asc')->select();
		Tpl::output('attr_value_list', $attr_value_list);
		
		Tpl::showpage('type_attr.edit');
	}
	
	/**
	 * 删除属性
	 */
	public function type_delOp(){
		$lang	= Language::getLangContent();
		if(empty($_GET['del_id'])) {
			showMessage($lang['wrong_argument']);
		}
		/**
		 * 属性模型
		 */
		$model_type = Model('type');
		
		if(is_array($_GET['del_id'])){
			$id = "'".implode("','", $_GET['del_id'])."'";
		}else{
			$id = intval($_GET['del_id']);
		}
		/**
		 * 属性列表
		 */
		$type_list	= $model_type->typeList(array('in_type_id'=>$id));
		
		if(is_array($type_list) && !empty($type_list)){
			
			/**
			 * 删除属性值表
			 */
			$attr_list	= $model_type->typeRelatedList('attribute', array('in_type_id'=>$id), 'attr_id');
			if(is_array($attr_list) && !empty($attr_list)){
				$attrs_id = '';
				foreach ($attr_list as $val){
					$attrs_id .= '"'.$val['attr_id'].'",';
				}
				$attrs_id = trim($attrs_id, ',');
				
				$return1 = $model_type->delType('attribute_value', array('in_attr_id'=>$attrs_id));	//删除属性值
				$return2 = $model_type->delType('attribute', array('in_attr_id'=>$attrs_id));		//删除属性
				if(!$return1 || !$return2){
					showMessage($lang['type_index_del_related_attr_fail']);
				}
			}
			
			/**
			 * 删除对应品牌
			 */
			$return = $model_type->delType('type_brand', array('in_type_id'=>$id));
			if(!$return){
				showMessage($lang['type_index_del_related_brand_fail']);
			}
			
			/**
			 * 删除对应规格
			 */
			$return = $model_type->delType('type_spec', array('in_type_id'=>$id));
			if(!$return){
				showMessage($lang['type_index_del_related_type_fail']);
			}
			
			/**
			 * 删除类型
			 */
			$return = $model_type->delType('type', array('in_type_id'=>$id));
			if(!$return){
				showMessage($lang['type_index_del_fail']);
			}
			
			/**
			 * 下架商品
			 */
			$this->offTheShelfProductsForType($id);
			
			showMessage($lang['type_index_del_succ']);
			
		}else{
			showMessage($lang['wrong_argument']);
		}
			

	}
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		/**
		 * 属性模型
		 */
		$model_type = Model('type');
		
		switch ($_GET['branch']){
			case 'sort':
			case 'name':
				$return = $model_type->typeUpdate(
					array($_GET['column']=>trim($_GET['value'])),
					array('type_id'=>intval($_GET['id'])),
					'type'
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
	 * 商品下架  属性修改
	 */
	private function offTheShelfProductsForAttr($a_id){
		$lang	= Language::getLangContent();
		$model_type = Model('type');
		if(is_array($a_id)) $a_id = implode(',', $a_id);
		$goods_id_list = $model_type->typeRelatedList('goods_attr_index', array('in_attr_id'=>$a_id), 'goods_id');
		if(is_array($goods_id_list) && !empty($goods_id_list)){
			$goods_id_array = array();
			foreach($goods_id_list as $val){
				$goods_id_array[] = $val['goods_id'];
			}
			$model_goods = Model('goods');
			$model_goods->updateGoods(array('goods_state'=>'1','goods_show'=>'0', 'goods_close_reason'=>$lang['type_edit_type_goods_close_reason']), $goods_id_array);
		}
	}
	
	/**
	 * 商品下架  类型修改
	 */
	private function offTheShelfProductsForType($t_id){
		$lang	= Language::getLangContent();
		$model_goods_class	= Model('goods_class');
		if(is_array($t_id))	$t_id = implode(',', $t_id);
		$gc_id_list = $model_goods_class->getClassList(array('in_type_id'=>$t_id), 'gc_id');
		if(is_array($gc_id_list) && !empty($gc_id_list)){
			$gc_id_array = array();
			foreach ($gc_id_list as $val){
				$gc_id_array[] = $val['gc_id'];
			}
			$gc_id_in = implode(',', $gc_id_array);
			$model_goods = Model('goods');
			$model_goods->updateGoodsWhere(array('goods_state'=>'1','goods_show'=>'0','goods_close_reason'=>$lang['type_edit_type_goods_close_reason']), array('gc_id_in'=>$gc_id_in));
		}
	}

	/**
	 * 类型导出
	 */
	public function export_step1Op(){
		$model_type = Model('type');
		$page	= new Page();
		$page->setEachNum(self::EXPORT_SIZE);
		$type_list	= $model_type->typeList(array('order'=>'type_sort asc'),$page);
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
				Tpl::output('download_lang',Language::get('nc_type_manage'));
				Tpl::output('murl','index.php?act=type&op=type');				
				Tpl::showpage('export.excel');
			}else{	//如果数量小，直接下载
				$this->createExcel($type_list);
			}
		}else{	//下载
			$this->createExcel($type_list);
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
		$excel_data[0][] = array('styleid'=>'s_title','data'=>L('exp_type_name'));

		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['type_name']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(L('exp_type_name'),CHARSET));
		$excel_obj->generateXML($excel_obj->charset(L('exp_type_name'),CHARSET).$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
}