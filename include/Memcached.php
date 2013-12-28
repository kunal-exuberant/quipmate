<?php

class Memcached
{
	private $con = '';
	function __construct()
	{ 
		global $MEM_IP;
		global $MEM_PORT;	  
		$this->con = new Memcache;
		$this->con->connect('localhost', 11211);
	}
	
	function __destruct()
	{
	    $this->con->close();
	}
	
	function set($key, $value)
	{
		return $this->con->set($key, $value);
	}
	
	function get($key)
	{
		return $this->con->get($key);
	}

	function version()
	{
		return $this->con->getVersion();
	}
}

?>