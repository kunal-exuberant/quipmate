<?php

require_once ('../include/Database.php');
require_once ('../include/File.php');
if (isset($_SESSION))
{
    require_once ('../include/Session.php');
    $session = new Session();
    $database = new Database();
    $session->start();
    if (isset($_SESSION['auth']))
    {
        header('Location: /');
        exit;
    }
}
$image_cdn = 'https://deb50923b530b51a8716-94183f92489d153831b49a81e18a1b54.ssl.cf2.rackcdn.com';
ob_start();

?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"> 
    <meta charset="UTF-8" content="text/html" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Quipmate is private social network for your company. It is a communication software for your employees which facilitates knowledge sharing and collaboration within your company" name="description">
    <meta content="Quipmate - Team" name="author">
    <meta content="http://www.quipmate.com" name="url">
    <meta content="enterprise social network, social, profile, collaboration, team, files sharing, project, idea sharing, innovation, creativity, conversation, knowledge management, engagement platform, identify hidden experts, breakdown silos, improve transparency, poll, questions, democratic decision making, enterprise 2.0, microblogging, employee engagement, groups, bottom-up communication, human capital" name="keywords">
    <title>Quipmate | Enterprise Social Network</title>
    <link href="favicon.ico" rel="shortcut icon">
<?php

$file = new File();
$file->style_welcome();
$file->google_analytics();

?>        
</head><!--/head-->

<body data-offset="0" data-target="#navbar" data-spy="scroll" class="">
    <header role="banner" id="header">
        <div class="container">
            <div class="navbar navbar-default" id="navbar">
                <div class="navbar-header">
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/" class="navbar-brand"></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#main-slider"><i class="fa fa-home"></i></a></li>
                        <li class=""><a href="#problems">Problems</a></li>
                        <li class=""><a href="#solution">Solution</a></li>
                        <li class=""><a href="#pricing">Pricing</a></li>
                        <li class=""><a href="#about-us">Team</a></li>
                        <li class=""><a href="#contact">Contact</a></li>
                    </ul>
				<ul class="pull-right list-none">
					<li><button data-toggle="modal" data-target="#loginmodal" title="Log In" class="btn pad1 top1 btn-primary bold">Login</button></li>
				</ul>
                </div>
            </div>
        </div>
    </header><!--/#header-->
<?php 
if (isset($_GET['email']) && isset($_GET['identifier']) && trim($_GET['email']) !='')
{
require_once ('../include/Session.php');
    require_once ('../include/Help.php');
    $session = new Session();
    $database = new Database();
    $session->start();
    $help = new Help();
    $email = $_GET['email'];
    if ($help->is_email($email))
    {
        $database = new Database();
        $help->assign_database($email, $database);
        $database = null;
        $database = new Database();
        $row = $database->is_already_user($email);
        if ($row['EMAIL'] != $email)
        {
            setcookie("console", "is_ not already_user", time() + 3600000, '/',
                '.quipmate.com');
            $identifier = $_GET['identifier'];
            $row = $database->virtual_select($email, $identifier);
            if ($row != 0 && $email == $row['EMAIL'] && $identifier == $row['UNIQUEID'])
            {
                $email = $row['EMAIL'];
                $nr = explode('@', $email);
                $new_member = $nr[0];

?>
<div class="container">
   <div class="row">
	<div class="top2 pad1">
		<div class="col-md-3"></div>
        <div class="col-md-6 col-sm-12 dynamic-top">
			<h3><?php  echo 'Hi ' . $new_member . ',';?></h3>
			<h4>Welcome to the Quipmate community !</h4>
			<h5>Please provide these details :</h5>
			<div class="form-group">
			<label class="text-left" >Name</label>
			<input type="text" id="signup_name" value="" title="Full Name" class="form-control" />
			</div>
			<div class="form-group">
			<label class="text-left">Password</label>
			<input type="password" id="signup_password" value=""  title="Password" class="form-control"/>
			</div>
			<div class="form-group">
			<label class="text-left">Gender</label>
			<select class="form-control" id="signup_gender">
			<option value="-1">Gender</option>
			<option value="0">Female</option>
			<option value="1">Male</option>
			</select>
			</div>
			<div class="form-group">
			<label class="text-left">Birthday</label> 
			<div class="form-control">
            <select size="1" id="day" >
			  <option value="-1">Day</option>
			  <?php

                for ($i = 1; $i <= 31; $i++)
                {
                    echo '<option value="' . $i . '">' . $i . '</option>';
                }

?>
			</select>
			<select id="month" >
			  <option value="-1">Month</option>
			  <option value="01">JAN</option>
			  <option value="02">FEB</option>
			  <option value="03">MAR</option>
			  <option value="04">APR</option>
			  <option value="05">MAY</option>
			  <option value="06">JUN</option>
			  <option value="07">JUL</option>
			  <option value="08">AUG</option>
			  <option value="09">SEP</option>
			  <option value="10">OCT</option>
			  <option value="11">NOV</option>
			  <option value="12">DEC</option>		
			</select>
            </div>
            <div class="hint">this date will be used for birthday updates.</div>
			</div>
            <div class="form-group" >
			<label class="text-left">Designation</label>
			<input type="text" id="signup_designation" value="" class="form-control" />
			</div>
            <div  class="form-group">
			<label class="text-left">Team</label>
			<input type="text" id="signup_team" value="" class="form-control" />
			</div>          
			<div class="form-group">
			<input type="hidden" id="email_hidden" value="<?php echo $email; ?>" />
			<input type="hidden" id="identifier_hidden" value="<?php  echo $identifier;?>" />
			<button onclick="action.register(this)" class="btn btn-success top1 form-control bold" >SIGNUP</button>
			</div>
			<span id="icon"></span>
			<div id="info" class="top1"></div>
			</div>
         </div>
      </div>
</div>            
			
		<?php                
            }
    else
    {
?>
<div class="container">
   <div class="row">
	<div class="top2 pad1">
        <div class="tex-center dynamic-top">
			<div class="alert alert-danger" role="alert"><h5>The invitation link sent to you seems to be broken. Please try again.</h5></div>
        </div>  
     </div>   
    </div>   
</div>    
<?php        
        
    }                
       }
    else
    {
?>
<div class="container">
   <div class="row">
	<div class="top2 pad1">
        <div class="text-center dynamic-top">
    	<h3>Welcome To Quipmate.</h3>
    	<h5>You are already a part of Quipmate</h5>
    	<h5>Please Login using your email and password.</h5>
    	<h5>If you forgot your password, please use forgot password link to recover it.</h5>
        </div>  
    </div>
   </div>
</div>         
<?php        
    }
           
  }
  else
  {
    
  }     

}
else 
    if (isset($_GET['id']) && isset($_GET['email']) && isset($_GET['click']))
    {
        $click = $_GET['click'];
        if ($click == 'recover_password')
        {
            require_once ('../include/Database.php');
            require_once ('../include/Session.php');
            require_once ('../include/Help.php');
            $session = new Session();
            $database = new Database();
            $session->start();
            $flag = 0;
            $id = $_GET['id'];
            $email = $_GET['email'];
            $help = new Help();
            $database = new Database();
            $help->assign_database($email, $database);
            $database = null;
            $database = new Database();
            $uniqueid = $database->select_uniqueid($email);
            if ($uniqueid == $id)
            {
?>
<div class="container">
   <div class="row">
	<div class="top2 pad1">
		<div class="col-md-3"></div>
        <div class="col-md-6 col-sm-12 dynamic-top"><h3>Reset your password</h3>
				<div class="form-group">
					<label class="text-left" >New Password</label>
					<input type="password" name="pass" id = "pass" class="form-control"/>
				</div>
				<input type="hidden" id="recover_password_email" value="<?php echo $email;?>" />
				<input type="hidden" id="recover_password_uniqueid" value="<?php  echo $id;?>" />
				<div class="form-group top1">
					<label class="text-left">Confirm Password</label>
					<input class="form-control" type="password" name="confirmpass" id = "confirmpass"/>
				</div>
				<button class="btn btn-success" name="change" id = "change" onclick="action.recover_password(this)">Reset Password</button>
				<div class="top1"><div id = "recover_password_info" ></div></div>
		</div>
      </div>
    </div>
</div>           
<?php                
            }
             else
            {

?>
<div class="container">
   <div class="row">
	<div class="top2 pad1">
        <div class="col-md-6 col-sm-12 dynamic-top"><h3>Invalid Account or Probably the link has been out-dated.</h3>
	    </div>
    </div>
 </div>
</div>         
<?php

            }
            $file->script_welcome();
        } 
        else
        {

?>
<div class="container">
   <div class="row">
	<div class="top2 pad1">
        <div class="col-md-6 col-sm-12 dynamic-top"><h3>Invalid Link.</h3>
	    </div>
    </div>
 </div>
</div> 
<?php

        }
    }
else
    if (isset($_GET['click']) && $_GET['click'] == 'forgot_password')
    {
            require_once ('../include/Session.php');
            $session = new Session();
            $session->start();
 ?>
<div class="container">
   <div class="row">
	<div class="top2 pad1">
		<div class="col-md-3"></div>
        <div class="col-md-6 col-sm-12 dynamic-top"><h3>Forgot your password?</h3>
		<div >
			<label class="text-left">Enter your Email</label>
			<input type="text" class="form-control text-left" id = "forgot_password_email" /> 
			<button class="btn btn-primary bold top1" onclick="action.forgot_password(this)" id = "forgot_password_button">Recover Password</button>
		</div>
		<div id="forgot_password_info" class="pad1 top1"></div>
        </div>
	</div>
    </div>
</div>    
<?php           
    }
else
    {            
?>    
    <section class="carousel" id="main-slider">
        <div class="carousel-inner">
            <div class="item">
                <div class="container">
                    <div class="carousel-content">
                        <h1>Employee Social Network</h1>
                        <p class="lead">Quipmate helps tap the collective power of employees,<br> free flow of ideas and knowledge in an organization.
</p>
                    </div>
                </div>
            </div><!--/.item-->
            <div class="item active">
                <div class="container">
                    <div class="carousel-content">
                        <h1>Communication Platform </h1>
                        <p class="lead">It is communication platform for employees and facilitates knowledge sharing <br>and collaboration within an organization.</p>
                    </div>
                </div>
            </div><!--/.item-->
        </div><!--/.carousel-inner-->
        <a data-slide="prev" href="#main-slider" class="prev"><i class="fa fa-chevron-left"></i></a>
        <a data-slide="next" href="#main-slider" class="next"><i class="fa fa-chevron-right"></i></a>
		<div id="headerwrap" class="container">
          <div class="row">
            <div class="span12">
              <h2>Join and invite your peers to Quipmate</h2>
			  <h4 id="signup_info"></h4>
              <input type="text" name="your-email" placeholder="Please enter your work email" id="signup_email">
              <input type="submit" onclick="action.self_invite(this)" value="Signup" id="signup_email_button">
            </div>
          </div>
          
        </div>
    </section><!--/#main-slider-->
<?php 
}
?>    
    <section id="problems">
        <div class="container">
            <div class="box first ">
                <div class="row ">
				    <div class="text-center"><h2></h2><h3 class="bold">Improve awareness inside organization</h3></div>
					<div class="col-md-6 col-sm-12">
						<div class="center">
						<img width="350" height="350" class="" max-width="" src="<?php echo $image_cdn;?>/Picture2.png">
						</div>
					</div>	
					<div class="col-md-6 col-sm-12">
					<div class="pad1"><h4><i class="fa fa-check-square-o fa-2x pull-left"></i>An employee may not be aware of what the person sitting five desk apart is working on.</h4>
					</div>
					<div class="pad1">
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>He might be working on the same problem that this employee worked on last month.</h4>
					</div>
					<div class="pad1"> 
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>Prevent this re-inventing the wheel in your  organization.</h4>
					</div>
					</div>					
				</div>	
			</div>
		</div>
		<div class="container top1">
			<div class="box">
				<div class="row">
				   <div class="text-center"><h3 class="bold">Speed up the flow of information</h3></div>
					<div class="col-md-6 col-sm-12">
					<div class="pad1"><h4><i class="fa fa-check-square-o fa-2x pull-left"></i>Information does not flow at the speed of twitter in your organization.</h4>
					</div>
					<div class="pad1">
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>Any information that you want to share with employees does not get across at that speed.</h4>
					</div>
					<div class="pad1"> 
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>Take decisions at speed of light.</h4>
					</div>
					</div>
                    <div class="col-md-6 col-sm-12">
                        <div class="center">
                            <img width="350" height="350" class="" src="<?php echo $image_cdn;?>/Picture3.jpg">
                        </div>
					</div>					
                </div><!--/.row-->
            </div><!--/.box-->
        </div><!--/.container-->
		 <div class="container top1">
			<div class="box">
				<div class="row">
				<div class="text-center"><h3 class="bold">Mobility</h3></div>
				    <div class="col-md-6 col-sm-12">
                        <div class="center">
                            <img width="350" height="350" class="" src="<?php echo $image_cdn;?>/Picture1.jpg">
                        </div>
					</div>	
					<div class="col-md-6 col-sm-12">
					<div class="pad1"><h4><i class="fa fa-check-square-o fa-2x pull-left"></i>More and more work is done these days when the employees are away from the desk.</h4>
					</div>
					<div class="pad1">
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>It is important that they are connected with the work they are doing in office from their mobile phone.</h4>
					</div>
					<div class="pad1"> 
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>Work from anywhere.</h4>
					</div>
					</div>
				
                </div><!--/.row-->
            </div><!--/.box-->
        </div><!--/.container-->
		<div class="container top1">
			<div class="box">
				<div class="row">
				   <div class="text-center"><h3 class="bold">Capture Knowledge</h3></div>
					<div class="col-md-6 col-sm-12">
					<div class="pad1"><h4><i class="fa fa-check-square-o fa-2x pull-left"></i>Capture the cycle of evolution of a product which is as much important as the final product itself.</h4>
					</div>
					<div class="pad1">
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>It should be captured and retained so that you are not dependent on any employee leaving the company.</h4>
					</div>
					</div>
                    <div class="col-md-6 col-sm-12">
                        <div class="center">
                            <img width="350" height="350" class="" src="<?php echo $image_cdn;?>/Picture4.jpg">
                        </div>
					</div>					
                </div><!--/.row-->
            </div><!--/.box-->
        </div><!--/.container-->	
		 <div class="container top1">
			<div class="box">
				<div class="row">
				<div class="text-center"><h3 class="bold">Culture</h3></div>
				    <div class="col-md-6 col-sm-12">
                        <div class="center">
                            <img width="350" height="350" class="" src="<?php echo $image_cdn;?>/Picture5.jpg">
                        </div>
					</div>	
					<div class="col-md-6 col-sm-12">
					<div class="pad1"><h4><i class="fa fa-check-square-o fa-2x pull-left"></i>Your employees mostly would be operating in silos - everyone is like a different system.</h4>
					</div>
					<div class="pad1">
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>They need a way to share, organize and retain the information.</h4>
					</div>
					</div>
				
                </div><!--/.row-->
            </div><!--/.box-->
        </div><!--/.container-->		
    </section><!--/#services-->

    <section id="solution">
        <div class="container top1">
			<div class="box">
				<div class="row ">
					<div class="center">
						<h2>Solution</h2>
						<h3 class="top0 bold">Private Social Network for your company</h3>
					</div><!--/.center-->
					<div class="col-md-6 col-sm-12">
					<div><h3>Using Quipmate your employees -</h3>
					</div>					
					<div class="pad1"><h4><i class="fa fa-check-square-o fa-2x pull-left"></i>Know whom they are working with.</h4>
					</div>
					<div class="pad1">
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>Know what other employees are working on.</h4>
					</div>
					<div class="pad1">
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>They are always connected with every other person in the organization.</h4>
					</div>
					<div class="pad1">
					<h4><i class="fa fa-check-square-o  fa-2x pull-left"></i>Always have access to everything - the company files, tools, expertise and history wherever they are and whenever they need.</h4>
					</div>
					</div>
                    <div class="col-md-6 col-sm-12">
                        <div class="center">
                            <img width="350" height="350" class="" src="<?php echo $image_cdn;?>/Picture6.jpg">
                        </div>
					</div>					
                </div><!--/.row-->
            </div><!--/.box-->
        </div><!--/.container-->
    </section><!--/#portfolio-->

    <section id="pricing">
        <div class="container">
            <div class="box">
                <div class="center">
                    <h2>Quipmate pricing</h2>
                </div><!--/.center-->   
                <div class="row" id="pricing-table">
                    <div class="col-sm-4">
                    </div><!--/.col-sm-4-->
                    <div class="col-sm-4">
                        <ul class="plan featured">
                            <!--<li class="plan-name">Premium</li>-->
                            <li class="plan-price"><i class="fa fa-inr"></i>&nbsp;5 <br /><h4 style="color: white;">Per employee per day</h4></li>
                            <li>1 Month free</li>
                            <li>Full Features</li>
                            <li>Unlimited Bandwidth</li>
                            <li>Unlimited Storage</li>
                            <li>Customer Support</li>
                            <li class="plan-action"><a class="btn btn-primary btn-lg" href="#main-slider">Signup</a></li>
                        </ul>
                    </div><!--/.col-sm-4-->
                    <div class="col-sm-4">
                    </div><!--/.col-sm-4-->
                </div> 
            </div> 
        </div>
    </section><!--/#pricing-->

    <section id="about-us">
        <div class="container">
            <div class="box">
                <div class="center">
                    <h2>Our passionate team</h2>
                </div>
                <div class="carousel scale" id="team-scroller">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="row">
                                  <div class="col-sm-4">
                                    <div class="member">
                                        <p><img alt="" src="https://media.licdn.com/mpr/mpr/shrink_240_240/p/6/005/077/22c/0bf071b.jpg" class="img-responsive img-thumbnail img-circle"></p>
                                        <h3>Kunal Singh<small class="designation">Co-Founder, CEO</small></h3>
                                        <ul class="social">
                                        <li><a href="https://www.linkedin.com/in/exuberant" target="_blank"><i class="fa fa-linkedin icon-linkedin icon-social"></i></a></li>
                                        </ul>
                                        
                                    </div>
                                </div>                               
							   <div class="col-sm-4">
                                    <div class="member">
                                        <p><img alt="" src="https://media.licdn.com/media/p/5/005/079/2c1/0fde188.jpg" class="img-responsive img-thumbnail img-circle"></p>
                                        <h3>Brijesh Kushwaha<small class="designation">CTO &amp; Co-Founder</small></h3>
                                        <ul class="social">
                                        <li><a href="https://www.linkedin.com/in/brijeshkushwaha" target="_blank"><i class="fa fa-linkedin icon-linkedin icon-social"></i></a></li>
                                        </ul>                                        
                                    </div>
                                </div>      
                                <div class="col-sm-4">
                                    <div class="member">
                                        <p><img alt="" src="https://media.licdn.com/media/p/7/005/037/201/0429a09.jpg" class="img-responsive img-thumbnail img-circle"></p>
                                        <h3>Vijay Kumar<small class="designation">Chairman, Director</small></h3>
                                        <ul class="social">
                                        <li><a href="https://www.linkedin.com/in/vijayjaiswal" target="_blank"><i class="fa fa-linkedin icon-linkedin icon-social"></i></a></li>
                                        </ul>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="member">
                                        <p><img alt="" src="https://media.licdn.com/mpr/mpr/shrink_200_200/p/3/000/014/260/3b128d5.jpg" class="img-responsive img-thumbnail img-circle"></p>
                                        <h3>Ambar Kumar<small class="designation">Director</small></h3>
                                        <ul class="social">
                                        <li><a href="https://www.linkedin.com/in/ambarkumar" target="_blank"><i class="fa fa-linkedin icon-linkedin icon-social"></i></a></li>
                                        </ul>                                        
                                    </div>
                                </div>   
                                <div class="col-sm-4">
                                    <div class="member">
                                        <p><img alt="" src="https://media.licdn.com/mpr/mpr/shrink_200_200/p/3/000/095/1aa/2211aba.jpg" class="img-responsive img-thumbnail img-circle"></p>
                                        <h3>Sunil Maheshwari<small class="designation">Advisor</small></h3>
                                        <ul class="social">
                                        <li><a href="https://www.linkedin.com/in/sunilm" target="_blank"><i class="fa fa-linkedin icon-linkedin icon-social"></i></a></li>
                                        </ul>                                        
                                    </div>
                                </div>     
                            </div>
                        </div>
                    </div>
                    <a data-slide="prev" href="#team-scroller" class="left-arrow">
                        <i class="fa fa-angle-left fa-4x"></i>
                    </a>
                    <a data-slide="next" href="#team-scroller" class="right-arrow">
                        <i class="fa fa-angle-right fa-4x"></i>
                    </a>
                </div><!--/.carousel-->
            </div><!--/.box-->
        </div><!--/.container-->
    </section><!--/#about-us-->

    <section id="contact">
        <div class="container">
            <div class="box last">
			<h2></h2>
                <div class="row">
                    <div class="col-sm-6">
                        <h3>Contact Form</h3>
                        <p>We are always glad to hear from you .Please fill the details in below form and submit .</p>
                        <div style="display: none" class="status alert alert-success"></div>
                        <form role="form" action="ajax/write.php" method="post" name="contact-form" class="contact-form" id="contact_form">
                            <input type="hidden" id="contact" value="contact" name="action">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="contact_name" placeholder="Name" required="required" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="contact_email" placeholder="Email address" required="required" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea placeholder="Message" rows="8" class="form-control" required="required" name="contact_message"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button id="contact_send" class="btn btn-danger btn-lg" type="submit">Send Message</button>
                                    </div>
                                    <div id="contact_info"></div>
                                </div>
                            </div>
                        </form>
                    </div><!--/.col-sm-6-->
                    <div class="col-sm-6">
                        <h3>Our Address</h3>
                        <div class="row">
                            <div class="col-md-7">
                                <address>
                                    <strong>Quipmate Enterprise Solutions Pvt. Ltd.</strong><br/>
                                    418, South Block <br/>
                                    Manipal Center, Dickenson Road<br/>
                                    Bangalore - 560042<br/>
                                    India<br/>
                                    Email : contact@quipmate.com<br/>
                                    <abbr title="Phone">Mob:</abbr> +91-9535880638
                                </address>
                            </div>
                        </div>
                        <h3>Connect with us</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="social">
                                    <li><a href="https://www.facebook.com/quipmate"><i class="fa fa-facebook icon-facebook icon-social fa-2x"></i> Facebook</a></li>
                                    <li><a href="https://plus.google.com/103861395293185727168/about"><i class="fa fa-google-plus icon-google-plus icon-social fa-2x"></i> Google Plus</a></li>
                                    <li><a href="https://in.pinterest.com/quipmate/"><i class="fa fa-pinterest icon-pinterest icon-social fa-2x"></i> Pinterest</a></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="social">
                                    <li><a href="https://www.linkedin.com/company/quipmate"><i class="fa fa-linkedin icon-linkedin icon-social fa-2x"></i> Linkedin</a></li>
                                    <li><a href="https://twitter.com/quipmate"><i class="fa fa-twitter icon-twitter icon-social fa-2x"></i> Twitter</a></li>
                                    <li><a href="https://www.youtube.com/channel/UCef6CYLPQRXCuc_xC28dtUw"><i class="fa fa-youtube icon-youtube icon-social fa-2x"></i> Youtube</a></li>
                                </ul>
                            </div>
                        </div>
                    </div><!--/.col-sm-6-->
                </div><!--/.row-->
            </div><!--/.box-->
        </div><!--/.container-->
    </section><!--/#contact-->

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; Quipmate Enterprise Solutions Private Limited. All Rights Reserved.
                </div>
                <div class="col-sm-6">
                	<a target="_blank" href="public/faq.php">FAQ</a><span class="separator">|</span>
                	<a target="_blank" href="public/terms.php">Terms of Use</a><span class="separator">|</span>
                	<a target="_blank" href="public/security.php">Security &amp; Compliance</a><span class="separator">|</span>
                	<a target="_blank" href="public/privacy.php">Privacy Policy</a><span class="separator">|</span>
                    <a target="_blank" href="public/getting_started.php">Getting Started</a>
                </div>
            </div>
        </div>
            <div aria-labelledby="basicModal" role="dialog" aria-hidden="true" class="modal" id="loginmodal" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
                            <h3>Sign Into Quipmate</h3>
                        </div>
                        <div class="modal-body">
                            <div>
                                <form id="login_form" action="ajax/write.php" method="post">
                                    <div>
                                        <p><input type="email" autocomplete="off" placeholder="Email address" value="" tabindex="5" class="input-lg form-control" name="email" id="login_email">
                                        </p>
                                        <!--label class="error error-container" for="popup-login-email">Please use a valid email address</label-->
                                        <p><input type="password" autocomplete="off" placeholder="Password" tabindex="5" class="input-lg form-control" name="password" id="login_pass"></p>
                                        <!--label class="error error-container" for="popup-login-password">Password required</label-->
                                    </div>
                                    <input type="hidden" id="action" value="login" name="action">
                                    <p style="text-align:right; font-size:12px;"><a href="welcome.php?click=forgot_password">Forgot your password?</a></p>
            
                                    <p><input type="submit" autocomplete="off" value="Sign in" tabindex="6" title="Login to Quipmate" class="btn btn-block btn-large btn-primary btn-home bold" name="login" id="login_button"></p>
            
                                </form>
                            </div>
                        <div id="login_response" class="top1"></div>
                        </div>
                    </div>
                </div>
            </div>	
<?php 
     $file->script_welcome();
?>		            
    </footer><!--/#footer-->

</body></html>