<?php
$menu = '7,15,15';
if (isset($_REQUEST['coid'])) {
    $thispageeditid = 4;
} else {
    $thispageaddid = 4;
}
$franchisee = 'yes';
include ('../../config/config.inc.php');
$dynamic = '1';

include ('../../require/header.php');

if (isset($_REQUEST['submit'])) {

    @extract($_REQUEST);

    $ip = $_SERVER['REMOTE_ADDR'];

    $general = FETCH_all("SELECT * FROM `contact_form` WHERE `coid` = ?", '1');

    $from = $general['support_mail'];

    $to = getcontact1('emailid', $_REQUEST['coid']);

    $subject = $_REQUEST['subject'];

    $MESSAGE = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="border:5px solid #da5454; background:#fff">
                    <tr>
                        <td align="left" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="10" bgcolor="#2a2a2a">
                                <tr>
                                    <td width="20%" align="right" valign="top" bgcolor="#2a2a2a">
                                         &nbsp;
                                    </td><td width="40%" align="left" valign="middle" bgcolor="#2a2a2a" style="font-family:Arial, Helvetica, sans-serif; color:#fff; font-weight:bold; font-size:12px;">Store 561</td>
                                    <td width="40%" align="center" valign="middle" bgcolor="#2a2a2a" style="font-family:Arial, Helvetica, sans-serif; color:#fff; font-weight:bold; font-size:15px;">&nbsp;&nbsp;&nbsp;<span style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#fff; font-weight:bold;">Contact Reply E-Mail</span></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">&nbsp;</td>
                    </tr>
        <tr>
<td height="15" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding: 0 10px; color:#000;">Dear ' . getcontact1('firstname', $_REQUEST['coid']) . ' ,</td>
        </tr>
        <tr>
<td height="10" align="left" valign="top" style="padding: 0 10px; " ></td>
        </tr>
        <tr>
<td height="15" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding: 0 10px; color:#000; font-weight:normal;">' . $_REQUEST['subject'] . '</td>
        </tr>
        <tr>
<td height="15" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; padding: 0 10px; color:#000; font-weight:normal;">' . $_REQUEST['comment'] . '</td>
        </tr>
        <tr>
<td height="15" align="left" style="padding: 0 10px;" valign="top"></td>
        </tr>
        <tr>
<td height="15" align="left" style="padding: 0 10px;" valign="top"></td>
        </tr>
        <tr>
<td height="15" align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; padding: 0 10px; color:#000; text-decoration:underline; font-weight:bold;">From ' . $general['support_mail'] . ' </td>
        </tr>
        <tr>
<td height="15" align="left" valign="top" style="padding: 0 10px; " ></td>
        </tr>
        <tr>
<td height="26" align="center" valign="middle" bgcolor="#2a2a2a" style="font-family:Arial, Gadget, sans-serif; font-size:10px; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Adarsh. All Rights Reserved.&nbsp;</td>
        </tr>
    </table>';
	sendgridmail($to, $message, $subject, $from, '', '');
    // sendoldmail($subject, $message, $from, $to);
    //sendoldmail($to, $message, $subject, '', '');

    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i>Successfully Send</h4></div>';
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Contact
            <small><?php
                if ($_REQUEST['coid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?> View Contact</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $sitename; ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="#"> <i class="fa fa-envelope-o"></i>Forms</a></li>
            <li><a href="<?php echo $sitename; ?>master/contactlist.htm">Contact Forms</a></li>
            <li class="active"><?php
                if ($_REQUEST['coid'] != '') {
                    echo 'Edit';
                } else {
                    echo 'Add New';
                }
                ?>&nbsp;View Contact</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form name="department" id="department" action="#" method="post" enctype="multipart/form-data" autocomplete="off" >
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php
                        if ($_REQUEST['coid'] != '') {
                            echo 'Edit';
                        } else {
                            echo 'Add New';
                        }
                        ?>&nbsp;View Contact</h3>
                    <span style="float:right; font-size:13px; color: #333333; text-align: right;"><span style="color:#FF0000;">*</span> Marked Fields are Mandatory</span>
                </div>
                <div class="box-body">
                    <?php echo $msg; ?>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Contact Form</div>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-3">
                                    Name:
                                </div>
                                <div class="col-md-3">
                                    <?php echo getcontact1('firstname', $_REQUEST['coid']); ?>
                                </div>
                            </div>
                            <br />


                            <div class="row">
                                <div class="col-md-3">
                                    Email:
                                </div>
                                <div class="col-md-3">
                                    <?php echo getcontact1('emailid', $_REQUEST['coid']); ?>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-3">
                                    Subject :
                                </div>
                                <div class="col-md-3">
                                    <?php echo getcontact1('subject', $_REQUEST['coid']); ?>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-3">
                                    Contact Number :
                                </div>
                                <div class="col-md-3">
                                    <?php echo getcontact1('phoneno', $_REQUEST['coid']); ?>
                                </div>
                            </div>

                            <br />

                            <div class="row">
                                <div class="col-md-3">
                                    Message:
                                </div>
                                <div class="col-md-3">
                                    <?php echo getcontact1('comments', $_REQUEST['coid']); ?>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-3">
                                    Date:
                                </div>
                                <div class="col-md-3">
                                    <?php echo date('d-M-Y', strtotime(getcontact1('date', $_REQUEST['coid']))); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <button type="button"  id="submit" class="btn btn-success" style="float:right;" onclick="click1();"> Reply</button>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="panel panel-info" id="demo" style="display: none;">
                        <div class="panel-heading">
                            <div class="panel-title">Reply</div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>To <span style="color:#FF0000;">*</span></label>
                                    <input type="text" name="email" required="required" id="email" class="form-control" value="<?php echo getcontact1('emailid', $_REQUEST['coid']); ?>" />
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-md-12">
                                    <br>
                                    <label>Subject <span style="color:#FF0000;">*</span></label>
                                    <input type="text" name="subject" id="subject"  required="required"  class="form-control" placeholder="Enter the Subject"> </div></div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <br>
                                    <label>Comment <span style="color:#FF0000;">*</span></label>
                                    <textarea rows="3" cols="30" name="comment"  required="required"  id="comment" class="form-control"> </textarea>
                                </div> </div>
                            <br/>

                            <div class="row">
                                <div class="col-md-8"></div>
                                <div class="col-md-4">
                                    <button type="submit" name="submit" id="submit" class="btn btn-success" style="float:right;" >Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="box-footer">
						<div class="row">
							<div class="col-md-6">
								<a href="<?php echo $sitename; ?>forms/contactlist.htm">Back to Listings page</a>
							</div>
							
						</div>
					</div>
                </div><!-- /.box-body -->
        </form> 
    </section><!-- /.content -->

</div><!-- /.content-wrapper -->

<?php include ('../../require/footer.php'); ?>

<script>
    function click1()
    {

        $('#demo').css("display", "block");

    }
</script>