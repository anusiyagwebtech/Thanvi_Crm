<?php
$menu = '1,1,1';



if (isset($_REQUEST['fid'])) {
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
    $getid = $_REQUEST['fid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext = '0';
    if ($imagetitle != '') {
        $imagec = $imagetitle;
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    if ($getid != '') {
        
        // $linkimge = $db->prepare("SELECT * FROM `follow` WHERE `fid` = ? ");
        // $linkimge->execute(array($getid));
        // $linkimge1 = $linkimge->fetch();
        // $pimage = $linkimge1['image'];
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
        if ($_REQUEST['fid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') {
        $msg = addfollow($name, $process, $last, $next , $getid);
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

                                           <!--  <h4 class="mt-0 header-title">Textual inputs</h4> -->
                                            
                                             <div class="row">
                                                <div class="col-md-6">
                                               <div>
                                                   <label>Project Name</label>
                                                    <input type="text" name="name" class="form-control" maxlength="25" name="name" id="defaultconfig" value="<?php echo getfollow('name', $_REQUEST['fid']); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                             <div class="form-group">
                                                 <div class="form-group">
                                                    <label class="control-label">Status</label>
                                                    <select class="form-control select2" name="process">
                                                        <option>None</option>
                                                         <optgroup label="Type Of Proposal">
                                                            <option value="On Process" <?php
                                                                if (getfollow('process', $_REQUEST['fid']) == 'On Process') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>On Process</option>
                                                            <option
                                                             value="Completed" <?php
                                                                if (getfollow('process', $_REQUEST['fid']) == 'Completed') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Completed</option>
                                                          

                                                        </optgroup>
                                                    </select>
                                                    </div>
                                                 </div>
                                             </div>
                                         </div>
                                             <div class="row">
                                                <div class="col-md-6">
                                                    <label>Last Follow</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" placeholder="mm/dd/yyyy" name="last"  value="<?php echo getfollow('last', $_REQUEST['fid']);?>">
                                                         
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                            <div class="col-md-6">
                                           <div class="form-group">
                                                    <label>Next Follow</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" placeholder="mm/dd/yyyy"name="next" value="<?php echo getfollow('next', $_REQUEST['fid']); ?>">
                                                          
                                                        </div><!-- input-group -->
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
                                                  if ($_REQUEST['fid'] != '') {
                                                         echo 'UPDATE';
                                                       } else {
                                                           echo 'submit';
                                                    }
                                                       ?>
                                               </button>
                                                   <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/follow/follow.php';" type="reset" class="btn btn-outline-secondary waves-effect">
                                                            Cancel
                                                    </button>
                                                    <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/follow/follow.php';" type="reset" class="btn btn-brown waves-effect" style="float:right;">
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
