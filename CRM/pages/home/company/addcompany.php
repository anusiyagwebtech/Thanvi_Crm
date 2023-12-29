<?php
$menu = '2,4,4';

if (isset($_REQUEST['cid'])) {
    $thispageeditid = 4;
} else {
    $thispageid = 4;
}
include ('../../../config/config.inc.php');
$dynamic = '1';
include ('../../../require/header.php');

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['cid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext = '0';
    if ($imagetitle != '') {
        $imagec = $imagetitle;
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
	if ($getid != '') {
		
        $linkimge = $db->prepare("SELECT * FROM `company` WHERE `cid` = ? ");
        $linkimge->execute(array($getid));
        $linkimge1 = $linkimge->fetch();
        $pimage = $linkimge1['image'];
    }
    if ($imag) {
        if ($pimage != '') {			
            unlink("../../../images/company/" . $pimage);
            unlink("../../../images/company/thump/" . $pimage);
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
            $thumppath = "../../../images/company/";
            $thumppath1 = "../../../images/company/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $thumppath1, $thumppath1, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['cid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') {
        $msg = addcompany1($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid);
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
            Home Company Mgmt
            <small><?php
                if ($_REQUEST['cid']) {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Company Mgmt </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-newspaper-o"></i> Home</a></li>
            <li><a href="<?php echo $sitename; ?>pages/home/company/company.htm">Company Mgmt</a></li>
            <li class="active"><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Company Mgmt</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['cid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Company Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Company Mgmt
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
                                        <input type="text" name="imagename" pattern="[a-z0-9-_]{2,255}" title="Allowed Characters (a-z0-9-_){2,255})" placeholder="Enter the Image Name" class="form-control" value="<?php echo getcompany1('image_name', $_REQUEST['cid']); ?>" required />                     
                                    </div>
                                </div>                                           
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 1000 Pixels Width * 1000 Pixels Height)</span></label>
                                        <input class="form-control spinner" <?php if (getcompany1('image', $_REQUEST['cid']) == '') { ?> required="required" <?php } ?> name="image" type="file"> 
                                    </div>
                                </div>
                                <?php if (getcompany1('image', $_REQUEST['cid']) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/company/<?php echo getcompany1('image', $_REQUEST['cid']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getcompany1('image', $_REQUEST['cid']); ?>', '<?php echo $_REQUEST['cid']; ?>', 'company', '../../images/company/thump', 'image', 'cid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="clearfix"><br /></div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Card Heading<span style="color:#FF0000;"> *</span></label>                                  
										 <textarea id="content1" name="content1" class="form-control" ><?php echo getcompany1('content1', $_REQUEST['cid']); ?></textarea>
									</div>
								</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Card Content<span style="color:#FF0000;"> *</span></label>                                  
                                         <textarea id="content" name="content" class="form-control" ><?php echo getcompany1('content', $_REQUEST['cid']); ?></textarea>
                                    </div>
                                </div>
							</div>
					
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" required="required " class="form-control" placeholder="Enter the Order" name="order" value="<?php echo getcompany1('order', $_REQUEST['cid']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if (getcompany1('status', $_REQUEST['cid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getcompany1('status', $_REQUEST['cid']) == '0') {
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
                            <a href="<?php echo $sitename; ?>home/company/company.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['cid'] != '') {
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
<?php include ('../../../require/footer.php'); ?>