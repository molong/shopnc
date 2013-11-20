<?php
/**
 * 商品分类管理
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
class goods_classControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('goods_class');
	}
	/**
	 * 分类管理
	 */
	public function goods_classOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
		/**
		 * 删除,编辑
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 删除
			 */
			if ($_POST['submit_type'] == 'del'){
				if (!empty($_POST['check_gc_id'])){
					if (is_array($_POST['check_gc_id'])){
						$del_array = $model_class->getChildClass($_POST['check_gc_id']);
						if (is_array($del_array)){
							foreach ($del_array as $k => $v){
								$model_class->del($v['gc_id']);
								$this->offTheShelfProducts(intval($_GET['gc_id']));
								/**
								 * 实例化模型
								 */
								$model_class_tag = Model('goods_class_tag');
								$model_class_tag->delByCondition(array('gc_condition'=>$v['gc_id']));
							}
						}
					}
					showMessage($lang['goods_class_index_del_succ']);
				}else {
					showMessage($lang['goods_class_index_choose_del']);
				}
			}
		}
		/**
		 * 父ID
		 */
		$parent_id = $_GET['gc_parent_id']?intval($_GET['gc_parent_id']):0;
		/**
		 * 列表
		 */
		$tmp_list = $model_class->getTreeClassList(3);
		if (is_array($tmp_list)){
			foreach ($tmp_list as $k => $v){
				if ($v['gc_parent_id'] == $parent_id){
					/**
					 * 判断是否有子类
					 */
					if ($tmp_list[$k+1]['deep'] > $v['deep']){
						$v['have_child'] = 1;
					}
					$class_list[] = $v;
				}
			}
		}
		if ($_GET['ajax'] == '1'){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$class_list = Language::getUTF8($class_list);
			}
			$output = json_encode($class_list);
			print_r($output);
			exit;
		}else {
			Tpl::output('class_list',$class_list);
			Tpl::showpage('goods_class.index');
		}
	}

	/**
	 * 商品分类添加
	 */
	public function goods_class_addOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
		if (chksubmit()){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["gc_name"], "require"=>"true", "message"=>$lang['goods_class_add_name_null']),
				array("input"=>$_POST["gc_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['goods_class_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$insert_array = array();
				$insert_array['gc_name']		= trim($_POST['gc_name']);
				$insert_array['type_id']		= intval($_POST['t_id']);
				$insert_array['type_name']		= trim($_POST['t_name']);
				$insert_array['gc_parent_id']	= intval($_POST['gc_parent_id']);
				$insert_array['gc_sort']		= intval($_POST['gc_sort']);
				$insert_array['gc_show']		= intval($_POST['gc_show']);
				$insert_array['gc_keywords']	= $_POST['gc_keywords'];
				$insert_array['gc_description']	= $_POST['gc_description'];

				$result = $model_class->add($insert_array);
				if ($result){
					$url = array(
						array(
							'url'=>'index.php?act=goods_class&op=goods_class_add&gc_parent_id='.$_POST['gc_parent_id'],
							'msg'=>$lang['goods_class_add_again'],
						),
						array(
							'url'=>'index.php?act=goods_class&op=goods_class',
							'msg'=>$lang['goods_class_add_back_to_list'],
						)
					);
					showMessage($lang['goods_class_add_succ'],$url);
				}else {
					showMessage($lang['goods_class_add_fail']);
				}
			}
		}
		/**
		 * 父类列表，只取到第二级
		 */
		$parent_list = $model_class->getTreeClassList(2);
		if (is_array($parent_list)){
			foreach ($parent_list as $k => $v){
				$parent_list[$k]['gc_name'] = str_repeat("&nbsp;",$v['deep']*2).$v['gc_name'];
			}
		}

		/**
		 * 类型列表
		 */
		$model_type	= Model('type');
		$type_list	= $model_type->typeList(array('order'=>'type_sort asc'), '', 'type_id,type_name');
		
		Tpl::output('type_list',$type_list);
		Tpl::output('gc_parent_id',$_GET['gc_parent_id']);
		Tpl::output('parent_list',$parent_list);
		Tpl::showpage('goods_class.add');
	}
	
	/**
	 * 编辑
	 */
	public function goods_class_editOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
		
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 验证
			 */
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["gc_name"], "require"=>"true", "message"=>$lang['goods_class_add_name_null']),
				array("input"=>$_POST["gc_sort"], "require"=>"true", 'validator'=>'Number', "message"=>$lang['goods_class_add_sort_int']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}
			
			/**
			 * 商品下架
			 */
			if($_POST['t_sign'] == 'ok'){
				$this->offTheShelfProducts(intval($_POST['gc_id']));
			}
				
			// 更新分类信息
			$update_array = array();
			$update_array['gc_id']			= intval($_POST['gc_id']);
			$update_array['gc_name'] 		= trim($_POST['gc_name']);
			$update_array['type_id']		= intval($_POST['t_id']);
			$update_array['type_name']		= trim($_POST['t_name']);
			$update_array['gc_sort']		= intval($_POST['gc_sort']);
			$update_array['gc_show']		= intval($_POST['gc_show']);
			$update_array['gc_keywords']	= $_POST['gc_keywords'];
			$update_array['gc_description']	= $_POST['gc_description'];

			$result = $model_class->goodsClassUpdate($update_array);
			if (!$result){
				showMessage($lang['goods_class_batch_edit_fail']);
			}
			
			// 更新该分类下子分类的所有类型。
			if (isset($_POST['t_associated']) && $_POST['t_associated'] == '1'){
				$gc_id_list = $model_class->getChildClass($_POST['gc_id']);
				if (is_array($gc_id_list) && !empty($gc_id_list)){
					$gc_id_str = '';
					foreach ($gc_id_list as $val){
						$gc_id_str .=$val['gc_id'].',';
					}
					$gc_id_str = rtrim($gc_id_str,',');
					$this->offTheShelfProducts($gc_id_str);
					$model_class->updateWhere(array('type_id'=>intval($_POST['t_id']), 'type_name'=>trim($_POST['t_name'])), array('in_gc_id'=>$gc_id_str));
				}
			}
			
			$url = array(
				array(
					'url'=>'index.php?act=goods_class&op=goods_class_edit&gc_id='.intval($_POST['gc_id']),
					'msg'=>$lang['goods_class_batch_edit_again'],
				),
				array(
					'url'=>'index.php?act=goods_class&op=goods_class',
					'msg'=>$lang['goods_class_add_back_to_list'],
				)
			);
			showMessage($lang['goods_class_batch_edit_ok'],$url);
		}
				
		$class_array = $model_class->getOneGoodsClass(intval($_GET['gc_id']));
		if (empty($class_array)){
			showMessage($lang['goods_class_batch_edit_paramerror']);
		}

		/**
		 * 类型列表
		 */
		$model_type	= Model('type');
		$type_list	= $model_type->typeList(array('order'=>'type_sort asc'), '', 'type_id,type_name');
		
//		Tpl::output('select_sign',$select_sign);
		Tpl::output('type_list',$type_list);
		Tpl::output('class_array',$class_array);
		Tpl::showpage('goods_class.edit');
	}
	
	/**
	 * 分类导入
	 */
	public function goods_class_importOp(){
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_class = Model('goods_class');
		/**
		 * 导入
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 得到导入文件后缀名
			 */
			$file_type = end(explode('.',$_FILES['csv']['name']));
			if (!empty($_FILES['csv']) && !empty($_FILES['csv']['name']) && $file_type == 'csv'){
				$fp = @fopen($_FILES['csv']['tmp_name'],'rb');
				/**
				 * 父ID
				 */
				$parent_id_1 = 0;
				
				while (!feof($fp)) {
					$data = fgets($fp, 4096);
					switch (strtoupper($_POST['charset'])){
						case 'UTF-8':
							if (strtoupper(CHARSET) !== 'UTF-8'){
								$data = iconv('UTF-8',strtoupper(CHARSET),$data);
							}
							break;
						case 'GBK':
							if (strtoupper(CHARSET) !== 'GBK'){
								$data = iconv('GBK',strtoupper(CHARSET),$data);
							}
							break;
					}
					
					if (!empty($data)){
						$data	= str_replace('"','',$data);
						/**
						 * 逗号去除
						 */
						$tmp_array = array();
						$tmp_array = explode(',',$data);
						if($tmp_array[0] == 'sort_order')continue;
						/**
						 * 第一位是序号，后面的是内容，最后一位名称
						 */
						$tmp_deep = 'parent_id_'.(count($tmp_array)-1);
						
						$insert_array = array();
						$insert_array['gc_sort'] = $tmp_array[0];
						$insert_array['gc_parent_id'] = $$tmp_deep;
						$insert_array['gc_name'] = $tmp_array[count($tmp_array)-1];
						$gc_id = $model_class->add($insert_array);
						/**
						 * 赋值这个深度父ID
						 */
						$tmp = 'parent_id_'.count($tmp_array);
						$$tmp = $gc_id;
					}
				}
				/**
				 * 重新生成缓存
				 */
				
				showMessage($lang['goods_class_import_succ'],'index.php?act=goods_class&op=goods_class');
			}else {
				showMessage($lang['goods_class_import_csv_null']);
			}
		}
		Tpl::showpage('goods_class.import');
	}
	
	/**
	 * 分类导出
	 */
	public function goods_class_exportOp(){
		/**
		 * 导出
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 实例化模型
			 */
			$model_class = Model('goods_class');
			/**
			 * 分类信息
			 */
			$class_list = $model_class->getTreeClassList();
			
			@header("Content-type: application/unknown");
        	@header("Content-Disposition: attachment; filename=goods_class.csv");
			if (is_array($class_list)){
				foreach ($class_list as $k => $v){
					$tmp = array();
					/**
					 * 序号
					 */
					$tmp['gc_sort'] = $v['gc_sort'];
					/**
					 * 深度
					 */
					for ($i=1; $i<=($v['deep']-1); $i++){
						$tmp[] = '';
					}
					/**
					 * 分类名称
					 */
					$tmp['gc_name'] = $v['gc_name'];
					/**
					 * 转码 utf-gbk
					 */
					if (strtoupper(CHARSET) == 'UTF-8'){
						switch ($_POST['if_convert']){
							case '1':
								$tmp_line = iconv('UTF-8','GB2312//IGNORE',join(',',$tmp));
								break;
							case '0':
								$tmp_line = join(',',$tmp);
								break;
						}
					}else {
						$tmp_line = join(',',$tmp);
					}
					$tmp_line = str_replace("\r\n",'',$tmp_line);
					echo $tmp_line."\r\n";
				}
			}
			exit;
		}
		Tpl::showpage('goods_class.export');
	}
	
	/**
	 * 删除分类
	 */
	public function goods_class_delOp(){
		$lang	= Language::getLangContent();
		$model_class = Model('goods_class');
		if (intval($_GET['gc_id']) > 0){
			/**
			 * 删除分类
			 */
			$model_class->del(intval($_GET['gc_id']));
			/**
			 * 实例化模型
			 */
			$model_class_tag = Model('goods_class_tag');
			$model_class_tag->delByCondition(array('gc_condition'=>intval($_GET['gc_id'])));
			$this->offTheShelfProducts(intval($_GET['gc_id']));
			showMessage($lang['goods_class_index_del_succ'],'index.php?act=goods_class&op=goods_class');
		}else {
			showMessage($lang['goods_class_index_choose_del'],'index.php?act=goods_class&op=goods_class');
		}
	}
	
	/**
	 * tag列表
	 */
	public function goods_class_tagOp(){
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_class_tag = Model('goods_class_tag');
		/**
		 * 删除
		 */
		if ($_POST['form_submit'] == 'ok'){
			/**
			 * 删除
			 */
			if ($_POST['submit_type'] == 'del'){
				if (is_array($_POST['tag_id']) && !empty($_POST['tag_id'])){
					/**
					 * 删除TAG
					 */
					$id = '"'.implode('","', $_POST['tag_id']).'"';
					$model_class_tag->delTag($id);
					showMessage($lang['goods_class_tag_del_succ']);
				}else {
					showMessage($lang['goods_class_tag_del_fail']);
				}
			}
		}
		
		/**
		 * 分页
		 */
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		
		$tag_list = $model_class_tag->getTagList(array(), $page);
		Tpl::output('tag_list', $tag_list);
		Tpl::output('page',$page->show());
		Tpl::showpage('goods_class_tag.index');
	}
	
	/**
	 * 重置TAG
	 */
	public function reset_tagOp(){
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_class = Model('goods_class');
		$model_class_tag = Model('goods_class_tag');
		
		/**
		 * 清空TAG
		 */
		$return = $model_class_tag->clearTag();
		if(!$return){
			showMessage($lang['goods_class_reset_tag_fail'], 'index.php?act=goods_class&op=goods_class_tag');
		}
		
		/**
		 * 商品分类
		 */
		$goods_class		= $model_class->getTreeClassList(3,array('order'=>'gc_parent_id asc,gc_sort asc,gc_id asc'));
		/**
		 * 格式化分类。组成三维数组
		 */
		if(is_array($goods_class) and !empty($goods_class)) {
			$goods_class_array = array();
			foreach ($goods_class as $val) {
				//一级分类
				if($val['gc_parent_id'] == 0) {
					$goods_class_array[$val['gc_id']]['gc_name']	= $val['gc_name'];
					$goods_class_array[$val['gc_id']]['gc_id']		= $val['gc_id'];
					$goods_class_array[$val['gc_id']]['type_id']	= $val['type_id'];
				}else {
					//二级分类
					if(isset($goods_class_array[$val['gc_parent_id']])){
						$goods_class_array[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_name']			= $val['gc_name'];
						$goods_class_array[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_id']			= $val['gc_id'];
						$goods_class_array[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_parent_id']	= $val['gc_parent_id'];
						$goods_class_array[$val['gc_parent_id']]['sub_class'][$val['gc_id']]['type_id']			= $val['type_id'];
					}else{
						foreach ($goods_class_array as $v){
							//三级分类
							if(isset($v['sub_class'][$val['gc_parent_id']])){
								$goods_class_array[$v['sub_class'][$val['gc_parent_id']]['gc_parent_id']]['sub_class'][$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_name']	= $val['gc_name'];
								$goods_class_array[$v['sub_class'][$val['gc_parent_id']]['gc_parent_id']]['sub_class'][$val['gc_parent_id']]['sub_class'][$val['gc_id']]['gc_id']	= $val['gc_id'];
								$goods_class_array[$v['sub_class'][$val['gc_parent_id']]['gc_parent_id']]['sub_class'][$val['gc_parent_id']]['sub_class'][$val['gc_id']]['type_id']	= $val['type_id'];
							}
						}
					}
				}
			}

			$return = $model_class_tag->tagAdd($goods_class_array);

			if($return){
				showMessage($lang['goods_class_reset_tag_succ'], 'index.php?act=goods_class&op=goods_class_tag');
			}else{
				showMessage($lang['goods_class_reset_tag_fail'], 'index.php?act=goods_class&op=goods_class_tag');
			}
			
		}else{
			showMessage($lang['goods_class_reset_tag_fail_no_class'], 'index.php?act=goods_class&op=goods_class_tag');
		}
	}
	
	/**
	 * 更新TAG名称
	 */
	public function update_tag_nameOp(){
		$lang	= Language::getLangContent();
		/**
		 * 实例化模型
		 */
		$model_class = Model('goods_class');
		$model_class_tag = Model('goods_class_tag');
		
		//需要更新的TAG列表
		$tag_list = $model_class_tag->getTagList(array(), '', 'gc_tag_id,gc_id_1,gc_id_2,gc_id_3');
		if(is_array($tag_list) && !empty($tag_list)){
			foreach ($tag_list as $val){
				//查询分类信息
				$in_gc_id = '';
				if($val['gc_id_1'] != '0'){
					$in_gc_id .= "'".$val['gc_id_1']."',";
				}
				if($val['gc_id_2'] != '0'){
					$in_gc_id .= "'".$val['gc_id_2']."',";
				}
				if($val['gc_id_3'] != '0'){
					$in_gc_id .= "'".$val['gc_id_3']."',";
				}
				$in_gc_id	= trim($in_gc_id, ',');
				$gc_list	= $model_class->getClassList(array('in_gc_id'=>$in_gc_id));
				
				//更新TAG信息
				$update_tag					= array();
				if(isset($gc_list['0']['gc_id']) && $gc_list['0']['gc_id'] != '0'){
					$update_tag['gc_id_1']		= $gc_list['0']['gc_id'];
					$update_tag['gc_tag_name']	.= $gc_list['0']['gc_name'];
				}
				if(isset($gc_list['1']['gc_id']) && $gc_list['1']['gc_id'] != '0'){
					$update_tag['gc_id_2']		= $gc_list['1']['gc_id'];
					$update_tag['gc_tag_name']	.= "&nbsp;&gt;&nbsp;".$gc_list['1']['gc_name'];
				}
				if(isset($gc_list['2']['gc_id']) && $gc_list['2']['gc_id'] != '0'){
					$update_tag['gc_id_3']		= $gc_list['2']['gc_id'];
					$update_tag['gc_tag_name']	.= "&nbsp;&gt;&nbsp;".$gc_list['2']['gc_name'];
				}
				unset($gc_list);
				$update_tag['gc_tag_id']	= $val['gc_tag_id'];
				$return = $model_class_tag->updateTag($update_tag);
				if(!$return){
					showMessage($lang['goods_class_update_tag_fail'], 'index.php?act=goods_class&op=goods_class_tag');
				}
			}
			showMessage($lang['goods_class_update_tag_succ'], 'index.php?act=goods_class&op=goods_class_tag');
		}else{
			showMessage($lang['goods_class_update_tag_fail_no_class'], 'index.php?act=goods_class&op=goods_class_tag');
		}
		
	}
	
	/**
	 * 删除TAG
	 */	
	public function tag_delOp(){
		$id = intval($_GET['tag_id']);
		$lang	= Language::getLangContent();
		$model_class_tag = Model('goods_class_tag');
		if ($id > 0){
			/**
			 * 删除TAG
			 */
			$model_class_tag->delTag($id);
			showMessage($lang['goods_class_tag_del_succ']);
		}else {
			showMessage($lang['goods_class_tag_del_fail']);
		}
	}
	
	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		switch ($_GET['branch']){
			/**
			 * 更新分类
			 */
			case 'goods_class_name':
				$model_class = Model('goods_class');
				$class_array = $model_class->getOneGoodsClass(intval($_GET['id']));
				
				$condition['gc_name'] = trim($_GET['value']);
				$condition['gc_parent_id'] = $class_array['gc_parent_id'];
				$condition['no_gc_id'] = intval($_GET['id']);
				$class_list = $model_class->getClassList($condition);
				if (empty($class_list)){
					$update_array = array();
					$update_array['gc_id'] = intval($_GET['id']);
					$update_array['gc_name'] = trim($_GET['value']);
					$model_class->goodsClassUpdate($update_array);
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
			/**
			 * 分类 排序 显示 设置
			 */
			case 'goods_class_sort':
			case 'goods_class_show':
			case 'goods_class_index_show':
				$model_class = Model('goods_class');
				$update_array = array();
				$update_array['gc_id'] = $_GET['id'];
				$update_array[$_GET['column']] = $_GET['value'];
				$model_class->goodsClassUpdate($update_array);
				echo 'true';exit;
				break;
			/**
			 * 添加、修改操作中 检测类别名称是否有重复
			 */
			case 'check_class_name':
				$model_class = Model('goods_class');
				$condition['gc_name'] = trim($_GET['gc_name']);
				$condition['gc_parent_id'] = intval($_GET['gc_parent_id']);
				$condition['no_gc_id'] = intval($_GET['gc_id']);
				$class_list = $model_class->getClassList($condition);
				if (empty($class_list)){
					echo 'true';exit;
				}else {
					echo 'false';exit;
				}
				break;
			/**
			 * TAG值编辑
			 */
			case 'goods_class_tag_value':
				$model_class_tag = Model('goods_class_tag');
				$update_array = array();
				$update_array['gc_tag_id'] = intval($_GET['id']);
				/**
				 * 转码  防止GBK下用中文逗号截取不正确
				 */
				$comma = '，';
				if (strtoupper(CHARSET) == 'GBK'){
					$comma = Language::getGBK($comma);
				}
				$update_array[$_GET['column']] = trim(str_replace($comma,',',$_GET['value']));
				$model_class_tag->updateTag($update_array);
				echo 'true';exit;
				break;
		}
	}
	
	/**
	 * 商品下架 
	 */
	private function offTheShelfProducts($gc_id_str){
		$lang	= Language::getLangContent();
		$model_goods = Model('goods');
		$model_goods->updateGoodsWhere(array('goods_state'=>'1','goods_show'=>'0', 'goods_close_reason'=>$lang['goods_class_edit_goods_close_reason']), array('gc_id_in'=>$gc_id_str));
	}
	
}