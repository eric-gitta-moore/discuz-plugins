<?php
/**
 * TOP API: taobao.tbk.dg.newuser.order.get request
 * 
 * @author auto create
 * @since 1.0, 2018.04.09
 */
class TbkDgNewuserOrderGetRequest
{
	/** 
	 * mm_xxx_xxx_xxx的第三位
	 **/
	private $adzoneId;
	
	/** 
	 * 结束注册时间
	 **/
	private $endRegisterTime;
	
	/** 
	 * 页码，默认1
	 **/
	private $pageNo;
	
	/** 
	 * 页大小，默认20，1~100
	 **/
	private $pageSize;
	
	/** 
	 * 开始注册时间
	 **/
	private $startRegisterTime;
	
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

	public function setEndRegisterTime($endRegisterTime)
	{
		$this->endRegisterTime = $endRegisterTime;
		$this->apiParas["end_register_time"] = $endRegisterTime;
	}

	public function getEndRegisterTime()
	{
		return $this->endRegisterTime;
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

	public function setStartRegisterTime($startRegisterTime)
	{
		$this->startRegisterTime = $startRegisterTime;
		$this->apiParas["start_register_time"] = $startRegisterTime;
	}

	public function getStartRegisterTime()
	{
		return $this->startRegisterTime;
	}

	public function getApiMethodName()
	{
		return "taobao.tbk.dg.newuser.order.get";
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
