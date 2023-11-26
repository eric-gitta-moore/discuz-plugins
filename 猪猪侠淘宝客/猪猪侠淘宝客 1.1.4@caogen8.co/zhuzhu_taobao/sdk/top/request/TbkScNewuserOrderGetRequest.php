<?php
/**
 * TOP API: taobao.tbk.sc.newuser.order.get request
 * 
 * @author auto create
 * @since 1.0, 2018.04.09
 */
class TbkScNewuserOrderGetRequest
{
	/** 
	 * mm_xxx_xxx_xxx的第三位
	 **/
	private $adzoneId;
	
	/** 
	 * 页码，默认1
	 **/
	private $pageNo;
	
	/** 
	 * 页大小，默认20，1~100
	 **/
	private $pageSize;
	
	/** 
	 * mm_xxx_xxx_xxx的第二位
	 **/
	private $siteId;
	
	private $apiParas = array();
	
	public function setAdzoneId($adzoneId)
	{
		$this->adzoneId = $adzoneId;
		$this->apiParas["adzone_id"] = $adzoneId;
	}

	public function getAdzoneId()
	{
		return $this->adzoneId;
	}

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

	public function setSiteId($siteId)
	{
		$this->siteId = $siteId;
		$this->apiParas["site_id"] = $siteId;
	}

	public function getSiteId()
	{
		return $this->siteId;
	}

	public function getApiMethodName()
	{
		return "taobao.tbk.sc.newuser.order.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkMaxValue($this->pageSize,100,"pageSize");
		RequestCheckUtil::checkMinValue($this->pageSize,1,"pageSize");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
