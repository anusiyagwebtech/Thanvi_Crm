<?php

function getblogcategory($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `blogcategory` WHERE `bcid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addblogcategory($title, $link, $image, $imagealt, $imagename, $content, $meta_title, $meta_keywords, $meta_description, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `bcid` FROM `blogcategory` WHERE `image_name`=?", $imagename);
        if ($link1['bcid'] == '') {
            $link2 = FETCH_all("SELECT `bcid` FROM `blogcategory` WHERE `link`=?", $link);
            if ($link2['bcid'] == '') {
                $resa = $db->prepare("INSERT INTO `blogcategory`(`category`,`link`,`description`,`image_alt`,`image_name`,`image`,`order`,`status`,`meta_title`,`meta_keywords`,`meta_description`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($title, $link, $content, $imagealt, $imagename, $image, $order, $status, $meta_title, $meta_keywords, $meta_description, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `bcid` FROM `blogcategory` WHERE `image_name`=? AND `bcid`!=?", $imagename, $getid);
        if ($link1['bcid'] == '') {
            $link2 = FETCH_all("SELECT `bcid` FROM `blogcategory` WHERE `link`=? AND `bcid`!=?", $link, $getid);
            if ($link2['bcid'] == '') {
                $resa = $db->prepare("UPDATE `blogcategory` SET `category`=?, `link`=?,`description`=?, `image`=?,`image_alt`=?,`image_name`=?,`order`=?, `status`=?, `meta_title`=?, `meta_keywords`=?, `meta_description`=?, `ip`=?, `updated_by`=? WHERE `bcid`=?");
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

function delblogcategory($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `blogcategory` WHERE `bcid`=?", $c);
        unlink('../../images/blogcategory/' . $getc['image']);
        unlink('../../images/blogcategory/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `blogcategory` WHERE `bcid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}

function getblog($a, $b) {
    global $db;
    $get1 = $db->prepare("SELECT * FROM `blog` WHERE `bid`=?");
    $get1->execute(array($b));
    $get = $get1->fetch(PDO::FETCH_ASSOC);
    $res = $get[$a];
    return $res;
}

function addblog($category, $title, $link, $image, $imagealt, $imagename, $content, $meta_title, $meta_keywords, $meta_description, $order, $status, $ip, $getid) {
    global $db;
    if ($getid == '') {
        $link1 = FETCH_all("SELECT `bid` FROM `blog` WHERE `image_name`=?", $imagename);
        if ($link1['bcid'] == '') {
            $link2 = FETCH_all("SELECT `bid` FROM `blog` WHERE `link`=?", $link);
            if ($link2['bcid'] == '') {
                $resa = $db->prepare("INSERT INTO `blog`(`category`,`title`,`link`,`description`,`image_alt`,`image_name`,`image`,`order`,`status`,`meta_title`,`meta_keywords`,`meta_description`,`ip`,`updated_by`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $resa->execute(array($category, $title, $link, $content, $imagealt, $imagename, $image, $order, $status, $meta_title, $meta_keywords, $meta_description, $ip, $_SESSION['UID']));
                $res = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-check"></i>Successfully Inserted</h4></div>';
            } else {
                $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Link already exists!</h4></div>';
            }
        } else {
            $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i>Image Name already exists!</h4></div>';
        }
    } else {
        $link1 = FETCH_all("SELECT `bid` FROM `blog` WHERE `image_name`=? AND `bid`!=?", $imagename, $getid);
        if ($link1['bid'] == '') {
            $link2 = FETCH_all("SELECT `bid` FROM `blog` WHERE `link`=? AND `bid`!=?", $link, $getid);
            if ($link2['bid'] == '') {
                $resa = $db->prepare("UPDATE `blog` SET `category`=?, `title`=?, `link`=?,`description`=?, `image`=?,`image_alt`=?,`image_name`=?,`order`=?, `status`=?, `meta_title`=?, `meta_keywords`=?, `meta_description`=?, `ip`=?, `updated_by`=? WHERE `bid`=?");
                $resa->execute(array(trim($category), trim($title), trim($link), trim($content), trim($image), trim($imagealt), trim($imagename), trim($order), trim($status), trim($meta_title), trim($meta_keywords), trim($meta_description), trim($ip), $_SESSION['UID'], $getid));

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

function delblog($a) {
    $b = str_replace(".", ",", $a);
    $b = explode(",", $b);
    foreach ($b as $c) {
        global $db;
        $getc = FETCH_all("SELECT `image` FROM `blog` WHERE `bid`=?", $c);
        unlink('../../images/blog/' . $getc['image']);
        unlink('../../images/blog/thump/' . $getc['image']);
        $get = $db->prepare("DELETE FROM `blog` WHERE `bid` = ? ");
        $get->execute(array($c));
    }
    $res = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button><h4><i class="icon fa fa-close"></i> Successfully Deleted!</h4></div>';
    return $res;
}
?>
