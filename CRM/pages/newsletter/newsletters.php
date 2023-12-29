<?php
$menu = "4,4,10";
$datatable = '1';
$thispageid = 20;
include ('../../config/config.inc.php');
$dynamic = '1';

include ('../../require/header.php');

if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delnewsletter($chk);
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
            if (confirm("Please confirm you want to Delete this Subscriber(s)"))
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
    #normalexamples tbody tr td:nth-child(2),tbody tr td:nth-child(3),tbody tr td:nth-child(4){
        text-align:left;
    }
    #normalexamples tbody tr td:nth-child(1),tbody tr td:nth-child(5){
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            NewsLetter
            <small>Manage all Subscribers</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-id-card-o"></i>Newsletters</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Subscribers</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="text-right">
                        <button type="button" name="export" id="export" class="btn btn-success" onclick="window.location.href = '<?php echo $sitename; ?>newsletter/exportcustomer.htm'">Export</button>
                    </div>
                    <br />
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: left" width="5%">Id</th>
                                    <th style="text-align: left" width="15%">Date</th>
                                    <th style="text-align: left" width="55%">E-mail Id</th> 
                                    <th style="text-align: left" width="15%">IP</th>
                                    <th width="10%"data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th>
                                </tr>
                            </thead>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">&nbsp;</th>
                                    <th style="margin:0px auto;"><button type="submit"  style="width:100%;"class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
include ('../../require/footer.php');
?>
<script type="text/javascript">
    $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=newslettertable"
    });
</script>





