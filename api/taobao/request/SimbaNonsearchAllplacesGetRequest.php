<?php
/**
 * TOP API: taobao.simba.nonsearch.allplaces.get request
 * 
 * @author auto create
 * @since 1.0, 2013-01-16 16:30:54
 */
class SimbaNonsearchAllplacesGetRequest
{
	
	private $apiParas = array();
	
	public function getApiMethodName()
	{
		return "taobao.simba.nonsearch.allplaces.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
