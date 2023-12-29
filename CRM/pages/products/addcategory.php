<?php
$menu = '4,4,8';
if (isset($_REQUEST['id'])) {
    $thispageeditid = 18;
} else {
    $thispageid = 18;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');
include_once "../master/uploadimage.php";

if (isset($_REQUEST['submit'])) {
    $i = 1;
    @extract($_REQUEST);
    $_SESSION['category_id'] = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $strupload = '1';
   
    $vaal=checkimage12('category', $imagename, 'cid', $_REQUEST['id']);
    
    if ($vaal == 'true') {
        $pimage = getcategory('image', $_REQUEST['id']);
        $imag = strtolower($_FILES["image"]["name"]);
        if ($imag) {
            $main = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            $size = $_FILES['image']['size'];
            $extension = getExtension($main);
            $extension = strtolower($extension);

            if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif') || ($extension == 'jpeg')) {
                if ($pimage != '') {
                    unlink("../../../images/category/" . $pimage);
                }
                $width = 500;
                $height = 500;
                $m = trim($imagename);
                $image = strtolower($m) . "." . $extension;
                $thumppath = "../../../images/category/";
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
            if ($home == '') {
                $home = 0;
            }
            $msg = addcategory($category, strtolower($link), $icon, $image, $imagename, $imagealt, $menuop, $home, $description, $metatitle, $metakeywords, $metadescription, $order, $status, $ip, $_REQUEST['id'], $thispageid);
        }
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-close"></i> Image name Already Exist!! try Different</div>';
    }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Category Mgmt
            <small><?php
if ($_REQUEST['id'] != '') {
    echo 'Edit';
} else {
    echo 'Add New';
}
?> Category Mgmt </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-product-hunt"></i> Product(s)</a></li>
            <li><a href="<?php echo $sitename; ?>products/category.htm">Category Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
?> Category Mgmt</li>
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
?> Category Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Category Mgmt
                        </div>
                        <div class="panel-body">                        
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Category Name <span style="color:#FF0000;">*</span></label>                                  
                                    <input type="text" name="category" id="category" placeholder="Enter The Category Name" class="form-control" value="<?php echo getcategory('category', $_REQUEST['id']); ?>"  pattern="[A-Z a-z 0-9 .,&_-]{1,55}" title="Special character not allowed." required />
                                </div>  
                                <div class="col-md-4">
                                    <label>Link <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" required="required" placeholder="Enter The Link"   pattern="[A-Za-z0-9_-]{2,255}" title="Special character not allowed." name="link" id="link" value="<?php echo strtolower(getcategory('link', $_REQUEST['id'])); ?>"/>
                                </div>
                                <div class="col-md-4">
                                    <label style="width:100%;">Font Awesome Icon <a href="http://fontawesome.io/icons/" target="_blank" style=" float:right; font-size:12px;">(List of Icons)</a></label>
                                    <input type="text" class="form-control" required="required" placeholder="fa fa-icon" pattern="[A-Z a-z 0-9.,&_-]{1,55}" title="Special character not allowed." name="icon" id="icon" value="<?php echo strtolower(getcategory('icon', $_REQUEST['id'])); ?>"/>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image Name <span id="addstar" style="color:#FF0000;"></span></label>                                  
                                    <input type="text" name="imagename" id="imagenameid"  pattern="[A-Z a-z 0-9 .,&_-]{1,55}" title="Special character not allowed." class="form-control" placeholder="Enter The Image Name" value="<?php echo getcategory('image_name', $_REQUEST['id']); ?>"  />
                                </div> 
                                <div class="col-md-6">
                                    <label>Image Alt <span id="addstar1" style="color:#FF0000;"></span></label>                                  
                                    <input type="text" name="imagealt"   pattern="[A-Z a-z 0-9 .,&_-]{1,55}" title="Special character not allowed." id="imagealtid"  class="form-control" placeholder="Enter The Image Alternate Name" value="<?php echo getcategory('image_alt', $_REQUEST['id']); ?>"  /> 
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image </label>
                                    <input type="file" name="image" id="image" onchange="imgchktore(this.value)" />
                                </div>
                                <?php if (getcategory('image', $_REQUEST['id']) != '') { ?>
                                    <div class="col-md-6" id="delimage">
                                        <img src="<?php echo $fsitename; ?>images/category/<?php echo getcategory('image', $_REQUEST['id']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getcategory('image', $_REQUEST['id']); ?>', '<?php echo $_REQUEST['id']; ?>', 'category', '../../images/category/', 'image', 'cid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                                <?php } ?>
                            </div>
                            <br />

                            <div class="row">

                                <div class="col-md-12">
                                    <label>Description</label>
                                    <textarea name="description" id="editor1" class="form-control" placeholder="Enter The Description"><?php echo getcategory('description', $_REQUEST['id']); ?></textarea>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-4">
                                    <label> 
                                        <input type="checkbox" name="menuop"  id="menuop"  value="1"
                                        <?php
                                        if ($_REQUEST['id'] != '') {
                                            $ched = getcategory('menu', $_REQUEST['id']);
                                            if ($ched == '1') {
                                                echo 'checked="checked"';
                                            }
                                        }
                                        ?>> Show in Menu<span style="color:#FF0000;" >*</span></label>
                                </div> 
                                <div class="col-md-4">
                                    <label>
                                        <input type="checkbox" name="home"  id="home" value="1"<?php
                                        if ($_REQUEST['id'] != '') {
                                            $ched = getcategory('home_page', $_REQUEST['id']);
                                            if ($ched == '1') {
                                                echo 'checked="checked"';
                                            }
                                        }
                                        ?>> Show in Home Page <span style="color:#FF0000;">*</span> </label>
                                </div>
                            </div> <br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" class="form-control" name="order" required="required" placeholder="Order" value="<?php echo getcategory('order', $_REQUEST['id']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if (getcategory('status', $_REQUEST['id']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getcategory('status', $_REQUEST['id']) == '0') {
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
                                    <input type="text" name="metatitle" id="metatitle" class="form-control" pattern="[A-Z a-z 0-9 .,&_-]{1,55}" title="Special character not allowed."  placeholder="Enter The Meta title" value="<?php echo getcategory('metatitle', $_REQUEST['id']); ?>" />
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    <label>Meta Keywords </label>
                                    <textarea name="metakeywords" class="form-control" id="metakeywords" placeholder="Enter The Meta Keywords"><?php echo getcategory('metakeywords', $_REQUEST['id']); ?></textarea>
                                </div>
                                <br/>
                                <div class="col-md-12">
                                    <label>Meta Description </label>
                                    <textarea name="metadescription" class="form-control"  id="metadescription" placeholder="Enter The Meta Description"><?php echo getcategory('metadescription', $_REQUEST['id']); ?></textarea>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>products/category.htm">Back to Listings page</a>
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