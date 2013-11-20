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
    <div class="shop_text_list">
      <div class="ornament1"></div>
      <div class="ornament2"></div>
      <table>
        <tr>
          <th class="align1" colspan="2"> <div class="table_title"> </div>
            
            <!--div class="top_page pagination">
                            <?php //echo $output['show_page'];?>
                        </div--> </th>
        </tr>
        <?php if(!empty($output['article_list']) and is_array($output['article_list'])){?>
        <?php foreach ($output['article_list'] as $article) {?>
        <tr>
          <td><a <?php if($article['article_url']!=''){?>target="_blank"<?php }?> href="<?php if($article['article_url']!='')echo $article['article_url'];else echo ncUrl(array('act'=>'article','article_id'=>$article['article_id']), 'article');?>" class="lebioa"><?php echo $article['article_title'];?></a></td>
          <td class="w150"><?php echo date('Y-m-d H:i',$article['article_time']);?></td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr>
          <td align="center" colspan="2"><?php echo $lang['article_article_not_found'];?></td>
        </tr>
        <?php }?>
      </table>
    </div>
    <div class="pagination"> <?php echo $output['show_page'];?> </div>
  </div>
</div>
