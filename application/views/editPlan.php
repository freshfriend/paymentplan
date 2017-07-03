<?php

$planId = '';
$userId = '';
$title = '';
$summary = '';
$amount = '';
$payDate = '';
$status = '';
$username = '';

if(!empty($planInfo))
{
    foreach ($planInfo as $ph)
    {
        $planId = $ph->planId;
        $userId = $ph->userId;
        $title = $ph->title;
        $summary = $ph->summary;
        $amount = $ph->amount;
        $payDate = $ph->payDate;
        $status = $ph->status;
        $username = $ph->name;
    }
}


?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if ($mode == 0) { ?>
            <i class="fa fa-ticket"></i> Plan Management
            <small>Add / Edit Plan</small>
        <?php } else { ?>
            <i class="fa fa-ticket"></i> Plan Detail
            <small>View Plan</small>
        <?php } ?>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                
                <?php if ($mode == 0) { ?>
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Plan Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>onEditPlan" method="post" id="editPlan">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label>Customer - <?php echo $username; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="<?php echo $title; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $planId; ?>" name="planId" id="planId" />
                                        <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="summary">Summary</label>
                                        <textarea type="text" class="form-control" id="summary" placeholder="Summary" name="summary" value="<?php echo $summary; ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" placeholder="Amount" id="amount" name="amount" value="<?php echo $amount; ?>" maxlength="11">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payDate">Pay Date</label>
                                        <input type="date" class="form-control" id="payDate" name="payDate" value="<?php echo $payDate; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Select Status</label>
                                        <select class="form-control required" id="status" name="status">
                                            <option value="1" <?php echo ($status == 1)?'selected':'' ?>>Active</option>
                                            <option value="2" <?php echo ($status == 2)?'selected':'' ?>>Complete</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                            <input type="button" class="btn btn-warning float-right" value="Return to Listing" onclick="document.location='<?php echo base_url().'planListing/'; ?>'" />
                        </div>
                    </form>
                </div>
                <?php } else { ?>
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Plan Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label>Customer - <?php echo $username; ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input disabled type="text" class="form-control" id="title" placeholder="Title" name="title" value="<?php echo $title; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $planId; ?>" name="planId" id="planId" />
                                        <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="summary">Summary</label>
                                        <textarea disabled type="text" class="form-control" id="summary" placeholder="Summary" name="summary" value="<?php echo $summary; ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input disabled type="number" class="form-control" placeholder="Amount" id="amount" name="amount" value="<?php echo $amount; ?>" maxlength="11">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payDate">Pay Date</label>
                                        <input disabled type="date" class="form-control" id="payDate" name="payDate" value="<?php echo $payDate; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label>Customer - <?php echo $username; ?></label>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <a type="button" class="btn btn-primary" href="<?php echo base_url().'editPlan/'.$planId; ?>"/>Edit</a>
                            <input type="button" class="btn btn-warning float-right" value="Return to Listing" onclick="document.location='<?php echo base_url().'planListing/'; ?>'" />
                        </div>
                    </form>
                </div>
                <?php } ?>
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
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>