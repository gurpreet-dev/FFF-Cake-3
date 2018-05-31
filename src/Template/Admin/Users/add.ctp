<section class="content-header">
    <h1>
    Users
    <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add User</li>
    </ol>
</section>

<section class="content">
	<div class="row">
        <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Form->create($user, ['id' => 'user-form', 'enctype' => 'multipart/form-data']) ?>
              <div class="box-body">
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <?php echo $this->Form->control('name', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <?php echo $this->Form->control('email', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Address</label>
                  <?php echo $this->Form->control('address', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <?php echo $this->Form->control('password1', ['label' => false, 'class' => 'form-control', 'type' => 'password']); ?>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Confirm Password</label>
                  <?php echo $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'type' => 'password']); ?>
                </div>     
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
              </div>
            <?= $this->Form->end() ?>
          </div>
        </div>
    </div>
</section> 

<script>
$().ready(function() {
	$("#user-form").validate({
		rules: {
			name: "required",
			email: {
				required: true,
				email: true
			},
      address: "required",
			password1: {
        required: true,
        minlength: 8
      },
			password: {
        required: true,
        minlength: 8,
        equalTo: "#password1"
      }
		},
		messages: {
			name: "Please enter your name",
			email: "Please enter a valid email address",
      address: "Please enter address",
			password1 : {
        required: "Please provide a password",
        minlength: "Your password must be at least 8 characters long"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 8 characters long",
        equalTo: "Password entered in both fields does not match"
      }
		}
	});
});

$('#datepicker').datepicker({
  autoclose: true
})
</script>      

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.1.6/tinymce.min.js"></script>
<script>
tinymce.init({
selector: 'textarea',
plugins: [
"code", "charmap", "link"
],
toolbar: [
"undo redo | styleselect | bold italic | link | alignleft aligncenter alignright | charmap code" | "media"
]
});
</script>