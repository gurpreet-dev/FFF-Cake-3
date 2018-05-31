<section class="content-header">
    <h1>
    Locations
    <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
        
        
        <div class="box">
  <div class="box-header">
    <h3 class="box-title"><?= h($location->title_en) ?></h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body no-padding">
    <table class="table table-condensed">
      <tbody>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($location->id) ?></td>
        </tr>
        <tr>
          <th><?= __('Title (English)') ?></th>
          <td><?= h($location->name_en) ?></td>
        </tr>
        <tr>
          <th><?= __('Title (Arabic)') ?></th>
          <td><?= h($location->name_ar) ?></td>
        </tr>
        <tr>
          <th><?= __('Created') ?></th>
          <td><?= h($location->created) ?></td>
        </tr>
        <tr>
          <th><?= __('Modified') ?></th>
          <td><?= h($location->modified) ?></td>
        </tr>

      </tbody>
    </table>
  </div>
  <!-- /.box-body -->
</div>

        
        
        
        </div>
    </div>
</section>       