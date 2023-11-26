<?php
/*
 *魔趣吧：www.moqu8.com
 *更多商业插件/模版免费下载 就在魔趣吧
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

//以下为日志

interface ILogHandler
{
	public function write($msg);
	
}

class CLogFileHandler implements ILogHandler
{
	private $handle = null;
	
	public function __construct($file = '')
	{
		$this->handle = fopen($file,'a');
	}
	
	public function write($msg)
	{
		fwrite($this->handle, $msg, 4096);
	}
	
	public function __destruct()
	{
		fclose($this->handle);
	}
}

class Log
{
	private $handler = null;
	private $level = 15;
	
	private static $instance = null;
	
	private function __construct(){}

	private function __clone(){}
	
	public static function Init($handler = null,$level = 15)
	{
		if(!self::$instance instanceof self)
		{
			self::$instance = new self();
			self::$instance->__setHandle($handler);
			self::$instance->__setLevel($level);
		}
		return self::$instance;
	}
	
	
	private function __setHandle($handler){
		$this->handler = $handler;
	}
	
	private function __setLevel($level)
	{
		$this->level = $level;
	}
	
	public static function DEBUG($msg)
	{
		self::$instance->write(1, $msg);
	}
	
	public static function WARN($msg)
	{
		self::$instance->write(4, $msg);
	}
	
	public static function ERROR($msg)
	{
		$debugInfo = debug_backtrace();
		$stack = "[";
		foreach($debugInfo as $key => $val){
			if(array_key_exists("file", $val)){
				$stack .= ",file:" . $val["file"];
			}
			if(array_key_exists("line", $val)){
				$stack .= ",line:" . $val["line"];
			}
			if(array_key_exists("function", $val)){
				$stack .= ",function:" . $val["function"];
			}
		}
		$stack .= "]";
		self::$instance->write(8, $stack . $msg);
	}
	
	public static function INFO($msg)
	{
		self::$instance->write(2, $msg);
	}
	
	private function getLevelStr($level)
	{
		switch ($level)
		{
		case 1:
			return 'debug';
		break;
		case 2:
			return 'info';	
		break;
		case 4:
			return 'warn';
		break;
		case 8:
			return 'error';
		break;
		default:
				
		}
	}
	
	protected function write($level,$msg)
	{
		if(($level & $this->level) == $level )
		{
			$msg = '['.date('Y-m-d H:i:s').']['.$this->getLevelStr($level).'] '.$msg."\n";
			$this->handler->write($msg);
		}
	}
}
