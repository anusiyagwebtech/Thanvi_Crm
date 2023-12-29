<?php
    include("../config/config.inc.php");
   
   // session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = $_POST['username'];
      $mypassword = $_POST['password']; 
      $password = md5($mypassword);
  


    $stmt = $db->prepare( "SELECT id FROM user WHERE val1 = '$myusername' and val2  = '$password'");
            $stmt->execute(array());
            $ress = $stmt->fetch(PDO::FETCH_ASSOC);
            
      
      // If result matched $myusername and $mypassword, table row must be 1 row
        
        //  echo 'testing';
        // exit;
      // print_r($row);
      // exit;
      if($ress['id'] != '') {

       
           $_SESSION['UID'] = $ress['id'];
         header("location: index.php");
      }else {
         
        $error=true;
        
         // $error = "Your Login Name or Password is invalid";
         
      }
   }
?>

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="public/assets/images/favicon.ico">



<!-- App css -->
<link href="<?php echo $sitename; ?>public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $sitename; ?>public/assets/css/icons.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $sitename; ?>public/assets/css/style.css" rel="stylesheet" type="text/css" />
</head>
<style>
* {
  box-sizing: border-box;
}



#myVideo {
  position: fixed;
  right: 0;
  bottom: 0;
  min-width: 100%; 
  min-height: 100%;
}

.content {
  position: fixed;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  width: 100%;
  padding: 20px;
}
h4{
    color:white;
}
p{
    color: white;
}
label{
    color: white;
}

</style>
    <body class="fixed-left" >

        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
        <!-- Begin page -->
        <!-- <div class="accountbg"></div> -->
        <video autoplay muted loop id="myVideo">
  <source src="public/assets/images/background.mp4" type="video/mp4">
  Your browser does not support HTML5 video.
</video>
      <!--   <video autoplay loop muted>
            <source src="public/assets/images/background.mp4"> -->
              
       <div class="content">
        <div class="wrapper-page" style="margin: 4.0% auto;">

            <div class="card " style="background-color: #3836362e;">
                <div class="card-body " style="padding: 1.0rem;" >

                    <h3 class="text-center m-0">
                        <a href="index.html" class="logo logo-admin"><img src="public/assets/images/logo.png" style="margin:5px;" height="70" alt="logo"></a>
                    </h3>

                    <div class="p-3">
                        <h4 class="font-18 m-b-5 text-center">Welcome Back !</h4>
                        <p class="text-muted text-center">Sign in to continue to Thanvi Technologies</p>
                        <!-- <?php echo '$incorrect;'?> -->
                        <?php if($error){ ?>
                        <div class="error" style="text-align:center;color:red;margin:20px;"> *Username (Or) Password Incorrect</div>
                        <?php } ?>

                        <form  action="" method="post" autocomplete="off" id="login-box">

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type = "text" name = "username"  class="form-control" required="required" id="uname" placeholder="Username" pattern="[a-zA-Z0-9.@-]{0,55}" title="Username" maxlength="55" >
                            </div>

                            <div class="form-group">
                                <label for="userpassword">Password</label>
                                <input  type = "password" name = "password"class="form-control" placeholder="Password"  minlength='6' maxlength="55" id="pwd" title="Password" required="required"  />
                            </div>

                            <div class="form-group row m-t-20">
                              <!--   <div class="col-sm-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customControlInline">
                                        <label class="custom-control-label" for="customControlInline">Remember me</label>
                                    </div>
                                </div> -->
                                <div class="col-sm-12 text-center">
                                    <button type = "submit" class="btn btn-primary w-md waves-effect waves-light" name="logsubmit" id="logsubmit">Log In</button>
                                </div>
                            </div>

                           <!--  <div class="form-group m-t-10 mb-0 row">
                                <div class="col-12 m-t-20">
                                    <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                </div>
                            </div> -->
                        </form>
                    </div>

                </div>
            </div>
        </div>

            <div class="m-t-40 text-center">
                <!-- <p class="text-white">Don't have an account ? <a href="pages-register.html" class="font-500 font-14 text-white font-secondary"> Signup Now </a> </p> -->
                <p class="text-white">© <?php echo date('Y'); ?>  <a style="color:white;" href="">Thanvi Technologies.</a></p>
            </div>

        </div>
    </div>
    

        
        <script src="<?php echo $sitename; ?>public/assets/js/jquery.min.js"></script>
        <script src="<?php echo $sitename; ?>public/assets/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo $sitename; ?>public/assets/js/modernizr.min.js"></script>
        <script src="<?php echo $sitename; ?>public/assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo $sitename; ?>public/assets/js/waves.js"></script>
        <script src="<?php echo $sitename; ?>public/assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo $sitename; ?>public/assets/js/jquery.scrollTo.min.js"></script>

        <!-- App js -->
        <script src="public/assets/js/app.js"></script>
           <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    

    </body>

<!-- Mirrored from admiria-v.php.themesbrand.com/pages-login.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Feb 2020 05:28:48 GMT -->
</html>