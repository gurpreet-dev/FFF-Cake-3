<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if($loggeduser['image'] != ''){ ?>
            <img src="<?php echo $this->request->webroot; ?>images/users/<?php echo $loggeduser['image']; ?>" class="img-circle" />
            <?php }else{ ?>
            <img src="<?php echo $this->request->webroot; ?>images/users/noimage.png" class="img-circle" />
            <?php } ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $loggeduser['name'] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        
        <li class="active">
          <a href="<?php echo $this->request->webroot; ?>admin/dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        
        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/users">
            <i class="fa fa-user"></i> <span>Users</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        
        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/contacts">
            <i class="fa fa-phone"></i> <span>Contact Us</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        
        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/staticpages">
            <i class="fa fa-book"></i> <span>Static Pages</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/users/plans">
            <i class="fa fa-tasks"></i> <span>Subscription Plans</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/users/subscribers">
            <i class="fa fa-users"></i> <span>Subscribers</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/users/subscribers?type=sequence">
            <i class="fa fa-book"></i> <span>Add/Change Sequence</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/users/subrelorders">
            <i class="fa fa-book"></i> <span>Subscription related ordrers</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>


        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/productkey">
            <i class="fa fa-key"></i> <span>Product keys</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/users/upcomingsubscriptions">
            <i class="fa fa-calendar"></i> <span>Upcoming Subscriptions</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        
        <!--<li>
          <a href="<?php echo $this->request->webroot; ?>admin/homesections">
            <i class="fa fa-home"></i> <span>Homepage Sections</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        
        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/reviews">
            <i class="fa fa-signal"></i> <span>Review And Rating</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        
        <li>
          <a href="<?php echo $this->request->webroot; ?>admin/links">
            <i class="fa fa-link"></i> <span>Social Links</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>