<?php
$menu = '4,12,12';

if (isset($_REQUEST['nid'])) {
    $thispageeditid = 4;
} else {
    $thispageid =4;
}
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['nid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext = '0';
    if ($imagetitle != '') {
        $imagec = $imagetitle;
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
	if ($getid != '') {
		
        $linkimge = $db->prepare("SELECT * FROM `news_banner` WHERE `nid` = ? ");
        $linkimge->execute(array($getid));
        $linkimge1 = $linkimge->fetch();
        $pimage = $linkimge1['image'];
    }
    if ($imag) {
        if ($pimage != '') {			
            unlink("../../images/banner/" . $pimage);
            unlink("../../images/banner/thump/" . $pimage);
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
            $m = strtolower($imagec);
            $imagev = $m . "." . $extension;
            $thumppath = "../../images/banner/";
            $thumppath1 = "../../images/banner/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $thumppath1, $thumppath1, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['nid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') {
        $msg = addbanner4($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid);
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
           News banner Mgmt
            <small><?php
                if ($_REQUEST['nid']) {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> banner Mgmt </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-newspaper-o"></i> News</a></li>
            <li><a href="<?php echo $sitename; ?>pages/news/banner2.htm">banner Mgmt</a></li>
            <li class="active"><?php
                if ($_REQUEST['nid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> banner Mgmt</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['nid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> banner Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            banner Mgmt
                        </div>
                        <div class="panel-body">                        
                           <!--  <div class="row">
                                <div class="col-md-6">
                                    <label>Events title <span style="color:#FF0000;">*</span></label>
                                    <input name="title" id="title" class="form-control" required="required" placeholder="Enter the Events Title" value="<?php echo stripslashes(getnews('title',$_REQUEST['nid'])); ?>" />
                                </div>
								<div class="col-md-6">
                                    <label>Events Date<span style="color:#FF0000;"> *</span></label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right usedatepicker" name="date" required="required"  value="<?php
                                        if (isset($_REQUEST['nid']) && (date('d-m-Y', strtotime(getnews('date', $_REQUEST['nid']))) != '01-01-1970')) {
                                            echo date('d-m-Y', strtotime(getnews('date', $_REQUEST['nid'])));
                                        } else {
                                            echo date('d-m-Y');
                                        }
                                        ?>" >
                                    </div>
                                </div>
                            </div> -->
                            <div class="clearfix"><br /></div>
							
                           <!--  <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Link<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="link" class="form-control" placeholder="Enter Link" pattern="[A-Za-z0-9-_]{2,110}" value="<?php echo getnews('link', $_REQUEST['nid']); ?>" required />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagetitle" pattern="[a-z0-9-_]{2,255}" title="Allowed Characters (a-z0-9-_){2,255})" placeholder="Enter the Image Name" class="form-control" value="<?php echo getnews('image_name', $_REQUEST['nid']); ?>" required />                     
                                    </div>
                                </div>
                            </div> -->
						<!--	<div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagealt" class="form-control" placeholder="Enter Image Alt Tag" value="<?php echo getnews('image_alt', $_REQUEST['nid']); ?>" required />                     
                                    </div>
                                </div> 
                                
                            </div>-->
                            <div class="clearfix"><br /></div>
							
                            <div class="row">  
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagename" pattern="[a-z0-9-_]{2,255}" title="Allowed Characters (a-z0-9-_){2,255})" placeholder="Enter the Image Name" class="form-control" value="<?php echo getbanner3('image_name', $_REQUEST['nid']); ?>" required />                     
                                    </div>
                                </div>                                           
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 1000 Pixels Width * 1000 Pixels Height)</span></label>
                                        <input class="form-control spinner" <?php if (getbanner3('image', $_REQUEST['nid']) == '') { ?> required="required" <?php } ?> name="image" type="file"> 
                                    </div>
                                </div>
                                <?php if (getbanner3('image', $_REQUEST['nid']) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/banner/<?php echo getbanner3('image', $_REQUEST['nid']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getbanner3('image', $_REQUEST['nid']); ?>', '<?php echo $_REQUEST['nid']; ?>', 'banner', '../../images/banner/thump', 'image', 'nid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="clearfix"><br /></div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Heading<span style="color:#FF0000;"> *</span></label>                                  
										 <textarea id="content1" name="content1" class="form-control" ><?php echo getbanner3('content1', $_REQUEST['nid']); ?></textarea>
									</div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Content<span style="color:#FF0000;"> *</span></label>                                  
                                         <textarea id="content" name="content" class="form-control" ><?php echo getbanner3('content', $_REQUEST['nid']); ?></textarea>
                                    </div>
                                </div>
							</div>
					
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" required="required " class="form-control" placeholder="Enter the Order" name="order" value="<?php echo getbanner3('order', $_REQUEST['nid']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if (getbanner3('status', $_REQUEST['nid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getbanner3('status', $_REQUEST['nid']) == '0') {
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
                            <a href="<?php echo $sitename; ?>news/banner2.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['nid'] != '') {
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