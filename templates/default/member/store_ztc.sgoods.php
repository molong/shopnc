<div class="eject_con gselector">
  <div id="warning"></div>
  
    <dl>
      <dt><?php echo $lang['store_ztc_goodsname'].$lang['nc_colon']; ?><!-- 商品名称 --></dt>
      <dd>
        <p>
          <input class="w300 text" type="text" id="stc_goods_name"/>
        </p>
        <p class="hint"><?php echo $lang['store_ztc_add_goods_searchtip'];?><!-- 提示：搜索只显示最新的50条数据<br>如果结果中没有您需要的信息<br>请输入商品详细名称进行搜索 --></p>
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_ztc_add_storegoodsclass'].$lang['nc_colon']; ?><!-- 本店分类 --></dt>
      <dd>
        <select id="stc_id" name="stc_id" class="sgcategory">
          <option value="0"><?php echo $lang['nc_please_choose'];?></option>
          <?php echo $output['select_string'];?>
        </select>
      </dd>
    </dl>
    <dl>
      <dt>&nbsp;</dt>
      <dd><a class="ncu-btn1" id="query_goods" href="javascript:void(0)"><span><?php echo $lang['nc_query'];?></span></a></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['store_ztc_add_choose_goods'].$lang['nc_colon']; ?><!-- 选择商品 --></dt>
      <dd>
        <select id="stc_goods_id" name="stc_goods_id" size="7" style=" height:140px;" class="w300">
          <option value="0"><?php echo $lang['store_ztc_add_search_up'];?></option>
        </select>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd><input type="submit"  class="submit" id="stc_submit" value="<?php echo $lang['nc_submit'];?>" /></dd>
    </dl>
  
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#stc_goods_name").focus();
    });
</script> 
<script type="text/javascript">
//<!CDATA[
$(function(){
    $('#query_goods').click(function(){
        $('#stc_goods_id').html('<option><?php echo $lang['store_ztc_add_loading_goodslist'];?>...</option>');
        $.getJSON('index.php?act=store_ztc&op=getselectgoodslist',{
            'stc_goods_name':$('#stc_goods_name').val(),
            'stc_id':$('#stc_id').val(),
            'column':'ok',
            't':<?php echo $output['ztc_type'];?>
            },
            function(data){
                if(data.done){
                    if(data.length != 0){
                        $('#stc_goods_id').html('');
						$.each(data.retval,function(i,item){
							$('#stc_goods_id').append('<option value="' + item.goods_id + '">' + item.goods_name + '</option>');
						});
					}else{
						$('#stc_goods_id').html('<option><?php echo $lang['store_ztc_add_no_goods'];?></option>');
					}
				}
            });
    });
    $('#stc_goods_id').dblclick(select);
    $('#stc_submit').click(select);
});

function msg(msg){
    $('#warning').show();
    $('#warning').text(msg);
    window.setTimeout(function(){
        $('#warning').hide();
    },4000)
}
function select(){
    var id_div = 'gselect_div';
    var id = 'goods_id';
    var name = 'ztc_gname';
    if(id.length == 0){
        msg('id_mission');
    }
    if($('#stc_goods_id').val()>0){
        $('#'+id).val($('#stc_goods_id').val());
        if(name.length>0){
            $('#'+name).val($('#stc_goods_id option:selected').text());
        }
        DialogManager.close(id_div);
    }else{
        msg('<?php echo $lang['store_ztc_add_choose_goods'];?>');
    }
}
//]]>
</script> 
