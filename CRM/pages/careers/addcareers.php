<?php
$menu = '3,3,3';

if (isset($_REQUEST['cid'])) {
    $thispageeditid = 18;
} else {
    $thispageid = 18;
}
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');

$getmanuf = $db->prepare("SELECT * FROM `careers` ORDER BY `cid` DESC");
$getmanuf->execute();
$lst = $getmanuf->fetch(PDO::FETCH_ASSOC);

if ($lst['cid'] == '' || $lst['cid'] == '0') {
    $val = 1;
    $purid = 'POI' . str_pad(1, 8, '0', STR_PAD_LEFT);
    $purid = get_bill_settings('prefix', '1') . str_pad(get_bill_settings('current_value', '1'), get_bill_settings('format', '1'), '0', STR_PAD_LEFT);
} else {
    $val = $lst['cid'] + 1;
   $purid = get_bill_settings('prefix','1') . str_pad(get_bill_settings('current_value','1'), get_bill_settings('format','1'), '0', STR_PAD_LEFT);;
}


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['cid'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $msg = addcareers($jobcode, $title,$jobtype,$location,$shortdescription,$link, $experience, $salary, $content, $order, $status, $ip, $getid);
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Careers Mgmt
            <small><?php
                if ($_REQUEST['cid']) {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Careers Mgmt </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-newspaper-o"></i> Careers</a></li>
            <li><a href="<?php echo $sitename; ?>careers/careers.htm">Careers Mgmt</a></li>
            <li class="active"><?php
                if ($_REQUEST['cid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Careers Mgmt</li>
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
                        ?> Careers Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Careers Mgmt
                        </div>
                        <div class="panel-body">                         
                            <div class="row">								
								<div class="col-md-6">
                                    <label>Job Code<span style="color:#FF0000;">*</span>
                                    </label>
                                    <input type="text" class="form-control" placeholder="Enter the Job Code" name="jobcode" id="jobcode" required="required" value="<?php
                                    if ($_REQUEST['cid'] != '') {
                                        echo getcareers('jobcode', $_REQUEST['cid']);
                                    } 
                                    ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Job title <span style="color:#FF0000;">*</span></label>
                                    <input name="title" id="title" class="form-control" required="required" placeholder="Enter the Jobs Title" value="<?php echo stripslashes(getcareers('title',$_REQUEST['cid'])); ?>" />
                                </div>								
                            </div> 
							<div class="clearfix"><br /></div>
							<div class="row">
								<div class="col-md-6">
                                    <label>Job Type <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="jobtype" class="form-control">
                                        <option value="Permanent" <?php
                                        if (getcareers('jobtype', $_REQUEST['cid']) == 'Permanent') {
                                            echo 'selected';
                                        }
                                        ?>>Permanent</option>
                                        <option value="Temporary" <?php
                                        if (getcareers('jobtype', $_REQUEST['cid']) == 'Temporary') {
                                            echo 'selected';
                                        }
                                        ?>>Temporary</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Job Location <span style="color:#FF0000;">(City)*</span></label>
                                    <input type="text" name="location" id="location" pattern="[A-Za-z0-9 -_]{2,110}" class="form-control" required="required" placeholder="Enter the Job Location" value="<?php echo stripslashes(getcareers('location',$_REQUEST['cid'])); ?>" />
                                </div>				
                            </div>	
							<div class="clearfix"><br /></div>
							<div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label>Years of Experience </label>                                  
                                        <input type="text" name="experience" pattern="[A-Z a-z 0-9-+]{1,110}" placeholder="Enter the Years of Experience" class="form-control" value="<?php echo getcareers('experience', $_REQUEST['cid']); ?>" />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Salary (&#8377;)<span style="color:#FF0000;">*</span></label>
                                    <input type="text" name="salary" id="salary" pattern="[A-Z a-z 0-9 -]{2,110}" class="form-control" required="required" placeholder="Enter the Salary" value="<?php echo stripslashes(getcareers('salary',$_REQUEST['cid'])); ?>" />
                                </div>
								
                            </div><div class="clearfix"><br /></div>
							<div class="row">  
                                
							<!--	<div class="col-md-6">
                                    <div class="form-group">
                                        <label>Link<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="link" class="form-control" placeholder="Enter Link" pattern="[A-Za-z0-9-_]{2,110}" value="<?php echo getcareers('link', $_REQUEST['cid']); ?>" required />                     
                                    </div>
                                </div> -->
								<div class="col-md-12">
                                    <label>Short Description <span style="color:#FF0000;"></span></label>
                                    <textarea id="shortdescription" name="shortdescription" class="form-control" ><?php echo getcareers('shortdescription', $_REQUEST['cid']); ?></textarea>
                                </div>
                            </div>
                          <!--  <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagealt" class="form-control" placeholder="Enter Image Alt Tag" value="<?php echo getcareers('image_alt', $_REQUEST['cid']); ?>" required />                     
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                        <input type="text" name="imagetitle" pattern="[A-Za-z0-9 -_]{2,110}" placeholder="Enter the Image Name" class="form-control" value="<?php echo getcareers('image_name', $_REQUEST['cid']); ?>" required />                     
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">                                             
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label>Image <span style="color:#FF0000;"> *(Recommended Size 1000 Pixels Width * 1000 Pixels Height)</span></label>
                                        <input class="form-control spinner" <?php if (getnews('image', $_REQUEST['cid']) == '') { ?> required="required" <?php } ?> name="image" type="file"> 
                                    </div>
                                </div>
                                <?php if (getnews('image', $_REQUEST['cid']) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage">
                                        <label> </label>
                                        <img src="<?php echo $fsitename; ?>images/events/<?php echo getnews('image', $_REQUEST['cid']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getcareers('image', $_REQUEST['cid']); ?>', '<?php echo $_REQUEST['cid']; ?>', 'news', '../images/events/thump', 'image', 'cid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div> -->
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Job Description <span style="color:#FF0000;"></span></label>
                                    <textarea id="editor1" name="content" class="form-control" rows="5" cols="80"><?php echo getcareers('description', $_REQUEST['cid']); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" required="required " class="form-control" placeholder="Enter the Order" name="order" value="<?php echo getcareers('order', $_REQUEST['cid']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if (getcareers('status', $_REQUEST['cid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getcareers('status', $_REQUEST['cid']) == '0') {
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
                            <a href="<?php echo $sitename; ?>careers/careers.htm">Back to Listings page</a>
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
<?php include ('../../require/footer.php'); ?>