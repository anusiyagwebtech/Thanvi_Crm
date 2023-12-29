<?php
$menu = '2,2,6';

if (isset($_REQUEST['sid'])) {
    $thispageeditid = 16;
} else {
    $thispageid = 16;
}

include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');
include 'uploadimage.php';

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['sid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext='0';
    if ($imagename != '') {
        $imagec = $imagename;
    } else {
        $imagec = time();
    }
    $imag = strtolower($_FILES["image"]["name"]);
    $pimage = getservices('image', $getid);
    
    if ($imag) {
        if ($pimage != '') {
            unlink("../../../images/services/" . $pimage);
            unlink("../../../images/services/thump/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 1000;
        $height = 1000;
        $width1 = 200;
        $height1 = 200;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = $imagec;
            $imagev = $m . "." . $extension;
            $thumppath = "../../../images/services/";
            $filepath = "../../../images/services/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $filepath, $filepath, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['sid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') {
        $msg = addservice($title, $link, $description, $image, $imagename, $imagealt, $order, $status, $meta_title, $meta_keywords, $meta_description, $ip, $getid);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-cross"></i> Image Format was Invalid., Please Use JPG, PNG, GIF Format</h4></div>';
    }
   
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>Services Mgmt<small><?php
                if ($_REQUEST['sid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Service </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>
            <li><a href="<?php echo $sitename; ?>master/services.htm">Services Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['sid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Service Mgmt</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['sid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Service</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Service Mgmt
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Title<span style="color:#FF0000;">*</span></label>  
                                    <input type="text" class="form-control" placeholder="Enter the Title" name="title" id="title" required="required" pattern="[0-9 A-Z a-z .,:'()]{2,255}" title="Allowed Characters (0-9 A-Z a-z .,:'()]{2,255})" value='<?php echo stripslashes(getservices('title', $_REQUEST['sid'])); ?>' />
                                </div>
                                <div class="col-md-6">
                                    <label>Link </label>
                                    <input type="text" class="form-control" placeholder="Enter the External Link" name="link" id="link" pattern="[0-9A-Za-z_#-]{0,60}" title="Allowed Characters [0-9A-Za-z_#-]{0,60}" value="<?php echo getservices('link', $_REQUEST['sid']); ?>" />
                                </div>

                            </div>
                            
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagealt" class="form-control" value="<?php echo getservices('image_alt', $_REQUEST['sid']); ?>" required />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagename" pattern="[A-Za-z0-9 -_]{2,110}" class="form-control" value="<?php echo getservices('imagename', $_REQUEST['sid']); ?>" required />                     
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 1000 Pixels Width * 1000 Pixels Height)</span></label>
                                        <input class="form-control spinner" <?php if (getservices('image', $_REQUEST['sid']) == '') { ?> required="required" <?php } ?> name="image" type="file"> 
                                    </div>
                                </div>
                                <?php if (getservices('image', $_REQUEST['sid']) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/services/<?php echo getservices('image', $_REQUEST['sid']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getservices('image', $_REQUEST['sid']); ?>', '<?php echo $_REQUEST['sid']; ?>', 'services', '../../images/services/', 'image', 'sid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Content <span style="color:#FF0000;"></span></label>
                                    <textarea id="editor1" name="description" class="form-control" rows="5" cols="80"><?php echo getservices('content', $_REQUEST['sid']); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" required="required " class="form-control" name="order" value="<?php echo stripslashes(getservices('order', $_REQUEST['sid'])); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if (stripslashes(getservices('status', $_REQUEST['sid'])) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (stripslashes(getservices('status', $_REQUEST['sid']) == '0')) {
                                            echo 'selected';
                                        }
                                        ?>>Inactive</option>

                                    </select>
                                </div>

                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="panel panel-info">
                                <div class="panel-heading">SEO Details</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Meta Title</label>
                                            <textarea name='meta_title' id="meta_title" placeholder="Enter the Meta Title" class="form-control"><?php echo stripslashes(getservices('meta_title', $_REQUEST['sid'])); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="clearfix"><br /></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Meta Keywords</label>
                                            <textarea name='meta_keywords' id="meta_keywords" placeholder="Enter the Meta Keywords" class="form-control"><?php echo stripslashes(getservices('meta_keywords', $_REQUEST['sid'])); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="clearfix"><br /></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Meta Description</label>
                                            <textarea name='meta_description' id="meta_description" placeholder="Enter the Meta Description" class="form-control"><?php echo stripslashes(getservices('meta_description', $_REQUEST['sid'])); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="clearfix"><br /></div>
                                </div>
                            </div>
                        </div><br/>

                    </div>

                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>master/services.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6"><!--validatePassword();-->
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['sid'] != '') {
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