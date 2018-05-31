<section class="st-banner">
        	<div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot;  ?>images/website/slider1.jpg">
            	<div class="container">
                	<div class="row">
                    	<div class="col-sm-6">
                        	<div class="carousel-content">
                                <h3>Welcome To</h3>
                                <h2>Friendly Fables</h2>
<!--                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.<br> Lorem Ipsum has been the industry's standard dummy text ever </p>-->
						</div>
                        </div>
                      
                      <div class="col-sm-6">
                      	<div class="family">
                   <img src="<?php echo $this->request->webroot;  ?>images/website/Family.png" />
                        </div>
                      </div>
                        
                    </div>
                    
                    
                    
                </div>
            </div>
            <div class="overlay"></div>
			
			<div class="slider-strip">
				<img src="<?php echo $this->request->webroot;  ?>images/website/curvy_shadow.svg" />
			</div>
        </section><!--st-banner-end-->
        
        <section class="st-read">
        	<div class="container">
                <div class="row">
                	<div class="col-sm-6">
                    	<div class="read_pic">
                        	<img class="custom-image" src="<?php echo $this->request->webroot;  ?>images/website/read.jpg" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                    	<div class="read_content">
                        	<h1 class="theme-heading">lorem ipsum</h1>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
                            <a href="#" class="theme-btn">Read More</a>
                        </div>
                    </div>
                </div>
           </div>
        </section><!--st-read-end-->
        
        
        <section class="st-books">
			<h1 class="theme-heading text-center">Our Books</h1>
			<div class="container">
                <div class="row">
<?php //echo '<pre>'; print_r($products); echo '</pre>'; ?>
					<?php foreach($products['GetMatchingProductResult'] as $product){ ?>
					<?php if($product['@attributes']['status'] == 'Success'){ ?>
					<div class="col-sm-3">
						<a href="https://www.amazon.ca/dp/<?php echo $product['Product']['Identifiers']['MarketplaceASIN']['ASIN']; ?>" target="_blank">
						<div class="book-outer">
							<div class="book-pic">

								<?php
								$img_url = $product['Product']['AttributeSets']['ItemAttributes']['SmallImage']['URL'];
								if (strpos($img_url, 'SL75') !== false) { ?>
								<img class="custom-image" src="<?php echo str_replace('SL75', 'SL1500', $img_url); ?>" />
								<?php    
								}else{ ?>
								<img class="custom-image" src="<?php echo $img_url; ?>" />
								<?php
								}
								?>
								
							</div>
							<div class="book-content">
								<h4><?php echo $product['Product']['AttributeSets']['ItemAttributes']['Title']; ?></h4>
								<?php if(isset($product['Product']['AttributeSets']['ItemAttributes']['ListPrice']['Amount'])){ ?>
								<h5><b><?php echo $product['Product']['AttributeSets']['ItemAttributes']['ListPrice']['Amount']; ?> <?php echo $product['Product']['AttributeSets']['ItemAttributes']['ListPrice']['CurrencyCode']; ?></b></h5>

								<?php }else{ ?>
								<h5><b>$ 12.50</b></h5>
								<?php } ?>
							</div>
						</div>
						</a>
						<div class="btn-sec" style="text-align:center; margin-bottom:20px;">						
							<button style="border:none; cursor:pointer;" type="button" id="<?php echo $product['Product']['Identifiers']['MarketplaceASIN']['ASIN'] ?>" class="theme-btn" onclick="addtocart('<?php echo $product['Product']['Identifiers']['MarketplaceASIN']['ASIN'] ?>', '1', '<?php echo str_replace('SL75', 'SL1500', $img_url); ?>', '<?php echo addslashes($product['Product']['AttributeSets']['ItemAttributes']['Title']); ?>');">Add to cart</button>
						</div>
					</div>
					<?php } ?>
					<?php } ?>
					
				</div>
			</div>
		</section><!--st-books-end-->
        
        <section class="st-gift">
			<div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot;  ?>images/website/slider2.jpg">
				<div class="container">
                	<div class="row">
                    	<div class="col-12 col-sm-12 col-md-6">
                        	<div class="carousel-content">
                                <h2>Give the gift of reading</h2>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.<br> Lorem Ipsum has been the industry's standard dummy text ever </p>
								<a href="<?php echo $this->request->webroot;  ?>users/plans">Start Now <span>>></span></a>
						</div>
                        </div>
						<div class="col-12 col-sm-12 col-md-6 align-self-center">
							<div class="service">
								<ul class="m-0 p-0">
								<li><div><p>one book each month</p></div></li>
								<li><div><p>small monthly cost</p></div></li>
								<li><div><p>wonderful gift for your child</p></div></li>
							</ul>
							</div>
						</div>
                    </div>
                </div>
			</div>
			 <div class="overlay"></div>
<!-- 			<div class="slider-strip">
				<img src="<?php echo $this->request->webroot;  ?>images/website/curvy_shadow.svg" />
			</div> -->
		</section><!--st-gift-end-->
		
        
		<!--<section class="st-bios">
			<div class="container">
                <div class="row">
				
                    <div class="col-sm-6">
						<div class="card">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="bios-pic">
                                            <img class="custom-image" class="img img-raised" src="<?php echo $this->request->webroot;  ?>images/website/s1.jpg">
                                        </div>
                                    </div>
                                    <div class="col-md-7 pl-0">
                                        <div class="content p-3">
											<h3 class="mb-1">Myrtles Big Race</h3>
											<p>
												Myrtle the Turtle loves to run! But can she win the big race and still have fun? Meet Myrtle and all her friends as they discover something more important than winning.
											</p>
										</div>
                                        </div>
                                </div>
                            </div>
					</div>
					
					<div class="col-sm-6">
						<div class="card">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="bios-pic">
                                            <img class="custom-image" class="img img-raised" src="<?php echo $this->request->webroot;  ?>images/website/s2.jpg">
                                        </div>
                                    </div>
                                    <div class="col-md-7 pl-0">
                                        <div class="content p-3">
											<h3 class="mb-1">Daizy Monster</h3>
											<p>
												Myrtle the Turtle loves to run! But can she win the big race and still have fun? Meet Myrtle and all her friends as they discover something more important than winning...
											</p>
										</div>
                                        </div>
                                </div>
                            </div>
					</div>
					<div class="col-sm-6">
						<div class="card">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="bios-pic">
                                            <img class="custom-image" class="img img-raised" src="<?php echo $this->request->webroot;  ?>images/website/s3.jpg">
                                        </div>
                                    </div>
                                    <div class="col-md-7 pl-0">
                                        <div class="content p-3">
											<h3 class="mb-1">Daizy Monster</h3>
											<p>
												Myrtle the Turtle loves to run! But can she win the big race and still have fun? Meet Myrtle and all her friends as they discover something more important than winning...
											</p>
										</div>
                                        </div>
                                </div>
                            </div>
					</div>
					
					<div class="col-sm-6">
						<div class="card">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="bios-pic">
                                            <img class="custom-image" class="img img-raised" src="<?php echo $this->request->webroot;  ?>images/website/s4.jpg">
                                        </div>
                                    </div>
                                    <div class="col-md-7 pl-0">
                                        <div class="content p-3">
											<h3 class="mb-1">Myrtles Big Race</h3>
											<p>
												Myrtle the Turtle loves to run! But can she win the big race and still have fun? Meet Myrtle and all her friends as they discover something more important than winning.
											</p>
										</div>
                                        </div>
                                </div>
                            </div>
					</div>
						<a href="#" class="theme-btn m-auto">view all</a>
				</div>
           
			</div>
			
		</section>-->
        
        <!--st-bios-end-->
        
        
        
        
        <section class="st-slides">
			<div class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot;  ?>images/website/slider3.jpg">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<div id="carouselExampleIndicators" class="carousel slide" data-ride="">
							  <div class="carousel-inner">
							  	<?php $i = 1; ?>
							  	<?php foreach($products['GetMatchingProductResult'] as $product){ ?>
								<?php if($product['@attributes']['status'] == 'Success'){ ?>
								<div class="carousel-item <?php echo ($i == 1) ? 'active' : ''; ?>">
								  <div class="row">
										<div class="col-sm-4">
											<div class="read_pic">
											<?php
											$img_url = $product['Product']['AttributeSets']['ItemAttributes']['SmallImage']['URL'];
											if (strpos($img_url, 'SL75') !== false) { ?>
											<img class="custom-image" src="<?php echo str_replace('SL75', 'SL1500', $img_url); ?>" />
											<?php    
											}else{ ?>
											<img class="custom-image" src="<?php echo $img_url; ?>" />
											<?php
											}
											?>
											</div>
										</div>
										<div class="col-sm-8 align-self-center">
											<div class="read_content">
												<h1 class="theme-heading"><?php echo $product['Product']['AttributeSets']['ItemAttributes']['Title']; ?></h1>
												<p><?php //echo $product['Product']['AttributeSets']['ItemAttributes']['Title']; ?>
													<?php
													if($product['description'] != ''){
														echo $product['description'];
													}else{
														echo $product['Product']['AttributeSets']['ItemAttributes']['Title'];
													}
													?>
												</p>
												<a href="https://www.amazon.ca/dp/<?php echo $product['Product']['Identifiers']['MarketplaceASIN']['ASIN']; ?>" target="_blank" class="theme-btn">buy now</a>
											</div>
										</div>
									</div>
								</div>
								<?php $i++; ?>
								<?php } ?>
								<?php } ?>
								
							  </div>
							  <a class="carousel-control-prev arw" href="#carouselExampleIndicators" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							  </a>
							  <a class="carousel-control-next arw" href="#carouselExampleIndicators" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							  </a>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</section> <!--st-slides-end-->

<script>
function addtocart(asin, quantity, image, title){

    $.ajax({
    	url: '<?php echo $this->request->webroot ?>cart/add',
    	data: {
    		asin: asin,
    		quantity: quantity,
    		image: image,
    		title: title
    	},
    	method: 'post',
    	dataType: 'text',
    	success: function(res){

       		$(".head-cart span").text(res);

       		$("#"+asin).html('<i class="fa fa-check"></i> Added');

       		setTimeout(function(){ $("#"+asin).html('Add to cart'); }, 3000);
       	}
    })



}
</script>		