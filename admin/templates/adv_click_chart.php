<div class="page">
<div class="fixed-bar">
  <div class="item-title">
    <h3><?php echo $lang['adv_index_manage'];?></h3>
    <ul class="tab-base">
      <li><a href="index.php?act=adv&op=adv" ><span><?php echo $lang['adv_manage'];?></span></a></li>
      <li><a href="index.php?act=adv&op=adv_check" ><span><?php echo $lang['adv_wait_check']; ?></span></a></li>
      <li><a href="index.php?act=adv&op=adv_add" ><span><?php echo $lang['adv_add'];?></span></a></li>
      <li><a href="index.php?act=adv&op=ap_manage" ><span><?php echo $lang['ap_manage'];?></span></a></li>
      <li><a href="index.php?act=adv&op=ap_add" ><span><?php echo $lang['ap_add'];?></span></a></li>
      <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['check_adv_chart']; ?></span></a></li>
    </ul>
  </div>
</div>
<div class="fixed-empty"></div>
<form method="post" action="index.php?act=adv&op=click_chart" name="formSearch">
<input type="hidden" name="formsubmit" value="ok" />
<table class="tb-type1 noborder search">
  <tr>
    <td>
      <?php echo "“".$output['adv_title']."”".$output['year']?><?php echo $lang['adv_chart_years_chart']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $lang['adv_chart_searchyear_input']; ?></td>
    <td><input class="queryInput" type="text" name="year" /></td>
    <td><?php echo $lang['adv_chart_year']; ?></td>
    <td><input type="hidden" name="adv_id" value="<?php echo $output['adv_id']; ?>" />
      <?php echo $lang['adv_search_to']; ?>&nbsp;
      <input class="txt date" type="text" id="add_time_to" name="add_time_to" value="<?php echo $_GET['add_time_to'];?>"/></td>
    <td><a href="javascript:document.formSearch.submit();" class="btn-search tooltip" title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
  </tr>
</table>
<div class="tdare">
  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="550" height="450" id="adv">
    <param name="movie" value="<?php echo SiteUrl; ?>/resource/clickswf/adv.swf" />
    <param name="quality" value="high" />
    <param name="bgcolor" value="#ffffff" />
    <param name="allowScriptAccess" value="sameDomain" />
    <param name="allowFullScreen" value="true" />
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="<?php echo SiteUrl; ?>/resource/clickswf/adv.swf" width="550" height="450">
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
</div>
