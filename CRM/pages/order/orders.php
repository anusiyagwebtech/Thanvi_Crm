<?php
$menu = "3,2,6";
$thispageid = 11;
include ('../../config/config.inc.php');
$dynamic = '1';
$datatable = '1';
include ('../../require/header.php');
?>
<style type="text/css">
    .row { margin:0;}
    #example1 tbody tr td:nth-child(1),tbody tr td:nth-child(2), tbody tr td:nth-child(6),tbody tr td:nth-child(7) {
        text-align:center;
    }
    #example1 tbody tr td:nth-child(5) {
        text-align:right;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Orders
            <small>List of Order(s)</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i>order</a></li>
            <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Orders</a></li>            
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-body">
                <div id="mmssg"><?php echo $msg; ?></div>
                <form name="form1" method="post" action="">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr align="center">
                                    <th style="width:5%;">O.id</th>
                                    <th style="width:15%">Order Date</th>
                                    <th style="width:10%">Order ID</th>
                                    <th style="width:30%">Customer</th>
                                    <th style="width:10%">Amount</th>
                                    <th style="width:20%">Order Status</th>
                                    <th style="width:10%">View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $o = '1';
                                $ord = pFETCH("SELECT * FROM `norder` WHERE `oid`!=? ORDER BY `oid` DESC", '');
                                while ($ford = $ord->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $o; ?></td>
                                        <td><?php echo date('d-M-Y H:i:s A', strtotime($ford['datetime'])); ?></td>
                                        <td><?php echo $ford['order_id']; ?></td>
                                        <td><?php
                                            if ($ford['guest'] == '1') {
                                                echo getguest1('email', $ford['CusID']) . ' ( Guest )';
                                            } else {
                                                echo getcustomer1('E-mail', $ford['CusID']);
                                            }
                                            ?></td>
                                        <td><?php echo $ford['currency'] . ' ' . number_format($ford['over_all_total'], '2', '.', ''); ?></td>
                                        <td>
                                            <select name="od_status" id="od_status" class="form-control" onchange="return changestatus(this.value,<?php echo $ford['oid']; ?>);">
                                                <option value="">Select Status</option>
                                                <option value="0" <?php
                                                if ($ford['order_status'] == '0') {
                                                    echo 'selected';
                                                }
                                                ?>>Awaiting Payment</option>
                                                <option value="1" <?php
                                                if ($ford['order_status'] == '1') {
                                                    echo 'selected';
                                                }
                                                ?>>Awaiting Fulfillment</option>
                                                <option value="2" <?php
                                                if ($ford['order_status'] == '2') {
                                                    echo 'selected';
                                                }
                                                ?>>Completed</option>
                                                <option value="3" <?php
                                                if ($ford['order_status'] == '3') {
                                                    echo 'selected';
                                                }
                                                ?>>Cancelled</option>
                                                <option value="4" <?php
                                                if ($ford['order_status'] == '4') {
                                                    echo 'selected';
                                                }
                                                ?>>Declined</option>
                                                <option value="5" <?php
                                                if ($ford['order_status'] == '5') {
                                                    echo 'selected';
                                                }
                                                ?>>Refunded</option>
                                                <option value="6" <?php
                                                if ($ford['order_status'] == '6') {
                                                    echo 'selected';
                                                }
                                                ?>>Partially Refunded</option>
                                            </select>
                                        </td>
                                        <td><i class="fa fa-eye" style="cursor:pointer;" onclick="editthis(<?php echo $ford['oid']; ?>);"> View</i></td>
                                    </tr>
                                    <?php
                                    $o++;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">&nbsp;</th>
                                    <td align="center"><div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" id="sendmail" name="sendmail" value="1" style="width:20px; float: left; height: 20px;" />
                                            </span>
                                            <label for="sendmail" class="form-control bg-gray color-palette">Send Mail</label>
                                        </div></td>
                                        <td>&nbsp;</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    function editthis(a)
    {
        var did = a;
        window.location.href = '<?php echo $sitename; ?>order/' + a + '/vieworder.htm';
    }
    function changestatus(a, b)
    {
        var e = $('input[name="sendmail"]:checked').val();
        var status = a;
        var oid = b;
        if (confirm("Please confirm you want to change the Order Status)"))
        {
            changestatusmessage(status, oid, e);
            location.reload();
            return true;
        } else
        {
            location.reload();
            return false;
        }
    }

    function changestatusmessage(a, b, c)
    {
        var a = a;
        var b = b;
        var c = c;
        if (window.XMLHttpRequest)
        {
            oRequestsubcat = new XMLHttpRequest();
        } else if (window.ActiveXObject)
        {
            oRequestsubcat = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if ((a != '') && (b != ''))
        {
            document.getElementById("mmssg").innerHTML = '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>';
            oRequestsubcat.open("POST", "<?php echo $fsitename; ?>get/results.htm", true);
            oRequestsubcat.onreadystatechange = getcstatus;
            oRequestsubcat.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            oRequestsubcat.send("orderstatus=" + a + "&orderid=" + b +"&sendmail="+c);
            console.log(a, b);
        }
        return false;
    }

    function getcstatus()
    {
        if (oRequestsubcat.readyState == 4)
        {
            if (oRequestsubcat.status == 200)
            {
                document.getElementById("mmssg").innerHTML = oRequestsubcat.responseText;
            } else
            {
                document.getElementById("mmssg").innerHTML = oRequestsubcat.responseText;
            }
        }
    }
</script>
<?php
include ('../../require/footer.php');
?>  