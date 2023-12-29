<?php
$menu = "4,4,11";
$thispageid = 21;
include ('../../config/config.inc.php');
$dynamic = '1';
//$datepicker = '1';
$datatable = '1';

include ('../../require/header.php');

if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = delattribute($chk, $thispageid, $ip);
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
            if (confirm("Please confirm you want to Delete this Attribute(s)"))
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
</style>
<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(1),tbody tr td:nth-child(3),tbody tr td:nth-child(4) {
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Attribute<small>Manage Attribute  Mgmt</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> Dynamic Pages</a></li>
            <li class="active">Attribute Group Mgmt</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>products/addattribute.htm">Add New Attribute </a></h3>
                <!---->
            </div>
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<!--                        <script src="<?php echo $sitename; ?>pages/master/ddtf.js"></script>-->
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center" width="5%" >S.id</th>
                                    <th  width="75%" >Name</th>                                  


                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;">Edit</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 10%;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th><!-- -->
                                </tr>
                            </thead><tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">&nbsp;</th>
                                    <th style="margin:0px auto;"><button type="submit" style="width:100%;"class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th><!-- -->
                                </tr>
                            </tfoot>
                            <?php // }  ?>
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
        var sid = a;
        window.location.href = '<?php echo $sitename; ?>products/' + a + '/editattribute.htm';
    }
</script>
<!--<script>
    jQuery('#example1').ddTableFilter();
</script>-->
<?php
include ('../../require/footer.php');
?>
<script type="text/javascript">
    $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=attritable"
    });
</script>