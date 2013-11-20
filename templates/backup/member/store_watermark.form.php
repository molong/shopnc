<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu'); ?>
  </div>
  <div class="ncu-form-style">
    <form method="post" enctype="multipart/form-data" action="index.php?act=store_album&op=store_watermark" id="wm_form">
      <div class="setup">
        <dl>
          <dt><?php echo $lang['store_watermark_pic'];?></dt>
          <dd>
            <?php if(!empty($output['store_wm_info']['wm_image_name'])){?>
            <p class="picture"><span class="thumb"><i></i> <img src="<?php echo SiteUrl.DS.ATTACH_WATERMARK.DS.$output['store_wm_info']['wm_image_name'];?>"  onload="javascript:DrawImage(this,100,100);" id="imgView"/></span><a href="javascript:void(0);" id="del_image" title="<?php echo $lang['store_watermark_del_pic'];?>"><?php echo $lang['store_watermark_del'];?></a></p>
            
            <!--<script type="text/javascript">
	$(function(){
	$("span.preview").preview();	  
	});
</script>-->
            
            <input type="hidden" id="is_del_image" name="is_del_image" value=""/>
            <p>
              <input type="file" maxlength="0" hidefocus="true" nc_type="logo" name="image" id="image"/>
            </p>
            <p class="hint"><?php echo $lang['store_watermark_choose_pic'];?></p>
            <?php }else{?>
            <p class="picture"  style="display:none;"><span class="thumb"><i></i><img id="imgView" src="" onload="javascript:DrawImage(this,100,100);"/></span></p>
            <p>
              <input type="file" maxlength="0" hidefocus="true" nc_type="logo" name="image" id="image"/>
            </p>
            <p class="hint"><?php echo $lang['store_watermark_choose_pic'];?></p>
            <?php }?>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_watermark_pic_quality'];?></dt>
          <dd>
            <p>
              <input type="text" name="image_quality" class="text" style="width:25px" value="<?php echo $output['store_wm_info']['jpeg_quality'] ? $output['store_wm_info']['jpeg_quality'] : 90 ;?>"/>
              % </p>
            <p class="hint">0 - 100</p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_watermark_pic_pos'];?></dt>
          <dd>
            <ul class="wm_pos" id="wm_image_pos">
              <h3 class="field_notice"><?php echo $lang['store_watermark_choose_pos'];?></h3>
              <li>
                <input type="radio" name="image_pos" value="1"<?php if($output['store_wm_info']['wm_image_pos'] == 1){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_pic_pos1'];?></label>
              </li>
              <li>
                <input type="radio" name="image_pos" value="2"<?php if($output['store_wm_info']['wm_image_pos'] == 2){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_pic_pos2'];?></label>
              </li>
              <li>
                <input type="radio" name="image_pos" value="3"<?php if($output['store_wm_info']['wm_image_pos'] == 3){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_pic_pos3'];?></label>
              </li>
              <li>
                <input type="radio" name="image_pos" value="4"<?php if($output['store_wm_info']['wm_image_pos'] == 4){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_pic_pos4'];?></label>
              </li>
              <li>
                <input type="radio" name="image_pos" value="5"<?php if($output['store_wm_info']['wm_image_pos'] == 5){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_pic_pos5'];?></label>
              </li>
              <li>
                <input type="radio" name="image_pos" value="6"<?php if($output['store_wm_info']['wm_image_pos'] == 6){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_pic_pos6'];?></label>
              </li>
              <li>
                <input type="radio" name="image_pos" value="7"<?php if($output['store_wm_info']['wm_image_pos'] == 7){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_pic_pos7'];?></label>
              </li>
              <li>
                <input type="radio" name="image_pos" value="8"<?php if($output['store_wm_info']['wm_image_pos'] == 8){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_pic_pos8'];?></label>
              </li>
              <li>
                <input type="radio" name="image_pos" value="9"<?php if($output['store_wm_info']['wm_image_pos'] == 9){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_pic_pos9'];?></label>
              </li>
            </ul>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_watermark_transition'];?></dt>
          <dd>
            <p>
              <input type="text" class="text"  name="image_transition" value="<?php echo $output['store_wm_info']['wm_image_transition'];?>"/>
            </p>
            <p class="hint"><?php echo $lang['store_watermark_transition_notice'];?></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_watermark_text'];?></dt>
          <dd>
            <p>
              <textarea name="wm_text" rows="3" ><?php echo $output['store_wm_info']['wm_text'];?></textarea>
            </p>
            <p class="hint"><?php echo $lang['store_watermark_text_notice'];?></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_watermark_text_size'];?></dt>
          <dd>
            <p>
              <input id="wm_text_size" class="text"  type="text" name="wm_text_size" value="<?php echo $output['store_wm_info']['wm_text_size'];?>"/>
              px </p>
            <p class="hint"><?php echo $lang['store_watermark_text_size_notice'];?></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_watermark_text_angle'];?></dt>
          <dd>
            <p>
              <select name="wm_text_angle" class="" style="width:50px;">
                <option value="1"<?php if($output['store_wm_info']['wm_text_angle'] == 1){echo ' selected="selected"';}?>>1</option>
                <option value="2"<?php if($output['store_wm_info']['wm_text_angle'] == 2){echo ' selected="selected"';}?>>2</option>
                <option value="3"<?php if($output['store_wm_info']['wm_text_angle'] == 3){echo ' selected="selected"';}?>>3</option>
                <option value="4"<?php if($output['store_wm_info']['wm_text_angle'] == 4){echo ' selected="selected"';}?>>4</option>
                <option value="5"<?php if($output['store_wm_info']['wm_text_angle'] == 5){echo ' selected="selected"';}?>>5</option>
                <option value="6"<?php if($output['store_wm_info']['wm_text_angle'] == 6){echo ' selected="selected"';}?>>6</option>
                <option value="7"<?php if($output['store_wm_info']['wm_text_angle'] == 7){echo ' selected="selected"';}?>>7</option>
                <option value="8"<?php if($output['store_wm_info']['wm_text_angle'] == 8){echo ' selected="selected"';}?>>8</option>
                <option value="9"<?php if($output['store_wm_info']['wm_text_angle'] == 9){echo ' selected="selected"';}?>>9</option>
                <option value="10"<?php if($output['store_wm_info']['wm_text_angle'] == 10){echo ' selected="selected"';}?>>10</option>
              </select>
            </p>
            <p class="hint"><?php echo $lang['store_watermark_text_angle_notice'];?></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_watermark_text_pos'];?></dt>
          <dd>
            <ul class="wm_pos" id="wm_text_pos">
              <h3 class="field_notice"><?php echo $lang['store_watermark_text_pos_notice'];?></h3>
              <li>
                <input type="radio" name="wm_text_pos" value="1"<?php if($output['store_wm_info']['wm_text_pos'] == 1){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_text_pos1'];?></label>
              </li>
              <li>
                <input type="radio" name="wm_text_pos" value="2"<?php if($output['store_wm_info']['wm_text_pos'] == 2){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_text_pos2'];?></label>
              </li>
              <li>
                <input type="radio" name="wm_text_pos" value="3"<?php if($output['store_wm_info']['wm_text_pos'] == 3){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_text_pos3'];?></label>
              </li>
              <li>
                <input type="radio" name="wm_text_pos" value="4"<?php if($output['store_wm_info']['wm_text_pos'] == 4){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_text_pos4'];?></label>
              </li>
              <li>
                <input type="radio" name="wm_text_pos" value="5"<?php if($output['store_wm_info']['wm_text_pos'] == 5){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_text_pos5'];?></label>
              </li>
              <li>
                <input type="radio" name="wm_text_pos" value="6"<?php if($output['store_wm_info']['wm_text_pos'] == 6){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_text_pos6'];?></label>
              </li>
              <li>
                <input type="radio" name="wm_text_pos" value="7"<?php if($output['store_wm_info']['wm_text_pos'] == 7){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_text_pos7'];?></label>
              </li>
              <li>
                <input type="radio" name="wm_text_pos" value="8"<?php if($output['store_wm_info']['wm_text_pos'] == 8){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_text_pos8'];?></label>
              </li>
              <li>
                <input type="radio" name="wm_text_pos" value="9"<?php if($output['store_wm_info']['wm_text_pos'] == 9){echo ' checked';}?>/>
                <label><?php echo $lang['store_watermark_text_pos9'];?> </label>
              </li>
            </ul>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_watermark_text_font'];?></dt>
          <dd>
            <p>
              <select name="wm_text_font" class="">
                <?php foreach($output['file_list'] as $key=>$value){?>
                <option value="<?php echo $key;?>"<?php if($output['store_wm_info']['wm_text_font'] == $key){echo ' selected="selected"';}?>><?php echo $value;?></option>
                <?php }?>
              </select>
            </p>
            <p class="hint"><?php echo $lang['store_watermark_text_font_notice'];?></p>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['store_watermark_text_color'];?></dt>
          <dd>
            <p>
              <input id="wm_text_color"  class="text"  type="text"  name="wm_text_color" value="<?php echo $output['store_wm_info']['wm_text_color']?$output['store_wm_info']['wm_text_color']:"#CCCCCC"; ?>"/>
            </p>
            <p class="hint"><?php echo $lang['store_watermark_text_color_notice'];?></p>
            <div id="colorpanel" style="display:none;width:253px;height:177px;"></div>
          </dd>
        </dl>
        <dl class="bottom">
          <dt>&nbsp;</dt>
          <dd>
            <input type="hidden" name="form_submit" value="ok" />
            <input type="submit" class="submit" value="<?php echo $lang['store_watermark_submit'];?>" />
          </dd>
        </dl>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
var SITE_URL = "<?php echo SiteUrl; ?>";
$(function(){
	$('#del_image').click(function (){
		var result = confirm('<?php echo $lang['store_watermark_del_pic_confirm'];?>');
		if (result)
		{
			$('#image').css('display','none');
			$('#del_image').css('display','none');
			$('#is_del_image').val('ok');
			$('#wm_form').submit();
		}
	});
	$('#wm_form').validate({
    	submitHandler:function(form){
    		ajaxpost('wm_form', '', '', 'onerror') 
    	},
        rules : {
            image_quality : {
                required   : true,
				number : true,
				min : 0,
				max : 100
            },
            image_transition : {
                required   : true,
				number : true,
				min : 0,
				max : 100
            },
			wm_text_size : {
				required : true,
				number : true
			},
			wm_text_color : {
				required : true,
				maxlength : 7
			}
        },
        messages : {
            image_quality : {
                required   : '<?php echo $lang['store_watermark_pic_quality_null'];?>',
				number : '<?php echo $lang['store_watermark_pic_quality_number'];?>',
				min : '<?php echo $lang['store_watermark_pic_quality_min'];?>',
				max : '<?php echo $lang['store_watermark_pic_quality_max'];?>'
            },
            image_transition : {
                required   : '<?php echo $lang['store_watermark_transition_null'];?>',
				number : '<?php echo $lang['store_watermark_transition_number'];?>',
				min : '<?php echo $lang['store_watermark_transition_min'];?>',
				max : '<?php echo $lang['store_watermark_transition_max'];?>'
            },
			wm_text_size : {
				required : '<?php echo $lang['store_watermark_text_size_null'];?>',
				number : '<?php echo $lang['store_watermark_text_size_number'];?>'
			},
			wm_text_color : {
				required : '<?php echo $lang['store_watermark_text_color_null'];?>',
				maxlength : '<?php echo $lang['store_watermark_text_color_max'];?>'
			}
        }
    });
});

$(document).ready( function () { 
     $("div").cssRadio(); 
     $("div").cssCheckBox(); 
}); 
jQuery.fn.cssRadio = function () { 
    $(":input[type=radio] + label").each( function(){ 
            if ( $(this).prev()[0].checked ) 
                $(this).addClass("checked"); 
            }) 
        .hover( 
            function() { $(this).addClass("over"); }, 
            function() { $(this).removeClass("over"); } 
            ) 
        .click( function() { 
             var contents = $(this).parent().parent(); /*多组控制 关键*/ 
            $(":input[type=radio] + label", contents).each( function() { 
                $(this).prev()[0].checked=false; 
                $(this).removeClass("checked");    
            }); 
            $(this).prev()[0].checked=true; 
             $(this).addClass("checked"); 
            }).prev().hide(); 
}; 

jQuery.fn.cssCheckBox = function () { 
    $(":input[type=checkbox] + label").each( function(){ 
            if ( $(this).prev()[0].checked ) 
                {$(this).addClass("checked");}            
            }) 
        .hover( 
            function() { $(this).addClass("over"); }, 
            function() { $(this).removeClass("over"); } 
            ) 
        .toggle( function()  /*不能click，不然checked无法回到unchecked*/ 
            {                
                $(this).prev()[0].checked=true; 
                 $(this).addClass("checked"); 
            }, 
            function() 
            { 
                $(this).prev()[0].checked=false; 
                 $(this).removeClass("checked"); 
            }).prev().hide();           
} 

$(document).ready(function() {
    ShowColorControl("wm_text_color");
});

function ShowColorControl(controlId)
{
    $("#" + controlId).bind("click", OnDocumentClick);
}
var ColorHex = new Array('00', '33', '66', '99', 'CC', 'FF')
var SpColorHex = new Array('FF0000', '00FF00', '0000FF', 'FFFF00', '00FFFF', 'FF00FF')
var current = null
function initPanel() {
    var colorTable = ''
    for (i = 0; i < 2; i++) {
        for (j = 0; j < 6; j++) {
            colorTable = colorTable + '<tr style="height:12px;">'
            colorTable = colorTable + '<td  style="width=11px;height:12px;background-color:#000000">'

            if (i == 0) {
                colorTable = colorTable + '<td style="width=11px;height:12px;background-color:#' + ColorHex[j] + ColorHex[j] + ColorHex[j] + '">'
            }
            else {
                colorTable = colorTable + '<td style="width=11px;height:12px;background-color:#' + SpColorHex[j] + '">'
            }


            colorTable = colorTable + '<td style="width=11px;height:12px;background-color:#000000">'
            for (k = 0; k < 3; k++) {
                for (l = 0; l < 6; l++) {
                    colorTable = colorTable + '<td style="width=11px;height:12px;background-color:#' + ColorHex[k + i * 3] + ColorHex[l] + ColorHex[j] + '">'
                }
            }
        }
    }
    colorTable = '<table width=253 border="0" cellspacing="0" cellpadding="0" style="border:1px #000000 solid;border-bottom:none;border-collapse: collapse" bordercolor="000000">'
           + '<tr height="30px"><td colspan=21 bgcolor=#cccccc>'
           + '<table cellpadding="0" cellspacing="1" border="0" style="border-collapse: collapse">'
           + '<tr><td width="3"><td><input type="text" id="DisColor" size="6" disabled style="border:solid 1px #000000;background-color:#ffff00"></td>'
           + '<td width="3"><td><input type="text" id="HexColor" size="7" style="border:inset 1px;font-family:Arial;" value="#000000"></td><td align="right" width="100%"><span id="spnClose" style="cursor:hand;">X</span>&nbsp;</td></tr></table></td></table>'
           + '<table  width=253  id="tblColor" border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="000000"  style="cursor:hand;">'
           + colorTable + '</table>';
    $("#colorpanel").html(colorTable);
    $("#tblColor").bind("mouseover", doOver);
    $("#tblColor").bind("mouseout", doOut);
    $("#tblColor").bind("click", doclick);
    $("#spnClose").bind("click", function() { $("#colorpanel").css("display","none"); });
}
//鼠标覆盖事件
function doOver(event) {

    var e = $.event.fix(event);
    var element = e.target;
    if ((element.tagName == "TD") && (current != element)) {

        if (current != null) { current.style.backgroundColor = current.style.background; }
        element.style.background = element.style.backgroundColor;
        $("#DisColor").css("backgroundColor", element.style.backgroundColor);
        var clr = element.style.backgroundColor.toUpperCase();
        if (clr.indexOf('RGB') > -1) {
            clr = clr.substring(clr.length - 18);
            clr = rgb2hex(clr);
        }
        $("#HexColor").val(clr);
        //element.style.backgroundColor = "white";
        current = element;
    }
}
//鼠标移开事件
function doOut(event) {
    if (current != null) current.style.backgroundColor = current.style.background.toUpperCase();
}
//鼠标点击事件
function doclick(event) {
    var e = $.event.fix(event);
    if (e.target.tagName == "TD") {
        var clr = e.target.style.background;
        clr = clr.toUpperCase();
        if (targetElement) {
            if (clr.indexOf('RGB') > -1) {
                clr = clr.substring(clr.length - 18);
                clr = rgb2hex(clr);
            }
            targetElement.value = clr; 
        }
        DisplayClrDlg(false, e);
        return clr;
    }
}

var targetElement = null;

function OnDocumentClick(event) {

    var e = $.event.fix(event);
    var srcElement = e.target;
//    if (srcElement.alt == "clrDlg") {
        targetElement = srcElement;
        DisplayClrDlg(true, e);
//    }
//    else {

//        while (srcElement && srcElement.id != "colorpanel") {
//            srcElement = srcElement.parentElement;
//        }
//        if (!srcElement) {
//            DisplayClrDlg(false, e);
//        }
//    }
}

//显示颜色对话框
//display 决定显示还是隐藏
//自动确定显示位置
function DisplayClrDlg(display, event) {

    var clrPanel = $("#colorpanel");
    if (display) {
        var left = document.body.scrollLeft + event.clientX;
        var top = document.body.scrollTop + event.clientY;
        if (event.clientX + clrPanel.width > document.body.clientWidth) {
            //对话框显示在鼠标右方时，会出现遮挡，将其显示在鼠标左方
            left -= clrPanel.width;
        }
        if (event.clientY + clrPanel.height > document.body.clientHeight) {
            //对话框显示在鼠标下方时，会出现遮挡，将其显示在鼠标上方
            top -= clrPanel.height;
        }

        clrPanel.css("left", left);
        clrPanel.css("top", top);
        clrPanel.css("display", "block");
    }
    else {
        clrPanel.css("display", "none");
    }
}

$(document).ready(function() {
    initPanel();
});

//RGB转十六进制颜色值
function zero_fill_hex(num, digits) {
    var s = num.toString(16);
    while (s.length < digits)
        s = "0" + s;
    return s;
}

function rgb2hex(rgb) {
    if (rgb.charAt(0) == '#')
        return rgb;
    var n = Number(rgb);
    var ds = rgb.split(/\D+/);
    var decimal = Number(ds[1]) * 65536 + Number(ds[2]) * 256 + Number(ds[3]);
    return "#" + zero_fill_hex(decimal, 6);
}
</script>