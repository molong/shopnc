<div class="keyword">
<h4><?php echo $lang['cur_location'].$lang['nc_colon'];?></h4>
	<?php if(!empty($output['nav_link_list']) && is_array($output['nav_link_list'])){?>
	<?php foreach($output['nav_link_list'] as $nav_link){?>
	<?php if(!empty($nav_link['link'])){?>
    <a href="<?php echo $nav_link['link'];?>"><?php echo $nav_link['title'];?></a><span>&nbsp;</span>
	<?php }else{?>
    <?php echo $nav_link['title'];?>
	<?php }?>
	<?php }?>
	<?php }?>
</div>