<?php
$menu = '1,1,1';



if (isset($_REQUEST['rid'])) {
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
    $getid = $_REQUEST['rid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext = '0';
    if ($imagetitle != '') {
        $imagec = $imagetitle;
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    if ($getid != '') {
        
        $linkimge = $db->prepare("SELECT * FROM `employee` WHERE `rid` = ? ");
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
        if ($_REQUEST['rid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') {
        $msg = addemployee($name, $password, $domain,$getid);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-cross"></i> Image Format was Invalid., Please Use JPG, PNG, GIF Format</h4></div>';
    }
}

?>
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



<form class="" action="#" method="post" enctype="multipart/form-data">
<div class="page-content-wrapper">

                        <div class="container-fluid">
                               <?php print_r($msg)?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">

                                            <h4 class="mt-0 header-title">Textual inputs</h4>
                                            
                                             <div class="row">
                                                <div class="col-md-6">
                                               <div>
                                                   <label>User Name</label>
                                                    <input type="text" name="name" class="form-control" maxlength="25"  id="defaultconfig" value="<?php echo getemployee('name', $_REQUEST['rid']); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div>
                                                   <label>Password</label>
                                                    <input type="text" name="password" class="form-control" maxlength="25"  id="defaultconfig" value="<?php echo getemployee('password', $_REQUEST['rid']); ?>">
                                                </div>
                                            <!--  <div class="form-group">
                                                 <div class="form-group">
                                                    <label class="control-label">Status</label>
                                                    <select class="form-control select2" name="process">
                                                        <option>None</option>
                                                         <optgroup label="Type Of Proposal">
                                                            <option value="On Process" <?php
                                                                if (getemployee('process', $_REQUEST['rid']) == 'On Process') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>On Process</option>
                                                            <option
                                                             value="Completed" <?php
                                                                if (getemployee('process', $_REQUEST['rid']) == 'Completed') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Completed</option>
                                                          

                                                        </optgroup>
                                                    </select>
                                                    </div>
                                                 </div> -->
                                             </div>
                                         </div>
                                           <!--   <div class="row">
                                                <div class="col-md-6">
                                                    <label>Last Follow</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="last"  value="<?php echo getfollow('last', $_REQUEST['fid']);?>">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-md-6">
                                           <div class="form-group">
                                                    <label>Next Follow</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="next" value="<?php echo getfollow('next', $_REQUEST['fid']); ?>">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                 <div class="form-group">
                                                    <label class="control-label">Domain</label>
                                                    <select class="form-control select2" name="domain">
                                                        <option>None</option>
                                                         <optgroup label="Type Of Proposal">
                                                            <option value="1" <?php
                                                                if (getemployee('domain', $_REQUEST['rid']) == '1') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Android</option>
                                                            <option
                                                             value="2" <?php
                                                                if (getemployee('domain', $_REQUEST['rid']) == '2') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Web</option>
                                                                <option
                                                             value="3" <?php
                                                                if (getemployee('domain', $_REQUEST['rid']) == '3') {
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
                                              <button type="submit" name="submit" class="btn btn-success waves-effect waves-light m-r-5"> 
                                                <?php
                                                  if ($_REQUEST['rid'] != '') {
                                                         echo 'UPDATE';
                                                       } else {
                                                           echo 'submit';
                                                    }
                                                       ?>
                                               </button>
                                                   <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/employee/employee.php';" type="reset" class="btn btn-outline-secondary waves-effect">
                                                            Cancel
                                                    </button>
                                                    <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/employee/employee.php';" type="reset" class="btn btn-brown waves-effect" style="float:right;">
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

              
                        


<!-- <style type="text/css">
    .btn{background-color: #16e60eeb;color: white;border: none;border-radius: 15px;width: 100px;}
    .btn:hover{background-color: #16e60eeb;color: white;border: none;border-radius: 15px;width: 100px;transition-duration: 1.7s;font-size: 20px;}
</style> -->

 <?php include('../../require/footer.php');?>
  
        <script src="<?php echo $fsitename; ?>public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo $fsitename; ?>public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo $fsitename; ?>public/plugins/select2/js/select2.min.js"></script>
        <script src="<?php echo $fsitename; ?>public/plugins/bootstrap-maxlength/bootstrap-maxlength.js"></script>
        <script src="<?php echo $fsitename; ?>public/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
        <script src="<?php echo $fsitename; ?>public/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
