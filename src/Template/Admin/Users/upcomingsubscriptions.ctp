<section class="content-header">
    <h1>
    Upcoming Subscriptions 
    <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Upcoming Subscriptions</li>
    </ol>
</section>

<section class="content">
	<div class="row">
        <div class="col-xs-12">
        
        <?php echo $this->Flash->render(); ?>
        
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
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subscribe Date</th>
                  <th>Monthly Date</th>
                  <th>Days Left</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                  <td><?php echo $user['id']; ?></td>
                  <td><?php echo $user['name']; ?></td>
                  <td><?php echo $user['email']; ?></td>
                  <td><?php echo date("d M, Y", strtotime($user['from'])); ?></td>
                  <td><?php echo '<span class="label label-success">'.date("d M, Y", ($user['final'])).'</span>'; ?></td>
                  <td>
                  <?php
                  $date1 = new DateTime();  //current date or any date
                  $date2 = new DateTime(date("d M, Y", ($user['final'])));   //Future date
                  $diff = $date2->diff($date1)->format("%a");  //find difference
                  $days = intval($diff);   //rounding days
                  echo $days;
                  ?>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Subscribe Date</th>
                  <th>Monthly Date</th>
                  <th>Days Left</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        
        
        
        </div>
    </div>
</section>       