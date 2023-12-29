<?php
$menu = "8,8,18";
$thispageid = 18;
if (isset($_REQUEST['coid'])) {
    $thispageeditid = 36;
} else {
    $thispageaddid = 36;
}
$franchisee = 'yes';
include ('../../config/config.inc.php');
$dynamic = '1';

include ('../../require/header.php');



if (isset($_REQUEST['statusupdate'])) {

    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];
    $getid = $_REQUEST['coid'];
    global $fsitename;

    $msg = updatecontact($status, $getid);
}

if (isset($_REQUEST['submit'])) {

    @extract($_REQUEST);
    $ip = $_SERVER['REMOTE_ADDR'];

    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
    $companyname = $general['Company_name'];

    $manageprofile = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
    $from = $manageprofile['recoveryemail'];

    $to = getcontactform1('emailid', $_REQUEST['coid']);

    $subject = "Reply Message For Your Contact From $companyname";

    $message = '<div style="background-color:#efefef;  -webkit-font-smoothing:antialiased; -webkit-text-size-adjust:none; width: 100%!important;height: 100%;">
    <table  height="100%" style="width: 100%;table-layout: fixed;">
     <tbody style="margin: 0 auto;display: table;">
        <tr>
            <td style="max-width: 600px!important; margin: 0 auto!important; clear: both!important;" >
                <div style="padding: 15px;max-width: 600px;margin: 0 auto; display: block;">
                    <table style="width: 100%;">
                        <tr>
                            <td><a href="' . $fsitename . '"> <img src=" ' . $fsitename . 'images/logo.png" style="float: left;" height="50px" border="0" /></a></td>
                            <td style="float:right;"></td>
                        </tr>
                    </table>
                </div>
            </td>
          </tr>
           <tr>   
            <td  style="clear: both!important;width:100%;">
                <div style="background:#960a9a;width: 100%;height: 35px;color: #fff; text-align:center; font-size: 20px; padding-top: 10px ">Reply For Contact</div>
            </td>
            </tr>
           <tr>
            <td bgcolor="#FFFFFF" style="max-width: 600px!important;margin: 0 auto!important;clear: both!important;">
                <div style="padding: 15px;max-width: 600px;margin: 0 auto;display: block;">
                    <table width="100%" height="100%" style="background:#FFFFF;">
                        <tr>
                            <td align="center" valign="middle">
                                <table width="571" border="0" cellspacing="0" cellpadding="0" style=" font-family:sans-serif; font-size:14px;font-weight: normal;  ">
                                    <tr>
                                        <td colspan="3" style="padding: 8px;margin-bottom: 10px;   line-height: 1.6;">Dear ' . getcontactform1('name', $_REQUEST['coid']) . ' , </td>
                                        <td style="padding: 8px;" colspan="2"></td>
                                    </tr>                                  
                                    <tr>
                                         <td colspan="3" style="padding: 8px;margin-bottom: 10px; line-height: 1.6;">Subject:</td>
                                         <td style="padding: 8px;" colspan="2">' . $_REQUEST['subject'] . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding: 8px;margin-bottom: 10px;line-height: 1.6;">Comment :</td>
                                        <td style="padding: 8px;" colspan="2">' . $_REQUEST['comment'] . '</td>        
                                    </tr>
                                                                   
                                    <tr>                                       
                                        <td>                                              
                                            <p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;">Regards,</p>
                                            <p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;"> ' . $companyname . '</p><br/>
                                            <p style="margin-bottom: 10px; font-weight: normal; padding-right: 10px; font-size: 14px; line-height: 1.6;"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div><!-- /content -->
            </td>
            </tr>
           <tr>
            <td  bgcolor="#efefef" style=";max-width: 600px!important;margin: 0 auto!important;clear: both!important;">
                <table style="width:100%">
                    <tr>
                        <td style="padding:5px;font-size: 14px; text-align: left;"  height="26"  colspan="3" valign="middle"  style="font-family:Arial, Gadget, sans-serif; font-size:10px; color:#000; align:center; font-weight:normal;">Copyrights &copy; ' . date('Y') . '  ' . $companyname . ' All Rights Reserved.&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>';
//    echo $message;
//    echo $to;
//    echo $from;
//    exit;
    sendgridmail($to, $message, $subject, $from, '', '');
    $msg = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Email Send Successfully. </h4></div>';
}
?>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="btn-group pull-right m-t-15">
                        <a href="<?php echo $sitename; ?>forms/contactlist.htm"><button type="button" class="btn btn-default">Back to Listing</button>
                        </a>                                  
                    </div>
                    <h4 class="page-title"><?php
                        if (isset($_REQUEST['coid'])) {
                            echo "View";
                        } else {
                            echo "Add";
                        }
                        ?> Contact</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo $sitename; ?>">Anvay</a></li>
                        <li class="breadcrumb-item">Forms</li>
                        <li class="breadcrumb-item active"><?php
                            if (isset($_REQUEST['coid'])) {
                                echo "View";
                            } else {
                                echo "Add";
                            }
                            ?> Contact</li>
                    </ol>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="row">
                            <div class="col-md-12">
                                <form name="department" id="department" action="#" method="post" enctype="multipart/form-data" autocomplete="off" >
                                    <div class="box box-info">
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
                                                            <?php echo getcontactform1("name", $_REQUEST['coid']); ?>
                                                        </div>                                                    
                                                        <div class="col-md-3">
                                                            Emailid:
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?php echo getcontactform1("emailid", $_REQUEST['coid']); ?>
                                                        </div>
                                                    </div>
                                                    <br />
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            Contact Number:
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?php echo getcontactform1("mobileno", $_REQUEST['coid']); ?>
                                                        </div>
                                                        <div class="col-md-3">
                                                            Subject:
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?php echo getcontactform1('subject', $_REQUEST['coid']); ?>
                                                        </div>
                                                    </div>
                                                    <br />
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            Message:
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?php echo getcontactform1('content', $_REQUEST['coid']); ?>
                                                        </div>                                                   
                                                        <div class="col-md-3">
                                                            Date:
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?php echo date('d-M-Y', strtotime(getcontactform1('date', $_REQUEST['coid']))); ?>
                                                        </div>
                                                    </div><br/>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            Status:
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select name="status" class="form-control">
                                                                <option value="1" <?php
                                                                if (stripslashes(getcontactform1('status', $_REQUEST['coid'])) == '1') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Active</option>
                                                                <option value="0" <?php
                                                                if (stripslashes(getcontactform1('status', $_REQUEST['coid']) == '0')) {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Inactive</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-8"></div>
                                                        <div class="col-md-4">
                                                            <button type="button" id="reply" class="btn btn-success" style="float:right;" onclick="click1();"> Reply</button>
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
                                                            <label>To <span style="color:#FF0000;"></span></label>
                                                            <input type="text" name="email" id="email"  pattern="[A-Za-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" class="form-control" value="<?php echo getcontactform1('emailid', $_REQUEST['coid']); ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="row">                                
                                                        <div class="col-md-12">
                                                            <br>
                                                            <label>Subject <span style="color:#FF0000;"></span></label>
                                                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter the Subject"> </div></div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <br>
                                                            <label>Comment <span style="color:#FF0000;"></span></label>
                                                            <textarea rows="3" cols="30" name="comment"  id="comment" class="form-control"> </textarea>
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
                                                    <div class="col-md-6">
                                                        <button type="submit" name="statusupdate" id="statusupdate" class="btn btn-success" style="float:right;">Update Status</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </form> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container -->
</div> <!-- content -->

<?php include ('../../require/footer.php'); ?>

<script>
    function click1()
    {

        $('#demo').css("display", "block");

    }
</script>