<?php defined('InShopNC') or exit('Access Invalid!');?>

<?php include template('home/cur_local');?>
<div class="article_con" style="margin:0 auto 20px;width:732px">
	<div>
		<h1><?php echo $output['doc']['doc_title'];?></h1>
		<h2><?php echo date('Y-m-d H:i',$output['doc']['doc_time']);?></h2>
		<div class="default">
			<p><?php echo nl2br($output['doc']['doc_content']);?></p>
		</div>
	</div>
</div>
