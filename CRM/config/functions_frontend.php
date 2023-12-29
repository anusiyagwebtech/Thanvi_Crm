<?php

function addsubscribe($newsletter, $ip) {
    global $db;

    $chk = FETCH_all("SELECT `email` FROM `newsletter` WHERE `email`=?", $newsletter);
    if ($chk['email'] == '') {
        $resa = $db->prepare("INSERT INTO `newsletter` (`email`,`ip`) VALUES(?,?)");
        $resa->execute(array($newsletter, $ip));
        $res = '<div class="alert alert-success alert-dismissible"> Subscribed Successfully </h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"> Already Subscribed</h4></div>';
    }
    return $res;
}

function checklogin($loginemail, $logpassword, $ip, $url) {
    global $db;
//$ress="SELECT `CusID`,`Status`,`Password` FROM `customer` WHERE `E-mail`='".$loginemail."'";
    $chk = FETCH_all("SELECT `CusID`,`Status`,`Password` FROM `customer` WHERE `E-mail`=?", $loginemail);
    $pass = md5($logpassword);
    if ($chk['Status'] == '1') {
        if ($chk['Password'] == $pass) {
            $_SESSION['FUID'] = $chk['CusID'];
            $stmt1 = pFETCH('INSERT INTO `cus_history` (`CusID`,`Logintime`,`Loginvia`,`IP`) VALUES (?,?,?,?)', $chk['CusID'], date('Y-m-d H:i:s'), $_SERVER['HTTP_USER_AGENT'], $ip);
            $res = 'sucess';
            if ($_SESSION['GUEST_ID'] != '') {
                $ds = $db->prepare("DELETE FROM `guest` WHERE `id`=?");
                $ds->execute(array($_SESSION['GUEST_ID']));
                $ds = $db->prepare("DELETE FROM `bill_ship_address` WHERE `Guest_ID`=?");
                $ds->execute(array($_SESSION['GUEST_ID']));
            }
            header("location:" . $url);
            exit;
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Login details are incorrect</h4></div>';
        }
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Your Account was Deactivated.. Please Contact <a href="https://www.everestgifts.com.au/pages/contact-us.htm">Admin</a></h4></div>';
    }
    return $res;
}


function signupp($fname, $lname, $signupemail, $signuppassword, $ip) {
    global $db;
    global $fsitename;

    $chk2 = FETCH_all("SELECT `CusID` FROM `customer` WHERE `E-mail`=? AND `Status`=?", $signupemail, '1');

    if (($chk['CusID'] == '') && ($chk['E-mail'] == '')) {
        $chk = $db->prepare("INSERT INTO `customer` (`FirstName`,`LastName`,`E-mail`,`Password`,`IP`,`Status`) VALUES (?,?,?,?,?,?)");
        $chk->execute(array($fname, $lname, $signupemail, md5($signuppassword), $ip, '1'));

        $_SESSION['FUID'] = $db->lastInsertId();
       
        $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
        $to = $general['recoveryemail'];
        $subject = "New User Registered - Adarsh";
        $message = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/' . $general['image'] . '" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New User Registered - Adarsh</span>
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello Admin,
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Name :</td>
                        <td style="padding:5px;" colspan="2">' . $fname . ' ' . $lname . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Email :</td>
                        <td style="padding:5px;" colspan="2">' . $signupemail . '</td>
                    </tr>
                  
                    <tr>
                        <td style="padding:5px;" colspan="3">New user has been registered to our site today .Please provide proper services to our most valueable customer  .</td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Adarsh All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

        sendgridmail($to, $message, $subject, $signupemail, '', '');

        $to1 = $signupemail;
        $subject1 = "Thanks for Register with Adarsh";

        $message1 = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/' . $general['image'] . '" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New User Registered - info@adarshsolutions.com</span>
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello ' . $fname . '  ' . $lname . ',
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;" colspan="3">Thank you for Register with us</td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Adarsh All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';
        sendgridmail($to1, $message1, $subject1, $general['recoveryemail'], '', '');
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Registered Successfully </h4></div>';
    } else {
        if (($chk['E-mail'] == $signupemail) && ($chk['Mobile'] == $mobileno)) {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> E-mail Address And Mobile Number Already Exist</h4></div>';
        } elseif ($chk['Mobile'] == $mobileno) {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Mobile Number Already Exist</h4></div>';
        } elseif ($chk['E-mail'] == $signupemail) {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> E-mail Address Already Exist</h4></div>';
		}
	}
    return $res;
}


function getcustomerlog($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `cus_history` WHERE `CusID`= ?  ORDER BY `Chid` DESC");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}

function getcus($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `customer` WHERE `CusID`= ?  ORDER BY `CusID` ASC");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}

function uploadprofile($fname, $lname, $signupemail, $mobileno, $image,$message,$jobcode, $ip, $id) {
    global $db;
	global $fsitename;
    if ($id != '') {   
		// echo "UPDATE `customer` SET `FirstName`=$fname,`LastName` =$lname, `E-mail`=$signupemail, `Mobile`=$mobileno, `Image`=$fileselect, `Message`=$message,`IP`=$ip,`Updated_type`=2  WHERE `CusID`= ?";
		// exit;
        $ress = $db->prepare("UPDATE `customer` SET `FirstName`=?,`LastName` =?, `E-mail`=?, `Mobile`=?, `Image`=?, `Message`=?,`jobcode`=?,`IP`=?,`Updated_type`=?  WHERE `CusID`= ?");
        $ress->execute(array($fname, $lname, $signupemail, $mobileno, $image,$message,$jobcode, $ip, '2', $id));
        
		$jobname1 = FETCH_all("SELECT * FROM `careers` WHERE `jobcode` = ?", $jobcode);
        $jobname = $jobname1['title'];
		
        $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
        $to = $general['recoveryemail'];
        
		$resume_path = realpath("images/resume/" . $image);
		
		// echo 'hjfghj'.$resume_path;
		// exit;
		
		$subject = "New profile for " . $jobname;
        $message = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
						<thead>
							<th style="width:20%;">
								<img src="http://www.adarshsolutions.com/images/logo.jpg" height="50px" border="0" />
							</th>
							<th  style="width:80%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
								<span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New Canditate Details</span>
							</th>
						</thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello Admin,
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Name :</td>
                        <td style="padding:5px;" colspan="2">' . $fname . ' ' . $lname . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Email :</td>
                        <td style="padding:5px;" colspan="2">' . $signupemail . '</td>
                    </tr>
					<tr>
                        <td style="padding:5px;vertical-align: top;" >Mobile Number :</td>
                        <td style="padding:5px;" colspan="2">' . $mobileno . '</td>
                    </tr>
					<tr>
                        <td style="padding:5px;vertical-align: top;" >Job Code :</td>
                        <td style="padding:5px;" colspan="2">' . $jobcode . '</td>
                    </tr>
					<tr>
                        <td style="padding:5px;vertical-align: top;" >Resume :</td>
                        <td style="padding:5px;" colspan="2">' . $image . ' </td>
                    </tr>
					<tr>
                        <td style="padding:5px;vertical-align: top;" >Message :</td>
                        <td style="padding:5px;" colspan="2">' . $message . '</td>
                    </tr>
                  
                    <tr>
                        <td style="padding:5px;" colspan="3">New Canditate apply the job registered to our site today .Please provide proper services to our most valueable canditate  .</td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Adarsh All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

        sendgridmail2($to, $message, $subject, $signupemail, $resume_path, $fname.'.'.pathinfo($image,PATHINFO_EXTENSION));

        $to1 = $signupemail;
        $subject1 = "Thanks for your apply with Adarsh Solutions";

        $message1 = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:20%;">
                    <img src="http://www.adarshsolutions.com/images/logo.jpg" height="50px" border="0" />
                    </th>
                    <th  style="width:80%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">Thank you New Canditate </span>
                    </th>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello ' . $fname . '  ' . $lname . ',
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
                    <tr>
                        <td style="padding:5px;" colspan="3">Thank you for Register with us</td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Adarsh All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';
        sendgridmail($to1, $message1, $subject1, $general['recoveryemail'], '', '');

		
		$res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Uploaded</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Please Login Again to Upload...</h4></div>';
    }
    return $res;
}


function getcustomer($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `customer` WHERE `CusID`= ? ");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}

function getguest1($a, $b) {
    global $db;
    $res = $db->prepare("SELECT * FROM `guest` WHERE `id`= ? ");
    $res->execute(array($b));
    $res = $res->fetch();
    return $res[$a];
}

?>