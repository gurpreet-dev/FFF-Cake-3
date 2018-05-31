<section class="content-header">
    <h1>
    <?php echo $this->Html->link(ucwords($user->name), ['controller' => 'users', 'action' => 'view', $user->id]).'\'s orders'; ?>
    <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('All Products') ?></li>
    </ol>
</section>

<section class="content">
<?= $this->Form->create($user, ['id' => 'record-form', 'enctype' => 'multipart/form-data']) ?>
    <div class="row">
        <?php /* ?><div class="col-xs-6">
        
        <?= $this->Flash->render() ?>
        
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Books</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th><?= __('') ?></th>
                  <th><?= __('Image') ?></th>
                  <th><?= __('Name') ?></th>
                  <th><?= __('Status') ?></th>
                  <th><?= __('Price') ?></th>
                </tr>
                </thead>
                <tbody>
               	<?php foreach($products['GetMatchingProductResult'] as $product){ ?>
				<?php if($product['@attributes']['status'] == 'Success'){ ?>
                <tr>
                  <td>
                  	<input type="radio" name="key" data-title="<?php echo $product['Product']['AttributeSets']['ItemAttributes']['Title']; ?>" value="<?php echo $product['Product']['Identifiers']['MarketplaceASIN']['ASIN']; ?>" required>
                  </td>
                  <td>
                  	
					<img class="custom-image" src="<?php echo $product['Product']['AttributeSets']['ItemAttributes']['SmallImage']['URL']; ?>" >

                  </td>
                  <td><?=  $product['Product']['AttributeSets']['ItemAttributes']['Title']; ?></td>
                  <td>
                  <?php if(in_array($product['Product']['Identifiers']['MarketplaceASIN']['ASIN'], $orderkeys)){ ?>
                  <span class="label label-success">Ordered</span>
                  <?php } ?>
                  </td>
                  <td>
                  	<?php if(isset($product['Product']['AttributeSets']['ItemAttributes']['ListPrice']['Amount'])){ ?>
					<?php echo $product['Product']['AttributeSets']['ItemAttributes']['ListPrice']['Amount']; ?> <?php echo $product['Product']['AttributeSets']['ItemAttributes']['ListPrice']['CurrencyCode']; ?>
					<?php } ?>
                  </td>
                </tr>
                <?php } ?>
                <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        
        
        
        </div><?php */ ?>


        <!-- Second -->

        <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Orders</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="userorders" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th><?= __('ID') ?></th>
                  <th><?= __('Product Key') ?></th>
                  <th><?= __('Product Title') ?></th>
                  <th><?= __('Date') ?></th>
                </tr>
                </thead>
                <tbody>
               	<?php foreach($orders as $order){ ?>
                <tr>
                  <td><?=  $order['id']; ?></td>
                  <td><?=  $order['key']; ?></td>
                  <td><?=  $order['title']; ?></td>
                  <td><?=  date('d M, Y', strtotime($order['date'])); ?></td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div> 


          <?php /* ?><div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Record</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">

            	<input type="hidden" name="title">
                <div class="form-group">
                  <label for="exampleInputEmail1">Date</label>
                  <?php echo $this->Form->control('date', ['id' => 'datepicker', 'class' => 'form-control', 'label' => false, 'required']); ?>
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
              </div>
            
          </div><?php */ ?>


        </div>
        <!-- Second (END) -->

    </div>
    <?= $this->Form->end() ?>
</section>  

<script>
$(document).ready(function(){
	$('#userorders').DataTable({
		'paging'      : true,
		'lengthChange': false,
		'searching'   : true,
		'ordering'    : false,
		'info'        : true,
		'autoWidth'   : false,
		'order'		  : [[ 1, "desc" ]],
		"pageLength": 2
	});
});

$().ready(function() {
	$("#record-form").validate();
});

$('#datepicker').datepicker({
  autoclose: true,
  format: 'dd-mm-yyyy'
});

$("input[name='key']").change(function(){ // bind a function to the change event
    if( $(this).is(":checked") ){ // check if the radio is checked
        var title = $(this).attr('data-title'); // retrieve the value
        
        $("input[name='title']").val(title);

    }
});

</script>      