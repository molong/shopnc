<?php

!defined('P_W') && exit('Forbidden');
//api mode 1

define('API_USER_USERNAME_NOT_UNIQUE', 100);

class User {

	var $base;
	var $db;

	function User($base) {
		$this->base = $base;
		$this->db = $base->db;
        $this->tablepre = $GLOBALS['tablepre'];
	}

	function getInfo($uids, $fields = array()) {
		if (!$uids) {
			return new ApiResponse(false);
		}
		require_once(R_P.'require/showimg.php');

		$uids = is_numeric($uids) ? array($uids) : explode(",",$uids);

		if (!$fields) $fields = array('uid', 'username', 'icon', 'gender', 'location', 'bday');

		$userService = L::loadClass('UserService', 'user'); /* @var $userService PW_UserService */
		$users = array();
		foreach ($userService->getByUserIds($uids) as $rt) {
			list($rt['icon']) = showfacedesign($rt['icon'], 1, 'm');
			$rt_a = array();
			foreach ($fields as $field) {
				if (isset($rt[$field])) {
					$rt_a[$field] = $rt[$field];
				}
			}
			$users[$rt['uid']] = $rt_a;
		}
		return new ApiResponse($users);
	}

	function alterName($uid, $newname) {
		$userService = L::loadClass('UserService', 'user'); /* @var $userService PW_UserService */
		$userName = $userService->getUserNameByUserId($uid);
		if (!$userName || $userName == $newname) {
			return new ApiResponse(1);
		}
		$existUserId = $userService->getUserIdByUserName($newname);
		if ($existUserId) {
			return new ApiResponse(API_USER_USERNAME_NOT_UNIQUE);
		}
		$userService->update($uid, array('username' => $newname));

		$user = L::loadClass('ucuser', 'user');
		$user->alterName($uid, $userName, $newname);

		return new ApiResponse(1);
	}

	function deluser($uids) {
		$user = L::loadClass('ucuser', 'user');
		$user->delUserByIds($uids);

        $this->db->query("DELETE FROM ".$this->tablepre."member WHERE member_id IN ($uids)");
		$this->db->query("DELETE FROM ".$this->tablepre."store WHERE member_id IN ($uids)");
		/*删除未完，还有其他数据需要删除*/
		return API_RETURN_SUCCEED;

		return new ApiResponse(1);
	}

	function synlogin($user) {
        global $db;
		list($winduid, $windid, $windpwd) = explode("\t", $this->base->strcode($user, false));
		$cookietime = 86400*7;
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        /**
        *同步登陆ShopNC
        */
        $userid = $db->escape_string(trim($winduid));
        $username = $db->escape_string(trim($windid));
		//$member_info = $db->get_one("SELECT * FROM ".$this->tablepre."member WHERE member_name='".$username."' and member_id='".$userid."'");
		$member_info = $db->get_one("SELECT member.*,store.store_name,store.grade_id FROM ".$this->tablepre."member as member left join ".$this->tablepre."store as store on member.store_id = store.store_id  WHERE member.member_name='".$username."' and member.member_id=".$userid);
		if(empty($member_info)) {
			return false;
		}
		if($member_info['member_state'] == '1'){//账号可以使用（1为启用 0 为禁用）
			$db->query("UPDATE ".$this->tablepre."member set member_login_ip='".$this->getIp()."',member_old_login_ip='".$member_info['member_login_ip']."',member_login_num=".($member_info['member_login_num']+1).",member_login_time='".time()."',member_old_login_time='".$member_info['member_login_time']."' WHERE member_name='".$username."' and member_id='".$userid."'");
			/**
			* 写入session
			*/
			$_SESSION['is_login']	= '1';
			$_SESSION['is_seller']	= intval($member_info['store_id']) == 0 ? '' : 1;
			$_SESSION['member_id']	= $member_info['member_id'];
			$_SESSION['member_name']= $member_info['member_name'];
			$_SESSION['member_email']= $member_info['member_email'];		
			if (trim($member_info['member_qqopenid'])){
				$_SESSION['openid']		= $member_info['member_qqopenid'];
			}
			if (trim($member_info['member_sinaopenid'])){
				$_SESSION['slast_key']['uid'] = $member_info['member_sinaopenid'];
			}
			if (intval($member_info['store_id']) > 0){
				$_SESSION['store_id']	= intval($member_info['store_id']);
				$_SESSION['store_name']	= $member_info['store_name'];
				$_SESSION['grade_id']	= $member_info['grade_id'];
			}
		}
	}

	function synlogout() {
        global $db;
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        /**
        *同步退出ShopNC
        */
		session_unset();
		session_destroy();
	}
    function getusergroup() {
        $usergroup = array();
        $query = $this->db->query("SELECT gid,gptype,grouptitle FROM ".UC_DBTABLEPRE."usergroups ");
        while($rt= $this->db->fetch_array($query)) {
            $usergroup[$rt['gid']] = $rt;
        }
        return new ApiResponse($usergroup);
    }
    function getIp(){
		if (@$_SERVER['HTTP_CLIENT_IP'] && $_SERVER['HTTP_CLIENT_IP']!='unknown') {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (@$_SERVER['HTTP_X_FORWARDED_FOR'] && $_SERVER['HTTP_X_FORWARDED_FOR']!='unknown') {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}

?>