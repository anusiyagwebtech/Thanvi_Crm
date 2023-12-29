<?php
//exit;
    require (dirname(dirname(__FILE__)).'/config/config.inc.php');
if($_SESSION['UID']==''){
 header("location: " . $sitename);
}
?>
<!DOCTYPE html>
<html lang="en">


<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title></title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="public/assets/images/favicon.ico">

<!-- C3 charts css -->
<link href="public/plugins/c3/c3.min.css" rel="stylesheet" type="text/css" />


<!-- App css -->
<link href="<?php echo $sitename; ?>public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $sitename; ?>public/assets/css/icons.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $sitename; ?>public/assets/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body class="fixed-left">

       <!--  <div id="preloader"><div id="status"><div class="spinner"></div></div></div> -->
        <!-- Begin page -->
        <div id="wrapper">

           <!-- ========== Left Sidebar Start ========== -->
   <div class="left side-menu">

<!-- LOGO -->
<div class="topbar-left">
    <div class="">
        <!--<a href="index.php" class="logo text-center">Admiria</a>-->
        <a href="<?php echo $sitename; ?>index.php" class="logo"><img src="<?php echo $sitename; ?>public/assets/images/logo1.png" height="50" alt="logo"></a>
    </div>
</div>

<div class="sidebar-inner slimscrollleft">
    <div id="sidebar-menu">
        <ul>
            <li class="menu-title">Main</li>

             <li>
                <a href=" <?php echo $sitename; ?>index.php" class="waves-effect"><i class="mdi mdi-cube-outline"></i><span> Dashboard </span></a>
            </li>

         <!--    <li>
                <a href="widgets.html" class="waves-effect"><i class="mdi mdi-cube-outline"></i><span> Widgets </span></a>
            </li> -->
<li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class=" mdi mdi-incognito"></i><span> Client Management <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $sitename; ?>pages/client/client.php">Client</a></li>
                   
                </ul>
            </li>
            <li class="has_sub " >
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-buffer"></i><span> Lead <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li  id="li_1"><a href="<?php echo $sitename; ?>pages/lead/addlead.php">Lead</a></li>
                    <li id="li_2"><a href="home/banner/banner.htm">Email Read</a></li>
                    <li id="li_3"><a href="home/banner/banner.htm">Email Compose</a></li>
                </ul>
            </li>
             <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class=" fa fa-hand-o-right"></i><span> Follow <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $sitename; ?>pages/follow/follow_details.php">Follow</a></li>
                   
                </ul>
            </li>
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-settings-variant"></i><span> Employee <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $sitename; ?>pages/employee/employee.php">Employee Management</a></li>
                   
                </ul>
            </li>
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-clipboard-outline"></i><span> Task Management <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $sitename; ?>pages/task/task.php">Task</a></li>
                   
                </ul>
            </li>
             
            <li>
                <a href="<?php echo $sitename; ?>calendar.php" class="waves-effect"><i class="mdi mdi-calendar-check"></i><span> Calendar </span></a>
            </li>

          <!--   <li class="menu-title">Components</li>

            <li class="has_sub">
                <a href="<?php echo $sitename; ?>javascript:void(0);" class="waves-effect"><i class="mdi mdi-buffer"></i> <span> User Interface <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span> </a>
                <ul class="list-unstyled">
                    <li><a href="ui-buttons.html">Buttons</a></li>
                    <li><a href="ui-colors.html">Colors</a></li>
                    <li><a href="ui-cards.html">Cards</a></li>
                    <li><a href="ui-tabs-accordions.html">Tabs &amp; Accordions</a></li>
                    <li><a href="ui-modals.html">Modals</a></li>
                    <li><a href="ui-images.html">Images</a></li>
                    <li><a href="ui-alerts.html">Alerts</a></li>
                    <li><a href="ui-progressbars.html">Progress Bars</a></li>
                    <li><a href="ui-dropdowns.html">Dropdowns</a></li>
                    <li><a href="ui-lightbox.html">Lightbox</a></li>
                    <li><a href="ui-navs.html">Navs</a></li>
                    <li><a href="ui-pagination.html">Pagination</a></li>
                    <li><a href="ui-popover-tooltips.html">Popover & Tooltips</a></li>
                    <li><a href="ui-badge.html">Badge</a></li>
                    <li><a href="ui-carousel.html">Carousel</a></li>
                    <li><a href="ui-video.html">Video</a></li>
                    <li><a href="ui-typography.html">Typography</a></li>
                    <li><a href="ui-sweet-alert.html">Sweet-Alert</a></li>
                    <li><a href="ui-grid.html">Grid</a></li>
                    <li><a href="ui-animation.html">Animation</a></li>
                    <li><a href="ui-highlight.html">Highlight</a></li>
                    <li><a href="ui-rating.html">Rating</a></li>
                    <li><a href="ui-nestable.html">Nestable</a></li>
                    <li><a href="ui-alertify.html">Alertify</a></li>
                    <li><a href="ui-rangeslider.html">Range Slider</a></li>
                    <li><a href="ui-sessiontimeout.html">Session Timeout</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-clipboard-outline"></i><span> Forms <span class="badge badge-pill badge-success pull-right">9</span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="form-elements.html">Form Elements</a></li>
                    <li><a href="form-validation.html">Form Validation</a></li>
                    <li><a href="../../form-advanced.php">Form Advanced</a></li>
                    <li><a href="form-wizard.html">Form Wizard</a></li>
                    <li><a href="form-editors.html">Form Editors</a></li>
                    <li><a href="form-uploads.html">Form File Upload</a></li>
                    <li><a href="form-mask.html">Form Mask</a></li>
                    <li><a href="form-summernote.html">Summernote</a></li>
                    <li><a href="form-xeditable.html">Form Xeditable</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-chart-line"></i><span> Charts <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="charts-morris.html">Morris Chart</a></li>
                    <li><a href="charts-chartist.html">Chartist Chart</a></li>
                    <li><a href="charts-chartjs.html">Chartjs Chart</a></li>
                    <li><a href="charts-flot.html">Flot Chart</a></li>
                    <li><a href="charts-c3.html">C3 Chart</a></li>
                    <li><a href="charts-sparkline.html">Sparkline Chart</a></li>
                    <li><a href="charts-other.html">Jquery Knob Chart</a></li>
                    <li><a href="charts-peity.html">Peity Chart</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-bulleted-type"></i><span> Tables <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="tables-basic.html">Basic Tables</a></li>
                    <li><a href="tables-datatable.html">Data Table</a></li>
                    <li><a href="tables-responsive.html">Responsive Table</a></li>
                    <li><a href="tables-editable.html">Editable Table</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-album"></i> <span> Icons  <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span></span> </a>
                <ul class="list-unstyled">
                    <li><a href="icons-material.html">Material Design</a></li>
                    <li><a href="icons-ion.html">Ion Icons</a></li>
                    <li><a href="icons-fontawesome.html">Font Awesome</a></li>
                    <li><a href="icons-themify.html">Themify Icons</a></li>
                    <li><a href="icons-dripicons.html">Dripicons</a></li>
                    <li><a href="icons-typicons.html">Typicons Icons</a></li>
                    <li><a href="icons-weather.html">Weather Icons</a></li>
                    <li><a href="icons-mobirise.html">Mobirise Icons</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-google-maps"></i><span> Maps <span class="badge badge-pill badge-danger pull-right">2</span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="maps-google.html"> Google Map</a></li>
                    <li><a href="maps-vector.html"> Vector Map</a></li>
                </ul>
            </li>

            <li class="menu-title">Extras</li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-location"></i><span> Authentication <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="pages-login.html">Login</a></li>
                    <li><a href="pages-register.html">Register</a></li>
                    <li><a href="pages-recoverpw.html">Recover Password</a></li>
                    <li><a href="pages-lock-screen.html">Lock Screen</a></li>
                    <li><a href="pages-login-2.html">Login 2</a></li>
                    <li><a href="pages-register-2.html">Register 2</a></li>
                    <li><a href="pages-recoverpw-2.html">Recover Password 2</a></li>
                    <li><a href="pages-lock-screen-2.html">Lock Screen 2</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-google-pages"></i><span> Extra Pages <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="pages-timeline.html">Timeline</a></li>
                    <li><a href="pages-invoice.html">Invoice</a></li>
                    <li><a href="pages-directory.html">Directory</a></li>
                    <li><a href="pages-blank.html">Blank Page</a></li>
                    <li><a href="pages-404.html">Error 404</a></li>
                    <li><a href="pages-500.html">Error 500</a></li>
                    <li><a href="pages-pricing.html">Pricing</a></li>
                    <li><a href="pages-gallery.html">Gallery</a></li>
                    <li><a href="pages-maintenance.html">Maintenance</a></li>
                    <li><a href="pages-coming-soon.html">Coming Soon</a></li>
                </ul>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-cart-outline"></i><span> Ecommerce <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="ecommerce-product-list.html">Product List</a></li>
                    <li><a href="ecommerce-product-grid.html">Product Grid</a></li>
                    <li><a href="ecommerce-order-history.html">Order History</a></li>
                    <li><a href="ecommerce-customers.html">Customers</a></li>
                    <li><a href="ecommerce-product-edit.html">Product Edit</a></li>
                </ul>
            </li>

            <li>
                <a href="frontend/index.html" class="waves-effect" target="_blank"><i class="mdi mdi-airplane"></i><span> Front End </span></a>
            </li>

            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-flask-outline"></i><span> Email Templates <span class="pull-right"><i class="mdi mdi-chevron-right"></i></span> </span></a>
                <ul class="list-unstyled">
                    <li><a href="email-templates-basic.html">Basic Action Email</a></li>
                    <li><a href="email-templates-alert.html">Alert Email</a></li>
                    <li><a href="email-templates-billing.html">Billing Email</a></li>
                </ul>
            </li>

            <li class="menu-title">Help & Support</li>

            <li>
                <a href="faq.html" class="waves-effect"><i class="mdi mdi-help-circle"></i><span> FAQ </span></a>
            </li>

            <li>
                <a href="contact.html" class="waves-effect"><i class="mdi mdi-headset"></i><span> Contact <span class="badge badge-pill badge-warning pull-right">3</span> </span></a>
            </li>

            <li>
                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-file-document-box"></i><span> Documentation </span></a>
            </li> -->

        </ul>
    </div>
    <div class="clearfix"></div>
</div> <!-- end sidebarinner -->
</div>
<!-- Left Sidebar End -->