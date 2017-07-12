<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard<?php echo $view ?>
      <small>Control panel</small>
    </h1>
  </section>
    
  <section class="content">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua" href="#tab1" data-toggle="tab">
          <div class="inner">
            <h3>$ <?php echo $total['totalAmount'] ?></h3>
            <p>Total Amount</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green" href="#tab4" data-toggle="tab">
          <div class="inner">
            <h3>$ <?php echo $total['paid'] ?></h3>
            <p>Total Paid</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow" href="#tab2" data-toggle="tab">
          <div class="inner">
            <h3>$ <?php echo $total['due'] ?></h3>
            <p>Coming Payments</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red" href="#tab3" data-toggle="tab">
          <div class="inner">
            <h3>$ <?php echo $total['declined'] ?></h3>
            <p>Failed Payments</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a class="small-box-footer">View <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
    </div>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body table-responsive no-padding tab-content">
              <div class="tab-pane <?php echo $view == 0 ? 'active' : '' ?>" id="tab1">
              <table class="table table-hover">
                <tr>
                  <th>No</th>
                  <th>Plan Name</th>
                  <th>Customer</th>
                  <th>Total Amount</th>
                  <th>Paid</th>
                  <th>Due</th>
                  <th>Remaining<br>Payments</th>
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
                </tr>
                <?php
                } else {
                  echo '<tr><td colspan="10" class="text-center"><i>No Plan<i></td></tr>';
                }
                ?>
              </table>
            </div>
            <div class="tab-pane <?php echo $view == 3 ? 'active' : '' ?>" id="tab3">
              <table class="table table-hover">
                <tr>
                  <th>No</th>
                  <th>Plan Name</th>
                  <th>Customer</th>
                  <th>Payment ID</th>
                  <th>Payment Date</th>
                  <th>Amount</th>
                  <th>Status</th>
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
                  <td><?php echo $record['name'] ?></td>
                  <td><?php echo 'ID - ' . $record['payment']->id ?></td>
                  <td><?php echo $record['payment']->dueDate ?></td>
                  <td><?php echo '$' . $record['payment']->amount ?></td>
                  <td><a class="btn btn-sm btn-danger opacity-full">Failed</a></td>
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
                  <td><b>$<?php echo $total['declined'] ?></b></td>
                  <td></td>
                </tr>
                <?php
                } else {
                  echo '<tr><td colspan="10" class="text-center"><i>No Declined<i></td></tr>';
                }
                ?>
              </table>
            </div>
            <div class="tab-pane <?php echo $view == 1 ? 'active' : '' ?>" id="tab4">
              <table class="table table-hover">
                <tr>
                  <th>No</th>
                  <th>Plan Name</th>
                  <th>Customer</th>
                  <th>Payment ID</th>
                  <th>Payment Date</th>
                  <th>Amount</th>
                  <th>Status</th>
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
                  <td><?php echo $record['name'] ?></td>
                  <td><?php echo 'ID - ' . $record['payment']->id ?></td>
                  <td><?php echo $record['payment']->dueDate ?></td>
                  <td><?php echo '$' . $record['payment']->amount ?></td>
                  <td><a class="btn btn-sm btn-success opacity-full">Success</a></td>
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
                  <td><b>$<?php echo $total['paid'] ?></b></td>
                  <td></td>
                </tr>
                <?php
                } else {
                  echo '<tr><td colspan="10" class="text-center"><i>No Billed<i></td></tr>';
                }
                ?>
              </table>
            </div>
            <div class="tab-pane <?php echo $view == 2 ? 'active' : '' ?>" id="tab2">
              <table class="table table-hover">
                <tr>
                  <th>No</th>
                  <th>Plan Name</th>
                  <th>Customer</th>
                  <th>Payment ID</th>
                  <th>Payment Date</th>
                  <th>Amount</th>
                  <th>Action</th>
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
                  <td><?php echo $record['name'] ?></td>
                  <td><?php echo 'ID - ' . $record['payment']->id ?></td>
                  <td><?php echo $record['payment']->dueDate ?></td>
                  <td><?php echo '$' . $record['payment']->amount ?></td>
                  <td>
                    <div <?php echo ($record['payment']->status==0) ? '' : 'hidden' ?>>
                      <a class="btn btn-sm btn-info opacity-full"
                        href="<?php echo base_url().'payment/approve/2/1/'.$record['payment']->id; ?>">
                        Approve
                      </a> or <a class="btn btn-sm btn-danger opacity-full"
                        href="<?php echo base_url().'payment/decline/2/3/'.$record['payment']->id; ?>">
                        Decline
                      </a>
                    </div>
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
                  <td><b>$<?php echo $total['due'] ?></b></td>
                  <td></td>
                </tr>
                <?php
                } else {
                  echo '<tr><td colspan="10" class="text-center"><i>No Future Payments<i></td></tr>';
                }
                ?>
              </table>
            </div>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
      </div>
    </section>
  </section>
</div>