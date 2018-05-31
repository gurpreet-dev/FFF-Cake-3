<section class="content-header">
    <h1>
    Product ASIN  <?= $this->Html->link(__('Add Product ASIN'), ['action' => 'add'], ['class' => 'btn btn-warning']) ?>
    <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Product Key</li>
    </ol>
</section>

<section class="content">
	<div class="row">
        <div class="col-xs-12">
        
        <?= $this->Flash->render() ?>
        
        <div class="box">
            <!--<div class="box-header">
              <h3 class="box-title">Hover Data Table</h3>
            </div>-->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Asin</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($productkey as $key): ?>
                <tr>
                  <td><?php echo $key['id']; ?></td>
                  <td><?php echo $key['title']; ?></td>
                  <td><?php echo $key['key']; ?></td>
                  <td>
                    
                    <?= $this->Html->link(
                        '<span class="fa fa-pencil"></span><span class="sr-only">' . __('Edit') . '</span>',
                        ['action' => 'edit', $key['id']],
                        ['escape' => false, 'title' => __('Edit'), 'class' => 'btn btn-success']
                    ) ?>
                    <a href="<?php echo $this->request->webroot; ?>admin/productkey/delete/<?php echo $key['id']; ?>" class="btn btn-danger" onclick="if (confirm('Are you sure you want to delete this file?')) { return true; } return false;"><span class="fa fa-trash"></span></a>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Asin</th>
                  <th>Actions</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        
        
        
        </div>
    </div>
</section>       