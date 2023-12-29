<?php
$menu = "5,5,12";

if (isset($_REQUEST['stid'])) {
    $thispageeditid = 22;
} else {
    $thispageid = 22;
}
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
include '../master/uploadimage.php';

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['stid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext = '0';
    if ($imagetitle != '') {
        $imagec = $imagetitle;
    } else {
        $imagec = time();
    }
    $imag = strtolower($_FILES["image"]["name"]);
    $pimage = getstaticpages('image', $getid);
    if ($imag) {
        if ($pimage != '') {
            unlink("../../../images/staticpages/" . $pimage);
            unlink("../../../images/staticpages/thump/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 1000;
        $height = 1000;
        $width1 = 300;
        $height1 = 300;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = $imagec;
            $imagev = $m . "." . $extension;
            $thumppath = "../../../images/staticpages/";
            $thumppath1 = "../../../images/staticpages/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $thumppath1, $thumppath1, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['stid'] != '') {
            $image = $pimage;
        } else {
            $image = '';
        }
    }    
    if ($ext != '1') {
        $msg = addstaticpagess($title, $metatitle, $metakeywords, $metadescription, $image_title, $image_alt, $image, $fullcontent, $shortdescription, $content2, $content3, $ip, $status, $getid);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-cross"></i> Image Format was Invalid., Please Use JPG, PNG, GIF Format</h4></div>';
    }
}

//if (isset($_REQUEST['submit'])) {
//    @extract($_REQUEST);
//    $getid = $_REQUEST['stid'];
//    $ip = $_SERVER['REMOTE_ADDR'];
//
//    if ($image_title != '') {
//        $imagec = $image_title;
//    } else {
//        $imagec = time();
//    }
//
//    $imag = strtolower($_FILES["image"]["name"]);
//    $pimage = getstaticpages('image', $getid);
//
//
//    if ($imag) {
//        if ($pimage != '') {
//            unlink("../../../images/staticpages/" . $pimage);
//            unlink("../../../images/staticpages/thump/" . $pimage);
//        }
//        $main = $_FILES['image']['name'];
//        $tmp = $_FILES['image']['tmp_name'];
//        $size = $_FILES['image']['size'];
//        $width = 1000;
//        $height = 1000;
//        $width1 = 200;
//        $height1 = 200;
//        $extension = getExtension($main);
//        $extension = strtolower($extension);
//        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
//            $m = $imagec;
//            $imagev = $m . "." . $extension;
//            $thumppath = "../../../images/staticpages/";
//            $thumppath1 = "../../../images/staticpages/thump/";
//            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
//            $bbb = Imageupload($main, $size, $width1, $thumppath1, $thumppath1, '255', '255', '255', $height1, strtolower($m), $tmp);
//        } else {
//            $ext = '1';
//        }
//        $image = $imagev;
//    } else {
//        $image = $pimage;
//    }
//    $msg = addstaticpagess($title, $metatitle, $metakeywords, $metadescription, $image_title, $image_alt, $image, $fullcontent, $shortdescription, $content2, $content3, $ip, $status, $getid);
//}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1><?php echo getstaticpages('title', $_REQUEST['stid']); ?></h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-id-card-o"></i>CMS</a></li>
            <li><a href="<?php echo $sitename; ?>CMS/staticpages.htm">Static Pages</a></li>
            <li class="active"><?php
                if ($_REQUEST['stid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;<?php echo $_REQUEST['title']; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data" autocomplete="off" >
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['stid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?>&nbsp;Static</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php
                    echo $msg;
                    if ($invalidmsg != '') {
                        echo $invalidmsg;
                    }
                    ?>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">SEO</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label> Title <span style="color:#FF0000;"></span></label>
                                    <input type="text" name="title" id="title" readonly="readonly" class="form-control" placeholder="Enter the Page Title" value="<?php echo getstaticpages('title', $_REQUEST['stid']); ?>" />
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <label>Meta Title <span style="color:#FF0000;"></span></label>
                                    <input type="text" name="metatitle" id="metatitle" class="form-control" placeholder="Enter the Meta Title" value="<?php echo getstaticpages('metatitle', $_REQUEST['stid']); ?>" />
                                </div>
                                <br />
                                <div class="col-md-12">
                                    <br />
                                    <label> Meta Keywords <span style="color:#FF0000;"></span></label>
                                    <textarea rows="3" cols="30" name="metakeywords" id="metakeywords" class="form-control" placeholder="Enter the Meta Keywords"><?php echo getstaticpages('metakeywords', $_REQUEST['stid']); ?></textarea>
                                </div>
                                <br />
                                <div class="col-md-12">
                                    <br />
                                    <label> Meta Description <span style="color:#FF0000;"></span></label>
                                    <textarea rows="3" cols="30" name="metadescription" id="metadescription" class="form-control" placeholder="Enter the Meta Description"><?php echo getstaticpages('metadescription', $_REQUEST['stid']); ?></textarea>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Image</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image Alt</label>
                                    <input type="text" class="form-control" pattern="[a-zA-Z 0-9 ,-.()]{2,200}" title="Special Charcters are not allowed" name="image_alt" id="image_alt" value="<?php echo getstaticpages('image_alt', $_REQUEST['stid']); ?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label>Image Title</label>
                                    <input type="text" class="form-control" pattern="[a-zA-Z0-9-]{2,200}" title="Special Charcters are not allowed" name="image_title" id="image_title" value="<?php echo getstaticpages('image_title', $_REQUEST['stid']); ?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label>Image</label>
                                    <input type="file" accept="image/*" class="form-control" name="image" id="image" />
                                </div>
                                <div class="col-md-6">
                                    <br>
                                    <label><font size="3"  color="red">Recommended Size(300 px X 300 px)</font></label>
                                </div>
                                <?php if (stripslashes(getstaticpages('image', $_REQUEST['stid'])) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/staticpages/<?php echo stripslashes(getstaticpages('image', $_REQUEST['stid'])); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deletemultiimage('<?php echo getstaticpages('image', $_REQUEST['stid']); ?>', <?php echo $_REQUEST['stid']; ?>, 'static_pages', '../../images/staticpages/', 'image', 'stid', 'delimage');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>   
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Short Description  <?php if ($_REQUEST['stid'] == '1') { ?>    1 <?php } ?></div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="shortdescription" class="form-control" placeholder="Enter the Short Description" style="width:100%;" ><?php echo (getstaticpages('shortcontent', $_REQUEST['stid'])); ?></textarea>
                                </div>
                                <div class="col-md-12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Contents  <?php if ($_REQUEST['stid'] == '1') { ?>    1 <?php } ?></div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea id="editor1" name="fullcontent" class="form-control" placeholder="Enter the Full Content" style="width:100%;" ><?php echo (getstaticpages('fullcontent', $_REQUEST['stid'])); ?></textarea>
                                </div>
                                <div class="col-md-12">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>CMS/staticpages.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['stid'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'INSERT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
        </form> 
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->

<script>

</script>

<?php include ('../../require/footer.php'); ?>