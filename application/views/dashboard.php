<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Payment Plan</small>
      </h1>
    </section>
    
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- info box -->
          <div class="info-box bg-aqua" href="#tab1" data-toggle="tab">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Customers (<?php echo $customerCount; ?>)</span>
              <span class="info-box-number"><?php echo $newCustomerCount; ?> <i>(new)</i></span>

              <div class="progress">
                <div class="progress-bar" style="width: <?php echo $newCustomerRate; ?>%"></div>
              </div>
              <span class="progress-description">
                <?php echo $newCustomerRate; ?>% Increase in last month
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- info box -->
          <div class="info-box bg-green" href="#tab2" data-toggle="tab">
            <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Active Plans (<?php echo $planCount; ?>)</span>
              <span class="info-box-number"><?php echo $activePlanCount; ?> <i>(active)</i></span>

              <div class="progress">
                <div class="progress-bar" style="width: <?php echo $activePlanRate; ?>%"></div>
              </div>
              <span class="progress-description">
                <?php echo $activePlanRate; ?>% Increase in last month
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- info box -->
          <div class="info-box bg-yellow" href="#tab3" data-toggle="tab">
            <span class="info-box-icon"><i class="fa fa-files-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Complete Plans (<?php echo $planCount; ?>)</span>
              <span class="info-box-number"><?php echo $completePlanCount; ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: <?php echo $completePlanRate; ?>%"></div>
              </div>
              <span class="progress-description">
                <?php echo $completePlanRate; ?>% Increase in last month
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- info box -->
          <div class="info-box bg-red" href="#tab4" data-toggle="tab">
            <span class="info-box-icon"><i class="fa fa-envelope-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Report</span>
              <span class="info-box-number"><?php echo $outdatedPlanCount; ?></span>

              <div class="progress">
                <div class="progress-bar" style="width: <?php echo $outdatedPlanRate; ?>%"></div>
              </div>
              <span class="progress-description">
                <?php echo $outdatedPlanRate; ?>% Increase in last month
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div><!-- ./col -->
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="tab-pane active" id="tab1">
                <a href="<?php echo base_url(); ?>userListing" class="more-info float-right">
                  View All <i class="fa fa-arrow-circle-right"></i>
                </a>
                <h1>
                  <i class="fa fa-users"></i> New Customers
                  <small>(<?php echo $newCustomerCount; ?>)</small>
                </h1>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th hidden>Role</th>
                      <th hidden class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($newCustomers))
                    {
                      foreach($newCustomers as $i=>$record)
                      {
                    ?>
                    <tr onclick="window.location='<?php echo base_url().'viewUser/'.$record->userId; ?>'">
                      <td><?php echo $i + 1/*$record->userId*/ ?></td>
                      <td><?php echo $record->name ?></td>
                      <td><?php echo $record->email ?></td>
                      <td><?php echo $record->mobile ?></td>
                      <td hidden><?php echo $record->role ?></td>
                      <td hidden class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editOld/'.$record->userId; ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->userId; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php
                      }
                    } else {
                      echo '<td colspan="10">No New Customers</td>';
                    }
                    ?>
                  </table>
                </div><!-- /.box-body -->
              </div>
              <div class="tab-pane" id="tab2">
                <a href="<?php echo base_url(); ?>planListing" class="more-info float-right">
                  View All <i class="fa fa-arrow-circle-right"></i>
                </a>
                <h1>
                  <i class="fa fa-calendar"></i> Active Plans
                  <small>(<?php echo $activePlanCount; ?>)</small>
                </h1>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Id</th>
                      <th>Title</th>
                      <th hidden>Summary</th>
                      <th>Amount</th>
                      <th>Pay Date</th>
                      <th hidden>Status</th>
                      <th>Customer</th>
                      <th hidden class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($activePlans))
                    {
                      foreach($activePlans as $i=>$record)
                      {
                    ?>
                    <tr onclick="window.location='<?php echo base_url().'viewPlan/'.$record->planId; ?>'">
                      <td><?php echo $i + 1/*$record->planId*/ ?></td>
                      <td><?php echo $record->title ?></td>
                      <td hidden><?php echo $record->summary ?></td>
                      <td><?php echo $record->amount ?></td>
                      <td>
                        <?php
                          $ret = '<div class="btn btn-sm btn-';
                          $timeNow = date('Y-m-d');
                          $strState = array('Pending', 'info');
                          if ($record->status == 2)
                            $strState = array('Completed', 'success');
                          else if ($timeNow > $record->payDate)
                            $strState = array('Out Dated', 'danger');
                          else if ($timeNow == $record->payDate)
                            $strState = array('Today', 'warning');
                          $ret .= $strState[1] . ' opacity-full" disabled>' . $strState[0] . '</div>';
                          echo $ret;
                          //echo $record->payDate . $timeNow;
                        ?>
                      </td>
                      <td hidden><?php echo $record->status ?></td>
                      <td><?php echo $record->name ?></td>
                      <td hidden class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editPlan/'.$record->planId; ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deletePlan" href="#" data-planid="<?php echo $record->planId; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php
                      }
                    } else {
                      echo '<td colspan="10">No Active Plans</td>';
                    }
                    ?>
                  </table>
                </div><!-- /.box-body -->
              </div>
              <div class="tab-pane" id="tab3">
                <a href="<?php echo base_url(); ?>planListing" class="more-info float-right">
                  View All <i class="fa fa-arrow-circle-right"></i>
                </a>
                <h1>
                  <i class="fa fa-calendar"></i> Complete Plans
                  <small>(<?php echo $completePlanCount; ?>)</small>
                </h1>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Id</th>
                      <th>Title</th>
                      <th hidden>Summary</th>
                      <th>Amount</th>
                      <th>Pay Date</th>
                      <th hidden>Status</th>
                      <th>Customer</th>
                      <th hidden class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($completePlans))
                    {
                      foreach($completePlans as $i=>$record)
                      {
                    ?>
                    <tr onclick="window.location='<?php echo base_url().'viewPlan/'.$record->planId; ?>'">
                      <td><?php echo $i + 1/*$record->planId*/ ?></td>
                      <td><?php echo $record->title ?></td>
                      <td hidden><?php echo $record->summary ?></td>
                      <td><?php echo $record->amount ?></td>
                      <td>
                        <?php
                          $ret = '<div class="btn btn-sm btn-';
                          $timeNow = date('Y-m-d');
                          $strState = array('Pending', 'info');
                          if ($record->status == 2)
                            $strState = array('Completed', 'success');
                          else if ($timeNow > $record->payDate)
                            $strState = array('Out Dated', 'danger');
                          else if ($timeNow == $record->payDate)
                            $strState = array('Today', 'warning');
                          $ret .= $strState[1] . ' opacity-full" disabled>' . $strState[0] . '</div>';
                          echo $ret;
                          //echo $record->payDate . $timeNow;
                        ?>
                      </td>
                      <td hidden><?php echo $record->status ?></td>
                      <td><?php echo $record->name ?></td>
                      <td hidden class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editPlan/'.$record->planId; ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deletePlan" href="#" data-planid="<?php echo $record->planId; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php
                      }
                    } else {
                      echo '<td colspan="10">No Complete Plans</td>';
                    }
                    ?>
                  </table>
                </div><!-- /.box-body -->
              </div>
              <div class="tab-pane" id="tab4">
                <a href="<?php echo base_url(); ?>planListing" class="more-info float-right">
                  View All <i class="fa fa-arrow-circle-right"></i>
                </a>
                <h1>
                  <i class="fa fa-calendar"></i> Outdated Plans
                  <small>(<?php echo $outdatedPlanCount; ?>)</small>
                </h1>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Id</th>
                      <th>Title</th>
                      <th hidden>Summary</th>
                      <th>Amount</th>
                      <th>Pay Date</th>
                      <th hidden>Status</th>
                      <th>Customer</th>
                      <th hidden class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($outdatedPlans))
                    {
                      $timeNow = date('Y-m-d');
                      foreach($outdatedPlans as $i=>$record)
                      {
                    ?>
                    <tr onclick="window.location='<?php echo base_url().'viewPlan/'.$record->planId; ?>'">
                      <td><?php echo $i + 1/*$record->planId*/ ?></td>
                      <td><?php echo $record->title ?></td>
                      <td hidden><?php echo $record->summary ?></td>
                      <td><?php echo $record->amount ?></td>
                      <td>
                        <?php
                          $ret = '<div class="btn btn-sm btn-';
                          $timeNow = date('Y-m-d');
                          $strState = array('Pending', 'info');
                          if ($record->status == 2)
                            $strState = array('Completed', 'success');
                          else if ($timeNow > $record->payDate)
                            $strState = array('Out Dated', 'danger');
                          else if ($timeNow == $record->payDate)
                            $strState = array('Today', 'warning');
                          $ret .= $strState[1] . ' opacity-full" disabled>' . $strState[0] . '</div>';
                          echo $ret;
                          //echo $record->payDate . $timeNow;
                        ?>
                      </td>
                      <td hidden><?php echo $record->status ?></td>
                      <td><?php echo $record->name ?></td>
                      <td hidden class="text-center">
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editPlan/'.$record->planId; ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deletePlan" href="#" data-planid="<?php echo $record->planId; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php
                      }
                    } else {
                      echo '<td colspan="10">No Active Plans</td>';
                    }
                    ?>
                  </table>
                </div><!-- /.box-body -->
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
      </div>
    </section>
</div>