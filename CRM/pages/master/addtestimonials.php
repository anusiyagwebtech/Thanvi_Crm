<?php
$menu = '2,2,7';
if (isset($_REQUEST['tid'])) {
    $thispageeditid = 17;
} else {
    $thispageid = 17;
}

include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['tid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = addtestimonials($title, $designation, $content, $order, $status, $ip, $getid);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Testimonials Mgmt
            <small><?php
                if ($_REQUEST['tid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Testimonials Mgmt </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>
            <li><a href="<?php echo $sitename; ?>master/testimonial.htm">Testimonial Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['tid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Testimonial</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['tid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Testimonial Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Testimonial Mgmt
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title<span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter the Name" name="title" id="title" required="required" pattern="[0-9 A-Z a-z .,:'()]{2,255}" title="Allowed Characters (0-9 A-Z a-z .,:'()]{2,255})" value="<?php echo gettestimonials('title', $_REQUEST['tid']); ?>" />
                                </div>
                           
                                <div class="col-md-6">
                                    <label>Designation<span style="color:#FF0000;">*</span></label>  
                                    <textarea required="required" class="form-control" name="designation" placeholder="Enter Designation"><?php echo gettestimonials('Designation', $_REQUEST['tid']); ?></textarea>
                                </div>
                            </div><br/>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Content<span style="color:#FF0000;">* (350 Characters Only Allowed)</span></label>  
                                    <textarea id="editor1" name="content" class="form-control" rows="5" cols="80"><?php echo gettestimonials('Content', $_REQUEST['tid']); ?></textarea>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" required="required " class="form-control" name="order" value="<?php echo gettestimonials('order', $_REQUEST['tid']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if (gettestimonials('status', $_REQUEST['tid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (gettestimonials('status', $_REQUEST['tid']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div><br/>
                    </div>

                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/testimonials.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6"><!--validatePassword();-->
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['tid'] != '') {
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


