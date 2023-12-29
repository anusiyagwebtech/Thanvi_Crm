<?php
$menu = '11,29';
if ($_REQUEST['sgid'] != '') {
    $thispageeditid = 40;
} else {
    $thispageaddid = 40;
}
include ('../../config/config.inc.php');
$dynamic = '1';

include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $_SESSION['sendgrid_id'] = $_REQUEST['sgid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = addsendgrid($username, $password, $ip, $status, $_SESSION['sendgrid_id']);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
         SendGrid Details
            <small><?php
                if ($_REQUEST['sgid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> SendGrid Detail</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a data-toggle="control-sidebar" href="#"><i class="fa fa-gears"></i>Settings</a></li>
            <li><a href="<?php echo $sitename; ?>settings/sendgrid.htm"><i class="fa fa-envelope"></i>SendGrid</a></li>
            <li class="active"><?php
                if ($_REQUEST['sgid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;SendGrid Detail</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data" autocomplete="off" >
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['sgid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?>&nbsp;SendGrid Detail</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">SendGrid Detail</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>User Name <span style="color:#FF0000;"></span></label>
                                    <input type="text" name="username" id="username" class="form-control"  placeholder="Enter the User Name" value="<?php echo getsendgrid('username', $_REQUEST['sgid']); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Password <span style="color:#FF0000;"></span></label>
                                    <input type="text" name="password" id="password" class="form-control"  placeholder="Enter the password" value="<?php echo getsendgrid('password', $_REQUEST['sgid']); ?>" />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;"></span></label>
                                    <select name="status" id="status" class="form-control" required="required">
                                        <option value="0" <?php if(getsendgrid('status', $_REQUEST['sgid'])=='0'){ echo 'selected="selected"'; } ?>>In-Active</option>
                                        <option value="1" <?php if(getsendgrid('status', $_REQUEST['sgid'])=='1'){ echo 'selected="selected"'; } ?>>Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>settings/sendgrid.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['sgid'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </form> 
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>