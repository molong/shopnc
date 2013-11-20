<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    <div class="text-intro"> <?php echo $lang['store_activity_theme'].$lang['nc_colon'];//'活动主题';?> <?php echo $output['activity_info']['activity_title'];?></div>
  </div>
  <form method="GET">
    <input type="hidden" name="act" value="store"/>
    <input type="hidden" name="op" value="activity_apply"/>
    <input type="hidden" value="<?php echo intval($_GET['activity_id']);?>" name="activity_id"/>
    <table class="ncu-table-style" >
      <thead>
        <tr>
          <th class="w70"></th>
          <th class="w300 tl"><?php echo $lang['store_activity_goods_name'];?></th>
          <th><?php echo $lang['store_activity_goods_brand'];?></th>
          <th class="w150"><?php echo $lang['store_activity_confirmstatus']; //审核状态?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['list']) and is_array($output['list'])){?>
        <?php foreach ($output['list'] as $k=>$v){ ?>
        <tr class="bd-line">
          <td><div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=goods&goods_id=<?php echo $v['goods_id']; ?>" target="_blank"><img src="<?php echo cthumb($v['goods_image'],'tiny',$_SESSION['store_id']);?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div></td>
          <td class="tl"><dl class="goods-name">
              <dt><a target="_blank" href="index.php?act=goods&goods_id=<?php echo $v['goods_id'];?>"><?php echo $v['goods_name'];?></a></dt>
              <dd><?php echo $v['gc_name'];?></dd>
            </dl></td>
          <td><?php echo $v['brand_name'];?></td>
          <td><?php if($v['activity_detail_state']=='1'){
          			echo $lang['store_activity_pass'];
          		  }elseif(in_array($v['activity_detail_state'],array('0','3'))){
          		  	echo $lang['store_activity_audit'];
          		  }
          	?></td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr>
          <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></td>
        </tr>
        <?php }?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <div class="activity_box">
    <h3><?php echo $lang['store_activity_choosegoods']; //选择商品?></h3>
    <?php if(!empty($output['goods_list']) and is_array($output['goods_list'])){?>
    <table class="search-form">
      <form method="GET">
        <input type="hidden" name="act" value="store"/>
        <input type="hidden" name="op" value="activity_apply"/>
        <input type="hidden" name="activity_id" value="<?php echo $_GET['activity_id'];?>"/>
        <tr>
          <td>&nbsp;</td>
          <th class="w60"><?php echo $lang['store_activity_class'].$lang['nc_colon'];?></th>
          <td class="w110"><select class="w100" name="gc_id"/>
            
            <option value="">-<?php echo $lang['store_activity_choose'];?>-</option>
            <?php foreach($output['gc_list'] as $gc){?>
            <option value="<?php echo $gc['gc_id'];?>" <?php if($gc['gc_id']==$output['search']['gc_id']){?>selected<?php }?>><?php echo $gc['gc_name'];?></option>
            <?php }?>
            </select></td>
          <th class="w60"><?php echo $lang['store_activity_brand'].$lang['nc_colon'];?></th>
          <td class="w110"><select class="w100" name="brand_id"/>
            
            <option value="">-<?php echo $lang['store_activity_choose'];?>-</option>
            <?php foreach($output['brand_list'] as $brand){?>
            <option value="<?php echo $brand['brand_id'];?>" <?php if($brand['brand_id']==$output['search']['brand_id']){?>selected<?php }?>><?php echo $brand['brand_name'];?></option>
            <?php }?>
            </select></td>
          <th class="w60"><?php echo $lang['store_activity_name'].$lang['nc_colon'];?></th>
          <td class="w160"><input type="text" class="text" name="name" value="<?php echo $output['search']['name'];?>"/></td>
          <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['store_activity_search'];?>"/></td>
        </tr>
      </form>
    </table>
    <?php }?>
    <form method="POST" id="apply_form" onsubmit="ajaxpost('apply_form','','','onerror');" action="index.php?act=store&op=activity_apply_save">
      <input type="hidden" name="activity_id" value="<?php echo $_GET['activity_id'];?>"/>
      <table class="ncu-table-style">
        <tbody>
          <?php if(!empty($output['goods_list']) and is_array($output['goods_list'])){?>
          <tr>
            <td colspan="20"><ul class="list">
                <?php foreach ($output['goods_list'] as $goods){?>
                <li>
                  <div class="goods-pic-small"><span class="thumb size60"><i></i><a href="index.php?act=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><img alt="<?php echo $goods['goods_name'];?>" title="<?php echo $goods['goods_name'];?>" src="<?php echo cthumb($goods['goods_image'],'tiny',$_SESSION['store_id']);?>" onload="javascript:DrawImage(this,60,60);" /></a></span></div>
                  <h4>
                    <input type="checkbox" value="<?php echo $goods['goods_id'];?>" name="item_id[]" class="checkitem"/>
                    <label><a href="index.php?act=goods&goods_id=<?php echo $goods['goods_id'];?>" target="_blank"><?php echo $goods['goods_name'];?></a></label>
                  </h4>
                </li>
                <?php }?>
                <div class="clear"></div>
              </ul></td>
          </tr>
          <?php }else{?>
          <tr>
            <td colspan="20" class="norecord"><i>&nbsp;</i><span><?php echo $lang['no_record'];//您尚未发布任何商品?></span></td>
          </tr>
          <?php }?>
        </tbody>
        <tfoot>
          <?php if(!empty($output['goods_list']) and is_array($output['goods_list'])){?>
          <tr>
            <td class="tc"><input type="checkbox" class="checkall" id="all2"></td>
            <td><label for="all2"><?php echo $lang['nc_select_all'];?></label>
              <div class="pagination"><?php echo $output['show_page'];?> </div></td>
          </tr>
          <?php }?>
        </tfoot>
      </table>
      <?php if(!empty($output['goods_list']) and is_array($output['goods_list'])){?>
      <div class="ncu-form-style tc mb30">
        <input type="submit" class="submit" value="<?php echo $lang['store_activity_join_now'];?>"/>
      </div>
      <?php }?>
    </form>
  </div>
</div>
