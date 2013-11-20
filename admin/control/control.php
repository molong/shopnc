<?php
/**
 * 系统后台公共方法
 *
 * 包括系统后台父类
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class SystemControl{
	/**
	 * 管理员资料 name id group
	 */
	private $admin_info;
	public function __construct(){
		Language::read('common,layout');
		/**
		 * 验证用户是否登录
		 * $admin_info 管理员资料 name id
		 */
		$this->admin_info = $this->systemLogin();
		if ($this->admin_info['id'] != 1){
			/**
			 * 验证权限
			 */
			$this->checkPermission($_GET['act']?$_GET['act']:$_POST['act']);
		}

		/**
		 * 转码  防止GBK下用ajax调用时传汉字数据出现乱码
		 */
		if (($_GET['branch']!='' || $_GET['op']=='ajax') && strtoupper(CHARSET) == 'GBK'){
			$_GET = Language::getGBK($_GET);
		}
	}

	/**
	 * 取得当前管理员信息
	 *
	 * @param
	 * @return 数组类型的返回结果
	 */
	protected function getAdminInfo(){
		return $this->admin_info;
	}

	/**
	 * 设置当前管理员信息
	 *
	 * @param array $param 会员信息的参数
	 * @return 数组类型的返回结果
	 */
	protected function setAdminInfo($param){
		return $this->admin_info = $param;
	}

	/**
	 * 系统后台登录验证
	 *
	 * @param
	 * @return array 数组类型的返回结果
	 */
	private function systemLogin(){
		/**
		 * 取得cookie内容，解密，和系统匹配
		 */
		$authkey = md5(C('setup_date').MD5_KEY);
		$tmp = unserialize(decrypt(cookie('sys_key'),$authkey));
		if (empty($tmp) || (empty($tmp['name']) || empty($tmp['id']))){
			/**
			 * 返回错误
			 */
			@header('Location: index.php?act=login&op=login');
			exit;
		}else {
			$this->systemSetKey($tmp['name'],$tmp['id']);
		}
		return $tmp;
	}

	/**
	 * 系统后台 会员登录后 将会员验证内容写入对应cookie中
	 *
	 * @param string $name 用户名
	 * @param int $id 用户ID
	 * @return bool 布尔类型的返回结果
	 */
	private function systemSetKey($name,$id){
		$tmp = array(
					'name'=>$name,
					'id'=>$id
				);
		$authkey = md5(C('setup_date').MD5_KEY);
		setNcCookie('sys_key',encrypt(serialize($tmp),$authkey));
		return true;
	}

	/**
	 * 验证当前管理员权限是否可以进行操作
	 *
	 * @param
	 * @return
	 */
	public function checkPermission($act='index'){
		$model_admin = Model('admin');
		$admin_array = $model_admin->getOneAdmin($this->admin_info['id']);
		if ($admin_array['admin_is_super'] == 1){
			return true;
		}
		$permission = explode('|',$admin_array['admin_permission']);
		if (@in_array('web_config',$permission)) $permission[] = 'web_api';//补充模块编辑弹出页权限
		/**
		 * 几个不需要进行验证的链接
		 */
		$tmp = array('index','dashboard','login');
		$permission = array_merge($permission,$tmp);
		if (@in_array($act,$permission)){
			return true;
		}else {
			showMessage(Language::get('nc_assign_right'),'','html','succ',0);
		}
	}
	/**
	 * 系统通知发送函数
	 *
	 * @param int $receiver_id 接受人编号
	 * @param string $tpl_code 模板标识码
	 * @param array $param 内容数组
	 * @return bool
	 */
	public function send_notice($receiver_id,$tpl_code,$param){

		/**
		 * 获取通知内容模板
		 */
		$mail_tpl_model	= Model('mail_templates');
		$mail_tpl	= $mail_tpl_model->getOneTemplates($tpl_code);
		if(empty($mail_tpl) || $mail_tpl['mail_switch'] == 0)return false;

		/**
		 * 获取接收人信息
		 */
		$member_model	= Model('member');
		$receiver	= $member_model->infoMember(array('member_id'=>$receiver_id));
		if(empty($receiver))return false;
		/**
		 * 为通知模板的主题与内容中变量赋值
		 */
		$subject	= ncReplaceText($mail_tpl['title'],$param);
		$message	= ncReplaceText($mail_tpl['content'],$param);
		/**
		 * 根据模板里面确定的通知类型采用对应模式发送通知
		 */
		$result	= false;
		switch($mail_tpl['type']){
			case '0':
				$email	= new Email();
				$result	= $email->send_sys_email($receiver['member_email'],$subject,$message);
				break;
			case '1':
				$model_message = Model('message');
				$param = array(
					//'msg_title'=>$subject,
					'member_id'=>$receiver_id,
					'to_member_name'=>$receiver['member_name'],
					'msg_content'=>$message,
					'message_type'=>1,//表示系统消息
				);
				$result = $model_message->saveMessage($param);
				break;
		}
		return $result;
	}
	/**
	 * 取得后台菜单
	 *
	 * @param string $permission
	 * @return 
	 */
	public function getNav($permission = '',&$top_nav,&$left_nav,&$map_nav){
		//取出管理员的权限
		$model_admin = Model('admin');
		$admin_array = $model_admin->getOneAdmin($this->admin_info['id']);
		$permission = explode('|',$admin_array['admin_permission']);
		
		/** 几个不需要进行验证的链接 */
		$tmp = array('index','dashboard','login');
		$permission = array_merge($permission,$tmp);		

		Language::read('common');
		$lang = Language::getLangContent();
		$array = require(BasePath.DS.ProjectName.DS.'include'.DS.'menu.php');
		//管理地图
		$map_nav = $array['left'];
		unset($map_nav[0]);
		$model_nav = "<li><a class=\"link actived\" id=\"nav__nav_\" href=\"javascript:;\" onclick=\"openItem('_args_');\"><span>_text_</span></a></li>\n";
		$top_nav = '';

		foreach ($array['top'] as $k=>$v) {
			$v['nav'] = $v['args'];
			$top_nav .= str_ireplace(array('_args_','_text_','_nav_'),$v,$model_nav);
		}
		//得到顶部菜单
		$top_nav = str_ireplace("\n<li><a class=\"link actived\"","\n<li><a class=\"link\"",$top_nav);

		$model_nav = "
          <ul id=\"sort__nav_\">
            <li>
              <dl>
                <dd>
                  <ol>
                    list_body
                  </ol>
                </dd>
              </dl>
            </li>
          </ul>\n";
		$left_nav = '';
		foreach ($array['left'] as $k=>$v) {
			//$left_nav .= str_ireplace(array('_nav_','_text_'),array($v['nav'],$v['text']),$model_nav);
			$left_nav .= str_ireplace(array('_nav_'),array($v['nav']),$model_nav);
			$model_list = "<li nc_type='_pkey_'><a href=\"JavaScript:void(0);\" name=\"item__op_\" id=\"item__op_\" onclick=\"openItem('_args_');\">_text_</a></li>";
			$tmp_list = '';
			
			$current_parent = '';//当前父级key
			
			foreach ($v['list'] as $key=>$value) {
				$model_list_parent = '';
				$args = explode(',',$value['args']);
				if ($admin_array['admin_is_super'] != 1){
					if (!@in_array($args[1],$permission)){
						continue;
					}
				}
				
				if (!empty($value['parent'])){
					if (empty($current_parent) || $current_parent != $value['parent']){
						$model_list_parent = "<li nc_type='parentli' dataparam='{$value['parent']}'><dt>{$value['parenttext']}</dt><dd style='display:block;'></dd></li>";
					}
					$current_parent = $value['parent'];
				}
				
				$value['op'] = $args[0];			
				//$tmp_list .= str_ireplace(array('_args_','_text_','_op_'),$value,$model_list);
				$tmp_list .= str_ireplace(array('_args_','_text_','_op_','_pkey_'),array($value['args'],$value['text'],$value['op'],$value['parent']),$model_list_parent.$model_list);
			}
			//得到左侧菜单
			$left_nav = str_replace('list_body',$tmp_list,$left_nav);
		}
	}
}