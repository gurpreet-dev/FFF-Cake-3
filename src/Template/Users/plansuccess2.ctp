<section class="st-thank">
	<?php if($_GET['res'] == 'success'){ ?>
	<div class="my-5">
		 <div class="text-center">
			 <h1 class="theme-heading mb-2">Thank You!</h1>
			 <p class="d-block text-dark" style="font-size:20px;">Your payment was received.</p>
		 </div>
		<div class="container">
			<div class="row">
				<div class="col-sm-8 m-auto">
					<div class="check mt-4">
					<img src="<?php echo $this->request->webroot ?>images/website/success.png" />	
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }else{ ?>
	<div class="my-5">
		 <div class="text-center">
			 <h1 class="theme-heading mb-2">Sorry!</h1>
			 <p class="d-block text-dark" style="font-size:20px;">Payment Unsuccessfull.</p>
		 </div>
		<div class="container">
			<div class="row">
				<div class="col-sm-8 m-auto">
					<div class="check mt-4">
					<img src="<?php echo $this->request->webroot ?>images/website/imgpsh_fullsize.png" />	
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
</section><!--st-subscription-end-->