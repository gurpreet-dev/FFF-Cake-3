<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = '';
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
        Friendly Fables
    </title>
    <link rel="icon" type="image/x-icon" href="<?php echo $this->request->webroot."images/website/favicon.png";?>" />

    <?= $this->Html->css( array('bootstrap.css','bootstrap-grid.css', 'bootstrap-reboot.css', 'style.css', 'responsive.css', 'custom/jquery-ui.min.css') ) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css" integrity="sha384-q3jl8XQu1OpdLgGFvNRnPdj5VIlCvgsDQTQB6owSOHWlAurxul7f+JpUOVdAiJ5P" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>

    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBQrWZPh0mrrL54_UKhBI2_y8cnegeex1o&sensor=false&libraries=places"></script>
    <style>
	.message.success{
		background: #00b33c;
		padding: 20px;
		color: #fff;
		font-size: 15px;
		margin: 40px 0px;
	}
	.message.error{
		background: #cc0000;
		padding: 20px;
		color: #fff;
		font-size: 15px;
		margin: 40px 0px;
	}
	</style>
    
</head>
<body>

	<main class="st-wrapper">
    
    	<header class="st-header">
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="<?php echo $this->request->webroot;  ?>"><img src="<?php echo $this->request->webroot; ?>images/website/friendly_logo.svg" /></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $this->request->webroot;  ?>">Home <!-- <span class="sr-only">(current)</span> --></a>
                            </li>
<!--                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $this->request->webroot;  ?>page/about-us">About Us</a>
                            </li>-->
                            
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo $this->request->webroot;  ?>users/plans">Subscription</a>
                            </li>
                            
                            
                            <li class="nav-item">
                                <a class="nav-link " href="<?php echo $this->request->webroot;  ?>users/contact">Contact Us</a>
                            </li>

                            
                            <?php /*if($loggeduser){ ?>
                            
                            <li class="nav-item log">
                                <a class="nav-link " href="<?php echo $this->request->webroot;  ?>users/logout">Logout</a>
                            </li>
                            <li class="nav-item user">
                                <a class="nav-link " href="<?php echo $this->request->webroot;  ?>users/edit/<?php echo base64_encode('user'.$loggeduser['id']); ?>?step=1"><img src="<?php echo $this->request->webroot; ?>images/users/<?php echo ($loggeduser['image'] != '') ? $loggeduser['image'] : 'noimage.png' ?>" /></a>
                            </li>
                            <?php }else{ ?>
                            
                            <li class="nav-item log">
                                <a class="nav-link " href="#" data-toggle="modal" data-target="#Login">Login</a>
                            </li>
                            <?php } */?>
							<li class="nav-item">
                                <a class="nav-link head-cart" href="<?php echo $this->request->webroot;  ?>cart"><img src="<?php echo $this->request->webroot;  ?>images/website/shopping-cart.svg" /><span><?php echo count($cartdata); ?></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <!--header-end-->
        
        <!--login-modals-->
        <div class="modal fade custom-modal bd-example-modal-lg" id="Login" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 p-0 text-center">
                                    <div class="login-outer align-self-center">
                                        <div class="content">
                                            <img src="<?php echo $this->request->webroot;  ?>images/website/logo-white.png" />
                                            <h1 class="theme-heading">lorem ipsum</h1>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum has been the industry's standard dummy text ever </p>
                                        </div>
                                        <div class="overlay"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <div class="right">
                                        <img src="<?php echo $this->request->webroot;  ?>images/website/logo.png" />
                                        <h4>Log In</h4>
                                        <h5>Enter your login details</h5> 
                                        
                                        <form id="login_frm">
                                        
                                        	<div class="alert-box" style="display: none;"></div>
                                            
                                            <div class="form-group">
                                                <input type="email" name="username" class="form-control" id="inputEmail2" aria-describedby="emailHelp" placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control" id="inputPassword1" placeholder="Password">
                                            </div>
                                            <a href="#" class="forgot" data-toggle="modal" data-target="#Forgot" data-dismiss="modal">Forgot Password ?</a>
                                            <button type="button" class="btn theme-btn">sign in</button>
                                            <span class="account">Dont have an account? <a data-toggle="modal" data-target="#Signup" data-dismiss="modal" href="#">Sign up</a></span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--login-modals-end-->
        <!--forgot-modal-->
        <div class="modal fade custom-modal bd-example-modal-lg" id="Forgot" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 p-0 text-center">
                                    <div class="login-outer align-self-center">
                                        <div class="content">
                                            <img src="<?php echo $this->request->webroot;  ?>images/website/logo-white.png" />
                                            <h1 class="theme-heading">lorem ipsum</h1>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum has been the industry's standard dummy text ever </p>
                                        </div>
                                        <div class="overlay"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <div class="right">
                                        <img src="<?php echo $this->request->webroot;  ?>images/website/logo.png" />
                                        <h4>Forgot Password</h4>
                                        <h5>Enter your email</h5>
                                        <form id="forgot_frm">
                                        	
                                            <div class="alert-box" style="display:none;"></div>
                                        
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" id="inputEmail3" aria-describedby="emailHelp" placeholder="Enter email">
                                            </div>
                                            <button type="button" class="btn theme-btn">Continue</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--forgot-modal-end-->
        <!--signup-modal-->
        <div class="modal fade custom-modal bd-example-modal-lg" id="Signup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
						 <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 p-0 text-center">
                                    <div class="login-outer align-self-center">
                                        <div class="content">
                                            <img src="<?php echo $this->request->webroot;  ?>images/website/logo-white.png" />
                                            <h1 class="theme-heading">lorem ipsum</h1>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum has been the industry's standard dummy text ever </p>
                                        </div>
                                        <div class="overlay"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center">
                                    <div class="right">
                                        <img src="<?php echo $this->request->webroot;  ?>images/website/logo.png" />
                                        <h4>Sign Up</h4>
                                        <h5>Enter your details</h5>
                                        
                                        
                                        
                                        <form id="signup-frm">
                                            
                                            <div class="alert-box" style="display: none;"></div>
                                            
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" id="inputText2" placeholder="Enter name">
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" id="inputEmail2" aria-describedby="emailHelp" placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password1" class="form-control" id="password1" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control" id="inputPassword2" placeholder="Confirm password">
                                            </div>
                                            <button type="button" class="btn theme-btn">sign Up</button>
                                            <span class="account">Already have an account? <a href="#" data-toggle="modal" data-target="#Login" data-dismiss="modal">Log in</a></span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--signup-modal-end-->
       
       <section class="st-content"> 
        
        <?= $this->fetch('content') ?>
        </section>
                
    </main>
    
    <footer>
        <div class="st-footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="inner">
                            <h1 class="heading">about us</h1>
                            <div class="row">
                                <div class="col-sm-3 pr-0">
                                    <div class="pic">
                                        <img src="<?php echo $this->request->webroot; ?>images/website/logo-white.png">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <p class="text">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="inner_b">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h1 class="heading">lorem ipsum</h1>
                                    <ul class="m-0 p-0">
                                        <li><a href="#">lorem ipsum</a></li>
                                        <li><a href="#">simply text</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-4">
                                    <h1 class="heading">lorem ipsum</h1>
<!--                                    <ul class="m-0 p-0">
                                        <?php foreach($staticpages as $page){ ?>
                                        <li><a href="<?php echo $this->request->webroot ?>page/<?php echo $page['slug']; ?>"><?php echo $page['title']; ?></a></li>
                                        <?php } ?>
                                    </ul>
-->                                </div>
                                <div class="col-sm-4">
                                    <h1 class="heading">lorem ipsum</h1>
                                    <ul class="m-0 p-0">
                                        <li><a href="#">lorem ipsum</a></li>
                                        <li><a href="#">simply text</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="copyright">Copyright &#169; friendlyfables.com</p>
            </div>
        </div>
    </footer>
    
<script>

/********* Sign Up **********/

var signup_form = $("#signup-frm").validate({
	rules: {
		name: "required",
		password1: {
			required: true,
			minlength: 8
		},
		password: {
			required: true,
			minlength: 8,
			equalTo: "#password1"
		},
		email: {
			required: true,
			email: true
		}
	},
	messages: {
		name: "Please enter your name",
		password1	: {
			required: "Please provide a password",
			minlength: "Your password must be at least 8 characters long"
		},
		password: {
			required: "Please provide a password",
			minlength: "Your password must be at least 8 characters long",
			equalTo: "Password entered in both fields does not match"
		},
		email: "Please enter a valid email address"
	}
});


$("#signup-frm button").click(function() {
        
	if(signup_form.form()){
		$.ajax({
			url: '<?php echo $this->request->webroot ?>users/ajaxSignup',
			data: $('#signup-frm').serialize(),
			method: 'post',
			dataType: 'json',
			beforeSend: function(){
				var info_html = '<div class="alert alert-info"><strong>Please Wait...</strong></div>';
				$('#signup-frm .alert-box').html(info_html).css('display', 'block');
			},
			success: function (response) {

				if(response){
					$('#signup-frm .alert-box').html(response.msg).css('display', 'block');
					if(response.isSucess == 'true'){
					    //alert('Sign up successfull');
						location.reload();
						
					}
				}
			}
		});
	}

});

/********* Sign Up (End) **********/

/********* Login **********/

var login_form = $("#login_frm").validate({
	rules: {
		password: {
			required: true
		},
		username: {
			required: true
		}
	},
	messages: {
		password	: {
			required: "Please enter a password"
		},
		username: "Please enter a valid email address"
	}
});

$('#login_frm button').on("click", function () {

	if(login_form.form()){
		$.ajax({
			url: '<?php echo $this->request->webroot; ?>users/login',
			data: $('#login_frm').serialize(),
			method: 'post',
			dataType: 'json',
			beforeSend: function(){
				$('#login_frm .alert-box').html('<div class="alert alert-info">Validating..</div>').css('display', 'block');
			},
			success: function(d){
				
				if (d.response.isSucess == 'false') {
					$('#login_frm .alert-box').html(d.response.msg).css('display', 'block');
					
				} else {
					$('#login_frm .alert-box').html(d.response.msg).css('display', 'block');
					location.reload();
				}
			}
		});
	}	
});

/********* Login (End) **********/


/********* Login **********/

var forgot_form = $("#forgot_frm").validate({
	rules: {
		email: {
			required: true,
			email: true
		},
	},
	messages: {
		email: "Please enter a valid email address"
	}
});

$('#forgot_frm button').on("click", function () {

	if(forgot_form.form()){
		$.ajax({
			url: '<?php echo $this->request->webroot; ?>users/forgot',
			data: $('#forgot_frm').serialize(),
			method: 'post',
			dataType: 'json',
			beforeSend: function(){
				$('#forgot_frm .alert-box').html('<div class="alert alert-info">Please Wait...</div>').css('display', 'block');
			},
			success: function(d){
				if (d.isSucess == 'false') {
					$('#forgot_frm .alert-box').html(d.msg).css('display', 'block');
				} else {
					$('#forgot_frm .alert-box').html(d.msg).css('display', 'block');
				}
			}
		});
	}	
});

/********* Login (End) **********/

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>

<?= $this->Html->script(array('parallax', 'custom')) ?>

</body>
</html>
