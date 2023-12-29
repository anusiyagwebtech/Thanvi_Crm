<?php

function getnewscategory($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `newscategory` WHERE `ncid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addnewscategory($title, $link, $image, $imagealt, $imagename, $content, $meta_title, $meta_keywords, $meta_description, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `ncid` FROM `newscategory` WHERE `image_name`=?", $imagename);
        if ($link1['ncid'] == '') {
            $link2 = FETCH_all("SELECT `ncid` FROM `newscategory` WHERE `link`=?", $link);
            if ($link2['ncid'] == '') {
                $resa = $db->prepare("INSERT INTO `newscategory`(`category`,`link`,`description`,`image_alt`,`image_name`,`image`,`order`,`status`,`meta_title`,`meta_keywords`,`meta_description`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");                   
                $resa->execute(array($title, $link, $content, $imagealt, $imagename, $image, $order, $status, $meta_title, $meta_keywords, $meta_description, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `ncid` FROM `newscategory` WHERE `image_name`=? AND `ncid`!=?", $imagename, $getid);
        if ($link1['ncid'] == '') {
            $link2 = FETCH_all("SELECT `ncid` FROM `newscategory` WHERE `link`=? AND `ncid`!=?", $link, $getid);
            if ($link2['ncid'] == '') {
                $resa = $db->prepare("UPDATE `newscategory` SET `category`=?, `link`=?,`description`=?, `image`=?,`image_alt`=?,`image_name`=?,`order`=?, `status`=?, `meta_title`=?, `meta_keywords`=?, `meta_description`=?, `ip`=?, `updated_by`=? WHERE `ncid`=?");
                $resa->execute(array(trim($title), trim($link), trim($content), trim($image), trim($imagealt), trim($imagename), trim($order), trim($status), trim($meta_title), trim($meta_keywords), trim($meta_description), trim($ip), $_SESSION['UID'], $getid));

                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    }
    return $res;
}

function delnewscategory($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `newscategory` WHERE `ncid`=?", $c);
        unlink('../../images/newscategory/' . $getc['image']);
        unlink('../../images/newscategory/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `newscategory` WHERE `ncid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getnews($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `news` WHERE `nid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addnews($title, $date, $link, $shortdescription,$image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `nid` FROM `news` WHERE `image_name`=?", $imagename);
        if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `news`(`title`,`date`, `link`, `shortdescription`,`image`,`image_alt`,`image_name`,`description`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $title, date('Y-m-d', strtotime($date)),$link, $shortdescription, $image, $imagealt, $imagename,$content,  $order, $status, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `nid` FROM `news` WHERE `image_name`=? AND `nid`=?", $imagename, $getid);
        if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `news` SET `title`=?, `date`=?, `link`=?, `shortdescription`=?,`image`=?,`image_alt`=?,`image_name`=?, `description`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `nid`=?");
                $resa->execute(array(trim($title), date('Y-m-d', strtotime(trim($date))),trim($link), trim($shortdescription), trim($image), trim($imagealt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    }
    return $res;
}

function delnews($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `news` WHERE `nid`=?", $c);
        unlink('../../images/events/' . $getc['image']);
        unlink('../../images/events/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `news` WHERE `nid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}




//lead//
function getlead($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `lead_form` WHERE `lid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];        
    return $res;
}

function addlead($client,$type, $image, $sentthrough, $sentto, $date, $proposal, $leadtype, $domain,$getid ) 
{
    //echo "string";
     // echo $getid;
     // exit;
    global $db;
    if ($getid == '') {
       // echo "insert agum";
       // echo $getid;
       // exit;
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `lead_form`(`client`,`type`,`document`,`sentthrough`,`sentto`,`date`,`proposal`,`leadtype`,
                `domain`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($client,$type, $document, $sentthrough, $sentto, $date, $proposal, $leadtype, $domain));      
                $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';                  
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } 
 else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `lead_form` SET `client`=?,`type`=?, `document`=?, `sentthrough`=?,`sentto`=?,`date`=?,`proposal`=?,`leadtype`=?,`domain`=?  WHERE `lid`=?");
                $resa->execute(array (trim($client),trim($type), trim($document), trim($sentthrough), trim($sentto),trim($date),trim($proposal),trim($leadtype),trim($domain), $getid));
                $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';                
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function dellead($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `lead_form` WHERE `lid`=?", $c);
        unlink('../../images/banner/' . $getc['image']);
        unlink('../../images/banner/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `lead_form` WHERE `lid` = ? ");
        $get->execute(array($c));
    }
    $res ='<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Deleted</h4></div>';       
    return $res;
}


//lead end//


//follow//
function getfollow($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `follow` WHERE `fid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addfollow($name, $process, $last, $next, $getid ) 
{
    // echo $document;
    // exit;
    global $db;
    if ($getid == '') {
       // echo $getid;
       // exit;
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `follow`( `name`,`process`,`last`,`next`) VALUES(?,?,?,?)");
                $resa->execute(array($name, $process, $last, $next));      
                $res ='<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';                 
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }  else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {

            $resa = $db->prepare("UPDATE `follow` SET `name`=?, `process`=?, `last`=?,`next`=?  WHERE `fid`=?");
                $resa->execute(array (trim($name), trim($process), trim($last), trim($next), $getid));
                $res ='<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';               
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

 
function delfollow($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `follow` WHERE `fid`=?", $c);
        unlink('../../images/banner/' . $getc['image']);
        unlink('../../images/banner/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `follow` WHERE `fid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Deleted</h4></div>';       
    return $res;
}


//follow end//


function getemployee($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `employee` WHERE `rid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addemployee($name, $password, $domain, $getid ) 
{
    // echo $document;
    // exit;
    global $db;
    if ($getid == '') {
       // echo $getid;
       // exit;
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `employee`( `name`,`password`,`domain`) VALUES(?,?,?)");
                $resa->execute(array($name, $password, $domain));      
                $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';                
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }  else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
              $resa = $db->prepare("UPDATE `employee` SET `name`=?, `password`=?, `domain`=?   WHERE `rid`=?");
                $resa->execute(array (trim($name), trim($password), trim($domain), $getid));
                $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';                
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

 
function delemployee($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `employee` WHERE `rid`=?", $c);
        // unlink('../../images/banner/' . $getc['image']);
        // unlink('../../images/banner/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `employee` WHERE `rid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Deleted</h4></div>';       
    return $res;
}


//follow end//


//Task//
function gettask($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `task` WHERE `tid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addtask($domain, $emp_name, $task_name, $project_name, $description, $start, $end, $priority,$getid ) 
{
    //echo "string";
     // echo $getid;
     // exit;
    global $db;
    if ($getid == '') {
       // echo "insert agum";
       // echo $getid;
       // exit;
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `task`( `domain`,`emp_name`,`task_name`,`project_name`,`description`,`start`,`end`,
                `priority`) VALUES(?,?,?,?,?,?,?,?)");
                $resa->execute(array($domain, $emp_name, $task_name, $project_name, $description, $start, $end, $priority));      
                $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } 
 else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `task` SET `domain`=?, `emp_name`=?, `task_name`=?,`project_name`=?,`description`=?,`start`=?,`end`=?,`priority`=?  WHERE `tid`=?");
                $resa->execute(array(trim($domain), trim($emp_name), trim($task_name), trim($project_name),trim($description),trim($start),trim($end),trim($priority), $getid));
                $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
   
    return $res;
}

function deltask($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `task` WHERE `tid`=?", $c);
        unlink('../../images/banner/' . $getc['image']);
        unlink('../../images/banner/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `task` WHERE `tid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Deleted</h4></div>';       
    return $res;
}
// Task end //

// client //
function getclient($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `client` WHERE `cid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addclient($cus_name, $com_name, $mobile, $email, $address, $domain,$getid ) 
{
    //echo "string";
     // echo $getid;
     // exit;
    global $db;
    if ($getid == '') {
       // echo "insert agum";
       // echo $getid;
       // exit;
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `client`( `cus_name`,`com_name`,`mobile`,`email`,`address`,`domain`) VALUES(?,?,?,?,?,?)");
                $resa->execute(array($cus_name, $com_name, $mobile, $email, $address, $domain));      
                $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } 
 else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `client` SET `cus_name`=?, `com_name`=?, `mobile`=?,`email`=?,`address`=?,`domain`=? WHERE `cid`=?");
                $resa->execute(array(trim($cus_name), trim($com_name), trim($mobile), trim($email),trim($address),trim($domain), $getid));
                $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
           // $msg = addclient($cus_name, $com_name, $mobile, $email, $address, $domain, $getid);

    return $res;
}

function delclient($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `client` WHERE `cid`=?", $c);
        unlink('../../images/banner/' . $getc['image']);
        unlink('../../images/banner/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `client` WHERE `cid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Deleted</h4></div>';       
    return $res;
}
// Client end //


//services//
function getservices1($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `services` WHERE `sid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addservices1($heading, $lable1, $lable2, $imagetitle, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `services`( `heading`,`lable1`,`lable2`,`imagetitle`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $heading, $lable1, $lable2, $imagetitle, $content, $order, $status, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `services` SET `heading`=?, `lable1`=?, `lable2`=?,`imagetitle`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `sid`=?");
                $resa->execute(array (trim($heading), trim($lable1), trim($lable2), trim($imagetitle),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delservices1($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `services` WHERE `sid`=?", $c);
        unlink('../../images/services/' . $getc['image']);
        unlink('../../images/services/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `services` WHERE `sid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

//services end//

//recent work//
function getrecent1($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `recent` WHERE `rid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addrecent1($content, $image, $imagealt, $imagetitle,$order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `recent`( `content`,`image`,`image_alt`,`image_title`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content, $image, $imagealt, $imagetitle, $order, $status, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
      
     // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `recent` SET `content`=?, `image`=?, `image_alt`=?,`image_title`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `rid`=?");
                $resa->execute(array ( trim($content), trim($image), trim($imagealt), trim($imagetitle), trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delrecent1($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `recent` WHERE `rid`=?", $c);
        unlink('../../images/recent/' . $getc['image']);
        unlink('../../images/recent/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `recent` WHERE `rid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

//recent end//

//company//
function getcompany1($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `company` WHERE `cid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addcompany1($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `company`( `content1`,`image`,`image_alt`,`image_name`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `company` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `cid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delcompany1($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `company` WHERE `cid`=?", $c);
        unlink('../../images/company/' . $getc['image']);
        unlink('../../images/company/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `company` WHERE `cid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
//company//

//renovation//
function getrenovation($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `renovation` WHERE `cid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addrenovation($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `renovation`( `content1`,`image`,`image_alt`,`image_name`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `renovation` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `cid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delrenovation($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `renovation` WHERE `cid`=?", $c);
        unlink('../../images/renovation/' . $getc['image']);
        unlink('../../images/renovation/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `renovation` WHERE `cid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
//renovation//


//testimonial//
function gettestimonial1($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `testimonial` WHERE `tid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addtestimonial1($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `testimonial`( `content1`,`image`,`image_alt`,`image_name`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `testimonial` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `tid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function deltestimonial1($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `company` WHERE `tid`=?", $c);
        unlink('../../images/testimonial/' . $getc['image']);
        unlink('../../images/testimonial/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `testimonial` WHERE `tid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
//testimonial//

//aboutus//
function getaboutus1($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `aboutus` WHERE `aid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addaboutus1($content1, $image, $imagealt, $imagename, $content,$list1,$list2,$list3, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `aboutus`( `content1`,`image`,`image_alt`,`image_name`,`content`,`list1`,`list2`,`list3`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content,$list1,$list2,$list3,$order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `aboutus` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?,`list1`=?,`list2`=?,`list3`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `aid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),trim($list1),trim($list2),trim($list3),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delaboutus1($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `aboutus` WHERE `aid`=?", $c);
        unlink('../../images/aboutus/' . $getc['image']);
        unlink('../../images/aboutus/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `aboutus` WHERE `aid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
//aboutus end//

//aboutus banner//
function getbanner2($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `about_banner` WHERE `bid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addbanner2($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `about_banner`( `content1`,`image`,`image_alt`,`image_name`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `about_banner` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `bid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delbanner2($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `about_banner` WHERE `bid`=?", $c);
        unlink('../../images/banner/' . $getc['image']);
        unlink('../../images/banner/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `about_banner` WHERE `bid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
//about us banner end//


//works banner//
function getbanner3($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `works_banner` WHERE `wid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addbanner3($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `works_banner`( `content1`,`image`,`image_alt`,`image_name`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `works_banner` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `wid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delbanner3($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `works_banner` WHERE `wid`=?", $c);
        unlink('../../images/banner/' . $getc['image']);
        unlink('../../images/banner/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `works_banner` WHERE `wid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
//works banner end//


//news banner//
function getbanner4($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `news_banner` WHERE `nid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addbanner4($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `news_banner`( `content1`,`image`,`image_alt`,`image_name`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `news_banner` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `nid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delbanner4($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `news_banner` WHERE `nid`=?", $c);
        unlink('../../images/banner/' . $getc['image']);
        unlink('../../images/banner/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `news_banner` WHERE `nid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
//news banner end//

//about testimonial//
function gettestimonial2($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `about_testimonial` WHERE `tid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addtestimonial2($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `about_testimonial`( `content1`,`image`,`image_alt`,`image_name`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `about_testimonial` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `tid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function deltestimonial2($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `company` WHERE `tid`=?", $c);
        unlink('../../images/testimonial/' . $getc['image']);
        unlink('../../images/testimonial/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `about_testimonial` WHERE `tid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
//about testimonial//




//interior//


function getinterior($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `interior` WHERE `bid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addinterior($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `interior`( `content1`,`image`,`image_alt`,`image_name`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `interior` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `bid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delinterior($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `interior` WHERE `bid`=?", $c);
        unlink('../../images/interior/' . $getc['image']);
        unlink('../../images/interior/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `interior` WHERE `bid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

//works//


function getworks($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `works` WHERE `bid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addworks($content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        // $link1 = FETCH_all("SELECT `bid` FROM `banner` WHERE `image_name`=?", $imagename);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `works`( `content1`,`image`,`image_alt`,`image_name`,`content`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $content1, $image, $imagealt, $imagename, $content, $order, $status, $ip, $_SESSION['UID']));       
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    } else {
        // $link1 = FETCH_all("SELECT `sid` FROM `services` WHERE `image_name`=? AND `sid`=?", $imagename, $getid);
        // if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `works` SET `content1`=?, `image`=?, `image_alt`=?,`image_name`=?,`content`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `bid`=?");
                $resa->execute(array (trim($content1), trim($image), trim($image_alt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        // } else {
        //     $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        // }
    }
    return $res;
}

function delworks($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `works` WHERE `bid`=?", $c);
        unlink('../../images/works/' . $getc['image']);
        unlink('../../images/works/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `works` WHERE `bid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}



function gettrain($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `training` WHERE `nid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addtrain($title, $date, $link, $shortdescription,$image, $imagealt, $imagename, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `nid` FROM `training` WHERE `image_name`=?", $imagename);
        if ($link1['image_name'] == '') {
            $resa = $db->prepare("INSERT INTO `training`(`title`,`date`, `link`, `shortdescription`,`image`,`image_alt`,`image_name`,`description`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array( $title, date('Y-m-d', strtotime($date)),$link, $shortdescription, $image, $imagealt, $imagename,$content,  $order, $status, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';           
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `nid` FROM `training` WHERE `image_name`=? AND `nid`=?", $imagename, $getid);
        if ($link1['image_name'] == '') {
            $resa = $db->prepare("UPDATE `training` SET `title`=?, `date`=?, `link`=?, `shortdescription`=?,`image`=?,`image_alt`=?,`image_name`=?, `description`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `nid`=?");
                $resa->execute(array(trim($title), date('Y-m-d', strtotime(trim($date))),trim($link), trim($shortdescription), trim($image), trim($imagealt), trim($imagename),trim($content),  trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    }
    return $res;
}

function deltrain($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `training` WHERE `nid`=?", $c);
        unlink('../../images/events/' . $getc['image']);
        unlink('../../images/events/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `training` WHERE `nid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}


function getcareers($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `careers` WHERE `cid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function gettrainer($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `train_user` WHERE `tid`=?");
    $get1->execute(array(1));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    
    return $res;
}

function addcareers($jobcode, $title,$jobtype,$location,$shortdescription,$link,$experience, $salary, $content, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `cid` FROM `careers` WHERE `jobcode`=?",$jobcode);
        if ($link1['cid'] == '') {
            $resa = $db->prepare("INSERT INTO `careers`(`jobcode`, `title`,`jobtype`,`location`,`shortdescription`,`link`,`experience`, `salary`, `description`,`order`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($jobcode, $title,$jobtype,$location,$shortdescription,$link, $experience, $salary, $content, $order, $status, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';                     
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Job Code already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `cid` FROM `careers` WHERE `jobcode`=? AND `cid`!=?", $jobcode, $getid);
        if ($link1['cid'] == '') {
            $resa = $db->prepare("UPDATE `careers` SET `jobcode`=?, `title`=?,`jobtype`=?,`location`=?,`shortdescription`=?, `link`=?,`experience`=?, `salary`=?, `description`=?, `order`=?, `status`=?, `ip`=?, `updated_by`=? WHERE `cid`=?");
                $resa->execute(array(trim($jobcode), trim($title),trim($jobtype),trim($location),trim($shortdescription),trim($link),trim($experience), trim($salary), trim($content), trim($order), trim($status), trim($ip), $_SESSION['UID'], $getid));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';         
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Job Code already exists!</h4></div>';
        }
    }
    return $res;
}

function delcareers($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `careers` WHERE `cid`=?", $c);
        unlink('../../images/careers/' . $getc['image']);
        unlink('../../images/careers/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `careers` WHERE `cid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
?>
