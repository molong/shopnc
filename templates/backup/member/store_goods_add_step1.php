<!-- S setp -->

<ul class="flow-chart">
  <li class="step a1" title="<?php echo $lang['store_goods_index_flow_chart_step1'];?>"></li>
  <li class="step b2" title="<?php echo $lang['store_goods_index_flow_chart_step2'];?>"></li>
  <li class="step c2" title="<?php echo $lang['store_goods_index_flow_chart_step3'];?>"></li>
</ul>
<!--S 搜索商品-->
<div class="wp_search_com"><span class="icon"></span><span class="txt"><?php echo $lang['store_goods_step1_search_category'];?>
  <input value="<?php echo $lang['store_goods_step1_search_input_text'];?>" id="searchKey" maxlength="22" type="text" class="text">
  </span><a class="btn_search" href="JavaScript:void(0);" id="searchBtn"><?php echo $lang['store_goods_step1_search'];?></a></div>
<!--S 搜索结果--> 
<!--S 分类选择区域-->
<div class="wrapper_search">
  <div class="wp_search_result" style="display:none;">
    <div class="back_to_sort"><a href="JavaScript:void(0);" nc_type="return_choose_sort">&lt;&lt;<?php echo $lang['store_goods_step1_return_choose_category'];?></a></div>
    <div class="no_result" id="searchNone" style="display:none;">
      <div class="cont">
        <p><?php echo $lang['store_goods_step1_search_null'];?></p>
        <p><a href="JavaScript:void(0);" nc_type="return_choose_sort">
          <button><?php echo $lang['store_goods_step1_return_choose_category'];?></button>
          </a>
        <p> 
      </div>
    </div>
    <div class="has_result" id="searchLoad" style="display:none;">
      <div class="loading"><img src="<?php echo TEMPLATES_PATH;?>/images/loading.gif" alt="loading..." ><span class="txt_searching"><?php echo $lang['store_goods_step1_searching'];?></span></div>
    </div>
    <div class="has_result" id="searchSome" style="display:none;">
      <div id="searchEnd"></div>
      <div class="result_list" id="searchList">
        <ul>
        </ul>
      </div>
    </div>
  </div>
  <div class="wp_sort" style="position:relative;">
    <div id="dataLoading" class="wp_data_loading">
      <div class="data_loading"><?php echo $lang['store_goods_step1_loading'];?></div>
    </div>
    <div class="sort_selector">
      <div class="sort_title">
        <div class="txt"><?php echo $lang['store_goods_step1_choose_common_category'];?></div>
        <input class="select_box" id="commSelect" value="<?php echo $lang['store_goods_step1_please_select'];?>" type="text" >
      </div>
    </div>
    <div class="select_list" id="commListArea" style="cursor: pointer; height: 280; overflow: auto; display: none;">
      <ul>
        <?php if(is_array($output['staple_array']) && !empty($output['staple_array'])) {?>
        <?php foreach ($output['staple_array'] as $val) {?>
        <li nc_type="<?php echo $val['gc_id']?>|<?php echo $val['staple_id']?>|<?php echo $val['type_id']?>"><span class="title"><?php echo $val['staple_name']?></span><a href="JavaScript:void(0);" title="<?php echo $lang['nc_delete'];?>" class="del_unavailable"></a></li>
        <?php }?>
        <?php }else{?>
        <li id="select_list_no"><span class="title"><?php echo $lang['store_goods_step1_no_common_category'];?></span></li>
        <?php }?>
      </ul>
    </div>
    <div id="class_div" class="wp_sort_block">
      <div class="sort_list">
        <div class="wp_category_list">
          <div id="class_div_1" class="category_list">
            <ul>
              <?php if(isset($output['goods_class']) && !empty($output['goods_class']) ) {?>
              <?php foreach ($output['goods_class'] as $val) {?>
              <li class="" onclick="selClass(this);" id="<?php echo $val['gc_id'];?>|1|<?php echo $val['type_id'];?>"> <a class="" href="javascript:void(0)"><span class="has_leaf"><?php echo $val['gc_name'];?></span></a> </li>
              <?php }?>
              <?php }?>
            </ul>
          </div>
        </div>
      </div>
      <div class="sort_list">
        <div class="wp_category_list blank">
          <div id="class_div_2" class="category_list">
            <ul>
            </ul>
          </div>
        </div>
      </div>
      <div class="sort_list">
        <div class="wp_category_list blank">
          <div id="class_div_3" class="category_list">
            <ul>
            </ul>
          </div>
        </div>
      </div>
      <div class="sort_list sort_list_last">
        <div class="wp_category_list blank">
          <div id="class_div_4" class="category_list ">
            <ul>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="tips_choice"  style="display: block; clear:both;"><span class="tips_zt"></span>
    <dl class="hover_tips_cont">
      <dt id="commodityspan"><span style="color:#F00;"><?php echo $lang['store_goods_step1_please_choose_category'];?></span></dt>
      <dt id="commoditydt" style="display: none;" class="current_sort"><?php echo $lang['store_goods_step1_current_choose_category'];?><?php echo $lang['nc_colon'];?></dt>
      <dd id="commoditydd"></dd>
      <dd id="commoditya" style="display: none;">&nbsp;&nbsp;<a href="JavaScript:void(0);"><?php echo $lang['store_goods_step1_add_common_category'];?></a></dd>
    </dl>
  </div>
  <div class="wp_confirm"> <span class="btn_confirm">
    <form method="get">
      <input name="act" value="store_goods" type="hidden" />
      <?php if(isset($_GET['goods_id']) && intval($_GET['goods_id']) > 0){?>
      <input name="op" value="edit_goods" type="hidden" />
      <input name="goods_id" value="<?php echo $_GET['goods_id'];?>" type="hidden" />
      <?php } else {?>
      <input name="op" value="add_goods" type="hidden" />
      <input name="step" value="two" type="hidden" />
      <?php }?>
      <input name="class_id" id="class_id" value="" type="hidden" />
      <input name="t_id" id="t_id" value="" type="hidden" />
      <input disabled="disabled" id="button_next_step" value="<?php echo $lang['store_goods_step1_next'];?>" type="submit"  class="submit" />
    </form>
    </span> </div>
</div>
<script type="text/javascript">
SEARCHKEY = '<?php echo $lang['store_goods_step1_search_input_text'];?>';
</script> 
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery.goods_add_step1.js"></script>