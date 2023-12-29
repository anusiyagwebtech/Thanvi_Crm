<?php
$menu = "3,2,6";
if ($_REQUEST['oid'] != '') {
    $thispageeditid = 1;
} else {
    $thispageid = 1;
}

include ('../../config/config.inc.php');
$dynamic = '1';
$datepicker = '1';
include ('../../require/header.php');


$norder = FETCH_all("SELECT * FROM `norder` WHERE `oid`=?", $_REQUEST['oid']);

if ($norderfetch['order_status'] == '0') {
    $odstatus = 'Unpaid/Incomplete Order';
} elseif ($norderfetch['order_status'] == '1') {
    $odstatus = 'Processing';
} elseif ($norderfetch['order_status'] == '2') {
    $odstatus = 'Success';
} elseif ($norderfetch['order_status'] == '3') {
    $odstatus = 'Failure';
} elseif ($norderfetch['order_status'] == '4') {
    $odstatus = 'Cancelled';
}

if ($norder['order_status'] == '0') {
    $ostatus = 'Awaiting for Payment';
} elseif ($norder['order_status'] == '1') {
    $ostatus = 'Awaiting Fulfillment';
} elseif ($norder['order_status'] == '2') {
    $ostatus = 'Completed';
} elseif ($norder['order_status'] == '3') {
    $ostatus = 'Cancelled';
} elseif ($norder['order_status'] == '4') {
    $ostatus = 'Declined';
} elseif ($norder['order_status'] == '5') {
    $ostatus = 'Refunded';
} elseif ($norder['order_status'] == '6') {
    $ostatus = 'Partially Refunded';
}
if ($norder['promotional_type'] == '1') {
    $ptype = $norder['promotional_code'] . ' (' . $norder['promotional_discount'] . ' %)';
} elseif ($norder['promotional_type'] == '2') {
    $ptype = $norder['promotional_code'] . ' (' . $norder['promotional_discount'] . ' ' . $norder['currency'] . ')';
} else {
    $ptype = '-';
}

if (isset($_REQUEST['update'])) {
    @extract($_REQUEST);
    
    $upd=$db->prepare("UPDATE `norder` SET `shipping_address`=?,`order_status`=?,`order_comments`=?,`card_message`=?,`anonymously`=? WHERE `oid`=?");
    $upd->execute(array($shipping_address,$od_status,$order_comments,$card_message,$anonymous,$_REQUEST['oid']));
    
    if ($od_status == '0') {
        $ostatus = 'Awaiting for Payment';
    } elseif ($od_status == '1') {
        $ostatus = 'Awaiting Fulfillment';
    } elseif ($od_status == '2') {
        $ostatus = 'Completed';
    } elseif ($od_status == '3') {
        $ostatus = 'Cancelled';
    } elseif ($od_status == '4') {
        $ostatus = 'Declined';
    } elseif ($od_status == '5') {
        $ostatus = 'Refunded';
    } elseif ($od_status == '6') {
        $ostatus = 'Partially Refunded';
    }

    if ($norder['guest'] == '1') {
        $name = getguest1('email', $norder['CusID']) . ' ( Guest )';
        $cemail = getguest1('email', $norder['CusID']);
    } else {
        $name = getcustomer1('FirstName', $norder['CusID']);
        $cemail = getcustomer1('E-mail', $norder['CusID']);
    }
    
    $to = $cemail;
    
    $subject='Your Everest Gifts Order Has Been Updated '.$norder['order_id'];

    $mailcontent = '<table style="width:600px; font-family:arial; font-size:13px;" cellpadding="0" cellspacing="0">
                <tr>
                    <td><h2 style="color:#cc6600; border-bottom:1px solid #cc6600;">Order Status Changed</h2></td>
                </tr>
                <tr>
                    <td><p><b>Hi ' . $name . '</b>,</p><p>An order you recently placed on our website has had its status changed.</p><p>The status of order '.$norder['order_id'].' is now ' . $ostatus . '</p></td>
                </tr>
                <tr>
                    <td>
                        <table style="width:100%; border-bottom:1px solid #cc6600; padding:2%; font-size:13px;" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="60%;" align="left">
                                    <h4>Order Number : ' . $norder['order_id'] . '</h4>
                                    <p>Order Date : ' . date('d-M-Y H:i:s A', strtotime($norder['datetime'])) . '</p>
                                    <p>Payment Method : ' . $norder['payment_mode'] . '</p>
                                    <h4>Currency : ' . $norder['currency'] . '</h4>
                                </td>
                                <td width="40%;">
                                </td>
                            </tr>
                        </table>
                    </td>
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

    if ($_REQUEST['sendmail'] == '1')
    {
         //Customer Email
        sendoldmail($subject, $mailcontent, $cemail, $to);
    }
    $msg='<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-check"></i> Order Updated Successfully!!! </div>';
}

?>
<style>
    td {
        border: none;
    }
</style>
<?php

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Order Mgmt
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo $sitename; ?>order/orders.htm"><i class="fa fa-shopping-cart"></i> order</a></li>
            <li><a href="#">view Order</a></li>

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
                            Customer Details <?php echo $fsitename ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12" style="padding-bottom: 10px;">
                                    <a href="<?php echo $fsitename ?>MPDF/<?php echo $norder['oid']; ?>/orderinvoice.htm" target="_blank" style="font-size: 21px;float:right">View Invoice</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <?php if ($norder['guest'] == '1') { ?>
                                                <tr>
                                                    <td colspan="2">Guest User
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="2">
                                                    <?php echo $norder['billing_address']; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table   class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Order ID : 
                                                </td>
                                                <td>
                                                    <?php echo $norder['order_id']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Date : 
                                                </td>
                                                <td>
                                                    <?php echo date("d-M-Y h:i:s A", strtotime($norder['datetime'])) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Delivery Date : 
                                                </td>
                                                <td>
                                                    <?php echo date("d-M-Y h:i:s A", strtotime($norder['delivery_date'])) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Currency : 
                                                </td>
                                                <td>
                                                    <?php echo $norder['currency']; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Order Status : 
                                                </td>
                                                <td>
                                                    <select name="od_status" id="od_status" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="0" <?php
                                                        if ($norder['order_status'] == '0') {
                                                            echo 'selected';
                                                        }
                                                        ?>>Awaiting Payment</option>
                                                        <option value="1" <?php
                                                        if ($norder['order_status'] == '1') {
                                                            echo 'selected';
                                                        }
                                                        ?>>Awaiting Fulfillment</option>
                                                        <option value="2" <?php
                                                        if ($norder['order_status'] == '2') {
                                                            echo 'selected';
                                                        }
                                                        ?>>Completed</option>
                                                        <option value="3" <?php
                                                        if ($norder['order_status'] == '3') {
                                                            echo 'selected';
                                                        }
                                                        ?>>Cancelled</option>
                                                        <option value="4" <?php
                                                        if ($norder['order_status'] == '4') {
                                                            echo 'selected';
                                                        }
                                                        ?>>Declined</option>
                                                        <option value="5" <?php
                                                        if ($norder['order_status'] == '5') {
                                                            echo 'selected';
                                                        }
                                                        ?>>Refunded</option>
                                                        <option value="6" <?php
                                                        if ($norder['order_status'] == '6') {
                                                            echo 'selected';
                                                        }
                                                        ?>>Partially Refunded</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Agent Code : 
                                                </td>
                                                <td>
                                                    <?php echo $norder['agent_code']; ?>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Shipping Information
                        </div>
                        <div class="panel-body">  
                            <div class="col-md-12">
                                <textarea name="shipping_address" id="shipping_address" class="form-control"><?php echo stripslashes($norder['shipping_address']); ?></textarea>

                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Other Informations
                        </div>
                        <div class="panel-body">  
                            <div class="col-md-4">
                                <label>Order Comments</label>
                                <textarea name="order_comments" id="order_comments" class="form-control"><?php echo stripslashes($norder['order_comments']); ?></textarea>            
                            </div>
                            <div class="col-md-4">
                                <label>Card Message</label>
                                <textarea name="card_message" id="card_message" class="form-control"><?php echo stripslashes($norder['card_message']); ?></textarea>            
                            </div>
                            <div class="col-md-4">
                                <label>Send this Gift as Surprise</label>
                                <select name="anonymous" id="aonymous" class="form-control">
                                    <option value="0" <?php
                                    if ($norder['anonymously'] == '0') {
                                        echo 'selected="selected"';
                                    }
                                    ?>>No</option>
                                    <option value="1" <?php
                                    if ($norder['anonymously'] == '1') {
                                        echo 'selected="selected"';
                                    }
                                    ?>>Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>    

                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Product Information
                        </div>
                        <div class="panel-body">  
                            <div class="col-md-12">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="25%">Product Name</th>
                                            <th width="15%" align="right">Price</th>
                                            <th width="10%" align="center">Qty</th>
                                            <th width="15%" align="right">Amount</th>
                                        </tr>           	
                                    </thead>
                                    <tbody>
                                        <?php
                                        $row = pFETCH("SELECT * FROM `order` WHERE `Order_id`=?", $norder['oid']);
                                        while ($frow = $row->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tr> 
                                                <td style="vertical-align:top"><?php echo $frow['product_name']; ?></td>
                                                <td style="vertical-align:top"><?php echo number_format($frow['product_price'], 2, '.', '') ?></td>
                                                <td align="center" style="vertical-align:top"><?php echo $frow['product_qty']; ?></td>
                                                <td align="right" style="vertical-align:top;padding-right: 10px;"> <?php echo number_format($frow['product_total_price'], 2, '.', '') ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">

                                <h4>Payment Method : <?php echo $norder['payment_mode']; ?></h4>
                                <p>Applied Promo Code : <?php echo $ptype; ?> </p>

                            </div>
                            <div class="col-md-6">
                                <td width="50%;" align="right">
                                    <table style="width:100%; font-size:13px;">
                                        <tr>
                                            <td style="border-bottom:1px dotted #cc6600;"><b>SubTotal (<?php echo $norder['currency']; ?>) :</b></td><td  style="border-bottom:1px dotted #cc6600;" align="right"><?php echo number_format($norder['subtotal'], '2', '.', ''); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom:1px dotted #cc6600;"><b>Discount (<?php echo $norder['currency']; ?>) :</b></td><td style="border-bottom:1px dotted #cc6600;" align="right"><?php echo number_format($norder['discounted_amount'], '2', '.', ''); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom:1px dotted #cc6600;"><b>Shipping (<?php echo $norder['currency']; ?>) :</b></td><td  style="border-bottom:1px dotted #cc6600;"align="right"><?php echo number_format($norder['shipping_charge'], '2', '.', ''); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom:1px dotted #cc6600;"><b>Total (<?php echo $norder['currency']; ?>) :</b></td><td style="border-bottom:1px dotted #cc6600;" align="right"><?php echo number_format($norder['over_all_total'], '2', '.', ''); ?></td>
                                        </tr>
                                    </table>
                                </td>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?php echo $sitename; ?>order/orders.htm">Back to Listings page</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="submit" name="update" id="update" class="btn btn-success">UPDATE</button>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </form>
        <!-- /.box -->
    </section><!-- /.content 
</div><!-- /.content-wrapper -->
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
