<?php include('require/sidebar.php');?>
<?php include('require/header.php');?>
<?php
    if (isset($_POST['submit']))

{

    $fproject   = $_POST['project'];
    $ftime  = $_POST['time'];
    $fprovider = $_POST['privoide'];
    $fprojectlink    = $_POST['link'];
    $follower       = $_POST['follow'];
    $custamer_contact      = $_POST['contact'];



     $query = "INSERT INTO  follow([fproject], [ftime], [fprovider], [fprojectlink], [follower], [custamer_contact]) VALUES ('$fproject', '$ftime', '$fprovider', '$fprojectlink', '$follower','$custamer_contact')";
    // $result =$dbo, $query;
     echo $conn;
     exit();

if(mysqli_query($conn, $query))

 {

echo "<script>alert('INSERTED SUCCESSFULLY');</script>";

}

else

 {

 echo "<script>alert('FAILED TO INSERT');</script>";

 }

 }
      





?>
<form method="post">
<div class="page-content-wrapper">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">

                                            <h4 class="mt-0 header-title">Textual inputs</h4>
                                            

                                            <div class="form-group row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label">
                                                    PROJECT
                                                </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" value="Who I Am" name="project" id="example-text-input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                            <label for="example-search-input" class="col-sm-2 col-form-label">TIME
                                            </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="time" name="time" value="How do I shoot web" id="example-search-input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="example-email-input" class="col-sm-2 col-form-label">PROVIDER</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="text" name="privoider" value="Sathyagar" id="example-email-input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="example-url-input" class="col-sm-2 col-form-label">PROJECT LINK</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="url" name="link" value="https://webtoall.com" id="example-url-input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="example-email-input" class="col-sm-2 col-form-label">
                                                    FOLLOWER
                                                </label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" name="follow" type="text" value="Roshan" id="example-email-input">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">CUSTAMER CONTACT</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="contact">
                                                        <option>Select</option>
                                                        <option>Mail</option>
                                                        <option>Call</option>
                                                    </select>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->



                  <input class="btn" type="submit" name="submit" value="add" align="right">
</form>
<style type="text/css">
    .btn{background-color: #16e60eeb;color: white;border: none;border-radius: 15px;width: 100px;}
    .btn:hover{background-color: #16e60eeb;color: white;border: none;border-radius: 15px;width: 100px;transition-duration: 1.7s;font-size: 20px;}
</style>
 <?php include('require/footer.php');?>