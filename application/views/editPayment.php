<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Payment Management
    </h1>
  </section>
  <div class="tab-content">
    <div class="tab-pane active" id="edit_payment">
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Edit Details</h3>
              </div>
              <form role="form" id="editPayment" action="<?php echo base_url() ?>payment/update" method="post" role="form">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="planId">Select Plan</label>
                        <select class="form-control required" id="planId" name="planId">
                          <option value="0">Plan *</option>
                          <?php
                            if(!empty($plans)) {
                              foreach ($plans as $plan) {
                          ?>
                            <option value="<?php echo $plan->id ?>" <?php echo $param->planId == $plan->id ? 'selected' : '' ?>><?php echo $plan->title ?></option>
                          <?php
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="status">Select Status</label>
                        <select class="form-control required" id="status" name="status" disabled>
                          <option value="0" <?php echo $param->status == 0 ? 'selected' : '' ?>>Pending</option>
                          <option value="1" <?php echo $param->status == 1 ? 'selected' : '' ?>>Success</option>
                          <option value="2" <?php echo $param->status == 2 ? 'selected' : '' ?>>Failed</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="dueDate">Pay Date</label>
                        <input type="date" class="form-control required date" id="dueDate" name="dueDate" value="<?php echo $param->dueDate; ?>">
                        <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $userId; ?>">
                        <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $param->userId; ?>">
                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $param->id; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control required number" id="amount" name="amount" value="<?php echo $param->amount; ?>" maxlength="11">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box-footer">
                  <input type="submit" class="btn btn-primary" value="Submit" />
                  <input type="reset" class="btn btn-default" value="Reset" />
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-4">
            <?php
              $this->load->helper('form');
              $error = $this->session->flashdata('error');
              if($error) {
            ?>
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <?php echo $this->session->flashdata('error'); ?>                    
            </div>
            <?php
              }  
              $success = $this->session->flashdata('success');
              if($success) {
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
        <script type="text/javascript">
          $(document).ready(function(){
            var addPaymentForm = $("#addPayment");
            var validator = addPaymentForm.validate({
              rules:{
                dueDate :{ required : true, date : true },
                amount :{ required : true, number : true, min : 0.1 },
                planId : { required : true, selected : true }
              },
              messages:{
                dueDate : { required : "This field is required", date : "Pay Date can't be past" },
                amount : { required : "This field is required", number : "Please enter numbers only", min : "Amount is too low" },
                planId : { required : "This field is required", selected : "Please select atleast one option" }
              }
            });
          });
        </script>    
      </section>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
