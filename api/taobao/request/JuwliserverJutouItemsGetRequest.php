<?php
/**
 * TOP API: taobao.juwliserver.jutou.items.get request
 * 
 * @author auto create
 * @since 1.0, 2013-01-16 16:30:54
 */
class JuwliserverJutouItemsGetRequest
{
	/** 
	 * 请求的页面页码
	 **/
	private $pageNo;
	
	/** 
	 * 请求页商品数量，不能大于50
	 **/
	private $pageSize;
	
	/** 
	 * 请求类型，ios:0 android:1
	 **/
	private $requestType;
	
	/** 
	 * 客户端请求的版本
	 **/
	private $requestVersion;
	
	private $apiParas = array();
	
	public function setPageNo($pageNo)
	{
		$this->pageNo = $pageNo;
		$this->apiParas["page_no"] = $pageNo;
	}

	public function getPageNo()
	{
		return $this->pageNo;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
		$this->apiParas["page_size"] = $pageSize;
	}

	public function getPageSize()
	{
		return $this->pageSize;
	}

	public function setRequestType($requestType)
	{
		$this->requestType = $requestType;
		$this->apiParas["request_type"] = $requestType;
	}

	public function getRequestType()
	{
		return $this->requestType;
	}

	public function setRequestVersion($requestVersion)
	{
		$this->requestVersion = $requestVersion;
		$this->apiParas["request_version"] = $requestVersion;
	}

	public function getRequestVersion()
	{
		return $this->requestVersion;
	}

	public function getApiMethodName()
	{
		return "taobao.juwliserver.jutou.items.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->pageNo,"pageNo");
		RequestCheckUtil::checkNotNull($this->pageSize,"pageSize");
		RequestCheckUtil::checkNotNull($this->requestType,"requestType");
		RequestCheckUtil::checkNotNull($this->requestVersion,"requestVersion");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
