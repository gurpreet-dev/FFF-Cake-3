<section class="content-header">
    <h1>
    <?= __('Plans') ?>  <?php //echo $this->Html->link(__('Add Plan'), ['action' => 'addplan'], ['class' => 'btn btn-warning']); ?>
    <small></small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Plans') ?></li>
    </ol> -->
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
                  <th><?= __('ID') ?></th>
                  <th><?= __('Title') ?></th>
                  <th><?= __('Price') ?></th>
                  <th><?= __('Content') ?></th>
                  <th><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($plans as $plan): ?>
                <tr>
                  <td><?= $this->Number->format($plan->id) ?></td>
                  <td><?= h($plan->title) ?></td>
                  <td><?= h('$'.$plan->price) ?></td>
                  <td><?= h($plan->content) ?></td>
                  <td>
                    <?= $this->Html->link(
                        '<span class="fa fa-pencil"></span><span class="sr-only">' . __('Edit') . '</span>',
                        ['action' => 'editplan', $plan->id],
                        ['escape' => false, 'title' => __('Edit'), 'class' => 'btn btn-success']
                    ) ?>
                    <!-- <a href="<?php echo $this->request->webroot; ?>admin/users/deleteplan/<?php echo $plan->id; ?>" class="btn btn-danger" onclick="if (confirm('Are you sure you want to delete this plan?')) { return true; } return false;"><span class="fa fa-trash"></span></a> -->
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