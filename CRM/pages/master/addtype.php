<?php
$menu = '2,1,2';
if (isset($_REQUEST['id'])) {
    $thispageeditid = 18;
} else {
    $thispageid = 18;
}

include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');
include_once "../master/uploadimage.php";

if (isset($_REQUEST['submit'])) {
    $i = 1;
    @extract($_REQUEST);
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $strupload = '1';

    $msg = addtype($type, $order, $status, $ip, $thispageid, $getid);
    
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Type Mgmt
            <small><?php
if ($_REQUEST['id'] != '') {
    echo 'Edit';
} else {
    echo 'Add New';
}
?> Type Mgmt </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>
            <li><a href="<?php echo $sitename; ?>master/types.htm">Type Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Type Mgmt</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Type Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Type Mgmt
                        </div>
                        <div class="panel-body">                        
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Type Name <span style="color:#FF0000;">*</span></label>                                  
                                    <input type="text" name="type" id="type" placeholder="Enter The Type Name" class="form-control" value="<?php echo gettype('type', $_REQUEST['id']); ?>"  pattern="[A-Z a-z 0-9 .,&_-]{1,55}" title="Special character not allowed." required />
                                </div>  
                                
                            </div>
                            <br/>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" class="form-control" name="order" required="required" value="<?php echo getbrand('order', $_REQUEST['id']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                if (getbrand('status', $_REQUEST['id']) == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                        <option value="0" <?php
                                        if (getbrand('status', $_REQUEST['id']) == '0') {
                                            echo 'selected';
                                        }
                                ?>>Inactive</option>

                                    </select>
                                </div>
                                <div id="txtHint1"><b></b></div>
                            </div> 
                        </div>
                    </div>
                   
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/types.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6"><!--validatePassword();-->
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                        if ($_REQUEST['id'] != '') {
                                            echo 'UPDATE';
                                        } else {
                                            echo 'SAVE';
                                        }
                                ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>