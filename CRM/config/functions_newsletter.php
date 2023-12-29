<?php

function getnewstemplate($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `newstemplate` WHERE `temid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addnewstemplate($title, $subject, $template, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `temid` FROM `newstemplate` WHERE `newsletter_title`=?", $title);
        if ($link1['temid'] == '') {

            $resa = $db->prepare("INSERT INTO `newstemplate` (`newsletter_title`,`subject`,`template`,`status`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?)");
            $resa->execute(array($title, $subject, $template, $status, $ip, $_SESSION['UID']));
            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Title already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `temid` FROM `newstemplate` WHERE `newsletter_title`=? AND `temid`!=?", $title, $getid);
        if ($link1['temid'] == '') {

            $resa = $db->prepare("UPDATE `newstemplate` SET `newsletter_title`=?, `subject`=?,`template`=?, `status`=?,`ip`=?,`updated_by`=? WHERE `temid`=?");
            $resa->execute(array(trim($title), trim($subject), trim($template), trim($status), trim($ip), $_SESSION['UID'], $getid));

            $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button><h4><i class="icon fa fa-check"></i>Successfully Updated</h4></div>';
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Title already exists!</h4></div>';
        }
    }
    return $res;
}

function delnewstemplate($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $get = $db->prepare("DELETE FROM `newstemplate` WHERE `temid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

?>
