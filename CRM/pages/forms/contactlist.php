<?php
$menu = '7,15,15';
$thispageid= 7;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
$franchisee='yes';
include ('../../require/header.php');

//$_SESSION['staticpages_id'] = '';
if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delcontact1($chk);
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
            if (confirm("Please confirm you want to Delete this contactlist(s)"))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else if (validcheck(name) == false)
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
    #normalexamples tbody tr td:nth-child(6) ,tbody tr td:nth-child(7) {
       text-align:center;    
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Contact Forms
            <small>Manage All Contact Forms</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"> <i class="fa fa-envelope-o"></i>Forms</a></li>
            <li class="active">Contact Forms</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>"></a></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:15%;">Date</th>
                                    <th style="width:20%;">Name</th>
                                    <th style="width:20%;">Email</th>
                                    <th style="width:20%;">Phone</th>
                                    <th style="width:20%;">Phone</th>

                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                            </thead>
                            
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6">&nbsp;</th>
                                        <th align="center"><button type="submit" class="btn btn-danger" name="delete" id="delete" style="width:100%;" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                    </tr>
                                </tfoot>
                           
                        </table>
                    </div>
                </form>

            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
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