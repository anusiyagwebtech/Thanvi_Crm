<?php
$menu = "8,8,18";
$thispageid = 18;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
$franchisee = 'yes';
include ('../../require/header.php');

//$_SESSION['staticpages_id'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $_SESSION['msg'] = delcontactform1($chk);
}
if (isset($_REQUEST['submit'])) {
    //print_r($_REQUEST);
    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];
    $msgg = contactform($email);
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
            if (confirm("Do you want to Delete this contact List(s)"))
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

</script>
<script type="text/javascript">
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
<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(5) ,tbody tr td:nth-child(6) {
        text-align:center;    
    }
</style>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="row">
            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="col-sm-12">                 
                    <div class="btn-group pull-right m-t-15">
                        <button type="button" name="export" id="export" class="btn btn-primary" onclick="window.location.href = '<?php echo $fsitename; ?>admin/forms/exportcustomer.htm'">Export</button>
                     <!--<a href="<?php echo $sitename; ?>hotels/addrooms.htm"><button type="button" class="btn btn-info">Add New</button></a>-->
                    </div> 
                    <h4 class="page-title">Forms</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Ariser</li>
                        <li class="breadcrumb-item">Forms</li>
                        <li class="breadcrumb-item active">Contact List</li>
                    </ol>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box table-responsive">
                            <h4 class="m-t-0 header-title">List of Contact</h4>
                            <p class="text-muted font-14 m-b-30">
                                <?php //echo $msg; ?>
                                <!--  Responsive is an extension for DataTables that resolves that problem by optimising the table's layout for different screen sizes through the dynamic insertion and removal of columns from the table. -->
                            </p>
                            <?php
                            if ($_SESSION['msg'] != '') {
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                            ?>
                            <form name="form1" method="post" action="">
                                <div class="table-responsive">
                                    <table id="normalexamples" class="table table-bordered table-striped">
                                        <thead>
                                            <tr align="center">
                                                <th style="width:5%;">S.id</th>
                                                <th style="width:15%;">Date</th>
                                                <th style="width:20%;">Name</th>
                                                <th style="width:20%;">Email ID</th>
                                                <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">View</th>
                                                <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                            </tr>
                                        </thead>                          
                                        <tfoot>
                                            <tr>
                                                <th colspan="5">&nbsp;</th>
                                                <th align="center"><button type="submit" class="btn btn-danger" name="delete" id="delete" style="width:100%;" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
    function viewthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>forms/' + a + '/viewcontact.htm';
    }
</script>
<?php
include ('../../require/footer.php');
?>
<script type="text/javascript">
    $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=contacttable"
    });
</script>