<?php
$menu = "4,4,12";
if (isset($_REQUEST['id'] )) {
    $thispageid = 22;
} else {
    $thispageid = 22;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');
if (isset($_REQUEST['submit'])) {

    @extract($_REQUEST);
    //print_r($_REQUEST);
    //exit;
    $_SESSION['company_id'] = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $date = date("Y-m-d h:i:sa");
    $getvalue= implode(',', $cid);
    $msg = addattributegroup($subcategory,$getvalue,$status,$date, $ip, $_REQUEST['id']);
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
            Attribute Group Mgmt
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Attribute Group Details </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-cogs"></i> Dynamic Pages</a></li>
            <li><a href="<?php echo $sitename; ?>products/attributegroup.htm"> Attribute Group Details </a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Attribute Group Details</li>
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
                        ?> Attribute Group Details</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Attribute Group
                        </div>
                        <div class="panel-body">
                             
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Attribute Name <span style="color:#FF0000;">*</span></label>                                  
                                    <input type="text" name="subcategory" id="category"  class="form-control" value="<?php echo getattributegroup('name', $_REQUEST['id']); ?>" required />
                                </div>
                                <div class="col-md-6">
                                    <label>Attribute<span style="color:#FF0000;">*</span></label>
                                    <select name="cid[]" class="form-control" required multiple>
                                        <?php
                                        $valset = explode(',',getattributegroup('attribute', $_REQUEST['id']));
                                         $s = $db->prepare("SELECT * FROM `attribute`");
                                        $s->execute(array());
                                        
                                        
                                        
                                        
                                       // $s = DB("SELECT * FROM `attribute`");
                                        while ($cate = $s->fetch()) {
                                            ?>
                                            <option value="<?php echo $cate['id']; ?>" <?php
                                            if (in_array($cate['id'], $valset) ) {
                                                echo 'selected';
                                            }
                                            ?>><?php echo $cate['name']; ?></option>
                                                <?php } ?>
                                    </select>
                                </div>  
                                
                            </div>
                            <br/>
                            
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        
                                        if (getattributegroup('status', $_REQUEST['id']) == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if (getattributegroup('status', $_REQUEST['id']) == '0') {
                                            echo 'selected';
                                        }
                                        ?>>Inactive</option>

                                    </select>
                                </div>
                                <div id="txtHint1"><b></b></div>
                            </div> 
                        </div>
                    </div>
                    
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo $sitename; ?>products/attributegroup.htm">Back to Listings page</a>
                        </div>
                        <div class="col-md-6">
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
