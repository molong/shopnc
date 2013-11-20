<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_PATH;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/highcharts.js" charset="utf-8"></script>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
    	chart = new Highcharts.Chart({
    		chart: {
    			renderTo: 'container',
    			type: 'bar'
    		},
    		title: {
    			text: '<?php echo $output['main_title']; ?>'
    		},
    		subtitle: {
    			text: '<?php echo $output['sub_title']; ?>'
    		},
    		xAxis: {
    			categories: [<?php echo $output['result_goods_str']; ?>],
    			title: {
    				text: null
    			},
    			labels: {
	   		         style: {
		   		        fontSize: '12px'
	   		         }
 		      	}
    		},
    		yAxis: {
    			min: 0,
          allowDecimals: false,
    			title: {
    				text: '<?php echo $lang['stat_goods_sale_tip']; ?>',
    				align: 'high'
    			},
    			labels: {
    				overflow: 'justify'
    			}
    		},
    		tooltip: {
    			formatter: function() {
    				return ''+
    					this.series.name +': '+ this.y +' <?php echo $lang['stat_unit']; ?>';
    			}
    		},
    		plotOptions: {
    			bar: {
    				dataLabels: {
    					enabled: true
    				}
    			}
    		},
    		credits: {
    			enabled: false
    		},
    			series: [{
    			name: '<?php echo $lang['stat_sale']; ?>',
    			data: [<?php echo $output['result_clicknum_str']; ?>]
    		}]
    	});
    });
    
});
</script>
<div class="wrap">
  <div class="tabmenu">
    <?php include template('member/member_submenu');?>
    </div>
  <form method="get" action="index.php">
    <table class="search-form">
      <input type="hidden" name="act" value="statistics" />
      <input type="hidden" name="op" value="goods_sale_statistics" />
      <tr>
        <td><input style="cursor:pointer" type="button" value="<?php echo $lang['stat_week_rank']; ?>" id="week_flow">&nbsp;<input style="cursor:pointer" type="button" value="<?php echo $lang['stat_month_rank']; ?>" id="month_flow">&nbsp;<input style="cursor:pointer" type="button" value="<?php echo $lang['stat_year_rank']; ?>" id="year_flow"></td>
        <th><?php echo $lang['stat_time_search'].$lang['nc_colon'];?></th>
        <td class="w180"><input type="text" class="text" name="add_time_from" id="add_time_from" value="<?php echo $_GET['add_time_from']; ?>" />
          &#8211;
          <input type="text" class="text" id="add_time_to" name="add_time_to" value="<?php echo $_GET['add_time_to']; ?>" /></td>
        <td class="w90 tc"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></td>
      </tr>
    </table>
  </form>
  <!-- JS统计图表 -->
  <div id="container" style="width: 800px; height: 450px; margin: 0 auto"></div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_PATH;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script type="text/javascript">
	$(function(){
	    $('#add_time_from').datepicker({dateFormat: 'yymmdd'});
	    $('#add_time_to').datepicker({dateFormat: 'yymmdd'});
	    $('#week_flow').click(function(){
	    	window.location.href = 'index.php?act=statistics&op=goods_sale_statistics';
		})
		$('#month_flow').click(function(){
	    	window.location.href = 'index.php?act=statistics&op=goods_sale_statistics&type=month';
		})
		$('#year_flow').click(function(){
	    	window.location.href = 'index.php?act=statistics&op=goods_sale_statistics&type=year';
		})
	});
</script>