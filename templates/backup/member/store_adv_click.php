<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
  </div>
  <div class="select_div">
    <form method="post" id="store_form" action="index.php?act=store_adv&op=adv_click_chart">
      <table class="search-form">
        <input type="hidden" name="formsubmit" value="ok" />
        <input type="hidden" name="adv_id" value="<?php echo $output['adv_id']; ?>" />
        <tr>
          <td></td>
          <th style="width:150px;"><?php echo $lang['adv_click_chart_searchyear_left']; ?></th>
          <td class="w80"><input type="text" class="text" name="year" style=" width:50px; margin-right:5px;">
            <?php echo $lang['adv_click_chart_searchyear_right']; ?></td>
          <td class="w90 tc"><input type="submit" value="<?php echo $lang['adv_search']; ?>" /></td>
        </tr>
      </table>
    </form>
  </div>
  <div class="ncu-table-style">
    <h3>“<?php echo $output['adv_title']; ?>”<?php echo $output['year']; ?><?php echo $lang['year_adv_click_chart']; ?></h3>
    <dl>
      <dd>
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="550" height="450" id="adv">
          <param name="movie" value="resource/clickswf/adv.swf" />
          <param name="quality" value="high" />
          <param name="bgcolor" value="#ffffff" />
          <param name="allowScriptAccess" value="sameDomain" />
          <param name="allowFullScreen" value="true" />
          <!--[if !IE]>-->
          <object type="application/x-shockwave-flash" data="resource/clickswf/adv.swf" width="550" height="450">
            <param name="quality" value="high" />
            <param name="bgcolor" value="#ffffff" />
            <param name="allowScriptAccess" value="sameDomain" />
            <param name="allowFullScreen" value="true" />
            <!--<![endif]--> 
            <!--[if gte IE 6]>-->
            <p> Either scripts and active content are not permitted to run or Adobe Flash Player version
              10.0.0 or greater is not installed. </p>
            <!--<![endif]--> 
            <a href="http://www.adobe.com/go/getflashplayer"> <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash Player" /> </a> 
            <!--[if !IE]>-->
          </object>
          <!--<![endif]-->
        </object>
      </dd>
    </dl>
  </div>
</div>
