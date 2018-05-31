<section class="content-header">
    <h1>
    ASIN keys
    <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit ASIN keys</li>
    </ol>
</section>

<section class="content">
  <div class="row">
        <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit ASIN keys</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?= $this->Form->create($productkey, ['id' => 'page-form', 'enctype' => 'multipart/form-data']) ?>
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Title</label>
                  <?php echo $this->Form->control('title', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Key</label>
                  <?php echo $this->Form->control('key', ['class' => 'form-control', 'label' => false]); ?>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Description</label>
                  <?php echo $this->Form->control('content', ['type' => 'textarea', 'class' => 'form-control', 'label' => false]); ?>
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
  $("#page-form").validate({
    rules: {
      title: "required",
      key: "required"
      content: "required"
    },
    messages: {
      title: "Please enter Title",
      key: "Please enter Key",
      content: "Please enter Description"  
    }
  });
});
</script>      