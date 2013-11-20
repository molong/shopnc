<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <form method="get" action="index.php">
    <table class="search-form">
      <input type="hidden" name="act" value="store_ztc" />
      <input type="hidden" name="op" value="ztc_glist" />
      <tr>
        <td></td>
        <th><?php echo $lang['store_ztc_goodsname'].$lang['nc_colon']; ?></th>
        <td class="w160"><input type="text"  class="text"  name="keyword" value="<?php echo $_GET['keyword']; ?>"/></td>
        <th><?php echo $lang['store_ztc_state'].$lang['nc_colon']; ?></th>
        <td class="w80"><select name="goods_type">
            <option value="0"><?php echo $lang['nc_please_choose'];?></option>
            <option value="goods_open" <?php if($_GET['goods_type'] == 'goods_open') { ?>selected="selected"<?php } ?>><?php echo $lang['store_ztc_glist_goodsshow']; ?><!-- 上架 --></option>
            <option value="goods_close" <?php if($_GET['goods_type'] == 'goods_close') { ?>selected="selected"<?php } ?>><?php echo $lang['store_ztc_glist_goodsunshow']; ?><!-- 下架 --></option>
            <option value="goods_commend" <?php if($_GET['goods_type'] == 'goods_commend') { ?>selected="selected"<?php } ?>><?php echo $lang['store_ztc_glist_goodsrecommend']; ?><!-- 推荐 --></option>
            <option value="goods_ban" <?php if($_GET['goods_type'] == 'goods_ban') { ?>selected="selected"<?php } ?>><?php echo $lang['store_ztc_glist_goodslock']; ?><!-- 禁售 --></option>
          </select></td>
        <td class="tc w90"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <table class="ncu-table-style">
    <thead>
      <tr>
        <th></th>
        <th><?php echo $lang['store_ztc_goodsname']; ?><!-- 商品名称 --></th>
        <th><?php echo $lang['store_ztc_glist_goldresidue'];?><!-- 剩余金币(枚) --></th>
        <th><?php echo $lang['store_ztc_starttime']; ?><!-- 开始时间 --></th>
        <th><?php echo $lang['store_ztc_glist_goodsshow']; ?><!-- 上架 --></th>
        <th><?php echo $lang['store_ztc_glist_goodsrecommend']; ?><!-- 推荐 --></th>
        <th><?php echo $lang['store_ztc_glist_goodslock']; ?><!-- 禁售 --></th>
        <th><?php echo $lang['store_ztc_gstate_ztc']; ?><!-- 直通车 --></th>
      </tr>
    </thead>
    <?php if (count($output['list_goods'])>0) { ?>
    <tbody>
      <?php foreach($output['list_goods'] as $val) { ?>
      <tr nc_type="table_item" idvalue="<?php echo $val['goods_id']; ?>">
        <td><a href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"> <img src="<?php  echo cthumb($val['goods_image'],'tiny',$_SESSION['store_id']);?>" onload="javascript:DrawImage(this,50,50);" /> </a></td>
        <td><?php echo $val['goods_name']; ?></td>
        <td><?php echo $val['goods_goldnum']; ?></td>
        <td><?php echo date('Y-m-d',$val['goods_ztcstartdate']); ?></td>
        <td><?php if ($val['goods_show']) { echo $lang['nc_yes']; } else { echo $lang['nc_no']; } ?></td>
        <td><?php if ($val['goods_commend']) { echo $lang['nc_yes']; } else { echo $lang['nc_no']; } ?></td>
        <td><?php if ($val['goods_state']) { echo $lang['nc_yes']; } else { echo $lang['nc_no']; } ?></td>
        <td><span <?php if ($val['goods_ztcstate']==1) { ?>class="right_ico"<?php } else { ?>class="wrong_ico"<?php } ?> onclick="ztc_gstate(this);" gid="<?php echo $val['goods_id']; ?>"></span></td>
      </tr>
      <?php } ?>
      <?php } else {?>
      <tr>
        <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if (count($output['list_goods'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<script type="text/javascript">
	function ztc_gstate(obj){
		var gid=$(obj).attr('gid');
		var span_class=$(obj).attr('class');
		var state='open';
		if(span_class=='right_ico') state='close';
		$.ajax({
			type:'POST',
			url:'index.php',
			data:'act=store_ztc&op=ztc_gstate&type='+state+'&gid='+gid,
			error:function(){
					
			},
			success:function(html){
				span_class='wrong_ico';
				if($(obj).attr('class')=='wrong_ico') span_class='right_ico';
				if(html=='true') $(obj).attr('class',span_class);
			},
			dataType:'text'
		});
	}
</script> 
