<?php
$menu = '1,1,1';



if (isset($_REQUEST['lid'])) {
    $thispageeditid = 1;
} else {
    $thispageid = 1;
}
// include ('../../../config/config.inc.php');
$dynamic = '1';
// include ('../../../require/header.php');
include ('../../require/sidebar.php');
include ('../../require/header.php');
// include ('../../config/config.inc.php');

if (isset($_REQUEST['newclient'])) {
    global $db;
    @extract($_REQUEST);
  $resa = $db->prepare("INSERT INTO `client`( `cus_name`,`com_name`,`mobile`,`email`,`address`,`domain`) VALUES(?,?,?,?,?,?)");
 $resa->execute(array($cusname, $cmpname, $mobileno, $emailid, $city, $domain));  
 $insid = $db->lastInsertId(); 
 $url="addlead.php?pid=".$insid; 
  echo "<script>window.location.assign('".$url."')</script>";  


}

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['lid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext = '0';
    if ($imagetitle != '') {
        $imagec = $imagetitle;  
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    if ($getid != '') {
        
        $linkimge = $db->prepare("SELECT * FROM `lead_form` WHERE `lid` = ? ");
        $linkimge->execute(array($getid));
        $linkimge1 = $linkimge->fetch();
        $pimage = $linkimge1['image'];
    }
    if ($imag) {
        if ($pimage != '') {            
            unlink("../../images/document/" . $pimage);
            unlink("../../images/document/thump/" . $pimage);
        }
        $main = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        $size = $_FILES['image']['size'];
        $width = 1000;
        $height = 1000;
        $width1 = 200;
        $height1 = 200;
        $extension = getExtension($main);
        $extension = strtolower($extension);
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'pdf')) {
            $m = strtolower($imagec);
            $imagev = $m . "." . $extension;
            $thumppath = "../../images/document/";
            $thumppath1 = "../../images/document/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $thumppath1, $thumppath1, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['lid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') {
        $msg = addlead($client,$type, $image, $sentthrough, $sentto, $date, $proposal, $leadtype, $domain, $getid);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-cross"></i> Image Format was Invalid., Please Use JPG, PNG, GIF Format</h4></div>';
    }
}
?>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker-autoclose" ).datepicker();
    $( "#anim" ).on( "change", function() {
      $( "#datepicker-autoclose" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
  </script>
  <style>
        .alert {
  padding: 20px;
  background-color:#4ac18e;
  color: white;
  text-align:center;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
  </style>


                    <!-- ==================
                         PAGE CONTENT START
                         ================== -->

                    <div class="page-content-wrapper">

                        <div class="container-fluid">
                             <?php print_r($msg)?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">

                                            <!-- <h4 class="mt-0 header-title">Validation type</h4>
                                            <p class="text-muted m-b-30 font-14"></p> -->
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <form class="" action="#" method="post" enctype="multipart/form-data">
                                                   <div class="form-group">
                                                    <!-- <label class="control-label">Type Of Proposal</label>
 -->
                                                  
                                                   <label>Lead Type</label>
                                                   <select name="leadtype" class="form-control">
                                                     <option value="">Select</option>
                                                     <option value="Direct Lead" <?php if(getlead('leadtype', $_REQUEST['lid'])=='Direct Lead') { ?> selected <?php } ?>>Direct Lead</option>
                                                      <option value="Reference Lead" <?php if(getlead('leadtype', $_REQUEST['lid'])=='Reference Lead') { ?> selected <?php } ?>>Reference Lead</option>
                                                       <option value="Old Customer" <?php if(getlead('leadtype', $_REQUEST['lid'])=='Old Customer') { ?> selected <?php } ?>>Old Customer</option>
                                                        <option value="Online Lead" <?php if(getlead('leadtype', $_REQUEST['lid'])=='Online Lead') { ?> selected <?php } ?>>Online Lead</option>  
                                                   </select>
                                              
                                                    <!-- <select class="form-control select2" name="type">
                                                        <option>none</option>
                                                        <optgroup label="Type Of Proposal">
                                                            <option value="call" <?php
                                                                if (getlead('type', $_REQUEST['lid']) == 'call') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Call</option>
                                                            <option
                                                             value="Mail" <?php
                                                                if (getlead('type', $_REQUEST['lid']) == 'Mail') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Mail</option>
                                                            <option value="Message" <?php
                                                                if (getlead('type', $_REQUEST['lid']) == 'Message') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Message</option>

                                                        </optgroup>
                                                  
                                                    </select> -->
                                                </div>
                                            </div>
                                              <div class="col-lg-6">
                                                  <div class="form-group">
                                                    <label>Client Name</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info btn-sm"  data-toggle="modal" data-target=".bs-example-modal-lg" style="height:36px;">+ Add Client</button>
                                                    <select name="client" class="form-control" required>
                                                        <option value="">Select</option>
                                                        <?php
$customer = pFETCH("SELECT * FROM `client` WHERE `cid`!=?", '0');
while ($customerfetch = $customer->fetch(PDO::FETCH_ASSOC)) 
{
?>
 <option value="<?php echo $customerfetch['cid']; ?>" <?php if(getlead("client", $_REQUEST['lid'])==$customerfetch['cid'] || $customerfetch['cid']==$_REQUEST['pid']) { ?> selected="selected" <?php } ?>><?php echo $customerfetch['cus_name']; ?></option>
<?php } ?>                   
                                                    </select>
                                                  
                                                   
                          
                                                </div>
   
                                            </div>
                                            <div class="col-md-6">
                            <label>Domain <span style="color:#FF0000;">*</span></label>
                           <select class="form-control select2" name="domain">
                                                        <option>None</option>
                                                         <optgroup label="Type Of Proposal">
                                                            <option value="1">Android</option>
                                                            <option value="2">Web</option>
                                                                <option value="3">SEO</option>
                                                          

                                                        </optgroup>
                                                    </select>
                        </div>
                                              <div class="col-lg-6">
                                                  <div class="form-group">
                                                    <label>Proposal Document and Upload Preview</label>
                                                    <input type="file" name="document"class="filestyle" data-buttonname="btn-secondary"
                                                    <?php echo getlead('document', $_REQUEST['lid']); ?>>
                                                </div>
   
                                            </div>
                                          </div>

                                            <div class="row">
                                                 <div class="col-lg-6">
                                                     <div class="form-group">
                                                    <label class="control-label">Proposal Send Through</label>
                                                    <select class="form-control select2" name="sentthrough">
                                                        <option>none</option>
                                                        <optgroup label="Proposal Sent Through">
                                                            <!-- <option
                                                            value="call" <?php
                                                                if (getlead('sentthrough', $_REQUEST['lid']) == 'call') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Call</option> -->
                                                            <option
                                                            value="mail"<?php
                                                                if (getlead('sentthrough', $_REQUEST['lid']) == 'mail') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Mail</option>
                                                            <option
                                                            value="message"<?php
                                                                if (getlead('sentthrough', $_REQUEST['lid']) == 'message') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Message</option>

                                                        </optgroup>
                                                  
                                                    </select>
                                                </div>
                                            </div>
                                              <div class="col-lg-6">
                                                <div>
                                                   <label>Proposal Send To</label>
                                                    <input type="text" name="sentto" class="form-control" maxlength="25" name="defaultconfig" id="defaultconfig" value="<?php echo getlead('sentto', $_REQUEST['lid']); ?>" >
                                                </div>
                                            </div>
                                        </div>
                                             <div class="row">
                                               <div class="col-lg-6">
                                                 <div class="form-group">
                                                    <label>Proposal Send Date</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose" size="30"  name="date" value="<?php echo getlead('date', $_REQUEST['lid']); ?>">
                                                         
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div>
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                            </div>
                                                <div class="col-lg-6">
                                                  <div>
                                                   <label>Proposal Status</label>
                                                   <select name="proposal" class="form-control" required>
                                                    <option value="">Select</option>
                                                     <option value="Followup" <?php if(getlead('proposal', $_REQUEST['lid'])=='Followup') { ?> selected <?php } ?>>Followup</option>
                                                      <option value="Converted" <?php if(getlead('proposal', $_REQUEST['lid'])=='Converted') { ?> selected <?php } ?>>Converted</option>
                                                       <option value="Hold" <?php if(getlead('proposal', $_REQUEST['lid'])=='Hold') { ?> selected <?php } ?>>Hold</option>
                                                        <option value="Reject" <?php if(getlead('proposal', $_REQUEST['lid'])=='Hold') { ?> selected <?php } ?>>Reject</option>
                                                    </select>
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    
                                         
                                        </div>
                                           
                                             <div class="row">
                                                  <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div>
                                                        <button type="submit" name="submit" id="submit" class="btn btn-success waves-effect waves-light m-r-5"><?php
                                                            if ($_REQUEST['lid'] != '') {
                                                                echo 'UPDATE';
                                                            } else {
                                                                echo 'Submit';
                                                            }
                                                            ?>
                                                        </button>
                                                     
                                                        <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/lead/lead.php';" type="reset" class="btn btn-outline-secondary waves-effect">
                                                            Cancel
                                                        </button>
                                                         <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/lead/lead.php';" type="reset" class="btn btn-brown waves-effect" style="float:right;">
                                                            Back To List Page
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            </form>

                             <!--  Modal content for the above example -->
                                                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title mt-0" id="myLargeModalLabel">Add Client</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form name="mform" method="post">
       <div class="row" style="padding-left:10px;">
                        
                        
                        <div class="col-md-4">
                            <label>Company Name<span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="cmpname" id="cmpname" placeholder="Enter Company Name" class="form-control" />
                        </div>
                         <div class="col-md-4">
                            <label>Customer Name<span style="color:#FF0000;">*</span></label>
                            <input type="text"  required="required" name="cusname" id="cusname" placeholder="Enter Customer Name" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label>Mobile Number <span style="color:#FF0000;">*</span></label>
                             <input type="text"  required="required" name="mobileno" id="mobileno" placeholder="Enter Mobileno" class="form-control" />
                        </div>
                        </div>
                        <br>
                        <div class="row" style="padding-left:10px;">
                        
                        <div class="col-md-4">
                            <label>E-mail ID <span style="color:#FF0000;">*</span></label>
                             <input type="text"  required="required" name="emailid" id="emailid" placeholder="Enter Emailid" class="form-control"/>
                        </div>
                         <div class="col-md-4">
                            <label>City <span style="color:#FF0000;">*</span></label>
                           <input type="text"  required="required" name="city" id="city" placeholder="Enter City" class="form-control"/>
                        </div>
                          
                    </div>
        <br>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="newclient">Save</button> &nbsp; &nbsp;&nbsp; <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
       </form>
      
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                    

                                        </div>
                                    </div>
                                </div> <!-- end col -->

                            </div> <!-- end row -->

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->



 
          

<?php include"../../require/footer.php"?>
<!-- plugin   -->

    <script src="<?php echo $sitename; ?>public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/select2/js/select2.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-maxlength/bootstrap-maxlength.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
