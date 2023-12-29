<?php

function getstaticpages($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `static_pages` WHERE `stid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}


function getcareerform($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `customer` WHERE `CusID`=?");
    $get1->execute(array(trim($b)));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}





function addcontact($service, $fname, $lname,$designation, $company, $place, $email, $phone,$subject, $message, $ip) {
    global $db;
    global $fsitename;
    $resa = $db->prepare("INSERT INTO `contact_form` (`service`,`firstname`,`lastname`, `designation`,`company`,`place`,`emailid`,`phoneno`,`subject`,`comments`,`ip`) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
    $resa->execute(array($service, $fname, $lname,$designation, $company, $place, $email, $phone,$subject, $message, $ip));
    $general = FETCH_all("SELECT * FROM `manageprofile` WHERE `pid` = ?", '1');
    $to = $general['recoveryemail'];
    $subject1 = "Contact From  " . $fname;

    $message = '<table width="600" border="0" cellspacing="0" cellpadding="0" style="vertical-align: top;border:5px solid #000000; background:#fff">
                    <thead>
                    <th style="width:30%;">
                    <img src="' . $fsitename . 'images/logo.jpg' .'" height="50px" border="0" />
                    </th>
                    <th  style="width:70%;font-family:Arial, Helvetica, sans-serif; color:#000; vertical-align: bottom; font-weight:bold; font-size:15px;">
                    <span style="font-famil:Arial, Helvetica, sans-serif; font-size:20px; color:#000; font-weight:bold;">New User Contact detail</span>
                    </th>
                    </thead>
                    
                    <tbody>
                    <tr>
                        <td align="left" valign="top" colspan="3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" style="padding:5px;" colspan="3">
                            Hello Admin,<br /><br /> You have a Contact<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr> 
					 <tr>
                        <td style="padding:5px;vertical-align: top;" >Service :</td>
                        <td style="padding:5px;" colspan="2">' . $service . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >First Name :</td>
                        <td style="padding:5px;" colspan="2">' . $fname . '</td>
                    </tr>
					<tr>
                        <td style="padding:5px;vertical-align: top;" >Last Name :</td>
                        <td style="padding:5px;" colspan="2">' . $lname . '</td>
                    </tr>
					<tr>
                        <td style="padding:5px;vertical-align: top;" >Designation :</td>
                        <td style="padding:5px;" colspan="2">' . $designation . '</td>
                    </tr>
					<tr>
                        <td style="padding:5px;vertical-align: top;" >Company :</td>
                        <td style="padding:5px;" colspan="2">' . $company . '</td>
                    </tr>
					<tr>
                        <td style="padding:5px;vertical-align: top;" >Place :</td>
                        <td style="padding:5px;" colspan="2">' . $place . '</td>
                    </tr>
					<tr>
                        <td style="padding:5px;vertical-align: top;" >Email :</td>
                        <td style="padding:5px;" colspan="2">' . $email . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Phone :</td>
                        <td style="padding:5px;" colspan="2">' . $phone . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Subject :</td>
                        <td style="padding:5px;" colspan="2">' . $subject . '</td>
                    </tr>
                    <tr>
                        <td style="padding:5px;vertical-align: top;" >Message :</td>
                        <td style="padding:5px;" colspan="2">' . $message . '</td>
                    </tr>
                    <tr>
                        <td style="height:20px;" colspan="3">&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td height="26" colspan="3" align="center" valign="middle" bgcolor="#333333" style="font-family:Arial, Gadget, sans-serif; font-size:10px;    vertical-align: middle; font-weight:normal; color:#fff;">&copy; ' . date('Y') . ' Adarsh All Rights Reserved.&nbsp;</td>
                    </tr>
                    </tbody>
                </table>';

    sendgridmail($to, $message, $subject1, $email, '', '');
    $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="fa fa-check"></i> Submitted Successfully </h4></div>';

    return $res;
}

/* Quotation code end here  */
?>
