<?php
$thispageid=35;
include ('../../config/config.inc.php');
$dynamic = '1';

include ('../../require/header.php');
$_SESSION['cid'] = '';

?>

<style type="text/css">
    .row { margin:0;}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            ReCaptcha Mgmt
            <small>Manage ReCaptcha Mgmt</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i> Settings</a></li>
            <li class="active"><i class="fa fa-repeat"></i> ReCaptcha Mgmt</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
<!--            <div class="box-header">
                <h3 class="box-title"><a href="<?php echo $sitename; ?>settings/addgeneral.htm">Add New General Mgmt</a></h3>
            </div> /.box-header -->
            <div class="box-body">
                <?php echo $msg; ?>
                <form name="form1" method="post" action="" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table id="example10" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">S.id</th>
                                    <th width="25%">SiteKey</th>
                                    <th align="center" width="10%">Status</th>
                                    <th data-sortable="false" align="center" width="10%" style="text-align: center; padding-right:0; padding-left: 0;">Edit</th>
                                    
                                </tr>
                            </thead>
                            <?php
                            $ndepart =$db->prepare("SELECT * FROM `captcha`");
                            $ndepart->execute(array());
                            if ($ndepart > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    $i = '1';
                                    while ($fdepart = $ndepart->fetch()) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                           
                                           <td><?php echo getcaptcha('sitekey', $fdepart['cid']); ?></td>
                                            <td width="10%"><?php
                                                if ($fdepart['status'] == '1') {
                                                    echo 'Active';
                                                } else {
                                                    echo 'Inactive';
                                                }
                                                ?></td>
                                            <td align="center" width="10%"><i class="fa fa-edit" onclick="editthis('<?php echo $fdepart['cid']; ?>');" style="cursor:pointer;"></i></td>
                                            
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            <?php } ?>
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
        window.location.href = '<?php echo $sitename; ?>settings/' + a + '/editcaptcha.htm';
    }
</script>
<?php
include ('../../require/footer.php');
?>
