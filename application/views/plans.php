<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-ticket"></i> Plan Management
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNewPlan"><i class="fa fa-plus"></i> Add New Plan</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Plans List</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>planListing" method="POST" id="searchList">
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
                      <th>Id</th>
                      <th>Title</th>
                      <th hidden>Summary</th>
                      <th>Amount</th>
                      <th>Pay Date</th>
                      <th hidden>Status</th>
                      <th>Customer</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($planRecords))
                    {
                      foreach($planRecords as $i=>$record)
                      {
                    ?>
                    <tr onclick="window.location='<?php echo base_url().'viewPlan/'.$record->planId; ?>'">
                      <td><?php echo $i + 1 + $segment/*$record->planId*/ ?></td>
                      <td><?php echo $record->title ?></td>
                      <td hidden><?php echo $record->summary ?></td>
                      <td><?php echo $record->amount ?></td>
                      <td>
                        <?php
                          $ret = '<div class="btn btn-sm btn-';
                          $timeNow = date('Y-m-d');
                          $strState = array('Pending', 'info');
                          if ($record->status == 'Complete')
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
                      <td><?php echo $record->name ?></td>
                      <td class="text-center">
                        <div <?php echo $record->status == 'Complete' ? 'hidden' : '' ?>>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editPlan/'.$record->planId; ?>"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deletePlan" href="#" data-planid="<?php echo $record->planId; ?>"><i class="fa fa-trash"></i></a>
                        </div>
                      </td>
                    </tr>
                    <?php
                      }
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "planListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
