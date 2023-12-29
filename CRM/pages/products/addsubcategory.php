<?php
$menu = "4,4,9";
global $db;
if (isset($_REQUEST['id'])) {
    $thispageeditid = 19;
} else {
    $thispageid = 19;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');
include_once "../master/uploadimage.php";

if (isset($_REQUEST['submit'])) {
    $i = 1;
    @extract($_REQUEST);
    $_SESSION['subcategory_id'] = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $cid_im = implode(",", $cid);
    $strupload = '1';

    $vaal = checkimage12('subcategory', $imagename, 'sid', $_REQUEST['id']);

    if ($vaal == 'true') {
        $pimage = getsubcategory('image', $_REQUEST['id']);
        $imag = strtolower($_FILES["image"]["name"]);
        if ($imag) {
            $main = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            $size = $_FILES['image']['size'];
            $extension = getExtension($main);
            $extension = strtolower($extension);

            if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif') || ($extension == 'jpeg')) {
                if ($pimage != '') {
                    unlink("../../../images/subcategory/" . $pimage);
                }
                $width = 500;
                $height = 500;
                $m = trim($imagename);
                $image = strtolower($m) . "." . $extension;
                $thumppath = "../../../images/subcategory/";
                $aaa = Imageuploadd($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            } else {
                $strupload = '2';
                $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i> Invalid File Format! Try jpg/png/gif/jpeg files only </div>';
            }
        } else {
            $image = '';
            if (isset($_REQUEST['id'])) {
                $image = $pimage;
            }
        }

        if ($strupload == '1') {
            if ($menuop == '') {
                $menuop = 0;
            }
            $msg = addsubcategory($cid_im, $subcategory, $link, $image, $imagename, $imagealt, $menuop, $description, $metatitle, $metakeywords, $metadescription, $order, $status, $ip, $_REQUEST['id'], $thispageid);
        }
    } 
    else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i> Image name Already Exist!! try Different</div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sub Category Mgmt
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Sub Category Details </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> Dynamic Pages</a></li>
            <li><a href="<?php echo $sitename; ?>products/subcategory.htm"> Sub Category Details </a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Sub Category Details</li>
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
                        ?> Sub Category Details</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Sub Category Details
                        </div>
                        <div class="panel-body">                        
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Category Name <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="cid[]" class="form-control" required multiple="multiple">
                                        <option value="">Select Category</option>
                                        <?php
                                        $s = $db->prepare("SELECT * FROM `category` WHERE `status`= ? ");
                                        $s->execute(array('1'));
                                        while ($cate = $s->fetch()) {
                                            ?>
                                            <option value="<?php echo $cate['cid']; ?>" <?php
                                            $sel = getsubcategory('cid', $_REQUEST['id']);
                                            $sel = explode(',', $sel);
                                            if (in_array($cate['cid'], $sel)) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $cate['category']; ?></option>
                                                <?php } ?>
                                    </select>
                                </div>  
                                <div class="col-md-4">
                                    <label>SubCategory Name <span style="color:#FF0000;">*</span></label>                                  
                                    <input type="text" name="subcategory" id="category" placeholder="Enter The SubCategory Name" class="form-control" value="<?php echo getsubcategory('subcategory', $_REQUEST['id']); ?>" pattern="[A-Z a-z 0-9 .,&_-]{1,55}" title="Special character not allowed." required />
                                </div>  
                                <div class="col-md-4">
                                    <label>Link <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" required="required" placeholder="Enter The Link" name="link" id="link"  pattern="[A-Za-z0-9_-]{2,255}" title="Special character not allowed." value="<?php echo getsubcategory('link', $_REQUEST['id']); ?>"/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image</label>
                                    <input type="file" name="image" id="image" onchange="imgchktore(this.value)"/>
                                </div>

                                <?php if (getsubcategory('image', $_REQUEST['id']) != '') { ?>
                                    <div class="col-md-6" id="delimage">
                                        <img src="<?php echo $fsitename; ?>images/subcategory/<?php echo getsubcategory('image', $_REQUEST['id']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getsubcategory('image', $_REQUEST['id']); ?>', '<?php echo $_REQUEST['id']; ?>', 'subcategory', '../../images/subcategory/', 'image', 'sid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>

                                    </div>
                                <?php } ?>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image Name <span id="addstar" style="color:#FF0000;"></span></label>                                  
                                    <input type="text" name="imagename" id="imagenameid"  pattern="[A-Z a-z 0-9 _-]{1,55}" title="Special character not allowed." class="form-control"  placeholder="Enter The Image Name" value="<?php echo getsubcategory('image_name', $_REQUEST['id']); ?>"  />
                                </div> 
                                <div class="col-md-6">
                                    <label>Image Alt<span id="addstar1" style="color:#FF0000;"></span></label>                                  
                                    <input type="text"  id="imagealtid"  pattern="[A-Z a-z 0-9 _-]{1,55}" title="Special character not allowed." name="imagealt" class="form-control" placeholder="Enter The Image Alternate Name" value="<?php echo getsubcategory('image_alt', $_REQUEST['id']); ?>"  />                                    </div>
                            </div><br/>

                            <div class="row">

                                <div class="col-md-12">
                                    <label>Description </label>
                                    <textarea name="description" id="editor1" class="form-control" placeholder="Enter The Description"><?php echo getsubcategory('description', $_REQUEST['id']); ?></textarea>
                                </div>
                            </div><br/>
                            <div class="row">

                                <div class="col-md-4">
                                    <label> 
                                        <input type="checkbox" name="menuop" id="menuop" value="1"
                                        <?php
                                        if ($_REQUEST['id'] != '') {
                                            $ched = getsubcategory('menu', $_REQUEST['id']);
                                            if ($ched == '1') {
                                                echo 'checked="checked"';
                                            }
                                        }
                                        ?>> Show in Menu</label>
                                </div>
                                <div class="col-md-4">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" class="form-control" required="" name="order" placeholder="Order" value="<?php echo getsubcategory('order', $_REQUEST['id']); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if (getsubcategory('status', $_REQUEST['id']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getsubcategory('status', $_REQUEST['id']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>Inactive</option>

                                    </select>
                                </div>
                                <div id="txtHint1"><b></b></div>
                            </div> 
                        </div>
                    </div>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            SEO
                        </div>
                        <div class="panel-body">  
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Meta Title</label>
                                    <input type="text" name="metatitle" id="metatitle"  class="form-control"  title="Allowed Characters (a-zA-Z ()0-9-)(3-20)" placeholder="Enter The Metatitle" value="<?php echo getsubcategory('metatitle', $_REQUEST['id']); ?>" />
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Meta Keywords</label>
                                    <textarea name="metakeywords" class="form-control" placeholder="Enter The Meta Keyword" id="metakeywords"><?php echo getsubcategory('metakeywords', $_REQUEST['id']); ?></textarea>
                                </div> 
                            </div><br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Meta Description</label>
                                    <textarea name="metadescription" class="form-control" placeholder="Enter The Meta Description" id="metadescription"><?php echo getsubcategory('metadescription', $_REQUEST['id']); ?></textarea>
                                </div>   
                            </div>
                            <br />     
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>products/subcategory.htm">Back to Listings page</a>
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