<?php
include ('../../config/config.inc.php');

    
?>







































if ($_REQUEST['validdatef'] != '') {
    if (strtotime($_REQUEST['validdatef']) > strtotime($_REQUEST['validdatet'])) {
        $data['value'] = '<p style="color:#ff0000;font-size:15px;">Valid To date should be greater than Valid From date  </p>';
    } else if (strtotime($_REQUEST['validdatef']) < strtotime($_REQUEST['validdatet'])) {

        $data['value'] = 1;
    } else {
        $data['value'] = 1;
    }
    echo json_encode($data);
}

if ($_REQUEST['removevalue'] != '') {
    $xs = $db->prepare("DELETE FROM `attribute_value` WHERE  `vid`= ? ");
    $xs->execute(array($_REQUEST['removevalue']));
}
 