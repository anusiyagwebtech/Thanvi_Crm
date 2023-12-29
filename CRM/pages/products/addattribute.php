<?php
$menu = "4,4,11";
if (isset($_REQUEST['id'])) {
    $thispageid = 21;
} else {
    $thispageid = 21;
}
include ('../../config/config.inc.php');
include ('../../config/uploadimage.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');


if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    // print_r($_REQUEST);
    //exit;
    $_SESSION['product_id'] = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_REQUEST['id'])) {
        $sqltes = DB_NUM("SELECT * FROM `attribute` WHERE `name`='" . trim($_REQUEST['product']) . "' AND `id`!='" . $_REQUEST['id'] . "'");
    } else {
        $sqltes = DB_NUM("SELECT * FROM `attribute` WHERE `name`='" . trim($_REQUEST['product']) . "'");
    }
    if ($sqltes == 0) {
        $getvalue = implode(',', $cid);
        $vals = implode(',', $vids);
        $date = date("Y-m-d h:i:sa");
        $msg = addattribute($product, $getvalue, $vals, $order, $status, $date, $_REQUEST['id'],$thispageid);
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-close"></i> Attribute Name Already Exist</h4></div>';
    }
}
?>
<style>
    .fa
    {
        cursor:pointer;
    }
</style>

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
    function insRow(e)
    {
        //alert("hi");
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


    
   


</script>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Attribute
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Attribute</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> Dynamic Pages</a></li>
            <li><a href="<?php echo $sitename; ?>products/attribute.htm"> Attribute Mgmt </a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Attribute</li>
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
                        ?> Attribute Mgmt</h3>
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
                            Attribute Mgmt


                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Attribute Name<span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" required="required" name="product" id="product" value="<?php
                                    if ($_REQUEST['id'] != '') {
                                        echo getattribute('name', $_REQUEST['id']);
                                    }
                                    ?>"/>
                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-12 "  id="adddetails">
                                    <?php
                                    if ($_REQUEST['id'] != '') {
                                        $ss = 0;


                                        $validsss = $db->prepare("SELECT * FROM `attribute_value` WHERE `valid`=? ");
                                        $validsss->execute(array($_REQUEST['id']));
                                        while ($validsssfet = $validsss->fetch()) {

                                            $idss = rand(3, 6) . time();
                                            ?>
                                            <div class="row" id="<?php echo $idss ?>" style="margin-bottom: 10px">
                                                <div class="col-md-4">
                                                    <label>Value<span style="color:#FF0000;">*</span></label>
                                                    <input type="text" class="form-control" required="required"    name="cid[]" id="product" value="<?php
                                                    echo $validsssfet['value'];
                                                    ?>"/>       
                                                </div>
                                                <div class="col-md-1">
                                                    <?php if ($ss > 0) { ?>
                                                        <span> 
                                                            <br />
                                                            <i class="fa fa-trash fa-2x" style="margin-top: 6px;color:#ff0000"  onclick="removethis(<?php echo $validsssfet['vid'] ?>, $(this))" ></i></span>   <?php } ?>
                                                </div>

                                                <input type="hidden" name="vids[]" value="<?php
                                                echo $validsssfet['vid'];
                                                ?>" />

                                            </div>
                                            <?php
                                            $ss++;
                                        }
                                    } else {

                                        $idss = rand(3, 6) . time();
                                        ?>
                                        <div class="row" id="<?php echo $ids ?>" style="margin-bottom: 10px">
                                            <div class="col-md-4">
                                                <label>Value<span style="color:#FF0000;">*</span></label>                                  
                                                <input type="text" class="form-control" required="required"    name="cid[]" id="product" value="<?php
                                                if ($_REQUEST['id'] != '') {
                                                    echo getattribute('name', $_REQUEST['id']);
                                                }
                                                ?>"/> 
                                            </div>
                                            <div class="col-md-1">
                                                <input type="hidden" name="vids[]" value="" />
                                            </div>
                                        </div>

                                        <?php
                                    }
                                    ?>

                                </div>
                            </div><br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <span   class="btn btn-success" onclick="additem()"  >Add</span>
                                </div>
                            </div><br/>




                            <!--                            <div class="row">
                                                            <div class="col-md-6">
                                                                <label>Order<span style="color:#FF0000;">*</span></label>                                  
                                                                <input type="number" class="form-control" name="order" required="required" value="<?php
                            if ($_REQUEST['id'] != '') {
                                echo getattribute('order', $_REQUEST['id']);
                            } else {
                                echo $_REQUEST['order'];
                            }
                            ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                                                <select name="status" class="form-control">
                                                                    <option value="1" <?php
                            //  echo  getcategory('status', $_REQUEST['id']);
                            if (getattribute('status', $_REQUEST['id']) == '1') {
                                echo 'selected';
                            }
                            ?>>Active</option>
                                                                    <option value="0" <?php
                            if (getattribute('status', $_REQUEST['id']) == '0') {
                                echo 'selected';
                            }
                            ?>>Inactive</option>
                            
                                                                </select>
                                                            </div>
                            
                                                        </div>-->
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>products/attribute.htm">Back to Listings page</a>
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


<script type="text/javascript">
<?php if (isset($_REQUEST['filesubmit'])) { ?>
        $(document).ready(function () {
            // $('#importfile').focus();
            ///  $('#tags').focus();
            $('html, body').animate({scrollTop: $('#newsdiv').offset().top}, 'fast');

        });
<?php } ?>
</script>

<script type="text/javascript">
    
    function additem()
    {
        //var ss=$("")
        $.ajax({
            url: "<?php echo $sitename; ?>pages/products/ajax_page.php",
            async: false,
            data: {attribute: 1},
            success: function (data) {
                $("#adddetails").append(data);
            }
        });
    }
    function removethis(a, b)
    {

        $.ajax({
            type: 'POST',
            url: "<?php echo $sitename; ?>pages/products/ajax_page.php",
            data: {removevalue: a},
            success: function (data) {
                $(b).parent().parent().parent().remove();
            }
        });

    }
    
    
    
    
    $('#cid').on('change', function () {
        var ts = $('#cid').val();
        //  alert(ts);
        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/getsubcate.php",
            async: false,
            data: {pid: ts},
            success: function (data) {
                $('#getsub').html(data);
            }
        });
    });

    $('#sid').on('change', function () {
        var ts = $('#sid').val();
        //  alert(ts);
        $.ajax({
            url: "<?php echo $sitename; ?>pages/master/getsubcate.php",
            async: false,
            data: {rid: ts},
            success: function (data) {
                $('#getsub1').html(data);
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
