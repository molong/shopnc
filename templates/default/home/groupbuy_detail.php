<link href="<?php echo TEMPLATES_PATH;?>/css/home_group.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
var tms = [];
var day = [];
var hour = [];
var minute = [];
var second = [];
function takeCount() {
    setTimeout("takeCount()", 1000);
    for (var i = 0, j = tms.length; i < j; i++) {
        tms[i] -= 1;
        //计算天、时、分、秒、
        var days = Math.floor(tms[i] / (1 * 60 * 60 * 24));
        var hours = Math.floor(tms[i] / (1 * 60 * 60)) % 24;
        var minutes = Math.floor(tms[i] / (1 * 60)) % 60;
        var seconds = Math.floor(tms[i] / 1) % 60;
        if (days < 0)
            days = 0;
        if (hours < 0)
            hours = 0;
        if (minutes < 0)
            minutes = 0;
        if (seconds < 0)
            seconds = 0;
        //将天、时、分、秒插入到html中
        document.getElementById(day[i]).innerHTML = days;
        document.getElementById(hour[i]).innerHTML = hours;
        document.getElementById(minute[i]).innerHTML = minutes;
        document.getElementById(second[i]).innerHTML = seconds;
    }
}
setTimeout("takeCount()", 1000);
</script>
<div class="mbm warp-all">
    <div class="group-nav">
        <h2><?php echo $lang['groupbuy_title'];?></h2>
        <div class="info">
            <h4><?php echo $lang['text_di'];?><em><?php echo $output['groupbuy_info']['template_name'];?></em><?php echo $lang['text_qi'].$lang['text_groupbuy'];?><?php echo $lang['nc_colon'];?></h4>
            <span class="time"><?php echo date('Y'.$lang['text_year'].'m'.$lang['text_month'].'d'.$lang['text_day'].' H:i',$output['groupbuy_info']['start_time']);?></span><span><?php echo $lang['text_to'];?></span><span class="time"><?php echo date('Y'.$lang['text_year'].'m'.$lang['text_month'].'d'.$lang['text_day'].' H:i',$output['groupbuy_info']['end_time']);?></span> </div>
        <ul>
            <li><a href="index.php?act=show_groupbuy&op=groupbuy_soon" target="_blank"><?php echo $lang['groupbuy_soon'];?></a></li>
            <li><a href="index.php?act=show_groupbuy&op=groupbuy_history" target="_blank"><?php echo $lang['groupbuy_history'];?></a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>
<div class="mbm warp-all content">
    <div class="left2">
        <div class="group">
            <h1><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$output['groupbuy_info']['goods_id']), 'goods');?>" target="_blank" title="<?php echo $output['groupbuy_info']['group_name'];?>"><?php echo $output['groupbuy_info']['group_name'];?></a></h1>
            <div class="box"><div class="<?php echo $output['groupbuy_message']['class'];?>"><span><?php echo $lang['currency'];?><?php echo $output['groupbuy_info']['groupbuy_price'];?></span><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$output['groupbuy_info']['goods_id']), 'goods');?>" target="_blank"><?php echo $lang['groupbuy_buy'];?></a></div>
                <div class="info">
                    <div class="prices">
                        <dl>
                            <dt><?php echo $lang['text_goods_price'];?></dt>
                            <dd><?php echo $output['groupbuy_info']['goods_price'];?></dd>
                        </dl>
                        <dl>
                            <dt><?php echo $lang['text_discount'];?></dt>
                            <dd><?php echo $output['groupbuy_info']['rebate'];?><?php echo $lang['text_zhe'];?></dd>
                        </dl>
                        <dl>
                            <dt><?php echo $lang['text_save'];?></dt>
                            <dd><?php echo sprintf("%01.2f",$output['groupbuy_info']['goods_price']-$output['groupbuy_info']['groupbuy_price']);?></dd>
                        </dl>
                    </div>
                    
                    <div class="time">
                    <?php if($output['groupbuy_message']['count_down']) { ?> 
                        <!-- 倒计时 距离本期结束 -->
                        <h3><?php echo $output['groupbuy_message']['count_down_text'];?></h3>
                        <p><span id="d1">0</span><strong><?php echo $lang['text_tian'];?></strong><span id="h1">0</span><strong><?php echo $lang['text_hour'];?></strong><span id="m1">0</span><strong><?php echo $lang['text_minute'];?></strong><span id="s1">0</span><strong><?php echo $lang['text_second'];?></strong></p>
                        <script type="text/javascript">
                        tms[tms.length] = "<?php echo $output['count_down'];?>";
                        day[day.length] = "d1";
                        hour[hour.length] = "h1";
                        minute[minute.length] = "m1";
                        second[second.length] = "s1";
                        </script> 
                    <?php } ?>
                    </div>
                    <div class="require">
                        <h3><?php echo $lang['text_goods_buy'];?>
                            <em>
                            <?php 
                            if(!empty($output['groupbuy_message']['hide_virtual_quantity'])) {
                                echo $output['groupbuy_info']['def_quantity'];
                            }
                            else {
                                echo $output['groupbuy_info']['virtual_quantity']+$output['groupbuy_info']['def_quantity'];
                            }
                            ?>
                            </em>
                        <?php echo $lang['text_piece'];?></h3>
                        <p><?php echo $output['groupbuy_message']['text'];?></p>
                    </div>
                </div>
                <div class="pic"><span class="thumb"><i></i><img src="<?php echo gthumb($output['groupbuy_info']['group_pic'],'max');?>" alt="" onload="javascript:DrawImage(this,480,350);"></span></div>
            </div>
            <div class="content">
                <div class="side-left">
                    <div class="intro"><h3><?php echo $lang['goods_info'];?></h3><div><?php echo $output['groupbuy_info']['group_intro'];?></div></div>
                    <div class="buyer"><h3><?php echo $lang['buyer_list'];?></h3><table width="100%" border="0" cellspacing="0" cellpadding="0"><thead><tr>
                                    <th width="25%"><?php echo $lang['text_buyer'];?></th>
                                    <th width="15%"><?php echo $lang['text_buy_count'];?></th>
                                    <th width="15%"><?php echo $lang['text_unit_price'];?></th>
                                    <th><?php echo $lang['text_buy_time'];?></th>
                            </tr></thead><tbody>
                            <?php if(is_array($output['order_list'])) { ?>
                            <?php foreach($output['order_list'] as $order) { ?>
                            <tr>
                                <td><?php echo str_cut($order['buyer_name'],'4').'***'; ?></td>
                                <td><?php echo $order['group_count'];?></td>
                                <td><?php echo $lang['currency'].sprintf("%01.2f",$order['goods_amount']/$order['group_count']);?></td>
                                <td><?php echo date('Y-m-d H:i:s',$order['add_time']);?></td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                            </tbody>
                            <tfoot><tr><td colspan="4">
                                        <span><?php echo $lang['currency'];?><?php echo $output['groupbuy_info']['groupbuy_price'];?></span>
                                       <a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$output['groupbuy_info']['goods_id']), 'goods');?>" target="_blank"><em><?php echo $lang['text_buy_now'];?></em></a>
                            </td></tr></tfoot>
                        </table>
                </div></div>
                <div class="store">
                    <!-- 店铺信息 -->
                    <h3><?php echo $lang['store_info'];?></h3>
                    <dl>
                        <dt><?php echo $lang['text_goods_store'];?></dt>
                        <dd class="store-name"><a href="<?php echo ncUrl(array('act'=>'show_store','id'=>$output['groupbuy_info']['store_id']), 'store');?>" target="_blank"><?php echo $output['groupbuy_info']['store_name'];?></a></dd>
                    </dl>
                    <!-- 店铺推荐商品 -->
                    <dl>
                        <dt><?php echo $lang['text_goods_commend'];?></dt>
                        <?php if(is_array($output['commend_goods_list'])) { ?>
                        <?php foreach($output['commend_goods_list'] as $commend_goods) { ?>
                        <dd>
                        <p class="pic">
                        <span class="thumb size120"><i></i>
                            <a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$commend_goods['goods_id']), 'goods');?>" target="_blank">
                            <img src="<?php echo thumb($commend_goods,'small')?>" onload="javascript:DrawImage(this,120,120);"></a>
                        </span>
                        </p>
                        <p class="name"><a href="<?php echo ncUrl(array('act'=>'goods','goods_id'=>$commend_goods['goods_id']), 'goods');?>" target="_blank"><?php echo $commend_goods['goods_name'];?></a></p>
                        <p class="store_price"><?php echo $lang['store_price'];?><?php echo $lang['nc_colon'];?><span><?php echo $lang['currency'].$commend_goods['goods_store_price'];?></span></p>
                        </dd>
                        <?php } ?>
                        <?php } ?>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="right2"><div class="group-hot">
            <div class="module_sidebar">
                <h2 style=" font-size: 14px; color: #C00;"><?php echo $lang['current_hot'];?></h2>
                <ul>
                    <?php $hot_groupbuy_count = 1;?>
                    <?php if(is_array($output['hot_groupbuy_list_in_progress'])) { ?>
                    <?php foreach($output['hot_groupbuy_list_in_progress'] as $hot_groupbuy) { ?>
                    <li <?php if($hot_groupbuy_count === 1) { echo "style=' border:none'";$hot_groupbuy_count++; }?> ><div class="name"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$hot_groupbuy['group_id'],'id'=>$hot_groupbuy['store_id']), 'groupbuy');?>" target="_blank"><?php echo $hot_groupbuy['group_name'];?></a></div>
                    <div class="box">
                        <div class="price"><span class="l"><?php echo $lang['currency'].$hot_groupbuy['groupbuy_price'];?></span><span class="r"><?php echo $lang['currency'].$hot_groupbuy['goods_price'];?></span></div>
                        <div class="mask"></div>
                        <div class="pic"><span class="thumb size168x123"><i></i><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$hot_groupbuy['group_id'],'id'=>$hot_groupbuy['store_id']), 'groupbuy');?>" target="_blank"><img src="<?php echo gthumb($hot_groupbuy['group_pic'],'small');?>" alt="" onload="javascript:DrawImage(this,168,123);"></a></span></div>
                    </div>
                    <div class="info"><span><?php echo $lang['text_buy'];?><em>
                            <?php 
                            if(!empty($output['groupbuy_message']['hide_virtual_quantity'])) {
                                echo $hot_groupbuy['def_quantity'];
                            }
                            else {
                                echo $hot_groupbuy['virtual_quantity']+$hot_groupbuy['def_quantity'];
                            }
                            ?>
        </em><?php echo $lang['text_piece'];?></span><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$hot_groupbuy['group_id'],'id'=>$hot_groupbuy['store_id']), 'groupbuy');?>" target="_blank"><?php echo $lang['to_see'];?></a></div>
                    </li>
                    <?php } ?>
                    <?php } ?>
                </ul>
        </div></div>
        <div class="group-top10">
            <div class="module_sidebar">
                <h2 style=" font-size: 14px; color: #C00;"><?php echo $lang['history_hot'];?></h2>
                <ol>
                    <?php if(is_array($output['hot_groupbuy_list'])) { ?>
            <?php $i=1;?>
                    <?php foreach($output['hot_groupbuy_list'] as $hot_groupbuy) { ?>
                    <li>
                    <div class="box">
                        <div class="num"><?php echo sprintf("%02d",$i);$i++;?></div>
                        <div class="pic"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$hot_groupbuy['group_id'],'id'=>$hot_groupbuy['store_id']), 'groupbuy');?>" title="<?php echo $hot_groupbuy['group_name'];?>" target="_blank"><img src="<?php echo ATTACH_GROUPBUY.'/'.$hot_groupbuy['group_pic'];?>" alt="" onload="javascript:DrawImage(this,123,90);"></a></div>
                    </div>
                    <dl>
                        <dt class="name"><a href="<?php echo ncUrl(array('act'=>'show_groupbuy','op'=>'groupbuy_detail','group_id'=>$hot_groupbuy['group_id'],'id'=>$hot_groupbuy['store_id']), 'groupbuy');?>" title="<?php echo $hot_groupbuy['group_name'];?>" target="_blank"><?php echo $hot_groupbuy['group_name'];?></a></dt>
                        <dd class="price"><?php echo $lang['currency'].$hot_groupbuy['groupbuy_price'];?></dd>
                        <dd class="info"><?php echo $lang['text_buy'];?><?php echo $hot_groupbuy['def_quantity']+$hot_groupbuy['virtual_quantity'];?><?php echo $lang['text_piece'];?></dd>
                        <dd class="time"><?php echo date('Y-m-d',$hot_groupbuy['end_time']);?></dd>
                    </dl>
                    </li>
                    <?php } ?>
                    <?php } ?>
                </ol>
        </div></div>
    </div>
</div>
<div class="clear"></div>

