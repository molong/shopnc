<div class="eject_con gselector">
  <div id="warning"></div>
    <dl>
      <dt><?php echo $lang['groupbuy_index_goods_name'].$lang['nc_colon'];?></dt>
      <dd>
        <input class="w300 text" type="text" id="stc_goods_name" />
      </dd>
    </dl>
    <dl>
      <dt><?php echo $lang['groupbuy_index_store_class'].$lang['nc_colon'];?></dt>
      <dd>
        <select id="stc_id" name="stc_id" class="sgcategory">
          <option value="0"><?php echo $lang['groupbuy_index_please_choose'];?></option>
          <?php echo $output['select_string'];?>
        </select>
      </dd>
    </dl>
    <dl>
      <dt>&nbsp;&nbsp;</dt>
      <dd><a id="query_goods" href="javascript:void(0)" class="ncu-btn1"><span><?php echo $lang['groupbuy_index_search'];?></span></a></dd>
    </dl>
    <dl>
      <dt><?php echo $lang['groupbuy_index_choose_goods'].$lang['nc_colon'];?></dt>
      <dd>
        <select id="stc_goods_id" name="stc_goods_id" size="7" style=" height:140px;" class="w300">
          <option value="0"><?php echo $lang['groupbuy_index_search_back'];?></option>
        </select>
      </dd>
    </dl>
    <dl class="bottom">
      <dt>&nbsp;</dt>
      <dd>
        <input type="submit" class="submit" id="stc_submit" value="<?php echo $lang['groupbuy_index_submit'];?>" />
      </dd>
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
        $('#stc_goods_id').html('<option><?php echo $lang['groupbuy_index_loading_list'];?>...</option>');
        $.getJSON('index.php?act=store_groupbuy&op=getSelectGoodsList',{
            'stc_goods_name':$('#stc_goods_name').val(),
            'stc_id':$('#stc_id').val(),
            'column':'ok'
            },
            function(data){
                if(data.done){
                    if(data.retval.length != 0){
                        $('#stc_goods_id').html('');
						$.each(data.retval,function(i,item){
							$('#stc_goods_id').append('<option value="' + item.goods_id + '">' + item.goods_name + '</option>');
						});
					}else{
						$('#stc_goods_id').html('<option><?php echo $lang['groupbuy_index_no_goods'];?></option>');
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
    var id = 'input_goods_id';
    var name = 'input_goods_name';
    var callback = 'gs_callback';
    if(id.length == 0){
        msg('id_mission');
    }
    if($('#stc_goods_id').val()>0){
        $('#'+id).val($('#stc_goods_id').val());
        if(name.length>0){
            $('#'+name).val($('#stc_goods_id option:selected').text());
        }if(callback.length>0){
            eval(callback+'()');
        }
        DialogManager.close(id);
    }else{
        msg('<?php echo $lang['groupbuy_index_choose_goods'];?>');
    }
}
//]]>
</script> 
