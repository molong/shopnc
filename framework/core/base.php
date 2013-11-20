<?php


final class Base
{

	const CPURL = "";

	public static function run( )
	{
		self::cp( );
		global $setting_config;
		self::parse_conf( $setting_config );
		define( "MD5_KEY", $setting_config['md5_key'] );
		settimezone( $setting_config['time_zone'] );
		self::start_session( );
		Tpl::output( "setting_config", $setting_config );
		self::control( );
	}

	private static function parse_conf( &$setting_config )
	{
		$nc_config = $GLOBALS['config'];
		if ( is_array( $nc_config['db']['slave'] ) && !empty( $nc_config['db']['slave'] ) )
		{
			$dbslave = $nc_config['db']['slave'];
			$sid = array_rand( $dbslave );
			$nc_config['db']['read'] = $dbslave[$sid];
		}
		else
		{
			$nc_config['db']['read'] = $nc_config['db'][1];
		}
		$nc_config['db']['write'] = $nc_config['db'][1];
		$setting_config = $nc_config;
		$setting = ( $setting = f( "setting" ) ) ? $setting : h( "setting", TRUE, "file" );
		if ( $nc_config['thumb']['save_type'] == 1 )
		{
			$nc_config['thumb_url'] = SiteUrl;
		}
		else if ( $nc_config['thumb']['save_type'] == 2 && preg_match( "/^http:\\/\\/[\\.\\-\\w]+/", $nc_config['thumb']['url'] ) )
		{
			$nc_config['thumb_url'] = $nc_config['thumb']['url'];
		}
		else if ( $nc_config['thumb']['save_type'] == 3 && $setting['ftp_open'] )
		{
			$nc_config['thumb_url'] = $setting['ftp_access_url'];
		}
		else
		{
			$nc_config['thumb_url'] = SiteUrl;
		}
		$setting_config = array_merge_recursive( $setting, $nc_config );
	}

	private static function control( )
	{
		if ( defined( "ProjectName" ) && ProjectName != "" )
		{
			$act_file = realpath( BasePath.DS.ProjectName.DS."control".DS.$_GET['act'].".php" );
		}
		else
		{
			if ( $GLOBALS['setting_config']['enabled_subdomain'] == "1" && $_GET['act'] == "index" && $_GET['op'] == "index" )
			{
				$store_id = subdomain( );
				if ( 0 < $store_id )
				{
					$GLOBALS['_GET']['act'] = "show_store";
				}
			}
			$act_file = realpath( BasePath.DS."control".DS.$_GET['act'].".php" );
		}
		if ( is_file( $act_file ) )
		{
			require( $act_file );
			$class_name = $_GET['act']."Control";
			if ( class_exists( $class_name ) )
			{
				$main = new $class_name( );
				$function = $_GET['op']."Op";
				if ( method_exists( $main, $function ) )
				{
					$main->$function( );
				}
				else if ( method_exists( $main, "indexOp" ) )
				{
					$main->indexOp( );
				}
				else
				{
					$error = "Base Error: function ".$function." not in {$class_name}!";
					throw_exception( $error );
				}
			}
			else
			{
				$error = "Base Error: class ".$class_name." isn't exists!";
				throw_exception( $error );
			}
		}
		else
		{
			$error = "Base Error: access file isn't exists!";
			throw_exception( $error );
		}
	}

	private static function start_session( )
	{
		@ini_set( "session.cookie_domain", $GLOBALS['setting_config']['subdomain_suffix'] );
		session_save_path( BasePath."/cache/session" );
		session_start( );
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
				header( "location: http://www.shopnc.net" );
				exit( );
			}
		}
	}

}

if ( !defined( "InShopNC" ) )
{
	exit( "Access Invalid!" );
}
?>
