<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('home/cur_local');?>

<div class="content">
  <div class="left">
    <div class="module_sidebar">
      <h2><b><?php echo $lang['article_article_article_class'];?></b></h2>
      <div class="wrap">
        <div class="classify_list">
          <ul>
            <?php foreach ($output['sub_class_list'] as $k=>$v){?>
            <li><a href="<?php echo ncUrl(array('act'=>'article','ac_id'=>$v['ac_id']));?>"><?php echo $v['ac_name']?></a></li>
            <?php }?>
          </ul>
        </div>
      </div>
      <h2><b><?php echo $lang['article_article_new_article'];?></b></h2>
      <div class="wrap">
        <div class="side_textlist">
          <ul>
            <?php if(is_array($output['new_article_list']) and !empty($output['new_article_list'])){?>
            <?php foreach ($output['new_article_list'] as $k=>$v){?>
            <li><a <?php if($v['article_url']!=''){?>target="_blank"<?php }?> href="<?php if($v['article_url']!='')echo $v['article_url'];else echo ncUrl(array('act'=>'article','article_id'=>$v['article_id']), 'article');?>"><?php echo $v['article_title']?></a></li>
            <?php }?>
            <?php }else{?>
            <li><?php echo $lang['article_article_no_new_article'];?></li>
            <?php }?>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="right">
    <div class="article_wrap">
      <div class="article_con">
        <h1><?php echo $output['article']['article_title'];?></h1>
        <h2><?php echo date('Y-m-d H:i',$output['article']['article_time']);?></h2>
        <div class="default">
          <p><?php echo $output['article']['article_content'];?></p>
        </div>
        <div class="more_article">
          <h3><?php echo $lang['article_show_previous'];?>:
            <?php if(!empty($output['pre_article']) and is_array($output['pre_article'])){?>
            <a <?php if($output['pre_article']['article_url']!=''){?>target="_blank"<?php }?> href="<?php if($output['pre_article']['article_url']!='')echo $output['pre_article']['article_url'];else echo ncUrl(array('act'=>'article','article_id'=>$output['pre_article']['article_id']), 'article');?>"><?php echo $output['pre_article']['article_title'];?></a> <span><?php echo date('Y-m-d H:i',$output['pre_article']['article_time']);?></span>
            <?php }else{?>
            <?php echo $lang['article_article_not_found'];?>
            <?php }?>
          </h3>
          <h3><?php echo $lang['article_show_next'];?>:
            <?php if(!empty($output['next_article']) and is_array($output['next_article'])){?>
            <a <?php if($output['next_article']['article_url']!=''){?>target="_blank"<?php }?> href="<?php if($output['next_article']['article_url']!='')echo $output['next_article']['article_url'];else echo ncUrl(array('act'=>'article','article_id'=>$output['next_article']['article_id']), 'article');?>"><?php echo $output['next_article']['article_title'];?></a> <span><?php echo date('Y-m-d H:i',$output['next_article']['article_time']);?></span>
            <?php }else{?>
            <?php echo $lang['article_article_not_found'];?>
            <?php }?>
          </h3>
        </div>
      </div>
    </div>
  </div>
</div>
