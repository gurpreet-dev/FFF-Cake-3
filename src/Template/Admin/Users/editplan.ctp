<?php
/**
  * @var \App\View\AppView $this
  */
?>

<section class="content-header">
    <h1>
    <?= __('Plans') ?>
    <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= __('Edit Plan') ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= __('Edit Plan') ?></h3>
                <?= $this->Form->create($plan, ['id' => 'location-form', 'enctype' => 'multipart/form-data']) ?>
                
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?= __('Title') ?></label>
                        <?php echo $this->Form->control('title', ['class' => 'form-control', 'label' => false]); ?>
                    </div>
                </div> 
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Price</label>
                        <?php echo $this->Form->control('price', ['class' => 'form-control', 'label' => false]); ?>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Duration</label>
                        <?php echo $this->Form->control('duration', ['type' => 'number', 'class' => 'form-control', 'label' => false]); ?>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Content</label>
                        <?php echo $this->Form->control('content', ['class' => 'form-control', 'label' => false]); ?>
                    </div>
                </div>  
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
    $("#location-form").validate({
        rules: {
            title: "required",
            content: "required",
            duration: "required",
            price: {
                required: true,
                number: true
            }
        },
        messages: {
            title: "Please fill this field",
            content: "Please fill this field",
            duration: "Please fill this field",
            price: {
                required: "Please fill this field",
                number: "Please enter valid price"
            }
        }
    });
});
</script>             