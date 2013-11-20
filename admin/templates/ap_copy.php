<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
h3 { margin-top:0;
}
</style>


<dl>
  <dt style="padding:10px 30px;">
    <input type="text" style=" width:400px;" value='<script type="text/javascript" src="<?php echo "<?php echo SiteUrl;?>/index.php?act=adv&op=advshow&ap_id=".$_GET['id'];?>"></script>' />
  </dt>
  <dd style="border-top: dotted 1px #E7E7E7; padding:10px 30px; color: #F60;"><?php echo $lang['adv_index_copy_to_clip'];?></dd>
</dl>
