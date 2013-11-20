<?php
!defined('P_W') && exit('Forbidden');
//api mode 6

class Credit {

	var $base;
	var $db;

	function Credit($base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function get() {
		 return new ApiResponse(pwCreditNames());
	}

    function syncredit($arr) {
		if (is_array($arr)) {
			foreach ($arr as $uid => $setv) {
				$updateMemberData = array();
				foreach ($setv as $cid => $value) {
                    $value = intval($value);
					$this->db->query("UPDATE ".$this->tablepre."member SET member_points={$value} WHERE uid='".UC::escape($uid)."'");

		            $member_name = $this->db->result_first("SELECT member_name FROM ".$this->tablepre."member WHERE member_id='".UC::escape($uid)."'");
                    $member_points = $this->db->result_first("SELECT member_points FROM ".$this->tablepre."member WHERE member_id='".UC::escape($uid)."'");
                    $amount = $value - $member_points;
                    $member_info	= $model_member->infoMember(array('member_id'=>$_SESSION['member_id']),'member_points');
		            $this->db->query("INSERT INTO ".$this->tablepre."points_log (pl_memberid, pl_membername, pl_points, pl_addtime, pl_desc, pl_stage) VALUES ('$uid', '$member_name', '$amount', '".time()."', '".getGBK('来自其它应用的积分兑入')."', 'app')");
				}
			}
		}
		return new ApiResponse(1);
	}

    function set($uid, $ctype, $value) {
		require_once(SHOPNC_ROOT . 'api/pw_api/credit.php');
		$credit->set($uid, $ctype, $value);
		return new ApiResponse(true);
	}

	function getvalue($uid) {
		require_once(SHOPNC_ROOT . 'api/pw_api/credit.php');
		$getv = $credit->get($uid);
		$retv = array();
		foreach ($credit->cType as $key => $value) {
			$retv[$key] = array('title' => $value, 'value' => isset($getv[$key]) ? $getv[$key] : 0);
		}
		return new ApiResponse($retv);
	}
}
?>