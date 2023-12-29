<?php
$menu = '1,1,1';



if (isset($_REQUEST['cid'])) {
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

if (isset($_REQUEST['submit'])) {
    @extract($_REQUEST);
    $getid = $_REQUEST['cid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext = '0';
    if ($imagetitle != '') {
        $imagec = $imagetitle;  
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    if ($getid != '') {
        
        $linkimge = $db->prepare("SELECT * FROM `client` WHERE `cid` = ? ");
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
            $thumppath = "../../../images/document/";
            $thumppath1 = "../../../images/document/thump/";
            $aaa = Imageupload($main, $size, $width, $thumppath, $thumppath, '255', '255', '255', $height, strtolower($m), $tmp);
            $bbb = Imageupload($main, $size, $width1, $thumppath1, $thumppath1, '255', '255', '255', $height1, strtolower($m), $tmp);
        } else {
            $ext = '1';
        }
        $image = $imagev;
    } else {
        if ($_REQUEST['cid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') {
        $msg = addclient($cus_name, $com_name, $mobile, $email, $address, $domain, $getid);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-cross"></i> Image Format was Invacid., Please Use JPG, PNG, GIF Format</h4></div>';
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
.row{
  padding-top:20px;
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

                                            <h4 class="mt-0 header-title">Add Client Details</h4>
                                            <p class="text-muted m-b-30 font-14"></p>
                                        <form class="" action="#" method="post" enctype="multipart/form-data">
                                             <div class="row">
                                                 <div class="col-lg-6">
                                                <div>
                                                   <label>Company Name</label>
                                                    <input type="text" name="com_name" class="form-control" id="defaultconfig" value="<?php echo getclient('com_name', $_REQUEST['cid']); ?>" >
                                                </div>
                                            </div>
                                             <div class="col-lg-6">
                                                <div>
                                                   <label>Customer Name</label>
                                                    <input type="text" name="cus_name" class="form-control"  id="defaultconfig" value="<?php echo getclient('cus_name', $_REQUEST['cid']); ?>" >
                                                </div>
                                            </div>
                                           
                                          </div>
                                           <div class="row">
                                            <div class="col-lg-6">
                                                <div>
                                                   <label>Mobile Number</label>
                                                    <input type="text" name="mobile" class="form-control" maxlength="25"  id="defaultconfig" value="<?php echo getclient('mobile', $_REQUEST['cid']); ?>" >
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                   <label>E-mail ID</label>
                                                    <input type="emsil" name="email" class="form-control"  id="defaultconfig" value="<?php echo getclient('email', $_REQUEST['cid']); ?>" >
                                                </div>
                                            </div>
                                          </div>
                                           <div class="row">
                                            <div class="col-lg-6">
                                                <div>
                                                   <label>City</label>
                                                    <input type="text" name="address" class="form-control"  id="defaultconfig" value="<?php echo getclient('address', $_REQUEST['cid']); ?>" >
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                 <div class="form-group">
                                                    <label class="control-label">Domain</label>
                                                    <select class="form-control select2" name="domain">
                                                        <option>None</option>
                                                         <optgroup label="Type Of Proposal">
                                                            <option value="1" <?php
                                                                if (getclient('domain', $_REQUEST['cid']) == '1') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Android</option>
                                                            <option
                                                             value="2" <?php
                                                                if (getclient('domain', $_REQUEST['cid']) == '2') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Web</option>
                                                                <option
                                                             value="3" <?php
                                                                if (getclient('domain', $_REQUEST['cid']) == '3') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>SEO</option>
                                                          

                                                        </optgroup>
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
                                                            if ($_REQUEST['cid'] != '') {
                                                                echo 'UPDATE';
                                                            } else {
                                                                echo 'Submit';
                                                            }
                                                            ?>
                                                        </button>
                                                     
                                                        <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/client/client.php';" type="reset" class="btn btn-outline-secondary waves-effect">
                                                            Cancel
                                                        </button>
                                                         <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/client/client.php';" type="reset" class="btn btn-brown waves-effect" style="float:right;">
                                                            Back To List Page
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            </form>

                                        </div>
                                    </div>
                                </div> <!-- end col -->

                            </div> <!-- end row -->

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->
}



 
          

<?php include"../../require/footer.php"?>
<!-- plugin   -->

    <script src="<?php echo $sitename; ?>public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/select2/js/select2.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-maxlength/bootstrap-maxlength.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
