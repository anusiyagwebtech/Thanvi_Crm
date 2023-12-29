<?php
$menu = '2,2,5';
if (isset($_REQUEST['paid'])) {
    $thispageeditid = 15;
} else {
    $thispageid = 15;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');
include 'uploadimage.php';

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['paid'];
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($imagetitle != '') {
        $imagec = $imagetitle;
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    $pimage = getourpartners('image', $getid);

    if ($imag) {
        if ($pimage != '') {
            unlink("../../../images/ourpartners/" . $pimage);
            unlink("../../../images/ourpartners/thump/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 350;
        $height = 150;
        $width1 = 200;
        $height1 = 200;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = $imagec;
            $imagev = $m . "." . $extension;
            $thumppath = "../../../images/ourpartners/";
            $filepath = "../../../images/ourpartners/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $filepath, $filepath, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['paid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') {
        $msg = addourpartners($title, $externallink,$image, $imagealt, $imagetitle, $order, $status, $ip, $getid);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-cross"></i> Image Format was Invalid., Please Use JPG, PNG, GIF Format</h4></div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gallery Mgmt
            <small><?php
if ($_REQUEST['paid']) {
    echo 'Edit';
} else {
    echo 'Add New';
}
?> Gallery Mgmt </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> Master(s)</a></li>
            <li><a href="<?php echo $sitename; ?>master/ourpartners.htm">Our Partners Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['paid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Our Partners Mgmt</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                if ($_REQUEST['paid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Our Partners Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Our Partners Mgmt
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title<span style="color:#FF0000;">*</span></label>  
                                    <input type="text" class="form-control" placeholder="Enter the Title" name="title" id="title" required="required" pattern="[0-9 A-Z a-z .,:'()]{2,255}" title="Allowed Characters (0-9 A-Z a-z .,:'()]{2,255})" value='<?php echo stripslashes(getourpartners('title', $_REQUEST['paid'])); ?>' />
                                </div>
                                <div class="col-md-6">
                                    <label>External Link<span style="color:#FF0000;">*</span></label>  
                                    <input type="text" class="form-control" placeholder="Enter the External Link" name="externallink" id="externallink" required="required" value='<?php echo stripslashes(getourpartners('external_link', $_REQUEST['paid'])); ?>' />
                                </div>
                            </div><br/>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagealt" class="form-control" value="<?php echo getourpartners('imagealt', $_REQUEST['paid']); ?>" required />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagetitle" pattern="[A-Za-z0-9 -_]{2,110}" class="form-control" value="<?php echo getourpartners('imagetitle', $_REQUEST['paid']); ?>" required />                     
                                    </div>
                                </div>
                            </div>

                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 350 Pixels Width * 150 Pixels Height)</span></label>
                                        <input class="form-control spinner" <?php if (getourpartners('image', $_REQUEST['paid']) == '') { ?> required="required" <?php } ?> name="image" type="file"> 
                                    </div>
                                </div>
                                <?php if (getourpartners('image', $_REQUEST['paid']) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/ourpartners/thump/<?php echo getourpartners('image', $_REQUEST['paid']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getourpartners('image', $_REQUEST['paid']); ?>', '<?php echo $_REQUEST['paid']; ?>', 'gallery', '../../images/ourpartners/', 'image', 'paid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" required="required " class="form-control" name="order" value="<?php echo getourpartners('order', $_REQUEST['paid']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                if (getourpartners('status', $_REQUEST['paid']) == '1') {
                                    echo 'selected';
                                }
                                ?>>Active</option>
                                        <option value="0" <?php
                                        if (getourpartners('status', $_REQUEST['paid']) == '0') {
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
                            <a href="<?php echo $sitename; ?>master/ourpartners.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                        if ($_REQUEST['paid'] != '') {
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