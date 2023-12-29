<?php
$menu = "5,5,12";
$thispageid = 22;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';

include ('../../require/header.php');

$_SESSION['static_pages'] = '';
?>
<style type="text/css">
    .row { margin:0;}
    #normalexamples tbody tr td:nth-child(2) {
        text-align:left;
    }
    #normalexamples tbody tr td:nth-child(1),tr td:nth-child(3) {
        text-align:center;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Static Pages
            <small>Manage All Static Pages</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-id-card-o"></i>CMS</a></li>
            <li class="active">Static Pages</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="box">
            <div class="box-header">
            </div><!-- box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="normalexamples" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">S.id</th>
                                    <th style="width:70%;">Page Title</th>
                                    <th data-sortable="false" align="center" style="text-align: center; padding-right:0; padding-left: 0; width: 25%;">Edit</th>
                                </tr>
                            </thead>
                           
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
        window.location.href = '<?php echo $sitename; ?>CMS/' + a + '/editstaticpages.htm';
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
        "sAjaxSource": "<?php echo $sitename; ?>pages/dataajax/gettablevalues.php?types=static_pages"
    });
</script>