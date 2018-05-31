<section class="content-header">
    <h1>
    <?= __('Subscription related orders') ?>
    <small></small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Subscription related orders') ?></li>
    </ol> -->
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
        
        <?= $this->Flash->render() ?>
        <?php //echo '<pre>'; print_r($subscribers); echo '</pre>'; ?>
        <div class="box">
            <!--<div class="box-header">
              <h3 class="box-title">Hover Data Table</h3>
            </div>-->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th><?= __('Book Due On') ?></th>
                  <th><?= __('Email') ?></th>
                  <th><?= __('Next Book') ?></th>
                  <th><?= __('Address') ?></th>
                  <th><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($subscribers as $subscriber): ?>
                <tr>
                  <td><?= h($subscriber->due_date) ?></td>
                  <td><?= h($subscriber->email) ?></td>
                  <td><?php 
                  if($subscriber->books_sequence != ''){
                  echo $subscriber->next_book['Title'];
                  }else{
                    echo '<span class="label label-warning">No sequence selected</span>';
                    } ?></td>
                  <td><?= h($subscriber->address) ?></td>
                  <td>
                  <a href="http://www.amazon.com/gp/aws/cart/add.html?AssociateTag=mostlydev04-20&ASIN.1=<?php echo $subscriber->next_book['ASIN']; ?>&Quantity.1=1" target="_blank" class="btn btn-xs btn-info" <?php echo ($subscriber->books_sequence == '') ? 'disabled' : ''; ?>>Create Order</a>

                  <?php if(isset($_GET['type']) && $_GET['type'] == 'sequence'){

                      echo $this->Html->link(
                        'Create Order',
                        ['action' => 'createorder', $subscriber->next_book['key']],
                        ['escape' => false, 'title' => __('Create Order'), 'class' => 'btn btn-info btn-xs']
                      );

                    } ?>
                    <button type="button" class="btn btn-xs btn-success mc" data-key="<?php echo $subscriber->next_book['ASIN']; ?>" data-userid="<?php echo $subscriber->id; ?>" data-date="<?php echo $subscriber->due_date; ?>"  data-title="<?php echo $subscriber->next_book['Title']; ?>">Mark Complete</button>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        
        
        
        </div>
    </div>
</section>  


<!-- Modal -->
<div id="mcModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <form action="<?php echo $this->request->webroot ?>admin/users/createorder" method="post" id="mc-frm">
      <div class="modal-body">
          <div class="form-group">
            <label for="email">Amazon Order Number:</label>
            <input type="text" name="amazon_order_number" class="form-control" id="email">
          </div>
          <div class="form-group">
            <label for="pwd">Amazon Tracking Number:</label>
            <input type="text" name="amazon_tracking_number" class="form-control" id="pwd">
          </div>
          <input type="hidden" name="key">
          <input type="hidden" name="user_id">
          <input type="hidden" name="date">
          <input type="hidden" name="title">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success mc-sub">Submit</button>
      </div>
      </form>
    </div>

  </div>
</div>    

<script>
  
$(".mc").click(function(){
  var user_id = $(this).attr('data-userid');
  var title = $(this).attr('data-title');
  var ASIN  = $(this).attr('data-key');
  var date  = $(this).attr('data-date');

  $("input[name='key']").val(ASIN);
  $("input[name='user_id']").val(user_id);
  $("input[name='date']").val(date);
  $("input[name='title']").val(title);

  $('#mcModal').modal();

});

var mc_form = $("#mc-frm").validate({
  rules: {
    amazon_order_number: "required",
    amazon_tracking_number: "required"
  },
  messages: {
    amazon_order_number: "Please enter amazon order number",
    amazon_tracking_number : "Please enter amazon tracking number"
  }
});

$(document).delegate('.mc-sub', 'click', function(){

  if(mc_form.form()){
    $("#mc-frm").submit();
  }

});

</script> 