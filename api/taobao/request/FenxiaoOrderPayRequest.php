<?php
/**
 * TOP API: taobao.fenxiao.order.pay request
 * 
 * @author auto create
 * @since 1.0, 2013-01-16 16:30:54
 */
class FenxiaoOrderPayRequest
{
	/** 
	 * 支付信息
	 **/
	private $message;
	
	/** 
	 * 采购单编号
	 **/
	private $purchaseOrderId;
	
	private $apiParas = array();
	
	public function setMessage($message)
	{
		$this->message = $message;
		$this->apiParas["message"] = $message;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function setPurchaseOrderId($purchaseOrderId)
	{
		$this->purchaseOrderId = $purchaseOrderId;
		$this->apiParas["purchase_order_id"] = $purchaseOrderId;
	}

	public function getPurchaseOrderId()
	{
		return $this->purchaseOrderId;
	}

	public function getApiMethodName()
	{
		return "taobao.fenxiao.order.pay";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->message,"message");
		RequestCheckUtil::checkMaxLength($this->message,500,"message");
		RequestCheckUtil::checkNotNull($this->purchaseOrderId,"purchaseOrderId");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
