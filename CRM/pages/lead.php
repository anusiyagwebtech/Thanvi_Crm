<?php
$menu = '2,1,1';



if (isset($_REQUEST['lid'])) {
    $thispageeditid = 1;
} else {
    $thispageid = 2;
}
// include ('../../../config/config.inc.php');
$dynamic = '1';
// include ('../../../require/header.php');
include ('require/sidebar.php');
include ('require/header.php');
include ('config/config.inc.php');

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
        
        $linkimge = $db->prepare("SELECT * FROM `lead` WHERE `lid` = ? ");
        $linkimge->execute(array($getid));
        $linkimge1 = $linkimge->fetch();
        $pimage = $linkimge1['image'];
    }
    if ($imag) {
        if ($pimage != '') {            
            unlink("../../../images/banner/" . $pimage);
            unlink("../../../images/banner/thump/" . $pimage);
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
        if (($extension == 'jpg') || ($extension == 'png') || ($extension == 'gif')) {
            $m = strtolower($imagec);
            $imagev = $m . "." . $extension;
            $thumppath = "../../../images/banner/";
            $thumppath1 = "../../../images/banner/thump/";
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
        $msg = addlead($type, $document, $sentthrough, $sentto, $date, $status, $leadtype, $domain, $getid);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-cross"></i> Image Format was Invalid., Please Use JPG, PNG, GIF Format</h4></div>';
    }
}
?>


                    <!-- ==================
                         PAGE CONTENT START
                         ================== -->

                    <div class="page-content-wrapper">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">

                                            <h4 class="mt-0 header-title">Validation type</h4>
                                            <p class="text-muted m-b-30 font-14"></p>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <form class="" action="#" method="post" enctype="multipart/form-data">
                                                   <div class="form-group">
                                                    <label class="control-label">Type Of Proposal</label>
                                                    <select class="form-control select2" name="type">
                                                        <option>Mail / Call / Message</option>
                                                        <optgroup label="Type Of Proposal">
                                                            <option>Call</option>
                                                            <option>Mail</option>
                                                            <option>Message</option>

                                                        </optgroup>
                                                  
                                                    </select>
                                                </div>
                                            </div>
                                              <div class="col-lg-6">
                                                  <div class="form-group">
                                                    <label>Default file input</label>
                                                    <input type="file" name="document"class="filestyle" data-buttonname="btn-secondary">
                                                </div>
   
                                            </div>
                                          </div>

                                            <div class="row">
                                                 <div class="col-lg-6">
                                                     <div class="form-group">
                                                    <label class="control-label">Proposal Sent Through</label>
                                                    <select class="form-control select2" name="sentthrough">
                                                        <option>Mail / Call / Message</option>
                                                        <optgroup label="Type Of Proposal">
                                                            <option>Call</option>
                                                            <option>Mail</option>
                                                            <option>Message</option>

                                                        </optgroup>
                                                  
                                                    </select>
                                                </div>
                                            </div>
                                              <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Proposal Sent Date</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose" name="date">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div>
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                             <div class="row">
                                               <div class="col-lg-6">
                                                 <div>
                                                   <label>Proposal Status</label>
                                                    <input type="text"  name="status"class="form-control" maxlength="25" name="defaultconfig" id="defaultconfig" />
                                                </div>
                                            </div>
                                                <div class="col-lg-6">
                                                 <div>
                                                   <label>Lead Type</label>
                                                    <input type="text" name="leadtype" class="form-control" maxlength="25" name="defaultconfig" id="defaultconfig" />
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row">
                                                 <div class="col-lg-6">
                                                     <div class="form-group">
                                                    <label class="control-label">Domain</label>
                                                    <select class="form-control select2" name="domain">
                                                        <option>Android / Web / SEO </option>
                                                        <optgroup label="Type Of Proposal">
                                                            <option>Call</option>
                                                            <option>Mail</option>
                                                            <option>Message</option>

                                                        </optgroup>
                                                  
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                           
                                             <div class="row">
                                                  <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div>
                                                        <button type="submit" name="submit" class="btn btn-pink waves-effect waves-light m-r-5"> 
                                                             <?php
                                                            if ($_REQUEST['1id'] != '') {
                                                                  echo 'UPDATE';
                                                              } else {
                                                                  echo 'submit';
                                                              }
                                                              ?>
                                                        </button>
                                                        <button type="reset" class="btn btn-secondary waves-effect">
                                                            Cancel
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



 
          

<?php include"require/footer.php"?>
<!-- plugin   -->
<script src="public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="public/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
<script src="public/assets/pages/form-advanced.js"></script>
