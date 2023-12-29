<?php
$menu = '3,3,9';

if (isset($_REQUEST['bid'])) {
    $thispageeditid = 9;
} else {
    $thispageid = 9;
}
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
include '../master/uploadimage.php';

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['bid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext = '0';
    if ($imagetitle != '') {
        $imagec = $imagetitle;
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    $pimage = getblog('image', $getid);

    if ($imag) {
        if ($pimage != '') {
            unlink("../../../images/blog/" . $pimage);
            unlink("../../../images/blog/thump/" . $pimage);
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
            $thumppath = "../../../images/blog/";
            $thumppath1 = "../../../images/blog/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $thumppath1, $thumppath1, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['bid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') {
        $category = implode(",",$category);
        $msg = addblog($category, $title, $link, $image, $imagealt, $imagetitle, $content, $meta_title, $meta_keywords, $meta_description, $order, $status, $ip, $getid);
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
            Blog Mgmt
            <small><?php
                if ($_REQUEST['bid']) {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Blog Mgmt </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Blog</a></li>
            <li><a href="<?php echo $sitename; ?>blog/blog.htm">Blog Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['bid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Blog Mgmt</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['bid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Blog Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Blog Mgmt
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Category<span style="color:#FF0000;">*</span></label>
                                    <select name="category[]" id="category" class="form-control" required="required" multiple="multiple">
                                        <option value="">Select Category</option>
                                        <?php 
                                        $cat=pFETCH("SELECT * FROM `blogcategory` WHERE `status`=?",'1');
                                        $category = explode(',', getblog('category',$_REQUEST['bid']));
                                        while($fcat=$cat->fetch(PDO::FETCH_ASSOC))
                                        {
                                        ?>
                                        <option value="<?php echo $fcat['bcid']; ?>" <?php echo (in_array($fcat['bcid'], $category)) ? 'selected="selected"' : ''; ?>><?php echo stripslashes($fcat['category']); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Link<span style="color:#FF0000;">*</span></label>  
                                    <input type="text" class="form-control" placeholder="Enter the Link" name="link" id="link" required="required" pattern="[0-9A-Za-z_#-]{0,60}" title="Allowed Characters [0-9A-Za-z_#-]{0,60}" value='<?php echo stripslashes(getblog('link', $_REQUEST['bid'])); ?>' />
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Title <span style="color:#FF0000;"></span></label>
                                    <textarea name="title" id="title" class="form-control" placeholder="Enter the Blog Title"><?php echo stripslashes(getblog('title',$_REQUEST['bid'])); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagealt" class="form-control" placeholder="Enter Image Alt Tag" value="<?php echo getblog('image_alt', $_REQUEST['bid']); ?>" required />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagetitle" pattern="[A-Za-z0-9 -_]{2,110}" placeholder="Enter the Image Name" class="form-control" value="<?php echo getblog('image_name', $_REQUEST['bid']); ?>" required />                     
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 1000 Pixels Width * 1000 Pixels Height)</span></label>
                                        <input class="form-control spinner" <?php if (getblog('image', $_REQUEST['bid']) == '') { ?> required="required" <?php } ?> name="image" type="file"> 
                                    </div>
                                </div>
                                <?php if (getblog('image', $_REQUEST['bid']) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/blog/<?php echo getblog('image', $_REQUEST['bid']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getblog('image', $_REQUEST['bid']); ?>', '<?php echo $_REQUEST['bid']; ?>', 'blog', '../images/blog/', 'image', 'bid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Content <span style="color:#FF0000;"></span></label>
                                    <textarea id="editor1" name="content" class="form-control" rows="5" cols="80"><?php echo getblog('description', $_REQUEST['bid']); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" required="required " class="form-control" placeholder="Enter the Order" name="order" value="<?php echo getblog('order', $_REQUEST['bid']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if (getblog('status', $_REQUEST['bid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getblog('status', $_REQUEST['bid']) == '0') {
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
                                            <textarea name='meta_title' id="meta_title" placeholder="Enter the Meta Title" class="form-control"><?php echo stripslashes(getblog('meta_title',  $_REQUEST['bid'])); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="clearfix"><br /></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Meta Keywords</label>
                                            <textarea name='meta_keywords' id="meta_keywords" placeholder="Enter the Meta Keywords" class="form-control"><?php echo stripslashes(getblog('meta_keywords',  $_REQUEST['bid'])); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="clearfix"><br /></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Meta Description</label>
                                            <textarea name='meta_description' id="meta_description" placeholder="Enter the Meta Description" class="form-control"><?php echo stripslashes(getblog('meta_description',  $_REQUEST['bid'])); ?></textarea>
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
                            <a href="<?php echo $sitename; ?>blog/blog.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['bid'] != '') {
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