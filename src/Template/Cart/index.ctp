<section class="st-about">
    <div class="container">
    	<div class="text-center">
    		<h1 class="theme-heading">Cart</h1>
    	</div>
    </div>
	<div class="overlay"></div>
</section><!-- End Here -->
<section class="cart_sec">
	<div class="container">
		<div class="row">
			<div id="no-more-tables" style="flex:0 0 100%; max-width:100%; margin-bottom:25px;">
				<?php //echo '<pre>'; print_r($cartdata); echo "</pre>"; ?>
				<?php if(!empty($cartdata)){ ?>
				<table class="col-md-12 table-bordered table-striped table-condensed cf">
					<thead>
						<tr>
							<th class="numeric"><h6>Product</h6></th>
							<th class="numeric"><h6>&nbsp;</h6></th>
							<th class="numeric"><h6>Quantity</h6></th>
							<th class="numeric"><h6>Price</h6></th>
							<th class="numeric"><h6>Total</h6></th>
							<th class="numeric"><h6>Action</h6></th>
						</tr>
					</thead><!-- Table Header Section End Here -->
					<tbody>

						<?php
						$subtotal = 0;
						$total = 0;
						?>
						<?php foreach($cartdata as $cart){ ?>
						<tr id="<?php echo $cart['asin']; ?>">
							<td data-title="Product"><img src="<?php echo $cart['image']; ?>" alt="<?php echo $cart['title']; ?>"></td>
							<td data-title="&nbsp;"><h6><?php echo $cart['title']; ?></h6><!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p> --></td>
							<td data-title="Quantity"><input type="number" min = '1' class="form-control upqty" placeholder="<?php echo $cart['qty']; ?>" data-asin = "<?php echo $cart['asin']; ?>" value="<?php echo $cart['qty']; ?>"></td>
							<td data-title="Price"><h6>$<?php echo $cart['price']; ?></h6></td>
							<td data-title="Total"><h6 class="price">$<?php echo $cart['price'] * $cart['qty']; ?></h6></td>
							<td data-title="Action"><a href="<?php echo $this->request->webroot ?>cart/remove/<?php echo $cart['asin']; ?>" class="btn btn-primary">Remove</a></td>
						</tr>
						<?php
						$subtotal = $subtotal + $cart['price'];
						$total = $total + ($cart['price'] * $cart['qty']);
						?>
						<?php } ?>
						
					</tbody>
				</table>
				<?php }else{ ?>
					<div class="col-md-12">
						<div class="cart-img-sec" style="text-align:center;">
							<img src="<?php echo $this->request->webroot; ?>images/website/empty_cart.png" style="max-width:100%;" alt="Empty Cart">
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section><!-- End Here -->
<section class="coupen-total">
	<div class="container">
		<div class="row">
		<?php if(!empty($cartdata)){ ?>
			<div class="col-sm-12 col-md-6">
				<!-- <div class="coupen-sec">
					<h3>Coupon</h3>
					<p>Enter your coupon code if you have one.</p>
					<input type="text" class="form-control" name="fn" value="" placeholder="Coupon Code">
					<input type="submit" class="btn btn-primary" value="Apply Coupon">
				</div> -->
			</div>
			<div class="col-sm-12 col-md-6">
				<div class="total">
					<h3>Subtotal</h3>
					<table class="table">
						<tbody>
							<tr><th>Subtotal</th><td>$<?php echo $subtotal; ?></td></tr>
							<tr><th>Total</th><td id="total_price">$<?php echo $total; ?></td></tr>
						</tbody>
					</table>
					<div class="checkout-btn">

					<?php
					$url = 'http://www.amazon.com/gp/aws/cart/add.html?AssociateTag=mostlydev04-20';

					$i = 1;
					foreach($cartdata as $cart){
					    $url .= '&ASIN.'.$i.'='.$cart["asin"];
					    $url .= '&Quantity.'.$i.'='.$cart['qty'];

					    $i++;
					}
					?>

						<a href="<?php echo $url; ?>">Proceed Checkout</a>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section><!-- End Here -->

<script>
$(".upqty").bind('keyup mouseup', function(){

	var asin = $(this).attr('data-asin');
	var qty = $(this).val();

	$.post('<?php echo $this->request->webroot ?>cart/update/'+asin+'/'+qty, function(data, status){
        data = JSON.parse(data);
        console.log(data);

        $("#"+asin+" .price").html('$'+data.product_price);

        $("#total_price").html('$'+data.total_price);

        $(".checkout-btn").load(location.href+" .checkout-btn>*","");

    });

});
</script>