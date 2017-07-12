<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i> Payment Management
    </h1>
  </section>
  <div class="tab-content">
    <div class="tab-pane <?php echo $view == 0 ? 'active' : '' ?>" id="list_payment">
      <section class="content">
        <div class="row">
          <div class="col-xs-12 text-right">
            <div class="form-group">
              <a class="btn btn-primary" href="#add_new_payment" data-toggle="tab"><i class="fa fa-plus"></i> Add New</a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Payment List</h3>
                <div class="box-tools">
                  <form action="<?php echo base_url() ?>payment/index" method="POST" id="searchList">
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
                    <th>Payment ID</th>
                    <th>Pay Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Plan Title</th>
                    <th class="text-center">Actions</th>
                  </tr>
                  <?php
                  if(!empty($records))
                  {
                    foreach($records as $index=>$record)
                    {
                  ?>
                  <tr>
                    <td>
                      <div <?php echo ($record->status==0) ? '' : 'hidden' ?>>
                        <a class="btn btn-sm btn-info opacity-full"
                          href="<?php echo base_url().'payment/approve/2/1/'.$record->id; ?>">
                          Approve
                        </a> or <a class="btn btn-sm btn-danger opacity-full"
                          href="<?php echo base_url().'payment/decline/2/3/'.$record->id; ?>">
                          Decline
                        </a>
                      </div>
                    </td>
                    <td><?php echo 'ID - ' . $record->id ?></td>
                    <td><?php echo $record->dueDate ?></td>
                    <td><?php echo $record->amount ?></td>
                    <td>
                      <?php
                        $ret = '<div class="btn btn-sm btn-';
                        $timeNow = date('Y-m-d');
                        $strState = array('Pending', 'info');
                        if ($record->status == 1)
                          $strState = array('Completed', 'success');
                        if ($record->status == 2)
                          $strState = array('Failed', 'danger');
                        else if ($timeNow > $record->dueDate)
                          $strState = array('Out Dated', 'danger');
                        else if ($timeNow == $record->dueDate)
                          $strState = array('Today', 'warning');
                        $ret .= $strState[1] . ' opacity-full" disabled>' . $strState[0] . '</div>';
                        echo $ret;
                      ?>
                    </td>
                    <td><?php echo $record->title ?></td>
                    <td class="text-center">
                      <div <?php echo $record->status == 0 ? '' : 'hidden'; ?> >
                        <a class="btn btn-sm btn-info" href="<?php echo base_url().'payment/edit/'.$record->id; ?>"><i class="fa fa-pencil"></i></a>
                        <a class="btn btn-sm btn-danger deleteItem" href="#" data-itemid="<?php echo $record->id; ?>"><i class="fa fa-trash"></i></a>
                      </div>
                    </td>
                  </tr>
                  <?php
                    }
                  } else {
                    echo '<tr><td colspan="10" class="text-center"><i>No Payment<i></td></tr>';
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

    <div class="tab-pane <?php echo $view == 1 ? 'active' : '' ?>" id="add_new_payment">
      <section class="content">
        <div class="row">
          <div class="col-xs-12 text-right">
            <div class="form-group">
              <a class="btn btn-primary" href="#list_payment" data-toggle="tab"><i class="fa fa-list"></i> View Payments</a>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Enter Details</h3>
              </div>
              <form role="form" id="addPayment" action="<?php echo base_url() ?>payment/create" method="post" role="form">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="fname">Select Plan</label>
                        <select class="form-control required" id="planId" name="planId">
                          <option value="0">Plan *</option>
                          <?php
                            if(!empty($plans)) {
                              foreach ($plans as $plan) {
                          ?>
                            <option value="<?php echo $plan->id ?>"><?php echo $plan->title ?></option>
                          <?php
                              }
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="dueDate">Pay Date</label>
                        <input type="date" class="form-control required date" id="dueDate" name="dueDate">
                        <input type="hidden" class="form-control" id="userId" name="userId" value="<?php echo $userId; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control required number" id="amount" name="amount" maxlength="11">
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
            var addPaymentForm = $("#addPayment");
            var validator = addPaymentForm.validate({
              rules:{
                dueDate :{ required : true, date : true },
                amount :{ required : true, number : true, min : 0.1 },
                //customerId : { required : true, selected : true },
                planId : { required : true, selected : true }
              },
              messages:{
                dueDate : { required : "This field is required", date : "Pay Date can't be past" },
                amount : { required : "This field is required", number : "Please enter numbers only", min : "Amount is too low" },
                //customerId : { required : "This field is required", selected : "Please select atleast one option" },
                planId : { required : "This field is required", selected : "Please select atleast one option" }
              }
            });
          });

          jQuery(document).on("click", ".deleteItem", function(){
            var itemId = $(this).data("itemid"),
              hitURL = baseURL + "payment/delete",
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
