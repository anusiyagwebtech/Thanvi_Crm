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
    $msg = delemployee($chk);
   //print_r($chk);
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
            if (confirm("Please confirm you want to Delete this "))
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

                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                            <div class="row" style="padding-bottom:20px;">
                                            <div class="col-md-6">

                                            <h4 class="mt-0 header-title">Employee Management</h4>
                                        </div>
                                         <div class="col-md-6">
                                             <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/employee/addemployee.php';" type="reset" class="btn btn-info waves-effect" style="float:right;margin-right:50px;"><i class="mdi mdi-account-plus"></i>&nbsp;
                                                            Add New Employee
                                                        </button>
                                                    </div>
                                                </div> 
                             
                                 <form name="form1" method="post" action="">
                                    <button type="submit" style="float:right;margin:10px;" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"><i class="mdi mdi-account-minus"></i>&nbsp; DELETE </button>

                                      <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">

                                                <thead>
                                                <tr>
                                                    <th>Emp id</th>
                                                    <th>Name</th>
                                                    <th>Password</th>
                                                    <th>Domain</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                    
                                            
                                                </tr>
                                                </thead>


                                            </table>
                                           
                                        </form>
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
        window.location.href = '<?php echo $sitename; ?>employee/' + a + '/editemployee.htm';
    }
</script>

<script type="text/javascript">
    $('#datatable').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=employeetable"
    });
</script>
