<?php
if (isset($_REQUEST['fid'])) {
    $thispageeditid = 21;
} else {
    $thispageaddid = 21;
}
$menu = "3,3,21";
include ('../../config/config.inc.php');
$dynamic = '1';
include ('../../require/header.php');
include ('../../config/uploadimage.php');
if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['flid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
          if ($imagename != '') {
        $imagec = $imagename;
    } else {
        $imagec = time();
    }
    $imag = strtolower($_FILES["image"]["name"]);
    if ($getid != '') {
        $linkimge = $db->prepare("SELECT * FROM `fleet` WHERE `fid` = ? ");
        $linkimge->execute(array($getid));
        $linkimge1 = $linkimge->fetch();
        $pimage = $linkimge1['image'];
    }
    if ($imag) {
        if ($pimage != '') {
            unlink("../../../images/fleet/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 1000;
        $height = 1000;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = $imagec;
            $imagev = $m . "." . $extension;
            $thumppath = "../../../images/fleet/";
            move_uploaded_file($tmp, $thumppath . $imagev);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['flid']!='') {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext == '1') {
        $msg = '<h4 class="icon fa fa-close" style="color:#e73d4a;"> <i class="icon fa fa-close" ></i> Select Image Only...!</h4>';
    } else {
        $title=gettypes('type', $type);
        
		 $msg = addfleet($title,$type, $link, $price,$amenities,$pricekm,$minprice,$adult,$children,$childseat,$luckage,$luckagecharge, $image, $imagename, $imagealt, $description, $order, $status, $pagetitle, $metatitle, $metakeywords, $metadescription,$ip, $getid);
    }
	
	



       
   
}
?>

<script>
    function getsubcategoryp(a, b)
    {
        $.ajax({
            url: "<?php echo $sitename; ?>pages/products/ajax_page.php",
            data: {subs: a, idss: b},
            success: function (data) {
                $("#sid" + b).html(data);
            }
        });
    }
    function getinnercategoryp(a, b)
    {
        $.ajax({
            url: "<?php echo $sitename; ?>pages/products/ajax_page.php",
            data: {inns: a, idss: b},
            success: function (data) {
                $("#nid" + b).html(data);
            }
        });
    }

    function additem()
    {
        $.ajax({
            url: "<?php echo $sitename; ?>pages/products/ajax_page.php",
            async: false,
            data: {add: 1},
            success: function (data) {
                $("#adddetails").append(data);
            }
        });
    }

    function setattrivalue(a)
    {
        $("#attribute_g_hidden").val(a);
    }
    function removethis(a, b)
    {
        $("#" + a).remove();
        //$(b).parent().parent().parent().remove();
    }
    function removethisattr(a)
    {
        var inc = parseInt($("#check_row").val()) - parseInt(1);
        $("#check_row").val(inc);

        if (parseInt(inc) === parseInt(0))
        {
            $("#attribute_group").removeAttr('disabled');
        }
        $("#remove_" + a).remove();
    }

    function insRow(e)
    {
        var last_row = document.getElementById("add_rows").rowIndex;
        if (last_row <= 6) {
            var x = document.getElementById('myTable').insertRow(last_row);

            var yx = document.getElementById('com').value = last_row;

            var y = x.insertCell(0);
            var w = x.insertCell(1);
            y.align = 'left';
            var dename = 'image[' + yx + ']';
            //alert(dename);
            y.innerHTML = "<input type='file' name='" + dename + "' id='" + dename + "'><img src='<?php echo $sitename; ?>images/delete-icon.gif' alt='Delete' title='Close' onclick='deleteRow(this);' style='cursor:pointer'><br/>";
            w.align = 'left';
            w.innerHTML = "";
        } else {
            alert('You are not allowed to add more than 7 images')
        }
    }

    function deleteRow(r)
    {
        var te = document.getElementById('com').value;
        for (i = te; i >= 1; i--)
        {
            document.getElementById('com').value = i - 1;
            document.getElementById('myTable').deleteRow(i);
            return false;
        }
    }
    function deletecheck()
    {
        if (confirm("Please confirm you want to delete this image. "))
        {
            return true;
        } else
        {
            return false;
        }
    }
    function additem_attr()
    {
        if ($("#attribute_g_hidden").val() === '')
        {
            alert('Please Select attribute group');
        } else
        {
            var inc = parseInt($("#check_row").val()) + parseInt(1);
            $.ajax({
                url: "<?php echo $sitename; ?>pages/products/ajax_page.php",
                data: {addattribute: $("#attribute_g_hidden").val(), inc: inc},
                success: function (data) {
                    $("#check_row").val(inc);
                    $("#addattribute").append(data);
                    $("#attribute_group").attr('disabled', 'disbled');
                }
            });
        }
    }
</script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Fleet
            <small><?php
                if ($_REQUEST['flid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Fleet</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Master(s)</a></li>            
            <li><a href="<?php echo $sitename; ?>dynamic/fleet.htm"><i class="fa fa-circle-o"></i> Fleet</a></li>
            <li class="active"><?php
                if ($_REQUEST['flid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Fleet</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['flid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Fleet</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Fleet Details</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <!--<div class="col-md-6">
                                    <label>Title <span style="color:#FF0000;"> *</span></label>
                                    <input type="text" class="form-control" placeholder="Enter the Title" name="title" id="title" pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="<?php echo getfleet('title', $_REQUEST['flid']); ?>" />
                                </div>-->
                                <div class="col-md-6">
                                    <label>Type <span style="color:#FF0000;"> *</span></label>
									<select name="type" class="form-control" required>
                                                        <option value="">Select Type</option>
                                                        <?php
                                                        $getmanuf = $db->prepare("SELECT * FROM `type`");
                                                        $getmanuf->execute(array());
                                                        $getmanuf1 = $getmanuf->rowCount();
                                                        while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                            <option value="<?php echo $fdepart['brid']; ?>"
                                                            <?php
                                                            if ($fdepart['brid'] == getfleet('type', $_REQUEST['flid']))
                                                            {
                                                                echo 'selected="selected"';
                                                            }
                                                            ?>><?php echo $fdepart['type']; ?></option>
                                                        <?php } ?>
                                                    </select>
					
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>External Link <span style="color:#FF0000;"> *</span></label>
                                    <input type="text" class="form-control" placeholder="Enter the External Link" name="link" id="link" pattern="[0-9 A-Z a-z .,:'()/]{0,255}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,255})" value="<?php echo getfleet('link', $_REQUEST['flid']); ?>" required/>
                                </div>
                                <div class="col-md-6">
                                    <label>Our Price<span style="color:#FF0000;"> *</span></label>
                                    <input type="text" class="form-control" placeholder="Enter the Price" name="price" id="price" pattern="[0-9 A-Z a-z .,:'()/]{0,255}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,255})" value="<?php echo getfleet('oprice', $_REQUEST['flid']); ?>" required/>
                                </div>
                            </div>
							<div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Amenities <span style="color:#FF0000;"> *</span></label>
                                    <textarea id="amenities" name="amenities" class="form-control" rows="5" cols="80" required><?php echo getfleet('amenities', $_REQUEST['flid']); ?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"><br /></div>
							<div class="row">
                                <div class="col-md-6">
                                    <label>Price Per KM<span style="color:#FF0000;"> *</span></label>
                                    <input type="text" class="form-control" placeholder="Enter the Price Per KM" name="pricekm" id="pricekm"  title="Allowed Characters (0-9A-Za-z .,:'()]{2,255})" value="<?php echo getfleet('pricekm', $_REQUEST['flid']); ?>" required />
                                </div>
                                <div class="col-md-6">
                                    <label>Minimum Price</label>
                                    <input type="text" class="form-control" placeholder="Enter the Min Price" name="minprice" id="minprice" pattern="[0-9 A-Z a-z .,:'()/]{0,255}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,255})" value="<?php echo getfleet('minprice', $_REQUEST['flid']); ?>" />
                                </div>
                            </div>
							<div class="clearfix"><br /></div>
							<div class="row">
                                <div class="col-md-6">
                                    <label>No of Adult(s)<span style="color:#FF0000;"> *</span></label>
									<input type="text" name="adult" id="adult" value="<?php echo getfleet('adult', $_REQUEST['flid']); ?>" pattern="[0-9 A-Z a-z .,:'()/]{0,255}" class="form-control" required>
									
								 </div>	
									<div class="col-md-6"> <label>No of Children(s)<span style="color:#FF0000;"> *</span></label>
									<input type="text" name="children" id="children" value="<?php echo getfleet('children', $_REQUEST['flid']); ?>" pattern="[0-9 A-Z a-z .,:'()/]{0,255}" class="form-control" required>
									
								 </div>	
								
                                
                            </div>
							<div class="clearfix"><br /></div>
                            <div class="row">
							<div class="col-md-6">	
                           <label>No of child seat(s)<span style="color:#FF0000;"> *</span></label>
									<input type="text" name="childseat" id="childseat" value="<?php echo getfleet('childseat', $_REQUEST['flid']); ?>" pattern="[0-9 A-Z a-z .,:'()/]{0,255}" class="form-control" required>
 </div>
                                <div class="col-md-1">
								
								<label>Luckage</label><br>
                                    <input type="checkbox" name="luckage" id="luckage" <?php if(getfleet('luckage', $_REQUEST['flid'])=='1') { ?> checked="checked" <?php } ?>/>
									</div>
									<div class="col-md-5">
									
                                    <label>Luckage Charges </label>
									<input type="text" class="form-control" placeholder="Enter the Luckage" name="luckagecharge" id="luckagecharge" pattern="[0-9 A-Z a-z .,:'()/]{0,255}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,255})" value="<?php echo getfleet('luckagecharge', $_REQUEST['flid']); ?>" />
									
                                    
                                </div>
                            </div>
							<div class="clearfix"><br /></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Description <span style="color:#FF0000;"></span></label>
                                    <textarea id="editor1" name="description" class="form-control" rows="5" cols="80"><?php echo getfleet('content', $_REQUEST['flid']); ?></textarea>
                                </div>
                            </div>
                           <div class="clearfix"><br /></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image Alt<span style="color:#FF0000;"> *</span></label>                                  
                                <input type="text" name="imagealt" class="form-control" value="<?php echo getfleet('image_alt', $_REQUEST['flid']); ?>" required />                     
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Image Name<span style="color:#FF0000;"> *</span></label>                                  
                                <input type="text" name="imagename" pattern="[A-Za-z0-9 -_]{2,110}" class="form-control" value="<?php echo getfleet('imagename', $_REQUEST['flid']); ?>" required />                     
                            </div>
                        </div>
                    </div>
                    <div class="row">                                             
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Image </label>
                                <input class="form-control spinner" <?php if (getfleet('image', $_REQUEST['flid']) == '') { ?> required="required" <?php } ?> name="image" type="file"> 
                            </div>
                        </div>
                        <?php if (getfleet('image', $_REQUEST['flid']) != '') { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12" id="delimage">
                                <label> </label>
                               <img src="<?php echo $fsitename; ?>images/fleet/<?php echo getfleet('image', $_REQUEST['flid']); ?>" style="padding-bottom:10px;" height="100" />
                               <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deleteimage('<?php echo getfleet('image', $_REQUEST['flid']); ?>', '<?php echo $_REQUEST['flid']; ?>', 'fleet', '../images/fleet/', 'image', 'fid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                    </div>
                        <?php } ?>
                    </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order <span style="color:#FF0000;">*</span></label>
                                    <input type="number" name="order" id="order" min="1" max="100" required="required" class="form-control" placeholder="Order" value="<?php echo getfleet('order', $_REQUEST['flid']); ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label>Status  <span style="color:#FF0000;">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" <?php
                                        if (getfleet('status', $_REQUEST['flid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getfleet('status', $_REQUEST['flid']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div></div>
                
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">SEO</div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label> Title <span style="color:#FF0000;"></span></label>
                                <input type="text" name="pagetitle" id="title" class="form-control" placeholder="Enter the Page Title" value="<?php echo getfleet('pagetitle', $_REQUEST['flid']); ?>" />
                            </div>
                            <div class="col-md-12">
                                <br>
                                <label>Meta Title <span style="color:#FF0000;"></span></label>
                                <input type="text" name="metatitle" id="metatitle" class="form-control" placeholder="Enter the Meta Title" value="<?php echo getfleet('metatitle', $_REQUEST['flid']); ?>" />
                            </div>
                            <br />
                            <div class="col-md-12">
                                <br />
                                <label> Meta Keywords <span style="color:#FF0000;"></span></label>
                                <textarea rows="3" cols="30" name="metakeywords" id="metakeywords" class="form-control" placeholder="Enter the Meta Keywords"><?php echo getfleet('metakeywords', $_REQUEST['flid']); ?></textarea>
                            </div>
                            <br />
                            <div class="col-md-12">
                                <br />
                                <label> Meta Description <span style="color:#FF0000;"></span></label>
                                <textarea rows="3" cols="30" name="metadescription" id="metadescription" class="form-control" placeholder="Enter the Meta Description"><?php echo getfleet('metadescription', $_REQUEST['flid']); ?></textarea>
                            </div>
                            <br>
                        </div>
                    </div>
                </div><!-- /.box-body --></div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>dynamic/fleet.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['flid'] != '') {
                                    echo 'UPDATE';
                                } else {
                                    echo 'SUBMIT';
                                }
                                ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box -->
        </form>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>
