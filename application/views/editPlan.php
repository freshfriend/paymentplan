<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Plan Management
    </h1>
  </section>
  <div class="tab-content">
    <div class="tab-pane active" id="edit_plan">
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Edit Details</h3>
              </div>
              <form role="form" id="editPlan" action="<?php echo base_url() ?>plan/update" method="post" role="form">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Title</label>
                        <input type="text" class="form-control required" id="title" name="title" value="<?php echo $param->title; ?>" maxlength="128">
                        <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $param->userId; ?>">
                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $param->id; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Select Customer</label>
                        <select class="form-control required" id="customerId" name="customerId">
                          <option value="0">Customer *</option>
                          <?php
                            if(!empty($customers)) {
                              foreach ($customers as $customer) {
                          ?>
                            <option value="<?php echo $customer->id ?>" <?php echo $param->customerId == $customer->id ? 'selected' : '' ?>><?php echo $customer->name ?></option>
                          <?php
                              }
                            }
                          ?>
                        </select>
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
            var editPlanForm = $("#editPlan");
            var validator = editPlanForm.validate({
              rules:{
                title :{ required : true },
                customerId : { required : true },
              },
              messages:{
                title :{ required : "This field is required" },
                customerId : { required : "This field is required" },
              }
            });
          });
        </script>    
      </section>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
