<?php
include ('../../config/config.inc.php');
if (isset($_REQUEST['newsid'])) {
    $s = '';
    if (trim($_REQUEST['dfrom']) != '' and trim($_REQUEST['dto']) != '') {
        $s.=" AND DATE_FORMAT(`datetime`,'%Y-%m-%d')  between '" . trim($_REQUEST['dfrom']) . "' and  '" . trim($_REQUEST['dto']) . "'";
    }

    if (trim($_REQUEST['emailsrch']) != '') {
        $s.=" AND `email` LIKE '%" . trim($_REQUEST['emailsrch']) . "%'";
    }

    if ($s != '') {
        $s = substr($s, 4);
        $aek1 = $db->prepare("SELECT * FROM `newsletter` WHERE ?");
        $aek1->execute(array($s));
        $aek=$aek1->fetch();
    }
} else {
    $aek1 =$db->prepare("SELECT * FROM `newsletter`");
    $aek1->execute(array());
    
}

$data2.="Email Address \t Date \t IP \n";

while ($fetchac =$aek1->fetch()) {

    $data2.=$fetchac['email'] . "\t" . date('d-m-Y h:i:s a', strtotime($fetchac['datetime'])) . "\t" . $fetchac['ip'] . "\n";
}

if ($data2 == "") {
    $data2 = "\n(0) Records Found!\n";
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=newsletter.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data2";
?>