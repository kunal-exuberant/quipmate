<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../common/secret.php');
class Session
{
    private static $lifetime = 0;
	private static $database = null;
    function __construct()
    {
       session_set_save_handler(
           array($this,'open'),
           array($this,'close'),
           array($this,'read'),
           array($this,'write'),
           array($this,'destroy'),
           array($this,'gc')
       );
    }

   public function start($session_name = null)
   {
       session_start($session_name); //Start it here
   }

    public static function open()
    {
        //Connect to mysql, if already connected, check the connection state here.
        return true;
    }

    public static function read($sessionid)
    {
		global $DB_IP;
		global $DB_USER;
		global $DB_PASSWORD;
        //Get data from DB with id = $id;
		$con = new mysqli($DB_IP, $DB_USER, $DB_PASSWORD,  'session');
		$sessionid = $con->real_escape_string($sessionid);
		$result= $con->query("select data from session where sessionid='$sessionid' ");
		$row = $result->fetch_array();
		return $row['data'];
    }

    public static function write($sessionid, $data)
    {
		global $DB_IP;
		global $DB_USER;
		global $DB_PASSWORD;

        //insert data to DB, take note of serialize
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		if(isset($_SESSION))
		{
			$myprofileid = $_SESSION['USERID'];
			$time = time();
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$con = new mysqli($DB_IP, $DB_USER, $DB_PASSWORD,'session');
			$sessionid = $con->real_escape_string($sessionid);
			return $con->query("replace into session(sessionid, profileid, time, ip, user_agent, data) values('$sessionid', '$myprofileid', '$time', '$ip', '$user_agent', '$data') ");
		}
    }

    public static function destroy($sessionid)
    {
		global $DB_IP;
		global $DB_USER;
		global $DB_PASSWORD;

       //MySql delete sessions where ID = $id
		$con = new mysqli($DB_IP, $DB_USER, $DB_PASSWORD,'session');
		$sessionid = $con->real_escape_string($sessionid);
		return $con->query("delete from session where sessionid='$sessionid' ");
    }

    public static function gc()
    {
        return true;
    }
    public static function close()
    {
        return true;
    }
    public function __destruct()
    {
        session_write_close();
    }
	
	public function delete($sessionid)
    {
		global $DB_IP;
		global $DB_USER;
		global $DB_PASSWORD;

       //MySql delete sessions where ID = $id
	   	$con = new mysqli($DB_IP, $DB_USER, $DB_PASSWORD,'session');
		$sessionid = $con->real_escape_string($sessionid);
		return $con->query("delete from session where sessionid='$sessionid' ");
    }
}
?>