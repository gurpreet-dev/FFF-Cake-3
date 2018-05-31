<section class="content-header">
    <h1>
    <?php echo $this->Html->link(ucwords($user->name), ['controller' => 'users', 'action' => 'view', $user->id]).'\'s sequence'; ?>
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
        <div class="col-xs-12">
        
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
                  <?php if(in_array($product['Product']['Identifiers']['MarketplaceASIN']['ASIN'], $selected)){ ?>
                  	<input type="checkbox" name="keys[]" data-title="<?php echo $product['Product']['AttributeSets']['ItemAttributes']['Title']; ?>" value="<?php echo $product['Product']['Identifiers']['MarketplaceASIN']['ASIN']; ?>" checked>
                    <?php }else{ ?>
                    <input type="checkbox" name="keys[]" data-title="<?php echo $product['Product']['AttributeSets']['ItemAttributes']['Title']; ?>" value="<?php echo $product['Product']['Identifiers']['MarketplaceASIN']['ASIN']; ?>">
                     <?php } ?>
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
            <div class="box-footer">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-success']) ?>
              </div>
          </div>
        
        </div>


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

/*********************/

var limit = '<?php echo $user->duration ?>';

$("#example2 input[type=checkbox]").click(function(){

  var check = $('#example2 input[type=checkbox]:checked').length;

    if(check >= limit){
        $('#example2 input[type=checkbox]:not(:checked)').attr('disabled', 'disabled');
    }else{
        $('#example2 input[type=checkbox]').removeAttr('disabled');
    }

});

/************************/

$(document).ready(function(){

  var numberOfCheckboxesSelected = $('#example2 input[type=checkbox]:checked').length;

  if(numberOfCheckboxesSelected >= limit){
    $('#example2 input[type=checkbox]:not(:checked)').attr('disabled', 'disabled');
  }else{
      $('#example2 input[type=checkbox]').removeAttr('disabled');
  }

});

</script>      