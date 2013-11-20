<?php
/**
 * 支付宝接口类
 *
 * 
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class alipay{
	/**
	 *支付宝网关地址（新）
	 */
	private $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';
	/**
	 * 消息验证地址
	 *
	 * @var string
	 */
	private $alipay_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
	/**
	 * 支付接口标识
	 *
	 * @var string
	 */
    private $code      = 'alipay';
    /**
	 * 支付接口配置信息
	 *
	 * @var array
	 */
    private $payment;
     /**
	 * 订单信息
	 *
	 * @var array
	 */
    private $order;
    /**
	 * 发送至支付宝的参数
	 *
	 * @var array
	 */
    private $parameter;
    
    public function __construct($payment_info=array(),$order_info=array()){
    	if (!extension_loaded('openssl')) $this->alipay_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';//检测没有安装openssl时使用HTTP形式消息验证地址
    	$this->alipay($payment_info,$order_info);
    }
    public function alipay($payment_info=array(),$order_info=array()){
    	if(!empty($payment_info) and !empty($order_info)){
    		$this->payment	= $payment_info;
    		$this->order	= $order_info;
    	}
    }
    /**
     * 获取支付接口的连接地址
     *
     * @return string
     */
    public function get_payurl()
    {
        //基本信息
        $this->parameter = array();
        $this->parameter['service'] 		=	'create_direct_pay_by_user';	//服务名  即时到帐交易接口
        $this->parameter['partner'] 		=	$this->payment['payment_config']['alipay_partner'];	//合作伙伴ID
        $this->parameter['_input_charset']  =	CHARSET;					//网站编码
        $this->parameter['notify_url'] 		=	SiteUrl."/api/gold_payment/alipay/notify_url.php";	//通知URL
        $this->parameter['return_url'] 		=	SiteUrl."/api/gold_payment/alipay/return_url.php";	//返回URL
        $modeltype = intval($this->order['modeltype']);//模块类型 1表示金币充值，2表示积分兑换
        if ($modeltype > 0){
        	$this->parameter['extra_common_param'] 	= "$modeltype";	//自定义参数
        }else {
        	$this->parameter['extra_common_param'] 	= '1';	//自定义参数
        }
        $this->parameter['sign_type'] 		=	'MD5';						//签名方式
        //业务参数
        $this->parameter['subject'] 		=	$this->order['order_sn'];	//商品名称
        $this->parameter['body'] 			=	$this->order['order_desc'] != ''?$this->order['order_desc']:$this->order['order_sn'];	//商品描述
        $this->parameter['out_trade_no'] 	=	$this->order['order_sn'];		//外部交易编号
        $this->parameter['price'] 			=	$this->order['order_amount'];//商品单价
        $this->parameter['quantity'] 		=	1;
        $this->parameter['payment_type'] 	=	1;
        //买卖双方信息
        $this->parameter['seller_email'] 	=	$this->payment['payment_config']['alipay_account'];	//卖家邮箱
        $this->parameter['extend_param']	= "isv^sh32";
        $this->parameter['key']		= $this->payment['payment_config']['alipay_key'];
        $this->parameter['sign']	= $this->sign($this->parameter);
        return $this->create_url();
    }
  /**
   * 通知地址验证
   *
   * @return bool
   */
  public function notify_verify() {
  	$param	= $_POST;
  	$param['key']	= $this->payment['payment_config']['alipay_key'];
		$veryfy_url = $this->alipay_verify_url. "partner=" .$this->payment['payment_config']['alipay_partner']. "&notify_id=".$param["notify_id"];
		$veryfy_result  = $this->get_verify($veryfy_url);
		$mysign = $this->sign($param);
		if (preg_match("/true$/i",$veryfy_result) && $mysign == $param["sign"])  {
			if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
				return true;
    	}
		}
		return false;
	}
	/**
	 * 返回地址验证
	 *
	 * @return bool
	 */
	public function return_verify() {
		$param	= $_GET;
		$param['act']	= "";
		$param['op']	= "";
		$param['key']	= $this->payment['payment_config']['alipay_key'];
		$veryfy_url = $this->alipay_verify_url. "partner=" .$this->payment['payment_config']['alipay_partner']. "&notify_id=".$param["notify_id"];
		$veryfy_result  = $this->get_verify($veryfy_url);
		
		$mysign = $this->sign($param);
		if (preg_match("/true$/i",$veryfy_result) && $mysign == $param["sign"])  {
			if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
				return true;
    	}
		}
		return false;
	}
	/**
	 * 通知地址发送到支付宝进行验证
	 *
	 * @param string $url
	 * @param string $time_out
	 * @return string
	 */
	private function get_verify($url,$time_out = "60") {
		$urlarr     = parse_url($url);
		$errno      = "";
		$errstr     = "";
		$transports = "";
		if($urlarr["scheme"] == "https") {
			$transports = "ssl://";
			$urlarr["port"] = "443";
		} else {
			$transports = "tcp://";
			$urlarr["port"] = "80";
		}
		$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
		if(!$fp) {
			die("ERROR: $errno - $errstr<br />\n");
		} else {
			if (trim(CHARSET) == '') {
				fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
			} else {
				fputs($fp, "POST ".$urlarr["path"].'?_input_charset='.CHARSET." HTTP/1.1\r\n");
			}
			fputs($fp, "Host: ".$urlarr["host"]."\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $urlarr["query"] . "\r\n\r\n");
			while(!feof($fp)) {
				$responseText .= @fgets($fp, 1024);
			}
			fclose($fp);
			$responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");
			return $responseText;
		}
	}
    /**
     * 制作支付接口的连接地址
     *
     * @return string
     */
    private function create_url() {
		$url        = $this->alipay_gateway_new;
		$filtered_array	= $this->para_filter($this->parameter);
		$sort_array = $this->arg_sort($filtered_array);
		$arg        = "";
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode($this->charset_encode($val,$this->parameter['_input_charset'],$this->parameter['_input_charset']))."&";
		}
		$url.= $arg."sign=" .$this->parameter['sign'] ."&sign_type=".$this->parameter['sign_type'];
		return $url;
	}
	/**
	 * 取得支付宝签名
	 *
	 * @return string
	 */
	private function sign($parameter) {
		$mysign = "";
		
		$filtered_array	= $this->para_filter($parameter);
		$sort_array = $this->arg_sort($filtered_array);
		$arg = "";
        while (list ($key, $val) = each ($sort_array)) {
			$arg	.= $key."=".$this->charset_encode($val,(empty($parameter['_input_charset'])?"UTF-8":$parameter['_input_charset']),(empty($parameter['_input_charset'])?"UTF-8":$parameter['_input_charset']))."&";
		}
		$prestr = substr($arg,0,-1);  //去掉最后一个&号
		$prestr	.= $parameter['key'];
        if($parameter['sign_type'] == 'MD5') {
			$mysign = md5($prestr);
		}elseif($parameter['sign_type'] =='DSA') {
			//DSA 签名方法待后续开发
			die("DSA 签名方法待后续开发，请先使用MD5签名方式");
		}else {
			die("支付宝暂不支持".$parameter['sign_type']."类型的签名方式");
		}
		return $mysign;

	}
	/**
	 * 除去数组中的空值和签名模式
	 *
	 * @param array $parameter
	 * @return array
	 */
	private function para_filter($parameter) {
		$para = array();
		while (list ($key, $val) = each ($parameter)) {
			if($key == "sign" || $key == "sign_type" || $key == "key" || $val == "")continue;
			else	$para[$key] = $parameter[$key];
		}
		return $para;
	}
	/**
	 * 重新排序参数数组
	 *
	 * @param array $array
	 * @return array
	 */
	private function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;

	}
	/**
	 * 实现多种字符编码方式
	 */
	private function charset_encode($input,$_output_charset,$_input_charset="UTF-8") {
		$output = "";
		if(!isset($_output_charset))$_output_charset  = $this->parameter['_input_charset'];
		if($_input_charset == $_output_charset || $input == null) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
	
}