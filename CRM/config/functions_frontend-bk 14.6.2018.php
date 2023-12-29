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


function signupp($fname, $mname, $lname, $address1, $address2, $city, $state, $zipcode, $country, $mobileno, $phoneno, $signupemail, $signuppassword, $newssubscribe, $ip) {
    global $db;
    global $fsitename;

    $chk2 = FETCH_all("SELECT `CusID` FROM `customer` WHERE `E-mail`=? AND `Status`=?", $signupemail, '1');

    if (($chk['CusID'] == '') && ($chk['E-mail'] == '') && ($chk['Mobile'] == '')) {
        $chk = $db->prepare("INSERT INTO `customer` (`FirstName`,`MiddleName`,`LastName`,`Adderss_1`,`Address_2`,`City`,`State`,`Postcode`,`Country`,`Mobile`,`Phone`,`E-mail`,`Password`,`IP`,`Status`,`signupvia`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $chk->execute(array($fname, $mname, $lname, $address1, $address2, $city, $state, $zipcode, $country, $mobileno, $phoneno, $signupemail, md5($signuppassword), $ip, '1', $_SERVER['HTTP_USER_AGENT']));

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
                    <span style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New User Registered - Click2buy.in</span>
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
    if ($id != '') {   
		// echo "UPDATE `customer` SET `FirstName`=$fname,`LastName` =$lname, `E-mail`=$signupemail, `Mobile`=$mobileno, `Image`=$fileselect, `Message`=$message,`IP`=$ip,`Updated_type`=2  WHERE `CusID`= ?";
		// exit;
        $ress = $db->prepare("UPDATE `customer` SET `FirstName`=?,`LastName` =?, `E-mail`=?, `Mobile`=?, `Image`=?, `Message`=?,`jobcode`=?,`IP`=?,`Updated_type`=?  WHERE `CusID`= ?");
        $ress->execute(array($fname, $lname, $signupemail, $mobileno, $image,$message,$jobcode, $ip, '2', $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Uploaded</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Please Login Again to Upload...</h4></div>';
    }
    return $res;
}


function changepassword($newpassword, $ip, $id) {
    global $db;
    $pass = md5($newpassword);
    $ress = pFETCH("UPDATE `customer` SET `Password`=? WHERE `CusID`=?", $pass, $id);
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
    return $res;
}

function changepassword1($loginemail, $ip) {
    global $db;
    $rand = mt_rand(100000, 999999);

    $ress = pFETCH("UPDATE `customer` SET `otp`=? WHERE `E-mail`=?", $rand, $loginemail);

    $cus = FETCH_all("SELECT * FROM `customer` WHERE `E-mail`=?", $loginemail);

    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');

    $from = $general['recoveryemail'];

    $subject = "Reset Password - Everest Gifts";

    $message = '<table style="width:100%;height:100%">
            <tbody>
                <tr>
                    <td align="center" valign="middle">
                        <table style="border-top:10px solid #006db7;border-bottom:10px solid #006db7;background:#f3f3f3;font-family:sans-serif;font-size:12px" width="600" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td align="left" valign="top" colspan="3">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="10" bgcolor="#FFFFFF">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" align="center" valign="top" bgcolor="#FFFFFF" width="50%">
                                                        <h1>EVEREST GIFTS </h1>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px" colspan="3">
                                        <h4>Hi ' . $cus['FirstName'] . ',</h4>
                                        <p>if you did not made this request then Please contact admin.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px" colspan="3">
                                        Click the link to change the Password : <a href="https://www.everestgifts.com.au/' . $rand . '/' . base64_encode($loginemail) . '/resetpassword.htm" target="_blank">Reset Password</a>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td bgcolor="#a0cc0e" colspan="3" style="color:#000000; padding:30px 10px; text-align:center;">FROM Everest Gifts</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>';

    sendoldmail($subject, $message, $from, $loginemail);

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Reset Password Link sent to your mail</h4></div>';

    return $res;
}

function updateaddress($myfirstname, $mylastname, $myemail, $mymobile, $myaddress1, $myaddress2, $mycity, $mypostcode, $mystate, $mycountry, $sfirstname, $slastname, $semail, $smobile, $saddress1, $saddress2, $scity, $spostcode, $sstate, $scountry, $ip, $id) {
    global $db;
    if ($id != '') {
        $ress = $db->prepare("UPDATE `bill_ship_address` SET `bfirstname`=?,`blastname` =?, `bemail`=?, `bphone`=?, `baddress1`=?,`baddress2`=?,`bcity`=?,`bstate`=?,`bcountry`=?,`bpostcode`=?,`sfirstname`=?,`slastname`=?,`semail`=?,`sphone`=?,`saddress1`=?,`saddress2`=?,`scity`=?,`sstate`=?,`scountry`=?,`spostcode`=?  WHERE `CusID`= ?");
        $ress->execute(array($myfirstname, $mylastname, $myemail, $mymobile, $myaddress1, $myaddress2, $mycity, $mystate, $mycountry, $mypostcode, $sfirstname, $slastname, $semail, $smobile, $saddress1, $saddress2, $scity, $sstate, $scountry, $spostcode, $id));
        $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i> Successfully Updated</h4></div>';
    } else {
        $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Please Login Again to Update...</h4></div>';
    }
    return $res;
}

function mailcart($orderid) {
    global $db;
    if ($orderid != '') {
        $res = '<table style="width:100%; font-size:13px;" cellpadding="5">
                            <thead>
                                <tr style="background:#cc6600; color:#FFF;">
                                    <th style="width:40%; text-align:left;">Item Name</th>
                                    <th style="width:15%; text-align:left;">SKU</th>
                                    <th style="width:15%; text-align:left;">Unit Price</th>
                                    <th style="width:15%; text-align:left;">Qty</th>
                                    <th style="width:15%; text-align:left;">Total Price</th>
                                </tr>
                            </thead><tbody>';
        $ooor = pFETCH("SELECT * FROM `order` WHERE `Order_id`=?", $orderid);
        while ($foo = $ooor->fetch(PDO::FETCH_ASSOC)) {
            $res .= '<tr>
                <td>' . stripslashes($foo['product_name']) . '</td>
                <td>' . stripslashes($foo['product_code']) . '</td>
                <td align="right">' . number_format($foo['product_price'], '2', '.', '') . '</td>
                <td align="center">' . $foo['product_qty'] . '</td>
                <td align="right">' . number_format($foo['product_total_price'], '2', '.', '') . '</td>
            </tr>';
        }
        $res .= '<tr>
                                    <td colspan="5">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>';
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

function addtestimonial($name, $email, $phone, $comment, $ip) {
    global $db;

    $resa = $db->prepare("INSERT INTO `testimonial` ( `title`, `comments`,`email`,`phoneno`,`ip`, `updated_by` ) VALUES(?,?,?,?,?,?)");

    //$resa = $db->prepare("INSERT INTO `testimonial` ( `title`=?, `comments`=?,`order`=?,`status`=?,`ip`=?, `Updated_by`=? );
    $resa->execute(array($name, $comment, $email, $phone, $ip, $_SESSION['UID']));

    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');

    $to = $general['recoveryemail'];

    $subject = "Your New Testimonial From  " . $name;

    $message = '<table style="height:100%; width:100%">
	<tbody>
		<tr>
			<td>
			<table border="0" cellpadding="0" cellspacing="0" style="width:600px">
				<tbody>
					<tr>
						<td colspan="3">
						<table border="0" cellpadding="10" cellspacing="0" style="width:100%">
							<tbody>
								<tr>
									<td colspan="2">
									<h1>EVEREST GIFTS</h1>
									</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td colspan="3">
						<p>Hello Admin,</p>

						<p>You have a New Testimonial</p>
						</td>
					</tr>
					<tr>
						<td>Name :</td>
						<td colspan="2">' . $name . '</td>
					</tr>
					<tr>
						<td>Email :</td>
						<td colspan="2">' . $email . '</td>
					</tr>
					
					<tr>
						<td>Contact Number :</td>
						<td colspan="2">' . $phone . '</td>
					</tr>
					<tr>
						<td>Message :</td>
						<td colspan="2">' . $comment . '</td>
					</tr>
					<tr>
						<td colspan="3" style="text-align:center">FROM Everest Gifts</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>
';

    sendoldmail($subject, $message, $email, $to);

    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="fa fa-check"></i> Successfully Inserted</h4></div>';

    return $res;
}

?>