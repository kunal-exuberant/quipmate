<?php 
require_once '/var/www/include/Database.php';
$email_type=$argv[1] ; 
    
if ($email_type=='weekly_alert') 
{
$database = new Database();
$db_list = $database->get_database_list();
While($result = $db_list->fetch_array())
{
 if($result['Database'] != 'profile' && $result['Database'] != 'admin' && $result['Database'] != 'session' && $result['Database'] != 'mysql' && $result['Database'] != 'information_schema' && $result['Database'] != 'performance_schema')
 {
        $db_name = $result['Database'] ;
        $client_name = ucfirst($db_name);
        $email_res = $database->email_select($db_name);
        While ($em = $email_res->fetch_array())
        {
            $email=$em['EMAIL'];             
		    $additionalHeaders = "Content-Type:text/html \r\n"; 
	       	$additionalHeaders .= "Reply-To:no-reply<no-reply@quipmate.com>\r\n";
            $additionalHeaders .= "From:Quipmate<share@quipmate.com>";
            $subject="What are you working on at "; 
            $subject.=$client_name."?";
            $mes='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html lang="en">
    <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    </head>
    <body bgcolor="#ffffff" style="font-family:Helvetica Neue, Helvetica, Verdana, Arial, sans-serif; color: #444444;">
    <div style="font-family: Helvetica Neue, Helvetica, Verdana, Arial, sans-serif; color: #444444; min-width: 320px; max-width: 600px; margin: 0 auto; padding: 0;">
    <table border="0" cellspacing="0" style="margin-bottom: 0;background:#f5f5f5;text-align:left" width="100%" >
    <tr style="text-align:right;">
    <td><a href="https://www.quipmate.com/"><img style="border:none;" src="https://372a66a66bee4b5f4c15-ab04d5978fd374d95bde5ab402b5a60b.ssl.cf2.rackcdn.com/quipmate-logo.png" alt="Quipmate" /></a>
    </td>
    </tr>
    <tr>
    <td colspan="4" height="30" style="padding-left:10px;">
    <h1 style="font-family: Helvetica Neue, Helvetica, Verdana, Arial, sans-serif; font-size: 20px; font-weight:bold; color: #156CAE; line-height: 20p
    x; vertical-align: middle; padding: 0; margin: 0;">
    <a href="https://www.quipmate.com" style="text-decoration: none; font-weight: bold; color: #156CAE;">';
    $mes.=$client_name;
    $mes.='
    </a>
    </h1>
    </td>
    </tr>
    </table>
    </div>
    <div style="font-family: Helvetica Neue, Helvetica, Verdana, Arial, sans-serif; color: #444444; min-width: 320px; max-width: 600px; margin: 0 auto
    ; padding: 0">
    <table cellspacing="0" style="margin-bottom: 0; background:#f5f5f5;" width="100%">
    <tr>
    <td colspan="2" style="font-family: Helvetica Neue, Helvetica, Verdana, Arial, sans-serif; font-size:18px; font-weight:bold; color: #444444;padding-left:10px;">
    <h1 style="font-family: Helvetica Neue, Helvetica, Verdana, Arial, sans-serif; font-size:18px; font-weight:bold; color: #444444; line-height: 20px
    ; vertical-align: middle;margin: 0 0 10px;">
    What\'s happening at ';
    $mes.=$client_name;
    $mes.='? </h1>
       </td>
       </tr>
       <tr>
          <td colspan="2" style="font-family: Helvetica Neue, Helvetica, Verdana, Arial, sans-serif;">
             <div style="border: 1px solid #dee2e5; background-color: #ebeff1; padding: 14px 20px; margin: 0 0 10px;">
                <table cellpadding="0" cellspacing="0" style="margin-bottom: 0" width="100%">
                   <tr>
                      <td rowspan="2" style="font-family: Helvetica Neue, Helvetica, Verdana, Arial, sans-serif; font-size:14px; line-height: 20px; font-weight:normal
                      ; vertical-align: top">
                         <p style="padding: 0; margin: 0 0 10px;">
                            It\'s been a while since you last logged in.Please visit Quipmate to see the updates from people in your network.
                         </p>
                         <table border="0" cellspacing="0" class="call_to_action">
                            <tr>
                               <td style="background-color: #4e8749; border:1px solid #156CAE; font-family: Helvetica Neue, Helvetica, Verdana, Arial, sans-serif; font-size: 14px; 
                               color: #ffffff; font-weight: bold; display: inline-block; padding: 8px 18px;">
                                  <a href="https://www.quipmate.com" style="font-family:Helvetica Neue, Helvetica, Verdana, Arial, sans-serif; 
                                  font-size: 14px; text-decoration: none; color: #ffffff; font-weight: bold; 
                                  display: inline-block;" target="_blank">Visit Quipmate
                                  </a>
                               </td>
                            </tr>
                         </table>
                         <p style="padding: 0; margin: 0 0 10px;">
                         </p>
                      </td>
                   </tr>
                </table>
             </div>
          </td>
       </tr>
       <tr>
          <td style="padding:20px 0px 20px 10px;">
             Happy Quipping
             <br />
             Thank You
             <br />
             <a style="text-decoration:none;" href="https://www.quipmate.com/">Quipmate</a>
          </td>
       </tr>
       <tr>
          <td style="height:25px;text-align:right;border-top:1px dashed #cccccc;">
             <a style="text-decoration:none;font-size:11px;" href="https://www.quipmate.com/settings.php?hl=email_settings">Email Settings</a>
             &middot;
             <a style="text-decoration:none;font-size:11px;" href="https://www.quipmate.com/settings.php?hl=notification_settings">Notification Settings</a>
          </td>
       </tr>
       </table>
       </div>
       </body>   
       </html>'; 
          $var = $database->email_insert($email,$subject,$mes,$additionalHeaders);
       }
              
       }
   }
}
?>