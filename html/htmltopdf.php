<?php
/* yum install wkhtmltopdf
   yum install Xvfb
   
*/
    
exec('wkhtmltopdf http://www.kitco.com/charts/livegold.html quipmate.pdf');

//Error: Can not connect to X server.

?>