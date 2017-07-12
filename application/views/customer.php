<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Customer Management
    </h1>
  </section>
  <div class="tab-content">
    <div class="tab-pane <?php echo $view == 0 ? 'active' : '' ?>" id="list_customer">
      <section class="content">
        <div class="row">
          <div class="col-xs-12 text-right">
            <div class="form-group">
              <a class="btn btn-primary" href="#add_new_customer" data-toggle="tab"><i class="fa fa-plus"></i> Add New</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Customer List</h3>
                <div class="box-tools">
                  <form action="<?php echo base_url() ?>customer/index" method="POST" id="searchList">
                    <div class="input-group">
                      <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                </div>
              </div><!-- /.box-header -->
              <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                  <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Card Number</th>
                    <th>Expire Date</th>
                    <th>Card Code</th>
                    <th class="text-center">Actions</th>
                  </tr>
                  <?php
                  if(!empty($records))
                  {
                    foreach($records as $index=>$record)
                    {
                  ?>
                  <tr>
                    <td onclick="" width="50px">
                      <a class="btn btn-sm btn-info" href="<?php echo base_url().'customer/view/'.$record->id; ?>"><i class="fa fa-eye"></i></a>
                    </td>
                    <td><?php echo $record->name ?></td>
                    <td><?php echo $record->email ?></td>
                    <td><?php echo $record->cardNumber ?></td>
                    <td><?php echo $record->expireDate ?></td>
                    <td><?php echo $record->cardCode ?></td>
                    <td class="text-center">
                      <a class="btn btn-sm btn-info" href="<?php echo base_url().'customer/edit/'.$record->id; ?>"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-sm btn-danger deleteItem" href="#" data-itemid="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  <?php
                    }
                  } else {
                    echo '<tr><td colspan="10" class="text-center"><i>No Customer<i></td></tr>';
                  }
                  ?>
                </table>
              </div><!-- /.box-body -->
              <div class="box-footer clearfix">
                <?php echo $this->pagination->create_links(); ?>
              </div>
            </div><!-- /.box -->
          </div>
        </div>
      </section>
    </div>

    <div class="tab-pane <?php echo $view == 1 ? 'active' : '' ?>" id="add_new_customer">
      <section class="content">
        <div class="row">
          <div class="col-xs-12 text-right">
            <div class="form-group">
              <a class="btn btn-primary" href="#list_customer" data-toggle="tab"><i class="fa fa-list"></i> View Customers</a>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Enter Details</h3>
              </div>
              <form role="form" id="addCustomer" action="<?php echo base_url() ?>customer/create" method="post" role="form">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Full Name</label>
                        <input type="text" class="form-control required" id="name" name="name" maxlength="128">
                        <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $userId; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Email Address</label>
                        <input type="text" class="form-control required email" id="email"  name="email" maxlength="128">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Card Number</label>
                        <input type="text" class="form-control required" id="cardNumber" name="cardNumber" maxlength="20">
                      </div>
                    </div>
                    <div class="col-md-3">                                
                      <div class="form-group">
                        <label for="fname">Expire Date</label>
                        <input type="text" class="form-control required" id="expireDate" name="expireDate" maxlength="4">
                      </div>
                    </div>
                    <div class="col-md-3">                                
                      <div class="form-group">
                        <label for="fname">Card Code</label>
                        <input type="text" class="form-control required" id="cardCode" name="cardCode" maxlength="4">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Company</label>
                        <input type="text" class="form-control" id="company" name="company" maxlength="30">
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Address</label>
                        <input type="text" class="form-control" id="address" name="address" maxlength="130">
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">City</label>
                        <input type="text" class="form-control" id="city" name="city" maxlength="30">
                      </div>
                    </div>
                    <div class="col-md-3">                                
                      <div class="form-group">
                        <label for="fname">State</label>
                        <input type="text" class="form-control" id="state" name="state" maxlength="5">
                      </div>
                    </div>
                    <div class="col-md-3">                                
                      <div class="form-group">
                        <label for="fname">Zip Code</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" maxlength="11">
                      </div>
                    </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Country</label>
                        <input type="text" class="form-control" id="country" name="country" maxlength="30">
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
            var addCustomerForm = $("#addCustomer");
            var validator = addCustomerForm.validate({
              rules:{
                name :{ required : true },
                email : { required : true, email : true, remote : { url : baseURL + "customer/checkEmail", type :"post"} },
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

          jQuery(document).on("click", ".deleteItem", function(){
            var itemId = $(this).data("itemid"),
              hitURL = baseURL + "customer/delete",
              currentRow = $(this);
            var confirmation = confirm("Are you sure to delete this item ?");
            if(confirmation)
            {
              jQuery.ajax({
              type : "POST",
              dataType : "json",
              url : hitURL,
              data : { itemId : itemId } 
              }).done(function(data){
                console.log(data);
                if(data.status == true) {
                  console.log("Successfully deleted");
                  currentRow.parents('tr').remove();
                }
                else { alert("Deletion failed"); }
              });
            }
          });
        </script>    
      </section>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
