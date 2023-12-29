<?php
$menu = "4,4,13";
if (isset($_REQUEST['id'])) {
    $thispageeditid = 9;
} else {
    $thispageid = 9;
}
include ('../../config/config.inc.php');

include ('../../config/uploadimage.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');

if (isset($_REQUEST['delete'])) {
    $delimg = $_REQUEST['img'];
    $delid = $_REQUEST['delete'];

    $dela = $db->prepare("SELECT * FROM `product` WHERE `pid`= ? ");
    $dela->execute(array($_REQUEST['delete']));
    $del = $dela->fetch();

    $image = explode(",", $del['image']);
    $uimg = '';
    foreach ($image as $images) {
        if ($images != '') {
            if ($delimg == $images) {
                unlink("../../../../product/thump/" . $delimg);
                unlink("../../../../product/small/" . $delimg);
                unlink("../../../../product/big/" . $delimg);
            } else {
                if ($uimg != '') {
                    $uimg .= "," . $images;
                } else {
                    $uimg = $images;
                }
            }
        }
    }

    $as = $db->prepare("UPDATE `product` SET `image`= ? WHERE `pid`= ? ");
    $as->execute(array($uimg, $del['pid']));

    header("location" . $sitename . "master/" . $_REQUEST['id'] . "/editproduct/?EditId=" . $del['id'] . '' . "&isuc=delete");
    //header("location" . $sitename . "master/" . $_REQUEST['id'] . "/editproduct/?EditId=" . $del['id'] . '' . "&isuc=delete");
}

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $_SESSION['product_id'] = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $strupload = '1';

    $sqltes1 = $db->prepare("SELECT * FROM `product` WHERE `productname`= ? AND `link`= ? AND `pid`!= ? ");
    $sqltes1->execute(array(trim($_REQUEST['product']), trim($_REQUEST['link']), $_REQUEST['id']));
    $sqltes = $sqltes1->rowCount();

    if ($sqltes == 0) {
        $img = '';
        $imgt = '';
        $img = getproduct('image', $_REQUEST['id']);


        for ($i = 0; $i < count($_FILES['image']['name']); $i++) {

            if ($_FILES['image']['name'][$i]) {
                $main = $_FILES['image']['name'][$i];
                $tmp = $_FILES['image']['tmp_name'][$i];
                $size = $_FILES['image']['size'][$i];
                $width = 100;
                $height = 100;
                $width1 = 500;
                $height1 = 500;
                $width2 = 2000;
                $height2 = 2000;
                $extension = getExtension($main);
                $extension = strtolower($extension);
                $m = time() . rand();
                $image = $m . "." . $extension;
                $thumppath = "../../../images/product/thump/";
                $fileimage = "../../../images/product/small/";
                $fileimage1 = "../../../images/product/big/";
                Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, $m, $tmp);
                Imageupload($main, $size, $width1, $fileimage, $fileimage, '255', '255', '255', $height1, $m, $tmp);
                Imageupload($main, $size, $width2, $fileimage1, $fileimage1, '255', '255', '255', $height2, $m, $tmp);
                if ($img == '') {
                    $img = $image;
                } else {
                    $img .= "," . $image;
                }
            }
        }

        foreach ($check_rows as $valuen) {

            $att_v = $
                    {
                    "attr_values_" . $valuen
                    };

            $pri_v = $
                    {
                    "price_attr_" . $valuen
                    };
            $spri_v = $
                    {
                    "sprice_attr_" . $valuen
                    };

            $attribute_values_new[] = implode('**', $att_v);
            $price_attr_value_new[] = $pri_v;
            $sprice_attr_value_new[] = $spri_v;

            if ($valuen == $default_attri) {
                $defe_attr_value_new[] = 1;
            } else {
                $defe_attr_value_new[] = 0;
            }
        }

        $attribute_values_new_implode = implode('@@&&', $attribute_values_new);
        $price_attr_value_new_implode = implode('@@&&', $price_attr_value_new);
        $sprice_attr_value_new_implode = implode('@@&&', $sprice_attr_value_new);
        $defe_attr_value_new_implode = implode('@@&&', $defe_attr_value_new);

        $date = date("Y-m-d h:i:sa");

        if ($strupload == '1') {
            if ($sprice == '') {
                $sprice = '0';
            }
            if ($strupload == '1') {
                if ($brand == '') {
                    $brand = '0';
                }
            }

            $cid = implode(',', $cid);
            $sid = implode(',', $sid);
            $nid = implode(',', $nid);

            $msg = addproduct($cid, $sid, $nid, $product, $note, $link, $brand, $sku, $availability, $price, $sprice, $shortdescription, $videolink, $furture, $showinhp, $deal, $img, $description, $specs, $order, $status, $metatitle, $metakeyword, $metadescription, $date, $weight, $length, $width, $height, $attribute_group, $attribute_values_new_implode, $price_attr_value_new_implode, $sprice_attr_value_new_implode, $defe_attr_value_new_implode, $_REQUEST['id']);
        }
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Link Already Exist</h4></div>';
    }
}
?>
<style>
    .fa
    {
        cursor:pointer;
    }
    .new_m
    {

        margin-bottom:10px;
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
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
            Product Mgmt
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Product Details </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> Dynamic Pages</a></li>
            <li><a href="<?php echo $sitename; ?>products/product.htm"> Product Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Product Details</li>
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
                        ?> Product Mgmt</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php
                    echo $msg;
                    if (isset($_REQUEST['suc'])) {
                        echo '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Saved</h4></div>';
                    }
                    ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Product Mgmt 
<!--                            <a target="_blank" style="float: right;margin-top: -7px;"  href="<?php echo $fsitename . 'productview' . '/' . getproduct('link', $_REQUEST['id']) ?>" class="btn  btn-primary" >Preview</a>-->
                        </div>
                        <div class="panel-body">  
                            <div class="row">
                                <div class="col-md-12"  id="adddetails">
                                    <?php
                                    $subcaeteded = explode(',', getproduct('sid', $_REQUEST['id']));
                                    $innercaeteded = explode(',', getproduct('innerid', $_REQUEST['id']));
                                    $caeteded = explode(',', getproduct('cid', $_REQUEST['id']));
                                    if ($_REQUEST['id'] != '') {
                                        $ss = 0;
                                        foreach ($caeteded as $catedid) {
                                            $idss = rand(3, 6) . time();
                                            ?>
                                            <div class="row" id="<?php echo $idss ?>" style="margin-bottom: 10px">
                                                <div class="col-md-4">
                                                    <label>Category Name <span style="color:#FF0000;">*</span></label>                                  
                                                    <select name="cid[]" class="form-control" required onchange="getsubcategoryp(this.value, '<?php echo $idss ?>')">
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        $getmanuf = $db->prepare("SELECT * FROM `category`");
                                                        $getmanuf->execute(array());
                                                        $getmanuf1 = $getmanuf->rowCount();
                                                        while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                                            ?>
                                                            <option value="<?php echo $fdepart['cid']; ?>"
                                                            <?php
                                                            if ($fdepart['cid'] == $catedid)
                                                            {
                                                                echo 'selected="selected"';
                                                            }
                                                            ?>><?php echo $fdepart['category']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4"  id='sid<?php echo $idss ?>' >
                                                    <label>SubCategory Name <span style="color:#FF0000;"></span></label>                                  
                                                    <select name="sid[]" class="form-control" onchange="getinnercategoryp(this.value, '<?php echo $idss ?>')"  >
                                                        <option value="">Select Subcategory</option>
                                                        <?php
                                                        $s = $db->prepare("SELECT * FROM `subcategory` WHERE FIND_IN_SET(?,`cid`) AND `status`= ? ");
                                                        $s->execute(array($catedid, '1'));
                                                        while ($cate = $s->fetch()) {
                                                            ?>
                                                            <option value="<?php echo $cate['sid']; ?>" <?php
                                                            if ($cate['sid'] == $subcaeteded[$ss]) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?php echo $cate['subcategory']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div> 
                                                <div class="col-md-4" id="nid<?php echo $idss ?>"  >
                                                    <label>Inner Category Name <span style="color:#FF0000;"></span></label>                                  
                                                    <select name="nid[]" class="form-control">
                                                        <option value="">Select Inner Category</option>
                                                        <?php
                                                        $s = $db->prepare("SELECT * FROM `innercategory` WHERE FIND_IN_SET(?,`subcategory`) AND `status`= ? ");
                                                        $s->execute(array($subcaeteded[$ss], '1'));
                                                        while ($cate = $s->fetch()) {
                                                            ?>
                                                            <option value="<?php echo $cate['innerid']; ?>" <?php
                                                            if ($cate['innerid'] == $innercaeteded[$ss]) {
                                                                echo 'selected';
                                                            }
                                                            ?>
                                                                    ><?php echo $cate['innername']; ?></option>
                                                                <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-1">
                                                    <?php if ($ss > 0) { ?>
                                                        <br />
                                                        <i class="fa fa-trash fa-2x" style="margin-top: 6px;color:#ff0000"  onclick="removethis(<?php echo $idss ?>, $(this))" ></i>    <?php }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            $ss++;
                                        }
                                    } else {

                                        $idss = rand(3, 6) . time();
                                        ?>
                                        <div class="row" id="<?php echo $ids ?>" style="margin-bottom: 10px">
                                            <div class="col-md-4">
                                                <label>Category Name <span style="color:#FF0000;">*</span></label>                                  
                                                <select name="cid[]" class="form-control" required onchange="getsubcategoryp(this.value,<?php echo $idss ?>)" >
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    $getmanuf = $db->prepare("SELECT * FROM `category`");
                                                    $getmanuf->execute();
                                                    while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                                        ?>
                                                        <option value="<?php echo $fdepart['cid']; ?>"
                                                        <?php
                                                        if ($fdepart['cid'] == getproduct('cid', $_REQUEST['pid'])) {
                                                            echo 'selected="selected"';
                                                        }
                                                        ?>><?php echo $fdepart['category']; ?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4"   id='sid<?php echo $idss ?>' >
                                                <label>SubCategory Name <span style="color:#FF0000;"></span></label>                                  
                                                <select name="sid[]"  class="form-control" onchange="getinnercategoryp(this.value,<?php echo $idss ?>)"  >
                                                    <option value="">Select Subcategory</option>

                                                </select>
                                            </div> 

                                            <div class="col-md-4" id="nid<?php echo $idss ?>">
                                                <label>Inner Category Name  <span style="color:#FF0000;"></span> </label>                                  
                                                <select name="nid[]"  class="form-control">
                                                    <option value="">Select Inner-Category</option>
                                                    <?php
                                                    $s = $db->prepare("SELECT * FROM `innercategory` WHERE `subcategory`= ?  AND `status`= ? ");
                                                    $s->execute(array($subcaeteded[$ss], '1'));

                                                    //$s = DB("SELECT * FROM `innercategory` WHERE `subcategory`='$subcaeteded[$nn]'  AND `status`=1");
                                                    while ($cate = $s->fetch()) {
                                                        ?>
                                                        <option value="<?php echo $cate['innerid']; ?>" <?php
                                                        if ($cate['innerid'] == $innercaeteded[$ss]) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo $cate['innername']; ?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>

                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="btn btn-success" onclick="additem()">Add</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Brand </label>
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select Brand</option>
                                        <?php
                                        $getmanuf = $db->prepare("SELECT * FROM `brand` WHERE `status`=?");
                                        $getmanuf->execute(array('1'));
                                        $getmanuf1 = $getmanuf->rowCount();

                                        while ($fdepart = $getmanuf->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <option value="<?php echo $fdepart['brid']; ?>"
                                            <?php
                                            if ($fdepart['brid'] == getproduct('brand', $_REQUEST['id'])) {
                                                echo 'selected="selected"';
                                            }
                                            ?> > <?php echo $fdepart['bname']; ?></option>
                                                <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Product Name <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" required="required" placeholder="Enter The Product Name" name="product" id="product" value='<?php
                                    if ($_REQUEST['id'] != '') {
                                        echo getproduct('productname', $_REQUEST['id']);
                                    }
                                    ?>'/>
                                </div>
                                <div class="col-md-6">
                                    <label>Link <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control"  pattern="[A-Za-z0-9.,&_- ]{1,55}" title="Special character not allowed." required="required" placeholder="Enter The Link" name="link" id="link" value="<?php
                                    if ($_REQUEST['id'] != '') {
                                        echo getproduct('link', $_REQUEST['id']);
                                    }
                                    ?>"/>
                                </div>

                            </div>
                            <br/>
                            <div class="row"><br/></div>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    Attribute
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Attribute Group <span style="color:#FF0000;"></span></label>

                                            <select id="attribute_group" onchange="setattrivalue(this.value)" class="form-control" name="attribute_group" <?php
                                            if (getproduct('attribute_group', $_REQUEST['id']) != '') {
                                                //echo 'disabled';
                                            }
                                            ?>>
                                                <option value="0">Select Attribute Group</option>
                                                <?php
                                                $s = $db->prepare("SELECT * FROM `attribute_group` WHERE `status`= ? ");
                                                $s->execute(array('1'));
                                                while ($cate = $s->fetch()) {
                                                    ?>
                                                    <option value="<?php echo $cate['id']; ?>" <?php
                                                    if ($cate['id'] == getproduct('attribute_group', $_REQUEST['id'])) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo $cate['name']; ?></option>
                                                        <?php } ?>
                                            </select>
                                            <input type="hidden"   name="attributegr"  value="<?php echo getproduct('attribute_group', $_REQUEST['id']) ?>" id="attribute_g_hidden" />
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <?php
                                        if ($_REQUEST['id'] != '') {
                                            ?>
                                            <div class="col-md-12 new_m"  id="addattribute">
                                                <?php
                                                $sattr = $db->prepare("SELECT * FROM `productattribute` WHERE `pid`= ? ");
                                                $sattr->execute(array($_REQUEST['id']));
                                                $sn = 0;
                                                while ($sattrf = $sattr->fetch()) {
                                                    if ($sattrf['attr_values'] != '') {
                                                        $sn++;
                                                        $labelsvalues = explode('**', $sattrf['attr_values']);
                                                        $checked = '';
                                                        if ($sattrf['default'] == '1') {
                                                            $checked = 'checked';
                                                        }
                                                        ?>
                                                        <div class="row new_m" id='remove_<?php echo $sn ?>'   >
                                                            <div class="col-md-1">
                                                                <br />
                                                                <input type="radio"  <?php echo $checked; ?>  name="default_attri" value="<?php echo $sn ?>" />
                                                            </div>
                                                            <?php
                                                            foreach ($labelsvalues as $valuesid) {
                                                                $single_att1 = $db->prepare("SELECT * FROM `attribute_value` WHERE `vid`= ? ");
                                                                $single_att1->execute(array($valuesid));
                                                                $single_att = $single_att1->fetch();
                                                                $attr_id = $single_att['valid'];

                                                                $single_att_name1 = $db->prepare("SELECT * FROM `attribute` WHERE `id`='" . $attr_id . "'");
                                                                $single_att_name1->execute(array());
                                                                $single_att_name = $single_att_name1->fetch();
                                                                ?>
                                                                <div class="col-md-3">
                                                                    <label><?php echo $single_att_name['name']; ?></label>
                                                                    <select name="attr_values_<?php echo $sn ?>[]"  class="form-control" >
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                        $single_att_others = $db->prepare("SELECT * FROM `attribute_value` WHERE `valid`= ? ");
                                                                        $single_att_others->execute(array($attr_id));

                                                                        while ($single_att_othersf = $single_att_others->fetch()) {
                                                                            ?>

                                                                            <option value="<?php echo $single_att_othersf['vid'] ?>" <?php
                                                                            if ($single_att_othersf['vid'] == $valuesid) {
                                                                                echo 'selected';
                                                                            }
                                                                            ?>><?php echo $single_att_othersf['value'] ?></option>
                                                                                <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            <div class="col-md-2">
                                                                <label>Price</label>
                                                                <input type="text" class="form-control"  required="required"  name="price_attr_<?php echo $sn ?>"  value="<?php echo $sattrf['price']; ?>"/>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label>Special Price</label>
                                                                <input type="text" class="form-control"    name="sprice_attr_<?php echo $sn ?>"  value="<?php echo $sattrf['sprice']; ?>"/>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <br />
                                                                <i class="fa fa-trash fa-2x" style="margin-top: 6px;color:#ff0000"  onclick="removethisattr(<?php echo $sn ?>)" ></i>
                                                            </div>
                                                            <input type="hidden" name="check_rows[]" value="<?php echo $sn ?>" />
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>		 
                                        </div>
                                        <div class="row new_m">
                                            <div class="col-md-12"><a class="btn btn-success" onclick="additem_attr()">Add Attribute</a>
                                                <input type="hidden" id="check_row" value="<?php echo $sn ?>" />
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="row new_m" id="addattribute">

                                        </div>		 
                                        <div class="row new_m">
                                            <div class="col-md-12">  <a class="btn btn-success" onclick="additem_attr()">Add Attribute</a>
                                                <input type="hidden" id="check_row" value="0" />
                                            </div>
                                        </div>		 
                                        <?php
                                    }
                                    ?>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>SKU</label>
                                    <input type="text" name="sku" id="sku" placeholder="Enter The SKU" value="<?php
                                    if ($_REQUEST['id'] != '') {
                                        echo getproduct('sku', $_REQUEST['id']);
                                    }
                                    ?>" class="form-control" >
                                </div>
                                <div class="col-md-6">
                                    <label>Availability</label>
                                    <select name="availability" class="form-control">
                                        <option value="1"<?php
                                        if (getproduct('availability', $_REQUEST['id']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>In Stock</option>
                                        <option value="0" <?php
                                        if (getproduct('availability', $_REQUEST['id']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>Out of Stock</option>
                                    </select>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Price <span style="color:#FF0000;"></span></label>
                                    <input type="number" step="0.01" class="form-control" placeholder="Enter The Price" name="price" id="price" value="<?php
                                    if ($_REQUEST['id'] != '') {
                                        echo getproduct('price', $_REQUEST['id']);
                                    }
                                    ?>"/>
                                </div>
                                <div class="col-md-6">
                                    <label>Special Price</label>
                                    <input  type="number" step="0.01" name="sprice" id="sprice" class="form-control" value="<?php
                                    if ($_REQUEST['id'] != '') {
                                        echo getproduct('sprice', $_REQUEST['id']);
                                    }
                                    ?>">
                                </div>

                            </div>
                            <br />
                            <!--                            <div class="row">
                                                            <div class="col-md-12">
                                                                <label>Product Note <span style="color:#FF0000;"></span></label>
                                                                <textarea class="form-control"    name="note" id="note" cols="3"><?php
                            if ($_REQUEST['id'] != '') {
                                echo getproduct('note', $_REQUEST['id']);
                            }
                            ?></textarea>
                                                            </div>
                                                        </div>
                                                        <br />-->
                            <div class="panel panel-info">
                                <div class="panel-heading">Shipping</div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Weight  (in Kgs)</label>
                                            <input  type="text"  name="weight" class="form-control"  pattern="[0-9.]*" value="<?php
                                            if ($_REQUEST['id'] != '') {
                                                echo getproduct('weight', $_REQUEST['id']);
                                            }
                                            ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Length (in Cms) Max length(999cms)<span style="color:#FF0000;"></span></label>
                                            <input type="text" class="form-control" pattern="[0-999.]*"  name="length"  value="<?php
                                            if ($_REQUEST['id'] != '') {
                                                echo getproduct('length', $_REQUEST['id']);
                                            }
                                            ?>"/>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Width (in Cms)</label>
                                            <input  type="text"   name="width"  pattern="[0-999.]*"  class="form-control" value="<?php
                                            if ($_REQUEST['id'] != '') {
                                                echo getproduct('width', $_REQUEST['id']);
                                            }
                                            ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Height (in Cms)</label>
                                            <input  type="text"  name="height" pattern="[0-999.]*"  class="form-control" value="<?php
                                            if ($_REQUEST['id'] != '') {
                                                echo getproduct('height', $_REQUEST['id']);
                                            }
                                            ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <label>Short Description</label>
                                    <textarea name="shortdescription"  id="editor3" class="form-control"><?php
                                        if ($_REQUEST['id'] != '') {
                                            echo getproduct('sortdescription', $_REQUEST['id']);
                                        }
                                        ?></textarea>
                                </div>

                            </div><br/>
                            <div class="row">

                                <div class="col-md-6">
                                    <label>Video Link</label>
                                    <div class="input-group">
                                        <span class="input-group-addon">https://www.youtube.com/watch?v=</span>
                                        <input type="text" class="form-control" placeholder="Enter the External videolink" name="videolink" id="videolink" value="<?php echo stripslashes(getproduct('videolink', $_REQUEST['id'])); ?>" />
                                    </div>
                                </div>
                                <?php if (getproduct('videolink', $_REQUEST['id']) != '') { ?>
                                    <div class="col-md-6 col-sm-6 col-xs-12" id="delimage">
                                        <label> </label>
                                        <iframe width="200" height="100" src="https://www.youtube.com/embed/<?php echo stripslashes(getproduct('videolink', $_REQUEST['id'])); ?>" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                <?php } ?>

                                <div class="col-md-3">
                                    <label>
                                        <input type="checkbox" name="furture"  id="furture"  value="1"
                                        <?php
                                        if ($_REQUEST['id'] != '') {
                                            $ched = getproduct('furtureyn', $_REQUEST['id']);
                                            if ($ched == '1') {
                                                echo 'checked="checked"';
                                            }
                                        } 
                                        
                                        ?>> Featured</label>
                                </div> 

                                <div class="col-md-3">
                                    <label>
                                        <input type="checkbox" name="deal"  id="deal"  value="1"
                                        <?php
                                        if ($_REQUEST['id'] != '') {
                                            $ched = getproduct('deal', $_REQUEST['id']);
                                            if ($ched == '1') {
                                                echo 'checked="checked"';
                                            }
                                        }
                                        ?>> Best Seller</label>
                                </div> 
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    if (isset($_REQUEST['id'])) {

                                        if (getproduct('image', $_REQUEST['id']) != '') {
                                            ?>
                                            <table>
                                                <?php
                                                $pimg = explode(",", getproduct('image', $_REQUEST['id']));
                                                $i = 0;
                                                foreach ($pimg as $img) {
                                                    if ($img == '') {
                                                        break;
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div class="col-md-6" id="delimage<?php echo $i; ?>">
                                                                <img src="<?php echo $fsitename; ?>images/product/small/<?php echo $img; ?>" style="padding-bottom:10px;" height="100" />
                                                                <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="del" onclick="javascript:deletemultiimage('<?php echo $img; ?>', '<?php echo $_REQUEST['id']; ?>', 'product', '../../images/product/small/', 'image', 'pid', 'delimage<?php echo $i; ?>');"><i class="fa fa-close">&nbsp;Delete Image</i></button>
                                                                <br />
                                                                <br />
                                                                <input type="file" name="image[<?php echo $i; ?>]" id="image[<?php echo $i; ?>]"/>
                                                                <br />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="com" id="com" />
                                                        <table id="myTable">
                                                            <?php
                                                            foreach ($pimg as $r) {
                                                                if ($r != '') {
                                                                    echo "<tr><td></td></tr>";
                                                                }
                                                            }
                                                            ?>
                                                            <tr id="add_rows">
                                                                <td align="left"><a href="javascript:insRow()" class="invitlink">Add another Images</a>&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>

                                                </tr>
                                            </table>
                                            <?php
                                        } else {
                                            ?>
                                            <table id="myTable">
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="com" id="com" />
                                                        <input type="file" name="image[0]" id="image[0]" />
                                                    </td>
                                                </tr>
                                                <tr id="add_rows">
                                                    <td align="left">
                                                        <a href="javascript:insRow()" class="invitlink">Add another Images</a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <table id="myTable">
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="com" id="com" />
                                                    <input type="file" name="image[0]" id="image[0]" />
                                                    <br/>
                                                </td>
                                            </tr>
                                            <tr id="add_rows">
                                                <td align="left">
                                                    <a href="javascript:insRow()" style=" color:#069; font-weight:bold;">Add another Images</a>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div> <br/>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Description </label>
                                    <textarea name="description" id="editor1" class="form-control" placeholder="Enter The Description"><?php
                                        if ($_REQUEST['id'] != '') {
                                            echo getproduct('description', $_REQUEST['id']);
                                        }
                                        ?></textarea>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">

                                    <label>Specs</label>
                                    <textarea name="specs" id="editor2" class="form-control" >
                                        <?php
                                        if ($_REQUEST['id'] != '') {
                                            echo getproduct('spacs', $_REQUEST['id']);
                                        }
                                        ?></textarea>

                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" class="form-control" name="order" required="required" value="<?php
                                    if ($_REQUEST['id'] != '') {
                                        echo getproduct('order', $_REQUEST['id']);
                                    }
                                    ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        //  echo  getcategory('status', $_REQUEST['id']);
                                        if (getproduct('status', $_REQUEST['id']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getproduct('status', $_REQUEST['id']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>Inactive</option>

                                    </select>
                                </div>

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
                                    <input type="text" name="metatitle" id="metatitle"   class="form-control"  placeholder="Enter The title" value="<?php echo getproduct('metatitle', $_REQUEST['id']); ?>" />
                                </div><br/>
                                <div class="col-md-12">
                                    <label>Meta Keywords</label>
                                    <textarea name="metakeyword" class="form-control" id="metakeyword"  placeholder="Enter The Meta Keyword" id="contact_number"><?php echo getproduct('metakeyword', $_REQUEST['id']); ?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label>Meta Description</label>
                                    <textarea name="metadescription" class="form-control" id="metadescription"  placeholder="Enter The Meta Description" id="contact_number"><?php echo getproduct('metadescription', $_REQUEST['id']); ?></textarea>
                                </div>
                            </div>
                            <br />
                        </div> 
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?php echo $sitename; ?>products/product.htm">Back to Listings page</a>
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
        </form>
</div>
<!-- /.box -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php include ('../../require/footer.php'); ?>