<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <table class="ncu-table-style">
    <tbody>
      <?php if ($output['follow_list']) { ?>
      <tr>
        <td colspan="2"><ul class="friend-list">
            <?php foreach($output['follow_list'] as $k => $v){ ?>
            <li id="recordone_<?php echo $v['friend_tomid']; ?>">
              <div class="friend-img"><span class="thumb size100"><a href="index.php?act=member_snshome&mid=<?php echo $v['friend_tomid'];?>" target="_blank"><img src="<?php if ($v['member_avatar']!='') { echo ATTACH_AVATAR.DS.$v['member_avatar']; } else { echo ATTACH_COMMON.DS.C('default_user_portrait'); } ?>" alt="<?php echo $v['friend_tomname']; ?>" onload="javascript:DrawImage(this,100,100);" /></a> </span> </div>
              <dl>
                <dt>
                	<a href="index.php?act=member_snshome&mid=<?php echo $v['friend_tomid'];?>" target="_blank" class="friend-name" title="<?php echo $v['friend_tomname']; ?>"><?php echo $v['friend_tomname']; ?></a>
                	<a href="index.php?act=home&op=sendmsg&member_id=<?php echo $v['friend_tomid']; ?>" target="_blank" class="message" title="<?php echo $lang['nc_message'] ;?>">&nbsp;</a>
                	<em class="<?php echo $v['sex_class'];?>"></em></dt>
                <dd class="credit">
                	<?php if (empty($v['credit_arr'])){ echo $lang['nc_buyercredit'].$lang['nc_colon'].$v['member_credit']; }else {?>
                	<span class="buyer-<?php echo $v['credit_arr']['grade']; ?> level-<?php echo $v['credit_arr']['songrade']; ?>"></span>
                	<?php }?>
                </dd>
                <dd class="area"><?php echo $v['member_areainfo'];?></dd>
                <dd>
                  <?php if($v['friend_followstate']==2){?>
                  <span class="fl"><?php echo $lang['snsfriend_follow_eachother'];?></span>
                  <?php }?>
                  <span class="fr cancel"><a href="javascript:void(0)" nc_type="cancelbtn" class="ncu-btn2" data-param='{"mid":"<?php echo $v['friend_tomid'];?>"}'><?php echo $lang['snsfriend_cancel_follow'];?></a></span> </dd>
              </dl>
            </li>
            <?php } ?>
          </ul></td>
      </tr>
      <?php } else { ?>
      <tr>
        <td class="norecord" colspan="2"><i></i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php if ($output['follow_list']) { ?>
    <tfoot>
      <tr>
        <td><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/sns_friend.js"></script> 
