<?php
$menu = "2,5,5";
$thispageid = 5;
include ('../../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';

include ('../../../require/header.php');

if (isset($_REQUEST['delete']) || isset($_REQUEST['delete_x'])) {
    $chk = $_REQUEST['chk'];
    $chk = implode('.', $chk);
    $msg = deltestimonial1($chk);
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
<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(2), #normalexamples tbody tr td:nth-child(3) {
        text-align:left;
    }  
    #normalexamples tbody tr td:nth-child(4),#normalexamples tbody tr td:nth-child(5),#normalexamples tbody tr td:nth-child(6),#normalexamples tbody tr td:nth-child(7) {
        text-align:center;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Home Testimonial Mgmt
            <small>Testimonial  Mgmt</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-newspaper-o"></i> Home</a></li>
            <li class="active">Testimonial Mgmt</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>home/testimonial/addtestimonial.htm">Add New </a></h3>
            </div>
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center" width="5%" >S.id</th>
                                    <th width="25%">image</th>                                   
									<th width="25%">content</th>
                                    <th style="text-align: center" width="10%" >content1</th>
									<th style="text-align: center" width="10%" >Order</th>
                                    <th style="text-align: center" width="10%">Status</th>
                                    <th data-sortable="false" align="center" width="10%" style="text-align: center; padding-right:0; padding-left: 0;">Edit</th>
                                   <!--  <th data-sortable="false" align="center" width="10%" style="text-align: center; padding-right:0; padding-left: 0;"><input name="check_all" id="check_all" value="1" onclick="javascript:checkall(this.form)" type="checkbox" /></th> -->
                                </tr>
                            </thead>
                            <tfoot>
                                <!-- <tr>
                                    <th colspan="7">&nbsp;</th>
                                    <th style="margin:0px auto;"><button type="submit" class="btn btn-danger" name="delete" id="delete" value="Delete" onclick="return checkdelete('chk[]');"> DELETE </button></th>
                                </tr> -->
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
        var bid = a;
        window.location.href = '<?php echo $sitename; ?>testimonial/' + a + '/edittestimonial.htm';
    }
</script>
<?php
include ('../../../require/footer.php');
?>
<script type="text/javascript">
    $('#normalexamples').dataTable({
        "bProcessing": true,
        "bServerSide": true,
        //"scrollX": true,
        "searching": true,
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=testimonial1table"
    });
</script>


