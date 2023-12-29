<?php

include ('../../require/sidebar.php');


include ('../../require/header.php');
?>
<style>
    .span{
        color:#fb8c00;
    }
    .border{
        border: 5px solid black !important;
        border-radius: 20px 20px 20px 20px;
    }
    h5{
        color:white;
    }
   
</style>


                    <!-- ==================
                         PAGE CONTENT START
                         ================== -->

                    <div class="page-content-wrapper">

                        <div class="container-fluid">

                            <div class="row" >
                                <div class="col-12">
                                    <div class="card m-b-20 " style="border-radius: 20px 20px 20px 20px;" >
                                        <div class="card-body border "style="background-image: linear-gradient(rgba(38, 50, 56, 1), rgba(0, 0, 0, 0.85)), url('<?php echo $sitename; ?>pages/lead/viewpage.jpg');background-size:1200px 400px;">
                                             <div class="row" style="padding:10px;padding-bottom:40px;">
                                            <div class="col-md-6">

                                          <h4 class="mt-0 header-title" style="color:white;">Task Management</h4>
                                         </div>
                                         <div class="col-md-6">
                                             <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/task/addtask.php';" type="reset" class="btn btn-info waves-effect" style="float:right;margin-right:30px;">
                                                <i class="mdi mdi-clipboard-check"></i>&nbsp;
                                                            Add New Task
                                                         </button>
                                                    </div>
                                                </div>
                                         <?php
                                         $view = FETCH_all("SELECT *FROM `lead_form` WHERE `lid` = ?", $_REQUEST['lid']);
                                         ?>

                                             <div class="row ">
                                                <div class="col-md-2">
                                                    
                                                </div>
                                                 <div class="col-md-2">
                                                     <h5>Sid </h5>
                                                    <h5>proposal Type   </h5>
                                                    <h5>Sent Through </h5>
                                                    <h5>Sent To  </h5>
                                                 </div>
                                                <div class="col-md-3">
                                                   <h5> : <?php echo getlead('lid', $_REQUEST['lid']); ?></h5>
                                                    <h5> :  <?php echo getlead('type', $_REQUEST['lid']); ?></h5>
                                                    <h5> : <?php echo getlead('sentthrough', $_REQUEST['lid']); ?></h5>
                                                    <h5> : <?php echo getlead('sentto', $_REQUEST['lid']); ?></h5>
                                                    
                                                </div>
                                             

                                                <div class="col-md-2">
                                                    <h5>Sent Date  </h5>
                                                    <h5>Status </h5>
                                                    <h5>Lead Type  </h5>
                                                    <h5>Domain  </h5>
                                                    
                                                </div>
                                                <div class="col-md-3">
                                                    <h5> : <?php echo getlead('date', $_REQUEST['lid']); ?></h5>
                                                    <h5> : <?php echo getlead('proposal', $_REQUEST['lid']); ?></h5>
                                                    <h5> : <?php echo getlead('leadtype', $_REQUEST['lid']); ?></h5>
                                                    <h5> : <?php echo getlead('domain', $_REQUEST['lid']); ?></h5>
                                                 </div>
                                             </div>
                                             <div class="row"style="padding-top:50px;">
                                                <div class="col-md-12">
                                               
                                                         <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/lead/lead.php';" type="reset" class="btn btn-warning" style="float:right;">
                                                            Back To List Page
                                                        </button>
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
        var tid = a;
        window.location.href = '<?php echo $sitename; ?>task/' + a + '/edittask.htm';
    }
</script>

<script type="text/javascript">
    $('#datatable').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=tasktable"
    });
</script>
