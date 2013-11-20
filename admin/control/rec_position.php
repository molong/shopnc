<?php
/**
 * 推荐位
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
class rec_positionControl extends SystemControl{
	public function __construct(){
		parent::__construct();
		Language::read('rec_position');
	}
	/**
	 * 推荐位列表
	 *
	 */
	public function rec_listOp(){
		$model = model('rec_position');
		//删除推荐位
		if (chksubmit()){
			$condition = array('rec_id'=>array('in',$_POST['rec_id']));
			$list = $model->where($condition)->select();
			if (!$list)	showMessage(Language::get('wrong_argument'));

			$result = $model->where($condition)->delete();
			if ($result){
				foreach ($list as $info){
					$info['content'] = unserialize($info['content']);
					if ($info['pic_type'] == 1 && is_array($info['content']['body'])){
						foreach ($info['content']['body'] as $v){
							@unlink(str_replace('SiteUrl',BasePath,$v['title']));
						}
					}
					if (file_exists($file = BasePath."/cache/rec_position/{$info['rec_id']}.php")) @unlink($file);
				}
			}else{
				showMessage(Language::get('nc_common_del_fail'));
			}
		}
		$condition = array();
		if ($_GET['pic_type'] == '0'){
			$condition['pic_type'] = 0;
		}elseif($_GET['pic_type'] == 1){
			$condition['pic_type'] = array('in','2,3');
		}
		if (!empty($_GET['keywords'])){
			$condition['title'] = array('like','%'.$_GET['keywords'].'%');
		}
		$list = $model->where($condition)->order('rec_id desc')->page(10)->select();
		foreach ((array)$list as $k=>$v){
			$list[$k]['content'] = unserialize($v['content']);
		}
		Tpl::output('list',$list);
		Tpl::output('page',$model->showpage());
		Tpl::showpage('rec_position.index');
	}
	/**
	 * 新增推荐位
	 *
	 */
	public function rec_addOp(){
		Tpl::showpage('rec_position.add');
	}
	/**
	 * 编辑推荐位
	 *
	 */
	public function rec_editOp(){
		$model = Model('rec_position');
		$info = $model->where(array('rec_id'=>intval($_GET['rec_id'])))->find();
		if (!$info)	showMessage(Language::get('no_record'));
		$info['content'] = unserialize($info['content']);
		Tpl::output('info',$info);
		Tpl::showpage('rec_position.edit');
	}
	/**
	 * 删除
	 *
	 */
	public function rec_delOp(){
		$model = Model('rec_position');
		$_GET['rec_id'] = intval($_GET['rec_id']);
		$info = $model->where(array('rec_id'=>$_GET['rec_id']))->find();
		if (!$info)	showMessage(Language::get('no_record'));
		
		$info['content'] = unserialize($info['content']);
		$result = $model->where(array('rec_id'=>$_GET['rec_id']))->delete();
		if ($result){
			if ($info['pic_type'] == 1 && is_array($info['content']['body'])){
				foreach ($info['content']['body'] as $v){
					@unlink(str_replace('SiteUrl',BasePath,$v['title']));
				}
			}
			if (file_exists($file = BasePath."/cache/rec_position/{$info['rec_id']}.php")) @unlink($file);
			showMessage(Language::get('nc_common_save_succ'));
		}else{
			showMessage(Language::get('nc_common_save_fail'));
		}
	}
	/**
	 * 添加保存推荐位
	 *
	 */
	public function rec_saveOp(){
		$array = array();
		$data = array();
		$pattern = "/^http:\/\/[A-Za-z0-9]+[A-Za-z0-9.]+\.[A-Za-z0-9]+/i";
		//文字类型
		if ($_POST['rec_type'] == 1){
			if (is_array($_POST['txt']) && is_array($_POST['urltxt'])){
				foreach ($_POST['txt'] as $k=>$v){
					if (trim($v) == '') continue;
					$c = count($array['body']);
					$array['body'][$c]['title'] = $v;
					$array['body'][$c]['url'] = preg_match($pattern,$_POST['urltxt'][$k]) ? $_POST['urltxt'][$k] : '';
					$data['pic_type'] = 0;
				}
			}else{
				showMessage(Language::get('wrong_argument'));
			}
		}elseif ($_POST['rec_type'] == 2 && $_POST['pic_type'] == 1){

			//本地图片上传
			if (is_array($_FILES['pic']['tmp_name'])){
				foreach($_FILES['pic']['tmp_name'] as $k=>$v){
					if (empty($v)) continue;
					$ext = pathinfo($_FILES['pic']['name'][$k], PATHINFO_EXTENSION);
					if (in_array(strtolower($ext),array('jpg','jpeg','gif','png'))){
						$filename = substr(md5(microtime(true)),0,16).rand(100,999).$k.'.'.$ext;
						if ($_FILES['pic']['size'][$k]<1024*1024){
							move_uploaded_file($v,BasePath.'/'.ATTACH_PATH.'/rec_position/'.$filename);
						}
						if ($_FILES['pic']['error'][$k] != 0) showMessage(Language::get('nc_common_op_fail'));
						$c = count($array['body']);
						$array['body'][$c]['title'] = 'SiteUrl/upload/rec_position/'.$filename;
						$array['body'][$c]['url'] 	= preg_match($pattern,$_POST['urlup'][$k]) ? $_POST['urlup'][$k] : '';
						$array['width']				= is_numeric($_POST['rwidth']) ? $_POST['rwidth'] : ''; 
						$array['height']			= is_numeric($_POST['rheight']) ? $_POST['rheight'] : ''; 
						$data['pic_type']			= 1;
					}
					if (empty($array)) showMessage(Language::get('wrong_argument'));
				}
			}
		}elseif ($_POST['rec_type'] == 2 && $_POST['pic_type'] == 2){

			//远程图片
			if (is_array($_POST['pic'])){
				foreach ($_POST['pic'] as $k=>$v){
					if (!preg_match("/^(http\:\/\/)/i",$v)) continue;
					$ext = pathinfo($v, PATHINFO_EXTENSION);
					if (in_array(strtolower($ext),array('jpg','jpeg','gif','png','bmp'))){
						$c = count($array['body']);
						$array['body'][$c]['title'] = $v;
						$array['body'][$c]['url'] 	= preg_match($pattern,$_POST['urlremote'][$k]) ? $_POST['urlremote'][$k] : '';
						$array['width']				= is_numeric($_POST['rwidth']) ? $_POST['rwidth'] : ''; 
						$array['height']			= is_numeric($_POST['rheight']) ? $_POST['rheight'] : ''; 
						$data['pic_type']			= 2;
					}
					if (empty($array)) showMessage(Language::get('wrong_argument'));
				}
			}
		}else{
			showMessage(Language::get('wrong_argument'));
		}
		$array['target'] 	= intval($_POST['rtarget']);
		$data['title'] 		= $_POST['rtitle'];
		$data['content'] 	= serialize($array);
		$model = Model('rec_position');
		$model->insert($data);
		showMessage(Language::get('nc_common_save_succ'),'index.php?act=rec_position&op=rec_list');
	}
	/**
	 * 编辑保存推荐位
	 *
	 */

	public function rec_edit_saveOp(){		
		if (!is_numeric($_POST['rec_id'])) showMessage(Language::get('wrong_argument'));
		$array = array();
		$data = array();
		$pattern = "/^http:\/\/[A-Za-z0-9]+[A-Za-z0-9.]+\.[A-Za-z0-9]+/i";
		//文字类型
		if ($_POST['rec_type'] == 1){
			if (is_array($_POST['txt']) && is_array($_POST['urltxt'])){
				foreach ($_POST['txt'] as $k=>$v){
					if (trim($v) == '') continue;
					$c = count($array['body']);
					$array['body'][$c]['title'] = $v;
					$array['body'][$c]['url'] = preg_match($pattern,$_POST['urltxt'][$k]) ? $_POST['urltxt'][$k] : '';
					$data['pic_type'] = 0;
				}
			}else{
				showMessage(Language::get('wrong_argument'));
			}
		}elseif ($_POST['rec_type'] == 2 && $_POST['pic_type'] == 1){
			//本地图片上传
			if (is_array($_FILES['pic']['tmp_name'])){
				foreach($_FILES['pic']['tmp_name'] as $k=>$v){
					//未上传新图的，还用老图
					if (empty($v) && !empty($_POST['opic'][$k])){
						$array['body'][$k]['title'] = $_POST['opic'][$k];
						$array['body'][$k]['url'] 	= preg_match($pattern,$_POST['urlup'][$k]) ? $_POST['urlup'][$k] : '';						
					}
					$ext = pathinfo($_FILES['pic']['name'][$k], PATHINFO_EXTENSION);
					if (in_array(strtolower($ext),array('jpg','jpeg','gif','png','bmp'))){
						$filename = substr(md5(microtime(true)),0,16).rand(100,999).$k.'.'.$ext;
						if ($_FILES['pic']['size'][$k]<1024*1024){
							move_uploaded_file($v,BasePath.'/'.ATTACH_PATH.'/rec_position/'.$filename);
						}
						if ($_FILES['pic']['error'][$k] != 0) showMessage('上传失败');

						//删除老图
						$opic = str_replace('SiteUrl',BasePath,$_POST['opic'][$k]);
						if (is_file($opic)) @unlink($opic);

						$array['body'][$k]['title'] = 'SiteUrl/upload/rec_position/'.$filename;
						$array['body'][$k]['url'] 	= preg_match($pattern,$_POST['urlup'][$k]) ? $_POST['urlup'][$k] : '';
						$data['pic_type']			= 1;
					}
				}
				//最后删除数据库里有但没有POST过来的图片
				$model = Model('rec_position');
				$oinfo = $model->where(array('rec_id'=>$_POST['rec_id']))->find();
				$oinfo = unserialize($oinfo['content']);
				foreach ($oinfo['body'] as $k=>$v) {
					if (!in_array($v['title'],(array)$_POST['opic'])){
						if (is_file(str_replace('SiteUrl',BasePath,$v['title']))){
							@unlink(str_replace('SiteUrl',BasePath,$v['title']));
						}				
					}
				}
				unset($oinfo);
			}
			//如果是上传图片，则取原图片地址
			if (empty($array)){
				if (is_array($_POST['opic'])){
					foreach ($_POST['opic'] as $k=>$v){
						$array['body'][$k]['title'] = $v;
						$array['body'][$k]['url'] 	= preg_match($pattern,$_POST['urlup'][$k]) ? $_POST['urlup'][$k] : '';						
					}
				}
			}
		}elseif ($_POST['rec_type'] == 2 && $_POST['pic_type'] == 2){

			//远程图片
			if (is_array($_POST['pic'])){
				foreach ($_POST['pic'] as $k=>$v){
					if (!preg_match("/^(http\:\/\/)/i",$v)) continue;
					$ext = pathinfo($v, PATHINFO_EXTENSION);
					if (in_array(strtolower($ext),array('jpg','jpeg','gif','png','bmp'))){
						$c = count($array['body']);
						$array['body'][$c]['title'] = $v;
						$array['body'][$c]['url'] 	= preg_match($pattern,$_POST['urlremote'][$k]) ? $_POST['urlremote'][$k] : '';
						$data['pic_type']			= 2;
					}
				}
			}
		}else{
			showMessage(Language::get('wrong_argument'));
		}

		if ($_POST['rec_type'] != 1){
			$array['width']				= is_numeric($_POST['rwidth']) ? $_POST['rwidth'] : ''; 
			$array['height']			= is_numeric($_POST['rheight']) ? $_POST['rheight'] : '';		
		}

		$array['target'] 	= intval($_POST['rtarget']);
		$data['title'] 		= $_POST['rtitle'];
		$data['content'] 	= serialize($array);
		$model = Model('rec_position');

		//如果是把本地上传类型改为文字或远程，则先取出原来上传的图片路径，待update成功后，再删除这些图片
		if ($_POST['opic_type'] == 1 && ($_POST['pic_type'] == 2 || $_POST['rec_type'] == 1)){
			$oinfo = $model->where(array('rec_id'=>$_POST['rec_id']))->find();
			$oinfo = unserialize($oinfo['content']);
		}
		$result = $model->where(array('rec_id'=>$_POST['rec_id']))->update($data);
		if ($result){
			if ($oinfo){
				foreach ($oinfo['body'] as $v){
					if (is_file(str_replace('SiteUrl',BasePath,$v['title']))){
						@unlink(str_replace('SiteUrl',BasePath,$v['title']));
					}
				}				
			}
			if (file_exists($file = BasePath."/cache/rec_position/{$_POST['rec_id']}.php")) @unlink($file);
			showMessage(Language::get('nc_common_save_succ'),'index.php?act=rec_position&op=rec_list');
		}else{
			showMessage(Language::get('nc_common_save_fail'),'index.php?act=rec_position&op=rec_list');
		}
	}

	public function rec_codeOp(){
		Tpl::showpage('rec_position.code','null_layout');		
	}
	public function rec_viewOp(){
		@header("Content-type: text/html; charset=".CHARSET);
		echo rec(intval($_GET['rec_id']));
	}	
}