<?php
$menu = '1,1,1';



if (isset($_REQUEST['tid'])) {
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
    $getid = $_REQUEST['tid'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $ext = '0';
    if ($imagetitle != '') {
        $imagec = $imagetitle;  
    } else {
        $imagec = time();
    }

    $imag = strtolower($_FILES["image"]["name"]);
    if ($getid != '') {
        
        $linkimge = $db->prepare("SELECT * FROM `task` WHERE `tid` = ? ");
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
        if ($_REQUEST['tid']) {
            $image = $pimage;
        } else {
            $image = '';
        }
    }
    if ($ext != '1') { 
        $msg = addtask($domain, $emp_name, $task_name, $project_name, $description, $start, $end, $priority, $getid);
    } else {
        $msg = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-cross"></i> Image Format was Invalid., Please Use JPG, PNG, GIF Format</h4></div>';
    }
}
?>

 
  <style>
      .row{
        padding-bottom:10px;
      }



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

                                            
                                             <h4 class="mt-0 header-title" style="padding:20px;">Task Management</h4>
                                   <div class="row">
                                        <div class="col-lg-6">
                                            <form class="" action="#" method="post" enctype="multipart/form-data">
                                                   <div class="form-group">
                                                    <label class="control-label">Domain</label>
                                                    <select class="form-control select2" name="domain" id="domain">
                                                        <option>Select Domain</option>
                                                       
                                                            <option value="1" 
                                                            <?php
                                                                if (gettask('domain', $_REQUEST['tid']) == '1') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Android</option>
                                                            <option
                                                             value="2" <?php
                                                                if (gettask('domain', $_REQUEST['tid']) == '2') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Web</option>
                                                            <option value="3" <?php
                                                                if (gettask('domain', $_REQUEST['tid']) == '3') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>SEO</option>

                                                        
                                                  
                                                    </select>
                                                </div>
                                            </div>


                                             <div class="col-lg-6">
                                                   <div class="form-group">
                                                    <label class="control-label">Employe Name</label>
                                                    <select  class="form-control select2" id="emp_name" name="emp_name">                          
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                            
                                            <div class="row">
                                             <div class="col-lg-6">
                                                  <div>
                                                   <label>Task Name</label>
                                                    <input type="text"  name="task_name" class="form-control" maxlength="25"  id="defaultconfig" value="<?php echo gettask('task_name', $_REQUEST['tid']); ?>" >
                                                </div>
                                            </div>

                                             <div class="col-lg-6">
                                                  <div>
                                                   <label>Project Name</label>
                                                    <input type="text"  name="project_name" class="form-control" maxlength="25" id="defaultconfig" value="<?php echo gettask('project_name', $_REQUEST['tid']); ?>" >
                                                </div>
                                            </div>
                                        </div>
                                          
                                          <div class="row">
                                             <div class="col-lg-6">
                                                 <div class="form-group">
                                                    <label> Start Date</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" placeholder="mm/dd/yyyy" size="30"  name="start" value="<?php echo gettask('start', $_REQUEST['tid']); ?>">
                                                         
                                                           <!--  <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div> -->
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="col-lg-6">
                                                 <div class="form-group">
                                                    <label>Ded End Date</label>
                                                    <div>
                                                        <div class="input-group">
                                                            <input type="date" class="form-control" placeholder="mm/dd/yyyy" size="30"  name="end" value="<?php echo gettask('end', $_REQUEST['tid']); ?>">
                                                          
                                                          <!--   <div class="input-group-append">
                                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                            </div> -->
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                
                                           <div class="row" >     
                                           
                                              <div class="col-lg-6">
                                                <label class="control-label"  >Project Description</label>
                                                <p class="text-muted m-b-15 font-14">
                                                    Hints about the task and important Corrections
                                                </p>
                                                <!-- <textarea class="form-control" rows="3" maxlength="225"><?php echo gettask('description', $_REQUEST['tid']); ?></textarea> -->
                                                <textarea class="form-control" name="description"></textarea>
                                            </div>
                                       

                                    <div class="col-lg-6">
                                        <div class="card-body">

                                            <h4 class="mt-0 header-title">Task Priority*</h4>
                                             <p class="text-muted m-b-15 font-14">
                                                    Please Select Any One Of The Priority Shown Below
                                                </p>
                                            

                                            <div class="row" style="padding-top:20px;">
                                               
                                                <h4 class="mt-0 header-title" style="padding-left:20px;padding-right:7px;">Critical</h4>
                                                <input type="radio" id="switch4" switch="danger" name="priority" value="Critical"
                                                            <?php
                                                                if (gettask('priority', $_REQUEST['tid']) == 'Critical') {
                                                                    echo 'checked';
                                                                }
                                                                ?>>
                                                <label for="switch4" data-on-label="Yes"
                                                       data-off-label="No"></label>
                                                   
                                            
                                                     <h4 class="mt-0 header-title"style="padding-left:30px;padding-right:7px;">Medium</h4>
                                                <input type="radio" id="switch5" switch="warning" name="priority" value="Medium"  
                                                           <?php
                                                                if (gettask('priority', $_REQUEST['tid']) == 'Medium') {
                                                                    echo 'checked';
                                                                }
                                                                ?>>
                                                <label for="switch5" data-on-label="Yes"
                                                       data-off-label="No"></label>
                                                        
                                                   
                                                     <h4 class="mt-0 header-title"style="padding-left:30px;padding-right:7px;">Low</h4>
                                                <input type="radio" id="switch8" switch="success" name="priority" value="Low"  
                                                           <?php
                                                                if (gettask('priority', $_REQUEST['tid']) == 'Low') {
                                                                    echo 'checked';
                                                                }
                                                                ?>>
                                                <label for="switch8" 
                                                      data-on-label="Yes" data-off-label="No"></label>
                                                        
                                                </div>       
                                            </div>
                                         </div>
                                     </div>
                                      

                                           
                                             <div class="row" style="padding-top:20px;">
                                                  <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div>
                                                        <button type="submit" name="submit" id="submit" class="btn btn-success waves-effect waves-light m-r-5"><?php
                                                            if ($_REQUEST['tid'] != '') {
                                                                echo 'UPDATE';
                                                            } else {
                                                                echo 'Submit';
                                                            }
                                                            ?>
                                                        </button>
                                                     
                                                        <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/task/task.php';" type="reset" class="btn btn-outline-secondary waves-effect">
                                                            Cancel
                                                        </button>
                                                         <button  onclick="window.location.href = '<?php echo $sitename; ?>pages/task/task.php';" type="reset" class="btn btn-brown waves-effect" style="float:right;">
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



 
          

<?php include"../../require/footer.php"?>
<!-- plugin   -->

    <script src="<?php echo $sitename; ?>public/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/select2/js/select2.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-maxlength/bootstrap-maxlength.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js"></script>
        <script src="<?php echo $sitename; ?>public/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
 <!-- Subcategory -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('#domain').on("change",function () {
         var domain = $(this).find('option:selected').val();
         $.ajax({
            url: "<?php echo $sitename; ?>pages/task/ajax.php",
            type: "POST",
            data: "domain="+domain,
            success: function (response) {
                console.log(response);

                 $("#emp_name").html(response);
            },
        });
    }); 

});

</script>
<script>
  $( function() {
    $( "#datepicker-autoclose" ).datepicker();
    $( "#anim" ).on( "change", function() {
      $( "#datepicker-autoclose" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
  </script>