<?php
$menu = '4,4,11';

if (isset($_REQUEST['temid'])) {
    $thispageeditid = 21;
} else {
    $thispageid = 21;
}

include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
//include '../master/uploadimage.php';
$_SESSION['temid'] = '';
if (isset($_REQUEST['submit'])) {
    
    @extract($_REQUEST);
    $_SESSION['temid'] = $_REQUEST['temid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $msg = addnewstemplate($title, $subject, $editor1, $status, $ip, $_SESSION['temid']);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content-header">
        <h1>
           Newsletter Template
            <small>
                <?php
                if ($_REQUEST['temid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Newsletter Template
            </small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $sitename; ?>">
                    <i class="fa fa-dashboard">
                    </i>Dashboard
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-newspaper-o"></i>
                    Newsletter
                </a>
            </li>
            <li>
                <a href="<?php echo $sitename; ?>master/newslettertemp.htm">
                   Newsletter Template
                </a>
            </li>
            <li class="active">
                <?php
                if ($_REQUEST['temid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;Newsletter Template
            </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data"  >
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <?php
                        if ($_REQUEST['temid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?>&nbsp;Newsletter Template
                    </h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;">
                        <span style="color:#FF0000;">
                            *
                        </span>Marked Fields are Mandatory
                    </span>
                </div>
                <div class="box-body">
                    <?php echo $msg;
                    ?>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Title <span style="color:#FF0000;"> * </span></label>
                            <input type="text" name="title" id="title" required="required" class="form-control" placeholder="Enter the Title"    value="<?php echo getnewstemplate('newsletter_title', $_REQUEST['temid']); ?>" />
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Subject <span style="color:#FF0000;"> * </span></label>
                            <input type="text" name="subject" id="subject" required="required" class="form-control" placeholder="Enter the Subject"    value="<?php echo getnewstemplate('subject', $_REQUEST['temid']); ?>" />
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Content <span style="color:#FF0000;"> * </span></label>                            
                            <textarea id="editor1" name="editor1" style="width:100%;"><?php echo getnewstemplate('template', $_REQUEST['temid']); ?></textarea>
                        </div>
                    </div><br>
                    <div class="row">
                       
                        <div class="col-md-6">
                            <label>
                                Status
                                <span style="color:#FF0000;">
                                    *
                                </span>
                            </label>
                            <select name="status" id="status" required="required" class="form-control">
                                <option value="1" <?php
                                if (getnewstemplate('status', $_REQUEST['temid']) == '1') {
                                    echo 'selected';
                                }
                                ?>>
                                    Active
                                </option>
                                <option value="0" <?php
                                if (getnewstemplate('status', $_REQUEST['temid']) == '0') {
                                    echo 'selected';
                                }
                                ?>>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/newslettertemp.htm">
                                Back to Listings page
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;">
                                <?php
                                if ($_REQUEST['temid'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?>
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </form>
    </section><!-- /.content -->
</div>

<?php include ('../../require/footer.php'); ?>