<section class="st-reset">
    <div class="text-center">
        <h1 class="theme-heading">Reset Password</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 m-auto">
            	<?= $this->Flash->render('positive') ?>
                <div class="inner-reset">
                    <p class="text-dark text-center d-block mb-4">Please enter a new password</p>
                    <form id="reset-form" method="post">
                        <div class="form-group">
                            <input type="password" name="rpassword" class="form-control" id="rpassword" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="rcpassword" class="form-control" id="inputPassword2" placeholder="Confirm password">
                        </div>
                        
                    	<button type="button" class="btn theme-btn d-block">Continue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--st-about-end-->


<script>

var reset_form = $("#reset-form").validate({
	rules: {
		rpassword: {
			required: true,
			minlength: 8
		},
		rcpassword: {
			required: true,
			minlength: 8,
			equalTo: "#rpassword"
		}
	},
	messages: {
		rpassword	: {
			required: "Please provide a password",
			minlength: "Your password must be at least 8 characters long"
		},
		rcpassword: {
			required: "Please provide a password",
			minlength: "Your password must be at least 8 characters long",
			equalTo: "Please enter the same password as above"
		}
	}
});

$("#reset-form button").click(function(){
	if(reset_form.form()){
		$("#reset-form").submit();
	}
});

</script>