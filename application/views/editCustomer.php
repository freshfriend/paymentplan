<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Customer Management
    </h1>
  </section>
  <div class="tab-content">
    <div class="tab-pane active" id="edit_customer">
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Edit Details</h3>
              </div>
              <form role="form" id="editCustomer" action="<?php echo base_url() ?>customer/update" method="post" role="form">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Full Name</label>
                        <input type="text" class="form-control required" id="name" name="name" value="<?php echo $param->name; ?>" maxlength="128">
                        <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $param->userId; ?>">
                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $param->id; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Email Address</label>
                        <input type="text" class="form-control required email" id="email" name="email" value="<?php echo $param->email; ?>" maxlength="128">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Card Number</label>
                        <input type="text" class="form-control required" id="cardNumber" name="cardNumber" value="<?php echo $param->cardNumber; ?>" maxlength="20">
                      </div>
                    </div>
                    <div class="col-md-3">                                
                      <div class="form-group">
                        <label for="fname">Expire Date</label>
                        <input type="text" class="form-control required" id="expireDate" name="expireDate" value="<?php echo $param->expireDate; ?>" maxlength="4">
                      </div>
                    </div>
                    <div class="col-md-3">                                
                      <div class="form-group">
                        <label for="fname">Card Code</label>
                        <input type="text" class="form-control required" id="cardCode" name="cardCode" value="<?php echo $param->cardCode; ?>" maxlength="4">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Company</label>
                        <input type="text" class="form-control" id="company" name="company" value="<?php echo $param->company; ?>" maxlength="30">
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $param->address; ?>" maxlength="130">
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo $param->city; ?>" maxlength="30">
                      </div>
                    </div>
                    <div class="col-md-3">                                
                      <div class="form-group">
                        <label for="fname">State</label>
                        <input type="text" class="form-control" id="state" name="state" value="<?php echo $param->state; ?>" maxlength="5">
                      </div>
                    </div>
                    <div class="col-md-3">                                
                      <div class="form-group">
                        <label for="fname">Zip Code</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo $param->zipcode; ?>" maxlength="11">
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Country</label>
                        <input type="text" class="form-control" id="country" name="country" value="<?php echo $param->country; ?>" maxlength="30">
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
            var editCustomerForm = $("#editCustomer");
            var validator = editCustomerForm.validate({
              rules:{
                name :{ required : true },
                email : { required : true, email : true, remote : { url : baseURL + "customer/checkEmail", type :"post", data : { userId : function(){ return $("#userId").val(); } } } },
                cardNumber :{ required : true },
                expireDate :{ required : true },
                cardCode :{ required : true },
              },
              messages:{
                name :{ required : "This field is required" },
                email : { required : "This field is required", email : "Please enter valid email address", remote : "Email already taken" },
                cardNumber :{ required : "This field is required" },
                expireDate :{ required : "This field is required" },
                cardCode :{ required : "This field is required" },
              }
            });
          });
        </script>    
      </section>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
