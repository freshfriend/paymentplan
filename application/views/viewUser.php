<?php

$userId = '';
$name = '';
$email = '';
$mobile = '';
$roleId = '';

if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId = $uf->userId;
        $name = $uf->name;
        $email = $uf->email;
        $mobile = $uf->mobile;
        $roleId = $uf->roleId;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Customer Detail
        <small>Plan / Paid / Remaining</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">

            <div class="col-md-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#plans" data-toggle="tab" aria-expanded="true">Payment Plans</a></li>
                  <li class=""><a href="#status" data-toggle="tab" aria-expanded="false">Status</a></li>
                  <li class=""><a href="#profile" data-toggle="tab" aria-expanded="false">Profile</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="plans">
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                          <table class="table table-hover">
                            <tr>
                              <th>Id</th>
                              <th>Title</th>
                              <th hidden>Summary</th>
                              <th>Amount</th>
                              <th>Pay Date</th>
                              <th hidden>Status</th>
                              <th hidden>Customer</th>
                              <th class="text-center">Actions</th>
                            </tr>
                            <?php
                            if(!empty($customerPlans))
                            {
                                foreach($customerPlans as $i=>$record)
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
                              <td hidden><?php echo $record->name ?></td>
                              <td class="text-center">
                                  <a class="btn btn-sm btn-info" href="<?php echo base_url().'editPlan/'.$record->planId; ?>"><i class="fa fa-pencil"></i></a>
                                  <a class="btn btn-sm btn-danger deletePlan" href="#" data-planid="<?php echo $record->planId; ?>"><i class="fa fa-trash"></i></a>
                              </td>
                            </tr>
                            <?php
                                }
                            } else {
                              echo '<td colspan="10">No Plans</td>';
                            }
                            ?>
                          </table>
                          
                        </div><!-- /.box-body -->
                      </div><!-- /.box -->
                  </div>
                  <div class="tab-pane" id="status">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label>Total Paid</label>
                                        <label type="text" class="form-control"><?php echo $status['totalPaid']; ?></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total Plan</label>
                                        <label type="text" class="form-control"><?php echo $status['totalPlan']; ?></label>
                                        <label type="text" class="form-control"><?php echo $status['remaining']; ?> plan(s) remaining</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="profile">
                    <div class="box box-primary">
                        <form role="form" action="<?php echo base_url() ?>editUser" method="post" id="editUser" role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-6">                                
                                        <div class="form-group">
                                            <label for="fname">Full Name</label>
                                            <label type="text" class="form-control"><?php echo $name; ?></label>
                                            <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />    
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <label type="text" class="form-control"><?php echo $email; ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="mobile">Mobile Number</label>
                                            <label type="text" class="form-control"><?php echo $mobile; ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6" hidden>
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select class="form-control" id="role" name="role">
                                                <option value="0">Select Role</option>
                                                <?php
                                                if(!empty($roles))
                                                {
                                                    foreach ($roles as $rl)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>    
                                </div>
                            </div><!-- /.box-body -->
        
                            <div class="box-footer">
                                <a type="button" class="btn btn-primary" href="<?php echo base_url().'editOld/'.$userId; ?>"/>Edit</a>
                                <input type="button" class="btn btn-warning float-right" value="Return to Listing" onclick="document.location='<?php echo base_url().'userListing/'; ?>'" />
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php
                        $this->load->helper('form');
                        $error = $this->session->flashdata('error');
                        if($error)
                        {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('error'); ?>                    
                    </div>
                    <?php } ?>
                    <?php  
                        $success = $this->session->flashdata('success');
                        if($success)
                        {
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                    <?php } ?>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>