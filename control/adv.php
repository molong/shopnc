<?php
/**
 * 广告展示
 *
 * 
 *
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');
class advControl {
    /**
	 * 
	 * 广告展示
	 */
	public function advshowOp(){
		$ap_id = intval($_GET['ap_id']);
		if($ap_id < 1)exit;
		$time    = time();
		//加载广告位缓存文件
		$ap_cache_file = BasePath.DS.'cache'.DS.'adv'.DS.'ap_'.$ap_id.'.cache.php';
		if(file_exists($ap_cache_file)){
			require($ap_cache_file);
		}else{
			exit;
		}
		//获取广告信息并展示		
		if($ap_class == '2'){
			/**
			 * 如果没有广告可供展示则显示默认图片
			 */
			if($is_use == '1'){
				//收集没有过期的广告
				$data_select = array();
				foreach ($data as $k=>$v){
					if($v['2'] < $time&&$v['3'] > $time&&$v['1'] == '1'){
						$data_select[$k] = $data[$k];
					}
				}
			if(empty($data_select)){
				$pic = SiteUrl."/".ATTACH_ADV."/".$default_content;
				$content .= "document.write(\"<div id='KinSlideshow' style='visibility:hidden;'>";
				$content .= "<a href=''><img src='".$pic."' alt='幻灯片默认广告图片' width='".$ap_width."' height='".$ap_height."' /></a>";
				$content .= "</div>\");";
			}else{
			
				$width    = $ap_width;
				$height   = $ap_height;
				$content .= "document.write(\"<div id='KinSlideshow' style='visibility:hidden;'>";
				foreach ($data as $k=>$v){
					//加载幻灯广告缓存并展示
					$adv_id = $v['0'];
					$adv_cache_file = BasePath.DS.'cache'.DS.'adv'.DS.'adv_'.$adv_id.'.cache.php';
				    if(file_exists($adv_cache_file)){
			            require($adv_cache_file);
				        if($adv_end_date > $time && $adv_start_time < $time && $is_allow == '1'){
						$pic_content = unserialize($adv_content);
						$pic = $pic_content['adv_slide_pic'];
						$pic = SiteUrl."/".ATTACH_ADV."/".$pic;
						$url = $pic_content['adv_slide_url'];
						$content .= "<a href='".SiteUrl.DS."index.php?act=advclick&op=advclick&adv_id=".$adv_id."&ap_class=".$ap_class."' target='_blank'><img src='".$pic."' width='".$width."' height='".$height."' /></a>";
					  }
		            }					
				}
				$content .= "</div>\");";	 
			 }
			}	
			/**
			 * 向页面输出广告
			 */
			echo $content;		     
		}else{	
			switch ($ap_display){
				case '1'://多广告随机展示
			    //收集没有过期的广告
				$data_select = array();
				foreach ($data as $k=>$v){
					if($v['2'] < $time&&$v['3'] > $time&&$v['1'] == '1'){
						$data_select[$k] = $data[$k];
					}
				}
					/**
			          * 如果没有广告可供展示则显示默认图片或文字
			          */
					if($is_use == '1'){
			        if(empty($data_select)){
			        	switch ($ap_class){
			        		case '0':
			        			$width   = $ap_width;
						        $height  = $ap_height;
			        			$content .= "document.write(\"<a href=''>";
						        $content .= "<img style='width:{$width}px;height:{$height}px' border='0' src='";
						        $content .= SiteUrl."/".ATTACH_ADV."/".$default_content;
					            $content .= "' alt=''/>";
						        $content .= "</a>\");";
			        			break;
			        		case '1':
			        			$content .= "document.write(\"<a href=''>";
						        $content .= $default_content;
						        $content .= "</a>\");";
			        			break;
			        		case '3':
			        			$width   = $ap_width;
						        $height  = $ap_height;
			        			$content .= "document.write(\"<a href=''>";
						        $content .= "<img style='width:{$width}px;height:{$height}px' border='0' src='";
						        $content .= SiteUrl."/".ATTACH_ADV."/".$default_content;
					            $content .= "' alt=''/>";
						        $content .= "</a>\");";
			        			break;
			        	}
			        /**
					 * 向页面输出广告
					 */
					echo $content;
			        }else {
			        $adv_info_rand =array();
					foreach ($data as $k=>$v){
						if($v['3'] > $time && $v['2'] < $time && $v['1'] == '1'){
							$adv_info_rand[$k] = $v['0'];
						}
					}
					/**
					 * 获取广告信息
					 */
					do {
						$select = array_rand($adv_info_rand);
					    $adv_info_select = $adv_info_rand[$select];
					    $adv_cache_file = BasePath.DS.'cache'.DS.'adv'.DS.'adv_'.$adv_info_select.'.cache.php';
					}
					while(!file_exists($adv_cache_file));
					if (file_exists($adv_cache_file)){
						require($adv_cache_file);
					}
					//图片广告
			       if($ap_class == '0' && $is_use == '1'){
						$width   = $ap_width;
						$height  = $ap_height;
						$pic_content = unserialize($adv_content);
						$pic     = $pic_content['adv_pic'];
						$url     = $pic_content['adv_pic_url'];
						$content .= "document.write(\"<a href='".SiteUrl.DS."index.php?act=advclick&op=advclick&adv_id=".$adv_id."&ap_class=".$ap_class."' target='_blank'>";
						$content .= "<img style='width:{$width}px;height:{$height}px' border='0' src='";
						$content .= SiteUrl."/".ATTACH_ADV."/".$pic;
					    $content .= "' alt='".$adv_title."'/>";
						$content .= "</a>\");";
					}
					//文字广告
			       if($ap_class == '1' && $is_use == '1'){
						$word_content = unserialize($adv_content);
						$word    = $word_content['adv_word'];
						$url     = $word_content['adv_word_url'];
						$content .= "document.write(\"<a href='".SiteUrl.DS."index.php?act=advclick&op=advclick&adv_id=".$adv_id."&ap_class=".$ap_class."' target='_blank'>";
						$content .= $word;
						$content .= "</a>\");";
					}
					//Flash广告
					if($ap_class == '3' && $is_use == '1'){
						$width   = $ap_width;
						$height  = $ap_height;
						$flash_content = unserialize($adv_content);
						$flash   = $flash_content['flash_swf'];
						$url     = $flash_content['flash_url'];
						$content .= "document.write(\"<a href='".$url."' target='_blank'><button style='width:".$width."px; height:".$height."px; border:none; padding:0; background:none;' disabled><object id='FlashID' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='".$width."' height='".$height."'>";
						$content .= "<param name='movie' value='";
						$content .= SiteUrl."/".ATTACH_ADV."/".$flash;
						$content .= "' /><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='9.0.45.0' /><!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 --><param name='expressinstall' value='";
						$content .= RESOURCE_PATH."/js/expressInstall.swf'/><!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 --><!--[if !IE]>--><object type='application/x-shockwave-flash' data='";
						$content .= SiteUrl."/".ATTACH_ADV."/".$flash;
						$content .= "' width='".$width."' height='".$height."'><!--<![endif]--><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='9.0.45.0' /><param name='expressinstall' value='";
						$content .= RESOURCE_PATH."/js/expressInstall.swf'/><!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 --><div><h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4><p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='获取 Adobe Flash Player' width='112' height='33' /></a></p></div><!--[if !IE]>--></object><!--<![endif]--></object></button></a>";
						$content .= "<script type='text/javascript'>swfobject.registerObject('FlashID');</script>\");";
					}
					/**
					 * 向页面输出广告
					 */
					echo $content;
			        }
				}
					
					break;
				case '2'://单广告展示
			    //收集没有过期的广告
				$data_select = array();
				foreach ($data as $k=>$v){
					if($v['2'] < $time&&$v['3'] > $time&&$v['1'] == '1'){
						$data_select[$k] = $data[$k];
					}
				}					
			        /**
			          * 如果没有广告可供展示则显示默认图片或文字
			          */
					if($is_use == '1'){
			        if(empty($data_select)){
			        	switch ($ap_class){
			        		case '0':
			        			$width   = $ap_width;
						        $height  = $ap_height;
			        			$content .= "document.write(\"<a href=''>";
						        $content .= "<img style='width:{$width}px;height:{$height}px' border='0' src='";
						        $content .= SiteUrl."/".ATTACH_ADV."/".$default_content;
					            $content .= "' alt=''/>";
						        $content .= "</a>\");";
			        			break;
			        		case '1':
			        			$content .= "document.write(\"<a href=''>";
						        $content .= $default_content;
						        $content .= "</a>\");";
			        			break;
			        		case '3':
			        			$width   = $ap_width;
						        $height  = $ap_height;
			        			$content .= "document.write(\"<a href=''>";
						        $content .= "<img style='width:{$width}px;height:{$height}px' border='0' src='";
						        $content .= SiteUrl."/".ATTACH_ADV."/".$default_content;
					            $content .= "' alt=''/>";
						        $content .= "</a>\");";
			        			break;
			        	}
			        /**
					 * 向页面输出广告
					 */
					echo $content;
			        }else {
			        	/**
					 * 获取广告信息
					 */
			        foreach ($data as $k=>$v){
						if($v['3'] > $time && $v['2'] < $time && $v['1'] == '1'){
							$adv_id = $v['0'];
						}
					}
			        //加载广告缓存文件
			        $adv_cache_file = BasePath.DS.'cache'.DS.'adv'.DS.'adv_'.$adv_id.'.cache.php';
				    if(file_exists($adv_cache_file)){
			            require($adv_cache_file);
		            }
					//图片广告
					if($ap_class == '0' && $is_use == '1' && $is_allow == '1'){
						$width   = $ap_width;
						$height  = $ap_height;
						$pic_content = unserialize($adv_content);
						$pic     = $pic_content['adv_pic'];
						$url     = $pic_content['adv_pic_url'];
						$content .= "document.write(\"<a href='".SiteUrl.DS."index.php?act=advclick&op=advclick&adv_id=".$adv_id."&ap_class=".$ap_class."' target='_blank'>";
						$content .= "<img style='width:{$width}px;height:{$height}px' border='0' src='";
						$content .= SiteUrl."/".ATTACH_ADV."/".$pic;
					    $content .= "' alt='".$adv_title."'/>";
						$content .= "</a>\");";
					}
					//文字广告
					if($ap_class == '1' && $is_use == '1' && $is_allow == '1'){
						$word_content = unserialize($adv_content);
						$word    = $word_content['adv_word'];
						$url     = $word_content['adv_word_url'];
						$content .= "document.write(\"<a href='".SiteUrl.DS."index.php?act=advclick&op=advclick&adv_id=".$adv_id."&ap_class=".$ap_class."' target='_blank'>";
						$content .= $word;
						$content .= "</a>\");";
					}
			        //Flash广告
					if($ap_class == '3' && $is_use == '1' && $is_allow == '1'){
						$width   = $ap_width;
						$height  = $ap_height;
						$flash_content = unserialize($adv_content);
						$flash   = $flash_content['flash_swf'];
						$url     = $flash_content['flash_url'];
						$content .= "document.write(\"<a href='http://".$url."' target='_blank'><button style='width:".$width."px; height:".$height."px; border:none; padding:0; background:none;' disabled><object id='FlashID' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='".$width."' height='".$height."'>";
						$content .= "<param name='movie' value='";
						$content .= SiteUrl."/".ATTACH_ADV."/".$flash;
						$content .= "' /><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='9.0.45.0' /><!-- 此 param 标签提示使用 Flash Player 6.0 r65 和更高版本的用户下载最新版本的 Flash Player。如果您不想让用户看到该提示，请将其删除。 --><param name='expressinstall' value='";
						$content .= RESOURCE_PATH."/js/expressInstall.swf'/><!-- 下一个对象标签用于非 IE 浏览器。所以使用 IECC 将其从 IE 隐藏。 --><!--[if !IE]>--><object type='application/x-shockwave-flash' data='";
						$content .= SiteUrl."/".ATTACH_ADV."/".$flash;
						$content .= "' width='".$width."' height='".$height."'><!--<![endif]--><param name='quality' value='high' /><param name='wmode' value='opaque' /><param name='swfversion' value='9.0.45.0' /><param name='expressinstall' value='";
						$content .= RESOURCE_PATH."/js/expressInstall.swf'/><!-- 浏览器将以下替代内容显示给使用 Flash Player 6.0 和更低版本的用户。 --><div><h4>此页面上的内容需要较新版本的 Adobe Flash Player。</h4><p><a href='http://www.adobe.com/go/getflashplayer'><img src='http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='获取 Adobe Flash Player' width='112' height='33' /></a></p></div><!--[if !IE]>--></object><!--<![endif]--></object></button></a>";
						$content .= "<script type='text/javascript'>swfobject.registerObject('FlashID');</script>\");";
					}
					/**
					 * 向页面输出广告
					 */
					echo $content;
			        }	
				}				
					break;
			}
		}
	}
}