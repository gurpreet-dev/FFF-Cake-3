<section class="st-about st-contact">
              <div class="container">
                    <div class="text-center">
                            <h1 class="theme-heading">contact us</h1>
                    </div>
                </div>
          
            <div class="overlay"></div>
    </section><!--st-about-end-->
        
        <section class="st-read st-company st-form">
          <div class="container">
                <div class="row">
                  
                    <div class="col-sm-7">
                    <?= $this->Flash->render() ?>
                      <div class="read_content">
                          <form action="" method="post" class="wpcf7-form" id="contact-form">
                <div class="form-row">
                <div class="form-group col-md-6">
                  <input type="text" name="name" class="form-control" id="inputText1" placeholder="Name">
                </div>
                <div class="form-group col-md-6">
                  <input type="email" name="email" class="form-control" id="inputEmail1" placeholder="Email">
                </div>
                </div>
                <div class="form-group">
                <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="8" placeholder="Message"></textarea>
                </div>
               
                <button type="submit" class="btn theme-btn float-right">Send Message</button>
              </form>
                        </div>
                    </div>
          
          <div class="col-sm-5">
                      <div class="read_pic">
                          <img class="custom-image" src="<?php echo $this->request->webroot ?>images/website/contact1.png" />
                        </div>
                    </div>
          
          <div class="col-sm-12">
            <div id="map"></div>
          </div>
          
          
                </div>
           </div>
        </section><!--st-read-end-->

<script>
$().ready(function() {
  $("#contact-form").validate({
    rules: {
      name: "required",
      message: "required",
      email: {
        required: true,
        email: true
      }
    },
    messages: {
      name: "Please enter your name",
      email: "Please enter a valid email address",
      message: "Please enter your message"
    }
  });
});

</script>            