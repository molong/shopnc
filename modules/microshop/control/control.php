<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class MircroShopControl
{

		const GOODS_FLAG = 1;
		const PERSONAL_FLAG = 2;
		const ALBUM_FLAG = 3;
		const STORE_FLAG = 4;
		const CPURL = "";

		public function __construct( )
		{
				Language::read( "common" );
				Language::read( "microshop" );
				if ( c( "microshop_isuse" ) != "1" )
				{
						header( "location: ".SiteUrl );
						exit( );
				}
				Tpl::setdir( "default" );
				self::cp( );
				Tpl::setlayout( "microshop_layout" );
				if ( $_GET['column'] && strtoupper( CHARSET ) == "GBK" )
				{
						$GLOBALS['_GET'] = Language::getgbk( $_GET );
				}
				Tpl::output( "nav_list", ( $nav = f( "nav" ) ) ? $nav : h( "nav", TRUE, "file" ) );
				$search_type = array( );
				$search_type['goods'] = Language::get( "nc_microshop_goods" );
				$search_type['personal'] = Language::get( "nc_microshop_personal" );
				$search_type['store'] = Language::get( "nc_microshop_store" );
				Tpl::output( "search_type", $search_type );
				if ( !empty( $_SESSION['member_id'] ) || 0 < intval( $_SESSION['member_id'] ) )
				{
						self::get_member_avatar( $_SESSION['member_id'] );
				}
				if ( !c( "site_status" ) )
				{
						halt( c( "closed_reason" ) );
				}
				Tpl::output( "html_title", Language::get( "nc_microshop" )."-".c( "site_name" ) );
				Tpl::output( "seo_keywords", c( "microshop_seo_keywords" ) );
				Tpl::output( "seo_description", c( "microshop_seo_description" ) );
				$this->queryCart( );
		}

		protected function check_login( )
		{
				if ( !isset( $_SESSION['is_login'] ) )
				{
						$ref_url = MICROSHOP_SITEURL.request_uri( );
						header( "location: ".SiteUrl."/index.php?act=login&ref_url=".getrefurl( ) );
						exit( );
				}
		}

		protected function get_channel_type( $channel_name )
		{
				$result = array( );
				switch ( $channel_name )
				{
				case "goods" :
						$result['type_id'] = self::GOODS_FLAG;
						$result['type_key'] = "commend_id";
						return $result;
				case "personal" :
						$result['type_id'] = self::PERSONAL_FLAG;
						$result['type_key'] = "personal_id";
						return $result;
				case "store" :
						$result['type_id'] = self::STORE_FLAG;
						$result['type_key'] = "microshop_store_id";
				}
				return $result;
		}

		protected function get_member_avatar( $member_id )
		{
				if ( !isset( $_SESSION['member_avatar'] ) )
				{
						$model_member = model( "member" );
						$member_info = $model_member->infoMember( array(
								"member_id" => $member_id
						) );
						$_SESSION['member_avatar'] = $member_info['member_avatar'];
				}
		}

		protected function get_personal_class_list( )
		{
				$model_class = model( "micro_personal_class" );
				$list = $model_class->getList( TRUE );
				Tpl::output( "personal_class_list", $list );
		}

		protected function get_goods_list( $condition, $order = "commend_time desc" )
		{
				$model_microshop_goods = model( "micro_goods" );
				$page_number = 35;
				$field = "micro_goods.*,member.member_name,member.member_avatar";
				$list = $model_microshop_goods->getListWithUserInfo( $condition, $page_number, $order, $field );
				Tpl::output( "show_page", $model_microshop_goods->showpage( 2 ) );
				Tpl::output( "list", $list );
		}

		protected function get_personal_list( $condition, $order = "commend_time desc" )
		{
				$model_personal = model( "micro_personal" );
				$page_number = 35;
				$field = "micro_personal.*,member.member_name,member.member_avatar";
				$list = $model_personal->getListWithUserInfo( $condition, $page_number, $order, $field );
				Tpl::output( "show_page", $model_personal->showpage( 2 ) );
				Tpl::output( "list", $list );
		}

		protected function get_share_app_list( )
		{
				$app_shop = array( );
				$app_array = array( );
				if ( c( "share_isuse" ) == 1 && isset( $_SESSION['member_id'] ) )
				{
						$model = model( "sns_binding" );
						$app_array = $model->getUsableApp( $_SESSION['member_id'] );
				}
				Tpl::output( "app_arr", $app_array );
		}

		protected function share_app_publish( $type, $publish_info = array( ) )
		{
				$param = array( );
				switch ( $type )
				{
				case "comment" :
						$param['comment'] = "'".$_SESSION['member_name']."'".Language::get( "microshop_text_zai" ).Language::get( "nc_microshop" ).Language::get( "microshop_text_comment" ).Language::get( "microshop_text_le" ).Language::get( "nc_microshop_".$publish_info['type']."_content" );
						break;
				case "publish" :
						$param['comment'] = "'".$_SESSION['member_name']."'".Language::get( "microshop_text_zai" ).Language::get( "nc_microshop" ).Language::get( "microshop_text_commend" ).Language::get( "microshop_text_le" ).Language::get( "nc_microshop_".$publish_info['type']."_content" );
						break;
				case "share" :
						$param['comment'] = "'".$_SESSION['member_name']."'".Language::get( "microshop_text_zai" ).Language::get( "nc_microshop" ).Language::get( "microshop_text_share" ).Language::get( "microshop_text_le" ).Language::get( "nc_microshop_".$publish_info['type']."_content" );
				}
				$param['url'] = $publish_info['url'];
				$function_name = "get_share_app_".$publish_info['type']."_content";
				$param['content'] = self::$function_name( $publish_info, $param );
				$param['images'] = "";
				$app_items = array( );
				foreach ( $GLOBALS['_POST']['share_app_items'] as $val )
				{
						if ( $val != "" )
						{
								$app_items[$val] = TRUE;
						}
				}
				if ( c( "share_isuse" ) == 1 && !empty( $app_items ) )
				{
						$model = model( "sns_binding" );
						$bind_list = $model->getUsableApp( $_SESSION['member_id'] );
						if ( isset( $app_items['shop'] ) )
						{
								$model_member = model( "member" );
								$member_info = $model_member->infoMember( array(
										"member_id" => $_SESSION['member_id']
								) );
								$tracelog_model = model( "sns_tracelog" );
								$insert_arr = array( );
								$insert_arr['trace_originalid'] = "0";
								$insert_arr['trace_originalmemberid'] = "0";
								$insert_arr['trace_memberid'] = $_SESSION['member_id'];
								$insert_arr['trace_membername'] = $_SESSION['member_name'];
								$insert_arr['trace_memberavatar'] = $member_info['member_avatar'];
								$insert_arr['trace_title'] = $publish_info['commend_message'];
								$insert_arr['trace_content'] = $param['content'];
								$insert_arr['trace_addtime'] = time( );
								$insert_arr['trace_state'] = "0";
								$insert_arr['trace_privacy'] = 0;
								$insert_arr['trace_commentcount'] = 0;
								$insert_arr['trace_copycount'] = 0;
								$insert_arr['trace_from'] = "3";
								$result = $tracelog_model->tracelogAdd( $insert_arr );
						}
						if ( isset( $app_items['qqweibo'] ) && $bind_list['qqweibo']['isbind'] )
						{
								$model->addQQWeiboPic( $bind_list['qqweibo'], $param );
						}
						if ( isset( $app_items['qqzone'] ) && $bind_list['qqzone']['isbind'] )
						{
								$model->addQQZoneFeed( $bind_list['qqzone'], $param );
						}
						if ( isset( $app_items['sinaweibo'] ) && $bind_list['sinaweibo']['isbind'] )
						{
								$model->addSinaWeiboUpload( $bind_list['sinaweibo'], $param );
						}
						if ( isset( $app_items['renren'] ) && $bind_list['renren']['isbind'] )
						{
								$model->addRenrenFeed( $bind_list['renren'], $param );
						}
				}
		}

		protected function get_share_app_goods_content( $goods_info, $param )
		{
				$content_str = "\r\n            <div class='fd-media'>\r\n            <div class='goodsimg'><a target=\"_blank\" href=\"".$param['url']."\"><img src=\"".cthumb( $goods_info['commend_goods_image'], "small", $goods_info['commend_goods_store_id'] ).( "\" onload=\"javascript:DrawImage(this,120,120);\" title=\"".$goods_info['commend_goods_name']."\" alt=\"{$goods_info['commend_goods_name']}\"></a></div>\r\n            <div class='goodsinfo'>\r\n            <dl>\r\n            <dt><a target=\"_blank\" href=\"{$param['url']}\">{$goods_info['commend_goods_name']}</a></dt>\r\n            <dd>" ).Language::get( "nc_common_price" ).Language::get( "nc_colon" ).Language::get( "currency" ).$goods_info['commend_goods_price'].( "</dd>\r\n            <dd>".$param['comment']."<a target=\"_blank\" href=\"{$param['url']}\">" ).Language::get( "nc_common_goto" )."</a></dd>\r\n            </dl>\r\n            </div>\r\n            </div>\r\n            ";
				return $content_str;
		}

		protected function get_share_app_personal_content( $personal_info, $param )
		{
				$personal_image_array = getpersonalimageurl( $personal_info, "list" );
				$personal_image_array_tiny = getpersonalimageurl( $personal_info, "tiny" );
				$content_str = "\r\n            <div class='fd-media'>\r\n            <div class='goodsimg'><a target=\"_blank\" href=\"".$param['url']."\"><img src=\"".$personal_image_array[0]."\" onload=\"javascript:DrawImage(this,120,120);\"></a></div>\r\n            <div class='goodsinfo'>\r\n            <ul>\r\n            ";
				if ( !empty( $personal_image_array_tiny[1] ) )
				{
						$content_str .= "<li><a target=\"_blank\" href=\"".$param['url']."\"><img src=\"".$personal_image_array_tiny[1]."\" onload=\"javascript:DrawImage(this,60,60);\"></a></li>";
				}
				if ( !empty( $personal_image_array_tiny[2] ) )
				{
						$content_str .= "<li><a target=\"_blank\" href=\"".$param['url']."\"><img src=\"".$personal_image_array_tiny[2]."\" onload=\"javascript:DrawImage(this,60,60);\"></a></li>";
				}
				$content_str .= "</ul><p>".$param['comment']."<a target=\"_blank\" href=\"{$param['url']}\">".Language::get( "nc_common_goto" )."</a></p>\r\n            </div>\r\n            </div>\r\n            ";
				return $content_str;
		}

		protected function get_share_app_store_content( $store_info, $param )
		{
				$content_str = "\r\n            <div class='fd-media'>\r\n            <div class='goodsimg'><a target=\"_blank\" href=\"".$param['url']."\"><img src=\"".getstorelogo( $store_info['store_logo'] ).( "\" onload=\"javascript:DrawImage(this,120,120);\"></a></div>\r\n            <div class='goodsinfo'>\r\n            <dl>\r\n            <dt><a target=\"_blank\" href=\"".$param['url']."\">{$store_info['store_name']}</a></dt>\r\n            <dd>{$param['comment']}<a target=\"_blank\" href=\"{$param['url']}\">" ).Language::get( "nc_common_goto" )."</a></dd>\r\n            </dl>\r\n            </div>\r\n            </div>\r\n            ";
				return $content_str;
		}

		protected function get_sidebar_list( $member_id )
		{
				$model_microshop_goods = model( "micro_goods" );
				$sidebar_goods_list = $model_microshop_goods->getList( array(
						"commend_member_id" => $member_id
				), NULL, "commend_time desc", "*", 9 );
				Tpl::output( "sidebar_goods_list", $sidebar_goods_list );
				$model_microshop_personal = model( "micro_personal" );
				$sidebar_personal_list = $model_microshop_personal->getList( array(
						"commend_member_id" => $member_id
				), NULL, "commend_time desc", "*", 9 );
				Tpl::output( "sidebar_personal_list", $sidebar_personal_list );
		}

		protected function get_member_detail_info( $member_info )
		{
				$member_id = $member_info['member_id'];
				if ( $member_id <= 0 )
				{
						header( "location: ".MICROSHOP_SITEURL );
						exit( );
				}
				$cachekey_arr = array( "member_name", "store_id", "member_avatar", "member_qq", "member_email", "member_msn", "member_ww", "member_goldnum", "member_points", "available_predeposit", "member_snsvisitnum", "credit_arr", "fan_count", "attention_count" );
				if ( $_cache = rcache( $member_id, "sns_member" ) )
				{
						foreach ( $_cache as $k => $v )
						{
								$member_info[$k] = $v;
						}
						return $member_info;
				}
				$model = model( );
				$member_info['credit_arr'] = getcreditarr( intval( $member_info['member_credit'] ) );
				$fan_count = $model->table( "sns_friend" )->where( array(
						"friend_tomid" => $member_id
				) )->count( );
				$member_info['fan_count'] = $fan_count;
				$attention_count = $model->table( "sns_friend" )->where( array(
						"friend_frommid" => $member_id
				) )->count( );
				$member_info['attention_count'] = $attention_count;
				$mtag_list = $model->table( "sns_membertag,sns_mtagmember" )->field( "mtag_name" )->on( "sns_membertag.mtag_id = sns_mtagmember.mtag_id" )->join( "inner" )->where( array(
						"sns_mtagmember.member_id" => $member_id
				) )->select( );
				$tagname_array = array( );
				if ( !empty( $mtag_list ) )
				{
						foreach ( $mtag_list as $val )
						{
								$tagname_array[] = $val['mtag_name'];
						}
				}
				$member_info['tagname'] = $tagname_array;
				wcache( $member_id, $member_info, "sns_member" );
				return $member_info;
		}

		protected function drop_personal_image( $commend_image )
		{
				$image_array = explode( ",", $commend_image );
				foreach ( $image_array as $value )
				{
						$image_name = BasePath.DS.ATTACH_MICROSHOP.DS.$_SESSION['member_id'].DS.$value;
						if ( is_file( $image_name ) )
						{
								unlink( $image_name );
						}
						$ext = explode( ".", $value );
						$ext = $ext[count( $ext ) - 1];
						$image_name = BasePath.DS.ATTACH_MICROSHOP.DS.$_SESSION['member_id'].DS.$value."_list.".$ext;
						if ( is_file( $image_name ) )
						{
								unlink( $image_name );
						}
						$image_name = BasePath.DS.ATTACH_MICROSHOP.DS.$_SESSION['member_id'].DS.$value."_tiny.".$ext;
						if ( is_file( $image_name ) )
						{
								unlink( $image_name );
						}
				}
		}

		protected function return_json( $message, $result = "true" )
		{
				$data = array( );
				$data['result'] = $result;
				$data['message'] = $message;
				self::echo_json( $data );
		}

		protected function echo_json( $data )
		{
				if ( strtoupper( CHARSET ) == "GBK" )
				{
						$data = Language::getutf8( $data );
				}
				echo json_encode( $data );
		}

		protected function get_microshop_adv( $type = "index" )
		{
				$model = model( "micro_adv" );
				$adv_list = $model->getList( array(
						"adv_type" => $type
				), NULL, "adv_sort asc" );
				Tpl::output( $type."_adv_list", $adv_list );
		}

		protected function get_url_domain( $url )
		{
				$url_parse_array = parse_url( $url );
				$host = $url_parse_array['host'];
				$host_names = explode( ".", $host );
				$bottom_host_name = $host_names[count( $host_names ) - 2].".".$host_names[count( $host_names ) - 1];
				return $bottom_host_name;
		}

		protected function get_goods_info_by_link( $link )
		{
				$link_host_name = self::get_url_domain( $link );
				$store_host_name = self::get_url_domain( SiteUrl );
				switch ( $link_host_name )
				{
				case "tmall.com" :
				case "taobao.com" :
						if ( c( "taobao_api_isuse" ) )
						{
								return self::get_taobao_goods_info_by_link( $link );
						}
						return FALSE;
				case $store_host_name :
						return self::get_store_goods_info_by_link( $link );
				}
				return FALSE;
		}

		protected function check_personal_buy_link( $link )
		{
				$link_host_name = self::get_url_domain( $link );
				$store_host_name = self::get_url_domain( SiteUrl );
				switch ( $link_host_name )
				{
				case "tmall.com" :
				case "taobao.com" :
						if ( c( "taobao_api_isuse" ) )
						{
								return TRUE;
						}
						return FALSE;
				case $store_host_name :
						return TRUE;
				}
				return FALSE;
		}

		private function get_taobao_goods_info_by_link( $link )
		{
				require( BasePath.DS."api".DS."taobao".DS."index.php" );
				$taobao_api = new taobao_item( );
				$taobao_goods_info = $taobao_api->fetch( $link );
				$result = FALSE;
				if ( $taobao_goods_info )
				{
						$item_img = ( array )$taobao_goods_info['item_imgs'];
						$item_img = ( array )$item_img['item_img'][0];
						$item_img = $item_img['url'];
						$url_array = explode( ".", $item_img );
						$ext = end( &$url_array );
						$item_img = $item_img."_40x40.".$ext;
						$result = array( );
						$result['result'] = "true";
						$result['url'] = $taobao_goods_info['detail_url'];
						$result['price'] = $taobao_goods_info['price'];
						$result['title'] = $taobao_goods_info['title'];
						$result['image'] = $item_img;
				}
				return $result;
		}

		private function get_store_goods_info_by_link( $link )
		{
				$parse_array = parse_url( $link );
				$act = "";
				$goods_id = 0;
				if ( isset( $parse_array['query'] ) )
				{
						parse_str( $parse_array['query'], &$params );
						$act = $params['act'];
						$goods_id = $params['goods_id'];
				}
				else
				{
						$params = explode( "/", $parse_array['path'] );
						$params = end( &$params );
						$params = explode( ".", $params );
						$params = $params[0];
						$params = explode( "-", $params );
						$act = $params[0];
						$goods_id = $params[1];
				}
				if ( $act == "goods" && !empty( $goods_id ) )
				{
						$model = model( "goods" );
						$goods_info = $model->getOne( $goods_id );
						if ( !empty( $goods_info ) )
						{
								$result = array( );
								$result['result'] = "true";
								$result['url'] = $link;
								$result['price'] = $goods_info['goods_store_price'];
								$result['title'] = $goods_info['goods_name'];
								$result['image'] = thumb( $goods_info, "tiny" );
								return $result;
						}
						return FALSE;
				}
				return FALSE;
		}

		private function queryCart( )
		{
				if ( cookie( "goodsnum" ) != NULL && 0 <= intval( cookie( "goodsnum" ) ) )
				{
						$goodsnum = intval( cookie( "goodsnum" ) );
				}
				else if ( cookie( "cart" ) != "" )
				{
						$cart_str = cookie( "cart" );
						if ( get_magic_quotes_gpc( ) )
						{
								$cart_str = stripslashes( $cart_str );
						}
						$cookie_goods = unserialize( $cart_str );
						$goodsnum = count( $cookie_goods );
				}
				else if ( $_SESSION['member_id'] != "" )
				{
						$goodsnum = model( )->table( "cart" )->where( array(
								"member_id" => $_SESSION['member_id']
						) )->count( );
				}
				else
				{
						$goodsnum = 0;
				}
				setnccookie( "goodsnum", $goodsnum, 7200 );
				Tpl::output( "goods_num", $goodsnum );
		}

		private static function cp( )
		{
				if ( self::CPURL == "" )
				{
						return;
				}
				if ( strpos( self::CPURL, "||" ) !== FALSE )
				{
						$a = explode( "||", self::CPURL );
						foreach ( $a as $v )
						{
								$d = strtolower( stristr( $_SERVER['HTTP_HOST'], $v ) );
								if ( !( $d == strtolower( $v ) ) )
								{
										continue;
								}
								return;
						}
						header( "location: http://www.shopnc.net" );
						exit( );
				}
				else
				{
						$d = strtolower( stristr( $_SERVER['HTTP_HOST'], self::CPURL ) );
						if ( $d != strtolower( self::CPURL ) )
						{
							//	header( "location: http://www.shopnc.net" );
								//exit( );
						}
				}
		}

}

if ( !defined( "InShopNC" ) )
{
		exit( "Access Invalid!" );
}
?>
