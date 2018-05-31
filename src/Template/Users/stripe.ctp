 <section class="payment-car">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-4 m-auto">
					<div class="inner-sec">
					<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
					<div class="payment-errors"></div>
					<form action="" method="POST" id="payment-form">
						<div class="form-row">
							<label>Card Number</label>
							<input type="text" size="20" autocomplete="off" class="card-number" />
						</div>
						<div class="form-row">
							<label>CVC</label>
							<input type="text" size="4" autocomplete="off" class="card-cvc" />
						</div>
						<div class="form-row">
							<label>Expiration (MM/YYYY)</label>
							<input type="text" size="2" class="card-expiry-month" placeholder="MM" />
							
							<input type="text" size="4" class="card-expiry-year" placeholder="YYYY" />
						</div>
						<button type="submit" class="btn btn-primary submit-button">Submit Payment</button>
					</form>

					 <script type="text/javascript">
						// this identifies your website in the createToken call below
						Stripe.setPublishableKey('pk_test_mhT7sj4ZEAn46Vo6FgxnltSJ');
						function stripeResponseHandler(status, response) {
							if (response.error) {
								// re-enable the submit button
								$('.submit-button').removeAttr("disabled");
								// show the errors on the form
								$(".payment-errors").html('<div class="pay-error">'+response.error.message+'</div>');
							} else {
								var form$ = $("#payment-form");
								// token contains id, last4, and card type
								var token = response['id'];
								// insert the token into the form so it gets submitted to the server
								form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
								// and submit
								form$.get(0).submit();
							}
						}
						$(document).ready(function() {
							$("#payment-form").submit(function(event) {
								// disable the submit button to prevent repeated clicks
								$('.submit-button').attr("disabled", "disabled");
								// createToken returns immediately - the supplied callback submits the form if there are no errors
								Stripe.createToken({
									number: $('.card-number').val(),
									cvc: $('.card-cvc').val(),
									exp_month: $('.card-expiry-month').val(),
									exp_year: $('.card-expiry-year').val()
								}, stripeResponseHandler);
								return false; // submit from callback
							});
						});
					</script>
					</div>
				</div>
			</div>
		</div>
	</div>
 </section><!-- End Here -->