<?php

!defined('P_W') && exit('Forbidden');
//api mode 7

class UserApp {
	
	var $base;
	var $db;

	function UserApp($base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function isInstall($uid) {
		$appid = array();
		$query = $this->db->query("SELECT appid FROM ".UC_DBTABLEPRE."userapp WHERE uid=" . pwEscape($uid));
		while ($rt = $this->db->fetch_array($query)) {
			$appid[] = $rt['appid'];
		}
		return new ApiResponse($appid);
	}

	function add($uid, $appid, $appname, $allowfeed ,$descrip) {
		global $timestamp;

		$this->db->query_unbuffered("REPLACE INTO ".UC_DBTABLEPRE."userapp SET " . pwSqlSingle(array(
			'uid'		=> $uid,
			'appid'		=> $appid,
			'appname'	=> $appname,
			'allowfeed'	=> $allowfeed
		)));

		if ($allowfeed) {
			$descrip = Char_cv($descrip);
			$this->db->query_unbuffered("INSERT INTO ".UC_DBTABLEPRE."feed SET " . pwSqlSingle(array(
				'uid'		=> $uid,
				'type'		=> 'app',
				'descrip'	=> $descrip,
				'timestamp'	=> $timestamp
			),false));
		}
		
		return new ApiResponse(true);
	}

	function appsUpdateCache($apps) {
		if ($apps && is_array($apps)) {

			require_once(R_P.'admin/cache.php');
			setConfig('db_apps_list',$apps);
			updatecache_c();
			return new ApiResponse(true);
		} else {
			return new ApiResponse(false);
		}
	}
}
?>