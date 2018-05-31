<style>
	.table tbody tr:first-child td {
    	border: 0 !important;
	}
</style>
<section class="st-about">
    <div class="container">
    	<div class="text-center">
    		<h1 class="theme-heading">Subscription</h1>
    	</div>
    </div>
	<div class="overlay"></div>
</section>
<section class="st-subscription">
	<div class="container">
		<div class="row">
        	<div class="col-md-8 col-sm-8">
            	<div class="img_wraper">
                	<img src="<?php echo $this->request->webroot;  ?>images/website/about1.png" alt="About" />
                </div>
            </div><!-- End Here -->
			<div class="col-sm-4 col-sm-4">
				<div class="inner-profile">
					<div class="card-deck mb-3">

					<?php foreach($plans as $plan){ ?>

						<div class="card mb-4 box-shadow">
						  <div class="card-header text-center" style="background-color:#f2f2f2; min-height:195px; margin-bottom:0px; padding-bottom:50px;">
							<h4 class="my-0 font-weight-normal"><?php echo $plan->title; ?></h4>
						  </div>
						  <div class="card-body" style="background-color:#f2f2f2;">
							<h1 class="card-title pricing-card-title">$<?php echo $plan->price; ?></h1>
							<p class="list-unstyled mt-3 mb-4" style="font-family:'Roboto', sans-serif;">
							  <?php echo $plan->content; ?>
							</p>

							<?php /*if($loggeduser){ ?>
							<button type="button" class="btn btn-lg btn-block text-white  plan-po <?php echo $plan->class; ?>" data-id="<?php echo $plan->id; ?>">Subscribe</button>
							<?php }else{ ?>
							<button type="button" data-toggle="modal" data-target="#Login" class="btn btn-lg btn-block text-white <?php echo $plan->class; ?>">Subscribe</button>
							 
							<?php }*/ ?>

							<button type="button" class="btn btn-lg btn-block plan-po" data-id="<?php echo $plan->id; ?>">Start Now for $<?php echo $plan->price; ?></button>
						  </div>
						</div>
					<?php } ?>
						
						
					  </div>

					  <div class="w-100"></div>
				</div>
			</div>
		</div>
	</div>
</section><!--st-subscription-end-->

<!-- The Modal -->
<div class="modal fade" id="planmodal">
  <div class="modal-dialog">
    <div class="modal-content" style="border: 0px;">

      <!-- Modal Header -->
      <div class="modal-header bg-success text-white">
        <h4 class="modal-title">Subscription Plan Details</h4>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Modal body..
      </div>


    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="planmodal1">
  <div class="modal-dialog">
    <div class="modal-content" style="border: 0px;">

      <!-- Modal Header -->
      <div class="modal-header bg-success text-white">
        <h4 class="modal-title">Subscription Plan Details</h4>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
      	<div class="details"></div>
        <div class="form">
	        <form action="" method="post" id="subscr-frm">
			<div class="alert-box"></div>
			<div class="form-group" style="margin-top:20px;">
			<input type="text" placeholder="Enter Name" name="name" class="form-control" id="email" required>
			</div>
			<div class="form-group">
			<input type="email" placeholder="Enter Email" name="email" class="form-control" id="pwd" required>
			</div>
			<div class="form-group">
			<textarea class="form-control" placeholder="Enter Address" name="address" required></textarea>
			</div>


			<button type="button" id="subpay" class="btn btn lg bg-success text-light float-right mt-3" data-id="">Pay with Credit Card</button>
			</form>
        </div>
      </div>


    </div>
  </div>
</div>


<script>
	
	$(".plan-po").click(function(){
		var id = $(this).attr('data-id');

		$("#subscr-frm button").attr('data-id', id);

		$.post("<?php echo $this->request->webroot ?>users/ajaxgetplan/"+id, function(data, status){
	        
	        data = JSON.parse(data);

	        var html = ''
	   			html+= '<table class="table">';
				html+= '<tbody>';
				html+= '<tr><td>Duration</td><td>'+data.duration+' Months</td></tr>';
				html+= '<tr><td>Price</td><td>$'+data.price+'</td></tr>';
				html+= '</tbody>';
				html+= '</table>';

				html+= '<ul class="list-group">';
				html+= '<li class="list-group-item">You will get 1 book per month for '+data.duration+' months.</li>';
				html+= '</ul>';


				var logged = '<?php echo $loggedin ?>';

				if(logged == 1){
					html+= '<a href="<?php echo $this->request->webroot ?>users/stripe/'+data.id+'"/<?php echo $loggeduser["id"] ?>" class="btn btn lg bg-success text-light float-right mt-3">Pay with Credit Card</a>';
				}	


			if(logged == 0){	
				$("#planmodal1 .modal-body .details").html(html);
				$("#planmodal1").modal();	
			}else{
				$("#planmodal .modal-body").html(html);
				$("#planmodal").modal();	
			}
			
			

	    });

	});


var subscr_form = $("#subscr-frm").validate({
  rules: {
    name: "required",
    email: {
    	required: true,
    	email: true
    },
    address: "required"
  },
  messages: {
    name: "Please enter name",
    email : {
    	required: "Please enter Email Ddress",
    	email: "Please enter valid email"
  	},
  	address: "Please enter valid email address"
  }
});

$(document).delegate('#subscr-frm button', 'click', function(){

  if(subscr_form.form()){

  	var id = $(this).attr('data-id');

    $.ajax({
		url: '<?php echo $this->request->webroot ?>users/addguest/'+id,
		data: $('#subscr-frm').serialize(),
		method: 'post',
		dataType: 'json',
		beforeSend: function(){
			var info_html = '<div class="alert alert-info"><strong>Please Wait...</strong></div>';
			$('#subscr-frm .alert-box').html(info_html).css('display', 'block');
		},
		success: function (response) {

			if(response){
				if(response.isSucess == 'true'){
					window.location.href = '<?php echo $this->request->webroot ?>'+response.url;
				}else{
					$('#subscr-frm .alert-box').html(response.msg);
				}
			}
		}
	});
  }

});

</script>