<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Plan Management
    </h1>
  </section>
  <div class="tab-content">
    <div class="tab-pane <?php echo $view == 0 ? 'active' : '' ?>" id="list_plan">
      <section class="content">
        <div class="row">
          <div class="col-xs-12 text-right">
            <div class="form-group">
              <a class="btn btn-primary" href="#add_new_plan" data-toggle="tab"><i class="fa fa-plus"></i> Add New</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Plan List</h3>
                <div class="box-tools">
                  <form action="<?php echo base_url() ?>plan/index" method="POST" id="searchList">
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
                    <th>No</th>
                    <th>Title</th>
                    <th>Customer</th>
                    <th class="text-center">Actions</th>
                  </tr>
                  <?php
                  if(!empty($records))
                  {
                    foreach($records as $index=>$record)
                    {
                  ?>
                  <tr>
                    <td><?php echo $index + 1 ?></td>
                    <td><?php echo $record->title ?></td>
                    <td><?php echo $record->name ?></td>
                    <td class="text-center">
                      <a class="btn btn-sm btn-info" href="<?php echo base_url().'plan/edit/'.$record->id; ?>"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-sm btn-danger deleteItem" href="#" data-itemid="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                  <?php
                    }
                  } else {
                    echo '<tr><td colspan="10" class="text-center"><i>No Plan<i></td></tr>';
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

    <div class="tab-pane <?php echo $view == 1 ? 'active' : '' ?>" id="add_new_plan">
      <section class="content">
        <div class="row">
          <div class="col-xs-12 text-right">
            <div class="form-group">
              <a class="btn btn-primary" href="#list_plan" data-toggle="tab"><i class="fa fa-list"></i> View Plans</a>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Enter Details</h3>
              </div>
              <form role="form" id="addPlan" action="<?php echo base_url() ?>plan/create" method="post" role="form">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Title</label>
                        <input type="text" class="form-control required" id="title" name="title" maxlength="128">
                        <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $userId; ?>">
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
                            <option value="<?php echo $customer->id ?>"><?php echo $customer->name ?></option>
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
          <div class="col-md-4" hidden>
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
            var addPlanForm = $("#addPlan");
            var validator = addPlanForm.validate({
              rules:{
                title :{ required : true },
                customerId : { required : true, selected : true }
              },
              messages:{
                title :{ required : "This field is required" },
                customerId : { required : "This field is required", selected : "Please select atleast one option" }
              }
            });
          });

          jQuery(document).on("click", ".deleteItem", function(){
            var itemId = $(this).data("itemid"),
              hitURL = baseURL + "plan/delete",
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
