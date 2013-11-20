<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_recommend_batch_handle'];?></h3>
      <ul class="tab-base">
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="post" name="form1">
    <input type="hidden" value="<?php echo $output['goods_id'];?>" name="goods_id">
    <input type="hidden" value="ok" name="form_submit">
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td class="required"><label><?php echo $lang['goods_recommend_to'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat w830" >
              <?php if(!empty($output['recommend_list']) && is_array($output['recommend_list'])){ ?>
              <?php foreach($output['recommend_list'] as $k => $v){ ?>
              <li class="left w18pre h36">
                <input type="radio" value="<?php echo $v['recommend_id'];?>" name="recommend_id" id="recommend_id<?php echo $v['recommend_id'];?>">
                <label for="recommend_id<?php echo $v['recommend_id'];?>"><?php echo $v['recommend_name'];?></label>
              </li>
              <?php } ?>
              <?php } ?>
            </ul></td>
        </tr>
      <tfoot>
        <tr class="tfoot">
          <td ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
