<section class="content-header">
    <h1>
    <?= __('Subscribers') ?> <?php echo (isset($_GET['type']) && $_GET['type'] == 'sequence') ? '(Add/Change sequence)' : ''; ?> <?php //echo $this->Html->link(__('Add Plan'), ['action' => 'addplan'], ['class' => 'btn btn-warning']); ?>
    <small></small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i><?= __('Dashboard') ?></a></li>
        <li class="active"><?= __('Subscribers') ?></li>
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
                  <th><?= __('Name') ?></th>
                  <th><?= __('Subscription Date') ?></th>
                  <th><?= __('Duration') ?></th>
                  <th><?= __('Expiry Date') ?></th>
                  <th><?= __('Price') ?></th>
                  <th><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($subscribers as $subscriber): ?>
                <tr>
                  <td><?= $this->Number->format($subscriber->id) ?></td>
                  <td><?= $this->Html->link(ucwords($subscriber->name), ['controller' => 'users', 'action' => 'view', $subscriber->id]) ?></td>
                  <td><?= h($subscriber->from) ?></td>
                  <td><?= h($subscriber->duration).' Months' ?></td>
                  <td><?= h($subscriber->to) ?></td>
                  <td><?php echo '$'.$subscriber->price; ?></td>
                  <td>
                  <?= $this->Html->link(
                        'Order Status',
                        ['action' => 'orders', $subscriber['id']],
                        ['escape' => false, 'title' => __('Order Status'), 'class' => 'btn btn-warning btn-xs']
                  ) ?>

                  <?php if(isset($_GET['type']) && $_GET['type'] == 'sequence'){

                      echo $this->Html->link(
                        'Change Books Sequence',
                        ['action' => 'changesequence', $subscriber['id']],
                        ['escape' => false, 'title' => __('Order Status'), 'class' => 'btn btn-info btn-xs']
                      );

                    } ?>
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