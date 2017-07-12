<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Customer : <?php echo $customer->name ?>
    </h1>
  </section>
  <div class="tab-content">
    <div class="tab-pane <?php echo $view == 0 ? 'active' : '' ?>" id="list_plan">
      <section class="content">
        <div class="row">
          <div class="col-xs-12 text-right">
            <div class="form-group">
              <a class="btn btn-primary" href="#add_new_plan" data-toggle="tab"><i class="fa fa-plus"></i> Add New Plan</a>
              <select class="btn col-md-3 valid" aria-required="true" aria-invalid="false" onchange="window.location='<?php echo base_url() ?>customer/view/<?php echo $customer->id ?>/'+this.value">
                <option value="1" <?php echo $mode == 1 ? 'selected' : '' ?>>Summary</option>
                <option value="2" <?php echo $mode == 2 ? 'selected' : '' ?>>Declined</option>
                <option value="3" <?php echo $mode == 3 ? 'selected' : '' ?>>Billed</option>
                <option value="4" <?php echo $mode == 4 ? 'selected' : '' ?>>Future Payments</option>
              </select>
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
                <?php
                  if ($mode == 1) {
                ?>
                <table class="table table-hover">
                  <tr>
                    <th>No</th>
                    <th>Plan Name</th>
                    <th>Customer</th>
                    <th>Total Amount</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Remaining<br>Payments</th>
                    <th class="text-center">View<br>Detail</th>
                  </tr>
                  <?php
                  if(!empty($plans))
                  {
                    foreach($plans as $index=>$record)
                    {
                  ?>
                  <tr>
                    <td><?php echo $index + 1 ?></td>
                    <td><?php echo $record->title ?></td>
                    <td><?php echo $record->name ?></td>
                    <td><?php echo $summaries[$index]['totalAmount'] ?></td>
                    <td><?php echo $summaries[$index]['paid'] ?></td>
                    <td><?php echo $summaries[$index]['due'] ?></td>
                    <td><?php echo $summaries[$index]['remainingPayments'] ?></td>
                    <td class="text-center">
                      <a class="btn btn-sm btn-info" href="<?php echo base_url().'customer/viewPlan/'.$record->id; ?>"><i class="fa fa-eye"></i></a>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td><b>TOTAL</b></td>
                    <td><b><?php echo $total['totalAmount'] ?></b></td>
                    <td><b><?php echo $total['paid'] ?></b></td>
                    <td><b><?php echo $total['due'] ?></b></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <?php
                  } else {
                    echo '<tr><td colspan="10" class="text-center"><i>No Plan<i></td></tr>';
                  }
                  ?>
                </table>
                <?php
                  } else if ($mode == 2) {
                ?>
                <table class="table table-hover">
                  <tr>
                    <th>No</th>
                    <th>Plan Name</th>
                    <th>Customer</th>
                    <th>Payment ID</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-center">View<br>Detail</th>
                  </tr>
                  <?php
                  if(!empty($declined))
                  {
                    foreach($declined as $index=>$record)
                    {
                  ?>
                  <tr>
                    <td><?php echo $index + 1 ?></td>
                    <td><?php echo $record['title'] ?></td>
                    <td><?php echo $customer->name ?></td>
                    <td><?php echo 'ID - ' . $record['payment']->id ?></td>
                    <td><?php echo $record['payment']->dueDate ?></td>
                    <td><?php echo '$' . $record['payment']->amount ?></td>
                    <td>failed</td>
                    <td class="text-center">
                      <a class="btn btn-sm btn-info" href="<?php echo base_url().'payment/edit/'.$record['payment']->id; ?>"><i class="fa fa-eye"></i></a>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td><b>TOTAL</b></td>
                    <td></td>
                    <td></td>
                    <td><b>$<?php echo $totalDeclined ?></b></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <?php
                  } else {
                    echo '<tr><td colspan="10" class="text-center"><i>No Declined<i></td></tr>';
                  }
                  ?>
                </table>
                <?php
                  } else if ($mode == 3) {
                ?>
                <table class="table table-hover">
                  <tr>
                    <th>No</th>
                    <th>Plan Name</th>
                    <th>Customer</th>
                    <th>Payment ID</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-center">View<br>Detail</th>
                  </tr>
                  <?php
                  if(!empty($billed))
                  {
                    foreach($billed as $index=>$record)
                    {
                  ?>
                  <tr>
                    <td><?php echo $index + 1 ?></td>
                    <td><?php echo $record['title'] ?></td>
                    <td><?php echo $customer->name ?></td>
                    <td><?php echo 'ID - ' . $record['payment']->id ?></td>
                    <td><?php echo $record['payment']->dueDate ?></td>
                    <td><?php echo '$' . $record['payment']->amount ?></td>
                    <td>success</td>
                    <td class="text-center">
                      <a class="btn btn-sm btn-info" href="<?php echo base_url().'payment/edit/'.$record['payment']->id; ?>"><i class="fa fa-eye"></i></a>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td><b>TOTAL</b></td>
                    <td></td>
                    <td></td>
                    <td><b>$<?php echo $totalBilled ?></b></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <?php
                  } else {
                    echo '<tr><td colspan="10" class="text-center"><i>No Billed<i></td></tr>';
                  }
                  ?>
                </table>
                <?php
                  } else if ($mode == 4) {
                ?>
                <table class="table table-hover">
                  <tr>
                    <th>No</th>
                    <th>Plan Name</th>
                    <th>Customer</th>
                    <th>Payment ID</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-center">View<br>Detail</th>
                  </tr>
                  <?php
                  if(!empty($futurePayments))
                  {
                    foreach($futurePayments as $index=>$record)
                    {
                  ?>
                  <tr>
                    <td><?php echo $index + 1 ?></td>
                    <td><?php echo $record['title'] ?></td>
                    <td><?php echo $customer->name ?></td>
                    <td><?php echo 'ID - ' . $record['payment']->id ?></td>
                    <td><?php echo $record['payment']->dueDate ?></td>
                    <td><?php echo '$' . $record['payment']->amount ?></td>
                    <td>pending</td>
                    <td class="text-center">
                      <a class="btn btn-sm btn-info" href="<?php echo base_url().'payment/edit/'.$record['payment']->id; ?>"><i class="fa fa-eye"></i></a>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                  <tr>
                    <td></td>
                    <td></td>
                    <td><b>TOTAL</b></td>
                    <td></td>
                    <td></td>
                    <td><b>$<?php echo $totalFuture ?></b></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <?php
                  } else {
                    echo '<tr><td colspan="10" class="text-center"><i>No Future Payments<i></td></tr>';
                  }
                  ?>
                </table>
                <?php
                  }
                ?>
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
              <form role="form" id="addPlan" action="<?php echo base_url().'plan/create/'.$customer->id ?>" method="post" role="form">
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
                        <input type="hidden" class="form-control" id="customerId" name="customerId" value="<?php echo $customer->id; ?>">
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