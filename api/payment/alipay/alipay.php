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
     * 获取支付接口的请求地址
     *
     * @return string
     */
    public function get_payurl(){
    	$this->parameter = array(
        		/* 基本信息 */
            'service'		=> $this->payment['payment_config']['alipay_service'],	//服务名
            'partner'		=> $this->payment['payment_config']['alipay_partner'],	//合作伙伴ID
            '_input_charset'	=> CHARSET,					//网站编码
            'notify_url'	=> SiteUrl."/api/payment/".$this->order['payment_code']."/notify_url.php",	//通知URL
            'sign_type'		=> 'MD5',						//签名方式
            'return_url'	=> SiteUrl."/api/payment/".$this->order['payment_code']."/return_url.php",	//返回URL
            /* 业务参数 */
            'subject'		=> $this->order['order_sn'],	//商品名称
            'body'			=> $this->order['order_sn'],	//商品描述
            'out_trade_no'	=> $this->order['out_sn'],		//外部交易编号
            'payment_type'	=> 1,							//支付类型
            /* 物流参数 统一暂定为其他快递*/
            'logistics_type'=> 'EXPRESS',					//物流配送方式：POST(平邮)、EMS(EMS)、EXPRESS(其他快递)
            'logistics_payment'	=> 'BUYER_PAY',				//物流费用付款方式：SELLER_PAY(卖家支付)、BUYER_PAY(买家支付)、BUYER_PAY_AFTER_RECEIVE(货到付款)
            /* 收货地址信息 */
            'receive_name'		=>$this->order['true_name'],//收货人姓名
            'receive_address'	=>$this->order['address'],	//收货人地址
            'receive_zip'		=>$this->order['zip_code'],	//收货人邮编
            'receive_phone'		=>$this->order['tel_phone'],//收货人电话
            'receive_mobile'	=>$this->order['mob_phone'],//收货人手机
            /* 买卖双方信息 */
            'seller_email'		=> $this->payment['payment_config']['alipay_account']	//卖家邮箱
        );
        if ($this->payment['payment_config']['alipay_service'] == 'create_direct_pay_by_user'){
        	$this->parameter['total_fee'] = $this->order['order_amount'];//订单总价
        } else {
        	$this->parameter['price']	= $this->order['order_amount'];//订单总价
			$this->parameter['quantity']= 1;						   //商品数量
			$this->parameter['logistics_fee'] = "0.00";//物流配送费用
        }
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
		$veryfy_result  = $this->getHttpResponse($veryfy_url);
		$mysign = $this->sign($param);
		if (preg_match("/true$/i",$veryfy_result) && $mysign == $param["sign"])  {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * 返回地址验证
	 *
	 * @return bool
	 */
	public function return_verify() {
		$param	= $_GET;
		$param['act']	= "";//将系统的控制参数置空，防止因为加密验证出错
		$param['op']	= "";
		$param['key']	= $this->payment['payment_config']['alipay_key'];
		$veryfy_url = $this->alipay_verify_url. "partner=" .$this->payment['payment_config']['alipay_partner']. "&notify_id=".$param["notify_id"];
		$veryfy_result  = $this->getHttpResponse($veryfy_url);
		$mysign = $this->sign($param);
		if (preg_match("/true$/i",$veryfy_result) && $mysign == $param["sign"])  {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * 获取订单更新参数数组
	 *
	 * @param array $param
	 * @return array
	 */
	public function getUpdateParam($param){
		$input	= array();
		if(empty($param['trade_status']) and empty($param['refund_status'])){
			$input['error']	= true;
		}else{
			if(!empty($param['trade_status'])){
				$input['order_state']	= $this->getTradeState($param['trade_status']);
			}
			if(!empty($param['refund_status'])){
				$input['refund_state']	= $this->getRefundState($param['refund_status']);
			}
			if($this->order['order_state'] >= $input['order_state'] and $this->order['refund_state'] >= $input['refund_state']){
				$input	= array();
			}elseif($this->order['order_state'] < $input['order_state'] and $this->order['refund_state'] >= $input['refund_state']){
				$input	= $this->getTradeChange($input['order_state']);
				$input['out_payment_code']	= $param['trade_no'];
			}elseif($this->order['order_state'] >= $input['order_state'] and $this->order['refund_state'] < $input['refund_state']){
				$input	= $this->getRefundChange($input['refund_state']);
			}
		}
		return $input;
	}
	/**
   * 构造确认发货接口
	 * 此接口只支持https请求
	 * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。
   * @param $data 请求参数数组
   * @return 支付宝返回XML处理结果
	 */
	public function sendPostInfo($data){
  	$this->parameter = array(
			"service"			=> "send_goods_confirm_by_platform",//接口名称
			'sign_type'		=> 'MD5',						//签名方式
			"partner"			=> $this->payment['payment_config']['alipay_partner'],	//合作伙伴ID
			'key'		=> $this->payment['payment_config']['alipay_key'],//安全检验码
			"_input_charset"	=> CHARSET,					//网站编码
			"trade_no"			=> $this->order['out_payment_code'],		//支付宝交易号
			"logistics_name"	=> $data['express_name'],//物流公司名称
			"invoice_no"		=> $data['shipping_code'],//物流发货单号
			"transport_type"	=> 'EXPRESS'//物流发货时的运输类型，三个值可选：POST（平邮）、EXPRESS（快递）、EMS（EMS）
      );
    $this->parameter['sign']	= $this->sign($this->parameter);
		$url = $this->create_url();
		//远程获取数据
		$xml_data = $this->getHttpResponse($url);
		//解析XML
		$doc = new DOMDocument();
		if(!empty($xml_data)) $doc->loadXML($xml_data);
		return $doc;
	}
	/**
	 * 发货处理
	 *
	 */
	public function sendGoods(){
    	echo "<script>window.location =\"https://www.alipay.com/trade/seller_send_goods.htm?trade_no=".$this->order['out_payment_code']."\";</script>"; exit;
    }
    /**
     * 收货处理
     *
     */
    public function receiveGoods(){
    	echo "<script>window.location =\"https://www.alipay.com/trade/dealing_got_products.htm?trade_no=".$this->order['out_payment_code']."\";</script>"; exit;
    }
	/**
	 * 远程获取数据
	 * $url 指定URL完整路径地址
	 * @param $time_out 超时时间。默认值：60
	 * return 远程输出的数据
	 */
	private function getHttpResponse($url,$time_out = "60") {
		$urlarr     = parse_url($url);
		$errno      = "";
		$errstr     = "";
		$transports = "";
		$responseText = "";
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
     * 制作支付接口的请求地址
     *
     * @return string
     */
    private function create_url() {
		$url        = $this->alipay_gateway_new;
		$filtered_array	= $this->para_filter($this->parameter);
		$sort_array = $this->arg_sort($filtered_array);
		$arg        = "";
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode($val)."&";
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
	/**
	 * 获取array格式的订单交易状态改变的参数数组
	 *
	 * @param string $code
	 * @param string $status
	 * @return int|bool
	 */
	private function getTradeState($status){
		$return	= false;
		switch($status){
			case 'WAIT_BUYER_PAY':
				$return	= 10;
				break;
			case 'WAIT_SELLER_SEND_GOODS':
				$return	= 20;
				break;
			case 'WAIT_BUYER_CONFIRM_GOODS':
				$return	= 30;
				break;
			case 'TRADE_FINISHED':
				$return	= 40;
				break;
			case 'TRADE_SUCCESS':
				$return	= 40;
				break;
			case 'TRADE_CLOSED':
				$return	= 99;
				break;
		}
		return $return;
	}
	/**
	 * 获取array格式的订单退款状态改变的参数数组
	 *
	 * @param string $code
	 * @param string $status
	 * @return int|bool
	 */
	private function getRefundState($status){
		$array_Status	= array();
		switch($status){
			case 'WAIT_SELLER_AGREE':
				$array_Status['refund_state']	= 10;
				break;
			case 'REFUND_CLOSED':
				$array_Status['refund_state']	= 20;
				break;
			case 'REFUND_SUCCESS':
				$array_Status['refund_state']	= 30;
				break;
		}
		return $array_Status;
	}
	/**
	 * 根据订单交易新状态获取其他订单属性的改变参数
	 *
	 * @param int $order_state
	 * @return array
	 */
	private function getTradeChange($order_state){
		$input	= array('order_state'=>$order_state);
		switch($order_state){
			case 10:
				break;
			case 20:
				$input['payment_time']	= time();
				break;
			case 30:
				$input['shipping_time']	= time();
				break;
			case 40:
				$input['finnshed_time']	= time();
				break;
		}
		return $input;
	}
	/**
	 * 根据订单退款新状态获取其他订单属性的改变参数
	 *
	 * @param int $order_state
	 * @return array
	 */
	private function getRefundChange($refund_state){
		$input	= array('refund_state'=>$refund_state);
		switch($refund_state){
			case 10:
				break;
			case 20:
				break;
			case 30:
				break;
		}
		return $input;
	}
}