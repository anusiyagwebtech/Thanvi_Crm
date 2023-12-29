<?php
$menu = "4,4,10";

if (isset($_REQUEST['inid'])) {
    $thispageeditid = 20;
} else {
    $thispageid = 20;
}

include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');
include ('../master/uploadimage.php');

if (isset($_REQUEST['submit'])) {
    $i = 1;
    @extract($_REQUEST);
    $_SESSION['inner_cate_id'] = $_REQUEST['inid'];
    $ip = $_SERVER['REMOTE_ADDR'];

    $strupload = '1';
//
//    $sqltes1 = $db->prepare("SELECT * FROM `innercategory` WHERE `link`= ? AND `pid`!= ? ");
//    $sqltes1->execute(array(trim($_REQUEST['product']), trim($_REQUEST['link']), $_REQUEST['id']));
//    $sqltes = $sqltes1->rowCount();


    if ($sqltes == 0) {

        $vaal = checkimage12('innercategory', $imagename, 'innerid', $_REQUEST['inid']);

        if ($vaal == 'true') {
            $pimage = getinnetcat('image', $_REQUEST['inid']);
            $imag = strtolower($_FILES["image"]["name"]);
            if ($imag) {
                $main = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
                $size = $_FILES['image']['size'];
                $extension = getExtension($main);
                $extension = strtolower($extension);

                if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif') || ($extension == 'jpeg')) {
                    if ($pimage != '') {
                        unlink("../../../images/innercategory/" . $pimage);
                    }
                    $width = 500;
                    $height = 500;
                    $m = trim($imagename);
                    $image = strtolower($m) . "." . $extension;
                    $thumppath = "../../../images/innercategory/";
                    $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
                } else {
                    $strupload = '2';
                    $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><i class="icon fa fa-close"></i> Invalid File Format! Try jpg/png/gif/jpeg files only </div>';
                }
            } else {
                $image = '';
                if (isset($_REQUEST['inid'])) {
                    $image = $pimage;
                }
            }
        }

        if ($strupload == '1') {
            $cid_im = implode(",", $cid);
            $sid_im = implode(",", $sid);
            $msg = addinnercategory($cid_im, $sid_im, $innercat, $link, $image, $imagename, $imagealt, $description, $metatitle, $metakeywords, $metadescription, $order, $status, $ip, $thispageid, $_REQUEST['inid']);
        }
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><i class="icon fa fa-close"></i> Image name Already Exist!! try Different</div>';
    }
}
?>
<script>

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }


</script>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Inner Category
            <small><?php
                if ($_REQUEST['inid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Inner Category </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> Dynamic Pages</a></li>
            <li><a href="<?php echo $sitename; ?>products/innercategory.htm"> Inner Category </a></li>
            <li class="active"><?php
                if ($_REQUEST['inid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Inner Category </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['inid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?> Inner Category </h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Inner Category 
                        </div>
                        <div class="panel-body">                        
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Category Name <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="cid[]" id="cid" class="form-control" multiple="multiple" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        $s = $db->prepare("SELECT * FROM `category` WHERE `status`= ? ");
                                        $s->execute(array('1'));

//$s = DB("SELECT * FROM `category` WHERE `status`=1");
                                        while ($cate = $s->fetch()) {
                                            ?>
                                            <option value="<?php echo $cate['cid']; ?>" <?php
                                            $sel = getinnetcat('cid', $_REQUEST['inid']);
                                            $sel = explode(',', $sel);
                                            if (in_array($cate['cid'], $sel)) {
                                                echo 'selected';
                                            }
                                            ?> ><?php echo $cate['category']; ?></option>
                                                <?php } ?>
                                    </select>
                                </div>
                                <div id="getsub">
                                    <div class="col-md-6">
                                        <label>SubCategory Name <span style="color:#FF0000;">*</span></label>                                  
                                        <select name="sid[]" class="form-control" required multiple="multiple">
                                            <option value="">Select Subcategory</option>
                                            <?php
                                            if (isset($_REQUEST['inid'])) {
                                                $tee = getinnetcat('subcategory', $_REQUEST['inid']);
                                                $cata = explode(',', $tee);
                                                foreach ($cata as $ca) {
                                                    $s = $db->prepare("SELECT * FROM `subcategory` WHERE `sid`= ?  AND `status`= ? ");
                                                    $s->execute(array($ca, '1'));
                                                    //$s = DB("SELECT * FROM `subcategory` WHERE `cid`='$tee'  AND `status`=1");
                                                    while ($cate = $s->fetch()) {
                                                        ?>
                                                        <option value="<?php echo $cate['sid']; ?>" <?php
                                                        $sel = getinnetcat('subcategory', $_REQUEST['inid']);
                                                        $sel = explode(',', $sel);
                                                        if (in_array($cate['sid'], $sel)) {
                                                            echo 'selected';
                                                        }
                                                        ?>><?php echo $cate['subcategory']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>

                                        </select>
                                    </div> 
                                </div>
                            </div><br/>

                            <div class="row"> 
                                <div class="col-md-6">
                                    <label>Inner Sub Category Name <span style="color:#FF0000;">*</span></label>                                 

                                    <input type="text" class="form-control" placeholder="Enter Inner Category" name="innercat" id="innercat" required="required" pattern="[0-9 A-Z a-z .,:'()]{2,60}" title="Allowed Characters (0-9A-Za-z .,:'()]{2,60})" value="<?php echo getinnetcat('innername', $_REQUEST['inid']); ?>"  />
                                </div> 


                                <div class="col-md-6">
                                    <label>Link <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" required="required" placeholder="Enter The Link" name="link" id="link"  pattern="[A-Za-z0-9_-]{2,255}" title="Special character not allowed." value="<?php echo getinnetcat('link', $_REQUEST['inid']); ?>"/>
                                </div>
                            </div><br/>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image</label>
                                    <input type="file" name="image" id="image" onchange="imgchktore(this.value)"/>
                                </div>

                                <?php if (getinnetcat('image', $_REQUEST['inid']) != '') { ?>
                                    <div class="col-md-6" id="delimage">

                                        <img src="<?php echo $fsitename; ?>images/innercategory/<?php echo getinnetcat('image', $_REQUEST['inid']); ?>" style="padding-bottom:10px;" height="100" />
                                        <button type="button" style="cursor:pointer;" class="btn btn-danger" name="del" id="delthis" onclick="javascript:deleteimage('<?php echo getinnetcat('image', $_REQUEST['inid']); ?>', '<?php echo $_REQUEST['inid']; ?>', 'innercategory', '../../images/innercategory/', 'image', 'innerid');"><i class="fa fa-close">&nbsp;Delete Image</i></button>                   
                                    </div>
                                <?php } ?>
                            </div>
                            <br />

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Image Name <span id="addstar" style="color:#FF0000;"></span></label>                                  
                                    <input type="text" name="imagename" id="imagenameid"  pattern="[A-Z a-z 0-9 _-]{1,55}" title="Special character not allowed." class="form-control" placeholder="Enter The Image Name" value="<?php echo getinnetcat('image_name', $_REQUEST['inid']); ?>"  />
                                </div> 
                                <div class="col-md-6">
                                    <label>Image Alt<span id="addstar1" style="color:#FF0000;"></span></label>                                  
                                    <input type="text"  id="imagealtid"  pattern="[A-Z a-z 0-9 _-]{1,55}" title="Special character not allowed." name="imagealt" class="form-control" placeholder="Enter The Image Alternate Name" value="<?php echo getinnetcat('image_alt', $_REQUEST['inid']); ?>"  />                                    </div>
                            </div><br/>

                            <div class="row">

                                <div class="col-md-12">
                                    <label>Description </label>
                                    <textarea name="description" id="editor1" class="form-control" placeholder="Enter The Description"><?php echo getinnetcat('description', $_REQUEST['inid']); ?></textarea>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                    <input type="number" class="form-control" required="" name="order" placeholder="Enter The Order" value="<?php echo getinnetcat('order', $_REQUEST['inid']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
//  echo  getcategory('status', $_REQUEST['id']);
                                        if (getinnetcat('status', $_REQUEST['inid']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getinnetcat('status', $_REQUEST['inid']) == '0') {
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
                                    <input type="text" name="metatitle" id="metatitle"  class="form-control"  title="Allowed Characters (a-zA-Z ()0-9-)(3-20)" placeholder="Enter The Metatitle" value="<?php echo getinnetcat('metatitle', $_REQUEST['inid']); ?>" />
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Meta Keywords</label>
                                    <textarea name="metakeywords" class="form-control" placeholder="Enter The Meta Keyword" id="metakeywords"><?php echo getinnetcat('metakeywords', $_REQUEST['inid']); ?></textarea>
                                </div> 
                            </div><br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Meta Description</label>
                                    <textarea name="metadescription" class="form-control" placeholder="Enter The Meta Description" id="metadescription"><?php echo getinnetcat('metadescription', $_REQUEST['inid']); ?></textarea>
                                </div>   
                            </div>
                            <br />     
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>products/innercategory.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6"><!--validatePassword();-->
                            <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;"><?php
                                if ($_REQUEST['inid'] != '') {
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
<script type="text/javascript">

    $('#cid').on('change', function () {
        var ts = $('#cid').val();
        //  alert(ts);
        $.ajax({
            url: "<?php echo $sitename; ?>pages/products/ajax_page.php",
            async: false,
            data: {pid: ts},
            success: function (data) {
                $('#getsub').html(data);
            }
        });
    });
    function delrec(a, b) {
        if (confirm("Are you sure you want to remove this timing?")) {
            a.parent().parent().remove();
            var rtn = '';
            $.ajax({
                url: "<?php echo $sitename; ?>pages/master/delthistime.php",
                async: false,
                data: {id: b},
                success: function (data) {
                    rtn = '1';
                }
            });
            if (rtn == '1') {

            }
        }
    }

    function imgchktore(a) {
        if (a != '')
        {
            $("#imagenameid").prop('required', true);
            $("#imagealtid").prop('required', true);
            $("#addstar").html('*');
            $("#addstar1").html('*');
        }
    }

</script>
<script>
    function showUser(str) {

        $("#one").hide();
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "<?php echo $sitename; ?>pages/master/add_branch_statebg.php?q=" + str, true);
        xmlhttp.send();
    }
    function showUser1(str) {

        // $("#two").hide();
        if (str == "") {
            document.getElementById("txtHint1").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint1").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "<?php echo $sitename; ?>pages/master/add_branch_citybg.php?z=" + str, true);
        xmlhttp.send();
    }
    function showUser2(str) {

        //$("#two").hide();
        if (str == "") {
            document.getElementById("city").innerHTML = "";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("city").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "<?php echo $sitename; ?>pages/master/add_branch_citybg.php?z=" + str, true);
        xmlhttp.send();
    }







</script>
