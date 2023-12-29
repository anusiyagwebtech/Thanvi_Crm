<?php
$menu = "3,2,7";
if ($_REQUEST['CusID'] != '') {
    $thispageeditid = 1;
} else {
    $thispageid = 1;
}
include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');

if (isset($_REQUEST['submit']))
{
    @extract($_REQUEST);
    if($resetpassword!='')
    {
        $pass= md5($resetpassword);
        $upd1 = pFETCH("UPDATE `customer` SET `Password`=?, `Status`=? WHERE `CusID`=?",$pass,$Status,$CusID);

        $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');

        $from = $general['recoveryemail'];

        $cemail = getcustomer('E-mail', $CusID);
    
        $to = $cemail;

        $subject='Password Reset for your Everestgifts account';

        $mailcontent = '<table style="width:600px; font-family:arial; font-size:13px;" cellpadding="0" cellspacing="0">
                <tr>
                    <td><h2 style="color:#cc6600; border-bottom:1px solid #cc6600;">Password has Changed</h2></td>
                </tr>
                <tr>
                    <td><p><b>Hi ' . getcustomer('FirstName', $CusID). '</b>,</p><p>Your Account Password for '.getcustomer('E-mail', $CusID).' was changed.</p><p>Your new password for your account is now " <b>'.$resetpassword.'</b> "</p></td>
                </tr>
                
                <tr>
                    <td>
                        <table style="width:100%; border-bottom:1px solid #cc6600; padding:2%; font-size:13px;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="50%;">
                                    <a href="http://www.everestgifts.com.au/" target="_blank">Everest Gifts</a>
                                </td>
                                <td width="50%;" align="right"></td>
                        </table>
                    </td>
                </tr>
            </table>';

        sendoldmail($subject, $mailcontent, $from, $to);
        
    } else {
        $pass = md5(resetpassword);
        $upd1 = pFETCH("UPDATE `customer` SET `Status`=? WHERE `CusID`=?",$Status,$CusID);
    }

    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
}
$userper1 = $db->prepare("SELECT * FROM `customer` WHERE `CusID`=?");
$userper1->execute(array($_REQUEST['CusID']));
$userper = $userper1->fetch();

$userper2 = $db->prepare("SELECT * FROM `bill_ship_address` ");
$userper2->execute(array());
$userper1 = $userper2->fetch();

if ($userper['newsletter'] == '1') {
    $userper['newsletter'] = 'subscribed';
} elseif ($userper['newsletter'] != '1') {
    $userper['newsletter'] = 'Not subscribed';
}
$result = $db->prepare("SELECT name FROM country_new WHERE id =?");
$result->execute(array($REQUEST['id']));

while ($userper2 = $result->fetch(PDO::FETCH_ASSOC)) {

    $text = $userper2['name'];
}
?>
<style>
    td{
        border: none;

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


</script>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer Mgmt
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo $sitename; ?>order/customers.htm"><i class="fa fa-cogs"></i>Customers</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <form method="post" autocomplete="off" enctype="multipart/form-data" action="">
            <div class="box box-info">
                <div class="box-header with-border">

                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>

                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Customer Details
                        </div>
                        <div class="panel-body">         
                            <div class="col-md-6">
                                <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                <select name="Status" class="form-control">
                                    <option value="1" <?php
//  echo $mast->getcategory('status', $_REQUEST['id']);
                                    if ($userper['Status'] == '1') {
                                        echo 'selected';
                                    }
                                    ?>>Active</option>
                                    <option value="0" <?php
                                    if ($userper['Status'] == '0') {
                                        echo 'selected';
                                    }
                                    ?>>Inactive</option>

                                </select>
                            </div>

                            <div class="col-md-12"><br>
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td>
                                                First Name : 
                                            </td>
                                            <td>
                                                <?php echo $userper['FirstName'] ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Last Name : 
                                            </td>
                                            <td>
                                                <?php echo $userper['LastName'] ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Email : 
                                            </td>
                                            <td>
                                                <?php echo $userper['E-mail'] ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Phone : 
                                            </td>
                                            <td>
                                                <?php echo $userper['Mobile'] ?>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                Profile Image: 
                                            </td>
                                            <td>
                                                <?php if($userper['Image']!=''){ echo '<img src="'.$fsitename.'images/profile/'.$userper['Image'].'" height="100" />'; } else { echo 'No Image'; } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Newsletter : 
                                            </td>
                                            <td>
                                                <?php echo $userper['newsletter'] ?>
                                            </td>


                                        </tr>
                                        <tr>
                                            <td>
                                                Reset Password: 
                                            </td>
                                            <td>
                                                <input type="text" name="resetpassword" id="resetpassword" />
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>


                            </div>

                        </div><br/>



                    </div>
                    <?php /*<div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Billing Address
                        </div>
                        <div class="panel-body">         



                            <div class="col-md-12"><br>

                                <table   class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td>
                                                First Name : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['bfirstname'] ?>
                                            </td>



                                            <td>
                                                Last Name : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['blastname'] ?>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                Email : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['bemail'] ?>
                                            </td>



                                            <td>
                                                Phone : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['bphone'] ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                Address1 : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['baddress1'] ?>
                                            </td>


                                            <td>
                                                Address2 : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['baddress2'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                city : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['bcity'] ?>
                                            </td>


                                            <td>
                                                Postal Code : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['bpostcode'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                State : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['bstate'] ?>
                                            </td>

                                            <td>
                                                Country : 
                                            </td>
                                            <td>
                                                <?php
                                                $result1 = $db->prepare("SELECT * FROM `country_new` ");
                                                $result1->execute(array());
                                                while ($row = $result1->fetch()) {
                                                    if ($row['id'] == $userper1['bcountry']) {
                                                        echo $row['name'];
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><br/>
                    </div>

                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Shipping Address
                        </div>
                        <div class="panel-body">         



                            <div class="col-md-12"><br>

                                <table   class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <td>
                                                First Name : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['sfirstname'] ?>
                                            </td>



                                            <td>
                                                Last Name : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['slastname'] ?>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                Email : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['semail'] ?>
                                            </td>



                                            <td>
                                                Phone : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['sphone'] ?>
                                            </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                Address1 : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['saddress1'] ?>
                                            </td>


                                            <td>
                                                Address2 : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['saddress2'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                city : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['scity'] ?>
                                            </td>


                                            <td>
                                                Postal Code : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['spostcode'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                State : 
                                            </td>
                                            <td>
                                                <?php echo $userper1['sstate'] ?>
                                            </td>

                                            <td>
                                                Country : 
                                            </td>
                                            <td>
                                                <?php
                                                $result1 = $db->prepare("SELECT * FROM `country_new` ");
                                                $result1->execute(array());
                                                while ($row = $result1->fetch()) {
                                                    if ($row['id'] == $userper1['scountry']) {
                                                        echo $row['name'];
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><br/>
                    </div> */ ?>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?php echo $sitename; ?>order/customers.htm">Back to Listings page</a>
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
                        </form>
                    </div>
                </div>
            </div>
            </div>

            <!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var sid = a;
        window.location.href = '<?php echo $sitename; ?>order/' + a + '/viewcustomer';
    }
</script>
<?php include ('../../require/footer.php'); ?>
<script type="text/javascript">

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
