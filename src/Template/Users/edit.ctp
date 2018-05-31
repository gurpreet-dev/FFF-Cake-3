<section class="st-editprofile">
    <div class="text-center">
        <h1 class="theme-heading">profile</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 m-auto">
            <?php echo $this->Flash->render(); ?>
                <div class="inner-profile">
                    <div class="row">
                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link <?php echo ($_GET['step'] == 1) ? 'active' : ''; ?>" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                                <a class="nav-link <?php echo ($_GET['step'] == 2) ? 'active' : ''; ?>" id="v-pills-edit-tab" data-toggle="pill" href="#v-pills-edit" role="tab" aria-controls="v-pills-edit" aria-selected="false">Edit Profile</a>
                                <a class="nav-link <?php echo ($_GET['step'] == 3) ? 'active' : ''; ?>" id="v-pills-password-tab" data-toggle="pill" href="#v-pills-password" role="tab" aria-controls="v-pills-password" aria-selected="false">Change Password</a>
                                <a class="nav-link <?php echo ($_GET['step'] == 4) ? 'active' : ''; ?>" href="<?php echo $this->request->webroot; ?>users/logout" role="tab" aria-selected="true">Logout</a>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade <?php echo ($_GET['step'] == 1) ? 'show active' : ''; ?>" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <div class="content">
                                        <img src="<?php echo $this->request->webroot; ?>images/users/<?php echo ($user->image != '') ? $user->image : 'noimage.png' ?>" class="previewHolder" style="display: block;margin: auto;" />
                                        <h4>username</h4>
                                        <h5><?php echo $user->email; ?></h5>
                                    </div>
                                    <div class="address">
                                        <h4>Address:</h4>
                                        <h5><?php echo $user->address; ?></h5>
                                    </div>
                                </div>
                                <div class="tab-pane fade <?php echo ($_GET['step'] == 2) ? 'show active' : ''; ?>" id="v-pills-edit" role="tabpanel" aria-labelledby="v-pills-home-edit">
                                    <div class="content text-center">
                                        <h4 class="mt-0">Edit Profile</h4>
                                       
                                        <form id="editpro-form" method="post" enctype="multipart/form-data">
                                            <div class="pic">
                                            	 <img src="<?php echo $this->request->webroot; ?>images/users/<?php echo ($user->image != '') ? $user->image : 'noimage.png' ?>" class="previewHolder"/>
                                             <div class="file-upload">
                                                <label for="upload" class="file-upload__label"><i class="fas fa-camera"></i></label>
                                                <input id="upload" class="file-upload__input" type="file" name="image">
                                            </div>
                                            </div>
                                             
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" id="exampleInputText5" placeholder="Name" value="<?php echo $user->name; ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" id="exampleInputText5" placeholder="Usename" value="<?php echo $user->email; ?>">
                                            </div>
                                            <div class="form-group">
                                                <textarea class="form-control" name="address" id="exampleFormControlTextarea2" rows="3" placeholder="70 Bowman St.South Windsor, CT 06074"><?php echo $user->address; ?></textarea>
                                            </div>
                                            <button type="button" class="btn theme-btn">Update</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade <?php echo ($_GET['step'] == 3) ? 'show active' : ''; ?>" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                                    <div class="content text-center">
                                        <h4 class="mt-0">Change Password</h4>
                                        <p class="mb-4 mt-3">Set a new password, Important please Log in new afterwards.</p>
                                        <p><span style="color:#000;">Email : </span><?php echo $user->email; ?></p>
                                        <form id="editcp-form" action="<?php echo $this->request->webroot ?>users/changepassword" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <input type="password" name="opassword" class="form-control" id="exampleInputPassword5" placeholder="Old Password">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="cpnpassword" class="form-control" id="cpnpassword" placeholder="New Password">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="cppassword" class="form-control" id="exampleInputPassword7" placeholder="Confirm Password">
                                            </div>
                                            <button type="submit" class="btn theme-btn">Change Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--st-about-end-->


<script>

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('.previewHolder').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#upload").change(function() {
  readURL(this);
});

var editpro_form = $("#editpro-form").validate({
	rules: {
		address: "required",
		image: {
			extension: "jpg|jpeg|png"
		}
	},
	messages: {
		address: "Please enter address",
		image: {
			extension: "Image should be in jpg, jpeg or png format"
		}
	}
});


$("#editpro-form button").click(function(){
	if(editpro_form.form()){
		$("#editpro-form").submit();
	}
});

/************ Change Password  *************/

var signup_form = $("#editcp-form").validate({
	rules: {
		opassword: "required",
		cpnpassword: {
			required: true,
			minlength: 8
		},
		cppassword: {
			required: true,
			minlength: 8,
			equalTo: "#cpnpassword"
		}
	},
	messages: {
		opassword: "Please enter old password",
		cpnpassword	: {
			required: "Please enter new password",
			minlength: "Your password must be at least 8 characters long"
		},
		cppassword: {
			required: "Please enter confirm password",
			minlength: "Your password must be at least 8 characters long",
			equalTo: "Please enter the same password as above"
		}
	}
});


$("#editpro-form button").click(function(){
	if(editpro_form.form()){
		$("#editpro-form").submit();
	}
});

</script>