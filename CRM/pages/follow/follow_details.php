<?php
$menu = "2,1,1";
$thispageid = 1;
include ('../../require/sidebar.php');
$dynamic = '1';
$datatable = '1';

include ('../../require/header.php');

if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delfollow($chk);
}
if(isset($_REQUEST['save']) || isset($_REQUEST['save']))
{
@extract($_REQUEST);
global $db;

$resa = $db->prepare("INSERT INTO `follow_history` (`reason`,`lead_id`, `follow_date`,`follow_time`,`follow_status`) VALUES (?,?,?,?,?)");
$resa->execute(array($reason,$fid, $follow_date, $follow_time,$follow_status));

$upresa = $db->prepare("UPDATE `lead_form` SET `reason`=?,`follow_date`=?, `follow_time`=?,`follow_status`=? WHERE `lid`=?");
$upresa->execute(array($reason,$follow_date, $follow_time,$follow_status,$fid));


 $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';


}
?>
<script type="text/javascript" >
    function validcheck(name)
    {
        var chObj = document.getElementsByName(name);
        var result = false;
        for (var i = 0; i < chObj.length; i++) {
            if (chObj[i].checked) {
                result = true;
                break;
            }
        }
        if (!result) {
            return false;
        } else {
            return true;
        }
    }

    function checkdelete(name)
    {
        if (validcheck(name) == true)
        {
            if (confirm("Please confirm you want to Delete this New(s)"))
            {
                return true;
            } else
            {
                return false;
            }
        } else if (validcheck(name) == false)
        {
            alert("Select the check box whom you want to delete.");
            return false;
        }
    }

    function checkall(objForm) {
        len = objForm.elements.length;
        var i = 0;
        for (i = 0; i < len; i++) {
            if (objForm.elements[i].type == 'checkbox') {
                objForm.elements[i].checked = objForm.check_all.checked;
            }
        }
    }
</script>

                    <!-- ==================
                         PAGE CONTENT START
                         ================== -->

                    <div class="page-content-wrapper">

                        <div class="container-fluid">
<?php echo $msg; ?>
                            <div class="row" >
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            <div class="row"style="padding-bottom:20px;">
                                            <div class="col-md-6">

                                            <h4 class="mt-0 header-title">Follow Details</h4>
                                        </div>
                                         <div class="col-md-6">
                                           &nbsp;
                                                    </div>
                                                </div>
                                
                                         <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">
                                                        <span class="d-none d-md-block" style="font-size:15px;">Followup</span><span class="d-block d-md-none"><i class="mdi mdi-home-variant h5"></i></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">
                                                        <span class="d-none d-md-block" style="font-size:15px;">Scheduled</span><span class="d-block d-md-none"><i class="mdi mdi-account h5"></i></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#messages1" role="tab">
                                                        <span class="d-none d-md-block" style="font-size:15px;">Hold</span><span class="d-block d-md-none"><i class="mdi mdi-email h5"></i></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#settings1" role="tab">
                                                        <span class="d-none d-md-block" style="font-size:15px;">Rejected</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#completed1" role="tab">
                                                        <span class="d-none d-md-block" style="font-size:15px;">Completed</span><span class="d-block d-md-none"><i class="mdi mdi-settings h5"></i></span>
                                                    </a>
                                                </li>
                                            </ul>
                                                <div class="tab-content">
                                                <div class="tab-pane active p-3" id="home1" role="tabpanel">
                                                    <p class="font-14 mb-0">
                                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                        <tr>
                                                            <th>Sno</th>
                                                            <th>Lead Type</th>
                                                            <th>Client Name</th>
                                                            <th>Domain</th>
                                                            <th>Proposal Document</th>
                                                            <th>Send Through</th>
                                                            <th>Send To</th>
                                                            <th>Send Date</th>
                                                            <th>Project Status</th>
                                                        </tr>
                                                        
                                                             <?php
                                                             $i=1;
$lead = pFETCH("SELECT * FROM `lead_form` WHERE `follow_status`=? ORDER BY `lid` DESC", '0');
while ($leadfetch = $lead->fetch(PDO::FETCH_ASSOC)) 
{
?>
<tr>
    <td><?php echo $i; ?></td>
                                                            <td><?php echo $leadfetch['type']; ?></td>
                                                            <td><?php echo getclient('com_name', $leadfetch['client']); ?></td>
                                                            <td><?php echo $leadfetch['domain']; ?></td>
                                                            <td><?php echo "-"; ?></td>
                                                            <td><?php echo $leadfetch['sentthrough']; ?></td>
                                                            <td><?php echo $leadfetch['sentto']; ?></td>
                                                            <td><?php echo $leadfetch['date']; ?></td>
                                                            <td>
                                                                 <!-- <select name="proposal" class="form-control " id="pro_statuss" title="<?php echo $leadfetch['lid']; ?>">
                                                                    <option value="0">Followup</option>
                                                                     <option value="1">Scheduled</option>
                                                                      <option value="2">Hold</option>
                                                                       <option value="3">Reject</option>
                                                                        <option value="4">Completed</option>
                                                                 </select>    -->
                                                                 <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal<?php echo $leadfetch['lid']; ?>">Change</button>
                                                                  <!-- sample modal content -->
                                                    <div id="myModal<?php echo $leadfetch['lid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myModalLabel">Next Followup Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                 <form method="post">
                                                                <div class="modal-body">
                                                                   
                                                                          <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label>Followup Status</label>
                                                                                <input type="hidden" name="fid" value="<?php echo $leadfetch['lid']; ?>">
                                                                                <select name="follow_status" class="form-control " onchange="chkstatus(this.value);" required="required">
                                                                                    <option value="">Select</option>
                                                                     <option value="1">Scheduled</option>
                                                                      <option value="3">Hold</option>
                                                                       <option value="4">Reject</option>
                                                                        <option value="5">Completed</option>
                                                                 </select> 
                                                                            </div>
                                                                        </div><br>
                                                                          <div class="row" style="display: none;" id="hscd">
                                                                            <div class="col-md-6">
                                                    <label>Reason</label>
                                                    <div>
                                                        <div class="input-group">
                                                           <textarea name="reason" class="form-control"></textarea>
                                                         
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                                                          </div>
                                                                        <div class="row" style="display: none;" id="scd">
                                                                            
                                                <div class="col-md-6">
                                                    <label>Followup Date</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" placeholder="mm/dd/yyyy" name="follow_date">
                                                         
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Followup Time</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="time" class="form-control" name="follow_time">
                                                         
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                            </div>
                                                                  
                                                                 <!--    <h5>Overflowing text to show scroll behavior</h5> -->
                                                                    
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="save">Save changes</button>
                                                                </div>
                                                            </form>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                               </td>
                                                        </tr>
                                                        <?php $i++;  } ?>
                                                       </table>
                                                    </p>
                                                </div>
                                                <div class="tab-pane p-3" id="profile1" role="tabpanel">
                                                     <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                        <tr>
                                                            <th>Sno</th>
                                                             <th>Follow Date</th>
                                                            <th>Follow Time</th>
                                                            <th>Lead Type</th>
                                                            <th>Client Name</th>
                                                            <th>Domain</th>
                                                            <th>Proposal Document</th>
                                                            <th>Send Through</th>
                                                            <th>Send To</th>
                                                            <th>Project Status</th>
                                                        </tr>
                                                        
                                                             <?php
                                                             $i=1;
$lead = pFETCH("SELECT * FROM `lead_form` WHERE (`follow_status`=? OR `follow_status`=?) ORDER BY `lid` DESC", '1','2');
while ($leadfetch = $lead->fetch(PDO::FETCH_ASSOC)) 
{
?>
<tr>
    <td><?php echo $i; ?></td>
     <td><?php echo date('d-m-Y',strtotime($leadfetch['follow_date'])); ?></td>
                                                             <td><?php echo date('h:i a',strtotime($leadfetch['follow_time'])); ?></td>
                                                            <td><?php echo $leadfetch['type']; ?></td>
                                                            <td><?php echo getclient('com_name', $leadfetch['client']); ?></td>
                                                            <td><?php echo $leadfetch['domain']; ?></td>
                                                            <td><?php echo "-"; ?></td>
                                                            <td><?php echo $leadfetch['sentthrough']; ?></td>
                                                            <td><?php echo $leadfetch['sentto']; ?></td>

                                                            <td>
                                                                 <!-- <select name="proposal" class="form-control " id="pro_statuss" title="<?php echo $leadfetch['lid']; ?>">
                                                                    <option value="0">Followup</option>
                                                                     <option value="1">Scheduled</option>
                                                                      <option value="2">Hold</option>
                                                                       <option value="3">Reject</option>
                                                                        <option value="4">Completed</option>
                                                                 </select>    -->
                                                                 <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal<?php echo $leadfetch['lid']; ?>">Change</button>
                                                                  <!-- sample modal content -->
                                                    <div id="myModal<?php echo $leadfetch['lid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myModalLabel">Next Followup Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                 <form method="post">
                                                                <div class="modal-body">
                                                                   
                                                                          <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label>Followup Status</label>
                                                                                <input type="hidden" name="fid" value="<?php echo $leadfetch['lid']; ?>">
                                                                                <select name="follow_status" class="form-control " onchange="chkstatus1(this.value);" required="required">
                                                                                    <option value="">Select</option>
                                                                     <option value="2">Rescheduled</option>
                                                                      <option value="3">Hold</option>
                                                                       <option value="4">Reject</option>
                                                                        <option value="5">Completed</option>
                                                                 </select> 
                                                                            </div>
                                                                        </div><br>
                                                                         <div class="row" style="display: none;" id="hscd1">
                                                                            <div class="col-md-6">
                                                    <label>Reason</label>
                                                    <div>
                                                        <div class="input-group">
                                                           <textarea name="reason" class="form-control"></textarea>
                                                         
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                                                          </div>

                                                                        <div class="row" style="display: none;" id="scd1">
                                                                            
                                                <div class="col-md-6">
                                                    <label>Followup Date</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" placeholder="mm/dd/yyyy" name="follow_date">
                                                         
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Followup Time</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="time" class="form-control" name="follow_time">
                                                         
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                            </div>
                                                                  
                                                                 <!--    <h5>Overflowing text to show scroll behavior</h5> -->
                                                                    
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="save">Save changes</button>
                                                                </div>
                                                            </form>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                               </td>
                                                        </tr>
                                                        <?php $i++;  } ?>
                                                       </table>
                                                </div>
                                                <div class="tab-pane p-3" id="messages1" role="tabpanel">
                                                   <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                        <tr>
                                                            <th>Sno</th>
                                                             <th>Follow Date</th>
                                                            <th>Follow Time</th>
                                                            <th>Lead Type</th>
                                                            <th>Client Name</th>
                                                            <th>Domain</th>
                                                            <th>Proposal Document</th>
                                                            <th>Send Through</th>
                                                            <th>Send To</th>
                                                            <th>Project Status</th>
                                                        </tr>
                                                        
                                                             <?php
                                                             $i=1;
$lead = pFETCH("SELECT * FROM `lead_form` WHERE `follow_status`=? ORDER BY `lid` DESC", '3');
while ($leadfetch = $lead->fetch(PDO::FETCH_ASSOC)) 
{
?>
<tr>
    <td><?php echo $i; ?></td>
     <td><?php echo date('d-m-Y',strtotime($leadfetch['follow_date'])); ?></td>
                                                             <td><?php echo date('h:i a',strtotime($leadfetch['follow_time'])); ?></td>
                                                            <td><?php echo $leadfetch['type']; ?></td>
                                                            <td><?php echo getclient('com_name', $leadfetch['client']); ?></td>
                                                            <td><?php echo $leadfetch['domain']; ?></td>
                                                            <td><?php echo "-"; ?></td>
                                                            <td><?php echo $leadfetch['sentthrough']; ?></td>
                                                            <td><?php echo $leadfetch['sentto']; ?></td>

                                                            <td>
                                                                 <!-- <select name="proposal" class="form-control " id="pro_statuss" title="<?php echo $leadfetch['lid']; ?>">
                                                                    <option value="0">Followup</option>
                                                                     <option value="1">Scheduled</option>
                                                                      <option value="2">Hold</option>
                                                                       <option value="3">Reject</option>
                                                                        <option value="4">Completed</option>
                                                                 </select>    -->
                                                                 <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal<?php echo $leadfetch['lid']; ?>">Change</button>
                                                                  <!-- sample modal content -->
                                                    <div id="myModal<?php echo $leadfetch['lid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myModalLabel">Next Followup Details</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                 <form method="post">
                                                                <div class="modal-body">
                                                                   
                                                                          <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label>Followup Status</label>
                                                                                <input type="hidden" name="fid" value="<?php echo $leadfetch['lid']; ?>">
                                                                                <select name="follow_status" class="form-control " onchange="chkstatus3(this.value);" required="required">
                                                                                    <option value="">Select</option>
                                                                     <option value="4">Reject</option>
                                                                        <option value="5">Completed</option>
                                                                 </select> 
                                                                            </div>
                                                                        </div><br>
                                                                         <div class="row" style="display: none;" id="hscd3">
                                                                            <div class="col-md-6">
                                                    <label>Reason</label>
                                                    <div>
                                                        <div class="input-group">
                                                           <textarea name="reason" class="form-control"></textarea>
                                                         
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                                                          </div>

                                                                        
                                                                  
                                                                 <!--    <h5>Overflowing text to show scroll behavior</h5> -->
                                                                    
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="save">Save changes</button>
                                                                </div>
                                                            </form>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                               </td>
                                                        </tr>
                                                        <?php $i++;  } ?>
                                                       </table>
                                                </div>
                                                <div class="tab-pane p-3" id="settings1" role="tabpanel">
                                                   <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                        <tr>
                                                            <th>Sno</th>
                                                             <th>Follow Date</th>
                                                            <th>Follow Time</th>
                                                            <th>Lead Type</th>
                                                            <th>Client Name</th>
                                                            <th>Domain</th>
                                                            <th>Proposal Document</th>
                                                            <th>Send Through</th>
                                                            <th>Send To</th>
                                                            <th>Project Status</th>
                                                        </tr>
                                                        
                                                             <?php
                                                             $i=1;
$lead = pFETCH("SELECT * FROM `lead_form` WHERE `follow_status`=? ORDER BY `lid` DESC", '4');
while ($leadfetch = $lead->fetch(PDO::FETCH_ASSOC)) 
{
?>
<tr>
    <td><?php echo $i; ?></td>
     <td><?php echo date('d-m-Y',strtotime($leadfetch['follow_date'])); ?></td>
                                                             <td><?php echo date('h:i a',strtotime($leadfetch['follow_time'])); ?></td>
                                                            <td><?php echo $leadfetch['type']; ?></td>
                                                            <td><?php echo getclient('com_name', $leadfetch['client']); ?></td>
                                                            <td><?php echo $leadfetch['domain']; ?></td>
                                                            <td><?php echo "-"; ?></td>
                                                            <td><?php echo $leadfetch['sentthrough']; ?></td>
                                                            <td><?php echo $leadfetch['sentto']; ?></td>

                                                           <td>Rejected</td>

                                                        </tr>
                                                        <?php $i++;  } ?>
                                                       </table>
                                                </div>
                                                 <div class="tab-pane p-3" id="completed1" role="tabpanel">
                                                   <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                                        <tr>
                                                            <th>Sno</th>
                                                             <th>Follow Date</th>
                                                            <th>Follow Time</th>
                                                            <th>Lead Type</th>
                                                            <th>Client Name</th>
                                                            <th>Domain</th>
                                                            <th>Proposal Document</th>
                                                            <th>Send Through</th>
                                                            <th>Send To</th>
                                                            <th>Project Status</th>
                                                        </tr>
                                                        
                                                             <?php
                                                             $i=1;
$lead = pFETCH("SELECT * FROM `lead_form` WHERE `follow_status`=? ORDER BY `lid` DESC", '5');
while ($leadfetch = $lead->fetch(PDO::FETCH_ASSOC)) 
{
?>
<tr>
    <td><?php echo $i; ?></td>
     <td><?php echo date('d-m-Y',strtotime($leadfetch['follow_date'])); ?></td>
                                                             <td><?php echo date('h:i a',strtotime($leadfetch['follow_time'])); ?></td>
                                                            <td><?php echo $leadfetch['type']; ?></td>
                                                            <td><?php echo getclient('com_name', $leadfetch['client']); ?></td>
                                                            <td><?php echo $leadfetch['domain']; ?></td>
                                                            <td><?php echo "-"; ?></td>
                                                            <td><?php echo $leadfetch['sentthrough']; ?></td>
                                                            <td><?php echo $leadfetch['sentto']; ?></td>

                                                           <td>Completed</td>

                                                        </tr>
                                                        <?php $i++;  } ?>
                                                       </table>
                                                </div>
                                            </div>
                                      

                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->


                        </div><!-- container-fluid -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

          <?php include('../../require/footer.php');?>

        <!-- Required datatable js -->
        <script src="<?php echo $sitename; ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="<?php echo $sitename; ?>public/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/datatables/jszip.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/datatables/pdfmake.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/datatables/vfs_fonts.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/datatables/buttons.print.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="<?php echo $sitename; ?>public/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo $sitename; ?><?php echo $sitename; ?>public/plugins/datatables/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="<?php echo $sitename; ?>public/assets/pages/datatables.init.js"></script>

        <!-- App js -->
        <!-- <script src="<?php echo $sitename; ?>public/assets/js/app.js"></script>  -->

    </body>

<!-- Mirrored from admiria-v.php.themesbrand.com/tables-datatable.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Feb 2020 05:28:32 GMT -->
</html>
<script type="text/javascript">
    function editthis(a)
    {
        var lid = a;
        window.location.href = '<?php echo $sitename; ?>pages/follow/addfollow.php?fid=' + a;
    }
</script>

<script type="text/javascript">
    $("#pro_statuss").change(function(){
var e = 1;
var status = $(this).val();
var oid = $(this).attr('title');    
if(confirm("Please confirm you want to Change the Status")){
var params = "prostatus="+status+"&lid="+oid;
//alert(params);
$.ajax({
type: "POST",
url: '<?php echo $fsitename; ?>admin/config/functions_ajax.php',
data: params,
success: function(data){
//alert('success');
//window.location.assign();  
}
});// you have missed this bracket
}
});
    $('#datatable').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=followtable"
    });
    function chkstatus(a)
    {
        if(a=='1'){

$('#scd').show();
$('#hscd').hide();
} else if(a=='3' || a=='4'){

$('#hscd').show();
$('#scd').hide();
}
else
{
  $('#scd').hide(); 
  $('#hscd').hide(); 
    }
}
function chkstatus1(a)
{

if(a=='1'){

$('#scd1').show();
$('#hscd').hide();
} else if(a=='3' || a=='4'){

$('#hscd1').show();
$('#scd1').hide();
}
else
{
  $('#scd1').hide(); 
  $('#hscd1').hide(); 
    }
}

function chkstatus3(a)
{
if(a=='3' || a=='4'){

$('#hscd3').show();
}
else
{
  $('#hscd3').hide(); 
    }
}
</script>
