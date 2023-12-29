<?php

function LoginCheck($a = '', $b = '') {
      
    global $db;
    if (($a == '') || ($b == '')) {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i>Email or Password was empty</div>';
    } else {

        //if ($e == '') {
            $stmt = $db->prepare( "SELECT id FROM user WHERE val1 = '$a' and val2  = '$b'");
            $stmt->execute(array());
            $ress = $stmt->fetch(PDO::FETCH_ASSOC);
            print_r($b);
            exit;
            if ($ress['id'] != '') {  
             
                if ($ress['val2'] == md5($b)) {
                    $res = "Hurray! You will redirect into dashboard soon";
                    $_SESSION['UID'] = $ress['id'];
                    $_SESSION['type'] = 'admin';
                    @extract($ress);
                    $res =1;
               
                } else {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i> Email or Password was incorrect</div>';
                }
            } 
            return $res;
       // }
    }
}

function logout() {
    global $db;
    $sql = $db->prepare("UPDATE `admin_history` SET `checkouttime`='" . date('Y-m-d H:i:s') . "' WHERE `id`=?");
    $sql->execute(array($_SESSION['admhistoryid']));
    // DB("UPDATE `admin_history` SET `checkouttime`='" . date('Y-m-d H:i:s') . "' WHERE `id`='" . $_SESSION['admhistoryid'] . "'");
}

function LoginCheck1($a = '', $b = '', $c = '', $d = '', $e = '', $tname = '', $mail = '') {

    global $db;
    if (($a == '') || ($b == '')) {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i>Email or Password was empty</div>';
    } else {
        if ($e == '') {
            $stmt = $db->prepare("SELECT * FROM `train_user` WHERE `login_id`=?");
            $stmt->execute(array($a));
            $ress = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($ress['tid'] != '') {
                if ($ress['password'] == $b) {
                    $res = "Hurray! You will redirect into dashboard soon";
                    $_SESSION['UID'] = $ress['tid'];
                    $_SESSION['type'] = 'admin';
                    @extract($ress);
                    if ($tid != '') {
                        date_default_timezone_set("Asia/Kolkata");
                        $e = date('F j, Y, g:i a');
                        $sql = 'INSERT INTO `train_user`(name, email, ip, check_in) VALUES (?,?,?,?)';
                        $stmt1 = $db->prepare($sql);
                        $stmt1->execute(array($tname, $mail, $c, $e));
                        $_SESSION['admhistoryid'] = $db->lastInsertId();
                        if ($d == '1') {
                            //if rememberme checkbox checked
                            setcookie('lemail', $a, time() + (60 * 60 * 24 * 10)); //Means 10 days change value of 10 to how many days as you want to remember the user details on user's computer
                            setcookie('lpass', $b, time() + (60 * 60 * 24 * 10));  //Here two coockies created with username and password as cookie names, $username,$password (login crediantials) as corresponding values
                        }
                    }
                } elseif ($ress['val3'] == '2') {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i> Your Account was deactivated by Admin</div>';
                } else {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i> Email or Password was incorrect</div>';
                }
            } else {

                $stmt2 = $db->prepare("SELECT * FROM `usermaster` WHERE `username`=?");
                $stmt2->execute(array($a));
                $sql = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($sql['uid'] != '') {

                    $stmt3 = $db->prepare("SELECT * FROM `permission` WHERE `pid`=?");
                    $stmt3->execute(array($sql['permissiongroup']));
                    $per = $stmt3->fetch(PDO::FETCH_ASSOC);
                    if ($per['status'] == '1') {
                        if (($a == $sql['username']) && ($b == $sql['password'])) {

                            $_SESSION['UID'] = $sql['uid'];
                            $_SESSION['UIDD'] = $sql['userid'];
                            $_SESSION['permissionid'] = $sql['permissiongroup'];
                            $res = "User";
                        }
                    } else {
                        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i>Access denied !</div>';
                    }
                } else {
                    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><i class="icon fa fa-close"></i> Invalid login details!</div>';
                }
            }
            return $res;
        }
    }
}

function logout1() {
    global $db;
    date_default_timezone_set("Asia/Kolkata");
    // $sql = $db->prepare("UPDATE `admin_history` SET `checkouttime`='" . date('Y-m-d H:i:s') . "' WHERE `id`=?");
    // $sql->execute(array($_SESSION['admhistoryid']));
    // DB("UPDATE `admin_history` SET `checkouttime`='" . date('Y-m-d H:i:s') . "' WHERE `id`='" . $_SESSION['admhistoryid'] . "'");
}
function companylogin($a) {
    /* $getlogo = mysql_fetch_array(mysql_query("SELECT * FROM `profile_area` WHERE `pid`='" . $_SESSION['UID'] . "'"));
      $res = $getlogo[$a];
      return $res; */
    /* global $db;
      $get1 =$db->prepare("SELECT * FROM `profile_area` WHERE `pid`=?");
      $get1->execute(array($_SESSION['UID']));
      $get=$get1->fetch(PDO::FETCH_ASSOC);
      $res = $get[$a];
      return $res; */
}


function companylogos($a) {
    //$getlogo = mysql_fetch_array(mysql_query("SELECT `image` FROM `profile_area` WHERE `pid`='" . $a . "'"));
    global $db;
    $getlogo1 = $db->prepare("SELECT `image` FROM `profile_area` WHERE `pid`=?");
    $getlogo1->execute(array($a));
    $getlogo = $getlogo1->fetch(PDO::FETCH_ASSOC);
    if ($getlogo['image'] != '') {
        $res = $getlogo['image'];
    } else {
        $res = $sitename . 'data/profile/logo.png';
    }
    return $res;
}

//sendgrid//
function getcontact1($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `contact_form` WHERE `coid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addcontact1($firstname, $emailid, $phoneno, $subject) {
    global $db;
    global $fsitename;
    $resa = $db->prepare("INSERT INTO `contact_form` (`firstname`,`emailid`,`phoneno`,`subject`) VALUES(?,?,?,?)");
    $resa->execute(array($firstname, $emailid, $phoneno, $subject));

    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
    $companyname = $general['Company_name'];

    $sendgrid = FETCH_all("SELECT * FROM `sendgrid` WHERE `sgid` = ?", '1');
    // $to = $sendgrid['s_email'];
//     $subject = "New User Contact - $companyname";

//     $message = '<div style="background-color:#efefef;  -webkit-font-smoothing:antialiased; -webkit-text-size-adjust:none; width: 100%!important;height: 100%;">
//     <table  height="100%" style="width: 100%;table-layout: fixed;">
//      <tbody style="margin: 0 auto;display: table;">
//         <tr>
//             <td style="max-width: 600px!important; margin: 0 auto!important; clear: both!important;" >
//                 <div style="padding: 15px;max-width: 600px;margin: 0 auto; display: block;">
//                     <table style="width: 100%;">
//                         <tr>
//                             <td><a href="' . $fsitename . '"> <img src=" ' . $fsitename . '/favicon.ico" style="float: left;" height="50px" border="0" /></a></td>
//                             <td style="float:right;"></td>
//                         </tr>
//                     </table>
//                 </div>
//             </td>
//           </tr>
//            <tr>
//             <td  style="clear: both!important;width:100%;">
//                 <div style="background:#6466AE;width: 100%;height: 35px;color: #fff; text-align:center; font-size: 20px; padding-top: 10px ">New User Request - Contact</div>
//             </td>
//             </tr>
//            <tr>
//             <td bgcolor="#FFFFFF" style="max-width: 600px!important;margin: 0 auto!important;clear: both!important;">
//                 <div style="padding: 15px;max-width: 600px;margin: 0 auto;display: block;">
//                     <table width="100%" height="100%" style="background:#FFFFF;">
//                         <tr>
//                             <td align="center" valign="middle">
//                                 <table width="571" border="0" cellspacing="0" cellpadding="0" style=" font-family:sans-serif; font-size:14px;font-weight: normal;  ">
//                                     <tr>
//                                         <td colspan="3" style="padding: 8px;margin-bottom: 10px;   line-height: 1.6;"> Name: </td>
//                                         <td style="padding: 8px;" colspan="2">' . $name . '</td>
//                                     </tr>
//                                     <tr>
//                                          <td colspan="3" style="padding: 8px;margin-bottom: 10px; line-height: 1.6;">Phone Number :</td>
//                                          <td style="padding: 8px;" colspan="2">' . $phone . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td colspan="3" style="padding: 8px;margin-bottom: 10px;line-height: 1.6;">Email :</td>
//                                         <td style="padding: 8px;" colspan="2">' . $email . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td colspan="3" style="padding: 8px;margin-bottom: 10px;line-height: 1.6;">Subject :</td>
//                                         <td style="padding: 8px;" colspan="2">' . $comments . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td colspan="3" style="padding: 8px;margin-bottom: 10px;line-height: 1.6;">Message :</td>
//                                         <td style="padding: 8px;" colspan="2">' . $content . '</td>
//                                     </tr>
//                                     <tr>
//                                         <td>
//                                             <p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;">Regards,</p>
//                                             <p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;"> ' . $name . '</p><br/>
//                                             <p style="margin-bottom: 10px; font-weight: normal; padding-right: 10px; font-size: 14px; line-height: 1.6;"></p>
//                                         </td>
//                                     </tr>
//                                     <tr>
//                                     </tr>
//                                 </table>
//                             </td>
//                         </tr>
//                     </table>
//                 </div><!-- /content -->
//             </td>
//             </tr>
//            <tr>
//             <td  bgcolor="#efefef" style=";max-width: 600px!important;margin: 0 auto!important;clear: both!important;">
//                 <table style="width:100%">
//                     <tr>
//                         <td style="padding:5px;font-size: 14px; text-align: left;"  height="26"  colspan="3" valign="middle"  style="font-family:Arial, Gadget, sans-serif; font-size:10px; color:#000; align:center; font-weight:normal;">Copyrights &copy; ' . date('Y') . '  ' . $companyname . ' All Rights Reserved.&nbsp;</td>
//                     </tr>
//                 </table>
//             </td>
//         </tr>
//         </tbody>
//     </table>
// </div>';
// echo $to, $message, $subject, $email;
// exit;
//     sendgridmail($to, $message, $subject, $email, '', '');

//     $subject1 = "Thanks for Contact with $companyname";

//     $message1 = '<div style="background-color:#efefef;  -webkit-font-smoothing:antialiased; -webkit-text-size-adjust:none; width: 100%!important;height: 100%;">
//     <table  height="100%" style="width: 100%;table-layout: fixed;">
//      <tbody style="margin: 0 auto;display: table;">
//         <tr>
//             <td style="max-width: 600px!important; margin: 0 auto!important; clear: both!important;" >
//                 <div style="padding: 15px;max-width: 600px;margin: 0 auto; display: block;">
//                     <table style="width: 100%;">
//                         <tr>
//                             <td><a href="' . $fsitename . '"> <img src=" ' . $fsitename . '/favicon.ico" style="float: left;" height="50px" border="0" /></a></td>
//                             <td style="float:right;"></td>
//                         </tr>
//                     </table>
//                 </div>
//             </td>
//           </tr>
//            <tr>   
//             <td  style="clear: both!important;width:100%;">
//                 <div style="background:#6466AE;width: 100%;height: 35px;color: #fff; text-align:center; font-size: 20px; padding-top: 10px ">Thanks for Register</div>
//             </td>
//             </tr>
//            <tr>
//             <td bgcolor="#FFFFFF" style="max-width: 600px!important;margin: 0 auto!important;clear: both!important;">
//                 <div style="padding: 15px;max-width: 600px;margin: 0 auto;display: block;">
//                     <table width="100%" height="100%" style="background:#FFFFF;">
//                         <tr>
//                             <td align="center" valign="middle">
//                                 <table width="571" border="0" cellspacing="0" cellpadding="0" style=" font-family:sans-serif; font-size:14px;font-weight: normal;  ">
//                                     <tr>
//                                         <td style="padding: 8px;margin-bottom: 10px;   line-height: 1.6;">Hi ' . $name . ', we are happy to join you in Ariser  Engineering Pvt Ltd. </td>
                                        
//                                     </tr>                                  
                                                       
//                                     <tr>                                       
//                                         <td>                                              
//                                             <p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;">Regards,</p>
//                                             <p style="margin-bottom: 10px; font-weight: normal;   font-size: 14px; line-height: 1.6;"> ' . $companyname . '</p><br/>
//                                             <p style="margin-bottom: 10px; font-weight: normal; padding-right: 10px; font-size: 14px; line-height: 1.6;"></p>
//                                         </td>
//                                     </tr>
//                                     <tr>
//                                     </tr>
//                                 </table>
//                             </td>
//                         </tr>
//                     </table>
//                 </div><!-- /content -->
//             </td>
//             </tr>
//            <tr>
//             <td  bgcolor="#efefef" style=";max-width: 600px!important;margin: 0 auto!important;clear: both!important;">
//                 <table style="width:100%">
//                     <tr>
//                         <td style="padding:5px;font-size: 14px; text-align: left;"  height="26"  colspan="3" valign="middle"  style="font-family:Arial, Gadget, sans-serif; font-size:10px; color:#000; align:center; font-weight:normal;">Copyrights &copy; ' . date('Y') . '  ' . $companyname . ' All Rights Reserved.&nbsp;</td>
//                     </tr>
//                 </table>
//             </td>
//         </tr>
//         </tbody>
//     </table>
// </div>';

//     sendgridmail($email, $message1, $subject1, $to, '', '');
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="fa fa-check"></i> Thanks for your interest.</h4></div>';

    return $res;
}
function delcontact1($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT * FROM `contact_form` WHERE `coid`=?", $c);
        unlink('../../images/newscategory/' . $getc['image']);
        unlink('../../images/newscategory/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `contact_form` WHERE `coid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
//sendgrid end//





function addprofile($a, $b, $c, $d, $e, $f, $g, $h, $j, $i) {
    global $db;
    if ($i == '') {
        $resa = $db->prepare("INSERT INTO `manageprofile` (`firstname`,`lastname`,`recoveryemail`,`phonenumber`,`Company_name`,`image`,`ip`,`Currency1`) VALUES (?,?,?,?,?,?,?)");
        $resa->execute(array($a, $b, $c, $d, $e, $f, $g, $h, $j, $i));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        //$ress="UPDATE `manageprofile` SET `title`='".$a."',`firstname`='".$b."',`lastname`='".$c."',`recoveryemail`='".$d."',`phonenumber`='".$e."',`Company_name`='".$f."',`image`='".$g."',`ip`='".$h."' WHERE `uid`='".$i."'";
        $resa = $db->prepare("UPDATE `manageprofile` SET `firstname`=?,`lastname`=?,`recoveryemail`=?,`phonenumber`=?,`Company_name`=?,`image`=?,`ip`=? , `Currency1`=?,`caddress`=? WHERE `uid`=?");
        $resa->execute(array($a, $b, $c, $d, $e, $f, $g, $h, $j, $i));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
    }

    return $res;
}

function adduser($a, $b, $c) {
    global $db;
    if ($i == '') {
        $resa = $db->prepare("INSERT INTO `train_user` (`name`,`email`,`ip`) VALUES (?,?,?)");
        $resa->execute(array($a, $b, $c));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
    } else {
        //$ress="UPDATE `manageprofile` SET `title`='".$a."',`firstname`='".$b."',`lastname`='".$c."',`recoveryemail`='".$d."',`phonenumber`='".$e."',`Company_name`='".$f."',`image`='".$g."',`ip`='".$h."' WHERE `uid`='".$i."'";
        $resa = $db->prepare("UPDATE `manageprofile` SET `title`=?,`firstname`=?,`lastname`=?,`recoveryemail`=?,`phonenumber`=?,`Company_name`=?,`image`=?,`ip`=? , `Currency1`=?,`caddress`=? WHERE `uid`=?");
        $resa->execute(array($a, $b, $c, $d, $e, $f, $g, $h, $j, $y, $i));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
    }

    return $res;
}

function getprofile($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `manageprofile` WHERE `pid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function words($ammt) {
    $number = $ammt;
    $no = round($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'one', '2' => 'two',
        '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
        '7' => 'seven', '8' => 'eight', '9' => 'nine',
        '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
        '13' => 'thirteen', '14' => 'fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? ucfirst($words[$number]) .
                    " " . $digits[$counter] . $plural . " " . $hundred :
                    ucfirst($words[floor($number / 10) * 10])
                    . " " . ucfirst($words[$number % 10]) . " "
                    . ucfirst($digits[$counter]) . $plural . " " . $hundred;
        } else
            $str[] = null;
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    if ($point < 19) {
        $points = ($point) ? " " . ucfirst($words[$point]) : '';
    } else {
        $points = ($point) ? " " . ucfirst($words[floor($point / 10) * 10]) . " " . ucfirst($words[$point = $point % 10]) : '';
    }

    $res .= $result . "";
    if ($points != '') {
        $res .= " and " . $points . ' Paisa Only';
    } else {
        $res .= ' Only';
    }
    return $res;
}

function compress_image($destination_url, $quality) {

    $info = getimagesize($destination_url);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($destination_url);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($destination_url);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($destination_url);

    imagejpeg($image, $destination_url, $quality);
    return $destination_url;
}

function show_toast($type, $msg) {
    return '
    <script id="thissc">
        window.onload = function(){
            toastr.' . $type . '("' . $msg . '");
                $("#thissc").remove();
        }
        
    </script>';
}

function getguest($a = '', $b = '') {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `guest` WHERE `id`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function getTable($table, $auto_id, $id) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `$table` WHERE `$auto_id`=?");
    $get1->execute(array($id));
    $get = $get1->fetch();
    return $get;
}

function getValue($table, $auto_id, $id, $field) {
    global $db;
    $get1 = FETCH_all("SELECT * FROM `$table` WHERE `$auto_id`=?",$id);
    $get = $get1[$field];
    return $get;
}

?>
