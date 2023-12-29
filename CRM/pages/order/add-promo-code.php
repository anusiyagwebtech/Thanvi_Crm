<?php
$menu = '3,2,70';
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
    $getid = $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $msg = add_promo_code($promo_code, $type, $value, $date_from, $date_to, $customers, $status, $ip, $getid);
}
$values_s = getTable('promocode', 'pcid', $_REQUEST['id']);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Promo Codes
            <small><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Promo Codes </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#"><i class="fa fa-asterisk"></i> Order</a></li>
            <li><a href="<?php echo $sitename; ?>order/promo-code.htm">Promo Codes </a></li>
            <li class="active"><?php
                if ($_REQUEST['id'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> Promo Code</li>
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
                        ?> Promo Code</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>
                    <div class="panel panel-info" id="comp_details_fields">
                        <div class="panel-heading">
                            Promo Code
                        </div>
                        <div class="panel-body">                        
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Code<span style="color:#FF0000;">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="promo_code" id="promo_code" placeholder="Enter The Code" class="form-control" value="<?php echo $values_s['promo_code']; ?>"  pattern="[A-Za-z0-9]{6}" title="Special character not allowed." required />
                                        <span class="input-group-addon" onclick="makeid();"><i class="fa fa-refresh"></i></span>
                                    </div>
                                </div>  
                                <div class="col-md-4">
                                    <label>Type <span style="color:#FF0000;">*</span></label>
                                    <select name="type" class="form-control" required>
                                        <option value="">Select</option>
                                        <option value="1" <?php echo ($values_s['type'] == '1') ? 'selected' : ''; ?>>Discount</option>
                                        <option value="2" <?php echo ($values_s['type'] == '2') ? 'selected' : ''; ?>>Amount</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Value <span style="color:#FF0000;">*</span></label>
                                    <input type="text" class="form-control" required="required" placeholder="Enter The Value" pattern="[A-Za-z0-9.,&_-]{1,55}" title="Special character not allowed." name="value" id="value" value="<?php echo $values_s['value']; ?>"required/>
                                </div>

                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-4">
                                    <label>From Date</label>
                                    <input type="text" name="date_from" class="form-control datepicker" required placeholder="From Date" value="<?php echo date("d-M-Y",strtotime($values_s['fromdate'])); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label>To Date</label>
                                    <input type="text" name="date_to" class="form-control datepicker" required placeholder="To Date" value="<?php echo date("d-M-Y",strtotime($values_s['todate'])); ?>" />
                                </div>
                                <div class="col-md-4">
                                    <label>Customers</label>
                                    <select name="customers[]" multiple class="form-control select2">
                                        <?php
                                        $sv = $db->prepare("SELECT * FROM `customer` WHERE `status`='1'");
                                        $sv->execute();
                                        while ($f = $sv->fetch()) {
                                            ?>
                                            <option value="<?php echo $f['CusID']; ?>" <?php echo ($values_s['specific_customers'] == $f['CusID']) ? 'selected' : ''; ?>><?php echo $f['FirstName'] . ' ' . $f['LastName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Status <span style="color:#FF0000;">*</span></label>                                  
                                    <select name="status" class="form-control">
                                        <option value="1" <?php
                                        if ($values_s['status'] == '1') {
                                            echo 'selected';
                                        }
                                        ?>>Active</option>
                                        <option value="0" <?php
                                        if ($values_s['status'] == '0') {
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
                            <a href="<?php echo $sitename; ?>order/promo-code.htm">Back to Listings page</a>
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
    function makeid() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 6; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        $('#promo_code').val(text);
    }
    $('.datepicker').datepicker({
        format: 'd-M-yyyy',
        autoclose: true
    });
</script>