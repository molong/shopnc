<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <form method="post" id="store_form" action="index.php?act=store_adv&op=adv_del">
    <table class="ncu-table-style">
      <thead>
        <tr>
          <th><?php echo $lang['ap_title']; ?></th>
          <th class="w200"><?php echo $lang['ap_intro']; ?></th>
          <th class="w80"><?php echo $lang['ap_style']; ?></th>
          <th class="w80"><?php echo $lang['ap_show_style']; ?></th>
          <th class="w80"><?php echo $lang['ap_now_show_num']; ?></th>
          <th class="w80"><?php echo $lang['ap_overtime']; ?></th>
          <th class="w90"><?php echo $lang['ap_option']; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['ap_info']) && is_array($output['ap_info'])){ foreach ($output['ap_info'] as $k=>$v){ ?>
        <tr class="bd-line">
          <td title="<?php echo $v['ap_name']; ?>"><?php echo $v['ap_name']; ?></td>
          <td title="<?php echo $v['ap_intro']; ?>"><?php echo $v['ap_intro']; ?></td>
          <td><?php 
       switch ($v['ap_class']){
        	case '0':
        		echo $lang['ap_pic'];
        		break;
        	case '1':
        		echo $lang['ap_word'];
        		break;
        	case '2':
        		echo $lang['ap_slide'];
        		break;
        	case '3':
        		echo "Flash";
        		break;
        }
       ?></td>
          <td><?php 
       switch ($v['ap_display']){
        	case '0':
        		echo $lang['ap_showstyle_slide'];
        		break;
        	case '1':
        		echo $lang['ap_showstyle_m'];
        		break;
        	case '2':
        		echo $lang['ap_showstyle_single'];
        		break;
        }
       ?></td>
          <td><?php 
       if(empty($output['adv_info'])){
       	echo "0";
       }else{
       $now   = 0;
       $order = 0;
       $time  = time();
       foreach ($output['adv_info'] as $adv_k=>$adv_v){
       	if($adv_v['ap_id'] == $v['ap_id']&&$adv_v['adv_end_date'] > $time&&$adv_v['adv_start_date'] < $time&&$adv_v['is_allow'] == '1'){
       		$now++;
       	}elseif ($adv_v['ap_id'] == $v['ap_id']&&$adv_v['adv_start_date'] > $time&&$v['ap_display'] != '0'){
       		$order++;
       	}
       }
       if($order == 0){
       	echo $now;
       }else{
       	echo $now."(".$lang['adv_buy_order'].$order.")";
       }
       }     
       ?></td>
          <td class="goods-time"><?php 
       if($v['ap_display'] == '2'&&$now != 0){
        $order_time = 1;
       	foreach ($output['adv_info'] as $adv_k=>$adv_v){
            if($adv_v['ap_id'] == $v['ap_id']){
                if(intval($adv_v['adv_end_date']) > $order_time) $order_time = intval($adv_v['adv_end_date']);
       		}
       	}
        echo "<span style='color:red'>".date('Y-m-d',$order_time)."</span>";
       }else{
       	echo $lang['adv_buy_nothing'];
       }
       ?></td>
          <td><?php 
       if ($v['ap_display'] == '2'&&$now != 0){
       	echo "<a href='index.php?act=store_adv&op=adv_buy&do=order&ap_id=".$v['ap_id']."&ordertime=".$order_time."' class='ncu-btn2'>".$lang['adv_buy_click_order']."</a>";
       }else{
       	echo "<a href='index.php?act=store_adv&op=adv_buy&do=buy&ap_id=".$v['ap_id']."' class='ncu-btn2'>".$lang['adv_buy_click_buy']."</a>";
       }
       ?></td>
        </tr>
        <?php }?>
        <?php }else{ ?>
        <tr>
          <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['sys_have_no_ap_now']; ?></span></td>
        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?></div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
